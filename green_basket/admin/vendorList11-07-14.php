<?php
require_once 'include/config.php';  // require or include, config.php from include folder
$vendor_city = $_GET['vendor_city'];   // get vendor city from viewvendor.php
if($vendor_city != ""){
	// get vendor record according to city from vendor_signup table
 $vendor_result = mysql_query("SELECT vendor_id, vendor_shop_name, vendor_city, vendor_email, vendor_mobile_number, vendor_area, vendor_shop_address, vendor_latitude, vendor_longitude, vendor_signup_date_time, vendor_approve_status from vendor_signup where vendor_city = '".$vendor_city."' order by vendor_signup_date_time");                        
                               $countrecord    =   0;
                            $i=1;
                            while($vendordetails=mysql_fetch_array($vendor_result))  //carry on looping through while there are records
                                {
                            $vendor_signup_date= date('d - M - Y',strtotime($vendordetails['vendor_signup_date_time']));
                                echo "<tr class='".$countrecord." show' > 
                                <td>".$i."</td> 
								<td>".$vendordetails['vendor_shop_name'] ."&nbsp;&nbsp;&nbsp;<a href='vendorOrder.php?v_id=".$vendordetails['vendor_id']."'>(Click to see order)</a></td> 
								<td>".$vendordetails['vendor_city']."</td> 
                                <td>".$vendordetails['vendor_area']."</td> 
                                <td>".$vendordetails['vendor_shop_address']."</td>
                                 <td><a href='https://www.google.com/maps/preview?q=".$vendordetails['vendor_latitude'].",".$vendordetails['vendor_longitude']."' target='_blank'>Click Here</a></td>
								<td>".$vendordetails['vendor_mobile_number']."</td>
								<td>".$vendordetails['vendor_email']."</td>
								<td>".$vendor_signup_date."</td>
								<td><a href='vendorEdit.php?v_id=".$vendordetails['vendor_id']."'>Edit</a>&nbsp;&nbsp;/&nbsp;&nbsp;
								<a href='#' id='".$vendordetails['vendor_id']."_vendor_id' class='delete' onclick=function()>delete</a></td>
								<td>     <div class='onoffswitch'>
										<input type='checkbox' name='onoffswitch' class='onoffswitch-checkbox' id='".$vendordetails['vendor_id']."' "; if($vendordetails['vendor_approve_status']==1){ echo 'checked'; } echo " onchange='showVendorStatus(this.id)'>
										<label class='onoffswitch-label' for='".$vendordetails['vendor_id']."'>
										<span class='onoffswitch-inner'></span>
										<span class='onoffswitch-switch'></span>
										</label>
										</div> </td>
								</tr>"; 
								$i++;
								}
}else{
	$vendor_result = mysql_query("SELECT vendor_id, vendor_shop_name, vendor_city, vendor_area, vendor_shop_address, vendor_latitude, vendor_longitude, vendor_signup_date_time, vendor_approve_status from vendor_signup order by vendor_signup_date_time");                        
 $countrecord    =   0;
                              $countrecord    =   0;
                            $i=1;
                            while($vendordetails=mysql_fetch_array($vendor_result))  //carry on looping through while there are records
                                {
                            $vendor_signup_date= date('d - M - Y',strtotime($vendordetails['vendor_signup_date_time']));
                                echo "<tr class='".$countrecord." show' > 
                                <td>".$i."</td> 
								<td>".$vendordetails['vendor_shop_name'] ."&nbsp;&nbsp;&nbsp;<a href='vendorOrder.php?v_id=".$vendordetails['vendor_id']."'>(Click to see order)</a></td> 
								<td>".$vendordetails['vendor_city']."</td> 
                                <td>".$vendordetails['vendor_area']."</td> 
                                <td>".$vendordetails['vendor_shop_address']."</td>
                                 <td><a href='https://www.google.com/maps/preview?q=".$vendordetails['vendor_latitude'].",".$vendordetails['vendor_longitude']."' target='_blank'>Click Here</a></td>
								<td>".$vendordetails['vendor_mobile_number']."</td>
								<td>".$vendordetails['vendor_email']."</td>
								<td>".$vendor_signup_date."</td>
								<td><a href='vendorEdit.php?v_id=".$vendordetails['vendor_id']."'>Edit</a>&nbsp;&nbsp;/&nbsp;&nbsp;
								<a href='#' id='".$vendordetails['vendor_id']."_vendor_id' class='delete' onclick=function()>delete</a></td>
								<td>     <div class='onoffswitch'>
										<input type='checkbox' name='onoffswitch' class='onoffswitch-checkbox' id='".$vendordetails['vendor_id']."' "; if($vendordetails['vendor_approve_status']==1){ echo 'checked'; } echo " onchange='showVendorStatus(this.id)'>
										<label class='onoffswitch-label' for='".$vendordetails['vendor_id']."'>
										<span class='onoffswitch-inner'></span>
										<span class='onoffswitch-switch'></span>
										</label>
										</div> </td>
								</tr>"; 
								$i++;
								}
	}	
?>

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
