<?php
require_once 'include/config.php';  // require or include, config.php from include folder
 $vendor_id = $_REQUEST['id']; // get vendor id from viewvendor.php
  // vendor record delete from vendor_signup table
 $sql_delete="delete from vendor_signup where vendor_id='".$vendor_id."'";
if(mysql_query($sql_delete)){	
		echo true;
	}else{
		echo false;
		}
// vendor record delete from vendor_rating table
$vendor_rating_delete_sql="delete from vendor_rating where vendor_id='".$vendor_id."'";
if(mysql_query($vendor_rating_delete_sql)){
		echo true;
		}else{
		echo false;
		}
// vendor record delete from vendor_product_list table
$vendor_product_list_delete_sql="delete from vendor_product_list where vendor_id='".$vendor_id."'";
			if(mysql_query($vendor_product_list_delete_sql)){
				echo true;
			}else{
		echo false;
		}
?>
