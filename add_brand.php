<?php
	include 'dbconfig.php';//make the cofig file include
	global $details;//make the connection vars global

	// Create connection
	$conn = new mysqli($details['server_host'], $details['mysql_name'],$details['mysql_password'], $details['mysql_database']);
	// Check connection
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	    echo "Error";
	} else {
		echo "Connection: success!";
	}

	$data = json_decode(file_get_contents("php://input"));
	$BrandName = $data->BrandName;

	// $result = $conn->query("SELECT * FROM brand WHERE BrandName = '$BrandName'");
	$res = $conn->prepare("SELECT BrandName FROM brand WHERE BrandName = ?");
	$res->bind_param( "s", $BrandName);
	$res->execute();
	$result = $res->get_result();
	// echo $results->num_rows;

	// $results->close();
	if (!$result) {
		echo $BrandName;
		echo "oops";
		die($mysqli->error);
	}
	if ($result->num_rows > 0) {
	   echo "Duplicate Brand";
	   // do something to alert user about non-unique brand
	} else {
		echo 'before prepare';
		// prepare and bind
		$stmt = $conn->prepare("INSERT INTO brand (BrandName) VALUES (?)");
		$stmt->bind_param("s", $BrandName);
		echo ' after prepare';
		
		$stmt->execute();
		echo 'after execute';
		$stmt->close();
		$conn->close();
		echo 'finished';
	}
?>