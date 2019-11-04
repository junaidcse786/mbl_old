<?php 

require_once('config/dbconnect.php');

if(!isset($_SESSION["user_panel"]) || !isset($_SESSION["front_user_id"])){

	$_SESSION["accessing_url"]=$_SERVER['REQUEST_URI'];
	
	header('Location: '.SITE_URL.'sign-in/');

}


?>