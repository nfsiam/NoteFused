<?php
	 $serverName="localhost";
	 $userName="root";
	 $password="";
	 $dbName="notefused";
	function execute($query)
	{
		global $serverName;
		global $userName;
		global $password;
		global $dbName;
		$conn = mysqli_connect($serverName, $userName,  $password, $dbName);
		mysqli_query($conn,$query);
		mysqli_close($conn);
	}
	
	function get($query)
	{
		global $serverName;
		global $userName;
		global $password;
		global $dbName;
		$conn = mysqli_connect( $serverName, $userName, $password, $dbName);
		$result=mysqli_query($conn,$query);
		mysqli_close($conn);
		return $result;
	}
	
	
?>