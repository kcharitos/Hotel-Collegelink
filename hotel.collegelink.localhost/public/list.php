<?php

require __DIR__.'/../boot/boot.php';

use Hotel\Room;
use Hotel\RoomTypes;
// use DateTime;

// Initialize room service.
$room = new Room();

// Get page parameters
$selectedPriceMin = $_GET['amount1'];
if($_GET['amount2'] == 0){
	$selectedPriceMax = "600";
} else{
	$selectedPriceMax = $_GET['amount2'];
}
$selectedGuests = $_GET['count_of_guests'];
$selectedCity = $_GET['city'];
$selectedTypeId = $_GET['room_type'];
$checkInDate = $_GET['check_in_date'];
$checkOutDate = $_GET['check_out_date'];

// Search for room
$allAvailableRooms = $room->searchRoom(new \DateTime($checkInDate), new \DateTime($checkOutDate), $selectedCity, $selectedTypeId, 
$selectedGuests, $selectedPriceMin, $selectedPriceMax);

// Get all cities
$cities = $room->getCities();

// Get all guests
$guests = $room->getGuests();

// Get all room types
$type = new RoomTypes();
$allTypes = $type->getAllTypes();


?>


<!DOCTYYPE>
<html>
<head>
    <meta name="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title> Search Results</title>
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
			<aside class="effect">
				<div class="left-shadow"></div>
				<div class="right-shadow"></div>
				<form class="SearchForm" action="list.php">
					<div>
						<h3> FIND THE PERFECT HOTEL </h3>
					</div>
					<div class="count-of-guests">
						<select name="count_of_guests">
							<option value="" selected disabled>Count of Guests</option>
							<?php 
								foreach($guests as $guest) {
							?>
								<option <?php echo $selectedGuests == $guest ? 'selected="selected"' : ''; ?>
								value="<?php echo $guest; ?>"><?php echo $guest; ?></option>
							<?php 
								}
							?>
						</select>
					</div>
					<div class="RoomType">
						<select name="room_type">
							<option value="" selected disabled>Room Type</option>
							<?php 
								foreach($allTypes as $roomType) {
							?>
								<option <?php echo $selectedTypeId == $roomType['type_id'] ? 'selected="selected"' : ''; ?>
								value="<?php echo $roomType['type_id']; ?>"><?php echo $roomType['title']; ?></option>
							<?php 
								}
							?>
						</select>
					</div>
					<div class="City">
						<select name="city">
							<option value="" selected disabled>City</option>
							<?php 
								foreach($cities as $city) {
							?>
								<option <?php echo $selectedCity == $city ? 'selected="selected"' : ''; ?>
								value="<?php echo $city; ?>"><?php echo $city; ?></option>
							<?php 
								}
							?>
						</select>
					</div>
					<div class="SliderAmounts" id="SliderAmounts">
						<div class="amount1">
							<input value="<?php echo $selectedPriceMin; ?>" type="text" id="amount1" name="amount1">
						</div>
						<div class="amount2">
							<input value="<?php echo $selectedPriceMax; ?>" type="text" id="amount2" name="amount2">
						</div>
					</div>
					<div id="slider-range"></div>
					<div class="priceTags">
						<div>
							<p>PRICE MIN.</p>
						</div>
						<div>
							<p>PRICE MAX.</p>
						</div>
					</div>
					<div class="Calendar">
						<input type="text" placeholder="Check-in Date" name="check_in_date" id="from" value="<?php echo $checkInDate; ?>"/>
					</div>
					<div class="Calendar">
						<input type="text" placeholder="Check-out Date" name="check_out_date" id="to" value="<?php echo $checkOutDate; ?>" />
					</div>
					<div>
						<button class="SearchButton">FIND HOTEL</button>
					</div>
				</form>
			</aside>
			<section class="ListOfRooms" id="ListOfRooms">
				<div class="SearchResults">
					<p> Search Results </p>
				</div>
				<?php 
					foreach($allAvailableRooms as $availableRoom) {
				?>
				<div class="roomContainer">
					<div class="room-photo">
						<img src="http://hotel.collegelink.localhost/public/assets/fonts/<?php echo $availableRoom['photo_url']; ?>" width="100%" height="95%">
					</div>
					<div class="roomInfo">
						<h3> <?php echo $availableRoom['city']; ?> </h3>
						<h4> <?php echo $availableRoom['name']; ?>, <?php echo $availableRoom['area']; ?></h4>
						<p> <?php echo $availableRoom['description_short']; ?> </p>
						<a class="GoToRoomPage" href="http://hotel.collegelink.localhost/public/room.php?room_id=<?php echo $availableRoom['room_id']; ?>&<?php echo $_SERVER['QUERY_STRING']; ?>"> Go to Room Page </a>
					</div>
					<div class="roomDetails">
						<div class="PerNight"> Per Night:<?php echo $availableRoom['price']; ?>€ </div>
						<div class="CountOfGuests"> Count of Guests:<?php echo $availableRoom['count_of_guests']; ?> </div>
						<div class="TypeOfRoom"> Type of Room: <?php $title = $type->IdToTitle($availableRoom['type_id']); foreach($title as $item){
						echo $item;} ?> </div>
					</div>
				</div>
				<?php 
					}
				?>
				<?php if(count($allAvailableRooms) == 0){ ?>
				<div class="noRooms">
					<p> There are no available rooms. </p>
				</div>
				<?php 
					} 
				?>
			</section>
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
			<link href="http://hotel.collegelink.localhost/public/assets/css/HeaderAndFooter.css" type="text/css" rel="stylesheet">
            <script src="http://hotel.collegelink.localhost/public/assets/JavaScript/list.js" type="text/javascript"></script>
			<script src="http://hotel.collegelink.localhost/public/assets/JavaScript/search.js" type="text/javascript"></script>
        </footer>
	</body>
</html>