<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
define('PAGENAME', 'addCitypage', true); 
require_once 'include/config.php'; // require or include, config.php from include folder
require_once 'include/header.php'; // require or include, header.php from include folder
$city_name=$_POST['city_name'];
$area_name=$_POST['area_name'];
$location_link=$_POST['location_link'];
$success_msg="City name has been added successfully";
if($_POST['submit']){
	if($city_name=="" || $area_name=="" || $location_link==""){		
		 $errormsg="All fields are required";
		}else{
	 $sql="SELECT COUNT(*) AS `isexits` from area_details where city_name='" . $city_name . "'";
			$execute_query=mysql_query($sql);
			while($row = mysql_fetch_array($execute_query)){
				 $isexits=$row['isexits'];
				}			
		if ($isexits == 0) {			
		 $sql_city="INSERT INTO area_details (city_name, area, location) VALUES ('".$city_name."', '".$area_name."', '".$location_link."')";
		if(mysql_query($sql_city)){
			   header('location:cityarea.php?msg='.$success_msg.'');
           exit();
			}else{
				 $errormsg="Server error, Please try again!";
				}
			
			}else{
       $errormsg    =   "City name already exist";     
    }
   }
}	    
?>
<link rel="stylesheet" href="css/flip_switch.css" type="text/css" media="screen" />
<script src="js/jquery.js"></script>
<section id="main" class="column">		
		<h4 class="alert_info">Welcome to the GreenBasket admin panel </h4>		
		<article class="module width_3_quarter" style="width: 100%;float:left;">
		<header><h3 class="tabs_involved">Add New City Name</h3>		
                </header> <!-- end of .tabs_involved -->               
                <div id="tab2" class="tab_content">
					<form method="POST" action="<?php $_SERVER['PHP_SELF']; ?>" id="addCitypage"> 
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
					<td><input type="text" name="city_name" value=""></td>						
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
			</table><!-- end of table -->
			</form><!-- end of form -->
			</div><!-- end of #tab2 -->		
		</article><!-- end of content manager article -->		
		<div class="clear"></div>		
		<div class="spacer"></div>
	</section><!-- end of section -->
</body>
</html>
