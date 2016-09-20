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
<h1>アンケート結果一覧</h1>
<p>○：2点　△：1点　✖：0点</p>
		
	<?php
	$link = mysqli_connect('localhost', 'xxxxx', 'xxxxxx');
	if (!$link) {
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
		
		// 項目を取得
		$item_array = array();
		$event_result = mysqli_query($link,'SELECT item1,item2,item3,item4,item5 from questionnair WHERE number = "'.$num.'";');
		$event = mysqli_fetch_assoc($event_result);
		$item_array[0]	= mb_convert_encoding($event['item1'], "UTF-8","sjis"); 
		$item_array[1]	= mb_convert_encoding($event['item2'], "UTF-8","sjis");
		$item_array[2]	= mb_convert_encoding($event['item3'], "UTF-8","sjis");
		$item_array[3]	= mb_convert_encoding($event['item4'], "UTF-8","sjis");
		$item_array[4]	= mb_convert_encoding($event['item5'], "UTF-8","sjis");
		
		//表を出力
		echo $title;
		echo "<br>\n";
		echo "<table border=1>\n";
		echo "<tr>\n";
		echo "<td>項目名</td>\n";
		echo "<td>○</td>\n";
		echo "<td>△</td>\n";
		echo "<td>✖</td>\n";
		echo "<td>点数</td>\n";
		echo "</tr>\n";
		
		for($j=0;$j<count($item_array);$j++){
			if($item_array[$j]!= ""){
				$j_name = $j+1;
				$r_string = 'result'.$j_name;
				
				//それぞれの結果を取得
				//○
				$result = mysqli_query($link,'SELECT COUNT(*) from q_result WHERE number = '.$num.' AND '.$r_string.' = 1;');
				if (!$result) {
					die('クエリーが失敗しました。まる'.mysql_error());
				}
				$temp_result = mysqli_fetch_assoc($result);
				$result_maru = $temp_result["COUNT(*)"];
				//△
				$result = mysqli_query($link,'SELECT COUNT(*) from q_result WHERE number = '.$num.' AND '.$r_string.' = 2;');
				if (!$result) {
					die('クエリーが失敗しました。さんかく'.mysql_error());
				}
				$temp_result = mysqli_fetch_assoc($result);
				$result_sankaku = $temp_result["COUNT(*)"];
				//✖
				$result = mysqli_query($link,'SELECT COUNT(*) from q_result WHERE number = '.$num.' AND '.$r_string.' = 3;');
				if (!$result) {
					die('クエリーが失敗しました。ばつ'.mysql_error());
				}
				$temp_result = mysqli_fetch_assoc($result);
				$result_batu = $temp_result["COUNT(*)"];
				 
				//scoreを計算
				$result_score= $result_maru*2 + $result_sankaku;
				
					echo "	<tr>\n";
					echo "		<td>$item_array[$j] </td>\n";
					echo "		<td>$result_maru </td>\n";
					echo "		<td>$result_sankaku </td>\n";
					echo "		<td>$result_batu </td>\n";
					echo "		<td>$result_score </td>\n";
					echo "	</tr>\n";
				}
			}
		}
		echo "</table>";
?>
<br><br>
<input type="button" name="top" onclick="location.href='../questionnair.html'" value="戻る">
</tr>
</table>
</body>
</html>