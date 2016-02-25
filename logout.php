<?php 
	session_start();
	if (!isset($_SESSION['user_token'])) {
		header('Location:login.php');
	} else {
		// Check session token di database
		$conn = new mysqli("localhost","root","admin","tubesweb1");
		$sql = "SELECT Username FROM user WHERE SessionID=?";
		$result = $conn->prepare($sql);
		if ($result === false) {
			trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->errno . ' ' . $conn->error, E_USER_ERROR);
		}
		$result->bind_param('s',$_SESSION['user_token']);
		$result->execute();
		$result->bind_result($ThisSessionUsername);
		$valid_user = False;
		while ($result->fetch()) {
			$valid_user = True;
		}
		$conn->close();

		// Handle session validity
		if ($valid_user) {
			// Destroy old session
			$_SESSION = array();
			session_destroy();
			// Update session ID to user
			$conn = new mysqli("localhost","root","admin","tubesweb1");
			$update_session_query = "UPDATE user SET SessionID=? WHERE Username=?";
			$result = $conn->prepare($update_session_query);
			if ($result === false) {
				trigger_error('Wrong SQL: ' . $update_session_query . ' Error: ' . $conn->errno . ' ' . $conn->error, E_USER_ERROR);
			}
			$blank_session_id = "";
			$result->bind_param('ss',$blank_session_id,$ThisSessionUsername);
			$result->execute();
			$conn->close();
			header('Location:login.php');
		} else {
			header('Location:index.php');
		}
	}


	/*//remove PHPSESSID from browser
	if ( isset( $_COOKIE[session_name()] ) )
	setcookie( session_name(), “”, time()-3600, “/” );
	//clear session from globals
	$_SESSION = array();
	//clear session from disk
	session_destroy();
	//redirect to login page
	header('Location:login.php');*/
?>