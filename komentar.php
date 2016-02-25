
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
			// Restart new session
			session_start();
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
			// Update session ID to user
			$conn = new mysqli("localhost","root","admin","tubesweb1");
			$update_session_query = "UPDATE user SET SessionID=? WHERE Username=?";
			$result = $conn->prepare($update_session_query);
			if ($result === false) {
				trigger_error('Wrong SQL: ' . $update_session_query . ' Error: ' . $conn->errno . ' ' . $conn->error, E_USER_ERROR);
			}
			$result->bind_param('ss',$_SESSION['user_token'],$ThisSessionUsername);
			$result->execute();
			$conn->close();
		} else {
			header('Location:login.php');
		}
	}
?>

<?php
	// LAKUKAN INSERT DATA KOMENTAR KE DATABASE
	// Buat koneksi ke phpmyadmin sekaligus database tubesweb1
	$connection = mysqli_connect('localhost', "root", "admin", "tubesweb1");
	// VARIABEL (POST DAN GET)
	$nama_komentator = mysqli_real_escape_string($connection,htmlentities($_GET['q2']));
	$email = mysqli_real_escape_string($connection,htmlentities($_GET['q3']));
	$isi_komentar = mysqli_real_escape_string($connection,htmlentities($_GET['q4']));
	$ID_post = mysqli_real_escape_string($connection,htmlentities($_GET['q1']));
	$tanggal = mysqli_real_escape_string($connection,htmlentities(date('d-m-Y')));
	if (mysqli_connect_errno())
	{
		echo "Failed to connect to MySQL: " .mysqli_connect_error();
	}
	// Langsung lakukan insert data dari form ke tabel daftar komentar
	$insertquery = "INSERT INTO daftarkomentar (Nama, TanggalKomentar, Email, IsiKomentar, ID_post_terkait) VALUES (?, ?, ?, ?, ?)";
	$result = $connection->prepare($insertquery);
	if ($result === false) {
		trigger_error('Wrong SQL: ' . $result . ' Error: ' . $connection->errno . ' ' . $connection->error, E_USER_ERROR);
	}
	$result->bind_param('ssssi',$nama_komentator,$tanggal,$email,$isi_komentar,$ID_post);
	$result->execute();
	/*if (!mysqli_query($connection, $insertquery))
	{
		die('Error: '. mysqli_error($connection));
	}*/
	// Akhiri transaksi
	mysqli_close($connection);
	
	
	// LAKUKAN PENGISIAN RESPONSE TEXT 
	// Buat koneksi ke database tubesweb1
	$connection = mysqli_connect('localhost', "root", "admin", "tubesweb1");
	if (mysqli_connect_errno())
	{
		echo "Failed to connect to MySQL: " .mysqli_connect_error();
	}
	// Baca isi tabel daftar komentar masukkan ke variabel response text
	$komentar_query = "SELECT Nama,TanggalKomentar,IsiKomentar FROM daftarkomentar WHERE ID_post_terkait=? ORDER BY TanggalKomentar desc";
	$result = $connection->prepare($komentar_query);
	if ($result === false) {
		trigger_error('Wrong SQL: ' . $komentar_query . ' Error: ' . $connection->errno . ' ' . $connection->error, E_USER_ERROR);
	}
	$result->bind_param('s',$ID_post);
	$result->execute();
	$result->bind_result($ThisCommentSender,$ThisCommentDate,$ThisCommentContent);
	$login_status = False;
	$response_text="";
	while ($result->fetch()) {
		$response_text.= "<li class='art-list-item'>";
		$response_text.= "	<div class='art-list-item-title-and-time'>";
		$response_text.= "		<h2 class='art-list-title'><a href='post.html'>".$ThisCommentSender."</a></h2>";
		$response_text.= "		<div class='art-list-time'>".$ThisCommentDate."</div>";
		$response_text.= "	</div>";
		$response_text.= "	<p>".$ThisCommentContent."</p>";
		$response_text.= "</li>";
	}
	// Akhiri transaksi
	mysqli_close($connection);
	
	echo $response_text; // PRINT HASIL RESPONSE_TEXT

	/*$hasil_baca = mysqli_query($connection, "SELECT * FROM daftarkomentar 
				  WHERE ID_post_terkait='$ID_post' ORDER BY TanggalKomentar desc");
	while ($row = mysqli_fetch_array($hasil_baca))
	{	
		$response_text.= "<li class='art-list-item'>";
		$response_text.= "	<div class='art-list-item-title-and-time'>";
		$response_text.= "		<h2 class='art-list-title'><a href='post.html'>".$row['Nama']."</a></h2>";
		$response_text.= "		<div class='art-list-time'>".$row['TanggalKomentar']."</div>";
		$response_text.= "	</div>";
		$response_text.= "	<p>".htmlentities($row['IsiKomentar'])."</p>";
		$response_text.= "</li>";
	}
	// Akhiri transaksi
	mysqli_close($connection);
	
	echo $response_text; // PRINT HASIL RESPONSE_TEXT*/
?>



