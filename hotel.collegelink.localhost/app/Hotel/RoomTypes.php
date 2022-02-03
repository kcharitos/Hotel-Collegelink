<?php

namespace Hotel;

use PDO;
use DateTime;
use Hotel\BaseService;

class RoomTypes extends BaseService
{
	public function getAllTypes()
	{
		// Get all room types
		return $this->fetchAll('SELECT * FROM room_type');
	}
	
	public function IdToTitle($typeId)
	{
		$parameters = [':type_id' => $typeId];
		
		// Converts Room Id to Room Title
		return $this->fetch('SELECT title FROM room_type WHERE type_id = :type_id', $parameters);
	}
	
}