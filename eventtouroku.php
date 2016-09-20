<?php

// スケジュールを更新する
$schedule = "";
$action = $_POST["action"];
if (isset($action) and $action == "登録する") {
    $schedule = htmlspecialchars($_POST["schedule"], ENT_QUOTES, "UTF-8");
	
    // スケジュールが入力されたか調べて処理を分岐
    if (!empty($schedule)) {
        // 入力された内容でスケジュールを更新
        //file_put_contents($file_name, $schedule);
		
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
	
	
	$db_selected = mysqli_select_db($link, '28thevent');
	if (!$db_selected){
	    die('selected failed'.mysql_error());
	}
	echo ('ok');
	$tempname = mb_convert_encoding($schedule,"sjis");
	$tempuser = mb_convert_encoding($_POST["selectBoxName"],"sjis");
	$tempyear  = $_POST["y"];
	$tempmonth = $_POST["m"];
	$tempdate  = $_POST["d"];
	$tempyear2  = $_POST["y2"];
	$tempmonth2 = $_POST["m2"];
	$tempdate2  = $_POST["d2"];
	
	$result_temp = mysqli_query($link,'INSERT INTO event (name,user, fyear,fmonth,fdate, lyear, lmonth, ldate) VALUES ("'.$tempname.'","'.$tempuser.'","'.$tempyear.'","'.$tempmonth.'","'.$tempdate.'","'.$tempyear2.'","'.$tempmonth2.'","'.$tempdate2.'")');
			if(!$result_temp){
				die('Quely failed'.mysql_error());
			}
	mysqli_close($link);
	
     }else {
        
    }
	
    header("Location: kanryo.php");
?>