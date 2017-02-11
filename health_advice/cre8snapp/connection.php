<?php

$video_con = mysql_connect('localhost','root','root');
if($video_con){
	
	mysql_select_db('Cre8snapp_db',$video_con);
}
else{
	die(mysql_error());
}