<html>
<head>
		
<?php
	
	 $link = mysqli_connect('localhost', 'xxxxx', 'xxxxxx');
	if (!$link) {
	    die('connect_fail'.mysql_error());
	}
	$db_selected = mysqli_select_db($link, '28thevent');
	if (!$db_selected){
	    die('selected failed'.mysql_error());
	}
	$id = $_GET["id"];
	
	$delete_result = mysqli_query($link,'DELETE from event WHERE id="'.$id.'"');
	$delete2_result = mysqli_query($link,'DELETE from schedule WHERE id="'.$id.'"');
	
	header("Location: kanryo.php");
?>

</body>
</html>