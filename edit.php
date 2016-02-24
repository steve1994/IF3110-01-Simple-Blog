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
	$ID= $_POST['ID_post']; // dapat ID post
	$judul = htmlentities($_POST['Judul']); // dapat judul post
	$tanggal_baru = htmlentities($_POST['Tanggal']); // dapat tanggal baru dari judul post terkait
	$konten_baru = htmlentities($_POST['Konten']); // dapat konten baru dari judul post terkait
	$csrf_token = $_POST['csrf_token'];
?>

<?php	
	// UPDATE POST DENGAN ID YANG SUDAH DICARI SEBELUMNYA
	// Buat koneksi ke database tubesweb1
	if (isset($_FILES["Gambar"]["name"])) {
		// Dapatkan path nama baru dari gambar
		$path_images = 'images/'.$_FILES['Gambar']['name'];
		// Buat direktori penyimpanan image jika belum ada
		if (!file_exists('images/')) {
			mkdir('images/');
		}
		// Upload file jpg ke direktori tersebut
		if (move_uploaded_file($_FILES['Gambar']['tmp_name'], 'images/'.$_FILES['Gambar']['name'])) {
			echo "File is valid\n";
		} else {
			echo "Upload failed\n";
		}

		// Update data dari user ke db
		$connection = mysqli_connect('localhost', "root", "", "tubesweb1");
		if (mysqli_connect_errno())
		{
			echo "Failed to connect to MySQL: " .mysqli_connect_error();
		}
		// Lakukan update data ke tabel daftarpost dengan ID yang sudah didapatkan
		$updatequery = "UPDATE daftarpost SET Judul='$judul', Tanggal='$tanggal_baru', IsiPostHTML='$konten_baru', Image='$path_images' WHERE daftarpost.ID='$ID'";
		mysqli_query($connection, $updatequery);	
		// Akhiri transaksi
		mysqli_close($connection);
	}


	$connection = mysqli_connect('localhost', "root", "", "tubesweb1");
	if (mysqli_connect_errno())
	{
		echo "Failed to connect to MySQL: " .mysqli_connect_error();
	}
	// Lakukan update data ke tabel daftarpost dengan ID yang sudah didapatkan
	$updatequery = "UPDATE daftarpost SET Judul='$judul', Tanggal='$tanggal_baru', IsiPostHTML='$konten_baru' WHERE daftarpost.ID='$ID'";
	mysqli_query($connection, $updatequery);	
	// Akhiri transaksi
	mysqli_close($connection);
?>

<?php
	// Refer ke halaman lain
	header("Location:index.php");
?>

</body>
</html>
