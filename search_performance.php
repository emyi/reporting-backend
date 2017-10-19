<?php
	include 'dbconfig.php';//make the cofig file include
	global $details;//make the connection vars global
	$conn = new mysqli($details['server_host'], $details['mysql_name'], $details['mysql_password'], $details['mysql_database']);
	$brandIds = empty($_GET['brand']) ? "" : $_GET['brand'];
	$productIds = empty($_GET['product']) ? "" : $_GET['product'];
	$networkIds = empty($_GET['network']) ? "" : $_GET['network'];
	$devices = empty($_GET['device']) ? "" : $_GET['device'];
	$devices1 = explode(",", $devices);
	$devices2 = "'" . implode ( "','", $devices1 ) . "'";

	$data = json_decode(file_get_contents("php://input"));
	$from = substr($data->from, 0, 10);
	$to = substr($data->to, 0, 10);

	// if none blank
	if($productIds != '' && $networkIds != '' && $devices != '' && $brandIds != ''){
			
		$result = $conn->query("SELECT performance.ID, performance.ProductID, performance.NetworkID, performance.BrandID, performance.Date, performance.Cost, performance.Revenue, performance.Leads, performance.Device, product.ProductName, network.NetworkName, brand.BrandName FROM performance LEFT JOIN product ON performance.ProductID = product.ID LEFT JOIN network ON performance.NetworkID = network.ID LEFT JOIN brand ON performance.BrandID = brand.ID WHERE performance.Date >= '$from' AND performance.Date <= '$to' AND ProductID IN ($productIds) AND NetworkID IN ($networkIds) AND Device IN ($devices2) AND BrandID IN ($brandIds) ORDER BY performance.Date ASC");
		// $res = $conn->prepare("SELECT performance.ID, performance.ProductID, performance.NetworkID, performance.BrandID, performance.Date, performance.Cost, performance.Revenue, performance.Leads, performance.Device, product.ProductName, network.NetworkName, brand.BrandName FROM performance LEFT JOIN product ON performance.ProductID = product.ID LEFT JOIN network ON performance.NetworkID = network.ID LEFT JOIN brand ON performance.BrandID = brand.ID WHERE performance.Date >= ? AND performance.Date <= ? AND ProductID IN (?) AND NetworkID IN (?) AND Device IN (?) AND BrandID IN (?) ORDER BY performance.Date ASC");
		// $res->bind_param("ssiisi", $from, $to, $productIds, $networkIds, $devices2, $brandIds);
		// $res->execute();
		// $result = $res->get_result();
		$data=array();
		while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
			$row=array();
			$row['ID']=addslashes($rs["ID"]);
			$row['ProductID']=addslashes($rs["ProductID"]);
			$row['ProductName']=addslashes($rs["ProductName"]);
			$row['NetworkID']=addslashes($rs["NetworkID"]);
			$row['NetworkName']=addslashes($rs["NetworkName"]);
			$row['BrandID']=addslashes($rs["BrandID"]);
			$row['BrandName']=addslashes($rs["BrandName"]);
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

		// echo count($data);
		echo json_encode($jsonData);
	}
	
	
	// if product and brand selected
	if($productIds != '' && $networkIds == '' && $devices == '' && $brandIds != ''){
			
		$result = $conn->query("SELECT performance.ID, performance.ProductID, performance.NetworkID, performance.BrandID, performance.Date, performance.Cost, performance.Revenue, performance.Leads, performance.Device, product.ProductName, network.NetworkName, brand.BrandName FROM performance LEFT JOIN product ON performance.ProductID = product.ID LEFT JOIN network ON performance.NetworkID = network.ID LEFT JOIN brand ON performance.BrandID = brand.ID WHERE performance.Date >= '$from' AND performance.Date <= '$to' AND ProductID IN ($productIds) AND BrandID IN ($brandIds) ORDER BY performance.Date ASC");
		// $res = $conn->prepare("SELECT performance.ID, performance.ProductID, performance.NetworkID, performance.BrandID, performance.Date, performance.Cost, performance.Revenue, performance.Leads, performance.Device, product.ProductName, network.NetworkName, brand.BrandName FROM performance LEFT JOIN product ON performance.ProductID = product.ID LEFT JOIN network ON performance.NetworkID = network.ID LEFT JOIN brand ON performance.BrandID = brand.ID WHERE performance.Date >= ? AND performance.Date <= ? AND ProductID IN (?) AND BrandID IN (?) ORDER BY performance.Date ASC");
		// $res->bind_param("ssii", $from, $to, $productIds, $brandIds);
		// $res->execute();
		// $result = $res->get_result();
		$data=array();
		while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
			$row=array();
			$row['ID']=addslashes($rs["ID"]);
			$row['ProductID']=addslashes($rs["ProductID"]);
			$row['ProductName']=addslashes($rs["ProductName"]);
			$row['NetworkID']=addslashes($rs["NetworkID"]);
			$row['NetworkName']=addslashes($rs["NetworkName"]);
			$row['BrandID']=addslashes($rs["BrandID"]);
			$row['BrandName']=addslashes($rs["BrandName"]);
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
	// if brand and network selected
	if($productIds == '' && $networkIds != '' && $devices == '' && $brandIds != ''){
			
		$result = $conn->query("SELECT performance.ID, performance.ProductID, performance.NetworkID, performance.BrandID, performance.Date, performance.Cost, performance.Revenue, performance.Leads, performance.Device, product.ProductName, network.NetworkName, brand.BrandName FROM performance LEFT JOIN product ON performance.ProductID = product.ID LEFT JOIN network ON performance.NetworkID = network.ID LEFT JOIN brand ON performance.BrandID = brand.ID WHERE performance.Date >= '$from' AND performance.Date <= '$to' AND BrandID IN ($brandIds) AND NetworkID IN ($networkIds) ORDER BY performance.Date ASC");
		// $res = $conn->prepare("SELECT performance.ID, performance.ProductID, performance.NetworkID, performance.BrandID, performance.Date, performance.Cost, performance.Revenue, performance.Leads, performance.Device, product.ProductName, network.NetworkName, brand.BrandName FROM performance LEFT JOIN product ON performance.ProductID = product.ID LEFT JOIN network ON performance.NetworkID = network.ID LEFT JOIN brand ON performance.BrandID = brand.ID WHERE performance.Date >= ? AND performance.Date <= ? AND BrandID IN (?) AND NetworkID IN (?) ORDER BY performance.Date ASC");
		// $res->bind_param( "ssii", $from, $to, $brandIds, $networkIds);
		// $res->execute();
		// $result = $res->get_result();
		$data=array();
		while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
			$row=array();
			$row['ID']=addslashes($rs["ID"]);
			$row['ProductID']=addslashes($rs["ProductID"]);
			$row['ProductName']=addslashes($rs["ProductName"]);
			$row['NetworkID']=addslashes($rs["NetworkID"]);
			$row['NetworkName']=addslashes($rs["NetworkName"]);
			$row['BrandID']=addslashes($rs["BrandID"]);
			$row['BrandName']=addslashes($rs["BrandName"]);
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
	// if brand and device selected
	if($productIds == '' && $networkIds == '' && $devices != '' && $brandIds != ''){
			
		$result = $conn->query("SELECT performance.ID, performance.ProductID, performance.NetworkID, performance.BrandID, performance.Date, performance.Cost, performance.Revenue, performance.Leads, performance.Device, product.ProductName, network.NetworkName, brand.BrandName FROM performance LEFT JOIN product ON performance.ProductID = product.ID LEFT JOIN network ON performance.NetworkID = network.ID LEFT JOIN brand ON performance.BrandID = brand.ID WHERE performance.Date >= '$from' AND performance.Date <= '$to' AND BrandID IN ($brandIds) AND Device IN ($devices2) ORDER BY performance.Date ASC");
		// $res = $conn->prepare("SELECT performance.ID, performance.ProductID, performance.NetworkID, performance.BrandID, performance.Date, performance.Cost, performance.Revenue, performance.Leads, performance.Device, product.ProductName, network.NetworkName, brand.BrandName FROM performance LEFT JOIN product ON performance.ProductID = product.ID LEFT JOIN network ON performance.NetworkID = network.ID LEFT JOIN brand ON performance.BrandID = brand.ID WHERE performance.Date >= ? AND performance.Date <= ? AND BrandID IN (?) AND Device IN (?) ORDER BY performance.Date ASC");
		// $res->bind_param( "ssis", $from, $to, $brandIds, $devices2);
		// $res->execute();
		// $result = $res->get_result();
		$data=array();
		while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
			$row=array();
			$row['ID']=addslashes($rs["ID"]);
			$row['ProductID']=addslashes($rs["ProductID"]);
			$row['ProductName']=addslashes($rs["ProductName"]);
			$row['NetworkID']=addslashes($rs["NetworkID"]);
			$row['NetworkName']=addslashes($rs["NetworkName"]);
			$row['BrandID']=addslashes($rs["BrandID"]);
			$row['BrandName']=addslashes($rs["BrandName"]);
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

	// if product and network selected
	if($productIds != '' && $networkIds != '' && $devices == '' && $brandIds == ''){
			
		$result = $conn->query("SELECT performance.ID, performance.ProductID, performance.NetworkID, performance.BrandID, performance.Date, performance.Cost, performance.Revenue, performance.Leads, performance.Device, product.ProductName, network.NetworkName, brand.BrandName FROM performance LEFT JOIN product ON performance.ProductID = product.ID LEFT JOIN network ON performance.NetworkID = network.ID LEFT JOIN brand ON performance.BrandID = brand.ID WHERE performance.Date >= '$from' AND performance.Date <= '$to' AND ProductID IN ($productIds) AND NetworkID IN ($networkIds) ORDER BY performance.Date ASC");
		// $res = $conn->prepare("SELECT performance.ID, performance.ProductID, performance.NetworkID, performance.BrandID, performance.Date, performance.Cost, performance.Revenue, performance.Leads, performance.Device, product.ProductName, network.NetworkName, brand.BrandName FROM performance LEFT JOIN product ON performance.ProductID = product.ID LEFT JOIN network ON performance.NetworkID = network.ID LEFT JOIN brand ON performance.BrandID = brand.ID WHERE performance.Date >= ? AND performance.Date <= ? AND ProductID IN (?) AND NetworkID IN (?) ORDER BY performance.Date ASC");
		// $res->bind_param( "ssii", $from, $to, $productIds, $networkIds);
		// $res->execute();
		// $result = $res->get_result();
		$data=array();
		while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
			$row=array();
			$row['ID']=addslashes($rs["ID"]);
			$row['ProductID']=addslashes($rs["ProductID"]);
			$row['ProductName']=addslashes($rs["ProductName"]);
			$row['NetworkID']=addslashes($rs["NetworkID"]);
			$row['NetworkName']=addslashes($rs["NetworkName"]);
			$row['BrandID']=addslashes($rs["BrandID"]);
			$row['BrandName']=addslashes($rs["BrandName"]);
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
	
	
	// if product and device selected
	if($productIds != '' && $networkIds == '' && $devices != '' && $brandIds == ''){
			
		$result = $conn->query("SELECT performance.ID, performance.ProductID, performance.NetworkID, performance.BrandID, performance.Date, performance.Cost, performance.Revenue, performance.Leads, performance.Device, product.ProductName, network.NetworkName, brand.BrandName FROM performance LEFT JOIN product ON performance.ProductID = product.ID LEFT JOIN network ON performance.NetworkID = network.ID LEFT JOIN brand ON performance.BrandID = brand.ID WHERE performance.Date >= '$from' AND performance.Date <= '$to' AND ProductID IN ($productIds) AND Device IN ($devices2) ORDER BY performance.Date ASC");
		// $res = $conn->prepare("SELECT performance.ID, performance.ProductID, performance.NetworkID, performance.BrandID, performance.Date, performance.Cost, performance.Revenue, performance.Leads, performance.Device, product.ProductName, network.NetworkName, brand.BrandName FROM performance LEFT JOIN product ON performance.ProductID = product.ID LEFT JOIN network ON performance.NetworkID = network.ID LEFT JOIN brand ON performance.BrandID = brand.ID WHERE performance.Date >= ? AND performance.Date <= ? AND ProductID IN (?) AND Device IN (?) ORDER BY performance.Date ASC");
		// $res->bind_param( "ssis", $from, $to, $productIds, $devices2);
		// $res->execute();
		// $result = $res->get_result();
		$data=array();
		while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
			$row=array();
			$row['ID']=addslashes($rs["ID"]);
			$row['ProductID']=addslashes($rs["ProductID"]);
			$row['ProductName']=addslashes($rs["ProductName"]);
			$row['NetworkID']=addslashes($rs["NetworkID"]);
			$row['NetworkName']=addslashes($rs["NetworkName"]);
			$row['BrandID']=addslashes($rs["BrandID"]);
			$row['BrandName']=addslashes($rs["BrandName"]);
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
	// if device and network selected
	if($productIds == '' && $networkIds != '' && $devices != '' && $brandIds == ''){
			
		$result = $conn->query("SELECT performance.ID, performance.ProductID, performance.NetworkID, performance.BrandID, performance.Date, performance.Cost, performance.Revenue, performance.Leads, performance.Device, product.ProductName, network.NetworkName, brand.BrandName FROM performance LEFT JOIN product ON performance.ProductID = product.ID LEFT JOIN network ON performance.NetworkID = network.ID LEFT JOIN brand ON performance.BrandID = brand.ID WHERE performance.Date >= '$from' AND performance.Date <= '$to' AND Device IN ($devices2) AND NetworkID IN ($networkIds) ORDER BY performance.Date ASC");
		// $res = $conn->prepare("SELECT performance.ID, performance.ProductID, performance.NetworkID, performance.BrandID, performance.Date, performance.Cost, performance.Revenue, performance.Leads, performance.Device, product.ProductName, network.NetworkName, brand.BrandName FROM performance LEFT JOIN product ON performance.ProductID = product.ID LEFT JOIN network ON performance.NetworkID = network.ID LEFT JOIN brand ON performance.BrandID = brand.ID WHERE performance.Date >= ? AND performance.Date <= ? AND Device IN (?) AND NetworkID IN (?) ORDER BY performance.Date ASC");
		// $res->bind_param( "sssi", $from, $to, $devices2, $networkIds);
		// $res->execute();
		// $result = $res->get_result();
		$data=array();
		while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
			$row=array();
			$row['ID']=addslashes($rs["ID"]);
			$row['ProductID']=addslashes($rs["ProductID"]);
			$row['ProductName']=addslashes($rs["ProductName"]);
			$row['NetworkID']=addslashes($rs["NetworkID"]);
			$row['NetworkName']=addslashes($rs["NetworkName"]);
			$row['BrandID']=addslashes($rs["BrandID"]);
			$row['BrandName']=addslashes($rs["BrandName"]);
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
	// if all selected except product
	if($productIds == '' && $networkIds != '' && $devices != '' && $brandIds != ''){
			
		$result = $conn->query("SELECT performance.ID, performance.ProductID, performance.NetworkID, performance.BrandID, performance.Date, performance.Cost, performance.Revenue, performance.Leads, performance.Device, product.ProductName, network.NetworkName, brand.BrandName FROM performance LEFT JOIN product ON performance.ProductID = product.ID LEFT JOIN network ON performance.NetworkID = network.ID LEFT JOIN brand ON performance.BrandID = brand.ID WHERE performance.Date >= '$from' AND performance.Date <= '$to' AND NetworkID IN ($networkIds) AND Device IN ($devices2) AND BrandID IN ($brandIds) ORDER BY performance.Date ASC");
		// $res = $conn->prepare("SELECT performance.ID, performance.ProductID, performance.NetworkID, performance.BrandID, performance.Date, performance.Cost, performance.Revenue, performance.Leads, performance.Device, product.ProductName, network.NetworkName, brand.BrandName FROM performance LEFT JOIN product ON performance.ProductID = product.ID LEFT JOIN network ON performance.NetworkID = network.ID LEFT JOIN brand ON performance.BrandID = brand.ID WHERE performance.Date >= ? AND performance.Date <= ? AND NetworkID IN (?) AND Device IN (?) AND BrandID IN (?) ORDER BY performance.Date ASC");
		// $res->bind_param( "ssisi", $from, $to, $networkIds, $devices2, $brandIds);
		// $res->execute();
		// $result = $res->get_result();
		$data=array();
		while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
			$row=array();
			$row['ID']=addslashes($rs["ID"]);
			$row['ProductID']=addslashes($rs["ProductID"]);
			$row['ProductName']=addslashes($rs["ProductName"]);
			$row['NetworkID']=addslashes($rs["NetworkID"]);
			$row['NetworkName']=addslashes($rs["NetworkName"]);
			$row['BrandID']=addslashes($rs["BrandID"]);
			$row['BrandName']=addslashes($rs["BrandName"]);
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
	// if all selected except network
	if($productIds != '' && $networkIds == '' && $devices != '' && $brandIds != ''){
			
		$result = $conn->query("SELECT performance.ID, performance.ProductID, performance.NetworkID, performance.BrandID, performance.Date, performance.Cost, performance.Revenue, performance.Leads, performance.Device, product.ProductName, network.NetworkName, brand.BrandName FROM performance LEFT JOIN product ON performance.ProductID = product.ID LEFT JOIN network ON performance.NetworkID = network.ID LEFT JOIN brand ON performance.BrandID = brand.ID WHERE performance.Date >= '$from' AND performance.Date <= '$to' AND Device IN ($devices2) AND ProductID IN ($productIds) AND BrandID IN ($brandIds) ORDER BY performance.Date ASC");
		// $res = $conn->prepare("SELECT performance.ID, performance.ProductID, performance.NetworkID, performance.BrandID, performance.Date, performance.Cost, performance.Revenue, performance.Leads, performance.Device, product.ProductName, network.NetworkName, brand.BrandName FROM performance LEFT JOIN product ON performance.ProductID = product.ID LEFT JOIN network ON performance.NetworkID = network.ID LEFT JOIN brand ON performance.BrandID = brand.ID WHERE performance.Date >= ? AND performance.Date <= ? AND Device IN (?) AND ProductID IN (?) AND BrandID IN (?) ORDER BY performance.Date ASC");
		// $res->bind_param( "sssii", $from, $to, $devices2, $productIds, $brandIds);
		// $res->execute();
		// $result = $res->get_result();
		$data=array();
		while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
			$row=array();
			$row['ID']=addslashes($rs["ID"]);
			$row['ProductID']=addslashes($rs["ProductID"]);
			$row['ProductName']=addslashes($rs["ProductName"]);
			$row['NetworkID']=addslashes($rs["NetworkID"]);
			$row['NetworkName']=addslashes($rs["NetworkName"]);
			$row['BrandID']=addslashes($rs["BrandID"]);
			$row['BrandName']=addslashes($rs["BrandName"]);
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
	// if all selected except device
	if($productIds != '' && $networkIds != '' && $devices == '' && $brandIds != ''){
			
		$result = $conn->query("SELECT performance.ID, performance.ProductID, performance.NetworkID, performance.BrandID, performance.Date, performance.Cost, performance.Revenue, performance.Leads, performance.Device, product.ProductName, network.NetworkName, brand.BrandName FROM performance LEFT JOIN product ON performance.ProductID = product.ID LEFT JOIN network ON performance.NetworkID = network.ID LEFT JOIN brand ON performance.BrandID = brand.ID WHERE performance.Date >= '$from' AND performance.Date <= '$to' AND NetworkID IN ($networkIds) AND ProductID IN ($productIds) AND BrandID IN ($brandIds) ORDER BY performance.Date ASC");
		// $res = $conn->prepare("SELECT performance.ID, performance.ProductID, performance.NetworkID, performance.BrandID, performance.Date, performance.Cost, performance.Revenue, performance.Leads, performance.Device, product.ProductName, network.NetworkName, brand.BrandName FROM performance LEFT JOIN product ON performance.ProductID = product.ID LEFT JOIN network ON performance.NetworkID = network.ID LEFT JOIN brand ON performance.BrandID = brand.ID WHERE performance.Date >= ? AND performance.Date <= ? AND NetworkID IN (?) AND ProductID IN (?) AND BrandID IN (?) ORDER BY performance.Date ASC");
		// $res->bind_param( "ssiii", $from, $to, $networkIds, $productIds, $brandIds);
		// $res->execute();
		// $result = $res->get_result();
		$data=array();
		while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
			$row=array();
			$row['ID']=addslashes($rs["ID"]);
			$row['ProductID']=addslashes($rs["ProductID"]);
			$row['ProductName']=addslashes($rs["ProductName"]);
			$row['NetworkID']=addslashes($rs["NetworkID"]);
			$row['NetworkName']=addslashes($rs["NetworkName"]);
			$row['BrandID']=addslashes($rs["BrandID"]);
			$row['BrandName']=addslashes($rs["BrandName"]);
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
	// if all selected except brand
	if($productIds != '' && $networkIds != '' && $devices != '' && $brandIds == ''){
			
		$result = $conn->query("SELECT performance.ID, performance.ProductID, performance.NetworkID, performance.BrandID, performance.Date, performance.Cost, performance.Revenue, performance.Leads, performance.Device, product.ProductName, network.NetworkName, brand.BrandName FROM performance LEFT JOIN product ON performance.ProductID = product.ID LEFT JOIN network ON performance.NetworkID = network.ID LEFT JOIN brand ON performance.BrandID = brand.ID WHERE performance.Date >= '$from' AND performance.Date <= '$to' AND NetworkID IN ($networkIds) AND ProductID IN ($productIds) AND Device IN ($devices2) ORDER BY performance.Date ASC");
		// $res = $conn->prepare("SELECT performance.ID, performance.ProductID, performance.NetworkID, performance.BrandID, performance.Date, performance.Cost, performance.Revenue, performance.Leads, performance.Device, product.ProductName, network.NetworkName, brand.BrandName FROM performance LEFT JOIN product ON performance.ProductID = product.ID LEFT JOIN network ON performance.NetworkID = network.ID LEFT JOIN brand ON performance.BrandID = brand.ID WHERE performance.Date >= ? AND performance.Date <= ? AND NetworkID IN (?) AND ProductID IN (?) AND Device IN (?) ORDER BY performance.Date ASC");
		// $res->bind_param( "ssiis", $from, $to, $networkIds, $productIds, $devices2);
		// $res->execute();
		// $result = $res->get_result();
		$data=array();
		while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
			$row=array();
			$row['ID']=addslashes($rs["ID"]);
			$row['ProductID']=addslashes($rs["ProductID"]);
			$row['ProductName']=addslashes($rs["ProductName"]);
			$row['NetworkID']=addslashes($rs["NetworkID"]);
			$row['NetworkName']=addslashes($rs["NetworkName"]);
			$row['BrandID']=addslashes($rs["BrandID"]);
			$row['BrandName']=addslashes($rs["BrandName"]);
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
	// if all blank except products
	if($productIds != '' && $networkIds == '' && $devices == '' && $brandIds == ''){
			
		$result = $conn->query("SELECT performance.ID, performance.ProductID, performance.NetworkID, performance.BrandID, performance.Date, performance.Cost, performance.Revenue, performance.Leads, performance.Device, product.ProductName, network.NetworkName, brand.BrandName FROM performance LEFT JOIN product ON performance.ProductID = product.ID LEFT JOIN network ON performance.NetworkID = network.ID LEFT JOIN brand ON performance.BrandID = brand.ID WHERE performance.Date >= '$from' AND performance.Date <= '$to' AND ProductID IN ($productIds) ORDER BY performance.Date ASC");
		// $res = $conn->prepare("SELECT performance.ID, performance.ProductID, performance.NetworkID, performance.BrandID, performance.Date, performance.Cost, performance.Revenue, performance.Leads, performance.Device, product.ProductName, network.NetworkName, brand.BrandName FROM performance LEFT JOIN product ON performance.ProductID = product.ID LEFT JOIN network ON performance.NetworkID = network.ID LEFT JOIN brand ON performance.BrandID = brand.ID WHERE performance.Date >= ? AND performance.Date <= ? AND ProductID IN (?) ORDER BY performance.Date ASC");
		// $res->bind_param( "ssi", $from, $to, $productIds);
		// $res->execute();
		// $result = $res->get_result();
		$data=array();
		while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
			$row=array();
			$row['ID']=addslashes($rs["ID"]);
			$row['ProductID']=addslashes($rs["ProductID"]);
			$row['ProductName']=addslashes($rs["ProductName"]);
			$row['NetworkID']=addslashes($rs["NetworkID"]);
			$row['NetworkName']=addslashes($rs["NetworkName"]);
			$row['BrandID']=addslashes($rs["BrandID"]);
			$row['BrandName']=addslashes($rs["BrandName"]);
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
	// if all blank except networks
	if($productIds == '' && $networkIds != '' && $devices == '' && $brandIds == ''){
			
		$result = $conn->query("SELECT performance.ID, performance.ProductID, performance.NetworkID, performance.BrandID, performance.Date, performance.Cost, performance.Revenue, performance.Leads, performance.Device, product.ProductName, network.NetworkName, brand.BrandName FROM performance LEFT JOIN product ON performance.ProductID = product.ID LEFT JOIN network ON performance.NetworkID = network.ID LEFT JOIN brand ON performance.BrandID = brand.ID WHERE performance.Date >= '$from' AND performance.Date <= '$to' AND NetworkID IN ($networkIds) ORDER BY performance.Date ASC");
		// $res = $conn->prepare("SELECT performance.ID, performance.ProductID, performance.NetworkID, performance.BrandID, performance.Date, performance.Cost, performance.Revenue, performance.Leads, performance.Device, product.ProductName, network.NetworkName, brand.BrandName FROM performance LEFT JOIN product ON performance.ProductID = product.ID LEFT JOIN network ON performance.NetworkID = network.ID LEFT JOIN brand ON performance.BrandID = brand.ID WHERE performance.Date >= ? AND performance.Date <= ? AND NetworkID IN (?) ORDER BY performance.Date ASC");
		// $res->bind_param( "ssi", $from, $to, $networkIds);
		// $res->execute();
		// $result = $res->get_result();
		$data=array();
		while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
			$row=array();
			$row['ID']=addslashes($rs["ID"]);
			$row['ProductID']=addslashes($rs["ProductID"]);
			$row['ProductName']=addslashes($rs["ProductName"]);
			$row['NetworkID']=addslashes($rs["NetworkID"]);
			$row['NetworkName']=addslashes($rs["NetworkName"]);
			$row['BrandID']=addslashes($rs["BrandID"]);
			$row['BrandName']=addslashes($rs["BrandName"]);
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
	// if all blank except devices
	if($productIds == '' && $networkIds == '' && $devices != '' && $brandIds == ''){
			
		$result = $conn->query("SELECT performance.ID, performance.ProductID, performance.NetworkID, performance.BrandID, performance.Date, performance.Cost, performance.Revenue, performance.Leads, performance.Device, product.ProductName, network.NetworkName, brand.BrandName FROM performance LEFT JOIN product ON performance.ProductID = product.ID LEFT JOIN network ON performance.NetworkID = network.ID LEFT JOIN brand ON performance.BrandID = brand.ID WHERE performance.Date >= '$from' AND performance.Date <= '$to' AND Device IN ($devices2) ORDER BY performance.Date ASC");
		// $res = $conn->prepare("SELECT performance.ID, performance.ProductID, performance.NetworkID, performance.BrandID, performance.Date, performance.Cost, performance.Revenue, performance.Leads, performance.Device, product.ProductName, network.NetworkName, brand.BrandName FROM performance LEFT JOIN product ON performance.ProductID = product.ID LEFT JOIN network ON performance.NetworkID = network.ID LEFT JOIN brand ON performance.BrandID = brand.ID WHERE performance.Date >= ? AND performance.Date <= ? AND Device IN (?) ORDER BY performance.Date ASC");
		// $res->bind_param( "sss", $from, $to, $devices2);
		// $res->execute();
		// $result = $res->get_result();
		$data=array();
		while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
			$row=array();
			$row['ID']=addslashes($rs["ID"]);
			$row['ProductID']=addslashes($rs["ProductID"]);
			$row['ProductName']=addslashes($rs["ProductName"]);
			$row['NetworkID']=addslashes($rs["NetworkID"]);
			$row['NetworkName']=addslashes($rs["NetworkName"]);
			$row['BrandID']=addslashes($rs["BrandID"]);
			$row['BrandName']=addslashes($rs["BrandName"]);
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
	// if all blank except brand
	if($productIds == '' && $networkIds == '' && $devices == '' && $brandIds != ''){
			
		$result = $conn->query("SELECT performance.ID, performance.ProductID, performance.NetworkID, performance.BrandID, performance.Date, performance.Cost, performance.Revenue, performance.Leads, performance.Device, product.ProductName, network.NetworkName, brand.BrandName FROM performance LEFT JOIN product ON performance.ProductID = product.ID LEFT JOIN network ON performance.NetworkID = network.ID LEFT JOIN brand ON performance.BrandID = brand.ID WHERE performance.Date >= '$from' AND performance.Date <= '$to' AND BrandID IN ($brandIds) ORDER BY performance.Date ASC");
		// $res = $conn->prepare("SELECT performance.ID, performance.ProductID, performance.NetworkID, performance.BrandID, performance.Date, performance.Cost, performance.Revenue, performance.Leads, performance.Device, product.ProductName, network.NetworkName, brand.BrandName FROM performance LEFT JOIN product ON performance.ProductID = product.ID LEFT JOIN network ON performance.NetworkID = network.ID LEFT JOIN brand ON performance.BrandID = brand.ID WHERE performance.Date >= ? AND performance.Date <= ? AND BrandID IN ($brandIds) ORDER BY performance.Date ASC");
		// $res->bind_param( "ssi", $from, $to, $brandIds);
		// $res->execute();
		// $result = $res->get_result();
		$data=array();
		while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
			$row=array();
			$row['ID']=addslashes($rs["ID"]);
			$row['ProductID']=addslashes($rs["ProductID"]);
			$row['ProductName']=addslashes($rs["ProductName"]);
			$row['NetworkID']=addslashes($rs["NetworkID"]);
			$row['NetworkName']=addslashes($rs["NetworkName"]);
			$row['BrandID']=addslashes($rs["BrandID"]);
			$row['BrandName']=addslashes($rs["BrandName"]);
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
	// if nothing selected, return everything
	if($productIds == '' && $networkIds == '' && $devices == '' && $brandIds == '') {
			
			$result = $conn->query("SELECT performance.ID, performance.ProductID, performance.NetworkID, performance.BrandID, performance.Date, performance.Cost, performance.Revenue, performance.Leads, performance.Device, product.ProductName, network.NetworkName, brand.BrandName FROM performance LEFT JOIN product ON performance.ProductID = product.ID LEFT JOIN network ON performance.NetworkID = network.ID LEFT JOIN brand ON performance.BrandID = brand.ID WHERE performance.Date >= '$from' AND performance.Date <= '$to' ORDER BY performance.Date ASC");
		// $res = $conn->prepare("SELECT performance.ID, performance.ProductID, performance.NetworkID, performance.BrandID, performance.Date, performance.Cost, performance.Revenue, performance.Leads, performance.Device, product.ProductName, network.NetworkName, brand.BrandName FROM performance LEFT JOIN product ON performance.ProductID = product.ID LEFT JOIN network ON performance.NetworkID = network.ID LEFT JOIN brand ON performance.BrandID = brand.ID WHERE performance.Date >= ? AND performance.Date <= ? ORDER BY performance.Date ASC");
		// 	$res->bind_param( "ss", $from, $to);
		// 	$res->execute();
		// 	$result = $res->get_result();
			$data=array();
			while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
				$row=array();
				$row['ID']=addslashes($rs["ID"]);
				$row['ProductID']=addslashes($rs["ProductID"]);
				$row['ProductName']=addslashes($rs["ProductName"]);
				$row['NetworkID']=addslashes($rs["NetworkID"]);
				$row['NetworkName']=addslashes($rs["NetworkName"]);
				$row['BrandID']=addslashes($rs["BrandID"]);
				$row['BrandName']=addslashes($rs["BrandName"]);
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
?>