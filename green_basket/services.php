<?php

/* Project Name: Green Basket Phonegap App 
 * @Author: Funki Developer
 * Company : Funki Orange software solution PVT. LTD
 * Email:greenbasketmobile@funkitechnologies.com
 * File Name: services
 * <info@greenbasket.com>
 */

@session_start();
define("__HOST", $_SERVER['HTTP_HOST']);
define("__ROOT", rtrim($_SERVER['DOCUMENT_ROOT'], "/"));
define("__REGARDS_FROM", "GreenBasket.");
define("__SUPPORT_EMAIL", "GreenBasket  Support <funkitest@gmail.com>");
define("__CONTACTUS_EMAIL", "GreenBasket  Support <contactus@greenbasket.com>");
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
	define("DB_NAME", "green_basket");
	define("FOLDER_NAME", "green_basket");
	define("FOLDER_URL", "http://" . __HOST . "/" . FOLDER_NAME . "/");
	define("__ROOT_DIR", __ROOT . "/" . FOLDER_NAME . "/");

	define("__MODE", "testing");
} else {

	//ini_set("display_errors", 0);
	define("DB_HOST", "localhost");
	define("DB_USER", "funkiora_greenba");
	define("DB_PASS", "f.xgq!Z)P3la");
	define("DB_NAME", "funkiora_green_basket");
	define("FOLDER_NAME", "GreenBasket");
	define("FOLDER_URL", "http://" . __HOST . "/" . FOLDER_NAME . "/");
	define("__ROOT_DIR", __ROOT . "/" . FOLDER_NAME . "/");

	define("__MODE", "testing");
}
$_POST['requestStr'] = $_REQUEST;

$_POST['requestStr'] = stripslashes(json_encode($_POST['requestStr']));
$_REQUESTSTR = json_decode($_POST['requestStr'], TRUE);

/* echo "POST DATA : \n----------------------------------\n";
  print_r($_REQUEST);
  echo "\n----------------------------------\n";

  die; */

require_once "class/class.db.php";

class Services extends DB {

	function construct() {
		parent::__construct();
	}

	// vendor sign up function
	function vendor_signup($vendor_details) {

		$res["error"] = "";
		$res["success"] = "false";
		if ($vendor_details['vendor_email'] == "") {
			$res["error"] = "Email address can't be blank";
		} else {
			$email_check_sql = "SELECT COUNT(*) AS `isexits`, `vendor_email` FROM `vendor_signup` WHERE `vendor_email` = '" . $vendor_details['vendor_email'] . "'";
			$execute_query = $this->query($email_check_sql);
			if ($execute_query[0]->isexits == 1) {
				$res["error"] = "Email address already exist";
			} else {
				if($vendor_details['vendor_pick_location_directly']==1){
					$latitude=$vendor_details['vendor_latitude'];
					$longitude=$vendor_details['vendor_longitude'];
					}else{
						$find_latlong = $this->getLnt($vendor_details['vendor_area'].','.$vendor_details['vendor_city']);
						$latitude=$find_latlong['lat'];
						$longitude=$find_latlong['lng'];
					}
				$data = array('vendor_shop_name' => $vendor_details['vendor_shop_name'],
					'vendor_mobile_number' => $vendor_details['vendor_mobile_number'],
					'vendor_email' => $vendor_details['vendor_email'],
					'vendor_password' => md5($vendor_details['vendor_password']),
					'vendor_shop_address' => $vendor_details['vendor_shop_address'],
					'vendor_area' => $vendor_details['vendor_area'],
					'vendor_city' => $vendor_details['vendor_city'],
					'another_city' => $vendor_details['another_city'],
					'another_area' => $vendor_details['another_area'],
					'vendor_sell_vegetables' => $vendor_details['vendor_sell_vegetables'],
					'vendor_sell_fruits' => $vendor_details['vendor_sell_fruits'],
					'vendor_pick_location_directly' => $vendor_details['vendor_pick_location_directly'],
					'vendor_latitude' => $latitude,
					'vendor_longitude' => $longitude,
					'vendor_approve_status' =>0,
					'vendor_signup_date_time' => date("Y-m-d H:i:s"));
				if ($this->insert(vendor_signup, $data)) {
					//$vendor_id = $this->last_insert_id();
					$sql_vendor_details = "select vendor_id, vendor_shop_name, vendor_mobile_number, vendor_email, vendor_shop_address, vendor_sell_vegetables, vendor_sell_fruits, vendor_pick_location_directly, vendor_latitude, vendor_longitude, vendor_active_status from vendor_signup where vendor_email ='" . $vendor_details["vendor_email"] . "'";
					$result = $this->query($sql_vendor_details);
					$res['vendor_details'] = $result;
					$res["vendor_id"] = $vendor_id;
					$res["success"] = "true";
				} else {
					$res['error'] = "Data not store in table.Please try again!";
				}
			}
		}
		return $res;
	}

	// Vendor sign in function
	function vendor_signin($vendor_details) {
		$res['error'] = "";
		$res['success'] = "false";
		$email = $vendor_details['vendor_email'];
		$password = md5($vendor_details['vendor_password']);
		if ($vendor_details["vendor_email"] == "") {
			$res['error'] = "Please provide me email address";
			$res['success'] = "false";
		} else {
			$login_check_sql = "SELECT COUNT(*) AS `isexits`, `vendor_email`, `vendor_password` FROM `vendor_signup` WHERE `vendor_email` = '" . $vendor_details["vendor_email"] . "' AND `vendor_password` = '" . $password . "' AND `vendor_approve_status` = '1'";
			$execute_query = $this->query($login_check_sql);
			if ($execute_query[0]->isexits == 1) {
				$sql_vendor_details = "select vendor_id, vendor_shop_name, vendor_mobile_number, vendor_email, vendor_shop_address, vendor_sell_vegetables, vendor_sell_fruits, vendor_pick_location_directly, vendor_latitude, vendor_longitude, vendor_active_status from vendor_signup where vendor_email ='" . $vendor_details['vendor_email'] . "'";
				$result = $this->query($sql_vendor_details);
				$res['vendor_details'] = $result;
				$res['success'] = "true";
			} else {
				$res['error'] = "Invalid Email and/or password";
			}
		}
		return $res;
	}

	function vendor_update($vendor_details) {
		$res["error"] = "";
		$res["success"] = "false";
		if ($vendor_details['vendor_email'] == "") {
			$res["error"] = "Please enter the email address";
		} else {
			$email_check_sql = "SELECT COUNT(*) AS `isexits` FROM `vendor_signup` WHERE `vendor_email` = '" . $vendor_details['vendor_email'] . "' AND (`vendor_email` = '" . $vendor_details['vendor_email'] . "' AND `vendor_id` != '" . $vendor_details["vendor_id"] . "')";
			$execute_query = $this->query($email_check_sql);
			if ($execute_query[0]->isexits == 1) {
				$res["error"] = "Email address already exits";
			} else {
				$data = array('vendor_shop_name' => $vendor_details['vendor_shop_name'],
					'vendor_mobile_number' => $vendor_details['vendor_mobile_number'],
					'vendor_email' => $vendor_details['vendor_email'],
					//'vendor_password' => md5($vendor_details['vendor_password']),
					'vendor_shop_address' => $vendor_details['vendor_shop_address'],
					'vendor_area' => $vendor_details['vendor_area'],
					'vendor_city' => $vendor_details['vendor_city'],
					'another_area' => $vendor_details['another_area'],
					'vendor_sell_vegetables' => $vendor_details['vendor_sell_vegetables'],
					'vendor_sell_fruits' => $vendor_details['vendor_sell_fruits'],
					'vendor_pick_location_directly' => $vendor_details['vendor_pick_location_directly'],
					'vendor_latitude' => $vendor_details['vendor_latitude'],
					'vendor_longitude' => $vendor_details['vendor_longitude']);
				if ($this->update("vendor_signup", $data, "vendor_id = '" . $vendor_details['vendor_id'] . "'")) {
					//$vendor_id = $this->last_insert_id();
					$sql_vendor_details = "select vendor_id, vendor_shop_name, vendor_mobile_number, vendor_email, vendor_shop_address, vendor_sell_vegetables, vendor_sell_fruits, vendor_pick_location_directly, vendor_latitude, vendor_longitude, vendor_active_status from vendor_signup where vendor_email ='" . $vendor_details["vendor_email"] . "'";
					$result = $this->query($sql_vendor_details);
					//$res['vendor_details'] = $result;
					//	$res["vendor_id"] = $vendor_id;
					$res["success"] = "true";
				} else {
					$res['error'] = "";
				}
			}
		}
		return $res;
	}

	// Send invoice to vendor and customer 
	function send_invoice($customer_details) {
		$res["error"] = "";
		$res["success"] = "false";
		$array_total_shopping = array();
		$array='';
		 $date = date("l, d M Y, H:i:s");
		$message = '';
		if ($customer_details['customer_mobile'] == "") {
			$res["error"] = "Please enter the customer mobile number";
		} else {
			/*if($customer_details["total_price"] < 100){
				$total_price=$customer_details["total_price"];
				$shpping_cost=10;
			}else{
				$total_price=$customer_details["total_price"];
				$shpping_cost=0;
			}*/
			$mobile_check_sql = "SELECT COUNT(*) AS `isexits` FROM `customer_signup` WHERE `customer_email` = '" . $customer_details['customer_email'] . "'";
			$execute_query = $this->query($mobile_check_sql);
			if ($execute_query[0]->isexits == 1) {
				$sql_customer_details = "select customer_id, customer_name,customer_latitude,customer_longitude,customer_mobile, customer_address, customer_city from customer_signup where `customer_email` = '" . $customer_details['customer_email'] . "'";
				$customer_result = $this->query($sql_customer_details);
				
				foreach ($customer_result as $customer_key => $customer_index) {
					$customer_id = $customer_index->customer_id;
					$customer_name = $customer_index->customer_name;
					$customer_address = $customer_index->customer_address;
					$customer_mobile = $customer_index->customer_mobile;				
					$customer_city = $customer_index->customer_city;				
				}
				//To get vendor details
				 $sql_vendor_details = "select vendor_shop_name, vendor_email, vendor_mobile_number, vendor_shop_address, vendor_city from vendor_signup where `vendor_id` = '" . $customer_details['vendor_id'] . "'";
				$vendor_result = $this->query($sql_vendor_details);				
				foreach ($vendor_result as $vendor_key => $vendor_index) {
					$vendor_email = $vendor_index->vendor_email;
					$vendor_shop_name = $vendor_index->vendor_shop_name;
					$vendor_mobile_number = $vendor_index->vendor_mobile_number;
					$vendor_shop_address = $vendor_index->vendor_shop_address;					
					$vendor_city = $vendor_index->vendor_city;					
				}				
				// To add new format of invoice
				
			$message .="<p>Hi,</p><br/><p>This is an email from GreenBasket.</p><p>Thank you for using our app to place an order with your local vendor.</p><br/><p>Here are the details of your new order:</p><p><table cellpadding='5'><tr>							<th>Item</th><th>Rate</th><th>Qty</th><th>Price</th></tr>";							
				for ($i = 0; $i < count($customer_details['product_details']); $i++) {
					if($customer_details["product_details"][$i]["product_price"] !=0){
					$product_sql = "select product_name, product_quantity_type from product where product_id ='" . $customer_details['product_details'][$i]['product_id'] . "'";
					$product_result = $this->query($product_sql);
					foreach ($product_result as $product_key => $product_index) {
						$product_name = $product_index->product_name;
						$product_quantity_type = $product_index->product_quantity_type;
					}
					$array_total_shopping[]=$customer_details["product_details"][$i]["product_price"];
					$message .="<tr><td>" . $product_name . "</td><td>Rs. " . $customer_details["product_details"][$i]["product_rate"] . "/" . $product_quantity_type . "</td><td>" . $customer_details["product_details"][$i]["product_quantity"] .  " " . $product_quantity_type . "</td><td>" . $customer_details["product_details"][$i]["product_price"] . "/-" . "</td></tr>";
					 $array.=$customer_details['product_details'][$i]['product_id'].',';
				}
				}
				 $product_id_array = rtrim($array,',');
				 $sum_total_product_price = array_sum($array_total_shopping);
				 if($sum_total_product_price < 100){
					$total_price =  $sum_total_product_price + 10;
					$shpping_cost =10;
				 }
				 else{
					 $shpping_cost=0;
					 $total_price =  $sum_total_product_price;
				 }
				$message .="<tr><td>Shipping</td><td></td><td></td><td>".$shpping_cost."/-</td></tr>";
			$message .="</table>";
					$message .="</p>";
					$message .="<p>(Rs. 10/- for orders below 100)</p>";
					$message .="<p>Total    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Rs. &nbsp;&nbsp;&nbsp; ".$total_price."/- </p>";					
					$message .="<p>This order will be shipped to:</p>";
					$message .="<p> Mr. ".$customer_name ."</p>";
					$message .="<p>".$customer_address ."</p>";
					$message .="<p>".$customer_city ."</p>";
					$message .="<p>Mobile number: ".$customer_mobile."</p>";
					$message .="<br/>";
					$message .="<p>Vendor details: </p>";
					$message .="<p>".$vendor_shop_name."</p>";
					$message .="<p>".$vendor_shop_address."</p>";
					$message .="<p>".$vendor_city."</p>";
					$message .="<p>Mobile number: ".$vendor_mobile_number."</p>";
					$message .="<br/>";
					$message .="<p>Note: GreenBasket only facilitates ordering from vendors. We do not deal with the goods ourselves and do not handl"; $message .="any payments for the goods mentioned above.</p>";
					$message .="<p>Kindly make the payment to the vendor directly on delivery after verifying your order.</p>";
					$message .="<p>GreenBasket does not take any responsibility for the quality of delivered goods or for the price quoted by the vendor.</p>";
					$message .="<p>Your use of GreenBasket is based on your acceptance of the terms and conditions at: <a href='#'>GreenBasket Terms of Use </a></p>";
					$message .="<br>";
					$message .="<p>If you did not place this order, kindly forward this email to us at support@greenbasket.com by changing the subject line to <b>De-register.</b> We shall promptly delete your email id from our database.</p>" .
					__REGARDS_FROM;
							

				$mail_data = array(
					"to" => $customer_details['customer_email'] . ',' . $vendor_email,
					"from" => __SUPPORT_EMAIL,
					"subject" => "Green Basket shopping details",
					"message" => $message
				);
				if ($this->sendMail($mail_data) == "success") {
					$res["success"] = "true";
					$res["customer_information"] = "Your shopping details has been send on your email address, Please check";
					//Save data in payment details save table
					$data = array('customer_id' => $customer_id,
				'vendor_id' => $customer_details['vendor_id'],
				'product_id' => $product_id_array,
				'total_payments' => $total_price,
				'payment_date_time' => date("Y-m-d H:i:s"));
				$this->insert(payment_details, $data);
				} else {
					$res['error'] = "Sorry!Your details do not send your email address. try again";
				}

				//echo $message;
			} else {
				$email_check_sql = "SELECT COUNT(*) AS `isexits`, `customer_email` FROM `customer_signup` WHERE `customer_email` = '" . $customer_details['customer_email'] . "'";
				$execute_query = $this->query($email_check_sql);
				if ($execute_query[0]->isexits == 1) {
					$res["error"] = "Email address already exist";
				} else {
					$data = array('customer_name' => $customer_details['customer_name'],
						'customer_mobile' => $customer_details['customer_mobile'],
						'customer_address' => $customer_details['customer_address'],
						'customer_area' => $customer_details['customer_area'],
						'customer_city' => $customer_details['customer_city'],
						'customer_email' => $customer_details['customer_email'],
						'customer_latitude' => $customer_details['customer_latitude'],
						'customer_longitude' => $customer_details['customer_longitude'],
						'customer_approve_status' => 1,
						'customer_signup_date_time' => date("Y-m-d H:i:s"));
					if ($this->insert(customer_signup, $data)) {
						$customer_id = $this->last_insert_id();
			//To get vendor details
				$sql_vendor_details = "select vendor_shop_name, vendor_email, vendor_mobile_number, vendor_shop_address, vendor_city from vendor_signup where `vendor_id` = '" . $customer_details['vendor_id'] . "'";
				$vendor_result = $this->query($sql_vendor_details);				
				foreach ($vendor_result as $vendor_key => $vendor_index) {
					$vendor_shop_name = $vendor_index->vendor_shop_name;
					$vendor_email = $vendor_index->vendor_email;
					$vendor_mobile_number = $vendor_index->vendor_mobile_number;
					$vendor_shop_address = $vendor_index->vendor_shop_address;					
					$vendor_city = $vendor_index->vendor_city;					
				}				
				// To add new format of invoice
			$message .="<p>Hi,</p><br/><p>This is an email from GreenBasket.</p><p>Thank you for using our app to place an order with your local vendor.</p><br/><p>Here are the details of your new order:</p><p><table cellpadding='5'><tr>							<th>Item</th><th>Rate</th><th>Qty</th><th>Price</th></tr>";							
				for ($i = 0; $i < count($customer_details['product_details']); $i++) {
					$product_sql = "select product_name, product_quantity_type from product where product_id ='" . $customer_details['product_details'][$i]['product_id'] . "'";
					$product_result = $this->query($product_sql);
					foreach ($product_result as $product_key => $product_index) {
						$product_name = $product_index->product_name;
						$product_quantity_type = $product_index->product_quantity_type;
					}
					$array_total_shopping[]=$customer_details["product_details"][$i]["product_price"];
					$message .="<tr><td>" . $product_name . "</td><td>Rs. " . $customer_details["product_details"][$i]["product_rate"] . "/" . $product_quantity_type . "</td><td>" . $customer_details["product_details"][$i]["product_quantity"] .  " " . $product_quantity_type . "</td><td>" . $customer_details["product_details"][$i]["product_price"] . "/-" . "</td></tr>";
					 $array.=$customer_details['product_details'][$i]['product_id'].',';
				}
				 $product_id_array = rtrim($array,',');
				 $sum_total_product_price = array_sum($array_total_shopping);
				  if($sum_total_product_price < 100){
					$total_price =  $sum_total_product_price + 10;
					$shpping_cost =10;
				 }
				 else{
					 $shpping_cost=0;
					 $total_price =  $sum_total_product_price;
				 }
				$message .="<tr><td>Shipping</td><td></td><td></td><td>".$shpping_cost."/-</td></tr>";
			$message .="</table>";
					$message .="</p>";
					$message .="<p>(Rs. 10/- for orders below 100)</p>";
					$message .="<p>Total    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Rs. &nbsp;&nbsp;&nbsp; ".$total_price."/- </p>";
					
					$message .="<p>This order will be shipped to:</p>";
					$message .="<p> Mr. ".$customer_details['customer_name'] ."</p>";
					$message .="<p>".$customer_details['customer_address'] ."</p>";
					$message .="<p>".$customer_details['customer_city'] ."</p>";
					$message .="<p>Mobile number: ".$customer_details['customer_mobile']."</p>";
					$message .="<br/>";
					$message .="<p>Vendor details: </p>";
					$message .="<p>".$vendor_shop_name."</p>";
					$message .="<p>".$vendor_shop_address."</p>";
					$message .="<p>".$vendor_city."</p>";
					$message .="<p>Mobile number: ".$vendor_mobile_number."</p>";
					$message .="<br/>";
					$message .="<p>Note: GreenBasket only facilitates ordering from vendors. We do not deal with the goods ourselves and do not handl"; $message .="any payments for the goods mentioned above.</p>";
					$message .="<p>Kindly make the payment to the vendor directly on delivery after verifying your order.</p>";
					$message .="<p>GreenBasket does not take any responsibility for the quality of delivered goods or for the price quoted by the vendor.</p>";
					$message .="<p>Your use of GreenBasket is based on your acceptance of the terms and conditions at: <a href='#'>GreenBasket Terms of Use </a></p>";
					$message .="<br>";
					$message .="<p>If you did not place this order, kindly forward this email to us at support@greenbasket.com by changing the subject line to <b>De-register.</b> We shall promptly delete your email id from our database.</p>" .
					__REGARDS_FROM;				
						
						$mail_data = array(
							"to" => $customer_details['customer_email'] . ',' . $vendor_email,
							"from" => __SUPPORT_EMAIL,
							"subject" => "Green Basket shopping details",
							"message" => $message
						);
						if ($this->sendMail($mail_data) == "success") {
							$res["success"] = "true";
							$res["customer_information"] = "Your shopping details has been send on your email address, Please check";
							//Save data in payment details save table
							$data = array('customer_id' => $customer_id,
							'vendor_id' => $customer_details['vendor_id'],
							'product_id' => $product_id_array,
							'total_payments' => $total_price,
							'payment_date_time' => date("Y-m-d H:i:s"));
							$this->insert(payment_details, $data);
						} else {
							$res['error'] = "Sorry!Your details do not send your email address. try again";
						}
						//echo $message;
					} else {
						$res['error'] = "Customer details do not store in table.Please try again!";
					}
				}
			}
		}
		return $res;
	}

	// Payments Details save
	function payment_details_save($payment_details) {
		$res["error"] = "";
		$res["success"] = "false";
		if ($payment_details['customer_id'] == "" || $payment_details['vendor_id'] == "") {
			$res["error"] = "Please provide me customer id and vendor id";
		} else {
			$data = array('customer_id' => $payment_details['customer_id'],
				'vendor_id' => $payment_details['vendor_id'],
				'product_id' => $payment_details['product_id'],
				'total_payments' => $payment_details['total_payments'],
				'payment_date_time' => date("Y-m-d H:i:s"));
			if ($this->insert(payment_details, $data)) {
				$payments_id = $this->last_insert_id();
				$sql_payments = "select payment_id, customer_id, vendor_id, product_id, total_payments from payment_details where payment_id ='" . $payments_id . "'";
				$result = $this->query($sql_payments);
				$res['payments_details'] = $result;
				$res['success'] = "true";
			} else {
				$res['error'] = "Data not store in table.Please try again!";
			}
		}
		return $res;
	}

	// Customer feedback message save
	function feedback_message_save($feedback_message) {
		$res["error"] = "";
		$res["success"] = "false";
		$data = array('customer_name' => $feedback_message['customer_name'],
			'customer_mobile_number' => $feedback_message['customer_mobile_number'],
			'feedback_message' => $feedback_message['feedback_message'],
			'feedback_date_time' => date("Y-m-d H:i:s"));
		if ($this->insert(customer_feedback, $data)) {
			//$res['success'] = "true";
			//$res['success_msg'] = "Thank you for given feedback my services";
			// Send mail
		
			$feedback_msg.='<p><b>Customer Name:</b> ' . $feedback_message['customer_name'] . '</p>';
			$feedback_msg.='<p><b>Customer Mobile Number :</b> ' . $feedback_message['customer_mobile_number'] . '</p>';
			$feedback_msg.='<p><b>Feedback Message :</b>' . $feedback_message['feedback_message'] . '</p>';
			$feedback_msg.='Thank you,<br />' . $feedback_message['customer_name'];
			$feedback_msg  .='<br />' . date("Y-m-d H:i:s");
			$mail_data = array(
				"to" => __SUPPORT_EMAIL,
				"from" => __CONTACTUS_EMAIL,
				"subject" => "Form submission from : Green Basket Feedback Message",
				"message" => $feedback_msg
			);
			if ($this->sendMail($mail_data) == "success") {
				$res["success"] = "true";
				$res['success_msg'] = "Thank you for given feedback my services";
				//$sucess_msg.= '<h1 style="<h1 style="center">Thanks! </h1>';
				//$sucess_msg.='<p>We appreciate that you’ve taken the time to write us. We’ll get back to you very soon. Please come back and see us often.</p>';
				//$res["sucess_msg"] = $sucess_msg;
			} else {
				$res['error'] = "Sorry!Your query not send to Green Basket. try again";
			}			
		} else {
			$res['error'] = "Sorry!Your query not send to Green Basket. try again";
		}
		//echo $feedback_msg;
		return $res;
	}
	
	// Vendor list for near my home
	function vendors_list_near_my_home($vegetables_vendor) {
		$res["error"] = "";
		$res["success"] = "false";
		$array = array();
		$customer_latitude = $vegetables_vendor['customer_latitude'];
		$customer_longitude = $vegetables_vendor['customer_longitude'];
		if ($vegetables_vendor['like_type'] == "") {
			$res["error"] = "Please provide me like type";
		} else {
			if ($vegetables_vendor['like_type'] == 111) {

				  $sql_vendor_details = "select vendor_id, vendor_shop_name, vendor_latitude, vendor_longitude from vendor_signup WHERE vendor_approve_status = '1' AND vendor_active_status = '1'";
				$result = $this->query($sql_vendor_details);
				foreach ($result as $key => $lat_log) {
					$vendor_id = $lat_log->vendor_id;
					$vendor_shop_name = $lat_log->vendor_shop_name;
					//	$vendor_mobile_number=$lat_log -> vendor_mobile_number;
					//	$vendor_email=$lat_log -> vendor_email;
					//	$vendor_shop_address=$lat_log -> vendor_shop_address;					
					$latitude2 = $lat_log->vendor_latitude;
					$longitude2 = $lat_log->vendor_longitude;
					$latitude1 = $customer_latitude;
					$longitude1 = $customer_longitude;
					$theta = $longitude1 - $longitude2;
					$miles = (sin(deg2rad($latitude1)) * sin(deg2rad($latitude2))) + (cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($theta)));
					$miles = acos($miles);
					$miles = rad2deg($miles);
					$km = $miles * 60 * 1.1515 * 1.60934;
					if ($km <= 2.000) {
						$rating_result = $this->vendor_average_rating($vendor_id);
						foreach ($rating_result as $rating_key => $rating_index) {
							$rating = $rating_index->rating;
							if ($rating == "") {
								$rating_value = "0";
							} else {
								$rating_value = round($rating, 1);
							}
						}
						$array[]=array(
							"vendor_id" => $vendor_id,
							"vendor_rating" => $rating_value,
							"vendor_shop_name" => $vendor_shop_name
								//"vendor_mobile_number" => $vendor_mobile_number, 
								//"vendor_email" => $vendor_email,
								//"vendor_shop_address" => $vendor_shop_address							   
						);
						//$array=$result;
					}
					
				}
			} elseif ($vegetables_vendor['like_type'] == 1) {
				$sql_vendor_details = "select vendor_id, vendor_shop_name, vendor_latitude, vendor_longitude from vendor_signup WHERE vendor_approve_status = '1' AND vendor_active_status = '1' AND vendor_sell_fruits = '1'";
				$result = $this->query($sql_vendor_details);
				foreach ($result as $key => $lat_log) {
					$vendor_id = $lat_log->vendor_id;
					$vendor_shop_name = $lat_log->vendor_shop_name;
					$vendor_mobile_number = $lat_log->vendor_mobile_number;
					$vendor_email = $lat_log->vendor_email;
					$vendor_shop_address = $lat_log->vendor_shop_address;
					$latitude2 = $lat_log->vendor_latitude;
					$longitude2 = $lat_log->vendor_longitude;
					$latitude1 = $customer_latitude;
					$longitude1 = $customer_longitude;
					$theta = $longitude1 - $longitude2;
					$miles = (sin(deg2rad($latitude1)) * sin(deg2rad($latitude2))) + (cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($theta)));
					$miles = acos($miles);
					$miles = rad2deg($miles);
					$km = $miles * 60 * 1.1515 * 1.60934;
					if ($km <= 2.000) {
						$rating_result = $this->vendor_average_rating($vendor_id);
						foreach ($rating_result as $rating_key => $rating_index) {
							$rating = $rating_index->rating;
							if ($rating == "") {
								$rating_value = "0";
							} else {
								$rating_value = round($rating, 1);
							}
						}
						array_push($array, array(
							"vendor_id" => $vendor_id,
							"vendor_rating" => $rating_value,
							"vendor_shop_name" => $vendor_shop_name
								//"vendor_mobile_number" => $vendor_mobile_number, 
								// "vendor_email" => $vendor_email,
								// "vendor_shop_address" => $vendor_shop_address							   
						));
					}
				}
			} 
			
			elseif ($vegetables_vendor['like_type'] == 0 || $vegetables_vendor['like_type'] =='') {
				 $sql_vendor_details = "select vendor_id, vendor_shop_name, vendor_latitude, vendor_longitude from vendor_signup WHERE vendor_approve_status = '1' AND vendor_active_status = '1'";
				$result = $this->query($sql_vendor_details);
				//print_r($result);
				foreach ($result as $key => $lat_log) {
					$vendor_id = $lat_log->vendor_id;
					$vendor_shop_name = $lat_log->vendor_shop_name;
					$vendor_mobile_number = $lat_log->vendor_mobile_number;
					$vendor_email = $lat_log->vendor_email;
					$vendor_shop_address = $lat_log->vendor_shop_address;
					$latitude2 = $lat_log->vendor_latitude;
					$longitude2 = $lat_log->vendor_longitude;
					$latitude1 = $customer_latitude;
					$longitude1 = $customer_longitude;
					$theta = $longitude1 - $longitude2;
					$miles = (sin(deg2rad($latitude1)) * sin(deg2rad($latitude2))) + (cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($theta)));
					$miles = acos($miles);
					$miles = rad2deg($miles);
					$km = $miles * 60 * 1.1515 * 1.60934;
					 //echo $km .'<br>';
					if ($km <= 2.000) {	
					$rating_result = $this->vendor_average_rating($vendor_id);
						foreach ($rating_result as $rating_key => $rating_index) {
							$rating = $rating_index->rating;
							if ($rating == "") {
								$rating_value = "0";
							} else {
								$rating_value = round($rating, 1);
							}
						}
						array_push($array, array(
							"vendor_id" => $vendor_id,
							"vendor_rating" => $rating_value,
							"vendor_shop_name" => $vendor_shop_name
								//"vendor_mobile_number" => $vendor_mobile_number, 
								// "vendor_email" => $vendor_email,
								// "vendor_shop_address" => $vendor_shop_address							   
						));
						//print_r($array);
					}
				}
			}else {
				if ($vegetables_vendor['like_type'] == 2) {
					$sql_vendor_details = "select vendor_id, vendor_shop_name, vendor_latitude, vendor_longitude from vendor_signup WHERE vendor_approve_status = '1' AND vendor_active_status = '1' AND vendor_sell_vegetables = '1'";
					$result = $this->query($sql_vendor_details);
					foreach ($result as $key => $lat_log) {
						$vendor_id = $lat_log->vendor_id;
						$vendor_shop_name = $lat_log->vendor_shop_name;
						$vendor_mobile_number = $lat_log->vendor_mobile_number;
						$vendor_email = $lat_log->vendor_email;
						$vendor_shop_address = $lat_log->vendor_shop_address;
						$latitude2 = $lat_log->vendor_latitude;
						$longitude2 = $lat_log->vendor_longitude;
						$latitude1 = $customer_latitude;
						$longitude1 = $customer_longitude;
						$theta = $longitude1 - $longitude2;
						$miles = (sin(deg2rad($latitude1)) * sin(deg2rad($latitude2))) + (cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($theta)));
						$miles = acos($miles);
						$miles = rad2deg($miles);
						$km = $miles * 60 * 1.1515 * 1.60934;
						if ($km <= 2.000) {
							$rating_result = $this->vendor_average_rating($vendor_id);
							foreach ($rating_result as $rating_key => $rating_index) {
								$rating = $rating_index->rating;
								if ($rating == "") {
									$rating_value = "0";
								} else {
									$rating_value = round($rating, 1);
								}
							}

							array_push($array, array(
								"vendor_id" => $vendor_id,
								"vendor_rating" => $rating_value,
								"vendor_shop_name" => $vendor_shop_name
									//"vendor_mobile_number" => $vendor_mobile_number, 
									// "vendor_email" => $vendor_email,
									// "vendor_shop_address" => $vendor_shop_address							   
							));
						}
					}
				}
			}
		}
		if (empty($array)) {
			$res["error"] = "Sorry, no vendors are found in your area.";
			
		} else {
			$res["success"] = "true";
			$res['vendor_list'] = $array;
		}

		return $res;
	}

	// Vendor list like_type=0 for both and like_type=1 for fruits and like_type=2 for vegetables
	function vendors_list($vegetables_vendor) {
		$res["error"] = "";
		$res["success"] = "false";
		$array = array();
		$customer_latitude = $vegetables_vendor['customer_latitude'];
		$customer_longitude = $vegetables_vendor['customer_longitude'];
		if ($vegetables_vendor['like_type'] == "") {
			$res["error"] = "Please provide me like type";
		} else {
			if ($vegetables_vendor['like_type'] == 111) {

				  $sql_vendor_details = "select vendor_id, vendor_shop_name, vendor_latitude, vendor_longitude from vendor_signup WHERE vendor_approve_status = '1' AND vendor_active_status = '1'";
				$result = $this->query($sql_vendor_details);
				foreach ($result as $key => $lat_log) {
					$vendor_id = $lat_log->vendor_id;
					$vendor_shop_name = $lat_log->vendor_shop_name;
					//	$vendor_mobile_number=$lat_log -> vendor_mobile_number;
					//	$vendor_email=$lat_log -> vendor_email;
					//	$vendor_shop_address=$lat_log -> vendor_shop_address;					
					$latitude2 = $lat_log->vendor_latitude;
					$longitude2 = $lat_log->vendor_longitude;
					$latitude1 = $customer_latitude;
					$longitude1 = $customer_longitude;
					$theta = $longitude1 - $longitude2;
					$miles = (sin(deg2rad($latitude1)) * sin(deg2rad($latitude2))) + (cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($theta)));
					$miles = acos($miles);
					$miles = rad2deg($miles);
					$km = $miles * 60 * 1.1515 * 1.60934;
					if ($km <= 2.000) {
						$rating_result = $this->vendor_average_rating($vendor_id);
						foreach ($rating_result as $rating_key => $rating_index) {
							$rating = $rating_index->rating;
							if ($rating == "") {
								$rating_value = "0";
							} else {
								$rating_value = round($rating, 1);
							}
						}
						$array[]=array(
							"vendor_id" => $vendor_id,
							"vendor_rating" => $rating_value,
							"vendor_shop_name" => $vendor_shop_name
								//"vendor_mobile_number" => $vendor_mobile_number, 
								//"vendor_email" => $vendor_email,
								//"vendor_shop_address" => $vendor_shop_address							   
						);
						//$array=$result;
					}
					
				}
			} elseif ($vegetables_vendor['like_type'] == 1) {
				$sql_vendor_details = "select vendor_id, vendor_shop_name, vendor_latitude, vendor_longitude from vendor_signup WHERE vendor_approve_status = '1' AND vendor_active_status = '1' AND vendor_sell_fruits = '1'";
				$result = $this->query($sql_vendor_details);
				foreach ($result as $key => $lat_log) {
					$vendor_id = $lat_log->vendor_id;
					$vendor_shop_name = $lat_log->vendor_shop_name;
					$vendor_mobile_number = $lat_log->vendor_mobile_number;
					$vendor_email = $lat_log->vendor_email;
					$vendor_shop_address = $lat_log->vendor_shop_address;
					$latitude2 = $lat_log->vendor_latitude;
					$longitude2 = $lat_log->vendor_longitude;
					$latitude1 = $customer_latitude;
					$longitude1 = $customer_longitude;
					$theta = $longitude1 - $longitude2;
					$miles = (sin(deg2rad($latitude1)) * sin(deg2rad($latitude2))) + (cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($theta)));
					$miles = acos($miles);
					$miles = rad2deg($miles);
					$km = $miles * 60 * 1.1515 * 1.60934;
					if ($km <= 2.000) {
						$rating_result = $this->vendor_average_rating($vendor_id);
						foreach ($rating_result as $rating_key => $rating_index) {
							$rating = $rating_index->rating;
							if ($rating == "") {
								$rating_value = "0";
							} else {
								$rating_value = round($rating, 1);
							}
						}
						array_push($array, array(
							"vendor_id" => $vendor_id,
							"vendor_rating" => $rating_value,
							"vendor_shop_name" => $vendor_shop_name
								//"vendor_mobile_number" => $vendor_mobile_number, 
								// "vendor_email" => $vendor_email,
								// "vendor_shop_address" => $vendor_shop_address							   
						));
					}
				}
			} 
			
			elseif ($vegetables_vendor['like_type'] == 0 || $vegetables_vendor['like_type'] =='') {
				 $sql_vendor_details = "select vendor_id, vendor_shop_name, vendor_latitude, vendor_longitude from vendor_signup WHERE vendor_approve_status = '1' AND vendor_active_status = '1'";
				$result = $this->query($sql_vendor_details);
				//print_r($result);
				foreach ($result as $key => $lat_log) {
					$vendor_id = $lat_log->vendor_id;
					$vendor_shop_name = $lat_log->vendor_shop_name;
					$vendor_mobile_number = $lat_log->vendor_mobile_number;
					$vendor_email = $lat_log->vendor_email;
					$vendor_shop_address = $lat_log->vendor_shop_address;
					$latitude2 = $lat_log->vendor_latitude;
					$longitude2 = $lat_log->vendor_longitude;
					$latitude1 = $customer_latitude;
					$longitude1 = $customer_longitude;
					$theta = $longitude1 - $longitude2;
					$miles = (sin(deg2rad($latitude1)) * sin(deg2rad($latitude2))) + (cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($theta)));
					$miles = acos($miles);
					$miles = rad2deg($miles);
					$km = $miles * 60 * 1.1515 * 1.60934;
					 //echo $km .'<br>';
					if ($km <= 2.000) {	
					$rating_result = $this->vendor_average_rating($vendor_id);
						foreach ($rating_result as $rating_key => $rating_index) {
							$rating = $rating_index->rating;
							if ($rating == "") {
								$rating_value = "0";
							} else {
								$rating_value = round($rating, 1);
							}
						}
						array_push($array, array(
							"vendor_id" => $vendor_id,
							"vendor_rating" => $rating_value,
							"vendor_shop_name" => $vendor_shop_name
								//"vendor_mobile_number" => $vendor_mobile_number, 
								// "vendor_email" => $vendor_email,
								// "vendor_shop_address" => $vendor_shop_address							   
						));
						//print_r($array);
					}
				}
			}
			
			
			
			
			
			else {
				if ($vegetables_vendor['like_type'] == 2) {
					$sql_vendor_details = "select vendor_id, vendor_shop_name, vendor_latitude, vendor_longitude from vendor_signup WHERE vendor_approve_status = '1' AND vendor_active_status = '1' AND vendor_sell_vegetables = '1'";
					$result = $this->query($sql_vendor_details);
					foreach ($result as $key => $lat_log) {
						$vendor_id = $lat_log->vendor_id;
						$vendor_shop_name = $lat_log->vendor_shop_name;
						$vendor_mobile_number = $lat_log->vendor_mobile_number;
						$vendor_email = $lat_log->vendor_email;
						$vendor_shop_address = $lat_log->vendor_shop_address;
						$latitude2 = $lat_log->vendor_latitude;
						$longitude2 = $lat_log->vendor_longitude;
						$latitude1 = $customer_latitude;
						$longitude1 = $customer_longitude;
						$theta = $longitude1 - $longitude2;
						$miles = (sin(deg2rad($latitude1)) * sin(deg2rad($latitude2))) + (cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($theta)));
						$miles = acos($miles);
						$miles = rad2deg($miles);
						$km = $miles * 60 * 1.1515 * 1.60934;
						if ($km <= 2.000) {
							$rating_result = $this->vendor_average_rating($vendor_id);
							foreach ($rating_result as $rating_key => $rating_index) {
								$rating = $rating_index->rating;
								if ($rating == "") {
									$rating_value = "0";
								} else {
									$rating_value = round($rating, 1);
								}
							}

							array_push($array, array(
								"vendor_id" => $vendor_id,
								"vendor_rating" => $rating_value,
								"vendor_shop_name" => $vendor_shop_name
									//"vendor_mobile_number" => $vendor_mobile_number, 
									// "vendor_email" => $vendor_email,
									// "vendor_shop_address" => $vendor_shop_address							   
							));
						}
					}
				}
			}
		}
		if (empty($array)) {
			$res["error"] = "Sorry, no vendors are found in your area.";
			
		} else {
			$res["success"] = "true";
			$res['vendor_list'] = $array;
		}

		return $res;
	}

	// customer information update or ship another address send
	function customer_information_check($information_check) {
		$res["error"] = "";
		$res["success"] = "false";

		if ($information_check['customer_mobile'] == "") {
			$res["error"] = "Please enter the customer mobile number";
		} else {
			$mobile_check_sql = "SELECT COUNT(*) AS `isexits` FROM `customer_signup` WHERE `customer_mobile` = '" . $information_check['customer_mobile'] . "'";
			$execute_query = $this->query($mobile_check_sql);
			if ($execute_query[0]->isexits != 1) {
				$res['error'] = "Mobile number does not exits";
			} else {
				$customer_sql = "SELECT `customer_id`, `customer_name`, `customer_email` FROM `customer_signup` WHERE `customer_mobile` = '" . $information_check['customer_mobile'] . "'";
				$execute_query = $this->query($customer_sql);
				$res["success"] = "true";
				$res['customer_information'] = $execute_query;
			}
		}
		return $res;
	}

	// Shipping address save or customer information update  "'".$customer_details['customer_email'].','.$vendor_email"'"
	function shipping_address_save($customer_details) {
		$res["error"] = "";
		$res["success"] = "false";
		$array='';
		$array_total_shopping = array();
		$date = date("l, d M Y, H:i:s");
		/*if ($customer_details['customer_mobile'] == "") {
			$res["error"] = "Please enter the customer mobile number";
		} else {*/
			/*if($customer_details["total_price"] < 100){
				$total_price=$customer_details["total_price"] + 10;
				$shpping_cost=10;
			}else{
				$total_price=$customer_details["total_price"];
				$shpping_cost=0;
			}*/
		/*	$sql_vendor = "select vendor_email from vendor_signup where vendor_id ='" . $customer_details["vendor_id"] . "'";
			$result_vendor = $this->query($sql_vendor);
			foreach ($result_vendor as $vendor_key => $vendor_index) {
				$vendor_email = $vendor_index->vendor_email;
			}*/

			if ($customer_details['update'] == 1) {
				$mobile_check_sql = "SELECT COUNT(*) AS `isexits`,customer_id FROM `customer_signup` WHERE `customer_mobile` = '" . $customer_details['customer_mobile'] . "' AND (`customer_mobile` = '" . $customer_details['customer_mobile'] . "' AND `customer_id` != '" . $customer_details["customer_id"] . "')";
				$execute_query = $this->query($mobile_check_sql);
				/*if ($execute_query[0]->isexits == 1) {
					$res['error'] = "Mobile number already exits";
				} else {*/
					$email_check_sql = "SELECT COUNT(*) AS `isexits` FROM `customer_signup` WHERE `customer_email` = '" . $customer_details['customer_email'] . "' AND `customer_id` != '" . $customer_details["customer_id"] . "'";
					$execute_query = $this->query($email_check_sql);					
						$find_latlong = $this->getLnt($customer_details['customer_area'].','.$customer_details['customer_city']);
						$data = array('customer_name' => $customer_details['customer_name'],
							'customer_mobile' => $customer_details['customer_mobile'],
							'customer_address' => $customer_details['customer_address'],
							'customer_area' => $customer_details['customer_area'],
							'customer_city' => $customer_details['customer_city'],
							'customer_email' => $customer_details['customer_email'],
							'customer_latitude' => $find_latlong['lat'],
							'customer_longitude' =>  $find_latlong['lng']);
						if ($this->update("customer_signup", $data, "customer_id = '" . $customer_details['customer_id'] . "'")) {
							$sql_customer_details = "select customer_id, customer_name, customer_mobile, customer_address, customer_area, customer_city, customer_email, customer_latitude, customer_longitude from customer_signup where customer_mobile ='" . $customer_details["customer_mobile"] . "'";
							$result = $this->query($sql_customer_details);
							$res['customer_details'] = $result;

						//To get vendor details
				$sql_vendor_details = "select vendor_shop_name, vendor_email, vendor_mobile_number, vendor_shop_address, vendor_city from vendor_signup where `vendor_id` = '" . $customer_details['vendor_id'] . "'";
				$vendor_result = $this->query($sql_vendor_details);				
				foreach ($vendor_result as $vendor_key => $vendor_index) {
					$vendor_shop_name = $vendor_index->vendor_shop_name;
					$vendor_email = $vendor_index->vendor_email;
					$vendor_mobile_number = $vendor_index->vendor_mobile_number;
					$vendor_shop_address = $vendor_index->vendor_shop_address;
					$vendor_city = $vendor_index->vendor_city;					
				}				
				// To add new format of invoice
			$message .="<p>Hi,</p><br/><p>This is an email from GreenBasket.</p><p>Thank you for using our app to place an order with your local vendor.</p><br/><p>Here are the details of your new order:</p><p><table cellpadding='5'><tr>							<th>Item</th><th>Rate</th><th>Qty</th><th>Price</th></tr>";							
				for ($i = 0; $i < count($customer_details['product_details']); $i++) {
					if($customer_details["product_details"][$i]["product_price"] !=0){
					$product_sql = "select product_name, product_quantity_type from product where product_id ='" . $customer_details['product_details'][$i]['product_id'] . "'";
					$product_result = $this->query($product_sql);
					foreach ($product_result as $product_key => $product_index) {
						$product_name = $product_index->product_name;
						$product_quantity_type = $product_index->product_quantity_type;
					}
					$message .="<tr><td>" . $product_name . "</td><td>Rs. " . $customer_details["product_details"][$i]["product_rate"] . "/" . $product_quantity_type . "</td><td>" . $customer_details["product_details"][$i]["product_quantity"] .  " " . $product_quantity_type . "</td><td>" . $customer_details["product_details"][$i]["product_price"] . "/-" . "</td></tr>";
					 $array.=$customer_details['product_details'][$i]['product_id'].',';
					 $array_total_shopping[]=$customer_details["product_details"][$i]["product_price"];
				}
				}
				 $product_id_array = rtrim($array,',');
				 $sum_total_product_price = array_sum($array_total_shopping);
				  if($sum_total_product_price < 100){
					$total_price =  $sum_total_product_price + 10;
					$shpping_cost =10;
				 }
				 else{
					 $shpping_cost=0;
					 $total_price =  $sum_total_product_price;
				 }
				$message .="<tr><td>Shipping</td><td></td><td></td><td>".$shpping_cost."/-</td></tr>";
			$message .="</table>";
					$message .="</p>";
					$message .="<p>(Rs. 10/- for orders below 100)</p>";
					$message .="<p>Total    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Rs. &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ".$total_price."/- </p>";
					
					$message .="<p>This order will be shipped to:</p>";
					$message .="<p> Mr. ".$customer_details['customer_name'] ."</p>";
					$message .="<p>".$customer_details['customer_address'] ."</p>";
					$message .="<p>".$customer_details['customer_city'] ."</p>";
					$message .="<p>Mobile number: ".$customer_details['customer_mobile']."</p>";
					$message .="<br/>";
					$message .="<p>Vendor details: </p>";
					$message .="<p>".$vendor_shop_name."</p>";
					$message .="<p>".$vendor_shop_address."</p>";
					$message .="<p>".$vendor_city."</p>";
					$message .="<p>Mobile number: ".$vendor_mobile_number."</p>";
					$message .="<br/>";
					$message .="<p>Note: GreenBasket only facilitates ordering from vendors. We do not deal with the goods ourselves and do not handle "; $message .="any payments for the goods mentioned above.</p>";
					$message .="<p>Kindly make the payment to the vendor directly on delivery after verifying your order.</p>";
					$message .="<p>GreenBasket does not take any responsibility for the quality of delivered goods or for the price quoted by the vendor.</p>";
					$message .="<p>Your use of GreenBasket is based on your acceptance of the terms and conditions at: <a href='#'>GreenBasket Terms of Use </a></p>";
					$message .="<br>";
					$message .="<p>If you did not place this order, kindly forward this email to us at support@greenbasket.com by changing the subject line to <b>De-register.</b> We shall promptly delete your email id from our database.</p>" .
					__REGARDS_FROM;								
							$mail_data = array(
								"to" => $customer_details['customer_email'] . ',' . $vendor_email,
								"from" => __SUPPORT_EMAIL,
								"subject" => "Green Basket shopping details",
								"message" => $message
							);
							if ($this->sendMail($mail_data) == "success") {
								$res["success"] = "true";
								$res["customer_information"] = "Your shopping details has been send your email address, Please check";
								//Save data in payment details save table
							$data = array('customer_id' => $customer_details['customer_id'],
							'vendor_id' => $customer_details['vendor_id'],
							'product_id' => $product_id_array,
							'total_payments' => $total_price,
							'payment_date_time' => date("Y-m-d H:i:s"));
							$this->insert(payment_details, $data);
							} else {
								$res['error'] = "Sorry!Your details do not send your email address. try again";
							}
							//echo $message;
						} else {
							$res['error'] = "Customer details do not update.Please try again!";
						}
					
				//}
			} else {
				/*$mobile_check_sql = "SELECT COUNT(*) AS `isexits` FROM `shipping_address` WHERE `mobile_number` = '" . $customer_details['customer_mobile'] . "'";
				$execute_query = $this->query($mobile_check_sql);
				if ($execute_query[0]->isexits == 1) {
					$res['error'] = "Mobile number already exits";
				} else {*/
					$email_check_sql = "SELECT COUNT(*) AS `isexits` FROM `shipping_address` WHERE `email_address` = '" . $customer_details['customer_email'] . "'";
					$execute_query = $this->query($email_check_sql);
					$shiping_data = array('name' => $customer_details['customer_name'],
							'mobile_number' => $customer_details['customer_mobile'],
							'address' => $customer_details['customer_address'],
							'area' => $customer_details['customer_area'],
							'city' => $customer_details['customer_city'],
							'email_address' => $customer_details['customer_email'],
							'customer_id' => $customer_details['customer_id']);
						if ($this->insert("shipping_address", $shiping_data)) {
						//To get vendor details
				$sql_vendor_details = "select vendor_shop_name, vendor_email, vendor_mobile_number, vendor_shop_address, vendor_city from vendor_signup where `vendor_id` = '" . $customer_details['vendor_id'] . "'";
				$vendor_result = $this->query($sql_vendor_details);				
				foreach ($vendor_result as $vendor_key => $vendor_index) {
					$vendor_shop_name = $vendor_index->vendor_shop_name;
					$vendor_email = $vendor_index->vendor_email;
					$vendor_mobile_number = $vendor_index->vendor_mobile_number;
					$vendor_shop_address = $vendor_index->vendor_shop_address;	
					$vendor_city = $vendor_index->vendor_city;				
				}				
				// To add new format of invoice
			$message .="<p>Hi,</p><br/><p>This is an email from GreenBasket.</p><p>Thank you for using our app to place an order with your local vendor.</p><br/><p>Here are the details of your new order:</p><p><table cellpadding='5'><tr>							<th>Item</th><th>Rate</th><th>Qty</th><th>Price</th></tr>";							
				for ($i = 0; $i < count($customer_details['product_details']); $i++) {
					if($customer_details["product_details"][$i]["product_price"] ==0){
					$product_sql = "select product_name, product_quantity_type from product where product_id ='" . $customer_details['product_details'][$i]['product_id'] . "'";
					$product_result = $this->query($product_sql);
					foreach ($product_result as $product_key => $product_index) {
						$product_name = $product_index->product_name;
						$product_quantity_type = $product_index->product_quantity_type;
					}
					 $array_total_shopping[]=$customer_details["product_details"][$i]["product_price"];
					$message .="<tr><td>" . $product_name . "</td><td>Rs. " . $customer_details["product_details"][$i]["product_rate"] . "/" . $product_quantity_type . "</td><td>" . $customer_details["product_details"][$i]["product_quantity"] .  " " . $product_quantity_type . "</td><td>" . $customer_details["product_details"][$i]["product_price"] . "/-" . "</td></tr>";
					 $array.=$customer_details['product_details'][$i]['product_id'].',';
					}
				}
				$sum_total_product_price = array_sum($array_total_shopping);
				  if($sum_total_product_price < 100){
					$total_price =  $sum_total_product_price + 10;
					$shpping_cost =10;
				 }
				 else{
					 $shpping_cost=0;
					 $total_price =  $sum_total_product_price;
				 }
				$message .="<tr><td>Shipping</td><td></td><td></td><td>".$shpping_cost."/-</td></tr>";
			$message .="</table>";
					$message .="</p>";
					$message .="<p>(Rs. 10/- for orders below 100)</p>";
					$message .="<p>Total    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Rs. &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ".$total_price."/- </p>";
					
					$message .="<p>This order will be shipped to:</p>";
					$message .="<p> Mr. ".$customer_details['customer_name'] ."</p>";
					$message .="<p>".$customer_details['customer_address'] ."</p>";
					$message .="<p>".$customer_details['customer_city'] ."</p>";
					$message .="<p>Mobile number: ".$customer_details['customer_mobile']."</p>";
					$message .="<br/>";
					$message .="<p>Vendor details: </p>";
					$message .="<p>".$vendor_shop_name."</p>";
					$message .="<p>".$vendor_shop_address."</p>";
					$message .="<p>".$vendor_city."</p>";
					$message .="<p>Mobile number: ".$vendor_mobile_number."</p>";
					$message .="<br/>";
					$message .="<p>Note: GreenBasket only facilitates ordering from vendors. We do not deal with the goods ourselves and do not handle "; $message .="any payments for the goods mentioned above.</p>";
					$message .="<p>Kindly make the payment to the vendor directly on delivery after verifying your order.</p>";
					$message .="<p>GreenBasket does not take any responsibility for the quality of delivered goods or for the price quoted by the vendor.</p>";
					$message .="<p>Your use of GreenBasket is based on your acceptance of the terms and conditions at: <a href='#'>GreenBasket Terms of Use </a></p>";
					$message .="<br>";
					$message .="<p>If you did not place this order, kindly forward this email to us at support@greenbasket.com by changing the subject line to <b>De-register.</b> We shall promptly delete your email id from our database.</p>" .
					__REGARDS_FROM;
							$mail_data = array(
								"to" => $customer_details['customer_email'] . ',' . $vendor_email,
								"from" => __SUPPORT_EMAIL,
								"subject" => "Green Basket shopping details",
								"message" => $message
							);
							if ($this->sendMail($mail_data) == "success") {
								$res["success"] = "true";
								$res["customer_information"] = "Your shopping details has been send your email address, Please check";
									//Save data in payment details save table
							$data = array('customer_id' => $customer_details['customer_id'],
							'vendor_id' => $customer_details['vendor_id'],
							'product_id' => $product_id_array,
							'total_payments' => $total_price,
							'payment_date_time' => date("Y-m-d H:i:s"));
							$this->insert(payment_details, $data);
							} else {
								$res['error'] = "Sorry!Your details do not send your email address. try again";
							}
						//	echo $message;
						} else {
							$res['error'] = "Customer details do not update.Please try again!";
						}
					
				//}
			}
		//}
		return $res;
	}

	// Insert items list of vendor
	function insert_items_list($insert_items) {
		$res["error"] = "";
		$res["success"] = "false";
		if ($insert_items['vendor_id'] == "") {
			$res["error"] = "Please enter the vendor id";
		} else {
			$vendor_id_sql = "SELECT COUNT(*) AS `isexits`, `vendor_id` FROM `vendor_product_list` WHERE `vendor_id` = '" . $insert_items['vendor_id'] . "'";
			$execute_query = $this->query($vendor_id_sql);
			if ($execute_query[0]->isexits == 1) {
				$data = array('items' => $insert_items['items'],
					'items_rate' => $insert_items['items_rate']
				);
				if ($this->update("vendor_product_list", $data, "vendor_id = '" . $insert_items['vendor_id'] . "'")) {
					$sql_vendor_items = "select vendor_id, items, items_rate from vendor_product_list where vendor_id ='" . $insert_items["vendor_id"] . "'";
					$result = $this->query($sql_vendor_items);
					$res['vendor_items_list'] = $result;
					$res['success'] = "true";
				} else {
					$res["error"] = "";
				}
			} else {
				$data = array('vendor_id' => $insert_items['vendor_id'],
					'items' => $insert_items['items'],
					'items_rate' => $insert_items['items_rate']
				);
				if ($this->insert("vendor_product_list", $data)) {
					$sql_vendor_items = "select vendor_id, items, items_rate from vendor_product_list where vendor_id ='" . $insert_items["vendor_id"] . "'";
					$result = $this->query($sql_vendor_items);
					$res['vendor_items_list'] = $result;
					$res['success'] = "true";
				} else {
					$res['error'] = "Data not store in table.Please try again!";
				}
			}
		}
		return $res;
	}

	// Show item list and rates of vendor
	/* 	function show_items_list($show_items){
	  $res["error"] = "";
	  $res["success"] = "false";
	  if ($show_items['vendor_id'] == "") {
	  $res["error"] = "Please enter the vendor id";
	  }else{
	  $sql_vendor_items = "select vendor_id, items, items_rate from vendor_product_list where vendor_id ='" . $show_items["vendor_id"] . "'";
	  $result = $this->query($sql_vendor_items);
	  $res['vendor_items _list'] = $result;
	  $res['success'] = "true";
	  }
	  return $res;
	  } */

	// Show item list and rates of vendor
	function vendor_items_list($items_rates) {
		$res["error"] = "";
		$res["success"] = "false";
		$customer_rating_value=0;
		if ($items_rates['vendor_id'] == "") {
			$res["error"] = "Please enter the vendor id";
		} else {
			

			$sql_vendor_items.= "select vpl.item_name,vpl.item_id,vpl.vendor_id,vpl.item_rate,p.product_id,p.product_type_filter,p.product_quantity_type,p.product_type_id,p.product_image,v.vendor_shop_name from vendor_product_list vpl "
					. "inner join product p on p.product_id=vpl.product_id inner join vendor_signup v "
					. "on v.vendor_id=vpl.vendor_id where vpl.vendor_id ='" . $items_rates["vendor_id"] . "' "
					. "AND vpl.product_active_status='1' AND vpl.item_rate!='' AND vpl.item_rate!='0'";
			if ($items_rates['product_type'] != "") {
				$sql_vendor_items.="AND p.product_type_id='" . $items_rates['product_type'] . "'";
			}
			if ($items_rates['product_type_filter'] != "") {
				$sql_vendor_items.="AND p.product_type_filter='" . $items_rates['product_type_filter'] . "'";
			}
			$sql_vendor_items;
			$result = $this->query($sql_vendor_items);
			//print_r($result);
			// Check rating customer rate or not for vender
			if($items_rates['customer_id'] !=""){
			$check_rating = $this->query("select count(*) as israte,rating from vendor_rating where vendor_id='" . $items_rates['vendor_id'] . "' and customer_id='" . $items_rates['customer_id'] . "'");
				
			$res['your_rate']=$check_rating[0]->rating;
			$res['is_rate'] = $check_rating[0]->israte;
			}
			$res['success'] = "true";
			$res['vendor_rating_value'] = $customer_rating_value;
			$res['vendor_items_list'] = $result;
			
		}

		return $res;
	}

	// Delete vendor information form table 
	function delete_vendor_information($vendor_information) {
		$res["error"] = "";
		$res["success"] = "false";
		if ($vendor_information['vendor_id'] == "") {
			$res["error"] = "Please enter the vendor id";
		} else {
			$data = array('vendor_approve_status' => 0);
			$this->update("vendor_signup", $data, "vendor_id = '" . $vendor_information['vendor_id'] . "'");
			$vendor_item_data = array('product_active_status' => 0);
			$this->update("vendor_product_list", $vendor_item_data, "vendor_id = '" . $vendor_information['vendor_id'] . "'");
			$res["success"] = "true";
		}
		return $res;
	}

	// Vendor forgot password function
	function vendor_forgot_password($forgot_password) {
		$res['error'] = "";
		$res['success'] = "false";
		if ($forgot_password['vendor_email'] == "") {
			$res['error'] = "Email address can't be blank";
		} else {
			$email_check_sql = "SELECT COUNT(*) AS `isexits`, `vendor_email` FROM `vendor_signup` WHERE `vendor_email` = '" . $forgot_password['vendor_email'] . "'";
			$execute_query = $this->query($email_check_sql);
			if ($execute_query[0]->isexits == 1) {
				$random_pass = $this->createRandomPass();
				if ($this->update('vendor_signup', array('vendor_password' => md5($random_pass)), 'vendor_email="' . $forgot_password['vendor_email'] . '"')) {
					$message = 'Hello ,
                                <br /><br /> 
                                As per your request, password has been changed for your green basket Account. Please use the new password
                                as given below to login to your account.
                                <br /><br />  
                                Password: <strong>' . $random_pass . '</strong><br />
                                <br />
                                Please keep these password safe.<br /> 
                                You will need your password to re-login to your green basket account. 
                                <br /><br />  
                                Thank you,<br />' .
							__REGARDS_FROM;
					$mail_data = array(
						"to" => $forgot_password["vendor_email"],
						"from" => __SUPPORT_EMAIL,
						"subject" => "New Password for Green Basket",
						"message" => $message
					);
					if ($this->sendMail($mail_data) == "success") {
						$res["success"] = "true";
						$res["Vendor_information"] = "Your new password has been sent to your email address, Please check";
					} else {
						$res['error'] = "Sorry!Password does not send to your email address. try again";
					}
				}
			} else {
				$res['error'] = "Email address does not exist";
			}
		}
		return $res;
	}

	// sending mail
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

	function createRandomPass() {
		$str = "QWERTYUIPKJHGFDSAZXCVBNM9827364501mnbvcxzasdfghjkpiuytrewq";
		return substr(str_shuffle($str), 4, 6);
	}

	// Admin product details insert
	function admin_product_insert($product_insert) {
		$res['error'] = "";
		$res['success'] = "false";

		$temp = explode('.', $_FILES['product_pic']['name']); /* breaks a string into an array */
		$extension = end($temp);
		$uploaddir = 'product_image';
		if (!is_dir($uploaddir)) {
			mkdir($uploaddir, 0777);
		}
		$datevideo = date('Y-m-d H:i:s');
		$date = date_create();
		$increment = date_timestamp_get($date);
		$uploadFileName = pathinfo($_FILES['product_pic']['name'], PATHINFO_FILENAME);
		$uploadFileExtn = pathinfo($_FILES['product_pic']['name'], PATHINFO_EXTENSION);
		while (file_exists($uploaddir . '/' . $uploadFileName . '_' . $increment . '.' . $uploadFileExtn)) {
			$date = date_create();
			$increment = date_timestamp_get($date);
		}

		$product_image_path = $uploaddir . '/' . $uploadFileName . '_' . $increment . '.' . $uploadFileExtn;
		$datetime = date("Y-m-d H:i:s");
		if (move_uploaded_file($_FILES['profile_pic']['tmp_name'], $uploaddir . '/' . $uploadFileName . '_' . $increment . '.' . $uploadFileExtn)) {
			$this->insert("product_type", array('product_type_name' => $product_insert['product_type_name']));
			$product_type_id = $this->last_insert_id();
			$data = array(
				'product_name' => $product_insert['product_name'],
				'product_type_id' => $product_type_id,
				'product_image' => $videopath,
				'product_quantity_type' => $product_insert['product_quantity_type'],
				'product_insert_date_time' => date("Y-m-d H:i:s"),
				'product_delete_status' => '0');
			if ($this->insert("product", $data)) {
				$res['success'] = "true";
			} else {
				$res['error'] = "Data not store in table.Please try again!";
			}
		} else {
			$res['error'] = "Product image is not uploaded";
		}

		return $res;
	}

	// Show product list of admin for vendor 
	function product_list_show($product_list) {
		$res['error'] = "";
		$res['success'] = "false";
		$array = array();
		if ($product_list['vendor_id'] == "") {
			$res["error"] = "Please provide me vendor id";
		} else {
			$sql = "select vendor_id, vendor_sell_vegetables, vendor_sell_fruits, vendor_active_status from vendor_signup where vendor_id='" . $product_list['vendor_id'] . "'";
			$result = $this->query($sql);
			foreach ($result as $key => $item_type_index) {
				$vendor_sell_vegetables = $item_type_index->vendor_sell_vegetables;
				$vendor_sell_fruits = $item_type_index->vendor_sell_fruits;
				$vendor_active_status = $item_type_index->vendor_active_status;
			}
			if ($vendor_sell_vegetables == '1' AND $vendor_sell_fruits == '0') {
				$vegetables_sql = "select p.product_id,p.product_type_id,p.product_name,p.product_image,p.product_quantity_type,p.product_delete_status from product p "
						. "inner join product_type pt on pt.product_type_id=p.product_type_id where pt.product_type_name='veggies' AND p.product_delete_status='0'";
				$vegetables_result = $this->query($vegetables_sql);

				foreach ($vegetables_result as $vegetables_key => $vegetables_index) {
					$product_id = $vegetables_index->product_id;
					$sql_vendor_product = "select product_id, item_rate, product_active_status from vendor_product_list where vendor_id='" . $product_list['vendor_id'] . "' AND product_id='" . $vegetables_index->product_id . "'";
					$result_vendor_product = $this->query($sql_vendor_product);
					foreach ($result_vendor_product as $result_vendor_key => $result_vendor_index) {
						$ven_product_id = $result_vendor_index->product_id;
					}
					if ($ven_product_id == $product_id) {
						array_push($array, array(
							"product_id" => $vegetables_index->product_id,
							"product_name" => $vegetables_index->product_name,
							"item_rate" => $result_vendor_index->item_rate,
							"product_image" => FOLDER_URL . $vegetables_index->product_image,
							"product_quantity_type" => $vegetables_index->product_quantity_type,
							"product_active_status" => $result_vendor_index->product_active_status
						));
					} else {
						array_push($array, array(
							"product_id" => $vegetables_index->product_id,
							"product_name" => $vegetables_index->product_name,
							"item_rate" => '',
							"product_image" => FOLDER_URL . $vegetables_index->product_image,
							"product_quantity_type" => $vegetables_index->product_quantity_type,
							"product_active_status" => '0'
						));
					}
				}
			} elseif ($vendor_sell_fruits = '1' AND $vendor_sell_vegetables == '0') {
				$fruits_sql = "select p.product_id,p.product_type_id,p.product_name,p.product_image,p.product_quantity_type,p.product_delete_status from product p "
						. "inner join product_type pt on pt.product_type_id=p.product_type_id where pt.product_type_name='fruits' AND p.product_delete_status='0'";
				$fruits_result = $this->query($fruits_sql);
				foreach ($fruits_result as $fruits_key => $fruits_index) {
					$product_id = $fruits_index->product_id;

					$sql_vendor_product = "select product_id, item_rate, product_active_status from vendor_product_list where vendor_id='" . $product_list['vendor_id'] . "' AND product_id='" . $fruits_index->product_id . "'";
					$result_vendor_product = $this->query($sql_vendor_product);
					foreach ($result_vendor_product as $result_vendor_key => $result_vendor_index) {
						$ven_product_id = $result_vendor_index->product_id;
					}
					if ($ven_product_id == $product_id) {
						array_push($array, array(
							"product_id" => $fruits_index->product_id,
							"product_name" => $fruits_index->product_name,
							"item_rate" => $result_vendor_index->item_rate,
							"product_image" => FOLDER_URL . $fruits_index->product_image,
							"product_quantity_type" => $fruits_index->product_quantity_type,
							"product_active_status" => $result_vendor_index->product_active_status
						));
					} else {
						array_push($array, array(
							"product_id" => $fruits_index->product_id,
							"product_name" => $fruits_index->product_name,
							"item_rate" => '',
							"product_image" => FOLDER_URL . $fruits_index->product_image,
							"product_quantity_type" => $fruits_index->product_quantity_type,
							"product_active_status" => '0'
						));
					}
				}
			} else {
				$all_items_sql = "select product_id,product_type_id,product_name,product_image,product_quantity_type,product_delete_status from product where product_delete_status='0'";
				$all_items_result = $this->query($all_items_sql);
				foreach ($all_items_result as $all_items_key => $all_items_index) {
					$product_id = $all_items_index->product_id;

					$sql_vendor_product = "select product_id, item_rate, product_active_status from vendor_product_list where vendor_id='" . $product_list['vendor_id'] . "' AND product_id='" . $all_items_index->product_id . "'";
					$result_vendor_product = $this->query($sql_vendor_product);
					foreach ($result_vendor_product as $result_vendor_key => $result_vendor_index) {
						$ven_product_id = $result_vendor_index->product_id;
					}
					if ($ven_product_id == $product_id) {
						//echo	$result_vendor_index->item_rate;
						array_push($array, array(
							"product_id" => $all_items_index->product_id,
							"product_name" => $all_items_index->product_name,
							"item_rate" => $result_vendor_index->item_rate,
							"product_image" => FOLDER_URL . $all_items_index->product_image,
							"product_quantity_type" => $all_items_index->product_quantity_type,
							"product_active_status" => $result_vendor_index->product_active_status
						));
					} else {
						array_push($array, array(
							"product_id" => $all_items_index->product_id,
							"product_name" => $all_items_index->product_name,
							"item_rate" => '',
							"product_image" => FOLDER_URL . $all_items_index->product_image,
							"product_quantity_type" => $all_items_index->product_quantity_type,
							"product_active_status" => '0'
						));
					}
				}
			}
		}
		$res['success'] = "true";
		$res['vendor_active_status'] = $vendor_active_status;
		$res['product_list'] = $array;
		return $res;
	}

	//Vendor item insert if vendor item name already inserted then onyl updated.
	function vendor_item_update($vendor_item) {
		$res['error'] = "";
		$res['success'] = "false";
		if ($vendor_item['vendor_id'] == "") {
			$res["error"] = "Please provide me vendor id";
		} else {
			if ($vendor_item['vendor_active_status'] != "") {
				$status_data = array('vendor_active_status' => $vendor_item['vendor_active_status']);
				$this->update("vendor_signup", $status_data, "vendor_id = '" . $vendor_item['vendor_id'] . "'");
				for ($i = 0; $i < count($vendor_item['product_details']); $i++) {
					$product_id = $vendor_item['product_details'][$i]['product_id'];
					$vendor_product_sql = "select COUNT(*) AS `isexits` from vendor_product_list where product_id='" . $product_id . "' AND vendor_id ='" . $vendor_item['vendor_id'] . "'";
					$execute_query = $this->query($vendor_product_sql);
					if ($execute_query[0]->isexits == 1) {
						$data = array(
							'item_rate' => $vendor_item['product_details'][$i]['item_rate'],
							'product_active_status' => $vendor_item['product_details'][$i]['product_active_status']);
						//print_r($data);
						if ($this->update("vendor_product_list", $data, "vendor_id = '" . $vendor_item['vendor_id'] . "' AND product_id = '" . $product_id . "'")) {
							$res['success'] = "true";
							$res['success_response'] = "Changes saves successfully";
						} else {
							$res['error'] = "";
						}
					} else {
						$product_type_sql = "select product_type_id, product_name from product where product_id='" . $vendor_item['product_details'][$i]['product_id'] . "'";
						$product_type_result = $this->query($product_type_sql);
						foreach ($product_type_result as $product_type_key => $product_type_index) {
							$product_type_id = $product_type_index->product_type_id;
							$product_name = $product_type_index->product_name;
						}
						$product_data = array('vendor_id' => $vendor_item['vendor_id'],
							'product_id' => $vendor_item['product_details'][$i]['product_id'],
							'product_type_id' => $product_type_id,
							'item_rate' => $vendor_item['product_details'][$i]['item_rate'],
							'item_name' => $product_name,
							'product_active_status' => $vendor_item['product_details'][$i]['product_active_status']);
						if ($this->insert("vendor_product_list", $product_data)) {
							$res['success'] = "true";
							$res['success_response'] = "Changes saves successfully";
						} else {
							$res['error'] = "Data not store in table.Please try again!";
						}
					}
				}
			}
		}
		return $res;
	}

	// All product list show for admin
	function admin_product_list() {
		$array = array();
		$all_items_sql = "select product_id,product_type_id,product_name,product_image,product_quantity_type,product_delete_status from product";
		$all_items_result = $this->query($all_items_sql);
		foreach ($all_items_result as $all_items_key => $all_items_index) {
			array_push($array, array(
				"product_id" => $all_items_index->product_id,
				"product_type_id" => $all_items_index->product_type_id,
				"product_name" => $all_items_index->product_name,
				"product_image" => FOLDER_URL . $all_items_index->product_image,
				"product_quantity_type" => $all_items_index->product_quantity_type,
				"product_delete_status" => $all_items_index->product_delete_status
			));
		}
		$res['success'] = "true";
		$res['product_list'] = $array;
		return $res;
	}

// Admin product list update or deleted
	function admin_product_update($product_delete) {
		$res['error'] = "";
		$res['success'] = "false";
		for ($i = 0; $i < count($product_delete['product_details']); $i++) {
			$data = array('product_delete_status' => $product_delete['product_details'][$i]['product_delete_status']);
			if ($this->update("product", $data, "product_id='" . $product_delete['product_details'][$i]['product_id'] . "'")) {
				$product_delete_status = $product_delete['product_details'][$i]['product_delete_status'];
				if ($product_delete_status == '1') {
					$data = array('product_active_status' => '2');
					$this->update("vendor_product_list", $data, "product_id='" . $product_delete['product_details'][$i]['product_id'] . "'");
					$res['success'] = "true";
				} else {
					$data = array('product_active_status' => '0');
					$this->update("vendor_product_list", $data, "product_id='" . $product_delete['product_details'][$i]['product_id'] . "'");
					$res['success'] = "true";
				}
			} else {
				$res["error"] = "";
			}
		}
		return $res;
	}

	// Vendor item deleted
	function vendor_item_delete($item_delete) {
		$res['error'] = "";
		$res['success'] = "false";
		$product_check_sql = "SELECT COUNT(*) AS `isexits`, `vendor_id`, `item_name` FROM `vendor_product_list` WHERE `vendor_id` = '" . $item_delete["vendor_id"] . "' AND `item_name` = '" . $item_delete["item_name"] . "'";
		$execute_query = $this->query($product_check_sql);
		if ($execute_query[0]->isexits == 1) {
			$data = array('product_delete_status' => 1);
			if ($this->update("vendor_product_list", $data, "vendor_id = '" . $item_delete['vendor_id'] . "' AND item_name = '" . $item_delete['item_name'] . "'")) {
				$res['success'] = "true";
			} else {
				$res["error"] = "Deletion error";
			}
		}
		return $res;
	}

	//suggest a new vendor
	function seggested_new_vendor($suggested_vendor) {
		$res["error"] = "";
		$res["success"] = "false";
		$data = array('customer_name' => $suggested_vendor['customer_name'],
			'customer_mobile_number' => $suggested_vendor['customer_mobile_number'],
			'vendor_name' => $suggested_vendor['vendor_name'],
			'vendor_mobile_number' => $suggested_vendor['vendor_mobile_number'],
			'suggested_date_time' => date("Y-m-d H:i:s"));
		if ($this->insert("suggested_vendor", $data)) {
			//$res['success'] = "true";
			//$res['success_msg'] = "Thank you for suggesting me";
			// Send mail
			$suggest_message.='<p><b>Customer Name:</b> ' . $suggested_vendor['customer_name'] . '</p>';
			$suggest_message.='<p><b>Customer Mobile Number:</b> ' . $suggested_vendor['customer_mobile_number'] . '</p>';
			$suggest_message.='<p><b>Vendor Name:</b> ' . $suggested_vendor['vendor_name'] . '</p>';
			$suggest_message.='<p><b>Vendor Mobile Number:</b> ' . $suggested_vendor['vendor_mobile_number'] . '</p>';
			$suggest_message.='Thank you,<br />' .$suggested_vendor['customer_name'];
			$suggest_message  .='<br />' . date("Y-m-d H:i:s");
			$mail_data = array(
				"to" => __SUPPORT_EMAIL,
				"from" => __CONTACTUS_EMAIL,
				"subject" => "Form submission from : Green Basket Suggest Vendor",
				"message" => $suggest_message
			);
			if ($this->sendMail($mail_data) == "success") {
				$res["success"] = "true";
				$res['success_msg'] = "Thank you for suggesting me";
				//$sucess_msg.= '<h1 style="<h1 style="center">Thanks! </h1>';
				//$sucess_msg.='<p>We appreciate that you’ve taken the time to write us. We’ll get back to you very soon. Please come back and see us often.</p>';
				//$res["sucess_msg"] = $sucess_msg;
			} else {
				$res['error'] = "You suggestion does not sent to vendor.Please try again!";
			}		
		} else {
			$res['error'] = "You suggestion does not sent to vendor.Please try again!";
		}
		//echo $suggest_message;
		return $res;
	}

	//Vendor change password
	function vendor_change_password($change_password) {
		$res['error'] = "";
		$res['success'] = "false";
		$old_password = md5($change_password['old_password']);
		//echo '<br>';
		$new_password = md5($change_password['new_password']);
		if ($change_password['vendor_email'] == "") {
			$res['error'] = "Please provide me email address";
		} else {
			$sql = "select vendor_email,vendor_password from vendor_signup where vendor_email='" . $change_password['vendor_email'] . "'";
			$result = $this->query($sql);
			foreach ($result as $key => $password_index) {
				$password = $password_index->vendor_password;
			}
			if ($old_password == $password) {
				if ($new_password == $password) {
					$res['error'] = "Please enter different password in new password";
				} else {
					$data = array('vendor_password' => md5($change_password['new_password']));
					$this->update("vendor_signup", $data, "vendor_email = '" . $change_password['vendor_email'] . "'");
					$res['success'] = "true";
					$res['changed_password'] = "Your password has been changed";
				}
			} else {
				$res['error'] = "Invalid current password";
			}
		}

		return $res;
	}

	// function for contact_us
	function contact_us($contact) {
		$res['error'] = "";
		$res['success'] = "false";
		if ($contact["mobile_number"] == "") {
			$res["error"] = "Please provide mobile number";
		} else {
			$contact_message.='<p>Name: ' . $contact["name"] . '</p>';
			$contact_message.='<p>Mobile Number: ' . $contact["mobile_number"] . '</p>';
			$contact_message.='<p>Message: ' . $contact["message"] . '</p>';
			$contact_message.='Thank you,<br />'.$contact["name"];
			$contact_message.='<br />' . date("Y-m-d H:i:s");
			$mail_data = array(
				"to" => __SUPPORT_EMAIL,
				"from" => __CONTACTUS_EMAIL,
				"subject" => "Form submission from : Green Basket Contact us",
				"message" => $contact_message
			);
			if ($this->sendMail($mail_data) == "success") {
				$res["success"] = "true";
				$sucess_msg.= '<h1 style="<h1 style="center">Thanks! </h1>';
				$sucess_msg.='<p>We appreciate that you’ve taken the time to write us. We’ll get back to you very soon. Please come back and see us often.</p>';
				$res["sucess_msg"] = $sucess_msg;
			} else {
				$res['error'] = "Sorry!Your query not send to Green Basket. try again";
			}
		}
		return $res;
	}

	// function save for vendor rating
	function vendor_rating_save($rating) {
		$res['error'] = "";
		$res['success'] = "false";
		//echo $rating['rating'];		
		if ($rating["vendor_id"] == "") {
			$res["error"] = "Please provide me vendor id";
		} else {
			$sql = "SELECT COUNT(*) AS `isexits`, `rating` FROM `vendor_rating` WHERE `vendor_id` = '" . $rating["vendor_id"] . "' AND `customer_id` = '" . $rating["customer_id"] . "'";
			$execute_query = $this->query($sql);
			foreach ($execute_query as $key => $rating_index) {
				$rating_value = $rating_index->rating;
			}
			if ($execute_query[0]->isexits == 1) {
				if ($rating_value == $rating['rating']) {
					$res['success'] = "true";
				} else {
					$data = array('rating' => $rating['rating']);
					if ($this->update("vendor_rating", $data, "vendor_id = '" . $rating['vendor_id'] . "' AND customer_id = '" . $rating['customer_id'] . "'")) {
						$res['success'] = "true";
					} else {
						$res['error'] = "";
					}
				}
			} else {
				$data = array('vendor_id' => $rating['vendor_id'],
					'customer_id' => $rating['customer_id'],
					'rating' => $rating['rating'],
					'vendor_rating_date_time' => date("Y-m-d H:i:s"));
				if ($this->insert("vendor_rating", $data)) {
					$res['success'] = "true";
				} else {
					$res['error'] = "Data not store in table.Please try again!";
				}
			}
		}
		return $res;
	}

	// Function show average rating value of vendor
	function vendor_average_rating($vendor_id) {		
		$sql = "select avg(rating) as rating from vendor_rating where vendor_id='" . $vendor_id . "'";
		return $this->query($sql);
		
	}

	//function customer rating show for vendor
	function customer_rating_show($items_rates) {
		$rating_sql = "select vr.rating from vendor_rating vr "
				. " where vr.vendor_id='" . $items_rates['vendor_id'] . "' AND vr.customer_id='" . $items_rates['customer_id'] . "'";
		return $this->query($rating_sql);
	}

	// Fetch green basket aboutus text
	function about_gb() {
		$res['error'] = "";
		$res['success'] = "false";
		$aboutus = $this->query("select about_text from gb_aboutus");
		if (!empty($aboutus[0])) {
			$res['about_us'] = $aboutus[0];
			$res['success'] = "true";
		}

		return $res;
	}
// Fetch green basket term conditions
	function term_conditions() {
		$res['error'] = "";
		$res['success'] = "false";
		$terms_conditions = $this->query("select terms_conditions from terms_conditions");
		if (!empty($terms_conditions[0])) {
			$res['term_conditions'] = $terms_conditions[0];
			$res['success'] = "true";
		}

		return $res;
	}

	// Area name according to city

	function area_name($city_details) {
		$res['error'] = "";
		$res['success'] = "false";
		if ($city_details['city_name'] == "") {
			$res['error'] = "City name can't be blank";
		} else {
			//select distinct vendor_area from vendor_signup where vendor_city='" . $city_details['city_name'] . "' and vendor_area!='None Of These' or vendor_area !=''
			$area_sql = "select distinct area from area_details where city_name='" . $city_details['city_name']."'";
			$area = $this->query($area_sql);
			$res['area_name'] = $area;
			$res['success'] = "true";
		}
		return $res;
	}

		// Get all city name 
	function city_name() {
		$res['error'] = "";
		$res['success'] = "false";		
			$city_sql = "select distinct city_name from area_details order by city_name";
			$city = $this->query($city_sql);
			$res['city_name'] = $city;
			$res['success'] = "true";
		
		return $res;
	}

// Customer email verification

	function customer_email_verification($customer_email) {

		$res['error'] = "";
		$res['success'] = "false";
		if ($customer_email['email'] == "") {
			$res['error'] = "Email address can't be blank";
		} else {
			$check_email = $this->query("SELECT COUNT(*) AS `isexits`,customer_id, customer_name,customer_email FROM `customer_signup` WHERE `customer_email` = '" . $customer_email['email'] . "'");
			$res['customer_information'] = $check_email;
			if ($check_email[0]->isexits > 0) {
				$res['is_check'] = 1;
			} else {
				$res['is_check'] = 0;
			}
			$res['success'] = "true";
		}
		return $res;
	}

// This function returns Longitude & Latitude from zip code.
	/**
	 * 
	 * @param type $zip
	 * @return type lat,long
	 * 
	 * $lat1 = $first_lat['lat'];
	  $lon1 = $first_lat['lng'];B-42,sec-59,Noida,Up
	 */
	function lookup($string) {

		$string = str_replace(" ", "+", urlencode($string));
		$details_url = "http://maps.googleapis.com/maps/api/geocode/json?address=" . $string . "&sensor=false";

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $details_url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$response = json_decode(curl_exec($ch), true);

		// If Status Code is ZERO_RESULTS, OVER_QUERY_LIMIT, REQUEST_DENIED or INVALID_REQUEST
		if ($response['status'] != 'OK') {
			return null;
		}

		//print_r($response);
		$geometry = $response['results'][0]['geometry'];

		$longitude = $geometry['location']['lat'];
		$latitude = $geometry['location']['lng'];

		$array = array(
			'latitude' => $geometry['location']['lng'],
			'longitude' => $geometry['location']['lat'],
			'location_type' => $geometry['location_type'],
		);

		return $array;
	}

//$city = 'San Francisco, USA';


	function getPlaceName($location_latlong) {
		$latitude=$location_latlong['current_lat'];
		$longitude=$location_latlong['current_long'];
		//echo 'http://maps.googleapis.com/maps/api/geocode/json?latlng='
			//	. $latitude . ',' . $longitude . '&sensor=false';
		//This below statement is used to send the data to google maps api and get the place
		//name in different formats. we need to convert it as required .
				 $geocode = 'http://maps.googleapis.com/maps/api/geocode/json?latlng='
				. $latitude . ',' . $longitude . '&sensor=false';


		

		//Here "formatted_address" is used to display the address in a user friendly format.
		//echo $output->results[0]->formatted_address;
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $geocode);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$response = json_decode(curl_exec($ch), true);
	//	print_r($response);
		print_r($response->results[0]['address_components'][3]);
		return $res['location']=$response;
	}

	// Customer signup 

	function customer_registration($customer_details) {

		$res['error'] = "";
		$res['success'] = "false";
		if ($customer_details['customer_email'] == "") {

			$error = "Email address can't be blank";
		} else {
			$find_latlong = $this->getLnt($customer_details['customer_city'].','.$customer_details['customer_area']);
			$check_email = $this->query("SELECT COUNT(*) AS `isexits`,customer_id FROM `customer_signup` WHERE `customer_email` = '" . $customer_details['customer_email'] . "'");
			$res['customer_information'] = $check_email;
			if ($check_email[0]->isexits > 0) {
				$data = array('customer_name' => $customer_details['customer_name'],
					'customer_mobile' => $customer_details['customer_mobile'],
					'customer_address' => $customer_details['customer_address'],
					'customer_area' => $customer_details['customer_area'],
					'customer_city' => $customer_details['customer_city'],
					'customer_email' => $customer_details['customer_email'],
					'customer_latitude' => $find_latlong['lat'],
					'customer_longitude' =>  $find_latlong['lng'],
					'customer_approve_status' => 1,
					'customer_signup_date_time' => date("Y-m-d H:i:s"));
					if($this->update('customer_signup',$data,"customer_id='".$check_email[0]->customer_id."'")){
						$customer_details = $this->query("SELECT customer_id, customer_name, customer_mobile, customer_address, customer_area, customer_city, customer_email, customer_latitude, customer_longitude FROM `customer_signup` WHERE `customer_id` = '" . $check_email[0]->customer_id . "'");
					if (!empty($customer_details)) {
						$res['customer_details'] = $customer_details;
						$res['success'] = "true";
						$res['success_msg'] = "Thank you";
					} else {
						$res['error'] = "Please try again";
					}
								
					}
					else {
						$res['error'] = "Please try again";
					}
			} else {
				$latlong = $this->lookup($customer_details['customer_address']);
				//print_r($latlong);
				$data = array('customer_name' => $customer_details['customer_name'],
					'customer_mobile' => $customer_details['customer_mobile'],
					'customer_address' => $customer_details['customer_address'],
					'customer_area' => $customer_details['customer_area'],
					'customer_city' => $customer_details['customer_city'],
					'customer_email' => $customer_details['customer_email'],
					'customer_latitude' => $find_latlong['lat'],
					'customer_longitude' =>  $find_latlong['lng'],
					'customer_approve_status' => 1,
					'customer_signup_date_time' => date("Y-m-d H:i:s"));
				if ($this->insert('customer_signup', $data)) {
					$customer_details = $this->query("SELECT customer_id, customer_name, customer_mobile, customer_address, customer_area, customer_city, customer_email, customer_latitude, customer_longitude FROM `customer_signup` WHERE `customer_id` = '" . $this->last_insert_id() . "'");
					if (!empty($customer_details)) {
						$res['customer_details'] = $customer_details;
						$res['success'] = "true";
						$res['success_msg'] = "Thank you for shipping";
					} else {
						$res['error'] = "Please try again";
					}
				}
			}
		}
		return $res;
	}

	// Get latlong using address
	
		// This function returns Longitude & Latitude from zip code.
	function getLnt($zip) {
		$url = "http://maps.googleapis.com/maps/api/geocode/json?address=" . urlencode($zip) . "&sensor=false";
		$result_string = file_get_contents($url);
		$result = json_decode($result_string, true);
		$result1[] = $result['results'][0];
		$result2[] = $result1[0]['geometry'];
		$result3[] = $result2[0]['location'];
		return $result3[0];
	}
	
	
	
}
?>

