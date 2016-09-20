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
<body>
<h1>希望イベント一覧</h1>
<p>削除するイベント希望を選択</p>
<table border=1>
<tr>
<td>イベント</td>
<td>希望者</td>
<td>希望日</td>
<form method="POST" action="mydelete_select.php">
<?php
	$user_name = mb_convert_encoding($_POST["selectBoxName"],"sjis");

	$link = mysqli_connect('localhost', 'xxxxx', 'xxxxxx');
	    die('接続失敗です。'.mysql_error());
	}
	
	$db_selected = mysqli_select_db($link, '28thevent');
	if (!$db_selected){
	    die('データベース選択失敗です。'.mysql_error());
	}
	
	$id_result = mysqli_query($link,'SELECT myid,name,schedule.user,time FROM schedule LEFT JOIN event ON schedule.id = event.id WHERE schedule.user="'.$user_name.'";');
	if (!$id_result) {
	    die('クエリーが失敗しました。'.mysql_error());
	}
	
	$myid_array = array(); 
	$name_array = array(); 
	$user_array =  array();
	$time_array = array();
	while($result = mysqli_fetch_assoc($id_result)){
		static $num=0;
		$myid_array[$num] = $result['myid']; 
		$name_array[$num] = $result['name']; 
		$user_array[$num] = $result['user'];
		$time_array[$num] = $result["time"];		
		$num++;
	}
	for($i=0;$i<count($name_array);$i++){
		$myid = $myid_array[$i];
		$name = mb_convert_encoding($name_array[$i],"UTF-8","sjis");
		$user = mb_convert_encoding($user_array[$i],"UTF-8","sjis");
		$time = $time_array[$i];
	echo "	<tr>\n";
		echo "		<td id=\"name\">$name </td>\n";
		echo "		<td id=\"user\">$user </td>\n";
		echo "		<td id=\"time\">'$time' </td>\n";
		echo "      <td><input type=\"button\" name=\"delete\" onclick=\"location.href='mydelete.php?myid=$myid'\" value=\"削除\"></td>\n";
		echo "	</tr>\n";
		}
		echo "</table>";

	mysqli_close($link);
?>

<!-- 「戻る」ボタン -->
      <input type="button" name="top" onclick="location.href='../schedule.html'" value="戻る">
</form>
</body>
</html>