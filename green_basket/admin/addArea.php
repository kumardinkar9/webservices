<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
define('PAGENAME', 'addAreapage', true); 
require_once 'include/config.php'; // require or include, config.php from include folder
require_once 'include/header.php';	 // require or include, header.php from include folder
// get city name from area_details table
$Sql_city_name = mysql_query("SELECT DISTINCT city_name from area_details order by city_name");
$city_name=$_POST['city_name'];
$area_name=$_POST['area_name'];
$location_link=$_POST['location_link'];
$success_msg="Area name has been added successfully";
if($_POST['submit']){
	 if($city_name==""){
		  $errormsg="Please select city name";
		 }else{
			if($area_name=="" || $location_link==""){		
		 $errormsg="All fields are required";
		}else{		
		 $sql_area="INSERT INTO area_details (city_name, area, location) VALUES ('".$city_name."', '".$area_name."', '".$location_link."')";
		if(mysql_query($sql_area)){
			   header('location:cityarea.php?msg='.$success_msg.'');
           exit();
			}else{
				 $errormsg="Server error, Please try again!";
				}	
			}
		}    
}
?>
<link rel="stylesheet" href="css/flip_switch.css" type="text/css" media="screen" />
<script src="js/jquery.js"></script>
<section id="main" class="column">
			<h4 class="alert_info">Welcome to the GreenBasket admin panel </h4>		
		<article class="module width_3_quarter" style="width: 100%;float:left;">
		<header><h3 class="tabs_involved">Add New Area Name</h3>		
                </header>                
                <div id="tab2" class="tab_content">
					<form method="POST" action="<?php $_SERVER['PHP_SELF']; ?>" id="addAreapage"> 
			<table class="tablesorter" cellspacing="0"> 
			<thead> 
				<?php
			if($errormsg != ""){
			echo '<tr>
				<th colspan="2" align="center" style="color:red;">'.$errormsg.'</th>
				</tr>';
			}
			?>
							</thead> 
				<tbody>
				<tr> 
					<td>City Name</td>     				
					<td><select class="select-city-name" id="selected-city-name" name="city_name">
					  <option value="">--select city name---</option>
					<?php
					 $countrecord    =   0;
                            while($citiesdetails=mysql_fetch_array($Sql_city_name))  //carry on looping through while there are records
                                {
									echo "<option class='".$countrecord."' value='" . $citiesdetails['city_name'] . "'>" . $citiesdetails['city_name'] . "</option>";									
								}					
					?>
					</select></td>						
				</tr> 
				</tbody>
				<tbody>
                <tr> 
					<td>Area Name</td>     				
					<td><input type="text" name="area_name" value=""></td>						
				</tr> 
				</tbody> 
				<tbody> 
				<tr> 
					<td>Area Loaction Link</td>    				
					<td><input type="text" name="location_link" value=""></td>						
				</tr>  
				</tbody> 
				<tbody>         
                <tr> 
					<td colspan="2" align="center"><input type="submit" name="submit" value="Submit"></td>						
				</tr>           			
			</tbody> 
			</table><!--end of table -->
			</form><!--end of form -->
			</div><!-- end of #tab2 -->		
		</article><!-- end of content manager article -->		
		<div class="clear"></div>		
		<div class="spacer"></div>
	</section><!--end of section -->
</body><!--end of body -->
</html>
