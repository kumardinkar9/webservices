<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
define('PAGENAME', 'termsConditionpage', true);
require_once 'include/config.php'; // require or include, config.php from include folder
require_once 'include/header.php';  // require or include, header.php from include folder
include_once 'ckeditor/ckeditor.php';  // require or include, ckeditor.php from ckeditor folder
	// get terms and condition from terms_condition.php page
$sql_terms="select terms_conditions from terms_conditions";
$execute_query=mysql_query($sql_terms);
	$row = mysql_fetch_array($execute_query);
	 $terms_conditions_value=$row['terms_conditions'];	 
 $terms_condition=mysql_real_escape_string($_POST['terms_condition']);
$last_updated_date_time=date("Y-m-d H:i:s");
if(isset($_POST['save'])){
	  $sql="UPDATE terms_conditions SET terms_conditions='" . $terms_condition . "', last_updated_date_time='" . $last_updated_date_time . "' WHERE terms_id='1'";
	if(mysql_query($sql)){
	$errormsg="Terms and condition update";	
	$sql_terms="select terms_conditions from terms_conditions";
			$execute_query=mysql_query($sql_terms);
			$row = mysql_fetch_array($execute_query);
				 $terms_conditions_value=$row['terms_conditions'];	
	}else{
		$errormsg="Terms and condition is not update, Please try again!";
		}
	}
?>
<link rel="stylesheet" href="css/flip_switch.css" type="text/css" media="screen" />
<script src="js/jquery.js"></script>
<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
<section id="main" class="column">		
		<h4 class="alert_info">Welcome to the GreenBasket admin panel </h4>		
		<article class="module width_3_quarter" style="width: 100%;float:left;">
		<header><h3 class="tabs_involved">Terms And Conditions</h3>	
                </header>  <!-- end of #tabs_involved -->		                         
                <div id="tab2" class="tab_content">
					<form method="POST" name="termsCondition" action="<?php $_SERVER['PHP_SELF']; ?>" id="termsCondition"> 
			<table class="tablesorter" cellspacing="0"> 
			<thead>	
				<?php
			if($errormsg != ""){
			echo '<tr>
				<td colspan="2" align="center" style="color:red;">'.$errormsg.'</td>
				</tr>';
			}
			?>				
				</thead> 				
				<tbody>
                     <tr> 
						 <td colspan="2"><textarea name="terms_condition" cols="50" rows="30" class="ckeditor"><?php echo $terms_conditions_value; ?></textarea></td>
					</tr>                               			
				</tbody> 
				<tbody>
                     <tr> 
						 <td colspan="2" align="center"><input type="submit" value="Save"  name="save" style="width: 110px !important;margin: 0px 138px;"></td>
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
