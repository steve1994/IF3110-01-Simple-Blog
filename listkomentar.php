<?php 
	session_start();
	if (!isset($_SESSION['user_token'])) {
		header('Location:login.php');
	} 
?>

<?php
	// LAKUKAN PENGISIAN RESPONSE TEXT 
	// Buat koneksi ke database tubesweb1
	$connection = mysqli_connect('localhost', "root", "", "tubesweb1");
	$ID_post = mysqli_real_escape_string($connection,htmlentities($_GET['q1']));
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
	// Print Hasil Response Text
	echo $response_text; 

	/*// Baca isi tabel daftar komentar masukkan ke variabel response text
	$hasil_baca = mysqli_query($connection, "SELECT * FROM daftarkomentar 
				  WHERE ID_post_terkait='$ID_post' ORDER BY TanggalKomentar desc");
	$response_text="";
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
