<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
define('PAGENAME', 'productImageUploadpage', true);
require_once 'include/config.php';  // require or include, config.php from include folder
require_once 'include/header.php';  // require or include, header.php from include folder
$product_id = $_GET['p_id']; 
 $file_name=$_FILES["file"]["name"];
 $file_type=$_FILES["file"]["type"];
 $file_size=$_FILES["file"]["size"];
 $file_tmp_name=$_FILES["file"]["tmp_name"];
 $success_msg="Product image has been uploaded successfully";
if($_POST['upload']){
    if(move_uploaded_file($file_tmp_name, "../product_image/". $file_name)){
		$sql="UPDATE product SET product_image='product_image/".$_FILES["file"]["name"]."' WHERE product_id='" . $product_id . "'";
				if(mysql_query($sql)){
					   header('location:itemDetails.php?msg='.$success_msg.'');
								exit();
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
		<header><h3 class="tabs_involved">Product image change or upload</h3>		
                </header><!-- end of #tabs_involved -->		           
                <div id="tab2" class="tab_content">
					<form method="POST" action="<?php $_SERVER['PHP_SELF']; ?>" id="blockuser" enctype="multipart/form-data"> 
			<table class="tablesorter" cellspacing="0"> 
			<thead> 				
				<?php
			if($message != ""){
			echo '<tr>
				<td colspan="2" style="color:red;" align="center">'.$message.'</td>
				</tr>';
			}
			?>					
				</thead> 				
				<tbody>
					<tr>
					<td align="right">Product Image</td>
					<td><input type="file" name="file" id="file"></td>                      
                   </tr>          			
			</tbody> 
			<tbody>
					<tr>
					<td colspan="2" align="center"><input type="submit" name="upload" value="upload"></td>
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
