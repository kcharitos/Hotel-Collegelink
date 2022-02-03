<?php

use Hotel\User;
use Hotel\Review;

// Boot application
require_once __DIR__. '/../../boot/boot.php';


// Return to home page if not a post request
if (strtolower($_SERVER['REQUEST_METHOD']) != 'post') {
	header('Location: /public/');
	
	return;
}

// If no user is loged in, return to main page
if(empty(User::getCurrentUserId())){
	header('Location: http://hotel.collegelink.localhost/public/');
	
	return;
}

// Check if room id is given
$roomId = $_REQUEST['room_id'];
if(empty($roomId)) {
	header('Location: /public/');
	
	return;
}

// Verify csrf
$csrf = $_REQUEST['csrf'];
if($csrf || !User::verifyCsrf($csrf)){
	header('Location: /public/');
	
	return;
}

// Add review
$review = new Review();
$review->insert($roomId, User::getCurrentUserId(), $_REQUEST['rate'], $_REQUEST['comment']);

//Return to room page
header(sprintf('Location: /public/room.php?room_id=%s',$roomId));