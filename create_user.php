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

	// $data = json_decode(file_get_contents("php://input"));
	// $username = strtolower(mysqli_real_escape_string($conn, $data->UserName));
	// $password = mysqli_real_escape_string($conn, $data->Password);
	// $password = password_hash($password, PASSWORD_DEFAULT);

	// // $result = $conn->query("SELECT * FROM user WHERE (UserName = $username)");
	// $res = $conn->prepare("SELECT ID FROM user WHERE UserName = ?");
	// $res->bind_param( "s", $username);
	// $res->execute();
	// $result = $res->get_result();

	// if ($result->num_rows > 0) {
	// 	echo 'Duplicate User';
	//    // do something to alert user about non-unique cart
	// } else {
	// 	echo 'before prepare';
	// 	// prepare and bind
	// 	$stmt = $conn->prepare("INSERT INTO user (UserName, Password) VALUES (?, ?)");
	// 	$stmt->bind_param("ss", $username, $password);
	// 	echo ' after prepare';
		
	// 	$stmt->execute();
	// 	echo 'after execute';
	// 	$stmt->close();
	// 	$conn->close();
	// 	echo 'finished';
	// }

	$data = json_decode(file_get_contents("php://input"));
	$username = strtolower(mysqli_real_escape_string($conn, $data->name));
	$password = mysqli_real_escape_string($conn, $data->password);
	$hashedPassword = password_hash($password, PASSWORD_BCRYPT);


	if($res = $conn->prepare("SELECT ID FROM user WHERE UserName = ?")){
		echo 'prepare success';
		if($res->bind_param( "s", $username)){
			echo 'bind success';
			if($res->execute()){
				echo 'execute success';
				if($result = $res->get_result()){
					if ($result->num_rows > 0){
						echo 'Duplicate User';
					}
					else {
						$stmt = $conn->prepare("INSERT INTO user (UserName, Password) VALUES (?, ?)");
						$stmt->bind_param("ss", $username, $hashedPassword);
						echo ' after prepare';
						
						$stmt->execute();
						echo 'after execute';
						$stmt->close();
					}

				}
				else {
					echo 'get results failure';
				}
			}
			else {
				echo 'execute failure';
			}
		}
		else {
			echo 'bind failure';
		}
	}
	else {
		echo 'prepare failure';
	}
	
	$res->close();
	$conn->close();
	
?>