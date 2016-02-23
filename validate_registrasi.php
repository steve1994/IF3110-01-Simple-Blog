<?php 
	$Username = $_POST['Username'];
	$Password = $_POST['Password'];
	$Email = htmlspecialchars($_POST['Email']);
	$csrf_token = $_POST['csrf_token'];

	session_start();
	if ($csrf_token == $_SESSION['csrf_token']) {
		// Check jika ternyata user sudah terdaftar
		$conn = new mysqli("localhost","root","","tubesweb1");
		$sql = "SELECT * FROM user WHERE Username='$Username'";
		$result = $conn->query($sql);
		$is_user_exist = False;
		if ($result->num_rows > 0) {
			$is_user_exist = True;
		} 
		$conn->close();

		if ($is_user_exist) {
			header('Location:register.php');
		} else {
			// Generate user token baru yang dihash
			/*function generateRandomString() {
		        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		        $charactersLength = strlen($characters);
		        $randomString = '';
		        $length = 20;
		        for ($i = 0; $i < $length; $i++) {
		            $randomString .= $characters[rand(0, $charactersLength - 1)];
		        }
		        return $randomString;
		    }
		    $_SESSION['user_token'] = generateRandomString();*/
			// Update username, password, beserta token user 
			$conn = new mysqli("localhost","root","","tubesweb1");
			$sql = "INSERT INTO user (Username,Password,Email) VALUES ('$Username','$Password','$Email')";
			$conn->query($sql);
			$conn->close();
			// Redirect ke login 
			header('Location:login.php');
		}
	} else {
		header('Location:register.php');
	}
?>