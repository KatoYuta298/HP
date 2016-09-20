<?php

 if($_POST["selectBoxName"] <> ""){
 $link = mysqli_connect('localhost', 'xxxxx', 'xxxxxx');
	if (!$link) {
	    die('connect_fail'.mysql_error());
	}
	
	
	$db_selected = mysqli_select_db($link, 'okinawa');
	if (!$db_selected){
	    die('selected failed'.mysql_error());
	}
	
	$tempname = $_POST["selectBoxName"];
	
	$result = mysqli_query($link,'SELECT * from car WHERE carname="'.$tempname.'"');
	$tmp = mysqli_fetch_assoc($result);
	$carNo = $tmp['carNo'];
	
	if(!$result){
		die('Quely failed'.mysql_error());
	}else{		
		if($result->num_rows > 0){
			$result_temp = mysqli_query($link,'DELETE FROM car WHERE carname="'.$tempname.'"');
			 if(!$result_temp){
				die('Quely failed'.mysql_error());
			}
			$result_temp = mysqli_query($link,'UPDATE member SET property=0,carNo=0 WHERE carNo="'.$carNo.'"');
			 if(!$result_temp){
				die('Quely failed'.mysql_error());
			}
		}else{
			header("HTTP/1.1 301 Moved Permanently");
			header("Location: error_notdriver.html");
			exit();
		}
	}
	
	header("HTTP/1.1 301 Moved Permanently");
    header("Location: delete_kanryou.html");
	
}else{
print "error";
} 
?>