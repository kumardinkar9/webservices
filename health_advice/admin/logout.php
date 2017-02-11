<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
session_start();
if($_SESSION['current_user'] != ""){
   if(session_destroy() == TRUE){
    header('location:index.php');
    exit();
   }
}
?>
