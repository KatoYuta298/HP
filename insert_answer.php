<?php

// 回答結果を保存
$num = 0;
$ID = 0;
$r_item1 = "";
$r_item2 = "";
$r_item3 = "";
$r_item4 = "";
$r_item5 = "";
$answer_count = 0;
$action = $_POST["action"];
if (isset($action) and $action == "送信") {
    $num = $_GET["num"];
	$answer_count = $_GET["count"];
	$r_item1 = htmlspecialchars($_POST["selectBoxResult0"], ENT_QUOTES, "UTF-8");
	$r_item2 = htmlspecialchars($_POST["selectBoxResult1"], ENT_QUOTES, "UTF-8");
	$r_item3 = htmlspecialchars($_POST["selectBoxResult2"], ENT_QUOTES, "UTF-8");
	$r_item4 = htmlspecialchars($_POST["selectBoxResult3"], ENT_QUOTES, "UTF-8");
	$r_item5 = htmlspecialchars($_POST["selectBoxResult4"], ENT_QUOTES, "UTF-8");
	
	if($answer_count == 0){
		header("Location: warning.php");
	}
	
	// SQLに接続
	$link = mysqli_connect('localhost', 'xxxxx', 'xxxxxx');
	if (!$link) {
	    die('connect_fail'.mysql_error());
	}

	//名前からIDを引く
	$tempuser = mb_convert_encoding($_POST["selectBoxName"],"sjis");
	$db_selected = mysqli_select_db($link, 'okinawa');
	if (!$db_selected){
	    die('selected failed'.mysql_error());
	}
	
	$ID_result = mysqli_query($link,'SELECT ID from member WHERE name="'.$tempuser.'"');
	
	if (!$ID_result) {
	    die('クエリーが失敗しました。'.mysql_error());
	}
	$id_temp_result = mysqli_fetch_assoc($ID_result);

	$ID = $id_temp_result['ID'];
	
	//回答を挿入または更新
	$db_selected = mysqli_select_db($link, '28thquestionnair');
	if (!$db_selected){
	    die('selected failed'.mysql_error());
	}
	$tempitem1 = 0;
	$tempitem2 = 0;
	$tempitem3 = 0;
	$tempitem4 = 0;
	$tempitem5 = 0;
	for($i=0;$i<$answer_count;$i++){
		$i_name = $i+1;
		switch(${'r_item'.$i_name}){
			case "○":
			${'tempitem'.$i_name} = 1;
			break;
			case "△":
			${'tempitem'.$i_name} = 2;
			break;
			case "✖":
			${'tempitem'.$i_name} = 3;
			break;
			default:
			${'tempitem'.$i_name} = 0;
			break;
		}
	}
	
	$result = mysqli_query($link,'SELECT * from q_result WHERE number = "'.$num.'" AND nameID = "'.$ID.'";');
	
	if(!$result){
		die('Quely failed'.mysql_error());
	}else{	
		if($result->num_rows > 0){
			$result_temp = mysqli_query($link,'UPDATE q_result SET result1= "'.$tempitem1.'",result2= "'.$tempitem2.'",result3= "'.$tempitem3.'",result4= "'.$tempitem4.'",result5= "'.$tempitem5.'" WHERE number = "'.$num.'" AND nameID = "'.$ID.'";');
			if(!$result_temp){
				die('UPDATE Quely failed'.mysql_error());
			}
		}else{
			$result_temp = mysqli_query($link,'INSERT INTO q_result (number,nameID,result1,result2,result3,result4,result5) VALUES ("'.$num.'","'.$ID.'","'.$tempitem1.'","'.$tempitem2.'","'.$tempitem3.'","'.$tempitem4.'","'.$tempitem5.'");');
			if(!$result_temp){
				$message = 'INSERT Quely failed'.mysql_error();
				die($message);
			}
		}
	}
	mysqli_close($link);
	
     }else {
        
    }
	
    header("Location: kanryo.php");
?>