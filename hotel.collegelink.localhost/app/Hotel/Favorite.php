<?php

namespace Hotel;

use Hotel\BaseService;

class Favorite extends BaseService
{
	public function isFavorite($roomId, $userId)
	{
		$parameters = [':room_id' => $roomId, ':user_id' => $userId];
		$favorite = $this->fetchAll('SELECT * FROM favorite WHERE room_id = :room_id AND user_id = :user_id', $parameters);
		
		return !empty($favorite);
	}
	
	public function addFavorite($roomId, $userId)
	{
		$parameters = [':room_id' => $roomId, ':user_id' => $userId];
		$favorite = $this->execute('INSERT IGNORE INTO favorite (room_id, user_id) VALUES (:room_id, :user_id)', $parameters);
		
		return !empty($favorite);
	}
	
	public function removeFavorite($roomId, $userId)
	{
		$parameters = [':room_id' => $roomId, ':user_id' => $userId];
		$favorite = $this->execute('DELETE FROM favorite WHERE room_id = :room_id AND user_id = :user_id', $parameters);
		
		return !empty($favorite);
	}
	
	public function findFavorite($userId)
	{
		$parameters = [':user_id' => $userId];
		$favorite = $this->fetch('SELECT room.name, favorite.room_id
									FROM room 
									INNER JOIN favorite 
									ON room.room_id = favorite.room_id
									WHERE favorite.user_id = :user_id', $parameters);
		
		return $favorite;
	}
}