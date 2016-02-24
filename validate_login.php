<?php 
	$csrf_token = $_POST['csrf_token'];
	session_start();

	if ($csrf_token == $_SESSION['csrf_token']) {
		// Check record into database
		$conn = new mysqli("localhost","root","","tubesweb1");
		// Escape SQL String Injection
		$Username = mysqli_real_escape_string($conn,htmlentities($_POST['Username']));
		$Password = mysqli_real_escape_string($conn,htmlentities($_POST['Password']));
		// Check login status
		$sql = "SELECT Password FROM user WHERE Username=?";
		$result = $conn->prepare($sql);
		if ($result === false) {
			trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->errno . ' ' . $conn->error, E_USER_ERROR);
		}
		$result->bind_param('s',$Username);
		$result->execute();
		$result->bind_result($ThisUserPassword);
		$login_status = False;
		while ($result->fetch()) {
			if ($ThisUserPassword == $Password) {
				$login_status = True;
			}
		}
		$conn->close();

		// Redirect Into Proper State (True / False)
		if ($login_status) {
			// Generate new user token pasca-login
			function generateRandomString() {
			    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			    $charactersLength = strlen($characters);
			    $randomString = '';
			    $length = 20;
			    for ($i = 0; $i < $length; $i++) {
			        $randomString .= $characters[rand(0, $charactersLength - 1)];
			    }
			    return $randomString;
			}
			$_SESSION['user_token'] = generateRandomString();
			// Update session saat ini ke tabel user
			$conn = new mysqli("localhost","root","","tubesweb1");
			$update_session_query = "UPDATE user SET SessionID=? WHERE Username=?";
			$result = $conn->prepare($update_session_query);
			if ($result === false) {
				trigger_error('Wrong SQL: ' . $update_session_query . ' Error: ' . $conn->errno . ' ' . $conn->error, E_USER_ERROR);
			}
			$result->bind_param('ss',$_SESSION['user_token'],$Username);
			$result->execute();
			$conn->close();
			// Redirect ke halaman utama
			header('Location:index.php');
		} else {
			header('Location:login.php');
		}
	} else {
		header('Location:login.php');
	}
?>