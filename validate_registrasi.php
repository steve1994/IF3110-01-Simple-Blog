<?php 
	$csrf_token = $_POST['csrf_token'];
	session_start();
	if ($csrf_token == $_SESSION['csrf_token']) {
		$conn = new mysqli("localhost","root","admin","tubesweb1");
		// Escape SQL Injection String
		$Username = mysqli_real_escape_string($conn,htmlentities($_POST['Username']));
		$Password = mysqli_real_escape_string($conn,htmlentities($_POST['Password']));
		$Email = mysqli_real_escape_string($conn,htmlentities($_POST['Email']));
		// Search through table using bind variable
		$sql = "SELECT * FROM user WHERE Username=?";
		$result = $conn->prepare($sql);
		if ($result === false) {
			trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->errno . ' ' . $conn->error, E_USER_ERROR);
		}
		$result->bind_param('s',$Username);
		$result->execute();
		$result->bind_result($ThisUsername,$ThisPassword,$ThisEmail);
		$is_user_exist = False;
		while ($result->fetch()) {
			$is_user_exist = True;
		}

		// Check if current user has exist in database
		if ($is_user_exist) {
			header('Location:register.php');
		} else {
			// Update username, password, beserta token user 
			$conn = new mysqli("localhost","root","admin","tubesweb1");
			// Insert Using Bind Variable
			$sql = "INSERT INTO user (Username,Password,Email) VALUES (?,?,?)";
			$result = $conn->prepare($sql);
			if ($result === false) {
				trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->errno . ' ' . $conn->error, E_USER_ERROR);
			}
			$result->bind_param('sss',$Username,$Password,$Email);
			$result->execute();
			$conn->close();
			// Redirect ke login 
			header('Location:login.php');
		}
	} else {
		header('Location:register.php');
	}
?>