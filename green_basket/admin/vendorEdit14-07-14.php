<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
define('PAGENAME', 'vendorEditpage', true);
require_once 'include/config.php';
require_once 'include/header.php';
$vendor_id  =   $_REQUEST['v_id'];
 $selectquery = mysql_query("SELECT * FROM vendor_signup where vendor_id='".$vendor_id."'");
while($vendordetails=mysql_fetch_array($selectquery))  //carry on looping through while there are records
        {
		 $vendor_shop_name=$vendordetails['vendor_shop_name'];
		$vendor_mobile_number=$vendordetails['vendor_mobile_number'];
		$vendor_email=$vendordetails['vendor_email'];
		$vendor_area=$vendordetails['vendor_area'];
		$vendor_city=$vendordetails['vendor_city'];
		$another_area=$vendordetails['another_area'];
		$vendor_shop_address=$vendordetails['vendor_shop_address'];
		$lat=$vendordetails['vendor_latitude'];
		$lng=$vendordetails['vendor_longitude'];
		$vendor_sell_vegetables=$vendordetails['vendor_sell_vegetables'];
		 $vendor_sell_fruits=$vendordetails['vendor_sell_fruits'];
		 $vendor_pick_location_directly=$vendordetails['vendor_pick_location_directly'];		
		}
		/*		
		$vendor_pick_location_address= getaddress($lat,$lng);
		// get address using latitude and longitude 
		function getaddress($lat,$lng)
		{
		$url = 'http://maps.googleapis.com/maps/api/geocode/json?latlng='.trim($lat).','.trim($lng).'&sensor=false';
		$json = @file_get_contents($url);
		$data=json_decode($json);
		$status = $data->status;
		if($status=="OK")
		return $data->results[0]->formatted_address;
		else
		return false;
		}
		// Get latitude and longitude using address
		$address = $_POST['vendor_pick_location_directly'];
		$prepAddr = str_replace(' ','+',$address);		 
		$geocode=file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false');		 
		$output= json_decode($geocode);		 
		$latitude = $output->results[0]->geometry->location->lat;
		$longitude = $output->results[0]->geometry->location->lng;		 
			*/	
		if($vendor_area==""){
			$select_area="Select Area";
			$select_value="";
			}else{
				$select_area=$vendor_area;
			$select_value=$vendor_area;
				}
		
		// sql for slecet all area for one city 
$sql_area=mysql_query("select vendor_area from vendor_signup where vendor_city='".$vendor_city."'");
if(isset($_POST['save'])){    
    //print_r($_POST);
    $vendor_shop_name =   $_POST['vendor_shop_name'];
    $vendor_mobile_number    =   $_POST['vendor_mobile_number'];
    $vendor_email      =   $_POST['vendor_email'];
    $vendor_shop_address     =   $_POST['vendor_shop_address'];
    $vendor_city  =   $_POST['vendor_city'];
    $vendor_area       =   $_POST['vendor_area'];
    $another_area       =   $_POST['another_area'];
    $vendor_sell_vegetables        =   $_POST['vendor_sell_vegetables'];
    $vendor_sell_fruits      =   $_POST['vendor_sell_fruits'];
    $vendor_lat      =   $_POST['vendor_latitude'];
    $vendor_lng      =   $_POST['vendor_longitude'];
    
    if($vendor_shop_name == "" || $vendor_mobile_number == "" || $vendor_email == "" || $vendor_shop_address == "" || $vendor_city == ""){
        $errormsg   =   "All field are require";    
    }
    else{
      $updatequery  =   "update vendor_signup set vendor_shop_name='".$vendor_shop_name."',vendor_mobile_number='".$vendor_mobile_number."',vendor_email='".$vendor_email."',vendor_shop_address='".$vendor_shop_address."',vendor_city='".$vendor_city."',vendor_area='".$vendor_area."',another_area='".$another_area."',vendor_sell_vegetables='".$vendor_sell_vegetables."',vendor_sell_fruits='".$vendor_sell_fruits."',vendor_latitude='".$vendor_lat."',vendor_longitude='".$vendor_lng."' where vendor_id='".$vendor_id."'";
    if(mysql_query($updatequery)){
			header('location:viewvendor.php');
				exit();
		}
    $errormsg   =   "Updation error! Please try again!";    
    }
}
if(isset($_POST['cancel'])){
        header('location:viewvendor.php');
		 exit();
}
?>
<script type="text/javascript" src="js/jquery-form.validate.js"></script>
<script type="text/javascript">
/*$(document).ready(function(){
$('#createuser').validate(
 {
  rules: {
    username: {
      minlength: 2,
      required: true
    },
    address: {
        minlength: 2,
      required: true
	  
    },
     email: {
      required: true,
      email: true
    },
    region: {
        minlength: 2,
      required: true
	  
    },
    contactno: {
      digits: true,
	  maxlength:14,
	  minlength: 10,
      required: true
    },
   
  },
  highlight: function(element) {
    $(element).closest('.control-group').removeClass('success').addClass('error');
  },
  success: function(element) {
    element
    .text('OK!').addClass('valid')
    .closest('.control-group').removeClass('error').addClass('success');
  }
 });
}); */// end document.ready
</script>
<section id="main" class="column" style="width:100%">
		
		<h4 class="alert_info">Welcome to the GreenBasket admin panel </h4>
		
		<article class="module width_3_quarter">
		<header><h3 class="tabs_involved">EDIT VENDORS</h3>
		
		</header>

		<div class="tab_container">
			<div id="tab1" class="tab_content">
                            <form method="POST" name="vendorEditpage" action="<?php $_SERVER['PHP_SELF']; ?>" id="updateuser">
			<table class="tablesorter" cellspacing="0"> 
			<tbody> 
								<?php
			if($errormsg != ""){
			echo '<tr>
				<th colspan="8" align="center" style="color:#ff0000; font-size:20px;">'.$errormsg.'</th>
				</tr>';
			}
			?>
				<tr> 
   				<td><label for="Shop Name">Shop Name:</label></td> 
    				<td><input type="text" name="vendor_shop_name" value="<?php echo $vendor_shop_name ;?>"></td>     				
				</tr>
			</tbody> 
			<tbody> 
				<tr> 
                                <td><label for="Mobile Number">Mobile Number:</label></td> 
    				<td><input type="text" name="vendor_mobile_number" value="<?php echo $vendor_mobile_number;?>"></td>     				
				</tr>
			</tbody> 
			<tbody> 
				<tr> 
   					<td><label for="Email Address">Email Address:</label></td> 
    				<td><input type="text" name="vendor_email" value="<?php echo $vendor_email;?>"></td>     				
				</tr>
			</tbody> 
			<tbody> 
				<tr> 
   				<td><label for="Address">Address:</label></td> 
    				<td><input type="text" name="vendor_shop_address" value="<?php echo $vendor_shop_address;?>"></td>     				
				</tr>
			</tbody> 
			<tbody> 
                        <tr> 
                        <td><label for="City">City :</label></td> 
                        <td><input type="text" name="vendor_city"  value="<?php echo $vendor_city;?>"></td>
                        </tr>
			</tbody>
			<tbody> 
                        <tr> 
                        <td><label for="Area">Area :</label></td> 
                        <td><select class="select-area" id="selected-area" name="vendor_area">
					  <option value="<?php echo $select_value; ?>"><?php echo $select_area; ?></option>
					<?php
					 $countrecord    =   0;
                            while($area_details=mysql_fetch_array($sql_area))  //carry on looping through while there are records
                                {
									echo "<option class='".$countrecord."' value='" . $area_details['vendor_area'] . "'>" . $area_details['vendor_area'] . "</option>";									
								}					
					?>
					</select> 
                        </td>
                        </tr>
			</tbody>
			<tbody> 
			<?php
			if($another_area!=""){
					echo "<tr> 
                        <td><label for='region'>Another Area :</label></td> 
                        <td><input type='text' name='another_area'  value='". $another_area ."'></td>
                        </tr>";
		}
			?>
			</tbody>
			<tbody> 
			<tr>
				<td>We Sell</td>
				<td><input type="checkbox" name="vendor_sell_vegetables" value="1" <?php if($vendor_sell_vegetables==1){ echo "checked"; } ?>>Vegetables
				<input type="checkbox" name="vendor_sell_fruits" value="1" <?php if($vendor_sell_fruits==1){ echo "checked"; } ?>>Fruits
				</td>
			</tr>
				</tbody> 
							
			<tbody> 
			<tr>
				<td>Location</td>
				<td>
					<div class="latlong"><div class="label">Latitude: </div><div class="value"><input type="text" name="vendor_latitude" value="<?php echo $lat; ?>"></div></div>
					<div class="latlong"><div class="label">Longitude: </div><div class="value"><input type="text" name="vendor_longitude" value="<?php echo $lng; ?>"></div>
				</td>
			</tr>
				</tbody> 
			<tbody> 
			<tr>
				<td align="center" colspan="2"><input type="submit" name="save" value="Save"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input type="submit" name="cancel" value="Cancel"></td>				
			</tr>
				</tbody> 
				<tbody> 
				
			</tbody> 
			
			</table>
                            </form>
			</div><!-- end of #tab1 -->
			
		
			
		</div><!-- end of .tab_container -->
		
		</article><!-- end of content manager article -->
		
		<div class="clear"></div>
		
		<div class="spacer"></div>
	</section>


</body>

</html>
