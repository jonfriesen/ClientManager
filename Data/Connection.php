<?php
require_once('Data/Config.php');
class Connection
{
	private static $connection = -1;
	private static $connectionFailed = false;
	
	private static function openConnection()
	{
		$server = Config::Get("database")["server"];
		$username = Config::Get("database")["username"];
		$password = Config::Get("database")["password"];
		$database = Config::Get("database")["database"];
		
		try
		{
			Connection::$connection = new PDO('mysql:host='.$server.';dbname='.$database, $username, $password);
			Connection::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		catch (PDOException $e)
		{
			echo 'ERROR'.$e->getMessage();
		}
		
	}
	private static function checkConnection()
	{
		if(is_object(Connection::$connection))
			return true;
		else if(!is_object(Connection::$connection) && Connection::$connectionFailed == false)
		{
			Connection::openConnection();
			if(!is_object(Connection::$connection))
			{
				Connection::$connectionFailed = true;
				return false;
			}
			else
				return true;
		}
		else
			return false;
	}
	
	private static function getParamType($value)
	{
		if (is_int($value) || ctype_digit($value))
    {
            $value = intval($value);
            return PDO::PARAM_INT;

    } elseif ($value === NULL) {

            return PDO::PARAM_NULL;

    } else {

            return PDO::PARAM_STR;
    }
	}

	public static function Query($spName)
	{
		// Check Connection
		if(!Connection::checkConnection())
		{
			echo 'Unable to establish a connection with the mysqli server';
			return new QueryErrorReader();
		}

		// Get Params
		$params = func_get_args();
		$params = array_splice($params, 1, sizeof($params) - 1);

		$placeHolder = '';
		for($i = 0; $i < sizeof($params); $i++)
		{
			$placeHolder .= ($i == 0 ? '?' : ', ?');
		}

		// Create statement
		$stmt = Connection::$connection->prepare("call ".$spName."(".$placeHolder.");");

		// Bind params
		for($i = 0; $i < sizeof($params); $i++)
		{
			$stmt->bindValue(($i+1), $params[$i], Connection::getParamType($params[$i]));
		}
		
		// Execute Statement
		$stmt->execute();

		// Get Results
		$result = $stmt->fetchAll(PDO::FETCH_OBJ);

		return $result;
	}
	public static function NonQuery($spName)
	{
		// Check Connection
		if(!Connection::checkConnection())
		{
			echo 'Unable to establish a connection with the mysqli server';
			return new QueryErrorReader();
		}

		// Get Params
		$params = func_get_args();
		$params = array_splice($params, 1, sizeof($params) - 1);

		$placeHolder = '';
		for($i = 0; $i < sizeof($params); $i++)
		{
			$placeHolder .= ($i == 0 ? '?' : ', ?');
		}

		// Create statement
		$stmt = Connection::$connection->prepare("call ".$spName."(".$placeHolder.");");

		// Bind params
		for($i = 0; $i < sizeof($params); $i++)
		{
			$stmt->bindValue(($i+1), $params[$i], Connection::getParamType($params[$i]));
		}
		
		// Execute Statement
		return $stmt->execute();
	}
	public static function ScalarQuery()
	{
		return call_user_func_array('Connection::Query', (func_get_args()))[0];
	}
}
?>