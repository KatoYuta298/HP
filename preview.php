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
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>スケジュール帳</title>
</head>
<body>
<h1>イベント希望状況</h1>

<table border=1>
<tr>
<td>イベント</td>
<td>提案者</td>
<td>日付</td>
<td>人数</td>
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
	
	$time_result = mysqli_query($link,'SELECT id,time ,count(time) from schedule group by id,time');
	
	$id_array = array(); 
	$time_array =  array();
	$count_array = array();
	while($res = mysqli_fetch_assoc($time_result)){
		static $num=0;
		$id_array[$num] = $res['id']; 
		$time_array[$num] = $res['time'];
		$count_array[$num] = $res["count(time)"];		
		$num++;
	}
	
	$event_result = mysqli_query($link,'SELECT id,name,user from event');
	$name_array = array();
	$user_array =  array();
	$id2_array = array();
	while($event = mysqli_fetch_assoc($event_result)){
		static $num2=0;
		$id2_array[$num2] = $event['id']; //IDの数だけ入っている
		$name_array[$num2] = $event['name'];
		$user_array[$num2] = $event['user'];
		$num2++;
	}
	
	$idcount_result = mysqli_query($link,'SELECT id,count(id) from schedule group by id');
	
	$idcount_array = array(); 
	$idnum_array = array();
	while($id_res = mysqli_fetch_assoc($idcount_result)){
		static $num3=0;
		$idnum_array[$num3] = $id_res['id']; //日付のあるIDだけ入っている
		$co_array[$num3] = $id_res['count(id)'];
		$num3++;
	}
	$num4=0;
	$num5=0;
	for($i=0;$i<count($id2_array);$i++){
		$id = $id2_array[$i];     //すべてのID
		$name=mb_convert_encoding($name_array[$i],"UTF-8","sjis");
		$user=mb_convert_encoding($user_array[$i], "UTF-8","sjis");
		if(count($idnum_array) <= 0) break;
		if($id == $idnum_array[$num4]){ //日付が登録されているIDと比べる
			$rowlen = 0;
			for($p=0;$p < count($id_array);$p++){
				if($id == $id_array[$p]){
					$rowlen++;
				}
			}
			echo "	<tr>\n";
			echo "		<td rowspan=\"$rowlen\">$name </td>\n";
			echo "		<td rowspan=\"$rowlen\">$user </td>\n";
			$timec="";
			//while($id_array[$num5] == $id && $num5 <= count($id_array)){
			for($l=0;$num5<count($id_array);$l++){
				if($id_array[$num5] != $id ) break;
				$timec=$time_array[$num5];
				$count=$count_array[$num5];
				
				if($l>0)echo "	<tr>\n";
				echo "		<td> '$timec'　</td>\n";
				echo "		<td> $count </td>\n";
				echo " <td><input type=\"button\" name=\"delete\" onclick=\"location.href='detail.php?id=$id&time=$timec'\" value=\"詳細\"></td>\n";
		
				echo "	</tr>\n";
				$num5++;
			}
			if($num4 < count($idnum_array)-1 ){
				$num4++;
			}else{
				break;
			}
		}
		
	echo "	</tr>\n";
		}
		echo "</table>";
?>
<br>
<input type="button" name="top" onclick="location.href='../schedule.html'" value="戻る">
</tr>
</table>
</body>
</html>