<?php
include('config.php');  // require or include, config.php from include folder
$id = $_GET['userId'];  // get vendor id from viewvendor.php page

// get vendor record from vendor_signup table
$result = mysql_query("SELECT instructor_approve_status from user_instructors where instructor_id='" . $id . "'");
$userStatus=mysql_fetch_array($result);  //carry on looping through while there are records
          
		$instructor_approve_status=$userStatus['instructor_approve_status'];	
			
		
			if($instructor_approve_status==0){
				$status = 1;
				}else{
					$status = 0;
					}											
					 $sql="UPDATE user_instructors SET instructor_approve_status='$status' WHERE instructor_id='" .$id . "'";
				if(mysql_query($sql)){
					 $massage="Approve status change";
			}	else{
				 $massage= "Approve status not change";
				}	
				echo  $massage;



?>

