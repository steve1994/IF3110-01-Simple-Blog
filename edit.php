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

<?php 
	session_start();
	if (!isset($_SESSION['user_token'])) {
		header('Location:login.php');
	} 
?>

<body class="default">
<?php
	$csrf_token = $_POST['csrf_token'];

	// UPDATE POST DENGAN ID YANG SUDAH DICARI SEBELUMNYA
	// Buat koneksi ke database tubesweb1
	if ($csrf_token == $_SESSION['csrf_token']) {
		if (isset($_FILES["Gambar"]["name"])) {
			// Check file type and file size
			$file_size = $_FILES['Gambar']['size'];
			$file_type = $_FILES['Gambar']['type'];

			if (($file_size < 2000000) && (strpos($file_type,"image"))) {
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
				// DAPAT VARIABEL POST GLOBAL
				$ID= mysqli_real_escape_string($connection,htmlentities($_POST['ID_post'])); // dapat ID post
				$judul = mysqli_real_escape_string($connection,htmlentities($_POST['Judul'])); // dapat judul post
				$tanggal_baru = mysqli_real_escape_string($connection,htmlentities($_POST['Tanggal'])); // dapat tanggal baru dari judul post terkait
				$konten_baru = mysqli_real_escape_string($connection,htmlentities($_POST['Konten'])); // dapat konten baru dari judul post terkait
				// Lakukan update data ke tabel daftarpost dengan ID yang sudah didapatkan
				$updatequery = "UPDATE daftarpost SET Judul=?, Tanggal=?, IsiPostHTML=?, Image=? WHERE daftarpost.ID=?";
				$result = $connection->prepare($updatequery);
				if ($result === false) {
					trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $connection->errno . ' ' . $connection->error, E_USER_ERROR);
				}
				$result->bind_param('ssssi',$judul,$tanggal_baru,$konten_baru,$path_images,$ID);
				$result->execute();
				mysqli_close($connection);

				// Refer ke halaman lain
				header("Location:index.php");
			} else {
				echo "Not supported file upload<BR>";
				echo "<a href='index.php'> BACK TO MAIN PAGE </a>";
			}
		}
	}
?>

</body>
</html>
