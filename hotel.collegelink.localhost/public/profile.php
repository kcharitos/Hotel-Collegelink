<?php

require __DIR__.'/../boot/boot.php';

use Hotel\Favorite;
use Hotel\Review;
use Hotel\User;
use Hotel\RoomTypes;
use Hotel\Booking;

// Get cuurent user id
$userId = User::getCurrentUserId();

// Check for logged in user
if(empty($userId)){
	header('Location: index.php');
	
	return;
}

// Find user's favorite rooms
$favorite = new Favorite();
$findFavorite = $favorite->findFavorite($userId);

// Find all user's reviews
$review = new Review();
$findReview = $review->findReview($userId);

// Find all user's bookings
$booking = new Booking();
$findBooking = $booking->findBooking($userId);

$type = new RoomTypes();

?>


<!DOCTYYPE>
<html>
<head>
    <meta name="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title> Profile Page </title>
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
				<div class="logout-logo">
					<a href="http://hotel.collegelink.localhost/public/actions/logout.php"><i class="fas fa-sign-out-alt"></i> Log-out </a>
				</div>
			</div>
		</header>
		<main>
			<div class="main-container">
                <aside class="effect">
                    <div class="left-shadow"></div>
                    <div class="right-shadow"></div>
                    <section class="fav-rev">
                        <div class="favorites">
							<h3> FAVORITES </h3>
							<?php
								if(!empty($findFavorite)){
							?>
							<ol>
								<li><a href="http://hotel.collegelink.localhost/public/room.php?room_id=<?php echo $findFavorite['room_id']; ?>"> <?php echo $findFavorite['name']; ?> </a></li>
							</ol>
							<?php
								}else{
							?>
							<div>
								<p> There are no favorite rooms. </p>
							</div>
							<?php
								}
							?>
						</div>
						<div class="reviews">
							<h3> REVIEWS </h3>
							<?php
								if(!empty($findReview)){
							?>
							<ol>
							<?php foreach($findReview as $review){ ?>
								<li>
								<a href="http://hotel.collegelink.localhost/public/room.php?room_id=<?php echo $review['room_id']; ?>">
									<?php
										echo $review['name'];
										$stars = $review['rate'];
										for($i=1 ; $i<=5 ;$i++){
											if($stars >= $i) {
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
								</a>
								</li>
								<?php
									}
								?>
							</ol>
							<?php
								}else{
							?>
							<div>
								<p> There are no reviews. </p>
							</div>
							<?php
								}
							?>
						</div>
                    </section>
                </aside>
				<section class="ListOfRooms">
					<div class="SearchResults">
						<p> My bookings </p>
					</div>
					<?php
						if(!empty($findBooking)){
							foreach($findBooking as $booking) {
					?>
					<div class="roomContainer">
						<div class="room-photo">
							<img src="http://hotel.collegelink.localhost/public/assets/fonts/<?php echo $booking['photo_url']; ?>" width="100%" height="95%">
						</div>
						<div class="roomInfo">
							<h3> <?php echo $booking['city']; ?> </h3>
							<h4> <?php echo $booking['name']; ?>, <?php echo $booking['area']; ?></h4>
							<p> <?php echo $booking['description_short']; ?> </p>
							<a class="GoToRoomPage" href="http://hotel.collegelink.localhost/public/room.php?room_id=<?php echo $booking['room_id']; ?>&<?php echo $_SERVER['QUERY_STRING']; ?>"> Go to Room Page </a>
						</div>
						<div class="roomDetails">
							<div class="total-cost"> Total Cost:<?php echo $booking['total_price']; ?>€ </div>
							<div class="dates"> Check-in Date:<?php echo $booking['check_in_date']; ?> </div>
							<div class="dates"> Check-out Date:<?php echo $booking['check_out_date']; ?> </div>
							<div class="room-type"> Type of Room: <?php $title = $type->IdToTitle($booking['type_id']); foreach($title as $item){
							echo $item;} ?> </div>
						</div>
					</div>
					<?php 
							}
						}else{
					?>
					<div>
						<p> There are no bookings. </p>
					</div>
					<?php
						}
					?>
				</section>
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
            <link href="http://hotel.collegelink.localhost/public/assets/css/list.css" type="text/css" rel="stylesheet">
			<link href="http://hotel.collegelink.localhost/public/assets/css/profile.css" type="text/css" rel="stylesheet">
			<link href="http://hotel.collegelink.localhost/public/assets/css/HeaderAndFooter.css" type="text/css" rel="stylesheet">
            <script src="http://hotel.collegelink.localhost/public/assets/JavaScript/list.js" type="text/javascript"></script>
        </footer>
	</body>
</html>