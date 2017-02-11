<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
define('PAGENAME', 'addProductpage', true);
require_once 'include/config.php'; // require or include, config.php from include folder
require_once 'include/header.php'; // require or include, header.php from include folder
$product_name=$_POST['product_name'];
$product_type=$_POST['product_type'];
$product_quantity_type=$_POST['product_quantity_type'];
$product_possible_units=$_POST['possible_units'];
$product_filter_type=$_POST['product_filter_type'];
$product_insert_date_time=date("Y-m-d H:i:s");    
$file_name=$_FILES["file"]["name"];
 $file_type=$_FILES["file"]["type"];
 $file_size=$_FILES["file"]["size"];
 $file_tmp_name=$_FILES["file"]["tmp_name"];
 $product_image="product_image/".$file_name;
$success_msg="New product has been added successfully";
foreach($product_possible_units as $key=>$value){
		$p_unit= "$value";
		if($p_unit != ""){
			$array.= $p_unit.',';
			}
	}
		  $possible_units_array = rtrim($array,',');
if($_POST['submit']){
    if(move_uploaded_file($file_tmp_name, "../product_image/". $file_name)){
		 $sql="INSERT INTO product (product_type_id, product_name, product_image, product_quantity_type, product_possible_units, product_insert_date_time, product_type_filter) VALUES ('".$product_type."', '".$product_name."', '".$product_image."', '".$product_quantity_type."', '".$possible_units_array."', '".$product_insert_date_time."', '".$product_filter_type."')";
		if(mysql_query($sql)){
			 header('location:itemDetails.php?msg='.$success_msg.'');
			}else{
				 $message="Sql error";
				}
		}else{
			 $message= "Image uploading error";
			}
		}   
?>
<link rel="stylesheet" href="css/flip_switch.css" type="text/css" media="screen" />
<script src="js/jquery.js"></script>
<section id="main" class="column">		
		<h4 class="alert_info">Welcome to the GreenBasket admin panel </h4>		
		<article class="module width_3_quarter" style="width: 100%;float:left;">
		<header><h3 class="tabs_involved">Add New Product</h3>		
                </header>  <!-- end of .tabs_involved -->                             
                <div id="tab2" class="tab_content">
					<form method="POST" action="<?php $_SERVER['PHP_SELF']; ?>" id="blockuser" enctype="multipart/form-data"> 
			<table class="tablesorter" cellspacing="0"> 
			<thead> 	
								<?php
			if($message != ""){
			echo '<tr>
				<th colspan="2" align="center" style="color="red"; font-size:20px;">'.$message.'</th>
				</tr>';
			}
			?>							
				</thead> 
				<tbody >
                  		<tr>
							<td>Product Name</td>
							<td><input type="text" name="product_name"></td>
                  		</tr>	
			</tbody>
			<tbody >
                  		<tr>
							<td>Product type</td>
							<td><input type='radio' name="product_type" value="1">fruits
								<input type='radio' name="product_type" value="2">veggies</td>
                  		</tr>	
			</tbody>
			<tbody >
                  		<tr>
							<td>Default Units </td>
							<td><input type='radio' name="product_quantity_type" value="Kg">Kg
								<input type='radio' name="product_quantity_type" value="gm">gm
								<input type='radio' name="product_quantity_type" value="Pc">Pc</td>
                  		</tr>	
			</tbody> 
			 
			<tbody >
                  		<tr>
							<td>Possible Units</td>
							<td><input type='checkbox' name="possible_units[]" value="Kg">Kg
								<input type='checkbox' name="possible_units[]" value="gm">gm
								<input type='checkbox' name="possible_units[]" value="Pc">Pc</td>
                  		</tr>	
			</tbody> 
			<tbody >
                  		<tr>
							<td>Product Filter Type</td>
							<td><input type='radio' name="product_filter_type" value="Basic">Basic
								<input type='radio' name="product_filter_type" value="Leafy">Leafy
								</td>
                  		</tr>	
			</tbody>
			<tbody>
					<tr>
					<td>Product Image</td>
					<td><input type="file" name="file" id="file"></td>
                      
                   </tr>          			
			</tbody> 
			<tbody>
					<tr>
					<td colspan="2" align="center"><input type="submit" name="submit" value="submit"></td>
                    </tr>          			
			</tbody> 
			</table><!-- end of table -->		
			</form><!-- end of form -->		
			</div><!-- end of #tab2 -->		
		</article><!-- end of content manager article -->		
		<div class="clear"></div>		
		<div class="spacer"></div>
	</section><!-- end of section -->		
</body>
</html>
