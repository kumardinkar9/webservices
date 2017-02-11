<?php

/* Project Name: Health Advice 
 * @Author: Bibhuti Ranjan 
 * Company : Funki Orange software solution PVT. LTD
 * Email:bibhuti.ranjan@funkitechnologies.com
 */
//header('Content-Type: application/json; Charset=UTF-8');
include "services.php";
$services_object = new Services(DB_HOST, DB_USER, DB_PASS, DB_NAME);

/*
 * {"action":"search vendors","category":"LogIn"}
 */

//error_reporting("E_ALL & ~E_NOTICE | ~E_DEPRECATED");

/* for social media user login 
  $_REQUESTSTR=array('task'=>'authentication',
  'social_user_id'=>'32',
  'user_name'=>'ranjan_bibhuti',
  'fname'=>'Ranjan',
  'lname'=>'Vibhuti',
  'email'=>'bibhuti@gmail.com',
  'gender'=>0,
  'login_type'=>'Twitter'); */
/* // Instructor login$_REQUESTSTR=array('task'=>'authentication',

  'instructor_user_name'=>'bibhuti',
  'instructor_password'=>'bibhuti',
  'login_type'=>'Instructors');
 * // Instructor signup
  $_REQUESTSTR=array('task'=>'instructors_signup',
  'instructor_user_name'=>'bibhuti_ranjan1',
  'instructor_email'=>'bibhuti123@gmail.com',
  'instructor_password'=>'bibhuti@gmail.com',
  'instructor_gender'=>0,
  'instructor_about'=>'It is a long established fact that a reader will be distracted by the readable c');
  // Forgot password
  $_REQUESTSTR=array('task'=>'instructor_forgot_password',
  'instructor_email'=>'bibhuti.ranjan@funkitechnologies.com');
  // For ask question
  $_REQUESTSTR=array('task'=>'store_question',
  'patient_id'=>'1',
  'question'=>'How do i loose weight?');
 * */


switch ($_REQUESTSTR["task"]) {

	//Check user authentication 
	case "authentication":
		$user_information = $_REQUESTSTR;
		$response_arr["response"] = $services_object->user_authentication($user_information);
		break;
	case "instructors_signup":
		$instructors_information = $_REQUESTSTR;
		$response_arr["response"] = $services_object->instructors_signup($instructors_information);
		break;
	case "instructor_forgot_password":
		$instructors_email = $_REQUESTSTR;
		$response_arr["response"] = $services_object->instructor_forgot_password($instructors_email);
		break;
	case "store_question":
		$store_question = $_REQUESTSTR;
		$response_arr["response"] = $services_object->store_question($store_question);
		break;
	case "give_answer":
		$give_answer = $_REQUESTSTR;
		$response_arr["response"] = $services_object->give_answer($give_answer);
		break;
	case "discussion_detail":
		$userid = $_REQUESTSTR;
		$response_arr["response"] = $services_object->discussion_detail($userid);
		break;

	case "instructors":		
		$response_arr["response"] = $services_object->instructors();
		break;
	case "instructor_details":
		$instructor_id = $_REQUESTSTR;
		$response_arr["response"] = $services_object->instructor_details_with_rating($instructor_id);
		break;
	case "update_instructor_profile":
		$instructor_profile_data = $_REQUESTSTR;
		$response_arr["response"] = $services_object->update_instructor_profile($instructor_profile_data);
		break;
	case "instructor_availability":
		$availability_info = $_REQUESTSTR;
		$response_arr["response"] = $services_object->instructor_availability($availability_info);
		break;
	case "booking":
		$booking_data = $_REQUESTSTR;
		$response_arr["response"] = $services_object->booking($booking_data);
		break;
	case "my_bookings":
		$user_id = $_REQUESTSTR;
		$response_arr["response"] = $services_object->my_bookings($user_id);
		break;
	
	case "rating":
		$rating_details = $_REQUESTSTR;
		$response_arr["response"] = $services_object->rating($rating_details);
		break;
	case "instructor_rating":
		$rating_details = $_REQUESTSTR;
		$response_arr["response"] = $services_object->instructor_rating($rating_details);
		break;
	
	case "purchase_user_token":
		$token_details = $_REQUESTSTR;
		$response_arr["response"] = $services_object->purchase_user_token($token_details);
		break;
	case "check_user_token":
		$user_token_data = $_REQUESTSTR;
		$response_arr["response"] = $services_object->check_user_token($user_token_data);
		break;
	case "update_token_after_chat":
		$chat_details = $_REQUESTSTR;
		$response_arr["response"] = $services_object->update_token_after_chat($chat_details);
		break;
	case "input_weight_details":
		$input_weight_data = $_REQUESTSTR;
		$response_arr["response"] = $services_object->input_weight_details($input_weight_data);
		break;
	case "get_token_value":
		$user_id = $_REQUESTSTR;
		$response_arr["response"] = $services_object->get_token_value($user_id);
		break;
	case "change_password":
		$pass_information = $_REQUESTSTR;
		$response_arr["response"] = $services_object->change_password($pass_information);
		break;
	case "my_tracking":
		$tracking_user = $_REQUESTSTR;
		$response_arr["response"] = $services_object->my_tracking($tracking_user);
		break;
	case "my_tracking_deatails":
		$tracking_user = $_REQUESTSTR;
		$response_arr["response"] = $services_object->my_tracking_deatails($tracking_user);
		break;
	
	case "user_details_by_userid":
		$user_information = $_REQUESTSTR;
		$response_arr["response"] = $services_object->user_details_by_userid($user_information);
		break;
	case "instructors_available_date":
		$available_dates = $_REQUESTSTR;
		$response_arr["response"] = $services_object->instructors_available_date($available_dates);
		break;
	case "discussion_detail_for_instructor":
		//$userid = $_REQUESTSTR;
		$response_arr["response"] = $services_object->discussion_detail_for_instructor();
		break;
	case "user_information_update":
		$user_details = $_REQUESTSTR;
		$response_arr["response"] = $services_object->user_information_update($user_details);
		break;
	
	case "instructor_my_bookings":
		$user_details = $_REQUESTSTR;
		$response_arr["response"] = $services_object->instructor_my_bookings($user_details);
		break;
	case "available_date_user_details":
		$user_details = $_REQUESTSTR;
		$response_arr["response"] = $services_object->available_date_user_details($user_details);
		break;
	case "instructors_available_date_time":
		$available_times = $_REQUESTSTR;
		$response_arr["response"] = $services_object->instructors_available_date_time($available_times);
		break;		
	case "instructor_availability_store":
		$availability_info = $_REQUESTSTR;
		$response_arr["response"] = $services_object->instructor_availability_store($availability_info);
		break;		
	case "return_user_token":
		$token = $_REQUESTSTR;
		$response_arr["response"] = $services_object->return_user_token($token);
		break;	
	default:
		$response_arr["error"] = "No task found";
		break;
}


if ($response_arr["task"] == "") {
	unset($response_arr["task"]);
}
//$_REQUESTSTR = json_decode($_REQUEST['jsondata'], TRUE);
//print_r($response_arr);
$raw_json = json_encode($response_arr);

echo $raw_json;
