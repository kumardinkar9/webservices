<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
define('PAGENAME', 'itemDetailspage', true);
require_once 'include/config.php';  // require or include, config.php from include folder
require_once 'include/header.php';  // require or include, header.php from include folder
$success_msg=$_GET['msg'];  // get success message from productImageUpload.php and addProduct.php page
// get product details from product table
 $product_result = mysql_query("select `product_id`, `product_type_id`, `product_name`, `product_quantity_type`, `product_image`, `product_type_filter`, `product_possible_units` from `product`") or die (mysql_error()); 
  ?>
<link rel="stylesheet" href="css/flip_switch.css" type="text/css" media="screen" />
<script src="js/jquery.js"></script>
<script>
/* update product filter type in product table*/
function productFilterUpdate(filterType) {
	var product_filter_type={product_filter_type:filterType};
	$.ajax({
   type: "GET",
   url: "productFilterUpdate.php",
   data: product_filter_type,
   success: function(data){
   $("#txtHint").html(data);
 /* alert(data);*/
     }
 });
}
</script>
<script>
/* Product type change */
function productTypeChange(type) {
	var productIdType={productIdType:type};
   $.ajax({
   type: "GET",
   url: "productTypeChange.php",
   data: productIdType,
   success: function(data){
     }
 });
}
</script>
<script>
/* Product default unit change */
function productUnitChange(unit) {
	var productIdUnit={productIdUnit:unit};
   $.ajax({
   type: "GET",
   url: "productUnitChange.php",
   data: productIdUnit,
   success: function(data){
     }
 });
}
</script>
<script>
/* Product Possible Unit change or add*/
function productPossibleUnitChange(unit) {
	var productIdUnit={productIdUnit:unit};
   $.ajax({
   type: "GET",
   url: "productPossibleUnitAdd.php",
   data: productIdUnit,
   success: function(data){
    }
 });
}
</script>
<section id="main" class="column">		
		<h4 class="alert_info">Welcome to the GreenBasket admin panel </h4>
		
		<article class="module width_3_quarter" style="width: 100%;float:left;">
		<header><h3 class="tabs_involved">Item Details</h3> <!-- end of #tabs_involved -->		
		<a href="addProduct.php" style="font-size: 21px; padding: 0px;">Click Here For Add New Product</a>
                </header>                
                <div id="tab2" class="tab_content">
			<table class="tablesorter" cellspacing="0"> 
			<thead> 
				<?php
			if($success_msg != ""){
			echo '<tr>
				<th colspan="8" align="center" style="color:#435f36; font-size:20px;">'.$success_msg.'</th>
				</tr>';
			}
			?>
				<tr> 
					<th>S. No.</th> 				
    				<th>Product Name</th> 
    				<th>Product Id</th> 
					<th>Type 
					</th> 
					 <th>Possible Units 
					 </th>
    				<th>Default Units 
    				</th> 
					<th>Product Filter type</th>					
					<th>Image</th>
				</tr> 
				<tr>
				<th></th> 				
    				<th></th> 
    				<th></th> 
					<th>
					fruits &nbsp; veggies
					</th> 
					 <th>
					   Kg &nbsp;  &nbsp;  gm &nbsp;  &nbsp; pc
					 </th>
    				<th>
    				   Kg &nbsp;  &nbsp;  gm &nbsp;  &nbsp; pc
    				</th> 
					<th>Basic? &nbsp;  &nbsp;  Leafy?</th>					
					<th></th>				
				</tr>
				</thead> 
				<tbody id="txtHint" class="table-body">
                            <?php                         
                            $countrecord    =   0;
                            // Use product_id and $i to create name of product type 
                            // Use product_id and $i to cteate value of basic and leafy
                            $i=1;
                            // Use product_id and $j to create product type name
                            $j=100001;							
                            while($productdetails=mysql_fetch_array($product_result))  //carry on looping through while there are records
                                {
									// product possible units get from database and convert in  array
									$all_possible_units=$productdetails['product_possible_units'];
									 $array_possible_units=explode(',',$all_possible_units); 
									 $Kg="Kg";    
									 $gm="gm";    
									 $Pc="Pc";  									                       
                                echo "<tr class='".$countrecord."'>
                                <td>".$i."</td> 
								<td>".$productdetails['product_name']."</td> 							
								<td>  &nbsp; &nbsp;".$productdetails['product_id']."</td> 							
                                <td>  <input type='radio' name='".$productdetails['product_id']."_".$j."' value='".$productdetails['product_id']."_1'"; if($productdetails['product_type_id']==1){ echo 'checked'; } echo " onclick='productTypeChange(this.value)'>&nbsp; &nbsp;<input type='radio' name='".$productdetails['product_id']."_".$j."' value='".$productdetails['product_id']."_2'"; if($productdetails['product_type_id']==2){ echo 'checked'; } echo " onclick='productTypeChange(this.value)'>
										 </td> 									 
                                <td>  <input type='checkbox' name='Kg' value='".$productdetails['product_id']."_Kg'"; if(in_array($Kg, $array_possible_units)){ echo 'checked'; } echo " onclick='productPossibleUnitChange(this.value)'>&nbsp; &nbsp;
                                <input type='checkbox' name='gm' value='".$productdetails['product_id']."_gm'"; if(in_array($gm, $array_possible_units)){ echo 'checked'; } echo " onclick='productPossibleUnitChange(this.value)'>&nbsp; &nbsp
                                <input type='checkbox' name='Pc' value='".$productdetails['product_id']."_Pc'"; if(in_array($Pc, $array_possible_units)){ echo 'checked'; } echo " onclick='productPossibleUnitChange(this.value)'> </td>                               
								<td>  
								<input type='radio' name='".$productdetails['product_id']."_".$i."' value='".$productdetails['product_id']."_Kg'"; if($productdetails['product_quantity_type']=='Kg'){ echo 'checked'; } echo " onclick='productUnitChange(this.value)'>&nbsp;  
								<input type='radio' name='".$productdetails['product_id']."_".$i."' value='".$productdetails['product_id']."_gm'"; if($productdetails['product_quantity_type']=='gm'){ echo 'checked'; } echo " onclick='productUnitChange(this.value)'>&nbsp; 
								<input type='radio' name='".$productdetails['product_id']."_".$i."' value='".$productdetails['product_id']."_Pc'"; if($productdetails['product_quantity_type']=='Pc'){ echo 'checked'; } echo " onclick='productUnitChange(this.value)'>&nbsp;							
								</td>							
								<td> <input type='checkbox' name='".$i."_".$j."' value='".$productdetails['product_id']."_Basic' onclick='productFilterUpdate(this.value)'"; if($productdetails['product_type_filter']=='Basic'){ echo 'checked'; } echo "> &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp; 
								<input type='checkbox' name='".$i."_".$j."' value='".$productdetails['product_id']."_Leafy' onclick='productFilterUpdate(this.value)'"; if($productdetails['product_type_filter']=='Leafy'){ echo 'checked'; } echo "></td>															
								<td><img src='".$base_url.$productdetails['product_image']."' width='100' height='100' >  &nbsp;<a href='productImageUpload.php?p_id=".$productdetails['product_id']."'> upload/change</a> </td>							
								</tr>"; 
								$i++;
								$j++;
								}								
                     ?>                                			
			</tbody> 
			</table><!-- end of table -->		
			</div><!-- end of #tab2 -->		
		</article><!-- end of content manager article -->		
		<div class="clear"></div>		
		<div class="spacer"></div>
	</section><!-- end of section -->		
</body>
</html>
