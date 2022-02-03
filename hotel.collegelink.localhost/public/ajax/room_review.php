<?php

use Hotel\User;
use Hotel\Review;
use Hotel\Favorite;

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

// Add review
$review = new Review();
$review->insert($roomId, User::getCurrentUserId(), $_REQUEST['rate'], $_REQUEST['comment']);

// Verify csrf
$csrf = $_REQUEST['csrf'];
if(empty($csrf) || !User::verifyCsrf($csrf)){
	echo 'This is an invalid request';
	return;
}

// Get all reviews
$roomReview = $review->getReviewByRoom($roomId);
$counter = count($roomReview);

// Load user
$user = new User();
$userInfo = $user->getByUserId(User::getCurrentUserId());

?>


<?php 
	if($counter > 0){
?>
<h4>
<?php echo sprintf('%d. %s', $counter, $userInfo['name']); ?>
<?php
	for($i=1 ; $i<=5 ;$i++){
		if($_REQUEST['rate'] >= $i) {
?>
		<i class="fas fa-star"></i>
<?php
		}else {
?>
		<i class="far fa-star"></i>
<?php
		}
	}
?>
</h4>
<h5> Created time: <?php echo (new DateTime())->format('Y-m-d H:i:s'); ?></h5>
<p><?php echo htmlentities($_REQUEST['comment']); ?></p>
<?php
	}else{
?>
<div class="no-reviews">
<p> There are no reviews for this room. </p>
</div>
<?php
	}
?>
