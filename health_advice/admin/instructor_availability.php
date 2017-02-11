<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
define('PAGENAME', 'instructoravailabilitypage', true);
include('header.php'); // require or include, config.php from include folder
include('config.php');
		// get vendor record from vendor_signup table
  $userresult = mysql_query("select user_instructors.instructor_id,user_instructors.fname,user_instructors.lname,user_instructors_availability.available_date,user_instructors_availability.video_available_date,user_instructors_availability.chat_available_date,user_instructors_availability.instructor_start_time,user_instructors_availability.instructor_end_time FROM user_instructors INNER JOIN user_instructors_availability ON user_instructors.instructor_id=user_instructors_availability.instructor_id");   

?>
<link rel="stylesheet" href="../css/flip_switch.css" type="text/css" media="screen" />

<section id="main" class="column" style="width:97%;">		
		<h4 class="alert_info">Welcome to the Family Health Panel </h4>		
		<article class="module width_3_quarter" style="width: 100%;float:left;">
		<header><h3 class="tabs_involved" align="center">INSTRUCTOR  AVAILABILITY</h3>		
                </header>                
                <div id="tab2" class="tab_content">
			<table class="tablesorter" cellspacing="0"> 
			<thead > 
				
				<tr align="center"> 
					<th align="center">Instructor Id</th> 
					<th align="center">First Name</th> 				
    				<th align="center">Last Name</th>
					   				 
					<th align="center">Available Date</th> 
					 <th align="center">Video Available Date</th>
					 <th align="center">Chat Available Date</th>
					 <th align="center">Instructor Start Time</th> 					 				 
    				<th align="center">Instructor End Time</th>								 
					 		 
    				
				</tr> 
				</thead> 
				<tbody id="txtHint" class="table-body" align="center">
                    <?php                  
                     
                            while($instructor=mysql_fetch_array($userresult))  //carry on looping through while there are records
                                {
                           
                                echo "<tr class='".$countrecord." show' > 
                            <td>".$instructor['instructor_id']."</td>
								<td>".$instructor['fname']."</td> 
								<td>".$instructor['lname']."</td>
                                   <td>".$instructor['available_date']."</td>
                                <td>".$instructor['video_available_date']."</td> 
                                <td>".$instructor['chat_available_date']."</td>                   			
		                        <td>".$instructor['instructor_start_time']."</td>
		                        <td>".$instructor['instructor_end_time']."</td>
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
