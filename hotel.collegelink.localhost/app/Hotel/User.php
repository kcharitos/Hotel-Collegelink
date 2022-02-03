<?php

namespace Hotel;

use PDO;
use Hotel\BaseService;
use Support\Configuration\Configuration;

class User extends BaseService
{
	const TOKEN_KEY = 'asfdhkgjlr;ofijhgbfdklfsadf';
	
	private static $currentUserId;
	
	public function getByUserId($userId)
	{
		$parameters = [':user_id' => $userId];
		return $this->fetch('SELECT * FROM user WHERE user_id = :user_id', $parameters);
	}
	
	public function getByEmail($email)
	{
		$parameters = [':email' => $email];
		return $this->fetch('SELECT * FROM user WHERE email = :email', $parameters);
	}
	
	public function getAllEmails()
	{
		return $this->fetch('SELECT email FROM user');
	}
	
	
	public function getList()
	{
		return $this->fetchAll('SELECT * FROM user');
	}
	
	
	public function insert($name, $email, $password)
	{
		// Prepare statement
		$statement = $this->getPdo()->prepare('INSERT INTO user (name, email, password) VALUES (:name, :email, :password)');
		
		// Hash password
		$passwordHash = password_hash($password, PASSWORD_BCRYPT);
		
		// Bind parameters
		$statement->bindParam(':name', $name, PDO::PARAM_STR);
		$statement->bindParam(':email', $email, PDO::PARAM_STR);
		$statement->bindParam(':password', $passwordHash, PDO::PARAM_STR);
		
		$rows = $statement->execute();
		
		return $rows == 1;
	}
	
	public function verify($email, $password)
	{
		// Step 1 - Retrieve user
		$user = $this->getByEmail($email);
		
		// Step 2 - Verify user password
		return password_verify($password, $user['password']);
	}
	
	public function generateToken($userId, $token = '')
	{
		// Create token payload
		$payload = [
			'user_id' => $userId,
			'csrf' => $token ?: md5(time())
		];
		$payloadEncoded = base64_encode(json_encode($payload));
		$signature = hash_hmac('sha256', $payloadEncoded, self::TOKEN_KEY);

		return sprintf('%s.%s', $payloadEncoded, $signature);
	}
	
	public static function getTokenPayload($token)
	{
		// Get payload and signature
		[$payloadEncoded] = explode('.', $token);

		// Get payload
		return json_decode(base64_decode($payloadEncoded), true);
	}

	public function verifyToken($token)
	{
		// Get payload
		$payload = $this->getTokenPayload($token);
		$userId = $payload['user_id'];
		$csrf = $payload['csrf'];

		// Generate signature and verify
		return $this->generateToken($userId, $csrf) == $token;
	}
	
	public static function getCsrf()
	{
		// Get token payload
		$token = $_COOKIE['user_token'];
		$payload = self::getTokenPayload($token);
		
		return $payload['csrf'];
	}
	
	public static function verifyCsrf($csrf)
	{
		return self::getCsrf() == $csrf;
	}
	
	public static function getCurrentUserId()
	{
		return self::$currentUserId;
	}
	
	public static function setCurrentUserId($userId)
	{
		return self::$currentUserId = $userId;
	}
}