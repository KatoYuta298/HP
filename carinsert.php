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
	$tempnum  = $_POST["fixed"];
	
	$result = mysqli_query($link,'SELECT * from car WHERE carname="'.$tempname.'"');
	
	if(!$result){
		die('Quely failed'.mysql_error());
	}else{		
		if($result->num_rows > 0){
			$result_temp = mysqli_query($link,'UPDATE car SET carname="'.$tempname.'" , fixed="'.$tempnum.'" WHERE carname="'.$tempname.'"');
			 if(!$result_temp){
				die('Quely failed'.mysql_error());
			}
		}else{
			$result_temp = mysqli_query($link,'INSERT INTO car (carname, fixed) VALUES ("'.$tempname.'","'.$tempnum.'")');
			if(!$result_temp){
				die('Quely failed'.mysql_error());
			}
		}
		
		$carno_result = mysqli_query($link,'SELECT carNo from car WHERE carname="'.$tempname.'"');
		$carno = mysqli_fetch_assoc($carno_result);
		$tmpcarno = $carno['carNo'];
	
		$result_temp = mysqli_query($link,'UPDATE member SET property=1, carNo="'.$tmpcarno.'" WHERE name="'.$tempname.'"');
		if(!$result_temp){
			die('Quely failed'.mysql_error());
		}

	}
	
	header("HTTP/1.1 301 Moved Permanently");
    header("Location: touroku_kanryou.html");
	
}else{
print "error";
} 
?>