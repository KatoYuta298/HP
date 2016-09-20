<html>
<head>
<meta name="viewport"
	content="width=320,
		height=480,
		initial-scale=1.0,
		minimum-scale=1.0,
		maximum-scale=2.0,
		user-scalable=yes" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>アンケート</title>
</head>
<body>
<h1>アンケート一覧</h1>
<p>回答するアンケートを選びましょう</p>
<table border=1>
<tr>
<td>アンケート名</td>
<td>作成者</td>
<td>説明</td>
</tr>
		
	<?php
	$link = mysqli_connect('localhost', 'xxxxx', 'xxxxxx');
	    die('connect_fail'.mysql_error());
	}
	$db_selected = mysqli_select_db($link, '28thquestionnair');
	if (!$db_selected){
	    die('selected failed'.mysql_error());
	}
	
	$event_result = mysqli_query($link,'SELECT number,title,name,text from questionnair');
	
	$num_array = array(); 
	$title_array = array();
	$name_array =  array();
	$text_array =  array();

	while($event = mysqli_fetch_assoc($event_result)){
		static $num=0;
		$num_array[$num]	= $event['number']; 
		$title_array[$num] = $event['title'];
		$name_array[$num] = $event['name'];
		$text_array[$num] = $event['text'];
		$num++;
	}
	for($i=0;$i<count($num_array);$i++){
		$num = $num_array[$i];
		$title=mb_convert_encoding($title_array[$i], "UTF-8","sjis");
		$name=mb_convert_encoding($name_array[$i], "UTF-8","sjis");
		$text=mb_convert_encoding($text_array[$i], "UTF-8","sjis");
		
		echo "	<tr>\n";
		echo "		<td><a href =\"answer.php?num=$num\">$title </td>\n";
		echo "		<td>$name </td>\n";
		echo "		<td>$text </td>\n";
		//echo "      <td><input type=\"button\" name=\"delete\" onclick=\"location.href='delete.php?id=$id'\" value=\"削除\"></td>\n";
		echo "	</tr>\n";
		}
		echo "</table>";
?>
<br><br>
<input type="button" name="top" onclick="location.href='../questionnair.html'" value="戻る">
</tr>
</table>
</body>
</html>