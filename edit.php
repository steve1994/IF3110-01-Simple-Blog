<!DOCTYPE html>
<html>
<head>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<meta name="description" content="Deskripsi Blog">
<meta name="author" content="Judul Blog">

<!-- Twitter Card -->
<meta name="twitter:card" content="summary">
<meta name="twitter:site" content="omfgitsasalmon">
<meta name="twitter:title" content="Simple Blog">
<meta name="twitter:description" content="Deskripsi Blog">
<meta name="twitter:creator" content="Simple Blog">
<meta name="twitter:image:src" content="{{! TODO: ADD GRAVATAR URL HERE }}">

<meta property="og:type" content="article">
<meta property="og:title" content="Simple Blog">
<meta property="og:description" content="Deskripsi Blog">
<meta property="og:image" content="{{! TODO: ADD GRAVATAR URL HERE }}">
<meta property="og:site_name" content="Simple Blog">

<link rel="stylesheet" type="text/css" href="assets/css/screen.css" />

<!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->


</head>

<body class="default">
<?php
	// DAPAT VARIABEL POST GLOBAL
	$judul = $_POST['Judul']; // dapat judul post
	$tanggal_baru = $_POST['Tanggal']; // dapat tanggal baru dari judul post terkait
	$konten_baru = $_POST['Konten']; // dapat konten baru dari judul post terkait
?>
<?php
	// CARI ID POST
	// Buat koneksi ke database tubesweb1
	$connection = mysqli_connect('localhost', "root", "", "tubesweb1");
	if (mysqli_connect_errno())
	{
		echo "Failed to connect to MySQL: " .mysqli_connect_error();
	}
	
	// Cari ID dari judul Post terlebih dahulu
	$hasil_baca = mysqli_query($connection, "SELECT * from daftarpost WHERE judul='$judul'");
	while ($row = mysqli_fetch_array($hasil_baca))
	{
		$ID = $row['ID'];
	}
	// Akhiri transaksi
	mysqli_close($connection);
?>
<?php	
	// UPDATE POST DENGAN ID YANG SUDAH DICARI SEBELUMNYA
	// Buat koneksi ke database tubesweb1
	$connection = mysqli_connect('localhost', "root", "", "tubesweb1");
	if (mysqli_connect_errno())
	{
		echo "Failed to connect to MySQL: " .mysqli_connect_error();
	}
	// Lakukan update data ke tabel daftarpost dengan ID yang sudah didapatkan
	$updatequery = "UPDATE daftarpost SET Tanggal='$tanggal_baru', IsiPostHTML='$konten_baru' WHERE daftarpost.ID='$ID'";
	mysqli_query($connection, $updatequery);	
	// Akhiri transaksi
	mysqli_close($connection);
?>
<H2>Data Berhasil Diperbaharui</H2>
<a href="index.php">LANJUT KE HALAMAN UTAMA</a>
</body>
</html>
