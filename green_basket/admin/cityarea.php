<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
define('PAGENAME', 'cityareapage', true);
require_once 'include/header.php'; // require or include, config.php from include folder
$success_msg=$_GET['msg']; // get success message from add city and area page
// get city name from area_details
$city_result = mysql_query("SELECT DISTINCT city_name from area_details order by city_name");
?>
<link rel="stylesheet" href="css/flip_switch.css" type="text/css" media="screen" />
<script src="js/jquery.js"></script>
<script>
	/* function for show area_name according city_name */
function showUser(city) {
	$("#success-message").hide();
	var cityname={cityname:city};
	if(cityname != ""){
   $.ajax({
   type: "GET",
   url: "CityAreaDetails.php",
   data: cityname,
   success: function(data){
   $("#txtHint").html(data);
   /*alert(data);*/
   }
 });
}
}
</script>
<section id="main" class="column">		
		<h4 class="alert_info">Welcome to the GreenBasket admin panel </h4>		
		<article class="module width_3_quarter" style="width: 100%;float:left;">
		<header><h3 class="tabs_involved">City And Area Details</h3>		
                </header> <!-- end of .tabs_involved -->                                             
                <div id="tab2" class="tab_content">
			<table class="tablesorter" cellspacing="0"> 
			<thead> 
					<?php
			if($success_msg != ""){
			echo '<tr>
				<th colspan="2" id="success-message" align="center" style="color:#435f36; font-size:20px;">'.$success_msg.'</th>
				</tr>';
			}
			?>	
				<select class="select-city" id="selected-city-name" name="users" onchange="showUser(this.value)">
					  <option value="">Pick City</option>
					<?php
					 $countrecord    =   0;
                            while($citiesdetails=mysql_fetch_array($city_result))  //carry on looping through while there are records
                                {
									echo "<option class='".$countrecord."' value='" . $citiesdetails['city_name'] . "'>" . $citiesdetails['city_name'] . "</option>";									
								}				
					?>
					</select> 
					<a href="addCity.php" style="margin-left: 200px; padding: 7px; font-size: 30px; background-color: green;">Add City</a>
					<a href="addArea.php" style="margin-left: 200px; padding: 7px; font-size: 30px; background-color: green;">Add Area</a>
				</thead> 				
				<tbody id="txtHint" class="table-body">                            			
			</tbody> 			
			</table><!-- end of table -->		
			</div><!-- end of #tab2 -->		
		</article><!-- end of content manager article -->		
		<div class="clear"></div>		
		<div class="spacer"></div>
	</section><!-- end of section -->		
</body>
</html>
