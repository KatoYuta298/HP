<?php
// 初期化
$q_title = "";
$q_explain = "";
$q_item1 = "";
$q_item2 = "";
$q_item3 = "";
$q_item4 = "";
$q_item5 = "";
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
<title>アンケート</title>
</head>
<body>
<h1>アンケート作成(○、△、×形式)</h1>
<form method="POST" action="q_touroku.php">
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
      <td>アンケート名(40字以内)</td>
    </tr>
    <tr>
      <td>
      <textarea rows="1" cols="40" name="q_title"><?php echo $q_title; ?></textarea>
      </td>
    </tr>
    <tr>
	  <td></td>
	</tr>
	<tr>
      <td>アンケート説明(40字以内)</td>
    </tr>
	 <tr>
      <td>
      <textarea rows="1" cols="40" name="q_explain"><?php echo $q_explain; ?></textarea>
      </td>
    </tr>
	<tr>
      <td>アンケート項目(40字以内)</td>
    </tr>
	 <tr>
      <td>
      1 <textarea rows="1" cols="40" name="q_item1"><?php echo $q_item1; ?></textarea>
      </td>
	  </tr>
	  <tr>
	   <td>
      2 <textarea rows="1" cols="40" name="q_item2"><?php echo $q_item2; ?></textarea>
      </td>
	  </tr>
<tr>
	   <td>
      3 <textarea rows="1" cols="40" name="q_item3"><?php echo $q_item3; ?></textarea>
      </td>
	  </tr>
<tr>
	   <td>
      4<textarea rows="1" cols="40" name="q_item4"><?php echo $q_item4; ?></textarea>
      </td>
	  </tr>
<tr>
	   <td>
      5 <textarea rows="1" cols="40" name="q_item5"><?php echo $q_item5; ?></textarea>
      </td>
</tr>
	 </table>
	 <br><br>
      <input type="submit" name="action" value="登録する">
<!-- 「戻る」ボタン -->
      <input type="button" name="back" onClick="history.back()" value="戻る">
      
 
</form>
</body>
</html>