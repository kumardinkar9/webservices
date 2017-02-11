<?php
error_reporting(1);
/* Project Name: Health Advice 
 * @Author: Bibhuti Ranjan 
 * Company : Funki Orange software solution PVT. LTD
 * Email:bibhuti.ranjan@funkitechnologies.com
 */
//header('Content-Type: application/json; Charset=UTF-8');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
include "services.php";
$services_object = new Services(DB_HOST, DB_USER, DB_PASS, DB_NAME);

/*
 * {"action":"search vendors","category":"LogIn"}
 */

//error_reporting("E_ALL & ~E_NOTICE | ~E_DEPRECATED");

switch ($_REQUESTSTR["task"]) {
	case "vendor_signup":
		$vendor_details = $_REQUESTSTR;
		$response_arr["response"] = $services_object->vendor_signup($vendor_details);
		break;
	case "vendor_signin":
		$vendor_details = $_REQUESTSTR;
		$response_arr["response"] = $services_object->vendor_signin($vendor_details);
		break;
	case "send_invoice":
		$customer_details = $_REQUESTSTR;
		$response_arr["response"] = $services_object->send_invoice($customer_details);
		break;	
	case "payment_details_save":
		$payment_details = $_REQUESTSTR;
		$response_arr["response"] = $services_object->payment_details_save($payment_details);
		break;	
	case "feedback_message_save":
		$feedback_message = $_REQUESTSTR;
		$response_arr["response"] = $services_object->feedback_message_save($feedback_message);
		break;
	case "vendors_list":
		$vegetables_vendor = $_REQUESTSTR;
		$response_arr["response"] = $services_object->vendors_list($vegetables_vendor);
		break;
	case "customer_information_check":
		$information_check = $_REQUESTSTR;
		$response_arr["response"] = $services_object->customer_information_check($information_check);
		break;
	case "insert_items_list":
		$insert_items = $_REQUESTSTR;
		$response_arr["response"] = $services_object->insert_items_list($insert_items);
		break;
	case "vendor_items_list":
		$items_rates = $_REQUESTSTR;
		$response_arr["response"] = $services_object->vendor_items_list($items_rates);
		break;
	case "delete_vendor_information":
		$vendor_information = $_REQUESTSTR;
		$response_arr["response"] = $services_object->delete_vendor_information($vendor_information);
		break;
	case "vendor_forgot_password":
		$forgot_password = $_REQUESTSTR;
		$response_arr["response"] = $services_object->vendor_forgot_password($forgot_password);
		break;
	case "admin_product_insert":
		$product_insert = $_REQUESTSTR;
		$response_arr["response"] = $services_object->admin_product_insert($product_insert);
		break;
	case "admin_product_delete":
		$product_delete = $_REQUESTSTR;
		$response_arr["response"] = $services_object->admin_product_delete($product_delete);
		break;
	case "vendor_item_update":
		$vendor_item = $_REQUESTSTR;
		$response_arr["response"] = $services_object->vendor_item_update($vendor_item);
		break;	
	case "vendor_item_delete":
		$item_delete = $_REQUESTSTR;
		$response_arr["response"] = $services_object->vendor_item_delete($item_delete);
		break;	
	case "seggested_new_vendor":
		$suggested_vendor = $_REQUESTSTR;
		$response_arr["response"] = $services_object->seggested_new_vendor($suggested_vendor);
		break;
	case "vendor_change_password":
		$change_password = $_REQUESTSTR;
		$response_arr["response"] = $services_object->vendor_change_password($change_password);
		break;		
	case "product_list_show":
		$product_list = $_REQUESTSTR;
		$response_arr["response"] = $services_object->product_list_show($product_list);
		break;
	case "vendor_update":
		$vendor_details = $_REQUESTSTR;
		$response_arr["response"] = $services_object->vendor_update($vendor_details);
		break;
	case "admin_product_list":
	//	$product_list = $_REQUESTSTR;
		$response_arr["response"] = $services_object->admin_product_list();
		break;
	case "shipping_address_save":
		$customer_details = $_REQUESTSTR;
		$response_arr["response"] = $services_object->shipping_address_save($customer_details);
		break;
	case "contact_us":
		$contact = $_REQUESTSTR;
		$response_arr["response"] = $services_object->contact_us($contact);
		break;
	case "vendor_rating_save":
		$rating = $_REQUESTSTR;
		$response_arr["response"] = $services_object->vendor_rating_save($rating);
		break;
	case "vendor_average_rating":
		$vendor_id = $_REQUESTSTR;
		$response_arr["response"] = $services_object->vendor_average_rating($vendor_id);
		break;
	case "customer_rating_show":
		$items_rates = $_REQUESTSTR;
		$response_arr["response"] = $services_object->customer_rating_show($items_rates);
		break;
	
	case "about_gb":
		$response_arr["response"] = $services_object->about_gb();
		break;
	case "term_conditions":
		$response_arr["response"] = $services_object->term_conditions();
		break;
	
	case "area_name":
		$parms = $_REQUESTSTR;
		$response_arr["response"] = $services_object->area_name($parms);
		break;
	case "city_name":
		//$parms = $_REQUESTSTR;
		$response_arr["response"] = $services_object->city_name();
		break;
	case "customer_email_verification":
		$parms = $_REQUESTSTR;
		$response_arr["response"] = $services_object->customer_email_verification($parms);
		break;
	case "customer_registration":
		$parms = $_REQUESTSTR;
		$response_arr["response"] = $services_object->customer_registration($parms);
		break;
	case "getPlaceName":
		$parms = $_REQUESTSTR;
		$response_arr["response"] = $services_object->getPlaceName($parms);
		break;
	case "vendors_list_near_my_home":
		$vegetables_vendor = $_REQUESTSTR;
		$response_arr["response"] = $services_object->vendors_list_near_my_home($vegetables_vendor);
		break;
	
	default:
		$response_arr["error"] = "No task found";
		break;
}
if ($response_arr["task"] == "") {
	unset($response_arr["task"]);
}

//print_r($response_arr);
$raw_json = json_encode($response_arr);

echo $raw_json;
