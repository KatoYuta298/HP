<?php
// 年月日を取得する
/*
if (isset($_GET["ymd"])) {
    // スケジュールの年月日を取得する
    $ymd = basename($_GET["ymd"]);
    $y = intval(substr($ymd, 0, 4));
    $m = intval(substr($ymd, 4, 2));
    $d = intval(substr($ymd, 6, 2));
    $disp_ymd = "{$y}年{$m}月{$d}日のスケジュール";

    // スケジュールデータを取得する
    $file_name = "data/{$ymd}.txt";
    if (file_exists($file_name)) {
        $schedule = file_get_contents($file_name);
    } else {
        $schedule = "";
    }
} else {
    // カレンダー画面に強制移動する
    header("Location: calendar.php");
}
*/
// スケジュールを更新する
$schedule = "";

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport"
	content="width=320,
		height=480,
		initial-scale=1.0,
		minimum-scale=1.0,
		maximum-scale=2.0,
		user-scalable=yes" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>スケジュール帳</title>
</head>
<body>
<h1>イベント登録</h1>
<form method="POST" action="eventtouroku.php">
 あなたは誰？ 
 <table>	
  <?php
	$link = mysqli_connect('localhost', 'xxxxx', 'xxxxxx');
	if (!$link) {
	    die('接続失敗です。'.mysql_error());
	}
	
	$db_selected = mysqli_select_db($link, 'okinawa');
	if (!$db_selected){
	    die('データベース選択失敗です。'.mysql_error());
	}
	
	$result = mysqli_query($link,'SELECT name FROM member;');
	if (!$result) {
	    die('クエリーが失敗しました。'.mysql_error());
	}
	
	
	while($temp = mysqli_fetch_assoc($result)){
	    static $i = 0;
	    $array[$i] = mb_convert_encoding($temp['name'], "UTF-8","sjis");		
	    $i++;
	}

	$sampleSelectBox = "<select name=\"selectBoxName\">\n";
	for ( $i = 0; $i < count( $array ); $i++ ) {
 	$sampleSelectBox .= "\t<option value=\"{$array[$i]}\">{$array[$i]}</option>\n";
	}
	$sampleSelectBox .= "</select>\n";
	echo "{$sampleSelectBox}";
	mysqli_close($link);
	?>

    <tr>
      <td>イベント名</td>
    </tr>
    <tr>
      <td>
      <textarea rows="1" cols="40" name="schedule"><?php echo $schedule; ?></textarea>
      </td>
    </tr>
    <tr>
	  <td></td>
	</tr>
	<tr>
      <td>開催希望日</td>
    </tr>
    <tr>
      <td>
	  <?php
		date_default_timezone_set('UTC');
		if (isset($_POST["y"])) {
			// 選択された年月を取得する
			$y = intval($_POST["y"]);
			$m = intval($_POST["m"]);
		} else {
			// 現在の年月を取得する
			$ym_now = date("Ym");
			$y = substr($ym_now, 0, 4);
			$m = substr($ym_now, 4, 2);
		}

		// 年月選択リストを表示する
		echo "<form method='POST' action=''>";

		// 年
		echo "<select name='y'>";
		for ($i = $y - 2; $i <= $y + 2; $i++) {
			echo "<option";
			if ($i == $y) {
				echo " selected ";
			}
			echo ">$i</option>";
		}
		echo "</select>年";

		// 月
		echo "<select name='m'>";
		for ($i = 1; $i <= 12; $i++) {
			echo "<option";
			if ($i == $m) {
				echo " selected ";
			}	
			echo ">$i</option>";
		}
		echo "</select>月";
		
		// 日
		echo "<select name='d'>";
		$ty = $y;
		$tm = $m; 
		$l = 1;
		if( $tm == 1 || $tm == 3|| $tm == 5|| $tm == 7|| $tm == 8 || $tm == 10 || $tm == 12 ){
			$l = 31;
		}else if ($ty % 4 == 0 && $tm == 2){
			$l = 29;
		}else if ($ty % 4 != 0 && $tm == 2){
			$l = 28;
		}else{
			$l = 30;
		}
		
		for ($i = 1; $i <= $l; $i++) {
			echo "<option";
			if ($i == $m) {
				echo " selected ";
			}
			echo ">$i</option>";
		}
		echo "</select>日 ～　";
		
		// 年月選択リストを再度表示する
		echo "<form method='POST' action=''>";

		// 年
		echo "<select name='y2'>";
		for ($i = $y - 2; $i <= $y + 2; $i++) {
			echo "<option";
			if ($i == $y) {
				echo " selected ";
			}
			echo ">$i</option>";
			$ty = $i;
		}
		echo "</select>年";

		// 月
		echo "<select name='m2'>";
		for ($i = 1; $i <= 12; $i++) {
			echo "<option";
			if ($i == $m) {
				echo " selected ";
			}
			echo ">$i</option>";
			$tm = $i;
		}
		echo "</select>月";
		
		// 日
		echo "<select name='d2'>";
		$ty = $y;
		$tm = $m; 
		$l = 1;
		if( $tm == 1 || $tm == 3|| $tm == 5|| $tm == 7|| $tm == 8 || $tm == 10 || $tm == 12 ){
			$l = 31;
		}else if ($ty % 4 == 0 && $tm == 2){
			$l = 29;
		}else if ($ty % 4 != 0 && $tm == 2){
			$l = 28;
		}else{
			$l = 30;
		}
		
		for ($i = 1; $i <= $l; $i++) {
			echo "<option";
			if ($i == $m) {
				echo " selected ";
			}
			echo ">$i</option>";
		}
		echo "</select>日　の間にやりたい　";

		?>
		</td>
	　</tr>
	  <tr>
	  <td></td>
	  </tr>
	 </table>
	 <br><br>
      <input type="submit" name="action" value="登録する">
<!-- 「戻る」ボタン -->
      <input type="button" name="back" onClick="history.back()" value="戻る">
      
 
</form>
</body>
</html>