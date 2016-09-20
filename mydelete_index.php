<html>
<head>
<meta name="viewport"
	content="width=320,
		height=480,
		initial-scale=1.0,
		minimum-scale=1.0,
		maximum-scale=2.0,
		user-scalable=yes" />
</head>
<form method="POST" action="mydelete_select.php">
<p>イベント希望日を削除するページです
<br><br>
◇あなたは誰◇
<br>

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
<input type="submit" name="action" value="削除ページへ">
<!-- 「戻る」ボタン -->
      <input type="button" name="back" onClick="history.back()" value="戻る">
</form>
</body>
</html>