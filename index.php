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
<link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico">

<!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

<title>Simple Blog</title>

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

</head>

<body class="default">

<div class="wrapper">

<nav class="nav">
    <a style="border:none;" id="logo" href="index.php"><h1>Simple<span>-</span>Blog</h1></a>
    <ul class="nav-primary">
        <li><a href="new_post.php">+ Tambah Post</a></li>
    </ul>
</nav>

<div id="home">
    <div class="posts">
		<nav class="art-list">
			<ul class="art-list-body" id="IsiList">
				<?php
				// BACA DATA DARI DATABASE DAFTARPOST UNTUK DITULIS DI SINI
				// Buat koneksi ke database tubesweb1
				$connection = mysqli_connect('localhost', "root", "admin", "tubesweb1");
				if (mysqli_connect_errno())
				{
					echo "Failed to connect to MySQL: " .mysqli_connect_error();
				}
				
				// Tampilkan isi tabel datapost dari database tubesweb1 terurut dari bawah
				$hasil_baca = mysqli_query($connection, "SELECT * FROM daftarpost ORDER BY ID desc");
				while ($row = mysqli_fetch_array($hasil_baca))
				{	
					echo "<li class='art-list-item'>";
					echo "	<div class='art-list-item-title-and-time'>";
                    echo "		<h2 class='art-list-title'><a href='post.php?q=$row[ID]'>";
					echo 			$row['Judul'];
					echo "		</a></h2>";
                    echo "		<div class='art-list-time'>";
					echo 			$row['Tanggal'];
					echo "		</div>";
					echo "	</div>";
					echo "	<p>";
					echo 		$row['IsiPostHTML'];
					echo "	</p>";
					echo "	<p>";
					echo "		<a href='edit_post.php?q2=$row[ID]'>Edit</a> | <a href='delete.php?q=$row[ID]' onclick='return hapusPost($row[ID])'>Hapus</a>";
					echo "	</p>";
					echo "</li>"; 
				}
				// Akhiri transaksi
				mysqli_close($connection);
			?>
			</ul>
		</nav>
    </div>
</div>

<footer class="footer">
    <div class="back-to-top"><a href="logout.php">LOGOUT</a></div>
    <!-- <div class="footer-nav"><p></p></div> -->
    <div class="psi">&Psi;</div>
    <aside class="offsite-links">
        Asisten IF3110 /
        <a class="rss-link" href="#rss">RSS</a> /
        <br>
        <a class="twitter-link" href="http://twitter.com/YoGiiSinaga">Yogi</a> /
        <a class="twitter-link" href="http://twitter.com/sonnylazuardi">Sonny</a> /
        <a class="twitter-link" href="http://twitter.com/fathanpranaya">Fathan</a> /
        <br>
        <a class="twitter-link" href="#">Renusa</a> /
        <a class="twitter-link" href="#">Kelvin</a> /
        <a class="twitter-link" href="#">Yanuar</a> /
        
    </aside>
</footer>

</div>

<script>
	function hapusPost(ID) // Lakukan konfirmasi ke user apakah mau menghapus post dengan ID 'ID_post' atau tidak
	{
		if (confirm("Apakah Anda yakin menghapus post ini?")==true)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
</script>
<script type="text/javascript" src="assets/js/fittext.js"></script>
<script type="text/javascript" src="assets/js/app.js"></script>
<script type="text/javascript" src="assets/js/respond.min.js"></script>

</body>
</html>
