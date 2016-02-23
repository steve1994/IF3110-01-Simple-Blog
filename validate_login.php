<?php 
	$csrf_token = $_POST['csrf_token'];
	$Username = $_POST['Username'];
	$Password = $_POST['Password'];

	session_start();
	if ($csrf_token == $_SESSION['csrf_token']) {
		// Check record into database
		$conn = new mysqli("localhost","root","","tubesweb1");
		$sql = "SELECT * FROM user WHERE Username='$Username'";
		$result = $conn->query($sql);
		$login_status = False;
		$rowPP = "";
		if ($result->num_rows > 0) {
			while ($row = $result->fetch_assoc()) {
				$rowPP .= $row['Password'];
				if ($row['Password'] == $Password) {
					$login_status = True;
				}
			} 
		} 
		$conn->close();
		// Check if computed username, password, user_token true 
		//$user_token_used = hash('sha256',$Username.$Password.$_SESSION['user_token']);
		/*$login_status = True;
		if ($user_token != $this_user_current_token) {
			$login_status = False;
		}*/
		// Redirect Into Proper State (True / False)
		if ($login_status) {
			// Restart session pasca-login
			session_unset();
			session_destroy();
			session_start();
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
			$new_user_token = generateRandomString();
	    	//$new_user_token_hash = hash('sha256',$Username.$Password.$new_user_token);
	    	// Update tabel user dengan token baru
			/*$conn = new mysqli("localhost","root","","tubesweb1");
			$sql = "UPDATE user SET csrf_token=$new_user_token_hash WHERE Username='$Username' AND Password='$Password'";
			mysqli_query($conn,$sql);
			mysqli_close($conn);*/
			// Update session variable
			$_SESSION['user_token'] = $new_user_token;
			// Redirect ke halaman utama
			header('Location:index.php');
		} else {
			//header('Location:login.php');
			echo $Password;
		}
	} else {
		//header('Location:login.php');
		echo 'I am C';
	}
?>