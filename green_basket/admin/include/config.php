<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
error_reporting(1);
session_start();
/*local server*/
$myServer = "localhost";
$myUser = "root";
$myPass = "root";
$myDB = "green_basket";

/*funkiorange server 
ob_start();
session_start();
$myServer = "localhost";
$myUser = "funkiora_greenba";
$myPass = "f.xgq!Z)P3la";
$myDB = "funkiora_green_basket";   */
$base_url="http://www.funkiorange.com/GreenBasket/";
ini_set('date.timezone', 'Asia/Kolkata');
$connect    = mysql_connect($myServer,$myUser,$myPass);
if($connect){    
$db= mysql_select_db($myDB,$connect);
}
 else {
  echo 'Server not connect';    
}
?>
