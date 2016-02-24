
<?php 
	session_start();
	if (!isset($_SESSION['user_token'])) {
		header('Location:login.php');
	} 
?>

<?php
	// LAKUKAN INSERT DATA KOMENTAR KE DATABASE
	// Buat koneksi ke phpmyadmin sekaligus database tubesweb1
	$connection = mysqli_connect('localhost', "root", "", "tubesweb1");
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
	$connection = mysqli_connect('localhost', "root", "", "tubesweb1");
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



