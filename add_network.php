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
	$NetworkName = $data->NetworkName;

	// $result = $conn->query("SELECT * FROM network WHERE NetworkName = '$NetworkName'");
	$res = $conn->prepare("SELECT NetworkName FROM network WHERE NetworkName = ?");
	$res->bind_param( "s", $NetworkName);
	$res->execute();
	$result = $res->get_result();
	if (!$result) {
		echo "oops";
		die($mysqli->error);
	}
	if ($result->num_rows > 0) {
	   echo "Duplicate Network";
	   // do something to alert user about non-unique network
	} else {
		echo 'before prepare';
		// prepare and bind
		$stmt = $conn->prepare("INSERT INTO network (NetworkName) VALUES (?)");
		$stmt->bind_param("s", $NetworkName);
		echo ' after prepare';
		
		$stmt->execute();
		echo 'after execute';
		$stmt->close();
		$conn->close();
		echo 'finished';
	}
?>