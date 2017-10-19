<?php
	include 'dbconfig.php';//make the cofig file include
	global $details;//make the connection vars global
	$conn = new mysqli($details['server_host'], $details['mysql_name'], $details['mysql_password'], $details['mysql_database']);
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	    echo "Error";
	}
	// } else {
	// 	echo "Connection: success!";
	// }
	$data = json_decode(file_get_contents("php://input"));
	$username = strtolower(mysqli_real_escape_string($conn, $data->name));
	$password = mysqli_real_escape_string($conn, $data->password);
	$hashedPassword = password_hash($password, PASSWORD_BCRYPT);
	$bad_login_limit = 3;
	$lockout_time = 600;

	if($res = $conn->prepare("SELECT * FROM user WHERE UserName = ?")){
		// echo 'prepare success';
		if($res->bind_param( "s", $username)){
			// echo 'bind success';
			if($res->execute()){
				// echo 'execute success';
				if($result = $res->get_result()){
					while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
						$row=array();
						$row['ID']=addslashes($rs["ID"]);
						$row['UserName']=addslashes($rs["UserName"]);
						$row['Password']=addslashes($rs["Password"]);
						$row['FailedLoginTime']=addslashes($rs["FailedLoginTime"]);
						$row['FailedLoginCount']=addslashes($rs["FailedLoginCount"]);
						$failed_login_count = $row['FailedLoginCount'];
						$first_failed_login = $row['FailedLoginTime'];
						if(($failed_login_count >= $bad_login_limit) && (time() - $first_failed_login < $lockout_time)) {
							echo "lockout";
							exit; // or return, or whatever.
						}
						
						else if( ($row['ID'] === "2" && !password_verify($password, $row['Password'])) ) {
							
							if( time() - $first_failed_login > $lockout_time ) {
								// first unsuccessful login since $lockout_time on the last one expired
								$first_failed_login = time(); // commit to DB
								$failed_login_count = 1; // commit to db
								$userID = $row['ID'];
								$stmt = $conn->prepare("UPDATE user SET FailedLoginTime=?, FailedLoginCount=? WHERE ID=?");
								$stmt->bind_param("iii", $first_failed_login, $failed_login_count, $userID);
								
								
								$stmt->execute();
								

								$stmt->close();
								echo 'ERROR: password does not match';
							} 
							else {
								$userID = $row['ID'];
								$failed_login_count++; // commit to db.
								$stmt = $conn->prepare("UPDATE user SET FailedLoginCount=? WHERE ID=?");
								$stmt->bind_param("ii", $failed_login_count, $userID);
								
								
								$stmt->execute();
								

								$stmt->close();
								echo 'ERROR: password does not match';
							}
							exit; // or return, or whatever.
						}
						else if(($row['ID'] === "3" && !password_verify($password, $row['Password']))){
							
							if( time() - $first_failed_login > $lockout_time ) {
								// first unsuccessful login since $lockout_time on the last one expired
								$first_failed_login = time(); // commit to DB
								$failed_login_count = 1; // commit to db
								$userID = $row['ID'];
								$stmt = $conn->prepare("UPDATE user SET FailedLoginTime=?, FailedLoginCount=? WHERE ID=?");
								$stmt->bind_param("iii", $first_failed_login, $failed_login_count, $userID);
								
								
								$stmt->execute();
								

								$stmt->close();
							} 
							else {
								$userID = $row['ID'];
								$failed_login_count++; // commit to db.
								$stmt = $conn->prepare("UPDATE user SET FailedLoginCount=? WHERE ID=?");
								$stmt->bind_param("ii", $failed_login_count, $userID);
								
								
								$stmt->execute();
								

								$stmt->close();
								echo 'ERROR: password does not match';
							}
							exit; // or return, or whatever.
						}
						else {
							// user is not currently locked out, and the login is valid.
							if($row['ID'] === "2" && password_verify($password, $row['Password'])){
								// echo 'Password match!';
								$first_failed_login = 0; // commit to DB
								$failed_login_count = 0; // commit to db
								$userID = $row['ID'];
								$stmt = $conn->prepare("UPDATE user SET FailedLoginTime=?, FailedLoginCount=? WHERE ID=?");
								$stmt->bind_param("iii", $first_failed_login, $failed_login_count, $userID);
								
								
								$stmt->execute();
								

								$stmt->close();
								session_start();
								$_SESSION['uid'] = uniqid('ang_');
								echo $_SESSION['uid'];
							}
							else if($row['ID'] === "3" && password_verify($password, $row['Password'])){
								// echo 'Password match!';
								$first_failed_login = 0; // commit to DB
								$failed_login_count = 0; // commit to db
								$userID = $row['ID'];
								$stmt = $conn->prepare("UPDATE user SET FailedLoginTime=?, FailedLoginCount=? WHERE ID=?");
								$stmt->bind_param("iii", $first_failed_login, $failed_login_count, $userID);
								
								
								$stmt->execute();
								

								$stmt->close();
								session_start();
								$_SESSION['uid'] = uniqid('vie_');
								echo $_SESSION['uid'];
							}
						}
						// if($row['ID'] === "2" && password_verify($password, $row['Password'])){
						// 	// echo 'Password match!';
						// 	session_start();
						// 	$_SESSION['uid'] = uniqid('ang_');
						// 	echo $_SESSION['uid'];
						// }
						// else if($row['ID'] === "3" && password_verify($password, $row['Password'])){
						// 	// echo 'Password match!';
						// 	session_start();
						// 	$_SESSION['uid'] = uniqid('vie_');
						// 	echo $_SESSION['uid'];
						// }
						// else {
						// 	echo 'ERROR: password does not match';
						// }
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

	// $result = $res->get_result();
	// $count = mysqli_num_rows($result);

	// if ($count == 1){
	// 	$row = $result->fetch_array(MYSQLI_ASSOC);

		
	// }

?>