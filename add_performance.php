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
	$ProductID = $data->ProductID;
	$NetworkID = $data->NetworkID;
	$BrandID = $data->BrandID;
	$Date = substr($data->Date, 0, 10);
	$Cost = preg_replace('/[\$,]/', '', $data->Cost);
	$Revenue = preg_replace('/[\$,]/', '', $data->Revenue);
	$Leads = $data->Leads;
	$Device = $data->Device;

	// $result = $conn->query("SELECT * FROM performance WHERE (Date = '$Date' AND ProductID = '$ProductID' AND Device = '$Device' AND NetworkID = $NetworkID)");
	$res = $conn->prepare("SELECT ID FROM performance WHERE (Date = ? AND ProductID = ? AND Device = ? AND NetworkID = ?)");
	$res->bind_param( "sisi", $Date, $ProductID, $Device, $NetworkID);
	$res->execute();
	$result = $res->get_result();
	if ($result->num_rows > 0) {
		echo 'Duplicate Performance';
	   // do something to alert user about non-unique performance
	} else {
		echo 'before prepare';
		// prepare and bind
		$stmt = $conn->prepare("INSERT INTO performance (ProductID, NetworkID, BrandID, Date, Cost, Revenue, Leads, Device) VALUES (?, ?, ?, STR_TO_DATE(?, '%Y-%m-%d'), ?, ?, ?, ?)");
		$stmt->bind_param("iiisddis", $ProductID, $NetworkID, $BrandID, $Date, $Cost, $Revenue, $Leads, $Device);
		echo ' after prepare';
		
		$stmt->execute();
		echo 'after execute';
		$stmt->close();
		$conn->close();
		echo 'finished';
	}
	
?>