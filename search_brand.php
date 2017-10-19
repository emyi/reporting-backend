<?php
	include 'dbconfig.php';//make the cofig file include
	global $details;//make the connection vars global
	$brandIds = empty($_GET['brand']) ? "" : $_GET['brand'];

	// if none blank
	if($brandIds != ''){
		$conn = new mysqli($details['server_host'], $details['mysql_name'], $details['mysql_password'], $details['mysql_database']);	
		// $result = $conn->query("SELECT * FROM brand WHERE ID IN ($brandIds)");
		$res = $conn->prepare("SELECT BrandName FROM brand WHERE ID = ?");
		$res->bind_param( "i", $brandIds);
		$res->execute();
		$result = $res->get_result();
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

		// echo count($data);
		echo json_encode($jsonData);
	}
?>