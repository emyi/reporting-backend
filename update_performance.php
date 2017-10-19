<?php
	include 'dbconfig.php';//make the cofig file include
	global $details;//make the connection vars global
	$method = empty($_GET['method']) ? "" : $_GET['method'];
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
	$ProductID = $data->ProductID;
	$NetworkID = $data->NetworkID;
	$Date = substr($data->Date, 0, 10);
	$Cost = preg_replace('/[\$,]/', '', $data->Cost);
	$Revenue = preg_replace('/[\$,]/', '', $data->Revenue);
	$Leads = $data->Leads;
	$Device = $data->Device;

	// $result = $conn->query("SELECT * FROM performance WHERE (Date = '$Date' AND BrandID = '$BrandID' AND ProductID = '$ProductID' AND Device = '$Device' AND NetworkID = $NetworkID)");
	// $res = $conn->prepare("SELECT * FROM performance WHERE (Date = ? AND BrandID = ? AND ProductID = ? AND Device = ? AND NetworkID = ?)");
	// $res->bind_param( "siisi", $Date, $BrandID, $ProductID, $Device, $NetworkID);
	// $res->execute();
	// $result = $res->get_result();
	// while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
	// 	$row=array();
	// 	$row['ID']=addslashes($rs["ID"]);
	// 	$row['BrandID']=addslashes($rs["BrandID"]);
	// 	$row['ProductID']=addslashes($rs["ProductID"]);
	// 	$row['NetworkID']=addslashes($rs["NetworkID"]);
	// 	$row['Date']=addslashes($rs["Date"]);
	// 	$row['Cost']=addslashes($rs["Cost"]);
	// 	$row['Revenue']=addslashes($rs["Revenue"]);
	// 	$row['Leads']=addslashes($rs["Leads"]);
	// 	$row['Device']=addslashes($rs["Device"]);
	// }



	// echo 'start result '.$row['ProductID'].' end result';
	// echo 'start productID '.$ProductID.' end productID';
	// if ($result->num_rows > 0) {
	// 	if ($row['ID'] != $ID ){
	// 		echo 'Duplicate Performance';
	// 	   // do something to alert user about non-unique performance
			
	// 	}else{
	// 		if($ID == ""){
	// 			echo 'before prepare';
	// 			// prepare and bind
	// 			$stmt = $conn->prepare("INSERT INTO performance (ProductID, NetworkID, BrandID, Date, Cost, Revenue, Leads, Device) VALUES (?, ?, ?, STR_TO_DATE(?, '%Y-%m-%d'), ?, ?, ?, ?)");
	// 			$stmt->bind_param("iiisddis", $ProductID, $NetworkID, $BrandID, $Date, $Cost, $Revenue, $Leads, $Device);
	// 			echo ' after prepare';
				
	// 			$stmt->execute();
	// 			echo 'after execute';
	// 			$stmt->close();
	// 			$conn->close();
	// 			echo 'finished';
	// 		}
	// 		else {


	// 			echo 'before prepare';
	// 			// prepare and bind
	// 			$stmt = $conn->prepare("UPDATE performance SET BrandID=?, ProductID=?, NetworkID=?, Date=STR_TO_DATE(?, '%Y-%m-%d'), Cost=?, Revenue=?, Leads=?, Device=? WHERE ID=$ID");
	// 			$stmt->bind_param("iiisddis", $BrandID, $ProductID, $NetworkID, $Date, $Cost, $Revenue, $Leads, $Device);
	// 			echo ' after prepare';
				
	// 			$stmt->execute();
	// 			echo 'after execute';
	// 			echo "Stmt: $ID, $BrandID, $ProductID, $NetworkID, $Date, $Cost, $Revenue, $Leads, $Device";
	// 			$stmt->close();
	// 			$conn->close();
	// 			echo 'finished';
	// 		}
	// 	}
	// } else {
	// 	if($ID == ""){
	// 		echo 'before prepare';
	// 		// prepare and bind
	// 		$stmt = $conn->prepare("INSERT INTO performance (ProductID, NetworkID, BrandID, Date, Cost, Revenue, Leads, Device) VALUES (?, ?, ?, STR_TO_DATE(?, '%Y-%m-%d'), ?, ?, ?, ?)");
	// 		$stmt->bind_param("iiisddis", $ProductID, $NetworkID, $BrandID, $Date, $Cost, $Revenue, $Leads, $Device);
	// 		echo ' after prepare';
			
	// 		$stmt->execute();
	// 		echo 'after execute';
	// 		$stmt->close();
	// 		$conn->close();
	// 		echo 'finished';
	// 	}
	// 	else {
	// 		echo 'before prepare';
	// 		// prepare and bind
	// 		$stmt = $conn->prepare("UPDATE performance SET BrandID=?, ProductID=?, NetworkID=?, Date=STR_TO_DATE(?, '%Y-%m-%d'), Cost=?, Revenue=?, Leads=?, Device=? WHERE ID=$ID");
	// 		$stmt->bind_param("iiisddis", $BrandID, $ProductID, $NetworkID, $Date, $Cost, $Revenue, $Leads, $Device);
	// 		echo ' after prepare';
			
	// 		$stmt->execute();
	// 		echo 'after execute';
	// 		echo "Stmt: $ID, $BrandID, $ProductID, $NetworkID, $Date, $Cost, $Revenue, $Leads, $Device";
	// 		$stmt->close();
	// 		$conn->close();
	// 		echo 'finished';
	// 	}
	// }
	if($checker = $conn->prepare("SELECT * FROM product WHERE ID = ?")){
		echo 'prepare checker success';
		if($checker->bind_param("i", $ProductID)){
			echo 'bind checker success';
			if($checker->execute()){
				echo 'execute checker success';
				if($result = $checker->get_result()){
					while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
						$row=array();
						$row['BID']=addslashes($rs["BID"]);
						if($row['BID'] == $BrandID){
							echo 'ProductID matches Brand';
						}
						else{die('ERROR: ProductID does not match Brand');}
					}
				}
				else{echo 'error getting result';}
			}
			else{echo 'Execute checker failed ('.$checker->errno.')'.$checker->error;}
		}
		else{echo 'bind checker failure';}	
	}
	else{echo 'prepare checker error';}
	
	$checker->close();
	// $conn->close();


	if($method == 'cost'){
		if($ID == ""){
			echo 'before insert cost';


			if($checkDupe = $conn->prepare("SELECT * FROM performance WHERE BrandID = ? AND ProductID = ? AND NetworkID = ? AND Date = ? AND Device = ?")){
				echo 'prepare checkDupe success';
				if($checkDupe->bind_param("iiiss", $BrandID, $ProductID, $NetworkID, $Date, $Device)){
					echo 'bind checkDupe success';
					if($checkDupe->execute()){
						echo 'execute checkDupe success';
						if($resultDupe = $checkDupe->get_result()){
							if ($resultDupe->num_rows > 0){
								echo 'Duplicate Performance';
							}
							else {
								// prepare and bind
								if($stmt = $conn->prepare("INSERT INTO performance (ProductID, NetworkID, BrandID, Date, Cost, Device) VALUES (?, ?, ?, STR_TO_DATE(?, '%Y-%m-%d'), ?, ?)")){
									echo 'prepare success';
									if($stmt->bind_param("iiisds", $ProductID, $NetworkID, $BrandID, $Date, $Cost, $Device)){
										echo 'bind success';
										if($stmt->execute()){
											echo 'execute success';
										}
										else{echo 'Execute failed ('.$stmt->errno.')'.$stmt->error;}
									}
									else{echo 'bind failure';}	
								}
								else{
									echo 'prepare error';
								}
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
			echo 'before update cost';
			// prepare and bind
			$stmt = $conn->prepare("UPDATE performance SET Cost=? WHERE ID=?");
			$stmt->bind_param("di", $Cost, $ID);
			echo ' after prepare';
			
			$stmt->execute();
			echo 'after execute';
			echo "Stmt: $ID, $BrandID, $ProductID, $NetworkID, $Date, $Cost, $Revenue, $Leads, $Device";
			$stmt->close();
			$conn->close();
			echo 'finished';
		}
	}
	else if($method == 'revenue'){
		if($ID == ""){
			echo 'before insert revenue';

			if($checkDupe = $conn->prepare("SELECT * FROM performance WHERE BrandID = ? AND ProductID = ? AND NetworkID = ? AND Date = ? AND Device = ?")){
				echo 'prepare checkDupe success';
				if($checkDupe->bind_param("iiiss", $BrandID, $ProductID, $NetworkID, $Date, $Device)){
					echo 'bind checkDupe success';
					if($checkDupe->execute()){
						echo 'execute checkDupe success';
						if($resultDupe = $checkDupe->get_result()){
							if ($resultDupe->num_rows > 0){
								echo 'Duplicate Performance';
							}
							else {
								// prepare and bind
								$stmt = $conn->prepare("INSERT INTO performance (ProductID, NetworkID, BrandID, Date, Revenue, Device) VALUES (?, ?, ?, STR_TO_DATE(?, '%Y-%m-%d'), ?, ?)");
								$stmt->bind_param("iiisds", $ProductID, $NetworkID, $BrandID, $Date, $Revenue, $Device);
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
			echo 'before update revenue';
			// prepare and bind
			$stmt = $conn->prepare("UPDATE performance SET Revenue=? WHERE ID=?");
			$stmt->bind_param("di", $Revenue, $ID);
			echo ' after prepare';
			
			$stmt->execute();
			echo 'after execute';
			echo "Stmt: $ID, $BrandID, $ProductID, $NetworkID, $Date, $Revenue, $Device";
			$stmt->close();
			$conn->close();
			echo 'finished';
		}
	}
	else if($method == 'leads'){
		if($ID == ""){
			echo 'before insert leads';

			if($checkDupe = $conn->prepare("SELECT * FROM performance WHERE BrandID = ? AND ProductID = ? AND NetworkID = ? AND Date = ? AND Device = ?")){
				echo 'prepare checkDupe success';
				if($checkDupe->bind_param("iiiss", $BrandID, $ProductID, $NetworkID, $Date, $Device)){
					echo 'bind checkDupe success';
					if($checkDupe->execute()){
						echo 'execute checkDupe success';
						if($resultDupe = $checkDupe->get_result()){
							if ($resultDupe->num_rows > 0){
								echo 'Duplicate Performance';
							}
							else {
								// prepare and bind
								$stmt = $conn->prepare("INSERT INTO performance (ProductID, NetworkID, BrandID, Date, Leads, Device) VALUES (?, ?, ?, STR_TO_DATE(?, '%Y-%m-%d'), ?, ?)");
								$stmt->bind_param("iiisis", $ProductID, $NetworkID, $BrandID, $Date, $Leads, $Device);
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
			echo 'before update leads';
			// prepare and bind
			$stmt = $conn->prepare("UPDATE performance SET Leads=? WHERE ID=?");
			$stmt->bind_param("ii", $Leads, $ID);
			echo ' after prepare';
			
			$stmt->execute();
			echo 'after execute';
			echo "Stmt: $ID, $BrandID, $ProductID, $NetworkID, $Date, $Cost, $Revenue, $Leads, $Device";
			$stmt->close();
			$conn->close();
			echo 'finished';
		}
	};
	// if($ID == ""){
	// 	echo 'before prepare';
	// 	// prepare and bind
	// 	$stmt = $conn->prepare("INSERT INTO performance (ProductID, NetworkID, BrandID, Date, Cost, Revenue, Leads, Device) VALUES (?, ?, ?, STR_TO_DATE(?, '%Y-%m-%d'), ?, ?, ?, ?)");
	// 	$stmt->bind_param("iiisddis", $ProductID, $NetworkID, $BrandID, $Date, $Cost, $Revenue, $Leads, $Device);
	// 	echo ' after prepare';
		
	// 	$stmt->execute();
	// 	echo 'after execute';
	// 	$stmt->close();
	// 	$conn->close();
	// 	echo 'finished';
	// }
	// else {


	// 	echo 'before prepare';
	// 	// prepare and bind
	// 	$stmt = $conn->prepare("UPDATE performance SET BrandID=?, ProductID=?, NetworkID=?, Date=STR_TO_DATE(?, '%Y-%m-%d'), Cost=?, Revenue=?, Leads=?, Device=? WHERE ID=$ID");
	// 	$stmt->bind_param("iiisddis", $BrandID, $ProductID, $NetworkID, $Date, $Cost, $Revenue, $Leads, $Device);
	// 	echo ' after prepare';
		
	// 	$stmt->execute();
	// 	echo 'after execute';
	// 	echo "Stmt: $ID, $BrandID, $ProductID, $NetworkID, $Date, $Cost, $Revenue, $Leads, $Device";
	// 	$stmt->close();
	// 	$conn->close();
	// 	echo 'finished';
	// }
?>