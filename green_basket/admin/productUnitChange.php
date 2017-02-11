<?php
require_once 'include/config.php';   // require or include, config.php from include folder
$product_unit = $_GET['productIdUnit'];  // get product_id and product_quantity_type from itemDetails.php page
$p_id_type=explode("_",$product_unit);
$product_id=$p_id_type['0'];
$product_quantity=$p_id_type['1'];
	$sql="UPDATE product SET product_quantity_type='" . $product_quantity . "' WHERE product_id='" . $product_id . "'";
	if(mysql_query($sql)){
	$massage="Product Type change";
	}								
?>
