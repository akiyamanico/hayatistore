<?php
session_start();
if((empty($_SESSION['ECI_User'])) or $_SESSION['ECI_Level'] != "admin") {
	echo "<meta http-equiv='refresh' content='0; url=../login.php'>";
	exit;
}
ini_set("session.cookie_domain", '.dev.local');
session_set_cookie_params(3600, '/', '.dev.local');
if(!isset($_SESSION)) {
   session_start();
}
// csrf code add here (see below...)
$http_origin = $_SERVER['HTTP_ORIGIN'];
if ($http_origin == "http://dev.local:3000" || $http_origin == "http://localhost:3300"){
    header("Access-Control-Allow-Origin: $http_origin");
}
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Headers: X-Requested-With, Origin, Content-Type, X-CSRF-Token, Accept');
// code starts here
$_SESSION['test'] = 'whatever';
session_write_close();
?>