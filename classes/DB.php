<?php

class DB{

	// Объект класса PDO
	private static $db;

	// Соединение с БД
	public static function init()
	{
		$config = require ('config.php');
		try{
			self::$db = new PDO('mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['dbname'], $config['db']['login'], $config['db']['password']);
		}catch(PDOException $e) {
			echo "Error!: " . $e->getMessage();
			exit();
		}
	}

	// Операции над БД
	public static function query($sql, $params = [])
	{
		// Подготовка запроса
		$stmt = self::$db->prepare($sql);
		
		// Обход массива с параметрами и подставляем значения
		if ( !empty($params) ) {
			foreach ($params as $key => $value) {
				$stmt->bindValue(":$key", $value);
			}
		}
		if(!$stmt){
		    $_SESSION['error'] = self::$db->errorInfo()[2];
        }
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	public static function getAll($table, $sql = '', $params = [])
	{
		return self::query("SELECT * FROM $table" . $sql, $params);
	}

	public static function getRow($table, $sql = '', $params = [])
	{
		$result = self::query("SELECT * FROM $table LIMIT 1" . $sql, $params);
		return $result[0]; 
	}


}