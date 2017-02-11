<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
define('PAGENAME', 'viewvendorpage', true);
require_once 'include/header.php'; // require or include, config.php from include folder
// get city name from area_details table
$city_name_result = mysql_query("SELECT distinct city_name from area_details order by city_name");
		// get vendor record from vendor_signup table
  $vendor_result = mysql_query("SELECT vendor_id, vendor_shop_name, vendor_city, vendor_email, vendor_mobile_number, vendor_area, vendor_shop_address, vendor_latitude, vendor_longitude, vendor_signup_date_time, vendor_approve_status from vendor_signup order by vendor_signup_date_time");   
?>
<link rel="stylesheet" href="css/flip_switch.css" type="text/css" media="screen" />
<script src="js/jquery.js"></script> 
<script>
/* Change vendor approve status in vendor signup table*/
function showVendorStatus(status) {
	var vendorId={vendorId:status};
   $.ajax({
   type: "GET",
   url: "vendorStatus.php",
   data: vendorId,
   success: function(data){
   /*$("#txtHint").html(data);
   alert(data);*/
   }
 });
}
</script>
<script>
/* Get city name from vendor signup table*/
function showVendor(getCity) {
	var vendor_city={vendor_city:getCity};
	if(vendor_city != ""){
	$.ajax({
   type: "GET",
   url: "vendorList.php",
   data: vendor_city,
   success: function(data){
   $("#txtHint").html(data);
 /* alert(data);*/
   }
 });
}
}
</script>
<script type="text/javascript">
/*To use conformation box for delete vendor from vendor_signup table*/
$(function() {
$(".delete").click(function(){
var element = $(this);
var del_id = element.attr("id");
var info = 'id=' + del_id;
if(confirm("Are you sure you want to delete this vendor?"))
{
 $.ajax({
   type: "POST",
   url: "vendorDelete.php",
   data: info,
   success: function(data){
	//   alert(data);
 }
});
  $(this).parents(".show").animate({ backgroundColor: "#003" }, "slow")
  .animate({ opacity: "hide" }, "slow");
 }
return false;
});
});
</script>
<section id="main" class="column" style="width:97%;">		
		<h4 class="alert_info">Welcome to the GreenBasket admin panel </h4>		
		<article class="module width_3_quarter" style="width: 100%;float:left;">
		<header><h3 class="tabs_involved">Vendor Lists</h3>		
                </header>                
                <div id="tab2" class="tab_content">
			<table class="tablesorter" cellspacing="0"> 
			<thead style="font-size: 10px"> 
				<tr><select class="select-city" id="selected-city-name" name="city_name" onchange="showVendor(this.value)">
					  <option value="">Pick City</option>
					<?php
					 $countrecord    =   0;
                            while($citiesdetails=mysql_fetch_array($city_name_result))  //carry on looping through while there are records
                                {
									echo "<option class='".$countrecord."' value='" . $citiesdetails['city_name'] . "'>" . $citiesdetails['city_name'] . "</option>";									
								}					
					?>
					</select> 
					</tr>
				<tr> 
					<th>S. No.</th> 				
    				<th>Vendor Shop Name</th> 
    				<th>Vendor City</th> 
					<th>Vendor Area</th> 
					 <th>Vendor Shop Address</th>
					 <th>Location(Link)</th>
					 <th>Mobile#</th> 
					 <th>Email Id</th> 					 
    				<th>Vendor Signup Date</th> 
    				<th>Action</th> 
					<th>Vendor Approved</th>
				</tr> 
				</thead> 
				<tbody id="txtHint" class="table-body">
                    <?php                  
                      $countrecord    =   0;
                            $i=1;
                            while($vendordetails=mysql_fetch_array($vendor_result))  //carry on looping through while there are records
                                {
                            $vendor_signup_date= date('d - M - Y',strtotime($vendordetails['vendor_signup_date_time']));
                                echo "<tr class='".$countrecord." show' > 
                                <td>".$i."</td> 
								<td>".$vendordetails['vendor_shop_name'] ."&nbsp;&nbsp;&nbsp;<br><a href='vendorOrder.php?v_id=".$vendordetails['vendor_id']."'>(Click to see order)</a></td> 
								<td>".$vendordetails['vendor_city']."</td> 
                                <td>".$vendordetails['vendor_area']."</td> 
                                <td>".$vendordetails['vendor_shop_address']."</td>
                                 <td><a href='https://www.google.com/maps/preview?q=".$vendordetails['vendor_latitude'].",".$vendordetails['vendor_longitude']."' target='_blank'>Click Here</a></td>
								<td>".$vendordetails['vendor_mobile_number']."</td>
								<td>".$vendordetails['vendor_email']."</td>
								<td>".$vendor_signup_date."</td>
								<td><a href='vendorEdit.php?v_id=".$vendordetails['vendor_id']."'>Edit</a>&nbsp;&nbsp;/&nbsp;&nbsp;
								<a href='#' id='".$vendordetails['vendor_id']."_vendor_id' class='delete' onclick=function()>delete</a></td>
								<td>    <div class='onoffswitch'>
										<input type='checkbox' name='onoffswitch' class='onoffswitch-checkbox' id='".$vendordetails['vendor_id']."' "; if($vendordetails['vendor_approve_status']==1){ echo 'checked'; } echo " onchange='showVendorStatus(this.id)'>
										<label class='onoffswitch-label' for='".$vendordetails['vendor_id']."'>
										<span class='onoffswitch-inner'></span>
										<span class='onoffswitch-switch'></span>
										</label>
										</div></td>
								</tr>"; 
								$i++;
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
