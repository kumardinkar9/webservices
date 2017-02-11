<?php

$video_con = mysql_connect('localhost','funkiora_health','LgG6K&~&yR;T');
if($video_con){
	
	mysql_select_db('funkiora_health_advice',$video_con);
}
else{
	die(mysql_error());
}