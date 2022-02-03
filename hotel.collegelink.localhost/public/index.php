<?php

require __DIR__.'/../boot/boot.php';

use Hotel\User;

// Check for logged in user
$userId = User::getCurrentUserId();
if(!empty($userId)){
	header('Location: home.php');
	
	return;
}

?>

<!DOCTYPE>
<html>
	<head>
		<meta name="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title> Welcome to Collegelink Hotel </title>
	</head>
	<body>
		<main>
			<img src="/public/assets/fonts/Cllogo.png" class="image">
			<div class="description">
				<p> Thank you for visiting Collegelink Hotel ! </p>
				<p> Please LOGIN or REGISTER to continue. </p>
			</div>
			<div class="buttons">
				<div class="LoginButton">
					<a href="http://hotel.collegelink.localhost/public/login.php"> LOGIN </a>
				</div>
				<div class="RegisterButton">
					<a href="http://hotel.collegelink.localhost/public/register.php"> REGISTER </a>
				</div>
			</div>
			<div class="VisitorButton">
				<a href="http://hotel.collegelink.localhost/public/home.php"> Or continue as a visitor. </a>
			</div>
		</main>
		<footer>
			<div>
				<p><i class="far fa-copyright"></i> collegelink 2022 </p>
			</div>
			<script src="https://kit.fontawesome.com/cd63bb6cf3.js" crossorigin="anonymous"></script>
			<link rel="preconnect" href="https://fonts.googleapis.com">
			<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
			<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500&display=swap" rel="stylesheet">
			<link href="http://hotel.collegelink.localhost/public/assets/css/index.css" type="text/css" rel="stylesheet">
		</footer>
	</body>