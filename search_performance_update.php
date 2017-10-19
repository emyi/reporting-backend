<?php
	include 'dbconfig.php';//make the cofig file include
	global $details;//make the connection vars global
	$productIds = empty($_GET['product']) ? "" : $_GET['product'];
	$networkIds = empty($_GET['network']) ? "" : $_GET['network'];
	$device = empty($_GET['device']) ? "" : $_GET['device'];
	$data = json_decode(file_get_contents("php://input"));
	$from = substr($data->from, 0, 10);
	$to = substr($data->to, 0, 10);


	// // check parameter for product and network
	// if($productIds != "" && $networkIds != ""){
	$conn = new mysqli($details['server_host'], $details['mysql_name'], $details['mysql_password'], $details['mysql_database']);	
	$result = $conn->query(
		"SELECT performance.*, product.ProductName, network.NetworkName
		FROM performance
		LEFT JOIN product
		ON performance.ProductID = product.ID
		LEFT JOIN network
		ON performance.NetworkID = network.ID
		WHERE performance.Date >= '$from' AND performance.Date <= '$to' AND ProductID IN ($productIds) AND NetworkID IN ($networkIds) AND Device = '$device'
		ORDER BY performance.Date ASC"
	);
	$data=array();
	while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
		$row=array();
		$row['ID']=addslashes($rs["ID"]);
		$row['ProductID']=addslashes($rs["ProductID"]);
		$row['ProductName']=addslashes($rs["ProductName"]);
		$row['NetworkID']=addslashes($rs["NetworkID"]);
		$row['BrandID']=addslashes($rs["BrandID"]);
		$row['NetworkName']=addslashes($rs["NetworkName"]);
		$row['Date']=addslashes($rs["Date"]);
		$row['Cost']=addslashes($rs["Cost"]);
		$row['Revenue']=addslashes($rs["Revenue"]);
		$row['Leads']=addslashes($rs["Leads"]);
		$row['Device']=addslashes($rs["Device"]);
		$data[]=$row;
	}
	$jsonData=array();
	$jsonData['records']=$data;

	$conn->close();
	echo json_encode($jsonData);
	// }
	// // check parameter for product
	// if($productIds != "" && $networkIds == ""){
	// 	$conn = new mysqli($details['server_host'], $details['mysql_name'], $details['mysql_password'], $details['mysql_database']);	
	// 	$result = $conn->query(
	// 		"SELECT performance.*, product.ProductName, network.NetworkName
	// 		FROM performance
	// 		LEFT JOIN product
	// 		ON performance.ProductID = product.ID
	// 		LEFT JOIN network
	// 		ON performance.NetworkID = network.ID
	// 		WHERE performance.Date >= '$from' AND performance.Date <= '$to' AND ProductID IN ($productIds)
	// 		ORDER BY performance.Date ASC"
	// 	);
	// 	$data=array();
	// 	while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
	// 		$row=array();
	// 		$row['ID']=addslashes($rs["ID"]);
	// 		$row['ProductID']=addslashes($rs["ProductID"]);
	// 		$row['ProductName']=addslashes($rs["ProductName"]);
	// 		$row['NetworkID']=addslashes($rs["NetworkID"]);
	// 		$row['BrandID']=addslashes($rs["BrandID"]);
	// 		$row['NetworkName']=addslashes($rs["NetworkName"]);
	// 		$row['Date']=addslashes($rs["Date"]);
	// 		$row['Cost']=addslashes($rs["Cost"]);
	// 		$row['Revenue']=addslashes($rs["Revenue"]);
	// 		$row['Leads']=addslashes($rs["Leads"]);
	// 		$row['Device']=addslashes($rs["Device"]);
	// 		$data[]=$row;
	// 	}
	// 	$jsonData=array();
	// 	$jsonData['records']=$data;

	// 	$conn->close();
	// 	echo json_encode($jsonData);
	// }
	// // check parameter for network
	// if($productIds == "" && $networkIds != ""){
	// 	$conn = new mysqli($details['server_host'], $details['mysql_name'], $details['mysql_password'], $details['mysql_database']);	
	// 	$result = $conn->query(
	// 		"SELECT performance.*, product.ProductName, network.NetworkName
	// 		FROM performance
	// 		LEFT JOIN product
	// 		ON performance.ProductID = product.ID
	// 		LEFT JOIN network
	// 		ON performance.NetworkID = network.ID
	// 		WHERE performance.Date >= '$from' AND performance.Date <= '$to' AND NetworkID IN ($networkIds)
	// 		ORDER BY performance.Date ASC"
	// 	);
	// 	$data=array();
	// 	while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
	// 		$row=array();
	// 		$row['ID']=addslashes($rs["ID"]);
	// 		$row['ProductID']=addslashes($rs["ProductID"]);
	// 		$row['ProductName']=addslashes($rs["ProductName"]);
	// 		$row['NetworkID']=addslashes($rs["NetworkID"]);
	// 		$row['BrandID']=addslashes($rs["BrandID"]);
	// 		$row['NetworkName']=addslashes($rs["NetworkName"]);
	// 		$row['Date']=addslashes($rs["Date"]);
	// 		$row['Cost']=addslashes($rs["Cost"]);
	// 		$row['Revenue']=addslashes($rs["Revenue"]);
	// 		$row['Leads']=addslashes($rs["Leads"]);
	// 		$row['Device']=addslashes($rs["Device"]);
	// 		$data[]=$row;
	// 	}
	// 	$jsonData=array();
	// 	$jsonData['records']=$data;

	// 	$conn->close();
	// 	echo json_encode($jsonData);
	// }
	// // products and networks null
	// if($productIds == "" && $networkIds == "") {
	// 	$conn = new mysqli($details['server_host'], $details['mysql_name'], $details['mysql_password'], $details['mysql_database']);	
	// 		$result = $conn->query(
	// 			"SELECT performance.*, product.ProductName, network.NetworkName
	// 			FROM performance
	// 			LEFT JOIN product
	// 			ON performance.ProductID = product.ID
	// 			LEFT JOIN network
	// 			ON performance.NetworkID = network.ID
	// 			WHERE performance.Date >= '$from' AND performance.Date <= '$to'
	// 			ORDER BY performance.Date ASC"
	// 		);
	// 		$data=array();
	// 		while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
	// 			$row=array();
	// 			$row['ID']=addslashes($rs["ID"]);
	// 			$row['ProductID']=addslashes($rs["ProductID"]);
	// 			$row['ProductName']=addslashes($rs["ProductName"]);
	// 			$row['NetworkID']=addslashes($rs["NetworkID"]);
	// 			$row['BrandID']=addslashes($rs["BrandID"]);
	// 			$row['NetworkName']=addslashes($rs["NetworkName"]);
	// 			$row['Date']=addslashes($rs["Date"]);
	// 			$row['Cost']=addslashes($rs["Cost"]);
	// 			$row['Revenue']=addslashes($rs["Revenue"]);
	// 			$row['Leads']=addslashes($rs["Leads"]);
	// 			$row['Device']=addslashes($rs["Device"]);
	// 			$data[]=$row;
	// 		}
	// 		$jsonData=array();
	// 		$jsonData['records']=$data;

	// 		$conn->close();
	// 		echo json_encode($jsonData);
	// }
?>