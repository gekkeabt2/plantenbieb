<?php
// Include the base files and check if user is logged in //
include_once ("../template/header.php");
include_once("../includes/config.php");


// Check if the user wants to change something //
if (isset($_GET["key"])&&$_GET["key"]!="") {
	$user = $database->select("users", ['user_id'], ["user_mail" => $_GET["key"]]);
	if(count($user)!=0){
	$data = $database->update("users", [
			"user_active" => 1
		], [
			"user_mail[=]" => $_GET["key"]
		]);
	}
}
header("location: ../users/login");
?>