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
	$BID = $data->BID;
	$ProductName = $data->ProductName;

	// $result = $conn->query("SELECT * FROM product WHERE ProductName = '$ProductName' AND BID = '$BID'");
	$res = $conn->prepare("SELECT ID FROM product WHERE ProductName = ? AND BID = ?");
	$res->bind_param( "si", $ProductName, $BID);
	$res->execute();
	$result = $res->get_result();
	if (!$result) {
		echo $ProductName;
		echo "oops";
		die($mysqli->error);
	}
	if ($result->num_rows > 0) {
	   echo "Duplicate Product";
	   // do something to alert user about non-unique product
	} else {
		echo 'before prepare';

		// prepare and bind
		$stmt = $conn->prepare("INSERT INTO product (BID, ProductName) VALUES (?, ?)");
		$stmt->bind_param("is", $BID, $ProductName);

		echo ' after prepare';
		$stmt->execute();
		echo 'after execute';
		$stmt->close();
		$conn->close();
		echo 'finished';
	}
	
?>