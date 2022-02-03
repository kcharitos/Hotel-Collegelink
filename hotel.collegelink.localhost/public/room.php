<?php

require __DIR__.'/../boot/boot.php';

use Hotel\Room;
use Hotel\RoomTypes;
use Hotel\Favorite;
use Hotel\User;
use Hotel\Review;
use Hotel\Booking;

// Initialize room service.
$room = new Room();
$favorite = new Favorite();

// Initialize room types
$type = new RoomTypes();


// Check for room id
$roomId = $_REQUEST['room_id'];
if(empty($roomId)) {
	header('Location: /public/home.php');
	return;
}

$roomInfo = $room->get($roomId);
if(empty($roomInfo)) {
	header('Location: /public/home.php');
	return;
}

// Get cuurent user id
$userId = User::getCurrentUserId();

// Check if room is favorite for current user.
$isFavorite = $favorite->isFavorite($roomId, $userId);

// Load all room reviews
$review = new Review();
$allReviews = $review->getReviewByRoom($roomId);

// Check for booking room
$checkInDate = $_REQUEST['check_in_date'];
$checkOutDate = $_REQUEST['check_out_date'];
$alreadyBooked = empty($checkInDate) || empty($checkOutDate);
if(!$alreadyBooked) {
	// Look for bookings
	$booking = new Booking();
	$isBooked = $booking->isBooked($roomId, $checkInDate, $checkOutDate);
}

?>

<!DOCTYYPE>
<html>
<head>
    <meta name="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title> Room Page </title>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
	<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
	<script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>
</head>
	<body>
		<header>
			<div class="header-container">
				<div class="hotels-logo">
					<p> Hotels </p>
				</div>
				<div class="home-logo">
					<a href="http://hotel.collegelink.localhost/public/home.php"><i class="fas fa-home"></i> Home </a>
				</div>
				<div class="profile-logo">
					<a href="http://hotel.collegelink.localhost/public/profile.php"><i class="fas fa-user"></i> Profile </a>
				</div>
			</div>
		</header>
		<main>
			<div class="basic-info">
				<div class="location"><?php  echo sprintf('%s - %s, %s', $roomInfo['name'], $roomInfo['area'], $roomInfo['city']) ?></div>
				<div class="reviews"> 
					Reviews: 
					<?php
						$RoomAvgReview = $roomInfo['avg_reviews'];
						for($i=1 ; $i<=5 ;$i++){
							if($RoomAvgReview >= $i) {
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
				</div>
				<div class="favorite" id="favorite">
					<form name="favoriteForm" class="favoriteForm" id="favoriteForm" method="post" action="actions/favorite.php">
						<input type="hidden" name="room_id" value="<?php echo $roomId; ?>">
						<input type="hidden" name="is_favorite" value="<?php echo $isFavorite ? '1' : '0'; ?>">
						<button type="submit"><i class="<?php echo $isFavorite ? 'fas' : 'far'; ?> fa-heart"></i></button>
					</form>
				</div>
				<div class="per-night"> Per Night: <?php echo $roomInfo['price'] ?>€ </div>
			</div>
			<div class="image">
				<img src="http://hotel.collegelink.localhost/public/assets/fonts/<?php  echo $roomInfo['photo_url'] ?>" width="100%" height="100%">
			</div>
			<div class="additional-info">
				<div class="CountOfGuests"><i class="fas fa-user"></i><?php echo $roomInfo['count_of_guests'] ?><p> COUNT OF GUESTS </p></div>
				<div class="TypeOfRoom"><i class="fas fa-bed"></i><?php $title = $type->IdToTitle($roomInfo['type_id']); foreach($title as $item){
							echo $item;} ?><p> TYPE OF ROOM </p></div>
				<div class="Parking"><i class="fas fa-parking"></i><?php echo $room->YesOrNo($roomInfo['parking']);?><p> PARKING </p></div>
				<div class="WiFi"><i class="fas fa-wifi"></i><?php echo $room->YesOrNo($roomInfo['wifi']);?><p> WIFI </p></div>
				<div class="PetFriendly"><i class="fas fa-paw"></i><?php echo $room->YesOrNo($roomInfo['pet_friendly']);?><p> PET FRIENDLY </p></div>
			</div>
			<div class="description">
				<h3> Room Description </h3>
				<p><?php echo $roomInfo['description_long'] ?></p>
			</div>
			<?php
				if($alreadyBooked){
			?>
			<div class="AlreadyBooked">
				<p> Already Booked </p>
			</div>
			<?php
				} else{
			?>
			<form class="booking-form" method="post" action="actions/book.php">
				<input type="hidden" name="room_id" value="<?php echo $roomId ?>">
				<input type="hidden" name="check_in_date" value="<?php echo $checkInDate ?>">
				<input type="hidden" name="check_out_date" value="<?php echo $checkOutDate ?>">
				<div class="BookButton">
					<button> Book Now </button>
				</div>
			</form>
			<?php
				}
			?>
			<iframe src="https://www.google.com/maps?q=<?php echo $roomInfo['location_lat']; ?>,<?php echo $roomInfo['location_long']; ?>&hl=es;z=14&amp;output=embed"
					width="810"
					height="450"
					style="border:0;margin:30px 0;"
					allowfullscreen=""
					loading="lazy">
			</iframe>
			<div class="line"></div>
				<div class="user-review">
					<h3> Reviews </h3>
					<div id="room-review-container">
						<?php 
							if(count($allReviews) > 0){
								foreach($allReviews as $counter => $review) {
						?>
						<h4>
							<?php echo sprintf('%d. %s', $counter + 1, $review['user_name']); ?>
							<?php
								for($i=1 ; $i<=5 ;$i++){
									if($review['rate'] >= $i) {
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
						<h5> Created time: <?php echo $review['created_time']; ?></h5>
						<p><?php echo htmlentities($review['comment']); ?></p>
						<?php
								}
							}else{
						?>
						<div class="no-reviews">
							<p> There are no reviews for this room. </p>
						</div>
					<?php
						}
					?>
				</div>
			</div>
			<div class="user-review">
				<h3> Add review </h3>
				<form class="review-form" id="review-form" method="post" action="actions/review.php">
					<input type="hidden" name="user_id" value="<?php echo $userId; ?>">
					<input type="hidden" name="room_id" value="<?php echo $roomId; ?>">
					<input type="hidden" name="csrf" value="<?php echo User::getCsrf(); ?>">
					<div class="rating" id="rating">
						<i class="far fa-star" data-value="1"></i>
						<i class="far fa-star" data-value="2"></i>
						<i class="far fa-star" data-value="3"></i>
						<i class="far fa-star" data-value="4"></i>
						<i class="far fa-star" data-value="5"></i>
						<input type="hidden" id="rate" name="rate" value="">
					</div>
					<div class="comments">
						<textarea name="comment" class="review-textarea"></textarea>
					</div>
					<div class="submit-button" id="submit-button">
						<button type="submit" class="submitButton"> Submit </button>
					</div>
				</form>
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
            <link href="http://hotel.collegelink.localhost/public/assets/css/room.css" type="text/css" rel="stylesheet">
			<link href="http://hotel.collegelink.localhost/public/assets/css/HeaderAndFooter.css" type="text/css" rel="stylesheet">
            <script src="http://hotel.collegelink.localhost/public/assets/JavaScript/room.js" type="text/javascript"></script>
			<script src="http://hotel.collegelink.localhost/public/assets/JavaScript/favorite&review.js" type="text/javascript"></script>
        </footer>
	</body>
</html>