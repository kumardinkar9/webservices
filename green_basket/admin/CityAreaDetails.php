<?php
require_once 'include/config.php'; // require or include, config.php from include folder
$cityname= $_GET['cityname'];
if($cityname != ""){
	// get city_name area_name and location from area_details table according to city_name
  $sql="SELECT city_name, area, location from area_details where city_name = '".$cityname."'";
$result = mysql_query($sql);
$city_html='';
$city_html.= "<tr><td colspan='3'></td></tr><tr><th style='text-align: left; padding: 10px; font-size: 25px;'>City</th><th style='text-align: left; padding: 10px; font-size: 25px;'>Area</th><th style='text-align: left; padding: 10px; font-size: 25px;'>Location</th></tr>";
while($row = mysql_fetch_array($result)) {
  $city_html.= "<tr>";
  $city_html.= "<td>" . $row['city_name'] . "</td>";
  $city_html.= "<td>" . $row['area'] . "</td>";
  $city_html.= "<td><a href='".$row['location']."' target='_blank'>Click Here</a></td>"; 
  $city_html.= "</tr>";
}
echo $city_html;
}else{
	// get city_name area_name and location from area_details table
	$sql="SELECT city_name, area, location from area_details";
$result = mysql_query($sql);
$city_html='';
$city_html.= "<tr><td colspan='3'></td></tr><tr><th style='text-align: left; padding: 10px; font-size: 25px;'>City</th><th style='text-align: left; padding: 10px; font-size: 25px;'>Area</th><th style='text-align: left; padding: 10px; font-size: 25px;'>Location</th></tr>";
while($row = mysql_fetch_array($result)) {
  $city_html.= "<tr>";
  $city_html.= "<td>" . $row['city_name'] . "</td>";
  $city_html.= "<td>" . $row['area'] . "</td>";
  $city_html.= "<td><a href='".$row['location']."' target='_blank'>Click Here</a></td>"; 
  $city_html.= "</tr>";
}
echo $city_html;	
	}
?> 
