<?php
	include 'dbconfig.php';//make the cofig file include
	global $details;//make the connection vars global
	$networkIds = empty($_GET['network']) ? "" : $_GET['network'];

	// if none blank
	if($networkIds != ''){
		$conn = new mysqli($details['server_host'], $details['mysql_name'], $details['mysql_password'], $details['mysql_database']);	
		// $result = $conn->query("SELECT * FROM network WHERE ID IN ($networkIds)");
		$res = $conn->prepare("SELECT NetworkName FROM network WHERE ID = ?");
		$res->bind_param( "i", $networkIds);
		$res->execute();
		$result = $res->get_result();
		$data=array();
		while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
			$row=array();
			$row['ID']=addslashes($rs["ID"]);
			$row['NetworkName']=addslashes($rs["NetworkName"]);
			$data[]=$row;
		}
		$jsonData=array();
		$jsonData['records']=$data;

		$conn->close();

		// echo count($data);
		echo json_encode($jsonData);
	}
?>