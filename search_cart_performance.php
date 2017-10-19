<?php
	include 'dbconfig.php';//make the cofig file include
	global $details;//make the connection vars global
	$brandIds = empty($_GET['brand']) ? "" : $_GET['brand'];

	$data = json_decode(file_get_contents("php://input"));
	$from = substr($data->from, 0, 10);
	$to = substr($data->to, 0, 10);

	// echo $data;
	// echo 'start from:'.$from.'end from';
	// echo 'start to:'.$to.'end to';
	// if none blank
	if($brandIds != ''){
		$conn = new mysqli($details['server_host'], $details['mysql_name'], $details['mysql_password'], $details['mysql_database']);	
		$result = $conn->query("SELECT cart.*, brand.BrandName FROM cart LEFT JOIN brand ON cart.BrandID = brand.ID WHERE cart.Date >= '$from' AND cart.Date <= '$to' AND BrandID IN ($brandIds) ORDER BY cart.Date ASC");
		// $res = $conn->prepare("SELECT cart.*, brand.BrandName FROM cart LEFT JOIN brand ON cart.BrandID = brand.ID WHERE cart.Date >= ? AND cart.Date <= ? AND BrandID IN (?) ORDER BY cart.Date ASC");
		// $res->bind_param( "ssi", $from, $to, $brandIds);
		// $res->execute();
		// $result = $res->get_result();
		$data=array();
		while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
			$row=array();
			$row['ID']=addslashes($rs["ID"]);
			$row['BrandID']=addslashes($rs["BrandID"]);
			$row['BrandName']=addslashes($rs["BrandName"]);
			$row['Date']=addslashes($rs["Date"]);
			$row['CRevenue']=addslashes($rs["CRevenue"]);
			$data[]=$row;
		}
		$jsonData=array();
		$jsonData['records']=$data;

		$conn->close();

		// echo count($data);
		echo json_encode($jsonData);
	}
	

	// if nothing selected, return everything
	if($brandIds == '') {
		$conn = new mysqli($details['server_host'], $details['mysql_name'], $details['mysql_password'], $details['mysql_database']);	
			// $result = $conn->query("SELECT cart.*, brand.BrandName FROM cart LEFT JOIN brand ON cart.BrandID = brand.ID WHERE cart.Date >= '$from' AND cart.Date <= '$to' ORDER BY cart.Date ASC");
			$res = $conn->prepare("SELECT cart.*, brand.BrandName FROM cart LEFT JOIN brand ON cart.BrandID = brand.ID WHERE cart.Date >= ?	 AND cart.Date <= ? ORDER BY cart.Date ASC");
			$res->bind_param( "ss", $from, $to);
			$res->execute();
			$result = $res->get_result();
			$data=array();
			while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
				$row=array();
				$row['ID']=addslashes($rs["ID"]);
				$row['BrandID']=addslashes($rs["BrandID"]);
				$row['BrandName']=addslashes($rs["BrandName"]);
				$row['Date']=addslashes($rs["Date"]);
				$row['CRevenue']=addslashes($rs["CRevenue"]);
				$data[]=$row;
			}
			$jsonData=array();
			$jsonData['records']=$data;

			$conn->close();
			echo json_encode($jsonData);
	}
?>