<?php

namespace Hotel;

use PDO;
use Hotel\BaseService;
use DateTime;

class Room extends BaseService
{
	public function get($roomId)
	{
		$parameters = [':room_id' => $roomId];
		return $this->fetch('SELECT * FROM room WHERE room_id = :room_id', $parameters);
	}
	
	public function getCities()
	{
		// Get all cities
		$cities = [];
		$rows = $this->fetchAll('SELECT DISTINCT city FROM room');
		foreach($rows as $row) {
			$cities[] = $row['city'];
		}
		
		return $cities;
	}
	
	public function getGuests()
	{
		// Get all guests
		$guests = [];
		$rows = $this->fetchAll('SELECT DISTINCT count_of_guests FROM room');
		foreach($rows as $row) {
			$guests[] = $row['count_of_guests'];
		}
		
		return $guests;
	}
	
	public function YesOrNo($number)
	{
		if($number == 0) {
			$result = 'No';
		}
		
		if($number == 1) {
			$result = 'Yes';
		}
		
		return $result;
	}
	
	
	public function searchRoom($checkInDate='', $checkOutDate='', $city = '', $typeId = '', $guests = '', $priceMin = '0', $priceMax = '600')
	{
		// Setup parameters
		$parameters = [':check_in_date' => $checkInDate->format(DateTime::ATOM),
					   ':check_out_date' => $checkOutDate->format(DateTime::ATOM)];

		if (!empty($city)) {
			$parameters[':city'] = $city;
		}
		if (!empty($typeId)) {
			$parameters[':type_id'] = $typeId;
		}
		if (!empty($guests)) {
			$parameters[':count_of_guests'] = $guests;
		}
		if (!empty($priceMin)) {
			$parameters[':price_min'] = $priceMin;
		}
		if (!empty($priceMax)) {
			$parameters[':price_max'] = $priceMax;
		}
		
		// Build query
		$sql = 'SELECT * FROM room WHERE ';
		if (!empty($city)) {
			$sql .= 'city = :city AND ';
		}
		if (!empty($typeId)) {
			$sql .= 'type_id = :type_id AND ';
		}
		if (!empty($guests)) {
			$sql .= 'count_of_guests = :count_of_guests AND ';
		}
		if (!empty($priceMin)) {
			$sql .= 'price >= :price_min AND ';
		}
		if (!empty($priceMax)) {
			$sql .= 'price <= :price_max AND ';
		}
		$sql .= 'room_id NOT IN (
				SELECT room_id
				FROM booking
				WHERE check_in_date <= :check_out_date AND check_out_date >= :check_in_date
				)';
		
		// Get results
		return $this->fetchAll($sql, $parameters);
	}
}