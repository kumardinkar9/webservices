<?php
require_once 'include/config.php'; // require or include, config.php from include folder
$product_filter_type = $_GET['product_filter_type']; // get product_id and filter_type from itemDetails.php page
$p_id_type=explode("_",$product_filter_type);
$product_id=$p_id_type['0'];
$filter_type=$p_id_type['1'];
if($filter_type=="Basic"){
		$sql="UPDATE product SET product_type_filter='".$filter_type."' WHERE product_id='" . $product_id . "'";
				if(mysql_query($sql)){
					$massage="Product filter type changed";					
				}
	}	
if($filter_type=="Leafy"){
					$sql="UPDATE product SET product_type_filter='".$filter_type."' WHERE product_id='" . $product_id . "'";
				if(mysql_query($sql)){
					$massage="Product filter type changed";
					}
	}
	 $product_result = mysql_query("SELECT product_id, product_type_id, product_name, product_quantity_type, product_image, product_type_filter from product");
	 $countrecord    =   0;
                            // Use product_id and $i to create name of product type 
                            // Use product_id and $i to cteate value of basic and leafy
                            $i=1;
                            // Use product_id and $j to create product type name
                            $j=100001;							
                            while($productdetails=mysql_fetch_array($product_result))  //carry on looping through while there are records
                                {                               
                                echo "<tr class='".$countrecord."'>
                                <td>".$i."</td> 
								<td>".$productdetails['product_name']."</td>								
								<td>  &nbsp; &nbsp;".$productdetails['product_id']."</td> 								
                                <td>  <input type='radio' name='".$productdetails['product_id']."_".$j."' value='1'"; if($productdetails['product_type_id']==1){ echo 'checked'; } echo ">&nbsp; &nbsp;<input type='radio' name='".$productdetails['product_id']."_".$j."' value='2'"; if($productdetails['product_type_id']==2){ echo 'checked'; } echo ">
										 </td> 									 
                                <td>  <input type='checkbox' name='fruits' value='1'"; if($productdetails['product_quantity_type']=='Kg'){ echo 'checked'; } echo ">&nbsp; &nbsp;<input type='checkbox' name='veggies' value='2'"; if($productdetails['product_quantity_type']=='gm'){ echo 'checked'; } echo ">&nbsp; &nbsp;<input type='checkbox' name='veggies' value='3'"; if($productdetails['product_quantity_type']=='Pc'){ echo 'checked'; } echo "> ".$productdetails['product_quantity_type']."</td>                               
								<td>  <input type='radio' name='".$productdetails['product_id']."_".$i."' value='1'"; if($productdetails['product_quantity_type']=='Kg'){ echo 'checked'; } echo ">&nbsp;  <input type='radio' name='".$productdetails['product_id']."_".$i."' value='2'"; if($productdetails['product_quantity_type']=='gm'){ echo 'checked'; } echo "> &nbsp; <input type='radio' name='".$productdetails['product_id']."_".$i."' value='3'"; if($productdetails['product_quantity_type']=='Pc'){ echo 'checked'; } echo "> </td>								
								<td> <input type='radio' name='".$i."_".$j."' value='".$productdetails['product_id']."_Basic' onclick='productFilterUpdate(this.value)'"; if($productdetails['product_type_filter']=='Basic'){ echo 'checked'; } echo "> &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp; 
								<input type='radio' name='".$i."_".$j."' value='".$productdetails['product_id']."_Leafy' onclick='productFilterUpdate(this.value)'"; if($productdetails['product_type_filter']=='Leafy'){ echo 'checked'; } echo "></td>															
								<td><img src='".$base_url.$productdetails['product_image']."' width='100' height='100' >  &nbsp;<a href='productImageUpload.php?p_id=".$productdetails['product_id']."'> upload/change</a> </td>							
								</tr>"; 
								$i++;
								$j++;
								}
?>
