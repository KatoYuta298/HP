<?php

// アンケートを登録する
$q_title = "";
$q_explain = "";
$q_item1 = "";
$q_item2 = "";
$q_item3 = "";
$q_item4 = "";
$q_item5 = "";
$action = $_POST["action"];
if (isset($action) and $action == "登録する") {
    $q_title = htmlspecialchars($_POST["q_title"], ENT_QUOTES, "UTF-8");
	$q_explain = htmlspecialchars($_POST["q_explain"], ENT_QUOTES, "UTF-8");
	$q_item1 = htmlspecialchars($_POST["q_item1"], ENT_QUOTES, "UTF-8");
	$q_item2 = htmlspecialchars($_POST["q_item2"], ENT_QUOTES, "UTF-8");
	$q_item3 = htmlspecialchars($_POST["q_item3"], ENT_QUOTES, "UTF-8");
	$q_item4 = htmlspecialchars($_POST["q_item4"], ENT_QUOTES, "UTF-8");
	$q_item5 = htmlspecialchars($_POST["q_item5"], ENT_QUOTES, "UTF-8");
	
    // アンケート名が入力されたか調べて処理を分岐
    if (!empty($q_title)) {
		
		// SQLに接続
		$link = mysqli_connect('localhost', 'xxxxx', 'xxxxxx');
		
		if (!$link) {
	    die('接続失敗です。'.mysql_error());
		}
	}else{
	 header("Location: warning.php");
	}
	if (!$link) {
	    die('connect_fail'.mysql_error());
	}
	
	
	$db_selected = mysqli_select_db($link, '28thquestionnair');
	if (!$db_selected){
	    die('selected failed'.mysql_error());
	}
	echo ('ok');
	$temptitle = mb_convert_encoding($q_title,"sjis");
	$tempuser = mb_convert_encoding($_POST["selectBoxName"],"sjis");
	$temptext = mb_convert_encoding($q_explain, "sjis");
	$tempitem1 = mb_convert_encoding($q_item1,  "sjis");
	$tempitem2 = mb_convert_encoding($q_item2,  "sjis");
	$tempitem3 = mb_convert_encoding($q_item3,  "sjis");
	$tempitem4 = mb_convert_encoding($q_item4,  "sjis");
	$tempitem5 = mb_convert_encoding($q_item5,  "sjis");
	
	
	$result_temp = mysqli_query($link,'INSERT INTO questionnair (title,name,text,item1,item2,item3,item4,item5) VALUES ("'.$temptitle.'","'.$tempuser.'","'.$temptext.'","'.$tempitem1.'","'.$tempitem2.'","'.$tempitem3.'","'.$tempitem4.'","'.$tempitem5.'")');
			if(!$result_temp){
				die('Quely failed'.mysql_error());
			}
	mysqli_close($link);
	
     }else {
        
    }
	
    header("Location: kanryo.php");
?>