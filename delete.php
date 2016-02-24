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
	// HAPUS GAMBAR DARI POST TERKAIT
	$connection = mysqli_connect('localhost', "root", "", "tubesweb1");
	// ESCAPE ID POST FROM STRING SQL INJECTION
	$ID_post = mysqli_real_escape_string($connection,htmlentities($_GET['q'])); 

	if (mysqli_connect_errno())
	{
		echo "Failed to connect to MySQL: " .mysqli_connect_error();
	}
	//$hasil_baca = mysqli_query($connection, "SELECT Images FROM daftarpost WHERE ID=?");
	$select_post = "SELECT Image FROM daftarpost WHERE ID=?";
	$result = $connection->prepare($select_post);
	if ($result === false) {
		trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $connection->errno . ' ' . $connection->error, E_USER_ERROR);
	}
	$result->bind_param('i',$ID_post);
	$result->execute();
	$result->bind_result($ThisUserImagesPath);
	$path_image_related = "";
	while ($result->fetch()) {
		$path_image_related .= $ThisUserImagesPath;
	}
	/*while ($row = mysqli_fetch_array($hasil_baca))
	{	
		$path_image_related .= $row['Image'];
	}*/
	mysqli_close($connection);

	// Setelah diketahui path hapus file terkait
	if (file_exists($path_image_related)) {
		if (unlink($path_image_related)) {
			echo "Image this post deleted";
		} else {
			echo "Failed to delete image";
		}
	}
	
	// HAPUS POST DARI TABEL DAFTAR POST
	// Buat koneksi ke phpmyadmin sekaligus database tubesweb1
	$connection = mysqli_connect('localhost', "root", "", "tubesweb1");
	if (mysqli_connect_errno())
	{
		echo "Failed to connect to MySQL: " .mysqli_connect_error();
	}
	// DELETE RECORD DI DATABASE
	$delete_post = "DELETE FROM daftarpost WHERE ID=?";
	$result = $connection->prepare($delete_post);
	if ($result === false) {
		trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $connection->errno . ' ' . $connection->error, E_USER_ERROR);
	}
	$result->bind_param('i',$ID_post);
	$result->execute();
	//mysqli_query($connection,"DELETE FROM daftarpost WHERE ID='$ID_post'");
	mysqli_close($connection);
	
	// HAPUS KOMENTAR DARI POST TERKAIT
	// Buat koneksi ke phpmyadmin sekaligus database tubesweb1
	$connection = mysqli_connect('localhost', "root", "", "tubesweb1");
	if (mysqli_connect_errno())
	{
		echo "Failed to connect to MySQL: " .mysqli_connect_error();
	}
	// DELETE RECORD DI DATABASE
	$delete_komentar = "DELETE FROM daftarkomentar WHERE ID=?";
	$result = $connection->prepare($delete_komentar);
	if ($result === false) {
		trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $connection->errno . ' ' . $connection->error, E_USER_ERROR);
	}
	$result->bind_param('i',$ID_post);
	$result->execute();
	//mysqli_query($connection,"DELETE FROM daftarkomentar WHERE ID='$ID_post'");
	mysqli_close($connection);
	
	// Refer ke halaman lain
	header("Location:index.php");
?>

</body>
</html>

