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
	$connection = mysqli_connect('localhost', "root", "", "tubesweb1");
	if (mysqli_connect_errno())
	{
		echo "Failed to connect to MySQL: " .mysqli_connect_error();
	}
	// Asumsi : tabel daftarpost sudah dibuat secara manual dalam database tubesweb1
	// Langsung lakukan insert data dari form ke tabel daftarpost
	$judul = htmlentities($_POST['Judul']);
	$tanggal = htmlentities($_POST['Tanggal']);
	$content = htmlentities($_POST['Konten']);
	$csrf_token = $_POST['csrf_token'];

	session_start();
	if ($csrf_token == $_SESSION['csrf_token']) {
		if (isset($_FILES['Gambar']['name'])) {
			// Simpan image ke server 
			$path_images = 'images/'.$_FILES['Gambar']['name'];
			$insertquery = "INSERT INTO daftarpost (Judul, Tanggal, IsiPostHTML, Image) VALUES ('$judul','$tanggal','$content','$path_images')";
			if (!mysqli_query($connection, $insertquery))
			{
				die('Error: '. mysqli_error($connection));
			}
			mysqli_close($connection);

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
		}

		// Redirect ke halaman login
		header("Location:index.php");
	} else {
		// Redirect ke form tambah post
		header("Location:new_post.php");
	}

	
?>

</body>
</html>
