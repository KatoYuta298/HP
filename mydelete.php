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
<?php
	
	$link = mysqli_connect('localhost', 'xxxxx', 'xxxxxx');
	if (!$link) {
	    die('connect_fail'.mysql_error());
	}
	$db_selected = mysqli_select_db($link, '28thevent');
	if (!$db_selected){
	    die('selected failed'.mysql_error());
	}
	$myid = $_GET["myid"];
	
	$delete2_result = mysqli_query($link,'DELETE from schedule WHERE myid="'.$myid.'"');
	
	header("Location: kanryo.php");
?>

</body>
</html>