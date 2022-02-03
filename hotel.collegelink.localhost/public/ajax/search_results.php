<?php

require __DIR__.'/../../boot/boot.php';

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