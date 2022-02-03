<?php

use Hotel\User;
use Hotel\Booking;

// Boot application
require_once __DIR__. '/../../boot/boot.php';


// Return to home page if not a post request
if (strtolower($_SERVER['REQUEST_METHOD']) != 'post') {
	header('Location: /public/');
	
	return;
}

// If no user is loged in, return to main page
if(empty(User::getCurrentUserId())){
	header('Location: /public/');
	
	return;
}

// Check if room id is given
$roomId = $_REQUEST['room_id'];
if(empty($roomId)) {
	header('Location: /public/');
	
	return;
}

// Verify csrf
// $csrf = $_REQUEST['csrf'];
// if(empty($csrf) || !User::verifyCsrf($csrf)){
	// echo 'This is an invalid request';
	// return;
// }

// Create booking
$booking = new Booking();
$checkInDate = $_REQUEST['check_in_date'];
$checkOutDate = $_REQUEST['check_out_date'];
$booking->insert($roomId, User::getCurrentUserId(), $checkInDate, $checkOutDate);

//Return to room page
header(sprintf('Location: /public/room.php?room_id=%s',$roomId));