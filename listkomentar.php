<?php 
	session_start();
	if (!isset($_SESSION['user_token'])) {
		header('Location:login.php');
	} 
?>

<?php
	// VARIABEL (POST DAN GET)
	$ID_post = $_GET['q1'];
	$response_text=""; // Variabel penampung string hasil
	
	// LAKUKAN PENGISIAN RESPONSE TEXT 
	// Buat koneksi ke database tubesweb1
	$connection = mysqli_connect('localhost', "root", "", "tubesweb1");
	if (mysqli_connect_errno())
	{
		echo "Failed to connect to MySQL: " .mysqli_connect_error();
	}
	// Baca isi tabel daftar komentar masukkan ke variabel response text
	$hasil_baca = mysqli_query($connection, "SELECT * FROM daftarkomentar 
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
	
	echo $response_text; // PRINT HASIL RESPONSE_TEXT
?>
