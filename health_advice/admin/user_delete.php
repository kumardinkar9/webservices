<?php
define('PAGENAME', 'userdeletepage', true);
include('config.php');  // require or include, config.php from include folder
 $userid = $_REQUEST['id']; // get vendor id from viewvendor.php
  // vendor record delete from vendor_signup table
 $sql_delete="delete from user_instructors where instructor_id='".$userid."'";
if(mysql_query($sql_delete)){	
		echo true;
	}else{
		echo false;
		}
// instructor record delete from instructors_rating table
$instructor_rating_delete_sql="delete from instructors_rating where instructors_id='".$userid."'";
if(mysql_query($instructor_rating_delete_sql)){
		echo true;
		}else{
		echo false;
		}
// instructor record delete from user_booking  table
$user_booking_delete_sql="delete from user_booking where instructor_id='".$userid."'";
			if(mysql_query($user_booking_delete_sql)){
				echo true;
			}else{
		echo false;
		}
// instructor record delete from user_instructors_availability table
$user_instructors_availability_delete_sql="delete from user_instructors_availability where instructor_id='".$userid."'";
			if(mysql_query($user_instructors_availability_delete_sql)){
				echo true;
			}else{
		echo false;
		}
?>
