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
<title>アンケート</title>
<?PHP
echo("<title>アンケート</title></head><body>");
echo("<h1>アンケート回答</h1>");

$num = $_GET["num"];
$answer_count = 0;  //項目数
$link = mysqli_connect('localhost', 'xxxx', 'xxxxxxxx');
	if (!$link) {
	    die('接続失敗です。'.mysql_error());
	}
	
	$db_selected = mysqli_select_db($link, '28thquestionnair');
	if (!$db_selected){
	    die('データベース選択失敗です。'.mysql_error());
	}
	
	$result = mysqli_query($link,"SELECT * FROM questionnair WHERE number=$num;");
	if (!$result) {
	    die('クエリーが失敗しました。'.mysql_error());
	}
	$temp = mysqli_fetch_assoc($result);
	$num = $temp['number'];
	$title = mb_convert_encoding($temp['title'],"UTF-8","sjis"); 
	$name = mb_convert_encoding($temp['name'],"UTF-8","sjis"); 
	$text = mb_convert_encoding($temp['text'],"UTF-8","sjis"); 
	// 項目を配列に入れる
	$item_array =  array();
	$item_array[0] = $temp['item1'];
	$item_array[1] = $temp['item2'];
	$item_array[2] = $temp['item3'];
	$item_array[3] = $temp['item4'];
	$item_array[4] = $temp['item5'];

	for($i=0;$i<count($item_array);$i++){
		if($item_array[$i] != ""){
			$answer_count++;
		}else{
			break;
		}
	}
	
	echo "アンケート名:　$title";
	echo "<br>\n";
	echo "作成者： $name";
	echo "<br>\n";
	echo "説明:　$text";
	echo "<br>\n";

echo "<br>\n";
echo "あなたは誰？";
echo "<br>\n";

// 名前
echo("<form method=\"post\" action=\"insert_answer.php?num=$num&count=5\">");
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
echo "<br>\n";
	
// アンケート回答
		echo "<table border=1>";
		echo "<tr>";
		echo "<td>項目</td>";
		echo "<td>回答</td>";
		echo "</tr>";
		
		for($j=0;$j<$answer_count;$j++){
		$item = mb_convert_encoding($item_array[$j],"UTF-8","sjis");
		if($item != ""){
			echo "	<tr>\n";
			echo "		<td>$item </td>\n";
			echo "		<td>\n";
			
			// ○、×、△
			$answer_array = array('-','○','△','✖');
			$temp= "selectBoxResult";
			$r_name = $temp.$j;
			
			$ansSelectBox = "<select name=$r_name>\n";
			for ( $x = 0; $x < count( $answer_array ); $x++ ) {
			$ansSelectBox .= "\t<option value=\"{$answer_array[$x]}\">{$answer_array[$x]}</option>\n";
			}
			$ansSelectBox .= "</select>\n";
			echo "{$ansSelectBox}";
			
			echo " 		</td>\n";
			echo "	</tr>\n";
			
			}else{
				break;
			}
		}
		echo "</table>";

?>
 
<input type="submit" name="action" value="送信">
 </form>
 <br><br>
 <input type="button" name="top" onclick="location.href='../questionnair.html'" value="戻る">
</body>
</html>