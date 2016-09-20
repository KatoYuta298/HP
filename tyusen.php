<?php
function uppercheck($arg_link,$arg_num){
	$count_result = mysqli_query($arg_link,'SELECT * from member WHERE carNo = "'.$arg_num.'"');
	$upper_result = mysqli_query($arg_link,'SELECT fixed from car WHERE carNo = "'.$arg_num.'"');

	$upper_count = mysqli_fetch_assoc($upper_result);
		
	if($upper_count['fixed'] > $count_result->num_rows){
		return true;
	}else{
	    return false;
	}	
}


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
	
	$check_result = mysqli_query($link,'SELECT carNo,property from member WHERE name="'.$tempname.'"');
	$property = mysqli_fetch_assoc($check_result);
	if($property['property'] == 1){
		header("HTTP/1.1 301 Moved Permanently");
		header("Location: error_driver.html");
		exit();
	}
	if($property['carNo'] > 0){
		$carNonow = $property['carNo'];
		header("HTTP/1.1 301 Moved Permanently");
		header("Location: tyuusen_kanryou.html?id=$carNonow");
		exit();
	}	
	
	$result = mysqli_query($link,'SELECT carNo from car');
	
	$array = array();
	while($temp = mysqli_fetch_assoc($result)){
	    static $i = 0;
		$tmp_result = uppercheck($link,$temp['carNo']);
	    if($tmp_result){
			$array[$i] = $temp['carNo'];
			print $array[$i];
			print '<br>';
			$i++;
		}
	}

	
	$count = count($array);
	
	if($count == 0 ){
		header("HTTP/1.1 301 Moved Permanently");
		header("Location: error_full.html");
		exit();
	}
	
	$random = rand(0,$count-1);
	
	//echo 'random_number:';
	//echo $array[$random];
	
	$tmpcarNo = $array[$random];
	
	if(!$result){
		die('Quely failed'.mysql_error());
	}else{
		$result_temp = mysqli_query($link,'UPDATE member SET carNo="'.$tmpcarNo.'" WHERE name="'.$tempname.'"');
		if(!$result_temp){
			die('Quely failed'.mysql_error());
		}
	}
	
	header("HTTP/1.1 301 Moved Permanently");
    header("Location: tyuusen_kanryou.html?id=$tmpcarNo");
	
}else{
print "error";
} 
?>