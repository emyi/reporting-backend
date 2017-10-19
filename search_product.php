<?php
	include 'dbconfig.php';//make the cofig file include
	global $details;//make the connection vars global
	$productIds = empty($_GET['product']) ? "" : $_GET['product'];

	// if none blank
	if($productIds != ''){
		$conn = new mysqli($details['server_host'], $details['mysql_name'], $details['mysql_password'], $details['mysql_database']);	
		$result = $conn->query(
			"SELECT *
			FROM product
			WHERE ID IN ($productIds)"
		);
		$data=array();
		while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
			$row=array();
			$row['ID']=addslashes($rs["ID"]);
			$row['ProductName']=addslashes($rs["ProductName"]);
			$data[]=$row;
		}
		$jsonData=array();
		$jsonData['records']=$data;

		$conn->close();

		// echo count($data);
		echo json_encode($jsonData);
	}
?>