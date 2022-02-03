<?php

require __DIR__.'/../boot/boot.php';

use Hotel\Room;
use Hotel\RoomTypes;

// Get cities
$room = new Room();
$cities = $room->getCities();

// Get all room types
$type = new RoomTypes();
$allTypes = $type->getAllTypes();

?>

<!DOCTYPE>
<html>
	<head>
		<meta name="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title> Room search </title>
		<link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
		<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
		<script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>
	</head>
	<body>
		<header>
			<div class="container">
				<div class="hotels-logo">
				<p> Hotels </p>
				</div>
				<div class="home-logo">
				<a href="http://hotel.collegelink.localhost/public/home.php"><i class="fas fa-home"></i> Home </a>
				</div>
			</div>
		</header>
		<main>
			<form action="list.php">
				<div class="form-selects">
					<select name="city">
						<option value="" selected disabled>City</option>
						<?php 
							foreach($cities as $city) {
						?>
							<option value="<?php echo $city; ?>"><?php echo $city; ?></option>
						<?php 
							}
						?>
					</select>
					<select name="room_type">
						<option value="" selected disabled>Room Type</option>
						<?php 
							foreach($allTypes as $roomType) {
						?>
							<option value="<?php echo $roomType['type_id']; ?>"><?php echo $roomType['title']; ?></option>
						<?php 
							}
						?>
					</select>
				</div>
				<div class="form-dates">
						<input name="check_in_date" type="text" placeholder="Check-in Date" id="from"/>
						<input name="check_out_date" type="text" placeholder="Check-out Date" id="to"/>
				</div>
				<div class="searchbutton">
					<button class="SearchButton" type="submit"> Search </button>
				</div>
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
			<link href="http://hotel.collegelink.localhost/public/assets/css/home.css" type="text/css" rel="stylesheet">
			<script src="http://hotel.collegelink.localhost/public/assets/JavaScript/home.js" type="text/javascript"></script>
		</footer>
	</body>
</html>	