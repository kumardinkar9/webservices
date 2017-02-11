<?php

/* Project Name: Health Advice 
 * @Author: 
 * Company : Funki Orange software solution PVT. LTD
 * Email:
 * File Name: services
 */
error_reporting(1);
@session_start();
define("__HOST", $_SERVER['HTTP_HOST']);
define("__ROOT", rtrim($_SERVER['DOCUMENT_ROOT'], "/"));
define("__REGARDS_FROM", "Family Health Team.");
define("__SUPPORT_EMAIL", "Family Health  Support <info@familyhealth.com>");
define("GOOGLE_API_KEY", "AIzaSyC8Dm6hj7lZ--EpKmP3pxofpweKDZ4z_PE");
ini_set("post_max_size", "30M");
ini_set("upload_max_filesize", "30M");
ini_set("memory_limit", -1);

//ini_set("log_errors", "On");
//ini_set("error_log", __ROOT_DIR . "error.log");

ini_set('date.timezone', 'Asia/Kolkata');

//ini_set("max_execution_time", 1800);
set_time_limit(7200);
//ini_set("error_reporting", "E_ALL & ~E_NOTICE | ~E_DEPRECATED");

if (__HOST == "localhost") {

	//http://localhost/health-advice
	//ini_set("display_errors", 0);

	define("DB_HOST", "localhost");
	define("DB_USER", "root");
	define("DB_PASS", "root");
	define("DB_NAME", "health_advice");
	define("FOLDER_NAME", "health-advice");
	define("FOLDER_URL", "http://" . __HOST . "/" . FOLDER_NAME . "/");
	define("__ROOT_DIR", __ROOT . "/" . FOLDER_NAME . "/");

	define("__MODE", "testing");
} else {

	//ini_set("display_errors", 0);

	define("DB_HOST", "localhost");
	define("DB_USER", "funkiora_health");
	define("DB_PASS", "b7U+Otoh^0nf");
	define("DB_NAME", "funkiora_health_advice");
	define("FOLDER_NAME", "health_advice");
	define("FOLDER_URL", "http://" . __HOST . "/" . FOLDER_NAME . "/");
	define("__ROOT_DIR", __ROOT . "/" . FOLDER_NAME . "/");

	define("__MODE", "testing");
}
/* $_POST['requestStr'] = $_REQUEST;
  if(is_array($_POST['requestStr'])){
  $_POST['requestStr'] = stripslashes(json_encode($_POST['requestStr']));
  }

  $_REQUESTSTR = json_decode($_POST['requestStr'], TRUE);
 */
header('Content-Type: application/json');
//print_r($_REQUEST);
if ($_POST['jsondata'] == "") {
	$_POST['requestStr'] = $_REQUEST;
	//print_r($_REQUEST['requestStr']);
	$_POST['requestStr'] = stripslashes(json_encode($_POST['requestStr']));
	$_REQUESTSTR = json_decode($_POST['requestStr'], TRUE);
} else {
	$_REQUESTSTR = json_decode($_POST['jsondata'], TRUE);
}

/* echo "POST DATA : \n----------------------------------\n";
  print_r($_REQUESTSTR);
  echo "\n----------------------------------\n";

  die; */

require_once "class/class.db.php";

class Services extends DB {

	function construct() {
		parent::__construct();
	}

	// Check user authantication 

	function user_authentication($user_information) {
		$res["error"] = "";
		$res["success"] = "false";
		if ($user_information["login_type"] == 'Facebook' || $user_information["login_type"] == 'Google Plus') {
			//echo $user_information['login_type'];
			$authentication_sql = "SELECT COUNT(*) AS `isexits`, `user_id` FROM `social_media_login_user` WHERE `email` = '" . $user_information["email"] . "' AND `login_type` = '" . $user_information["login_type"] . "'";
			$execute_query = $this->query($authentication_sql);
			if ($execute_query[0]->isexits == 1) {
				foreach ($execute_query as $key => $user_index) {
					$user_id = $user_index->user_id;
				}
				$res["userdetails"] = $this->get_user_details($user_id);
				/* $sql="select user_id, social_user_id, user_name, fname, lname, email, device_id, gender, login_type, profile_image_url FROM social_media_login_user WHERE email = '" . $user_information["email"] . "' AND login_type = '" . $user_information["login_type"] . "'";
				  $result = $this->query($sql);
				  $res["userdetails"] = $result; */
				$res["success"] = "true";
			} else {

				$user_details_array = array(
					'social_user_id' => $user_information['social_user_id'],
					'user_name' => $user_information['user_name'],
					'fname' => $user_information['fname'],
					'lname' => $user_information['lname'],
					'email' => $user_information['email'],
					'gender' => $user_information['gender'],
					'login_type' => $user_information['login_type'],
					'device_token' => $user_information['device_token'],
					'registration_id' => $user_information['registration_id'],
					'profile_image_url' => $user_information['profile_image_url'],
					'device_id' => $user_information['device_id'],
					'login_date_time' => date("Y-m-d H:i:s")
				);
				if ($this->insert("social_media_login_user", $user_details_array)) {
					$user_id = $this->last_insert_id();
					$res["userdetails"] = $this->get_user_details($user_id);
					$res["success"] = "true";
					// To insert data in gcm_users table for android team
					/*$gcm_data=array(
					'name' => $user_information['fname'],
					'email' => $user_information['email'],
					'gcm_regid' => $user_information['registration_id'],
					'created_at' => date("Y-m-d H:i:s")
					);
					$this->insert("gcm_users", $gcm_data);*/
					/* $sql="select user_id, social_user_id, user_name, fname, lname, email, gender, login_type, device_id, profile_image_url FROM social_media_login_user WHERE email = '" . $user_information["email"] . "' AND login_type = '" . $user_information["login_type"] . "'";
					  $result = $this->query($sql);
					  $res["userdetails"] = $result; */
					
				}
			}
		} elseif ($user_information["login_type"] == 'Twitter') {
			$authentication_sql = "SELECT COUNT(*) AS `isexits`, `user_id` FROM `social_media_login_user` WHERE `user_name` = '" . $user_information["user_name"] . "' AND `login_type` = '" . $user_information["login_type"] . "'";
			$execute_query = $this->query($authentication_sql);
			if ($execute_query[0]->isexits == 1) {
				foreach ($execute_query as $key => $user_index) {
					$user_id = $user_index->user_id;
				}
				$res["userdetails"] = $this->get_user_details($user_id);
				/* $sql="select user_id, social_user_id, user_name, fname, lname, email, gender, login_type, device_id, profile_image_url FROM social_media_login_user WHERE user_name = '" . $user_information["user_name"] . "' AND login_type = '" . $user_information["login_type"] . "'";
				  $result = $this->query($sql);
				  $res["userdetails"] = $result; */
				$res["userdetails"] = $this->get_user_details($user_id);
				$res["success"] = "true";
			} else {

				$user_details_array = array(
					'social_user_id' => $user_information['social_user_id'],
					'user_name' => $user_information['user_name'],
					'fname' => $user_information['fname'],
					'lname' => $user_information['lname'],
					'email' => $user_information['email'],
					'gender' => $user_information['gender'],
					'login_type' => $user_information['login_type'],
					'profile_image_url' => $user_information['profile_image_url'],
					'device_token' => $user_information['device_token'],
					'registration_id' => $user_information['registration_id'],
					'device_id' => $user_information['device_id'],
					'login_date_time' => date("Y-m-d H:i:s")
				);
				if ($this->insert("social_media_login_user", $user_details_array)) {
					$user_id = $this->last_insert_id();
					$res["userdetails"] = $this->get_user_details($user_id);
					$res["success"] = "true";
					// To insert data in gcm_users table for android team
					/*$gcm_data=array(
					'name' => $user_information['fname'],
					'email' => $user_information['user_name'],
					'gcm_regid' => $user_information['registration_id'],
					'created_at' => date("Y-m-d H:i:s")
					);
					$this->insert("gcm_users", $gcm_data);*/
					/* 	$sql="select user_id, social_user_id, user_name, fname, lname, email, gender, login_type, device_id, profile_image_url FROM social_media_login_user WHERE user_name = '" . $user_information["user_name"] . "' AND login_type = '" . $user_information["login_type"] . "'";
					  $result = $this->query($sql);
					  $res["userdetails"] = $result; */
					
				}
			}
		}
		/// Checking authntication for instructor
		else if ($user_information["login_type"] == 'Instructors') {
			$authentication_sql = "SELECT COUNT(*) AS `isexits`, `instructor_id` FROM `user_instructors` WHERE `instructor_email` = '" . $user_information["instructor_email"] . "' AND `instructor_approve_status` = 1 AND `instructor_password` = '" . MD5($user_information["instructor_password"]) . "'";
			$execute_query = $this->query($authentication_sql);
			if ($execute_query[0]->isexits == 1) {
				$res["userdetails"] = $this->get_instructorsr_details($execute_query[0]->instructor_id);
				$res["success"] = "true";
			} else {
				$res["error"] = "Invalid Email Id or password";
			}
		} else {
			$res["error"] = "Please provide require data for authentication";
		}
		return $res;
	}

	// Instructors signup 

	function instructors_signup($instructors_signup_data) {

		$res["error"] = "";
		$res["success"] = "false";
		if ($instructors_signup_data['instructor_email'] == "") {

			$res["error"] = "Please provide email address";
		} /* else {
		  // Check username for instructor
		  $check_username_sql = "SELECT COUNT(*) AS `isexits_username`, `instructor_id` FROM `user_instructors` WHERE `instructor_user_name` = '" . $instructors_signup_data["instructor_user_name"] . "'";
		  $execute_query = $this->query($check_username_sql);
		  if ($execute_query[0]->isexits_username == 1) {
		  $res["error"] = "Username already exits";
		  } */ else {
			// Check email address for instructor
			$check_email_sql = "SELECT COUNT(*) AS `isexits_email`, `instructor_id` FROM `user_instructors` WHERE `instructor_email` = '" . $instructors_signup_data["instructor_email"] . "'";
			$execute_query = $this->query($check_email_sql);
			if ($execute_query[0]->isexits_email == 1) {
				$res["error"] = "Email address already exist";
			} else {
				$data = array('fname' => mysql_real_escape_string($instructors_signup_data['fname']),
					'lname' => mysql_real_escape_string($instructors_signup_data['lname']),
					'instructor_password' => MD5($instructors_signup_data['instructor_password']),
					'instructor_email' => $instructors_signup_data['instructor_email'],
					'instructor_gender' => $instructors_signup_data['instructor_gender'],
					'skills' => $instructors_signup_data['skills'],
					'instructor_phone_number' => $instructors_signup_data['instructor_phone_number'],
					'instructor_registraton_date_time' => date("Y-m-d H:i:s"),
					'device_token' => $instructors_signup_data['device_token'],
					'registration_id' => $instructors_signup_data['registration_id'],
					'instructor_approve_status' => 0);

				if ($this->insert(user_instructors, $data)) {
					$user_id = $this->last_insert_id();
					$data_gcm=array('gcm_regid' => $instructors_signup_data['registration_id'],
							'user_id' => $user_id,
							'email' => $instructors_signup_data['instructor_email'],
					'name' => $instructors_signup_data['fname'],
					'created_at' => date("Y-m-d H:i:s"));
					$this->insert(gcm_users, $data_gcm);
					$res["success"] = "true";
				} else {
					$res["error"] = "instructor information not store in database";
				}
			}
		}

		return $res;
	}

	//Instructor forgot password


	function instructor_forgot_password($instructor_email) {

		if ($instructor_email['instructor_email'] == "") {
			$res["error"] = "Please provide email address";
		} else {
			$check_email_sql = "SELECT COUNT(*) AS `isexits_email`, `instructor_id`,`instructor_user_name` FROM `user_instructors` WHERE `instructor_email` = '" . $instructor_email["instructor_email"] . "'";
			$execute_query = $this->query($check_email_sql);
			if ($execute_query[0]->isexits_email == 1) {
				$random_pass = $this->creater_random_pass();
				if ($this->update("user_instructors", array("instructor_password" => md5($random_pass)), "`instructor_id` = " . $execute_query[0]->instructor_id))
					$message = 'Hello ' . $execute_query[0]->instructor_user_name . ',
									<br /><br /> 
									As per your request, password has been changed for your Family Health Account. Please use the new password
									as given below to login to your account.
									<br /><br />  
									Password: <strong>' . $random_pass . '</strong><br />
									<br />
									Please keep these password safe.<br /> 
									You will need your password to re-login .
									<br /><br />  
									Thank you,<br />' .
							__REGARDS_FROM;

				//echo $message;
				$mail_data = array(
					"to" => $instructor_email["instructor_email"],
					//"to" => "ian@carronmedia.com",
					//"bcc" => __PASSWORD_EMAIL,
					"from" => __SUPPORT_EMAIL,
					"subject" => "New Password for Family Health",
					"message" => $message
				);
				if ($this->send_mail($mail_data) == "success") {
					$res["success"] = "true";
				}
			} else {
				$res["error"] = "Email address does n't exit";
			}
		}
		return $res;
	}

// User ask question and store in db
	function store_question($question_information) {

		$res["error"] = "";
		$res["success"] = "false";
		if ($question_information['patient_id'] == "") {
			$res["error"] = "Please provide user id";
		} else {
			$question_array = array(
				'patient_id' => $question_information['patient_id'],
				'question' => mysql_real_escape_string($question_information['question']),
				'question_description' => mysql_real_escape_string($question_information['question_description']),
				'question_post_date_time' => date("Y-m-d H:i:s")
			);
			if ($this->insert('questions', $question_array)) {
				$select_token = "select device_token, registration_id from user_instructors where instructor_approve_status=1";
				$token_result = $this->query($select_token);
				foreach ($token_result as $key => $token_number) {
					$message = 'New question has been posted';
					// $this->sendiphonePush($token_number->device_token, $message);							
					/*if($token_number->device_token==""){
						$res['push_message'] = $this->sendandroidPush($token_number->registration_id, $message);
						}else{
						$res['push_message'] = $this->sendiphonePush($token_number->device_token, $message);							
							}*/
				}
				$res["success"] = "true";
			} else {
				$res["error"] = "Question information not store in database";
			}
		}
		return $res;
	}

	// Instructors give the answer

	function give_answer($answer_details) {
		$res["error"] = "";
		$res["success"] = "false";

		if ($answer_details['posted_question_id'] == "" || $answer_details['suggested_instructor_id'] == "") {
			$res["error"] = "Please provide all information";
		} else {
			$answer_array = array('posted_question_id' => $answer_details['posted_question_id'],
				'suggested_instructor_id' => $answer_details['suggested_instructor_id'],
				'question_post_patient_id' => $answer_details['question_post_patient_id'],
				'answer' => mysql_real_escape_string($answer_details['answer']),
				'post_date_time' => date("Y-m-d H:i:s"));
			if ($this->insert('answers', $answer_array)) {
				$res["success"] = "true";
			} else {
				$res["error"] = "Answer not store in database";
			}
		}
		return $res;
	}

	//    Get discustion information 
	function discussion_detail($userid) {
		$res["error"] = "";
		$res["success"] = "false";
		if ($userid['user_id'] == "") {

			$res["error"] = "Please provide user id";
		} else {
			$sql = "select  q.`question`,q.`question_description`,q.`question_id`,q.`patient_id`,q.`question_status` as recent_activity,q.`question_post_date_time` as all_answer "
					. "from questions q "; // where q.`patient_id`='" . $userid['user_id'] . "'
			$result_question = $this->query($sql);
			//print_r($result_question);
			foreach ($result_question as $index => $question_indix) {
				$question_id = $question_indix->question_id;
				$recent_activity_date = $question_indix->all_answer;
				$answer = "select  ans.`posted_question_id`,ans.`post_date_time`,ans.`suggested_instructor_id`,ans.`answer`,ans.`answer_id`,d.`fname`,d.`lname`,d.`instructor_profile_pic`,d.`instructor_id` as rating ,d.`headline` from answers ans "
						. "left join user_instructors d on d.`instructor_id` = ans.`suggested_instructor_id` where ans.`posted_question_id`='$question_id'";
				$answer_result = $this->query($answer);
				//print_r($answer_result);
				$result_question[$index]->all_answer = $answer_result;
				//print_r($result_answer);
				foreach ($answer_result as $key => $answer_index) {
					$posted_question_id = $answer_index->posted_question_id;
					$recent_answer_date = $answer_index->post_date_time;
					if ($recent_activity_date < $recent_answer_date) {
						$recent_activity_date = $recent_answer_date;
					}
					$suggested_instructor = $answer_index->suggested_instructor_id;
					$rating_value = $this->instructor_rating(array('instructor_id' => $suggested_instructor));
					if ($rating_value[0]->rating == "") {
						$rating_value[0]->rating = 0;
					} else {
						$rating_value[0]->rating;
					}
					$answer_result['rating'] = $rating_value[0]->rating;
				}
				$result_question[$index]->recent_activity = $recent_activity_date;
			}
		}


		$res["success"] = "true";
		$res['discussion_details'] = $result_question;
		return $res;
	}

	function discussion_detail_for_instructor() {
		$res["error"] = "";
		$res["success"] = "false";
		$result = array();

		$sql = "select  q.`question`,q.`question_description`,q.`question_id`,q.`patient_id`,q.`question_status` as recent_activity,q.`question_post_date_time` as all_answer "
				. "from questions q";
		$result_question = $this->query($sql);
		//print_r($result_question);
		foreach ($result_question as $index => $question_indix) {
			$question_id = $question_indix->question_id;
			$recent_activity_date = $question_indix->all_answer;
			$answer = "select  ans.`posted_question_id`,ans.`post_date_time`,ans.`suggested_instructor_id`,ans.`answer`,ans.`answer_id`,d.`fname`,d.`lname`,d.`instructor_profile_pic`,d.`instructor_id` as rating ,d.`headline` from answers ans "
					. "left join user_instructors d on d.`instructor_id` = ans.`suggested_instructor_id` where ans.`posted_question_id`='$question_id'";
			$answer_result = $this->query($answer);
			//print_r($answer_result);
			$result_question[$index]->all_answer = $answer_result;
			//print_r($result_answer);
			foreach ($answer_result as $key => $answer_index) {
				$posted_question_id = $answer_index->posted_question_id;
				$recent_answer_date = $answer_index->post_date_time;


				if ($recent_activity_date < $recent_answer_date) {
					$recent_activity_date = $recent_answer_date;
				}
				$suggested_instructor = $answer_index->suggested_instructor_id;
				$rating_value = $this->instructor_rating(array('instructor_id' => $suggested_instructor));

				if ($rating_value[0]->rating == "") {
					$rating_value[0]->rating = 0;
				} else {
					$rating_value[0]->rating;
				}
				$answer_result['rating'] = $rating_value[0]->rating;
			}
			$result_question[$index]->recent_activity = $recent_activity_date;
		}




		$res["success"] = "true";
		$res['discussion_details'] = $result_question;
		return $res;
	}

	// Update instructor profile 


	function update_instructor_profile($instructor_profile_data) {
		$res["error"] = "";
		$res["success"] = "false";
		if ($instructor_profile_data['instructor_id'] == "") {

			$res["error"] = "Please provide instructor id";
		} else {

			$temp = explode('.', $_FILES['profile_pic']['name']); /* breaks a string into an array */
			$extension = end($temp);
			$uploaddir = 'profile_picture/' . $instructor_profile_data['instructor_id'];
			if (!is_dir($uploaddir)) {
				mkdir($uploaddir, 0777);
			}
			$datevideo = date('Y-m-d H:i:s');
			$date = date_create();
			$increment = date_timestamp_get($date);
			$uploadFileName = pathinfo($_FILES['profile_pic']['name'], PATHINFO_FILENAME);
			$uploadFileExtn = pathinfo($_FILES['profile_pic']['name'], PATHINFO_EXTENSION);
			while (file_exists($uploaddir . '/' . $uploadFileName . '_' . $increment . '.' . $uploadFileExtn)) {
				$date = date_create();
				$increment = date_timestamp_get($date);
			}

			$prifile_image_path = $uploaddir . '/' . $uploadFileName . '_' . $increment . '.' . $uploadFileExtn;
			$datetime = date("Y-m-d H:i:s");
			if (move_uploaded_file($_FILES['profile_pic']['tmp_name'], $uploaddir . '/' . $uploadFileName . '_' . $increment . '.' . $uploadFileExtn)) {
				$data = array('fname' => mysql_real_escape_string($instructor_profile_data['fname']),
					'lname' => mysql_real_escape_string($instructor_profile_data['lname']),
					'skills' => mysql_real_escape_string($instructor_profile_data['skills']),
					'headline' => mysql_real_escape_string($instructor_profile_data['headline']),
					'instructor_profile_pic' => $prifile_image_path);
				/* 'video_call_price' => $instructor_profile_data['video_call_price'],
				  'one_two_one_chat_price' => $instructor_profile_data['one_two_one_chat_price'],
				  'group_chat_price' => $instructor_profile_data['group_chat_price']); */
				if ($this->update("user_instructors", $data, "instructor_id = '" . $instructor_profile_data['instructor_id'] . "'")) {
					$res["success"] = "true";
				} else {
					$res["error"] = "Updation error";
				}
			} else {
				$res["error"] = "Image uploading error!Please try again";
			}
		}
		return $res;
	}

	// Store instructor availability

	function instructor_availability($availability_info) {
	//	print_r($availability_info);
		//echo count($availability_info['chat']);
		$res["error"] = "";
		$res["success"] = "false";
		$instructor_id = $availability_info["instructor_id"];
		if ($availability_info['instructor_id'] == "") {
			$res["error"] = "Please provide instructor id";
		} else {

			if (!empty($availability_info['group_chat'])) {

				for ($i = 0; $i < count($availability_info['group_chat']); $i++) {
					$data = array('instructor_id' => $availability_info['instructor_id'],
						'available_date' => $availability_info['group_chat'][$i]['chat_available_date'],
						'topic' => $availability_info['group_chat'][$i]['topic'],
						'instructor_start_time' => $availability_info['group_chat'][$i]['instructor_start_time'],
						'instructor_end_time' => $availability_info['group_chat'][$i]['instructor_end_time']
					);
					//print_r($data);
					echo $this->insert("user_instructors_availability", $data);
				}
			}
			if (!empty($availability_info['video_chat'])) {
				echo 'video';
				for ($i = 0; $i < count($availability_info['video_chat']); $i++) {

					$data = array('instructor_id' => $availability_info['instructor_id'],
						'video_available_date' => $availability_info['video_chat'][$i]['chat_available_date'],
						'topic' => $availability_info['video_chat'][$i]['topic'],
						//'topic' => 'video',
						'instructor_start_time' => $availability_info['video_chat'][$i]['instructor_start_time'],
						'instructor_end_time' => $availability_info['video_chat'][$i]['instructor_end_time']
					);
					echo $this->insert("user_instructors_availability", $data);
				}
			}
			if (!empty($availability_info['chat'])) {
				echo 'chat';
				for ($i = 0; $i < count($availability_info['chat']); $i++) {

					$data = array('instructor_id' => $availability_info['instructor_id'],
						'chat_available_date' => $availability_info['chat'][$i]['chat_available_date'],
						'topic' => $availability_info['chat'][$i]['topic'],
						//'topic' => 'chat',
						'instructor_start_time' => $availability_info['chat'][$i]['instructor_start_time'],
						'instructor_end_time' => $availability_info['chat'][$i]['instructor_end_time']
					);

					echo $this->insert("user_instructors_availability", $data);
				}
			}
			$res["success"] = "true";
		
		}
		return $res;
	}
	
	// Store instructor availability for android team
	function instructor_availability_store($availability_info){
		$res["error"] = "";
		$res["success"] = "false";
		$instructor_id = $availability_info["instructor_id"];
		if ($availability_info['instructor_id'] == "") {
			$res["error"] = "Please provide instructor id";
		} else {
			if($availability_info['group_chat'] != "0" && $availability_info['group_chat'] != ""){
				$group_chat=explode('**',$availability_info['group_chat']);
				$available_date=explode(',',$group_chat['0']);
				$topic=explode(',',$group_chat['1']);
				$instructor_start_time=explode(',',$group_chat['2']);
				$instructor_end_time=explode(',',$group_chat['3']);
				for($i=0; $i < count($available_date); $i++){
				$data = array('instructor_id' => $availability_info['instructor_id'],
						'available_date' => $available_date[$i],
						'topic' => $topic[$i],
						'instructor_start_time' => $instructor_start_time[$i],
						'instructor_end_time' => $instructor_end_time[$i]);
					//print_r($data);
					 $this->insert("user_instructors_availability", $data);
				 }
				}
			
			if($availability_info['video_chat'] != "0" && $availability_info['video_chat'] != ""){
				$video_chat=explode('**',$availability_info['video_chat']);
				$video_available_date=explode(',',$video_chat['0']);
			//	$topic=explode(',',$video_chat['1']);
				$instructor_start_time=explode(',',$video_chat['1']);
				$instructor_end_time=explode(',',$video_chat['2']);
				for($i=0; $i < count($video_available_date); $i++){
				$data = array('instructor_id' => $availability_info['instructor_id'],
						'video_available_date' => $video_available_date[$i],
					//	'topic' => $topic[$i],
						'instructor_start_time' => $instructor_start_time[$i],
						'instructor_end_time' => $instructor_end_time[$i]);
					 $this->insert("user_instructors_availability", $data);
				}
			}
			if($availability_info['chat'] != "0" && $availability_info['chat'] != ""){
				$chat=explode('**',$availability_info['chat']);
				$chat_available_date=explode(',',$chat['0']);
			//	$topic=explode(',',$chat['1']);
				$instructor_start_time=explode(',',$chat['1']);
				$instructor_end_time=explode(',',$chat['2']);
				for($i=0; $i < count($chat_available_date); $i++){
				$data = array('instructor_id' => $availability_info['instructor_id'],
						'chat_available_date' => $chat_available_date[$i],
					//	'topic' => $topic[$i],
						'instructor_start_time' => $instructor_start_time[$i],
						'instructor_end_time' => $instructor_end_time[$i]);
					 $this->insert("user_instructors_availability", $data);
				}
			}
				$res["success"] = "true";
		}	
		return $res;
	}
	
	// User	 Booking for chat to instructor	

	function booking($booking_data) {
		$res["error"] = "";
		$res["success"] = "false";
		if ($booking_data['user_id'] == "") {

			$res["error"] = "Please provide booker id";
		} else {

			if ($booking_data['chat_type'] == 'Group Chat') {

				//$count_usere = "select count(*) as tot_user form user_booking where instructor_id='" . $booking_data['instructor_id'] . "' and chat_type='Group Chat' and instructor_availability_id='" . $booking_data['availability_id'] . "'";
				$count_usere = "select count(*) as tot_user from user_booking where instructor_id='" . $booking_data['instructor_id'] . "' and instructor_availability_id='" . $booking_data['availability_id'] . "'";
				$count_result = $this->query($count_usere);
				if ($count_result[0]->tot_user == 11) {
					$res["error"] = "Sorry! Already 11 users booked for this date.";
				} else {
					$data = array(
						'booker_id' => $booking_data['user_id'],
						'instructor_id' => $booking_data['instructor_id'],
						'discuss_topic' => mysql_real_escape_string($booking_data['discuss_topic']),
						'booking_date' => $booking_data['booking_date'],
						'start_time' => $booking_data['start_time'],
						'instructor_availability_id' => $booking_data['availability_id'],
						'length_time' => $booking_data['length_time'],
						'chat_type' => mysql_real_escape_string($booking_data['chat_type'])
					);
					if ($this->insert("user_booking", $data)) {
						// Send mail for instructor
						$sql_user_name = "select user_name, fname, lname from social_media_login_user where user_id='" . $booking_data['user_id'] . "'";
						$result_user_name = $this->query($sql_user_name);

						$user_name = $result_user_name[0]->user_name;
						//$fname=$user_name_index->fname;
						//$lname=$user_name_index->lname;

						$sql_ins_mail = "select instructor_email from user_instructors where instructor_id='" . $booking_data['instructor_id'] . "'";
						$result_ins_mail = $this->query($sql_ins_mail);

						$instructor_email = $result_ins_mail[0]->instructor_email;

						$message = 'Hello ,
                               <p>User Name: <strong>' . $user_name . '</strong> has booked you. </p>                               
                                <br /><br />  
                                Thank you,<br />' .
								__REGARDS_FROM;

						$mail_data = array(
							"to" => $instructor_email,
							"from" => __SUPPORT_EMAIL,
							"subject" => "New patient for Family Health",
							"message" => $message
						);
						if ($this->send_mail($mail_data) == "success") {
							$res["success"] = "true";
						}
						//add update code
						if ($booking_data['token_value'] != "") {
							$sql = "select instructor_id,earn_token from user_instructors where instructor_id = '" . $booking_data['instructor_id'] . "'";
							$instructor_earn_token = $this->query($sql);
							$total_earn_token = $instructor_earn_token[0]->earn_token + $booking_data['token_value'];
							$update_query = $this->update('user_instructors', array('earn_token' => $total_earn_token), 'instructor_id ="' . $booking_data['instructor_id'] . '"');
							if ($update_query == 0 || $update_query == 1) {
								$user_token = "select user_token_id,token_values from user_token where user_id='" . $booking_data['user_id'] . "'";
								$user_token_value = $this->query($user_token);
								$left_token = $user_token_value[0]->token_values - $booking_data['token_value'];
								$this->update('user_token', array('token_values' => $left_token), 'user_id ="' . $booking_data['user_id'] . '"');

								$res["success"] = "true";
							} else {
								$res["error"] = "Updation error";
							}
						} else {
							$res["error"] = "Please provide token value";
						}
						//end 
					} else {
						$res["error"] = "Sorry ! Booking details not store in table ";
					}
				}
			} else {
				$data = array(
					'booker_id' => $booking_data['user_id'],
					'instructor_id' => $booking_data['instructor_id'],
					'discuss_topic' => mysql_real_escape_string($booking_data['discuss_topic']),
					'booking_date' => $booking_data['booking_date'],
					'start_time' => $booking_data['start_time'],
					'instructor_availability_id' => $booking_data['availability_id'],
					'length_time' => $booking_data['length_time'],
					'chat_type' => mysql_real_escape_string($booking_data['chat_type'])
				);
				if ($this->insert("user_booking", $data)) {
					// Send mail for instructor
					$sql_user_name = "select user_name, fname, lname from social_media_login_user where user_id='" . $booking_data['user_id'] . "'";
					$result_user_name = $this->query($sql_user_name);
					
						$user_name = $result_user_name[0]->user_name;
						//$fname=$user_name_index->fname;
						//$lname=$user_name_index->lname;
					
					$sql_ins_mail = "select instructor_email from user_instructors where instructor_id='" . $booking_data['instructor_id'] . "'";
					$result_ins_mail = $this->query($sql_ins_mail);
					
						$instructor_email = $result_ins_mail[0]->instructor_email;
					
					$message = 'Hello ,
                               <p>User Name: <strong>' . $user_name . '</strong> has booked you. </p>                               
                                <br /><br />  
                                Thank you,<br />' .
							__REGARDS_FROM;

					$mail_data = array(
						"to" => $instructor_email,
						"from" => __SUPPORT_EMAIL,
						"subject" => "New patient for Family Health",
						"message" => $message
					);
					if ($this->send_mail($mail_data) == "success") {
						$res["success"] = "true";
					}
					//add update code
					if ($booking_data['token_value'] != "") {
						$sql = "select instructor_id,earn_token from user_instructors where instructor_id = '" . $booking_data['instructor_id'] . "'";
						$instructor_earn_token = $this->query($sql);
						$total_earn_token = $instructor_earn_token[0]->earn_token + $booking_data['token_value'];
						$update_query = $this->update('user_instructors', array('earn_token' => $total_earn_token), 'instructor_id ="' . $booking_data['instructor_id'] . '"');
						if ($update_query == 0 || $update_query == 1) {
							$user_token = "select user_token_id,token_values from user_token where user_id='" . $booking_data['user_id'] . "'";
							$user_token_value = $this->query($user_token);
							$left_token = $user_token_value[0]->token_values - $booking_data['token_value'];
							$this->update('user_token', array('token_values' => $left_token), 'user_id ="' . $booking_data['user_id'] . '"');

							$res["success"] = "true";
						} else {
							$res["error"] = "Updation error";
						}
					} else {
						$res["error"] = "Please provide token value";
					}
					//end 
				} else {
					$res["error"] = "Sorry ! Booking details not store in table ";
				}
			}
		}
		return $res;
	}
	
	// function for return users token
	function return_user_token($token){
		$res["error"] = "";
		$res["success"] = "false";
		if ($token['availability_id'] == "") {
			$res["error"] = "Please provide me availability id";
		} else {
			// count users
			$count_user = "select count(*) as user from user_booking where instructor_availability_id='" . $token['availability_id'] . "'";
			$count_result = $this->query($count_user);
			$count_users=$count_result[0]->user;
				if ($count_users < 4) {
					// get user_id and time length
					$sql_select_user="select booker_id, length_time from user_booking where instructor_availability_id='" . $token['availability_id'] . "'";
					$result_user = $this->query($sql_select_user);
					foreach($result_user as $key_user=>$user_index){
						$booker_id=$user_index->booker_id;
						$length_time=$user_index->length_time;
						$token_rate=$length_time * 4;
						// get users token
						$select_user_token="select token_values from user_token where user_id ='" . $booker_id . "'";
						$result_user= $this->query($select_user_token);
					foreach($result_user as $key_token=>$token_index){
						$token_values=$token_index->token_values;
						}
						$total_user_token=$token_rate + $token_values;
						$this->update('user_token', array('token_values' => $total_user_token), 'user_id ="' . $booker_id . '"');
						}
						// get instructor id
						$sql_select_instructor="select instructor_id from user_instructors_availability where availability_id='" . $token['availability_id'] . "'";
					$result_instructor= $this->query($sql_select_instructor);
					foreach($result_instructor as $key_instructor=>$instructor_index){
						 $instructor_id=$instructor_index->instructor_id;
						}
						// get instructor token
						$select_inst_token="select earn_token from user_instructors where instructor_id ='" . $instructor_id . "'";
						$result_token= $this->query($select_inst_token);
					foreach($result_token as $key_token=>$token_index){
						 $earn_token=$token_index->earn_token;
						}
						$total_inst_token=$earn_token - $token_rate;
						$this->update('user_instructors', array('earn_token' => $total_inst_token), 'instructor_id ="' . $instructor_id . '"');
						// delete user booking details
						$sql_user_delete=mysql_query("delete from user_booking where instructor_availability_id='" . $token['availability_id'] . "'");
						// delete group call booking details
						$sql_user_delete=mysql_query("delete from user_instructors_availability where availability_id='" . $token['availability_id'] . "'");
						$res["success"] = "true";
				}
		}
		return $res;
	}

	// Fetch user details according to user id 
	function user_details_by_userid($user_information) {

		$res["error"] = "";
		$res["success"] = "false";
		if ($user_information['user_id'] == "") {

			$res["error"] = "Please provide user id";
		} else {
			$sql = "select u.`user_name`,u.`email`,u.`profile_image_url`,u.`user_id`,u.`fname`,u.`lname`,ut.`token_values` from social_media_login_user u "
					. "left join user_token ut on u.`user_id`=ut.`user_id` where u.`user_id` = '" . $user_information['user_id'] . "'";
			$user_details = $this->query($sql);
			foreach ($user_details as $key => $value) {
				if ($value->token_values == "") {
					$user_details[$key]->token_values = 0;
				}
			}


			$res['user_information'] = $user_details;
			$res["success"] = "true";
		}
		return $res;
	}

	// Show bookings details according to user id
	function my_bookings($user_id) {

		$res["error"] = "";
		$res["success"] = "false";
		if ($user_id['user_id'] == "") {
			$res["error"] = "Please provide user id ";
		} else {
			/* $sql = "select ub.discuss_topic,ub.booking_id,ub.booking_date,ub.length_time,ub.chat_type,ui.instructor_id,ui.instructor_email as email,ui.fname,ui.lname,ui.instructor_profile_pic from user_booking ub "
			  . "inner join user_instructors ui on ui.instructor_id=ub.instructor_id where ub.booker_id='" . $user_id['user_id'] . "'"; */

			$sql = "select ub.discuss_topic,ub.booking_id,ub.booking_date,ub.start_time,ub.length_time,ub.chat_type,ui.instructor_id,ui.instructor_email as email,ui.fname,ui.lname,ui.instructor_profile_pic from user_booking ub "
					. "inner join user_instructors ui on ui.instructor_id=ub.instructor_id where ub.booker_id='" . $user_id['user_id'] . "'";
			$bookings_information = $this->query($sql);
			$res["success"] = "true";
			$res['bookings_information'] = $bookings_information;
		}
		return $res;
	}

	function instructor_my_bookings($instructor_id) {

		$res["error"] = "";
		$res["success"] = "false";
		if ($instructor_id['instructor_id'] == "") {
			$res["error"] = "Please provide instructor id ";
		} else {
			$sql = "select smu.user_id,smu.email,smu.user_name,smu.fname,smu.lname,smu.gender,smu.email,smu.profile_image_url,ub.booking_id,ub.start_time,ub.discuss_topic,ub.booking_date,ub.length_time,ub.chat_type from "
					. "social_media_login_user smu inner join user_booking ub on smu.user_id=ub.booker_id where ub.instructor_id='" . $instructor_id['instructor_id'] . "'";
			$bookings_information = $this->query($sql);
			$res["success"] = "true";
			$res['bookings_information'] = $bookings_information;
		}
		return $res;
	}

// Instructor rating
	function rating($rating_details) {

		$res["error"] = "";
		$res["success"] = "false";
		$data = array('instructors_id' => $rating_details['instructor_id'],
			'patient_id' => $rating_details['user_id'],
			'rating_value' => $rating_details['rating_value'],
			'device_id' => $rating_details['device_id']);
		$tbl_name = 'instructors_rating';
		if ($rating_details['instructor_id'] == "" || $rating_details['user_id'] == "") {
			$res["error"] = "Please provide instructor and user id";
		} else {
			$sql = "select count(*) as isexits, instructors_id, patient_id  from instructors_rating where instructors_id='" . $rating_details['instructor_id'] . "' and patient_id ='" . $rating_details['user_id'] . "'";
			$rating_data = $this->query($sql);
			if ($rating_data[0]->isexits > 0) {
				$this->update($tbl_name, $data, 'instructors_rating_id="' . $rating_details['rating_id'] . '"');
				$res["success"] = "true";
			} else {
				if ($this->insert($tbl_name, $data)) {
					$res["success"] = "true";
				} else {
					$res["error"] = "Rating not store in database";
				}
			}
		}
		return $res;
	}

	function instructor_details_with_rating($instructor_id) {

		$res["success"] = "false";
		$res["error"] = "";
		if ($instructor_id['instructor_id'] == "") {
			$res["error"] = "Please provide instructor id";
		} else {

			$res['rating'] = $this->instructor_rating($instructor_id);
			$res['instructor_details'] = $this->instructor_details($instructor_id);
		}
		return $res;
	}

	// Fetch all instructors (Coaches)

	function instructors() {
		$res["success"] = "false";
		$res["error"] = "";
		//$instructorsrs = $this->get("user_instructors", "`instructor_id` , `instructor_user_name`,`video_call_price`,`one_two_one_chat_price`,`group_chat_price`,`fname`,`lname`, `instructor_email`, `instructor_gender`, `instructor_about`");
		$instructor = $this->query("select `instructor_id` ,`earn_token` as rating,`instructor_profile_pic`, `instructor_user_name`,`video_call_price`,`one_two_one_chat_price`,`group_chat_price`,`fname`,`lname`, `instructor_email`, `instructor_gender`, `skills` from user_instructors where instructor_approve_status =1");
		foreach ($instructor as $key => $instructor_value) {
			$rating = $this->instructor_rating(array('instructor_id' => $instructor_value->instructor_id));
			if ($rating[0]->rating == '') {
				$rating[0]->rating = 0;
			} else {
				$rating[0]->rating;
			}
			$instructor[$key]->rating = $rating[0]->rating;
		}
		$res['instructor_details'] = $instructor;
		return $res;
	}

	/// Fetch rating 
	function instructor_rating($instructor_id) {

		$sql = "select rating_value/count(*) as rating from instructors_rating where instructors_id='" . $instructor_id['instructor_id'] . "'";
		return $this->query($sql);
	}

	function instructor_details($instructor_id) {

		$instructorsr_details = $this->get("user_instructors", "`instructor_id`,`headline`,`instructor_profile_pic`,`fname`,`lname`,`video_call_price`,`one_two_one_chat_price`,`group_chat_price`,`skills`, `instructor_email`, `instructor_gender`", "`instructor_id` = '" . $instructor_id['instructor_id'] . "'");
		return $instructorsr_details[0];
	}

	// Get social meadia user details
	function get_user_details($user_id) {
		$user_details = $this->get("social_media_login_user", "`social_user_id` ,`profile_image_url`,`device_id`,`user_name`, `fname`, `lname`, `email` , `gender`, `login_type`,`user_id`", "`user_id`='" . $user_id . "'");

		return $user_details[0];
	}

	// Get Instructors details 	

	function get_instructorsr_details($instructorsr_id) {

		$instructorsr_details = $this->get("user_instructors", "`instructor_id` , `instructor_user_name`, `instructor_email`, `instructor_gender`, `instructor_about`", "`instructor_id` = '" . $instructorsr_id . "'");
		return $instructorsr_details[0];
	}

// Generate six digit random number 
	function creater_random_pass() {
		$str = "FAMILYHEALTHDEVELOPEFUNKIORANGEASDECDERHFGTRYHFBBFGFTFTFGFJFLGKGJHNNFNFHGFJFK";
		return substr(str_shuffle($str), 4, 6);
	}

	/// Sending mail 
	function send_mail($ml_data) {
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

//  User purchase token
	function purchase_user_token($token_details) {
		$res["success"] = "false";
		$tbl_name = "user_token";
		$res["error"] = "";
		if ($token_details['token_value'] == "" || $token_details['user_id'] == "") {
			$res["error"] = "Please provide token value and user id";
		} else {
			$sql = "select user_token_id,user_id,token_values from " . $tbl_name . " where user_id='" . $token_details['user_id'] . "'";
			$get_result = $this->query($sql);
			if ($get_result[0]->user_id == $token_details['user_id']) {
				$total_token_value = $get_result[0]->token_values + $token_details['token_value'];
				$this->update($tbl_name, array('token_values' => $total_token_value, 'purchase_date_time' => date("Y-m-d H:i:s")), 'user_id =' . $token_details['user_id']);

				$res["success"] = "true";
			} else {
				$this->insert($tbl_name, array('token_values' => $token_details['token_value'], 'purchase_date_time' => date("Y-m-d H:i:s"), 'user_id' => $token_details['user_id']));
				$res["success"] = "true";
			}
		}

		return $res;
	}

// Check user token available or not 
	function check_user_token($user_token_data) {
		$res["success"] = "false";
		$res["error"] = "";
		if ($user_token_data['user_id'] == "" || $user_token_data['instructor_id'] == "") {
			$res["error"] = "Please provide user id and instructor id";
		} else {
			$sql = "select count(*) as isValue,user_token_id,token_values from user_token where user_id ='" . $user_token_data['user_id'] . "'";
			$user_token_value = $this->query($sql);
			if ($user_token_value[0]->isValue == 0) {
				$res["error"] = "Insufficient token";
			} else {

				$res['chat_duration_time'] = $user_token_value[0]->token_values / $user_token_data['call_per_rate'];

				$res["success"] = "true";
			}
		}
		return $res;
	}

	//Update user token or instructor earn token
	function update_token_after_chat($chat_details) {
		$res["success"] = "false";
		$res["error"] = "";
		if ($chat_details['user_id'] == "" || $chat_details['instructor_id'] == "") {
			$res["error"] = "Please provide user id and instructor id";
		} else {
			if ($chat_details['chat_duration_value'] != "") {
				$sql = "select instructor_id,earn_token from user_instructors where instructor_id = '" . $chat_details['instructor_id'] . "'";
				$instructor_earn_token = $this->query($sql);
				$total_earn_token = $instructor_earn_token[0]->earn_token + $chat_details['chat_duration_value'];
				if ($this->update('user_instructors', array('earn_token' => $total_earn_token), 'instructor_id ="' . $chat_details['instructor_id'] . '"')) {
					$user_token = "select user_token_id,token_values from user_token where user_id='" . $chat_details['user_id'] . "'";
					$user_token_value = $this->query($user_token);
					$left_token = $user_token_value[0]->token_values - $chat_details['chat_duration_value'];
					$this->update('user_token', array('token_values' => $left_token), 'user_id ="' . $chat_details['user_id'] . '"');

					$res["success"] = "true";
				} else {
					$res["error"] = "Updation error";
				}
			} else {
				$res["error"] = "Please provide chat duration";
			}
		}
		return $res;
	}

	// Store input weight
	function input_weight_details($input_weight_data) {
		$res["success"] = "false";
		$res["error"] = "";

		$temp = explode('.', $_FILES['track_photo']['name']); /* breaks a string into an array */
		$extension = end($temp);
		$uploaddir = 'my_track/' . $input_weight_data['user_id'];
		if (!is_dir($uploaddir)) {
			mkdir($uploaddir, 0777);
		}
		$datevideo = date('Y-m-d H:i:s');
		$date = date_create();
		$increment = date_timestamp_get($date);
		$uploadFileName = pathinfo($_FILES['track_photo']['name'], PATHINFO_FILENAME);
		$uploadFileExtn = pathinfo($_FILES['track_photo']['name'], PATHINFO_EXTENSION);
		while (file_exists($uploaddir . '/' . $uploadFileName . '_' . $increment . '.' . $uploadFileExtn)) {
			$date = date_create();
			$increment = date_timestamp_get($date);
		}

		$videopath = $uploaddir . '/' . $uploadFileName . '_' . $increment . '.' . $uploadFileExtn;
		$datetime = date("Y-m-d H:i:s");
		if (move_uploaded_file($_FILES['track_photo']['tmp_name'], $uploaddir . '/' . $uploadFileName . '_' . $increment . '.' . $uploadFileExtn)) {
			$data = array('track_user_id' => $input_weight_data['user_id'],
				'weight' => $input_weight_data['weight'],
				'bmi' => $input_weight_data['bmi'],
				'body_fat' => $input_weight_data['body_fat'],
				'calories_consume' => $input_weight_data['calories_consume'],
				'calories_burned' => $input_weight_data['calories_burned'],
				'grams_fat' => $input_weight_data['grams_fat'],
				'grams_protein' => $input_weight_data['grams_protein'],
				'area_of_body' => $input_weight_data['area_of_body'],
				'measurement_different' => $input_weight_data['measurement_different'],
				'sport' => $input_weight_data['sport'],
				'distance' => $input_weight_data['distance'],
				'time' => $input_weight_data['time'],
				'position' => $input_weight_data['position'],
				'win_loss' => $input_weight_data['win_loss'],
				'mytrack_photo' => $videopath,
				'tracking_date' => date("Y-m-d"),
				'number_of_training_sessions' => $input_weight_data['number_of_training_sessions'],
				'exercise_performed' => $input_weight_data['exercise_performed'],
				'load_achieved' => $input_weight_data['load_achieved'],
				'average_repetitions' => $input_weight_data['average_repetitions'],
				'average_sets' => $input_weight_data['average_sets'],
				'average_pace' => $input_weight_data['average_pace'],
				'average_heart_rate' => $input_weight_data['average_heart_rate'],
				'average_watts' => $input_weight_data['average_watts'],
				'average_cadence' => $input_weight_data['average_cadence'],
				'number_of_recovery_sessions' => $input_weight_data['number_of_recovery_sessions'],
				'number_of_flexibility_sessions' => $input_weight_data['number_of_flexibility_sessions']);
			if ($this->insert('input_weight', $data)) {
				$res['success'] = "true";
			} else {
				$res['error'] = "Data not store in table.Please try again!";
			}
		} else {
			$res['error'] = "Mytrack photo not uploaded!Please try agian";
		}
		return $res;
	}

// get token value and message set by admin

	function get_token_value($user_id) {
		$res["sucess"] = "false";
		$res["error"] = "";

		if ($user_id['user_id'] == "") {

			$res["error"] = "Please provide user id";
		} else {
			$user_toke = $this->query("select count(*) as istoken,token_values from user_token where user_id ='" . $user_id['user_id'] . "'");
			$toke_sql = "select t.`normal_token_one`,t.`normal_token_one_price`,t.`normal_token_two`,t.`normal_token_two_price`,t.`normal_token_three`,t.`normal_token_three_price`,t.`monthly_token_one`,t.`monthly_token_one_price`,t.`monthly_token_two`,t.`monthly_token_two_price`,t.`monthly_token_three`,"
					. " t.`monthly_token_three_price`,t.`message`,t.`free_token_value` from token_rate_by_admin t order by t.`token_rate_id` limit 1";

			$token_query = $this->query($toke_sql);
			$res['monthly'] = array('monthly_token_one' => $token_query[0]->monthly_token_one, 'monthly_token_one_price' => $token_query[0]->monthly_token_one_price,
				'monthly_token_two' => $token_query[0]->monthly_token_two, 'monthly_token_two_price' => $token_query[0]->monthly_token_two_price,
				'monthly_token_three' => $token_query[0]->monthly_token_three, 'monthly_token_three_price' => $token_query[0]->monthly_token_three_price);

			$res['normal_token'] = array('normal_token_one' => $token_query[0]->normal_token_one, 'normal_token_one_price' => $token_query[0]->normal_token_one_price,
				'normal_token_two' => $token_query[0]->normal_token_two, 'normal_token_two_price' => $token_query[0]->normal_token_two_price,
				'normal_token_three' => $token_query[0]->normal_token_three, 'normal_token_three_price' => $token_query[0]->normal_token_three_price);


			if ($user_toke[0]->istoken == 0) {
				$user_toke[0]->token_values = 0;
			} else {
				$user_toke[0]->token_values;
			}
			$res['token_message'] = array('message' => $token_query[0]->message, 'free_token_value' => $token_query[0]->free_token_value, 'user_token_value' => $user_toke[0]->token_values);
			$res["sucess"] = "true";
		}
		return $res;
	}

// Changed password 


	function change_password($pass_information) {

		$res["sucess"] = "false";
		$res["error"] = "";

		if ($pass_information['user_id'] == "") {

			$res["error"] = "Please provide user id";
		} else {
			$sql_password = "select count(*) isexits,instructor_password from user_instructors where instructor_id ='" . $pass_information['user_id'] . "' AND instructor_password='" . MD5($pass_information['old_password']) . "'";
			$password_get = $this->query($sql_password);
			if ($password_get[0]->isexits == 1) {

				$this->update('user_instructors', array('instructor_password' => MD5($pass_information['new_password'])), "instructor_id ='" . $pass_information['user_id'] . "' AND instructor_password='" . MD5($pass_information['old_password']) . "'");
				$res["sucess"] = "true";
			} else {
				$res["error"] = "Old password does not match";
			}
		}
		return $res;
	}

//  my tracking 

	function my_tracking($tracking_user) {
		$res["success"] = "false";
		$res["error"] = "";
		if ($tracking_user['user_id'] == "") {

			$res["error"] = "Please provide user id";
		} else {
			$res['my_tracking'] = $this->get('input_weight', 'mytrack_photo,tracking_date,weight,bmi,body_fat,input_weight_id', 'track_user_id ="' . $tracking_user['user_id'] . '" order by input_weight_id DESC');
			$res["success"] = "true";
		}
		return $res;
	}

//  Fetch my tracking details according to tracking id

	function my_tracking_deatails($tracking_user) {
		$res["success"] = "false";
		$res["error"] = "";
		if ($tracking_user['tracking_id'] == "") {

			$res["error"] = "Please provide tracking id";
		} else {
			$res['my_tracking_details'] = $this->get('input_weight', 'input_weight_id,weight,bmi,body_fat,calories_consume,calories_burned,grams_fat,grams_protein,area_of_body,measurement_different,sport,distance,time,position,win_loss,mytrack_photo,tracking_date,number_of_training_sessions,exercise_performed,load_achieved,average_repetitions,average_sets,average_pace,average_heart_rate,average_watts,average_cadence,number_of_recovery_sessions,number_of_flexibility_sessions', 'input_weight_id ="' . $tracking_user['tracking_id'] . '"');
			$res["success"] = "true";
		}
		return $res;
	}

	//Fetch instructors available date
	/* 	function instructors_available_date($available_dates){
	  $res["error"] = "";
	  $res["success"] = "false";
	  $array='';
	  $key_array=array();
	  $vedio_array='';
	  $topic_array='';
	  $chat_array='';
	  $inst_topic_array='';
	  $topic_index=array();
	  //$chat_date=array();
	  $current_date=date("Y-m-d");
	  $available_topic=$available_dates['topic'];
	  if ($available_dates['instructor_id'] == "") {
	  $res["error"] = "Please provide instructor id";
	  } else {
	  if($available_dates['instructor_id'] != "" AND $available_dates['call_type'] == group)	{
	  $instructors_available = "select available_date, topic, instructor_start_time, instructor_end_time from user_instructors_availability where instructor_id ='" . $available_dates["instructor_id"] ."' AND topic ='" . $available_dates['call_type'] ."'";
	  $result = $this->query($instructors_available);
	  $explode_available_date=explode(",",$result[0]->available_date);
	  $explode_topic=explode("@",$result[0]->topic);
	  foreach($explode_available_date as $key=>$explodes_inst_date){
	  $ins_avilab_date=date("Y-m-d", strtotime($explodes_inst_date));

	  if($ins_avilab_date >= $current_date){
	  $key_array[]=$key;

	  $array.=$ins_avilab_date.',';
	  }
	  }
	  $array = rtrim($array,',');

	  foreach($key_array as $index){
	  $ins_topic=$explode_topic[$index];
	  $topic_array.=$ins_topic.'@';
	  }
	  $topic_array = rtrim($topic_array,'@');
	  $res["success"] = "true";
	  $result[0]->available_date=$array;
	  $result[0]->topic=$topic_array;
	  $res['instructors_availability']= $result;
	  }else{
	  if($available_dates['instructor_id'] != "" AND $available_dates['call_type'] == video)	{
	  $instructors_available = "select video_available_date, instructor_start_time, instructor_end_time from user_instructors_availability where instructor_id ='" . $available_dates["instructor_id"] ."' AND topic ='" . $available_dates['call_type'] ."'";
	  $result = $this->query($instructors_available);
	  $explode_video_date=explode(",",$result[0]->video_available_date);
	  foreach($explode_video_date as $key=>$explodes_inst_video){
	  $ins_avilab_video=date("Y-m-d", strtotime($explodes_inst_video));
	  if($ins_avilab_video >= $current_date){
	  $key_array[]=$key;
	  $ins_video_date.=$ins_avilab_video.',';
	  }
	  }
	  $ins_video_date = rtrim($ins_video_date,',');
	  $res["success"] = "true";
	  $result[0]->video_available_date=$ins_video_date;
	  $res['instructors_availability']= $result;
	  }
	  else{
	  if($available_dates['instructor_id'] != "" AND $available_dates['call_type'] == chat)	{
	  $instructors_available = "select chat_available_date, instructor_start_time, instructor_end_time from user_instructors_availability where instructor_id ='" . $available_dates["instructor_id"] ."' AND topic ='" . $available_dates['call_type'] ."'";
	  $result = $this->query($instructors_available);
	  $explode_chat_date=explode(",",$result[0]->chat_available_date);
	  foreach($explode_chat_date as $key=>$explodes_inst_chat){
	  $ins_avilab_chat=date("Y-m-d", strtotime($explodes_inst_chat));
	  if($ins_avilab_chat >= $current_date){
	  $key_array[]=$key;
	  $ins_chat_date.=$ins_avilab_chat.',';
	  }
	  }
	  $ins_chat_date = rtrim($ins_chat_date,',');
	  $res["success"] = "true";
	  $result[0]->chat_available_date=$ins_chat_date;
	  $res['instructors_availability']= $result;
	  }	else{

	  $res["error"] = "Invalid call type";
	  }
	  }
	  }
	  }
	  return $res;
	  }
	 */

	/*//Fetch instructors available date
	function instructors_available_date($available_dates) {
		$res["error"] = "";
		$res["success"] = "false";
		$array = array();

		$current_date = date("Y-m-d");
		$available_topic = $available_dates['topic'];
		if ($available_dates['instructor_id'] == "") {
			$res["error"] = "Please provide instructor id";
		} else {
			if ($available_dates['instructor_id'] != "" AND $available_dates['call_type'] == 'group') {
				$instructors_available = "select availability_id,available_date,topic,instructor_start_time, instructor_end_time from user_instructors_availability where instructor_id ='" . $available_dates["instructor_id"] . "'";
				$result = $this->query($instructors_available);
				foreach ($result as $key => $result_inst_date) {
					$ins_avilab_date = date("Y-m-d", strtotime($result_inst_date->available_date));
					if ($ins_avilab_date >= $current_date) {
						$ins_availability_id = $result_inst_date->availability_id;
						$ins_topic = $result_inst_date->topic;
						$ins_start_time = $result_inst_date->instructor_start_time;
						$ins_end_time = $result_inst_date->instructor_end_time;
						array_push($array, array(
							"availability_id" => $ins_availability_id,
							"available_date" => $ins_avilab_date,
							"topic" => $ins_topic,
							"instructor_start_time" => $ins_start_time,
							"instructor_end_time" => $ins_end_time
						));
						$res["success"] = "true";
						$res['instructors_availability'] = $array;
					} else {
						$res['error'] = "Instructor not available";
					}
				}
			} else {
				if ($available_dates['instructor_id'] != "" AND $available_dates['call_type'] == 'video') {
					$instructors_available = "select availability_id,video_available_date, instructor_start_time, instructor_end_time from user_instructors_availability where instructor_id ='" . $available_dates["instructor_id"] . "'";
					$result = $this->query($instructors_available);

					foreach ($result as $key => $inst_video) {
						$ins_avilab_video = date("Y-m-d", strtotime($inst_video->video_available_date));
						if ($ins_avilab_video >= $current_date) {
							$ins_availability_id = $inst_video->availability_id;
							$ins_start_time = $inst_video->instructor_start_time;
							$ins_end_time = $inst_video->instructor_end_time;
							array_push($array, array(
								"availability_id" => $ins_availability_id,
								"available_date" => $ins_avilab_video,
								"instructor_start_time" => $ins_start_time,
								"instructor_end_time" => $ins_end_time
							));
							$res["success"] = "true";
							$res['instructors_availability'] = $array;
						} else {
							$res['error'] = "Instructor not available";
						}
					}
				} else {
					if ($available_dates['instructor_id'] != "" AND $available_dates['call_type'] == 'chat') {
						$instructors_available = "select availability_id,chat_available_date, instructor_start_time, instructor_end_time from user_instructors_availability where instructor_id ='" . $available_dates["instructor_id"] . "'";
						$result = $this->query($instructors_available);

						foreach ($result as $key => $inst_chat) {
							$ins_avilab_chat = date("Y-m-d", strtotime($inst_chat->chat_available_date));
							if ($ins_avilab_chat >= $current_date) {
								$ins_availability_id = $inst_chat->availability_id;
								$ins_start_time = $inst_chat->instructor_start_time;
								$ins_end_time = $inst_chat->instructor_end_time;
								array_push($array, array(
									"availability_id" => $ins_availability_id,
									"available_date" => $ins_avilab_chat,
									"instructor_start_time" => $ins_start_time,
									"instructor_end_time" => $ins_end_time
								));
								$res["success"] = "true";
								$res['instructors_availability'] = $array;
							} else {
								$res['error'] = "Instructor not available";
							}
						}
					} else {

						$res["error"] = "Invalid call type";
					}
				}
			}
		}
		return $res;
	}*/


		//Fetch instructors available date
	function instructors_available_date($available_dates) {
		$res["error"] = "";
		$res["success"] = "false";
		$array = array();

		$current_date = date("Y-m-d");
		$available_topic = $available_dates['topic'];
		if ($available_dates['instructor_id'] == "") {
			$res["error"] = "Please provide instructor id";
		} else {
			if ($available_dates['instructor_id'] != "" AND $available_dates['call_type'] == 'group') {
				 $instructors_available = "select availability_id,available_date,topic,instructor_start_time, instructor_end_time from user_instructors_availability where instructor_id ='" . $available_dates["instructor_id"] . "'";
				$result = $this->query($instructors_available);
				foreach ($result as $key => $result_inst_date) {
					$ins_avilab_date = date("Y-m-d", strtotime($result_inst_date->available_date));				
					if ($ins_avilab_date >= $current_date) {
						$ins_availability_id = $result_inst_date->availability_id;
						$ins_topic = $result_inst_date->topic;
						$ins_start_time = $result_inst_date->instructor_start_time;
						$ins_end_time = $result_inst_date->instructor_end_time;
						array_push($array, array(
							"availability_id" => $ins_availability_id,
							"available_date" => $ins_avilab_date,
							"topic" => $ins_topic,
							"instructor_start_time" => $ins_start_time,
							"instructor_end_time" => $ins_end_time
						));
						$res["success"] = "true";
						$res['instructors_availability'] = $array;
					} 
				}
				if($res['instructors_availability']==""){
							$res["error"] = "Instructor not available";
							}
			} elseif ($available_dates['instructor_id'] != "" AND $available_dates['call_type'] == 'video') {
					$instructors_available = "select availability_id,video_available_date, instructor_start_time, instructor_end_time from user_instructors_availability where instructor_id ='" . $available_dates["instructor_id"] . "'";
					$result = $this->query($instructors_available);

					foreach ($result as $key => $inst_video) {
						$ins_avilab_video = date("Y-m-d", strtotime($inst_video->video_available_date));
						if ($ins_avilab_video >= $current_date) {
							$ins_availability_id = $inst_video->availability_id;
							$ins_start_time = $inst_video->instructor_start_time;
							$ins_end_time = $inst_video->instructor_end_time;
							array_push($array, array(
								"availability_id" => $ins_availability_id,
								"available_date" => $ins_avilab_video,
								"instructor_start_time" => $ins_start_time,
								"instructor_end_time" => $ins_end_time
							));
							$res["success"] = "true";
							$res['instructors_availability'] = $array;
						} 
					}
					if($res['instructors_availability']==""){
							$res["error"] = "Instructor not available";
							}
				} elseif ($available_dates['instructor_id'] != "" AND $available_dates['call_type'] == 'chat') {
						$instructors_available = "select availability_id,chat_available_date, instructor_start_time, instructor_end_time from user_instructors_availability where instructor_id ='" . $available_dates["instructor_id"] . "'";
						$result = $this->query($instructors_available);

						foreach ($result as $key => $inst_chat) {
							$ins_avilab_chat = date("Y-m-d", strtotime($inst_chat->chat_available_date));
							if ($ins_avilab_chat >= $current_date) {
								$ins_availability_id = $inst_chat->availability_id;
								$ins_start_time = $inst_chat->instructor_start_time;
								$ins_end_time = $inst_chat->instructor_end_time;
								array_push($array, array(
									"availability_id" => $ins_availability_id,
									"available_date" => $ins_avilab_chat,
									"instructor_start_time" => $ins_start_time,
									"instructor_end_time" => $ins_end_time
								));
								$res["success"] = "true";
								$res['instructors_availability'] = $array;
							} 
						}
						if($res['instructors_availability']==""){
							$res["error"] = "Instructor not available";
							}
					} else {
						$res["error"] = "Invalid call type";
					}
				}
				return $res;
			}
		
		
	

	// social media user update function
	function user_information_update($user_details) {
		$res["error"] = "";
		$res["success"] = "false";
		if ($user_details['user_id'] == "") {

			$res["error"] = "Please provide me user id";
		} else {
			$temp = explode('.', $_FILES['user_profile_pic']['name']); /* breaks a string into an array */
			$extension = end($temp);
			$uploaddir = 'user_profile_pic/' . $user_details['user_id'];
			if (!is_dir($uploaddir)) {
				mkdir($uploaddir, 0777);
			}
			$datevideo = date('Y-m-d H:i:s');
			$date = date_create();
			$increment = date_timestamp_get($date);
			$uploadFileName = pathinfo($_FILES['user_profile_pic']['name'], PATHINFO_FILENAME);
			$uploadFileExtn = pathinfo($_FILES['user_profile_pic']['name'], PATHINFO_EXTENSION);
			while (file_exists($uploaddir . '/' . $uploadFileName . '_' . $increment . '.' . $uploadFileExtn)) {
				$date = date_create();
				$increment = date_timestamp_get($date);
			}

			$prifile_image_path = $uploaddir . '/' . $uploadFileName . '_' . $increment . '.' . $uploadFileExtn;
			$datetime = date("Y-m-d H:i:s");
			if (move_uploaded_file($_FILES['user_profile_pic']['tmp_name'], $uploaddir . '/' . $uploadFileName . '_' . $increment . '.' . $uploadFileExtn)) {
				$data = array('fname' => $user_details['fname'],
					'lname' => $user_details['lname'],
					'profile_image_url' => $prifile_image_path);
				if ($this->update("social_media_login_user", $data, "user_id = '" . $user_details['user_id'] . "'")) {
					$res["success"] = "true";
				} else {
					$res["error"] = "Updation error";
				}
			} else {
				$res["error"] = "Image uploading error!Please try again";
			}
		}
		return $res;
	}

	// Return user details 
	function available_date_user_details($user_details) {
		$res["error"] = "";
		$res["success"] = "false";
		$array = array();
		if ($user_details['instructor_id'] == "") {
			$res["error"] = "Please provide me instructor id";
		} else {
			//	$sql = "select u.user_id,u.social_user_id,u.user_name,u.fname,u.lname,u.email,u.profile_image_url,ub.booker_id,ia.instructor_id from social_media_login_user u "
			//	. "inner join user_booking ub on u.user_id=ub.booker_id inner join user_instructors_availability ia on ia.instructor_id=ub.instructor_id where ia.`instructor_id`='" . $user_details['instructor_id'] . "' AND ia.`available_date`='" . $user_details['available_date'] . "' AND ia.`instructor_start_time`='" . $user_details['instructor_start_time'] . "' AND ia.`topic` = '" . $user_details['topic'] . "'";
			//	 $sql = "select u.user_id,u.user_name,u.email,ub.booker_id,ia.instructor_id from social_media_login_user u "
			//		. "inner join user_booking ub on u.user_id=ub.booker_id inner join user_instructors_availability ia on ia.instructor_id=ub.instructor_id where ia.`instructor_id`='" . $user_details['instructor_id'] . "' AND ia.`available_date`='" . $user_details['available_date'] . "' AND ia.`instructor_start_time`='" . $user_details['instructor_start_time'] . "' AND ia.`topic` = '" . $user_details['topic'] . "'";

			$sql = "select instructor_id, availability_id, available_date, topic, instructor_start_time from user_instructors_availability where instructor_id='" . $user_details['instructor_id'] . "' AND available_date='" . $user_details['available_date'] . "' AND instructor_start_time='" . $user_details['instructor_start_time'] . "' AND topic = '" . $user_details['topic'] . "'";
			$result = $this->query($sql);
			foreach ($result as $key => $inst_available_index) {
				//$inst_availability_id=$inst_available_index->availability_id;
				$user_details_sql = "select u.user_id,u.user_name,u.email,ub.booker_id,ub.instructor_availability_id from social_media_login_user u "
						. "inner join user_booking ub on u.user_id=ub.booker_id where ub.instructor_availability_id='" . $inst_available_index->availability_id . "'";
				$result_user_details = $this->query($user_details_sql);
				foreach ($result_user_details as $user_key => $user_index) {
					$user_id = $user_index->user_id;
					$user_name = $user_index->user_name;
					$email = $user_index->email;
                                        $availability_id=$user_index->instructor_availability_id;
					array_push($array, array(
						"user_id" => $user_id,
						"user_name" => $user_name,
						"email" => $email,
                                                "instructor_availability_id" => $availability_id

					));
				}
			}
			$res['users_details'] = $array;
			$res["success"] = "true";
		}
		return $res;
	}

	function instructors_available_date_time($available_times) {
		$res["error"] = "";
		$res["success"] = "false";
		$array = array();
		$array_video = array();
		$array_chat = array();
		$current_date = date("Y-m-d");

		if ($available_times['instructor_id'] == "") {
			$res["error"] = "Please provide instructor id";
		} else {
			if ($available_times['instructor_id'] != "") {
				$instructors_available = "select availability_id,available_date,instructor_start_time, instructor_end_time from user_instructors_availability where instructor_id ='" . $available_times["instructor_id"] . "'";
				$result = $this->query($instructors_available);

				foreach ($result as $key => $result_inst_date) {

					$ins_avilab_date = date("Y-m-d", strtotime($result_inst_date->available_date));

					if ($ins_avilab_date >= $current_date AND $ins_avilab_date == $available_times['date']) {
						$ins_availability_id = $result_inst_date->availability_id;
						$ins_topic = $result_inst_date->topic;
						$ins_start_time = $result_inst_date->instructor_start_time;
						$ins_end_time = $result_inst_date->instructor_end_time;
						array_push($array, array(
							"availability_id" => $ins_availability_id,
							"available_date" => $ins_avilab_date,
							"instructor_start_time" => $ins_start_time,
							"instructor_end_time" => $ins_end_time
						));
						$res["success"] = "true";
						$res['instructor_available_date'] = $array;
					}
				}
				$instructors_video = "select availability_id,video_available_date,instructor_start_time, instructor_end_time from user_instructors_availability where instructor_id ='" . $available_times["instructor_id"] . "'";
				$result_video = $this->query($instructors_video);

				foreach ($result_video as $key_video => $result_inst_video_date) {
					$ins_video_date = date("Y-m-d", strtotime($result_inst_video_date->video_available_date));

					if ($ins_video_date >= $current_date AND $ins_video_date == $available_times['date']) {
						$ins_availability_id = $result_inst_video_date->availability_id;
						$ins_video = $result_inst_video_date->video_available_date;
						$ins_start_time = $result_inst_video_date->instructor_start_time;
						$ins_end_time = $result_inst_video_date->instructor_end_time;
						array_push($array_video, array(
							"availability_id" => $ins_availability_id,
							"video_available_date" => $ins_video,
							"instructor_start_time" => $ins_start_time,
							"instructor_end_time" => $ins_end_time
						));
						$res["success"] = "true";
						$res['instructor_video_available_date'] = $array_video;
						($array);
					}
				}
				$instructors_chat = "select availability_id,chat_available_date,instructor_start_time, instructor_end_time from user_instructors_availability where instructor_id ='" . $available_times["instructor_id"] . "'";
				$result_chat = $this->query($instructors_chat);

				foreach ($result_chat as $key_chat => $result_inst_chat_date) {
					$ins_chat_date = date("Y-m-d", strtotime($result_inst_chat_date->chat_available_date));

					if ($ins_chat_date >= $current_date AND $ins_chat_date == $available_times['date']) {
						$ins_availability_id = $result_inst_chat_date->availability_id;
						$ins_chat = $result_inst_chat_date->chat_available_date;
						$ins_start_time = $result_inst_chat_date->instructor_start_time;
						$ins_end_time = $result_inst_chat_date->instructor_end_time;
						array_push($array_chat, array(
							"availability_id" => $ins_availability_id,
							"chat_available_date" => $ins_chat,
							"instructor_start_time" => $ins_start_time,
							"instructor_end_time" => $ins_end_time
						));
						$res["success"] = "true";
						$res['instructor_chat_available_date'] = $array_chat;
					}
				}
			}
		}
		return $res;
	}

	// Send push notification for iphone 
	function sendiphonePush($device, $messageBody="Fit + Health") {
		$deviceToken = '27c9d615268de722b017aff078fac4932533920ce42d466cb60c2cf8454ea3c0';

				$passphrase = 'pushchat';

				$message = 'My first push notification!';

				////////////////////////////////////////////////////////////////////////////////

				$ctx = stream_context_create();
				$filename = 'ckdev.pem';
				stream_context_set_option($ctx, 'ssl', 'local_cert', $filename);
				stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

				// Open a connection to the APNS server
				$fp = stream_socket_client(
				'ssl://gateway.sandbox.push.apple.com:2195', $err,
				$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);

				if (!$fp)
				exit("Failed to connect: $err $errstr" . PHP_EOL);

				echo 'Connected to APNS' . PHP_EOL;

				// Create the payload body
				$body['aps'] = array(
				'alert' => $message,
				'sound' => 'default'
				);

				// Encode the payload as JSON
				$payload = json_encode($body);

				// Build the binary notification
				$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . 

				$payload;

				// Send it to the server
				$result = fwrite($fp, $msg, strlen($msg));

				if (!$result)
					echo 'Message not delivered' . PHP_EOL;
				else
					echo 'Message successfully delivered'.PHP_EOL;

				// Close the connection to the server
				fclose($fp);

		
		
		
		
		
		
		
		// Put your device token here (without spaces):
			/*$deviceToken = '27c9d615268de722b017aff078fac4932533920ce42d466cb60c2cf8454ea3c0';
			//$deviceToken =$device;
			// Put your private key's passphrase here:
			$passphrase = 'pushchat';

			// Put your alert message here:
			$message = '"Push message "';

			////////////////////////////////////////////////////////////////////////////////

			$ctx = stream_context_create();
			stream_context_set_option($ctx, 'ssl', 'local_cert', 'ck.pem');
			stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

			// Open a connection to the APNS server
			$fp = stream_socket_client(
				'ssl://gateway.sandbox.push.apple.com:2195', $err,
				$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);

			if (!$fp)
				exit("Failed to connect: $err $errstr" . PHP_EOL);

			echo 'Connected to APNS' . PHP_EOL;

			// Create the payload body
			$body['aps'] = array(
				'alert' => $message,
				'sound' => 'default'
				);

			// Encode the payload as JSON
			$payload = json_encode($body);

			// Build the binary notification
			$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;

			// Send it to the server
			$result = fwrite($fp, $msg, strlen($msg));

			if (!$result)
				echo 'Message not delivered' . PHP_EOL;
			else
				echo 'Message successfully delivered' . PHP_EOL;

			// Close the connection to the server
			fclose($fp);*/

		
		
		}
	

	/*function sendiphonePush($device, $messageBody="Fit + Health") {
		// Put your device token here (without spaces):
		//$deviceToken = '27c9d615268de722b017aff078fac4932533920ce42d466cb60c2cf8454ea3c0';
		$deviceToken = $device;
		// Put your private key's passphrase here:
		//$passphrase = ‘pushchat';
		$passphrase = 'pushchat';

		// Put your alert message here:
		$message = $messageBody;

		//echo "DEVICE : ".$deviceToken."\nMESSAGE : ".$message; die;
		////////////////////////////////////////////////////////////////////////////////

		$ctx = stream_context_create();
		//stream_context_set_option($ctx, 'ssl', 'local_cert', 'DesiPushFinal.pem');
		stream_context_set_option($ctx, 'ssl', 'local_cert', 'ck.pem');
		stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

		// Open a connection to the APNS server
		//ssl://gateway.push.apple.com:2195
		//ssl://gateway.sandbox.push.apple.com:2195
		$fp = stream_socket_client('ssl://gateway.sandbox.push.apple.com:2195', $err, $errstr, 60, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT, $ctx);

		$res = "";
		if (!$fp) {
			$res.= "Failed to connect";
			$res.= '<br>';
			$res.= 'Error:' . $err;
			$res.= '<br>';
			$res.= 'Errstr:' . $errstr;
			//exit();
		} else {
			$res.= "Connected to APNS";
			$res.= '<br>';
			$res.= 'Error:' . $err;
			$res.= '<br>';
			$res.= 'Errstr:' . $errstr;
		}

		// Create the payload body
		$body['aps'] = array(
			'alert' => $message,
			'sound' => 'default'
		);

		// Encode the payload as JSON
		$payload = json_encode($body);

		// Build the binary notification
		$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;

		// Send it to the server
		$result = fwrite($fp, $msg, strlen($msg));

		if (!$result) {

			return false;
			//echo 'bye';
		} else {
			return true;
			//echo 'hiii';
		}

		//echo $res;	
		/* if (!$result)
		  $res = false;
		  else
		  $res = true; */

		// Close the connection to the server
		//fclose($fp);
		//die;

	//}

	// Push notification for android

	function sendandroidPush($registatoin_ids, $message) {
		$registatoin_ids = array($registatoin_ids);
		$message = array("price" => $message);
		// Set POST variables
		$url = 'https://android.googleapis.com/gcm/send';

		$fields = array(
			'registration_ids' => $registatoin_ids,
			'data' => $message,
		);

		$headers = array(
			'Authorization: key=' . GOOGLE_API_KEY,
			'Content-Type: application/json'
		);
		// Open connection
		$ch = curl_init();

		// Set the url, number of POST vars, POST data
		curl_setopt($ch, CURLOPT_URL, $url);

		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		// Disabling SSL Certificate support temporarly
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

		// Execute post
		$result = curl_exec($ch);

		//$res='';
		$_res = (json_decode($result));
		//print_r($_res);
		if ($_res->success === 0) {
			//echo 'byee';
			$res = false;
			return $res;
			//die('Curl failed: ' . curl_error($ch));
			//$res.= 'Curl failed: ' . curl_error($ch);
		} else {
			//$res=0;
			$res = true;
			return $res;
		}
		//echo $res;
		// Close connection
		curl_close($ch);
		//echo $result;
		//return $res;
	}
	
	

}

?>
