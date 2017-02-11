<?php
require 'connection.php';
$allowedExts = array('webm', 'mp4', 'ogv', 'mov', 'MOV');
$temp = explode('.', $_FILES['urlvideo']['name']); /* breaks a string into an array */
$extension = end($temp);
$user_email= $_REQUEST['user_email'];
$uploaddir = 'videos/'.$user_email;
if (!is_dir($uploaddir)) {
    mkdir($uploaddir,0777);   
	
}
if (($_FILES['urlvideo']['type'] == 'video/webm') || ($_FILES['urlvideo']['type'] == 'video/mp4') || ($_FILES['urlvideo']['type'] == 'video/ogv') || ($_FILES['urlvideo']['type'] == 'video/mov') || ($_FILES['urlvideo']['type'] == 'video/MOV') || ($_FILES['urlvideo']['type'] == 'video/quicktime') || (in_array($extension, $allowedExts))) {
	if ($_FILES['urlvideo']['size'] > 100000000000000) /* 200 MB  */ {
		die("File size exceeds 200 MB.");
	} else {
		if ($_FILES['urlvideo']['error'] > 0) /* 0 error code: no error */ {
			die("Error Code: " . $_FILES['urlvideo']['error']);
		} else {
			$datevideo = date('Y-m-d H:i:s');
			$date = date_create();
			$increment = date_timestamp_get($date);
			$uploadFileName = pathinfo($_FILES['urlvideo']['name'], PATHINFO_FILENAME);
			$uploadFileExtn = pathinfo($_FILES['urlvideo']['name'], PATHINFO_EXTENSION);
			while (file_exists($uploaddir.'/' . $uploadFileName . '_' . $increment . '.' . $uploadFileExtn)) {
				$date = date_create();
				$increment = date_timestamp_get($date);
			}
			
			$videopath = $uploaddir.'/' . $uploadFileName . '_' . $increment . '.' . $uploadFileExtn;
			$datetime = date("Y-m-d H:i:s");
			if (move_uploaded_file($_FILES['urlvideo']['tmp_name'], $uploaddir.'/' . $uploadFileName . '_' . $increment . '.' . $uploadFileExtn)) {
				$vurl = "http://funkiorange.com/health_advice/".$uploaddir."/" . $uploadFileName . '_' . $increment . '.' . $uploadFileExtn;
				$video_sql = "INSERT INTO `video_sharing` (user_email,video_url,uploading_date_time)
                     VALUES ('$user_email','$videopath','$datetime')";
				mysql_query($video_sql);                
				echo "http://funkiorange.com/health_advice/".$uploaddir."/" . $uploadFileName . '_' . $increment . '.' . $uploadFileExtn;
			} else {
				die("An error occurred. Please try again.");
			}
		}
	}
} else {
	die("Invalid file format.");
}
?>
