<?php
require_once 'include/config.php';  // require or include, config.php from include folder
$v_id_ = $_GET['vendorId'];  // get vendor id from viewvendor.php page
$v_id_array=explode("_",$v_id_);
$vendor_id=$v_id_array['0'];
// get vendor record from vendor_signup table
$result = mysql_query("SELECT vendor_shop_name, vendor_mobile_number, vendor_email, vendor_shop_address, vendor_approve_status from vendor_signup where vendor_id='" . $vendor_id . "'");
while($vendorStatus=mysql_fetch_array($result))  //carry on looping through while there are records
          {
		$vendor_shop_name=$vendorStatus['vendor_shop_name'];	
		$vendor_mobile_number=$vendorStatus['vendor_mobile_number'];	
		$vendor_email=$vendorStatus['vendor_email'];	
		$vendor_shop_address=$vendorStatus['vendor_shop_address'];	
		$vendor_approve_status=$vendorStatus['vendor_approve_status'];	
		}
			if($vendor_approve_status==0){
				$sql="UPDATE vendor_signup SET vendor_approve_status='1' WHERE vendor_id='" . $vendor_id . "'";
				if(mysql_query($sql)){					
		 $mail_format='<p>Hi,</p>
					<br/>
					<p>This is an email from GreenBasket.</p>
					<p>Thank you for signing up with us.</p>
					<br/>
					<p>Your sign up details are:</p>
					<p>Vendor name: '.$vendor_shop_name.'</p>
					<p>Address: '.$vendor_shop_address.'</p>
					<p>Mobile number: '.$vendor_mobile_number.'</p>
					<br/>
					<p>Your details will be verified by our admin and once approved, you can start receiving orders for the vegetables or fruits that you supply.</p>
					<br/>
					<p>If you need more assistance, please get in touch with us at support@greenbasket.com</p>
					<br/>
					<p>Note: GreenBasket only facilitates ordering from vendors. We do not deal with the goods ourselves and do not handle any payments for the goods mentioned above.</p>
					<p>Kindly make the payment to the vendor directly on delivery after verifying your order.</p>
					<p>GreenBasket does not take any responsibility for the quality of delivered goods or for the price quoted by the vendor.</p>
					<p>Your use of GreenBasket is based on your acceptance of the terms and conditions at: <a href="#">GreenBasket Terms of Use </a></p>
					<br/>
					<p>If you did not register with us, kindly forward this email to us at support@greenbasket.com by changing the subject line to <b>De-register.</b> We shall promptly delete your email id from our database.</p>
					<br/>
					<p>Thanks,</p>
					<p>Team GreenBasket</p>';					
					$mail_data = array(
						"to" => $vendor_email,
						"from" => "support@greenbasket.com",
						"subject" => "This is an email from GreenBasket",
						"message" => $mail_format
					);
					if (sendMail($mail_data)) {
						 $message= "True ";
					}
					}
				}else{
					$sql="UPDATE vendor_signup SET vendor_approve_status='0' WHERE vendor_id='" . $vendor_id . "'";
				if(mysql_query($sql)){
					 $massage="Approve status change";
			}											
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


?>

