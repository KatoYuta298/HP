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
<title>スケジュール帳</title>
</head>
<body>
<h1>イベント一覧</h1>
<p>参加したいイベントを選びましょう</p>
<table border=1>
<tr>
<td>イベント</td>
<td>提案者</td>
<td>募集期間</td>
</tr>
		
	<?php
	$link = mysqli_connect('localhost', 'xxxxx', 'xxxxxx');
	if (!$link) {
	    die('connect_fail'.mysql_error());
	}
	$db_selected = mysqli_select_db($link, '28thevent');
	if (!$db_selected){
	    die('selected failed'.mysql_error());
	}
	
	$event_result = mysqli_query($link,'SELECT * from event');
	
	$id_array = array(); 
	$event_array = array();
	$name_array =  array();
	$user_array =  array();
	$fyear_array =  array();
	$fmonth_array=  array();
	$fdate_array =  array();
	$lyear_array = array();
	$lmonth_array =  array();
	$ldate_array =  array();
	while($event = mysqli_fetch_assoc($event_result)){
		static $num=0;
		$id_array[$num]	= $event['id']; 
		$name_array[$num] = $event['name'];
		$user_array[$num] = $event['user'];
		$fyear_array[$num] = $event['fyear'];
		$fmonth_array[$num] = $event['fmonth'];
		$fdate_array[$num] = $event['fdate'];
		$lyear_array[$num] = $event['lyear'];
		$lmonth_array[$num] = $event['lmonth'];
		$ldate_array[$num] = $event['ldate'];
		$num++;
	}
	for($i=0;$i<count($name_array);$i++){
		$id = $id_array[$i];
		$name=mb_convert_encoding($name_array[$i],"UTF-8","sjis");
		$user=mb_convert_encoding($user_array[$i], "UTF-8","sjis");
		$fyear=$fyear_array[$i];
		$fmonth=$fmonth_array[$i];
		$fdate=$fdate_array[$i] ;
		$lyear=$lyear_array[$i] ;
		$lmonth=$lmonth_array[$i];
		$ldate=$ldate_array[$i] ;
		
/*		$car_result = mysqli_query($link,'SELECT carNo,fixed from car WHERE carname="'.$tmpname.'"');
		$cartmp = mysqli_fetch_assoc($car_result);
		$fixed_num = $cartmp['fixed'];
		$car_num = $cartmp['carNo'];
		
		$name_result = mysqli_query($link,'SELECT name from member WHERE property=0 AND carNo="'.$car_num.'"');
		$name_array = array();
		$tnum=0;
		while($nametmp = mysqli_fetch_assoc($name_result)){
			$name_array[$tnum] = $nametmp['name'];
			$tnum++;
		}
*/
		echo "	<tr>\n";
		echo "		<td><a href =\"calendar.php?id=$id\">$name </td>\n";
		echo "		<td>$user </td>\n";
		echo "		<td>$fyear 年 $fmonth 月 $fdate 日　～　$lyear 年 $lmonth 月 $ldate 日</td>\n";
		echo "      <td><input type=\"button\" name=\"delete\" onclick=\"location.href='delete.php?id=$id'\" value=\"削除\"></td>\n";
		echo "	</tr>\n";
		}
		echo "</table>";
?>
<br><br>
<input type="button" name="top" onclick="location.href='../schedule.html'" value="戻る">
</tr>
</table>
</body>
</html>