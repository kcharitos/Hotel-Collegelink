<?php

namespace Hotel;

use PDO;
use Support\Configuration\Configuration;

class BaseService
{
	private static $pdo;
	
	public function __construct()
	{
		$this->initializePdo();
	}
	
	protected function initializePdo()
	{
		// Check if pdo is already initialized
		if(!empty(self::$pdo)) {
			return;
		}
		
		// Load database configuration
		$config = Configuration::getInstance();
		$databaseConfig = $config->getConfig()['database'];
		
		// Conect to database
		self::$pdo = new PDO(sprintf('mysql:host=%s;dbname=%s;charset=UTF8', $databaseConfig['host'],
		$databaseConfig['database']), $databaseConfig['user'], $databaseConfig['password'],[PDO::
		MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'UTF8'"]);
	}
	
	protected function getPdo()
	{
		return self::$pdo;
	}
	
	protected function execute($sql, $parameters)
	{
		// Prepare statement
		$statement = $this->getPdo()->prepare($sql);
		
		// Bind parameters
		//foreach ($parameters as $key => $value) {
			//$statement->bindParam($key, $value, is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR);
		//}
		
		// Execute
		$status = $statement->execute($parameters);
		
		return $status;
	}
	
	protected function fetchAll($sql, $parameters = [], $type = PDO::FETCH_ASSOC)
	{
		// Prepare statement
		$statement = $this->getPdo()->prepare($sql);
		
		// Bind parameters
		//foreach ($parameters as $key => $value) {
			//$statement->bindValue($key, $value, is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR);
		//}
		
		// Execute
		$statement->execute($parameters);
		
		// Fetch all
		return $statement->fetchAll($type);
	}
	
	protected function fetch($sql, $parameters = [], $type = PDO::FETCH_ASSOC)
	{
		// Prepare statement
		$statement = $this->getPdo()->prepare($sql);
		
		// Bind parameters
		//foreach ($parameters as $key => $value) {
			//$statement->bindValue($key, $value, is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR);
		//}
		
		// Execute
		$statement->execute($parameters);
		
		// Fetch all
		return $statement->fetch($type);
	}
}