<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
define('PAGENAME', 'userviewpage', true);
include('header.php'); // require or include, config.php from include folder
include('config.php');
		// get vendor record from vendor_signup table
  $userresult = mysql_query("SELECT user_id,user_name,fname,lname,email,gender,login_date_time,login_type,profile_image_url from social_media_login_user"); 
  $totalcount=mysql_query("SELECT COUNT(*) FROM social_media_login_user");
  $rows=mysql_fetch_array($totalcount); 
  $total=$rows[0];
  

?>

<link rel="stylesheet" href="../css/flip_switch.css" type="text/css" media="screen" />
<section id="main" class="column" style="width:97%;">		
		<h4 class="alert_info">Welcome to the Family Health Panel </h4>		
		<article class="module width_3_quarter" style="width: 100%;float:left;">
		<header><h3 class="tabs_involved" >USER VIEW </h3><h2 style="padding-top:20px";><?php echo "Total rows: " . $total;?></h2>		
                </header>                
                <div id="tab2" class="tab_content">
			<table class="tablesorter" cellspacing="0"> 
			<thead > 
				
				<tr align="center"> 
					<th align="center">S.NO.</th> 
					<th align="center">User Name</th> 				
    				<th align="center">Fname</th>
					 <th align="center">Lname</th> 
    				 
					<th align="center">Email</th> 
					 <th align="center">Gender</th>
					 <th align="center">Login Date Time</th>
					 <th align="center">Login Type</th> 
					 <th align="center">Profile Picture</th> 
					 					 
    				
				</tr> 
				</thead> 
				<tbody id="txtHint" class="table-body" align="center">
                    <?php                  
                     
                            while($user=mysql_fetch_array($userresult))  //carry on looping through while there are records
                                {
                           
                                echo "<tr class='".$countrecord." show' > 
                            
								<td>".$user['user_id']."</td> 
								<td>".$user['user_name']."</td> 
								<td>".$user['fname']."</td>
                                   <td>".$user['lname']."</td>
                                <td>".$user['email']."</td> 
                                <td>    <div class='onoffswitch'>
										<label name='onoffswitch' class='onoffswitch-label' id='".$user['user_id']."'>";
										if($user['gender']==1){ echo 'Female'; }
										else { echo 'Male'; }
										echo "</label>
										
										</div></td> 
										<td>".$user['login_date_time']."</td>  
                                 
                                <td>".$user['login_type']."</td>
                 <td><img src='".$user['profile_image_url']."' width='50' height='50' ></td>
                                     							
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
