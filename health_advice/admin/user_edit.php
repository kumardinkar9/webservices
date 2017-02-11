<?php
define('PAGENAME', 'usereditpage', true);
include('config.php');  // require or include, config.php from include folder
include('header.php');   // require or include, header.php from include folder
$user_id  =   $_REQUEST['user_id'];   

 $selectquery = mysql_query("select fname,lname,Instructor_email,Instructor_phone_number,Instructor_about,skills,video_call_price,one_two_one_chat_price,group_chat_price,earn_token,headline FROM user_instructors where instructor_id=$user_id");
$userdetails=mysql_fetch_array($selectquery);  //carry on looping through while there are records
       
		$userfname=$userdetails['fname'];
		$userlname=$userdetails['lname'];
		$useremail=$userdetails['Instructor_email'];
		$userphone=$userdetails['Instructor_phone_number'];
		$userabout=$userdetails['Instructor_about'];
		$userskills=$userdetails['skills'];
		$uservideocallprice=$userdetails['video_call_price'];
		$userchatprice=$userdetails['one_two_one_chat_price'];
		$usergroupchatprice=$userdetails['group_chat_price'];
		$userearntoken=$userdetails['earn_token'];
		$userheadline=$userdetails['headline'];
		
	
		
if(isset($_POST['save'])){    
    //print_r($_POST);
        $fname=$_POST['fname'];
		$lname=$_POST['lname'];
		$email=$_POST['email'];
		$phone=$_POST['phone_number'];
		$about=$_POST['about'];
		$skills=$_POST['skills'];
		$videocall=$_POST['videocall'];
		$onetwoonechat=$_POST['onetwoone'];
		$groupchat=$_POST['groupchat'];
		$earntoken=$_POST['earntoken'];
		$headline=$_POST['headline'];
		
		
		
		
      $updatequery  =   "update user_instructors set fname='".$fname."',lname='".$lname."',Instructor_email='".$email."',Instructor_phone_number='".$phone."',Instructor_about='".$about."',skills='".$skills."',video_call_price='".$videocall."',one_two_one_chat_price='".$onetwoonechat."',group_chat_price='".$groupchat."',earn_token='".$earntoken."',headline='".$headline."' where instructor_id=$user_id";
    if (mysql_query($updatequery))
	{
		
			header('location:user_instructors.php');
				exit();
		}else
		{
    $errormsg   =   "Updation error! Please try again!";    
    
    }
}
if(isset($_POST['cancel'])){
        header('location:user_instructors.php');
		 exit();
}
?>
<script type="text/javascript" src="js/jquery-form.validate.js"></script>

<section id="main" class="column" style="width:100%">
		
		<h4 class="alert_info">Welcome to the Family Health Panel </h4>
		
		<article class="module width_3_quarter">
		<header><h3 class="tabs_involved">EDIT USER INSTRUCTION</h3>
		
		</header>

		<div class="tab_container">
			<div id="tab1" class="tab_content">
                            <form method="POST" name="user_edit.php" action="<?php $_SERVER['PHP_SELF']; ?>" >
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
   				<td><label for="fname">First Name:</label></td> 
    				<td><input type="text" name="fname" value="<?php echo $userfname ;?>"></td>     				
				</tr>
			</tbody> 
			<tbody> 
				<tr> 
                                <td><label for="lname">Last Name:</label></td> 
    				<td><input type="text" name="lname" value="<?php echo $userlname;?>"></td>     				
				</tr>
			</tbody> 
			<tbody> 
				<tr> 
   					<td><label for="Email Address">Email Address:</label></td> 
    				<td><input type="text" name="email" value="<?php echo $useremail;?>"></td>     				
				</tr>
			</tbody> 
			<tbody> 
				<tr> 
   				<td><label for="mobile">Phone No.:</label></td> 
    				<td><input type="text" name="phone_number" value="<?php echo $userphone;?>"></td>     				
				</tr>
			</tbody> 
			<tbody> 
                        <tr> 
                        <td><label for="City">About :</label></td> 
                        <td><input type="text" name="about"  value="<?php echo $userabout;?>"></td>
                        </tr>
			</tbody>
			<tbody> 
                        <tr> 
                        <td><label for="City">Skills :</label></td> 
                        <td><input type="text" name="skills"  value="<?php echo $userskills;?>"></td>
                        </tr>
			</tbody>
			<tbody> 
                        <tr> 
                        <td><label for="City">Video Call Price :</label></td> 
                        <td><input type="text" name="videocall"  value="<?php echo $uservideocallprice;?>"></td>
                        </tr>
			</tbody>
			<tbody> 
                        <tr> 
                        <td><label for="City">One two one chat price :</label></td> 
                        <td><input type="text" name="onetwoone"  value="<?php echo $userchatprice;?>"></td>
                        </tr>
			</tbody>
			<tbody> 
                        <tr> 
                        <td><label for="City">Group chat price :</label></td> 
                        <td><input type="text" name="groupchat"  value="<?php echo $usergroupchatprice;?>"></td>
                        </tr>
			</tbody>
			<tbody> 
                        <tr> 
                        <td><label for="City">Earn token :</label></td> 
                        <td><input type="text" name="earntoken"  value="<?php echo $userearntoken;?>"></td>
                        </tr>
			</tbody>
			<tbody> 
                        <tr> 
                        <td><label for="City">Headline :</label></td> 
                        <td><input type="text" name="headline"  value="<?php echo $userheadline;?>"></td>
                        </tr>
			</tbody>
			<tbody> 
                        
			</tbody>
			
			
			<tbody> 
			<tr>
				<td align="center" colspan="2"><input type="submit" name="save" value="Update"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
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
