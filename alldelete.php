<?php

 $link = mysqli_connect('localhost', 'xxxx', 'xxxx');
	if (!$link) {
	    die('connect_fail'.mysql_error());
	}
	
	
	$db_selected = mysqli_select_db($link, 'okinawa');
	if (!$db_selected){
	    die('selected failed'.mysql_error());
	}
	
	$result_temp = mysqli_query($link,'DELETE FROM car');
	if(!$result_temp){
		die('Quely failed'.mysql_error());
	}
	$result_temp = mysqli_query($link,'UPDATE member SET property=0,carNo=0' );
	if(!$result_temp){
		die('Quely failed'.mysql_error());
	}
	
	header("HTTP/1.1 301 Moved Permanently");
    header("Location: alldelete_kanryou.html");
	
?>