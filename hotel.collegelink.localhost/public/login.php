<?php
require __DIR__.'/../boot/boot.php';

use Hotel\User;

// Check for existing logged in user
if(!empty(User::getCurrentUserId())) {
	header('Location: /public/home.php');
	return;
}

?>


<!DOCTYPE>
<html>
	<head>
		<meta name="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
		<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
		<title> Login User </title>
	</head>
	<body>
		<header>
			<div class="header-container">
				<div class="hotels-logo">
				<h4> Hotels </h4>
				</div>
				<div class="home-logo">
				<a href="http://hotel.collegelink.localhost/public/index.php"><h4><i class="fas fa-home"></i> Home </h4></a>
				</div>
			</div>
		</header>
		<main>
			<form method="POST" action="actions/login.php">
				<div class="form-field">
					<label for="email"> E-mail Address: </label>
					<input id="email" class="form-control" type="text" name="email" placeholder="Please enter your E-mail address">
					<?php
						if(isset($_REQUEST['emailError'])){
					?>
					<div class="email-doesnt-exist">
						 <p> This email address doesn't exist. </p>
					</div>
					<?php
						}
					?>
					<div class="email-error">
						 <p> Please enter a valid email address. </p>
					</div>
				</div>
				<div class="form-field">
					<label for="password"> Password: </label>
					<input id="password" class="form-control" type="password" name="password" placeholder="Please enter your password">
					<?php
						if(isset($_REQUEST['passwordError'])){
					?>
					<div class="password-doesnt-match">
						<p> The password you have entered doesn't match this email address. </p>
					</div>
					<?php
						}
					?>
					<div class="password-error">
						<p> Password must be more than 6 characters. </p>
					</div>
				</div>
				<button class="LoginButton" type="submit"> LOGIN </button>
			</form>
		</main>
		<footer>
				<div>
					<p><i class="far fa-copyright"></i> collegelink 2022 </p>
				</div>
				<script src="https://kit.fontawesome.com/cd63bb6cf3.js" crossorigin="anonymous"></script>
				<link rel="preconnect" href="https://fonts.googleapis.com">
				<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
				<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500&display=swap" rel="stylesheet">
				<link href="http://hotel.collegelink.localhost/public/assets/css/login.css" type="text/css" rel="stylesheet">
				<script src="http://hotel.collegelink.localhost/public/assets/JavaScript/login.js" type="text/javascript"></script>
			</footer>
	</body>
