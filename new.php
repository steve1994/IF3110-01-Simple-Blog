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
	// Buat koneksi ke phpmyadmin sekaligus database tubesweb1
	// Asumsi : database tubesweb1 sudah dibuat secara manual
	$connection = mysqli_connect('localhost', "root", "", "tubesweb1");
	if (mysqli_connect_errno())
	{
		echo "Failed to connect to MySQL: " .mysqli_connect_error();
	}
	
	// Asumsi : tabel daftarpost sudah dibuat secara manual dalam database tubesweb1
	// Langsung lakukan insert data dari form ke tabel daftarpost
	
	$judul = $_POST['Judul'];
	$tanggal = $_POST['Tanggal'];
	$content = $_POST['Konten'];
	$insertquery = "INSERT INTO daftarpost (Judul, Tanggal, IsiPostHTML) VALUES ('$judul','$tanggal','$content')";
	
	if (!mysqli_query($connection, $insertquery))
	{
		die('Error: '. mysqli_error($connection));
	}
	// Akhiri transaksi
	mysqli_close($connection);
?>
<H2>Data Berhasil Ditambahkan</H2>
<a href="index.php">LANJUT KE HALAMAN UTAMA</a>
</body>
</html>