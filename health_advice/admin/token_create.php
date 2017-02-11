<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
define('PAGENAME', 'tokencreatepage', true);
include('header.php'); // require or include, config.php from include folder
include('config.php');
		// get vendor record from vendor_signup table
  $userresult = mysql_query("select * FROM token_rate_by_admin");   

?>
<link rel="stylesheet" href="../css/flip_switch.css" type="text/css" media="screen" />
<script src="js/jquery.js"></script> 
<script>
/* Change vendor approve status in vendor signup table*/
function showuserStatus(status) {
	var userId={userId:status};
   $.ajax({
   type: "GET",
   url: "user_status.php",
   data:userId,
   success: function(data){
   /*$("#txtHint").html(data);*/
   alert(data);
   }
 });
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
   url: "user_delete.php",
   data: info,
   success: function(data){
	   //alert(data);
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
		<h4 class="alert_info">Welcome to the Family Health Panel </h4>		
		<article class="module width_3_quarter" style="width: 100%;float:left;">
		<header><h3 class="tabs_involved">TOKEN CREATE</h3>		
                </header>                
                <div id="tab2" class="tab_content">
			<table class="tablesorter" cellspacing="0"> 
			<thead > 
				
				<tr align="center"> 
					<th align="center">S.NO.</th> 				
    				<th align="center">Normal Token One</th>
					 <th align="center">Normal Token One Price</th> 
    				 
					<th align="center">Normal Token Two</th> 
					 <th align="center">Normal Token Two Price</th>
					 <th align="center">Normal Token Three</th>
					 <th align="center">Normal Token Three Price</th> 					 				 
    				<th align="center">Monthly Token One</th>								 
					 <th align="center">Monthly Token One Price</th>
					 <th align="center">Monthly Token Two</th>								 
					 <th align="center">Monthly Token Two Price</th>
					 <th align="center">Monthly Token Three</th>								 
					 <th align="center">Monthly Token Three Price</th>
					 <th align="center">Message</th> 
					 <th align="center">Free Token Value</th>
					 <th align="center">Action</th>				 
    				
				</tr> 
				</thead> 
				<tbody id="txtHint" class="table-body" align="center">
                    <?php                  
                     
                            while($usertoken=mysql_fetch_array($userresult))  //carry on looping through while there are records
                                {
                           
                                echo "<tr class='".$countrecord." show' > 
                            
								<td>".$usertoken['token_rate_id']."</td> 
								<td>".$usertoken['normal_token_one']."</td>
                                   <td>".$usertoken['normal_token_one_price']."</td>
                                <td>".$usertoken['normal_token_two']."</td> 
                                <td>".$usertoken['normal_token_two_price']."</td>                   			
		                        <td>".$usertoken['normal_token_three']."</td>
                                
                                     <td >".$usertoken['normal_token_three_price']."</td>
                                     <td >".$usertoken['monthly_token_one']."</td>
                                     <td >".$usertoken['monthly_token_one_price']."</td>
                                     <td >".$usertoken['monthly_token_two']."</td>
                                     <td >".$usertoken['monthly_token_two_price']."</td>
                                     <td >".$usertoken['monthly_token_three']."</td>
                                     <td >".$usertoken['monthly_token_three_price']."</td>
                                     <td >".$usertoken['message']."</td>
                                     <td >".$usertoken['free_token_value']."</td>
                                                                         
                                     <td><a href='token_edit.php?token_id=".$usertoken['token_rate_id']."'>Edit</a></td>
								
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
