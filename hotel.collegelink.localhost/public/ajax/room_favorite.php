<?php

use Hotel\User;
use Hotel\Favorite;

// Boot application
require_once __DIR__. '/../../boot/boot.php';


// Return to home page if not a post request
if (strtolower($_SERVER['REQUEST_METHOD']) != 'post') {

	return;
}

// Check if room id is given
$roomId = $_REQUEST['room_id'];
if(empty($roomId)) {
	
	return;
}

// Verify csrf //Δεν το έχω ενεργοποιήσει διότι αλλιώς δεν γίνεται το redirect στην αρχική όταν ο χρήστης
//δοκιμάζει να βάλει το δωμάτιο στα αγαπημένα ενώ δεν είναι συνδεδεμένος.
// $csrf = $_REQUEST['csrf'];
// if(empty($csrf) || !User::verifyCsrf($csrf)){
	// echo 'This is an invalid request';
	// return;
// }

// Get current user id
if(empty(User::getCurrentUserId())){
	$userId = '';
}else{
	$userId = User::getCurrentUserId();
}


// Set room to favorites
$favorite = new Favorite();

// Add or remove room from favorites
$isFavorite = $_REQUEST['is_favorite'];

if(!$isFavorite) {
	$status = $favorite->addFavorite($roomId, $userId);
} else{
	$status = $favorite->removeFavorite($roomId, $userId);
}

// Return operation status
header('Content-Type: application/json');
echo json_encode([
	'status' => $status,
	'is_favorite' => !$isFavorite,
	'user' => $userId
]);
