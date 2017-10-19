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
	$ID = $data->ID;
	$BrandID = $data->BrandID;
	$Date = substr($data->Date, 0, 10);
	$Revenue = preg_replace('/[\$,]/', '', $data->Revenue);


	$result = $conn->query("SELECT * FROM cart WHERE (Date = '$Date' AND BrandID = '$BrandID')");
	while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
		$row=array();
		$row['ID']=addslashes($rs["ID"]);
		$row['BrandID']=addslashes($rs["BrandID"]);
		$row['Date']=addslashes($rs["Date"]);
		$row['Revenue']=addslashes($rs["Revenue"]);
	}
	// echo 'start result '.$row['ProductID'].' end result';
	// echo 'start productID '.$ProductID.' end productID';
	// if ($result->num_rows > 0) {
	// 	if ($row['ID'] != $ID ){
	// 		echo 'Duplicate Performance';
	// 	   // do something to alert user about non-unique performance
			
	// 	}else{
	// 		echo 'before prepare';
	// 		// prepare and bind
	// 		$stmt = $conn->prepare("UPDATE cart SET BrandID=?, Date=STR_TO_DATE(?, '%Y-%m-%d'), CRevenue=? WHERE ID=$ID");
	// 		$stmt->bind_param("isd", $BrandID, $Date, $Revenue);
	// 		echo ' after prepare';
			
	// 		$stmt->execute();
	// 		echo 'after execute';
	// 		echo "Stmt: $ID, $BrandID, $Date, $Revenue";
	// 		$stmt->close();
	// 		$conn->close();
	// 		echo 'finished';
	// 	}
	// } else {
	// 	echo 'before prepare';
	// 	// prepare and bind
	// 	$stmt = $conn->prepare("UPDATE cart SET BrandID=?, Date=STR_TO_DATE(?, '%Y-%m-%d'), CRevenue=? WHERE ID=$ID");
	// 	$stmt->bind_param("isd", $BrandID, $Date, $Revenue);
	// 	echo ' after prepare';
		
	// 	$stmt->execute();
	// 	echo 'after execute';
	// 	echo "Stmt: $ID, $BrandID, $Date, $Revenue";
	// 	$stmt->close();
	// 	$conn->close();
	// 	echo 'finished';
	// }

	if($ID == ""){
		echo 'before prepare';

		if($checkDupe = $conn->prepare("SELECT * FROM cart WHERE BrandID = ? AND Date = ?")){
			echo 'prepare checkDupe success';
			if($checkDupe->bind_param("is", $BrandID, $Date)){
				echo 'bind checkDupe success';
				if($checkDupe->execute()){
					echo 'execute checkDupe success';
					if($resultDupe = $checkDupe->get_result()){
						if ($resultDupe->num_rows > 0){
							echo 'Duplicate Performance';
						}
						else {
							// prepare and bind
							$stmt = $conn->prepare("INSERT INTO cart (BrandID, Date, CRevenue) VALUES (?, STR_TO_DATE(?, '%Y-%m-%d'), ?)");
							$stmt->bind_param("isd", $BrandID, $Date, $Revenue);
							echo ' after prepare';
							
							$stmt->execute();
							echo 'after execute';
						}
					}
					else{echo 'error getting result';}
				}
				else{echo 'Execute checkDupe failed ('.$checkDupe->errno.')'.$checkDupe->error;}
			}
			else{echo 'bind checkDupe failure';}	
		}
		else{echo 'prepare checkDupe error';}
		
		$checkDupe->close();

		
		$stmt->close();
		$conn->close();
		echo 'finished';
	}
	else {
		echo 'before prepare';
		// prepare and bind
		$stmt = $conn->prepare("UPDATE cart SET BrandID=?, Date=STR_TO_DATE(?, '%Y-%m-%d'), CRevenue=? WHERE ID=$ID");
		$stmt->bind_param("isd", $BrandID, $Date, $Revenue);
		echo ' after prepare';
		
		$stmt->execute();
		echo 'after execute';
		echo "Stmt: $ID, $BrandID, $Date, $Revenue";
		$stmt->close();
		$conn->close();
		echo 'finished';

		
	}

?>