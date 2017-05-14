<?php

$stable_version = "v0";
$testing_version = "v1";
$versions = array("v0"=> "2017-05-30");

$datadir = "/var/web/imagedata/";
$db_servername = "localhost";
$db_username = "images";
$db_password = "images";
$db_name   = "images";
$json_encode_props = JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PARTIAL_OUTPUT_ON_ERROR;

function handle_version($version) {
   global $stable_version, $testing_version, $old_versions;
   if ($version == null) {
      $version = $stable_version;
   }
   header("X-Version: ".$version);
   header("X-Version-Stable: ".$stable_version);
   header("X-Version-Testing: ".$testing_version);
   $found = false;
   $expires = null;
   foreach ($versions as $ver => $expire) {
     if ($version == $ver) {
       $found = true; 
       $expires = $expire;  
       break;
     }
   }
   if ($version == $stable_version) { 
      header("X-Version-Status: You are on the most recent stable version");  
      if ($expires != null) {
         header("X-Version-Expires: ".$expires);
     } 
   } else if ($version == $testing_version) {
      header("X-Version-Status: You are on the testing (unstable) version that is still in development.");
   } else {
     if ($found) {
       header("X-Version-Expires: ".$expires);
       header("X-Version-Status: The version you are using ('".$version."') expired at '".$expires."'");
     } else {
       header("X-Version-Status: You are using an unrecognized version '".$version."'");
     }
   } 
}

function http_exit($code, $msg) {
    global $json_encode_props;
    $msg = $msg == null ? "" : $msg;
    http_response_code($code);
    header('Content-Type: application/json');
    header('X-Result-Size: 0');
    $obj = array("size"=>0, "code"=>$code, "message"=>$msg);
    echo json_encode($obj, $json_encode_props)."\n";
    exit(0);
}

function param($param) {
   $value = isset($_GET[$param]) ? $_GET[$param] : null;
   return $value;
}


function open_db_connection() {
    global $db_servername, $db_username, $db_password, $db_name;
    $conn = new mysqli($db_servername, $db_username, $db_password, $db_name);
    if ($conn->connect_error) {
       http_exit(500, "Internal Server Error");
    }
    return $conn;
}

function close_db_connection($conn) {
    if ($conn != null) { 
       $conn->close();
    }
    $conn = null;
}

function applyMatchMode($where, $what, $value, $matchMode, $matchModeParam) {
   if ($what == null || $value == null) {
      return $where;
   }
   $value = $value == null ? "" : str_replace("'", "''", $value);
   $and = $where == null || $where == "" ? "" : " and ";
   $matchMode = $matchMode == null ? null : strtoupper($matchMode);
   if ($matchMode == null || $matchMode == "ANYWHERE") {
       return $where . $and . $what . " like '%" . $value . "%' ";
   } else if ($matchMode == "START") {
       return $where . $and . $what . " like '" . $value . "%' ";
   } else if ($matchMode == "END") {
       return $where . $and . $what . " like '%" . $value . "' "; 
   } else if ($matchMode == "EXACT") {
       return $where . $and . $what . " = '" . $value . "' ";
   } else {
       throw new Exception("Invalid value \'$matchMode\' for parameter \'$matchModeParam\'. Possible values are  \'ANYWHERE\', \'START\', \'END\' or \'EXACT\'.");
   } 
}





?>
