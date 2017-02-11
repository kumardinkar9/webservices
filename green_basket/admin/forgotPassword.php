<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
define('PAGENAME', 'forgotPassword', true);
require_once 'include/config.php';  // require or include, config.php from include folder
require_once 'include/headerForgotPassword.php';  // require or include, headerForgotPassword.php from include folder
$email=$_POST['email'];
if($_POST['submit']){
	if($_POST['email'] == ""){
		 $errormsg="Please provide me email address";
		}else{
			$result=mysql_query("select normal_password from admin_user where admin_email='" . $email . "'");
			while($row = mysql_fetch_array($result)) {
				  $password=$row['normal_password'];
				}
				if($password != ""){
				$message = 'Hello ,
                                <br /><br /> 
                                As per your request, password your green basket Account. Please use the password
                                as given below to login to your account.
                                <br /><br />  
                                Password: <strong>' . $password . '</strong><br />
                                <br />
                                Please keep these password safe.<br /> 
                                You will need your password to re-login to your green basket account. 
                                <br /><br />  
                                Thank you,<br />' .
								__REGARDS_FROM;
				$mail_data = array(
					"to" => $email,
					"from" => "info@greenbasket.com",
					"subject" => "Green Basket Admin Password",
					"message" => $message
				);				
				if (sendMail($mail_data)) {					
					$success_msg = "Your password has been send your email address, Please check";
				} 
			}else{
					$errormsg = "Invalid email address";
				}
			}   
}
		function sendMail($ml_data) {
		$headersq = 'MIME-Version: 1.0' . "\n";
		$headersq .= 'Content-Type: text/html; charset=ISO-8859-1' . "\n";
		$headersq .= 'From: ' . $ml_data["from"] . "\n";
		if (isset($ml_data["reply_to"]) && ($ml_data["reply_to"] != ""))
			$headersq .= 'Reply-To: ' . $ml_data["reply_to"] . "\n";
		if (isset($ml_data["cc"]) && ($ml_data["cc"] != ""))
			$headersq .= 'Cc: ' . $ml_data["cc"] . "\n";
		if (isset($ml_data["bcc"]) && ($ml_data["bcc"] != ""))
			$headersq .= 'Bcc: ' . $ml_data["bcc"] . "\n";
		$to = $ml_data["to"];
		$subject = $ml_data["subject"];
		$msg = '<html><head><title>' . $subject . '</title></head><body>' . $ml_data["message"] . '</body></html>';

		if (mail($to, $subject, $msg, $headersq))
			return "success";
		else
			return "failed";
	}
?>
<section id="main" class="column" style="width:100%">		
		<h4 class="alert_info">Welcome to the GreenBasket admin panel </h4>		
		<article class="module width_3_quarter" style="width: 50%;margin: 0px 395px;float:left;">
		<header><h3 class="tabs_involved">Forgot Password</h3>		
		</header> <!-- end of .tabs_involved -->                                             
		<div class="tab_container">
			<div id="tab1" class="tab_content">
                     <form method="POST" name="blockuser" action="<?php $_SERVER['PHP_SELF']; ?>" id="blockuser">                                   
			<table class="tablesorter" cellspacing="0"> 
				<tbody>
			<?php
			if($errormsg != ""){
			echo '<tr>
				<td colspan="2" align="center" style="color:red;">'.$errormsg.'</td>
				</tr>';
			}
			if($success_msg != ""){
			echo '<tr>
				<td colspan="2" align="center" style="color:green;">'.$success_msg.'</td>
				</tr>';
			}
			?>			
			<tbody> 
				<tr> 
   					<td><label for="name">Email Address</label></td> 
    				<td><label for="name"><input type="text" name="email"></label></td> 
				</tr>
			</tbody> 
			<tbody> 
				<tr> 
   					<td colspan="2" align="center"><input id="forgot-password-button" type="submit" name="submit" value="Submit">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="./index.php" style="text-decoration:underline; font-size:20px;">click here for LogOn</a></td> 
    				</tr>
			</tbody> 		
			</table><!-- end of table -->                                             
                     </form><!-- end of form -->                                             
			</div><!-- end of #tab1 -->			
		</div><!-- end of .tab_container -->		
		</article><!-- end of content manager article -->		
		<div class="clear"></div>		
		<div class="spacer"></div>
	</section><!-- end of section -->                                             
</body>
</html>
