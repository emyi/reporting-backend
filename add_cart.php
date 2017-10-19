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
	$BrandID = $data->BrandID;
	$Date = substr($data->Date, 0, 10);
	$Revenue = preg_replace('/[\$,]/', '', $data->Revenue);


	// $result = $conn->query("SELECT * FROM cart WHERE (Date = '$Date' AND BrandID = $BrandID)");
	$res = $conn->prepare("SELECT BrandID FROM cart WHERE (Date = ? AND BrandID = ?)");
	$res->bind_param( "si", $Date, $BrandID);
	$res->execute();
	$result = $res->get_result();

	if ($result->num_rows > 0) {
		echo 'Duplicate Performance';
	   // do something to alert user about non-unique cart
	} else {
		echo 'before prepare';
		// prepare and bind
		$stmt = $conn->prepare("INSERT INTO cart (BrandID, Date, CRevenue) VALUES (?, STR_TO_DATE(?, '%Y-%m-%d'), ?)");
		$stmt->bind_param("isd", $BrandID, $Date, $Revenue);
		echo ' after prepare';
		
		$stmt->execute();
		echo 'after execute';
		$stmt->close();
		$conn->close();
		echo 'finished';
	}
	
?>