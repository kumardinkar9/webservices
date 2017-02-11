<?php
include('config.php'); 

if($_SESSION['current_user'] != ""){  
    header('location:user_instructors.php');
    exit();
}
	
$storevale = array();
if(isset($_POST['LoginUser'])){
$UserName	=	$_POST['username'];
$Password	=	md5($_POST['password']);
if($UserName ==""){
	$errormsg	=	"Please enter username.";
}
elseif($Password == ""){
	$errormsg	=	"Please enter password.";
}
else{	
    $sql="SELECT COUNT(*) AS `isexits` from admin_user where admin_username='" . $UserName . "' AND admin_password='" . $Password . "'";
			$execute_query=mysql_query($sql);
			while($row = mysql_fetch_array($execute_query)){
				$isexits=$row['isexits'];
				}			
		if ($isexits > 0) {			
       $_SESSION['current_user'] =  $UserName; 
            if($_SESSION['current_user'] != ""){           
           header('location:user_instructors.php');
           echo "successful";
           exit();
       }
       else{           
           $errormsg    =   "Worng entry";
       }
    }
    else{
       $errormsg    =   "Username or password doesnot match.";     
    }   
}
}
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8"/>
	<title>Dashboard I Admin Panel</title>	
	<link rel="stylesheet" href="css/layout.css" type="text/css" media="screen" />
	<script src="js/jquery-1.5.2.min.js" type="text/javascript"></script>
	<script src="js/hideshow.js" type="text/javascript"></script>
	<script src="js/jquery.tablesorter.min.js" type="text/javascript"></script>
	<script type="text/javascript" src="js/jquery.equalHeight.js"></script>
	<script type="text/javascript" src="js/jquery-form.validate.js"></script>
	</head>
<body>
	<header id="header">
		<hgroup>
			<h1 class="site_title"><a href="index.php"><img src="images/logo.png"><span>FHA</span></a></h1>
				</hgroup><!-- end of hgroup -->	
	</header> <!-- end of header bar -->	
	<section id="main" class="column">
		<div class="clear"></div>
			</div>
		</article><!-- end of stats article -->		
		<article class="module width_3_quarter" style="margin: 170px 167px 0px 30px;">
		<header><h3 class="tabs_involved">Admin Login</h3>
		</header><!-- end of #tabs_involved -->		
		<div class="tab_container">
			<div id="tab1" class="tab_content">
				<form method="POST" name="adminlogin" action="<?php $_SERVER['PHP_SELF']; ?>" id="adminlogin"> 
			<table class="tablesorter" cellspacing="0">			
			<tbody >
				<?php
			if($errormsg != ""){
			echo '<tr>
				<td colspan="2" align="center" style="color:red;">'.$errormsg.'</td>
				</tr>';
			}
			?>		
                  		<tr>
							<td>UserName:</td>
							<td><input type="text" name="username"></td>
                  		</tr>	
			</tbody> 
			<tbody >
                  		<tr>
							<td>Password:</td>
							<td><input type="password" name="password"></td>
                  		</tr>	
			</tbody> 
			<tbody >
                  		<tr>
							<td colspan="2" align="center"><a href="forgot_password.php" style="text-decoration:underline; font-size:25px;">forgot password?</a></td>
							
                  		</tr>	
			</tbody>
			   
			<tbody >
                  		<tr>
							<td colspan="2" align="center"><input type="submit" value="Login" title="Submit" name="LoginUser" style="width: 210px !important;margin: 0px 138px;"></td>
							
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
