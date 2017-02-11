<?php

// response json
$json = array();

/**
 * Registering a user device
 * Store reg id in users table
 */
if (isset($_REQUEST["name"]) && isset($_REQUEST["email"]) && isset($_REQUEST["regId"])) {
    $name = $_REQUEST["name"];
    $email = $_REQUEST["email"];
    $gcm_regid = $_REQUEST["regId"]; // GCM Registration ID
    
    // Store user details in db
    include_once 'db_functions.php';
    include_once 'GCM.php';

    $db = new DB_Functions();
    $gcm = new GCM();

    $res = $db->storeUser($name, $email, $gcm_regid);

    $registatoin_ids = array($gcm_regid);
    $message = array("product" => "Fit + Healthy");

    $result = $gcm->send_notification($registatoin_ids, $message);

    echo $result;
} else {
    // user details missing
    echo "Sql error ";
}
?>
