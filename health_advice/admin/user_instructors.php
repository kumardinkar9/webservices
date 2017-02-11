<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
define('PAGENAME', 'userinstructorspage', true);
include('header.php'); // require or include, config.php from include folder
include('config.php');
		// get vendor record from vendor_signup table
  $userresult = mysql_query("SELECT Instructor_ID,Instructor_user_name,Instructor_password,Instructor_email,Instructor_phone_number,Instructor_gender,Instructor_about,Instructor_approve_status,fname,lname,earn_token,instructor_profile_pic from user_instructors");   
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
		<header><h3 class="tabs_involved">user instructors</h3>		
                </header>                
                <div id="tab2" class="tab_content">
			<table class="tablesorter" cellspacing="0"> 
			<thead > 
				
				<tr align="center"> 
					<th align="center">S.NO.</th> 				
    				<th align="center">Fname</th>
					 <th align="center">Lname</th> 
    				 
					<th align="center">Instructor Email</th> 
					 <th align="center">Instructor Phone Number</th>
					 <th align="center">Instructor Gender</th>
					 <th align="center">Instructor About</th> 
					 				 
    				<th align="center">Instructor Approve Status</th> 
    				
					
					 
					 <th align="center">Earn Token</th>
					 <th align="center">Profile Picture</th> 
					 <th align="center">Action</th>					 
    				
				</tr> 
				</thead> 
				<tbody id="txtHint" class="table-body" align="center">
                    <?php                  
                     
                            while($userinstructor=mysql_fetch_array($userresult))  //carry on looping through while there are records
                                {
                           
                                echo "<tr class='".$countrecord." show' > 
                            
								<td>".$userinstructor['Instructor_ID']."</td> 
								<td>".$userinstructor['fname']."</td>
                                   <td>".$userinstructor['lname']."</td>
                                <td>".$userinstructor['Instructor_email']."</td> 
                                <td>".$userinstructor['Instructor_phone_number']."</td> 
                                			
										  
										<td>    <div class='onoffswitch'>
										<label name='onoffswitch' class='onoffswitch-label' id='".$userinstructor['Instructor_ID']."'>";
										if($userinstructor['Instructor_gender']==1){ echo 'Female'; }
										else { echo 'Male'; }
										echo "</label>
										
										</div></td>  
                                 
                                <td>".$userinstructor['Instructor_about']."</td>
                                <td>    <div class='onoffswitch'>
										<input type='checkbox' name='onoffswitch' class='onoffswitch-checkbox' id='".$userinstructor['Instructor_ID']."' "; if($userinstructor['Instructor_approve_status']==1){ echo 'checked'; } echo " onchange='showuserStatus(this.id)'>
										<label class='onoffswitch-label' for='".$userinstructor['Instructor_ID']."'>
										<span class='onoffswitch-inner'></span>
										<span class='onoffswitch-switch'></span>
										</label>
										</div></td>  
                                 
                                     <td >".$userinstructor['earn_token']."</td>
                                     <td><img src='".$userinstructor['instructor_profile_pic']."' width='50' height='50' ></td>
                                     <td><a href='user_edit.php?user_id=".$userinstructor['Instructor_ID']."'>Edit</a>&nbsp;&nbsp;/&nbsp;&nbsp;
								
								<a href='#' id='".$userinstructor['Instructor_ID']."_instructor_Id' class='delete' onclick=function()>delete</a></td>
								
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
