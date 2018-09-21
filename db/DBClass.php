<?php
require_once( 'DBSettings.php' );
//Database class to connect to database and fire queries
class DBClass extends DatabaseSettings
{
	var $classQuery;
	var $link;

	var $errno = '';
	var $error = '';

	// Connects to the database
	function __construct()
	{
		// Load settings from parent class
		$settings = DatabaseSettings::getSettings();

		// Get the main settings from the array we just loaded
		$host = $settings['dbhost'];
		$name = $settings['dbname'];
		$user = $settings['dbusername'];
		$pass = $settings['dbpassword'];

		// Connect to the database
		$this->link = new mysqli( $host , $user , $pass , $name );
	}

	// Executes a database query
	function query( $query )
	{
		$this->classQuery = $query;
		return $this->link->query( $query );
	}

	function escapeString( $query )
	{
		return $this->link->escape_string( $query );
	}

	// Get the data return int result
	function numRows( $result )
	{
		return $result->num_rows;
	}

	function lastInsertedID()
	{
		return $this->link->insert_id;
	}

	// Get query using assoc method
	function fetchAssoc( $result )
	{
		return $result->fetch_assoc();
	}

	// Gets array of query results
	function fetchArray( $result , $resultType = MYSQLI_ASSOC )
	{
		return $result->fetch_array( $resultType );
	}

	// Fetches all result rows as an associative array, a numeric array, or both
	function fetchAll( $result , $resultType = MYSQLI_ASSOC )
	{
		return $result->fetch_all( $resultType );
	}

	// Get a result row as an enumerated array
	function fetchRow( $result )
	{
		return $result->fetch_row();
	}

	// Free all MySQL result memory
	function freeResult( $result )
	{
		$this->link->free_result( $result );
	}

	//Closes the database connection
	function close()
	{
		$this->link->close();
	}

	function sql_error()
	{
		if( empty( $error ) )
		{
			$errno = $this->link->errno;
			$error = $this->link->error;
		}
		return $errno . ' : ' . $error;
	}
}
?>
