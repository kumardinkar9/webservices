<?php
require_once 'include/config.php';  // require or include, config.php from include folder
$product_unit = $_GET['productIdUnit']; // get product_id and product_quantity from itemDetails.php page
$p_id_type=explode("_",$product_unit);
$product_id=$p_id_type['0'];
$product_quantity=$p_id_type['1'];
// get product_possible_units from product table
$sql="select product_possible_units from product where product_id='" . $product_id . "'";
$execute_query=mysql_query($sql);
			while($row = mysql_fetch_array($execute_query)){
				 $product_possible_units=$row['product_possible_units'];
				}				
$possible_units=explode(",",$product_possible_units);
$array=array();
$array_unit='';
$replace="";
if(in_array($product_quantity,$possible_units)){
	$update_possible_units=str_replace($product_quantity,$replace,$product_possible_units);
	print_r($update_possible_units);
	$var_possible_units=explode(",",$update_possible_units);
	for($i=0; $i<count($var_possible_units); $i++){
		$units=$var_possible_units[$i];
		if($units != ""){
		$array_unit.=$units.",";
		}
	}
		$array_unit = rtrim($array_unit,",");
			$sql_unit="UPDATE product SET product_possible_units='" . $array_unit . "' WHERE product_id='" . $product_id . "'";
	if(mysql_query($sql_unit)){
			$massage="Product possible units update";
			}			
	}else{
		if($product_possible_units==""){
				$sql_unit="UPDATE product SET product_possible_units='" . $product_quantity . "' WHERE product_id='" . $product_id . "'";
			if(mysql_query($sql_unit)){
			$massage="Product possible units update";
			}
			}else{
			$sql_unit="UPDATE product SET product_possible_units='" . $product_possible_units . "," . $product_quantity . "' WHERE product_id='" . $product_id . "'";
			if(mysql_query($sql_unit)){
			$massage="Product possible units update";
			}
		}					
}								
?>
