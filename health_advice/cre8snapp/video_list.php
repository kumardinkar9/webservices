<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require 'connection.php';

function video_list() {
	$res["error"] = "";
	$res["success"] = "false";
	$video_sql = "select video_upload_id,total_value/total_votes as rating,user_email,video_url,uploading_date_time from video_sharing";
	$execute = mysql_query($video_sql);
	if (mysql_num_rows($execute) > 0) {
		$dataset = array();
		$i = 0;
		while ($ds_ = mysql_fetch_object($execute)) {

			$dataset[$i++] = $ds_;
		}
		//print_r($dataset);
		$res["video_list"] = $dataset;
		$res["success"] = "true";
	} else {
		$res["error"] = "No any video";
	}
	return $res;
}

function update_rating($video_rate_details) {
	
	$res["error"] = "";
	$res["success"] = "false";
	$count = mysql_query("SELECT count(*) as isvoted  FROM video_sharing where video_upload_id ='" . $video_rate_details['video_id'] . "' AND user_device_id LIKE '%".$video_rate_details['device_id']."%' ") or die(" Error: " . mysql_error());
	$count_result = mysql_fetch_object($count);
	if($count_result->isvoted == 1){
		$res["error"] = "Already voted for this item";
	}
	
	 else {
		 $query = mysql_query("SELECT total_votes, total_value,user_device_id FROM video_sharing where video_upload_id ='" . $video_rate_details['video_id'] . "'") or die(" Error: " . mysql_error());
		$result = mysql_fetch_object($query);
		$total_votes = $result->total_votes;
		$current_rating = $result->total_value;
		if($user_device_id = $result->user_device_id == ""){
			$user_device = $video_rate_details['device_id'];
		}
		else{
			$user_device = $result->user_device_id.','.$video_rate_details['device_id'];
		}
		$user_device_id = $result->user_device_id;	
		$total_noof_vote = $total_votes + 1;
		$total_rating = $video_rate_details['sent_vote'] + $current_rating; // add together the current vote value and the total vote value
		$update_rate = "update video_sharing set total_votes='" . $total_noof_vote . "',total_value='" . $total_rating . "',user_device_id='".$user_device."' where video_upload_id ='" . $video_rate_details['video_id'] . "'";
		$execute_sql = mysql_query($update_rate);
		if ($execute_sql) {

			$res["success"] = "true";
		} else {
			$res["error"] = "Rating not updated";
		}
	}

	return $res;
}



if ($_REQUEST['video_id'] != "") {
	
	$response_arr["response"] = update_rating($_REQUEST);
} else {
	$response_arr["response"] = video_list();
}

echo json_encode($response_arr);
