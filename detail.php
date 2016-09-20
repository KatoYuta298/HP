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
<p>イベント希望者一覧
<br>
<br>

<?php
	
	$link = mysqli_connect('localhost', 'xxxxx', 'xxxxxx');
	if (!$link) {
	    die('接続失敗です。'.mysql_error());
	}
	
	$db_selected = mysqli_select_db($link, '28thevent');
	if (!$db_selected){
	    die('データベース選択失敗です。'.mysql_error());
	}
	
	$id = $_GET["id"];
	$time = mb_convert_encoding($_GET["time"],"sjis");
	$result = mysqli_query($link,'SELECT user FROM schedule WHERE id="'.$id.'" AND time="'.$time.'" ');
	if (!$result) {
	    die('クエリーが失敗しました。'.mysql_error());
	}
	
	
	while($temp = mysqli_fetch_assoc($result)){
	    static $i = 0;
	    $array[$i] = mb_convert_encoding($temp['user'], "UTF-8","sjis");		
	    $i++;
	}
	echo "<table>";
	for($i=0;$i<count($array);$i++){
		$user = $array[$i];
	echo "	<tr>\n";
		echo "		<td id=\"user\">$user </td>\n";
		echo "	</tr>\n";
		}
		echo "</table>";

?>
<br><br><br>
<!-- 「戻る」ボタン -->
      <input type="button" name="back" onClick="history.back()" value="戻る">
</body>
</html>