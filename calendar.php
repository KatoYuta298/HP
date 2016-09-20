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
</head>
<title>スケジュール帳</title>
<?PHP
echo("<title>スケジュール帳</title></head><body>");
echo("<h1>イベント希望日登録</h1>");
$id = $_GET["id"];
$link = mysqli_connect('localhost', 'xxxxx', 'xxxxx');
	if (!$link) {
	    die('接続失敗です。'.mysql_error());
	}
	
	$db_selected = mysqli_select_db($link, '28thevent');
	if (!$db_selected){
	    die('データベース選択失敗です。'.mysql_error());
	}
	
	$result = mysqli_query($link,"SELECT name FROM event WHERE id=$id;");
	if (!$result) {
	    die('クエリーが失敗しました。'.mysql_error());
	}
	$temp = mysqli_fetch_assoc($result);
	$event = mb_convert_encoding($temp['name'],"UTF-8","sjis"); 

echo("<form id=\"form1\" name=\"form1\" method=\"post\" action=\"calendar.php?id=$id\">");

	echo "イベント:　$event";
    echo "<p>◇カレンダー◇</p>";


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
echo "<input type='submit' value='表示' name='sub1'>";
echo "</form>";
?>
<!-- カレンダーの表示 -->
<table border="1">
<tr>
<th>日</th>
<th>月</th>
<th>火</th>
<th>水</th>
<th>木</th>
<th>金</th>
<th>土</th>
</tr>
<tr>
<?php
// 1日の曜日まで移動
$wd1 = date("w", mktime(0, 0, 0, $m, 1, $y));
for ($i = 1; $i <= $wd1; $i++) {
    echo "<td>　</td>";
}
$id = $_GET["id"];
$d = 1;

while (checkdate($m, $d, $y)) {
    // 日付リンクの表示
    /*$link = "touroku.php?id=$id&y=$y&m=$m&d=$d&user=$selectBoxName";
    echo "<td><a href=\"" . sprintf($link, $y, $m, $d) . "\">{$d}</a></td>";
	*/
	  echo "<td>$d</td>";
	
    // 今日が土曜日の場合の処理
    if (date("w", mktime(0, 0, 0, $m, $d, $y)) == 6) {
        // 週を終了
        echo "</tr>";

        // 次の週がある場合は新たな行を準備
        if (checkdate($m, $d + 1, $y)) {
            echo "<tr>";
        }
    }

    // 日付を1つ進める
    $d++;
}

// 最後の週の土曜日まで移動
$wdx = date("w", mktime(0, 0, 0, $m + 1, 0, $y));
for ($i = 1; $i < 7 - $wdx; $i++) {
    echo "<td>　</td>";
}
?>
</tr>
</table>
<br><br>
◇登録◇
<br>
<br>
あなたは誰？
<br>
<?php 
// 名前
echo("<form id=\"form2\" name=\"form2\" method=\"post\" action=\"touroku.php?id=$id\">");
$id = $_GET["id"];
$link = mysqli_connect('localhost', 'root', 'maron0220');
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
	echo("<br><p>イベントを希望する日を選びましょう</p>");

// 年月選択リストを表示する
		echo "<form method='POST' action=''>";

		// 年
		echo "<select name='year'>";
		for ($i = $y - 2; $i <= $y + 2; $i++) {
			echo "<option";
			if ($i == $y) {
				echo " selected ";
			}
			echo ">$i</option>";
		}
		echo "</select>年";

		// 月
		echo "<select name='month'>";
		for ($i = 1; $i <= 12; $i++) {
			echo "<option";
			if ($i == $m) {
				echo " selected ";
			}	
			echo ">$i</option>";
		}
		echo "</select>月";
		
		// 日
		echo "<select name='date'>";
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
		echo "</select>日 を希望　";

?>
 
 <BUTTON type=”submit” >送信</BUTTON>
 </form>
 <br><br>
 <input type="button" name="top" onclick="location.href='../schedule.html'" value="戻る">
</body>
</html>