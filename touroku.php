<?php



// スケジュールを更新する
$schedule = "";
        //file_put_contents($file_name, $schedule);
		
		// SQLに接続
		$link = mysqli_connect('localhost', 'xxxxx', 'xxxxxx');
		
	if (!$link) {
	    die('connect_fail'.mysql_error());
	}
	
	
	$db_selected = mysqli_select_db($link, '28thevent');
	if (!$db_selected){
	    die('selected failed'.mysql_error());
	}
	$id = $_GET["id"];
	$tempuser = mb_convert_encoding($_POST["selectBoxName"],"sjis");
	$tempyear  = $_POST["year"];
	$tempmonth = $_POST["month"];
	$tempdate  = $_POST["date"];
	
	$time = date("Y-m-d", mktime(0,0,0,$tempmonth,$tempdate,$tempyear));
	
	$result_temp = mysqli_query($link,'INSERT INTO schedule (id,user, time) VALUES ("'.$id.'","'.$tempuser.'","'.$time.'")');
			if(!$result_temp){
				die('Quely failed'.mysql_error());
			}
	mysqli_close($link);
	
    header("Location: kanryo.php");
?>