
<?php
	include 'dbconfig.php';//make the cofig file include
	global $details;//make the connection vars global
	$method = empty($_GET['method']) ? "" : $_GET['method'];
	$brandID = empty($_GET['brandID']) ? "" : $_GET['brandID'];

	if($method == "all_performance"){
		$conn = new mysqli($details['server_host'], $details['mysql_name'], $details['mysql_password'], $details['mysql_database']);	
		$result = $conn->query(
			"SELECT performance.*, product.ProductName, network.NetworkName, brand.BrandName
				FROM performance
				LEFT JOIN product
				ON performance.ProductID = product.ID
				LEFT JOIN network
				ON performance.NetworkID = network.ID
				LEFT JOIN brand
				ON performance.BrandID = brand.ID
			ORDER BY performance.BrandID ASC"
		);
		$data=array();
		while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
			$row=array();
			$row['ID']=addslashes($rs["ID"]);
			$row['ProductID']=addslashes($rs["ProductID"]);
			$row['ProductName']=addslashes($rs["ProductName"]);
			$row['NetworkID']=addslashes($rs["NetworkID"]);
			$row['BrandID']=addslashes($rs["BrandID"]);
			$row['BrandName']=addslashes($rs["BrandName"]);
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
	}


	if($method == "all_network"){
		$conn = new mysqli($details['server_host'], $details['mysql_name'],$details['mysql_password'], $details['mysql_database']);	
		$result = $conn->query("SELECT * FROM network");
		$data=array();
		while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
			$row=array();
			$row['ID']=addslashes($rs["ID"]);
			$row['Name']=addslashes($rs["NetworkName"]);
			$data[]=$row;
		}
		$jsonData=array();
		$jsonData['records']=$data;

		$conn->close();
		echo json_encode($jsonData);
	}
	if($method == "all_product" && $brandID == ""){
		$conn = new mysqli($details['server_host'], $details['mysql_name'],$details['mysql_password'], $details['mysql_database']);	
		$result = $conn->query("SELECT * FROM product");
		$data=array();
		while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
			$row=array();
			$row['ID']=addslashes($rs["ID"]);
			$row['BID']=addslashes($rs["BID"]);
			$row['Name']=addslashes($rs["ProductName"]);
			$data[]=$row;
		}
		$jsonData=array();
		$jsonData['records']=$data;

		$conn->close();
		echo json_encode($jsonData);

	}
	if($method == "all_product" && $brandID != ""){
			$conn = new mysqli($details['server_host'], $details['mysql_name'],$details['mysql_password'], $details['mysql_database']);	
			$result = $conn->query("SELECT * FROM product WHERE BID IN ($brandID)");
			$data=array();
			while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
				$row=array();
				$row['ID']=addslashes($rs["ID"]);
				$row['BID']=addslashes($rs["BID"]);
				$row['Name']=addslashes($rs["ProductName"]);
				$data[]=$row;
			}
			$jsonData=array();
			$jsonData['records']=$data;

			$conn->close();
			echo json_encode($jsonData);
		}
	if($method == "all_brand"){
		$conn = new mysqli($details['server_host'], $details['mysql_name'],$details['mysql_password'], $details['mysql_database']);	
		$result = $conn->query("SELECT * FROM brand");
		$data=array();
		while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
			$row=array();
			$row['ID']=addslashes($rs["ID"]);
			$row['BrandName']=addslashes($rs["BrandName"]);
			$data[]=$row;
		}
		$jsonData=array();
		$jsonData['records']=$data;

		$conn->close();
		echo json_encode($jsonData);
	}
?>