<?php
require_once 'include/config.php'; // require or include, config.php from include folder
$product_type = $_GET['productIdType'];  // get product_id and product_type_id from itemDetails.php page
$p_id_type=explode("_",$product_type);
$product_id=$p_id_type['0'];
$product_type=$p_id_type['1'];
	$sql="UPDATE product SET product_type_id='" . $product_type . "' WHERE product_id='" . $product_id . "'";
	if(mysql_query($sql)){
	$massage="Product Type change";
	}							
?>
