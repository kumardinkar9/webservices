<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'config.php';
if($_SESSION['current_user'] == ""){  
    header('location:index.php');
    exit();
}
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8"/>
	<title>Dashboard I Admin Panel</title>	
	<link rel="stylesheet" href="css/layout.css" type="text/css" media="screen" />
	<script type="text/javascript" src="js/jquery.equalHeight.js"></script>	
    <link href="css/jquery-ui-1.9.2.custom.min.css" rel="stylesheet" type="text/css" />
    <!-- add scripts -->
    <script src="js/jquery.191.js"></script>
    <script src="js/jquery-ui-1.9.2.custom.min.js"></script>
	
</head>
<body>
	<header id="header">
		<hgroup>
			<h1 class="site_title"><a href="index.php"><img src="images/logo.png"><span>GreenBasket</span></a></h1>
			<h2 class="section_title"></h2>
		</hgroup>
	</header> <!-- end of header bar -->	
	<section id="secondary_bar">
		<div class="user">		
			<!-- <a class="logout_user" href="#" title="Logout">Logout</a> -->
		</div>
		<div class="breadcrumbs_container">
		<ul class="tabs">
                        <li <?php if(PAGENAME == 'viewvendorpage'){ echo 'class="active"'; } ?>><a href="viewvendor.php">Vendor Details</a></li>
                        <li <?php if(PAGENAME == 'itemDetailspage'){ echo 'class="active"'; } ?>><a href="itemDetails.php">Item Details</a></li>
                        <li <?php if(PAGENAME == 'cityareapage'){ echo 'class="active"'; } ?>><a href="cityarea.php">Cities and Areas</a></li>  
                        <li <?php if(PAGENAME == 'termsConditionpage'){ echo 'class="active"'; } ?>><a href="termsCondition.php">Terms & Conditions</a></li>                         
                        <li><a href="logout.php">Logout</a></li>
		</ul>
			<!-- <article class="breadcrumbs"><a href="index.html">Website Admin</a> <div class="breadcrumb_divider"></div> <a class="current">Dashboard</a></article> -->
		</div>
	</section><!-- end of secondary bar -->
	

