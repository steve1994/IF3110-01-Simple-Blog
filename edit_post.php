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

<title>Simple Blog | Tambah Post</title>

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
			// Check if this post owned by this user
            $connection = mysqli_connect('localhost', "root", "admin", "tubesweb1");
            $sql = "SELECT Username FROM daftarpost WHERE ID=?";
            $result = $connection->prepare($sql);
            if ($result === false) {
                trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $connection->errno . ' ' . $connection->error, E_USER_ERROR);
            }
            $result->bind_param('i',$_GET['q2']);
            $result->execute();
            $result->bind_result($UsernameThisPost);
            $valid_user_this_post = False;
            while ($result->fetch()) {
                if ($UsernameThisPost == $ThisSessionUsername) {
                    $valid_user_this_post = True;
                }
            }

            if ($valid_user_this_post) {
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
            	header('Location:index.php');
            }
		} else {
			header('Location:login.php');
		}
	}
?>

</head>

<body class="default">
<div class="wrapper">

<nav class="nav">
    <a style="border:none;" id="logo" href="index.html"><h1>Simple<span>-</span>Blog</h1></a>
    <ul class="nav-primary">
        <li><a href="new_post.html">+ Tambah Post</a></li>
    </ul>
</nav>

<?php
	// Mencatat judul post terkait
	$ID_post = $_GET["q2"];
    $_SESSION['csrf_token'] = generateRandomString();
?>

<article class="art simple post">
    
    
    <h2 class="art-title" style="margin-bottom:40px">-</h2>

    <div class="art-body">
        <div class="art-body-inner">
            <h2>Edit Post</h2>

            <div id="contact-area">
                <form enctype="multipart/form-data" method="post" action="edit.php" name="form_new_post" onsubmit="return KeluarkanValidasi()">
					<input type="hidden" name="ID_post" id="ID_post" value="<?php echo $ID_post; ?>">
					<input type="hidden" name="csrf_token" id="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

                    <label for="Judul">Judul:</label>
                    <input type="text" name="Judul" id="Judul" value=
					"<?php 
						// MENAMPILKAN JUDUL POST
						// Buat koneksi ke database tubesweb1
						$connection = mysqli_connect('localhost', "root", "admin", "tubesweb1");
						if (mysqli_connect_errno())
						{
							echo "Failed to connect to MySQL: " .mysqli_connect_error();
						}

						$hasil_baca = mysqli_query($connection, "SELECT * FROM daftarpost where ID='$ID_post'");
						while ($row = mysqli_fetch_array($hasil_baca))
						{	
							echo $row['Judul'];
						}
						// Akhiri transaksi
						mysqli_close($connection);
					?>">

                    <label for="Tanggal">Tanggal:</label>
                    <input type="text" name="Tanggal" id="Tanggal" value=
					"<?php
						// MENAMPILKAN JUDUL POST
						// Buat koneksi ke database tubesweb1
						$connection = mysqli_connect('localhost', "root", "admin", "tubesweb1");
						if (mysqli_connect_errno())
						{
							echo "Failed to connect to MySQL: " .mysqli_connect_error();
						}

						$hasil_baca = mysqli_query($connection, "SELECT * FROM daftarpost where ID='$ID_post'");
						while ($row = mysqli_fetch_array($hasil_baca))
						{	
							echo $row['Tanggal'];
						}
						// Akhiri transaksi
						mysqli_close($connection);
					?>">
                    
                    <label for="Konten">Konten:</label><br>
                    <textarea name="Konten" rows="20" cols="20" id="Konten">
						<?php
							// MENAMPILKAN JUDUL POST
							// Buat koneksi ke database tubesweb1
							$connection = mysqli_connect('localhost', "root", "admin", "tubesweb1");
							if (mysqli_connect_errno())
							{
								echo "Failed to connect to MySQL: " .mysqli_connect_error();
							}

							$hasil_baca = mysqli_query($connection, "SELECT * FROM daftarpost where ID='$ID_post'");
							while ($row = mysqli_fetch_array($hasil_baca))
							{	
								echo $row['IsiPostHTML'];
							}
							// Akhiri transaksi
							mysqli_close($connection);
						?>
					</textarea>

					<label for="Gambar">Gambar:</label>
                    <input type="file" name="Gambar" id="Gambar" required>

                    <input type="submit" name="submit" value="Simpan" class="submit-button">
                </form>
            </div>
        </div>
    </div>

</article>

<footer class="footer">
    <div class="back-to-top"><a href="">Back to top</a></div>
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

<script type="text/javascript" src="assets/js/validasi_tanggal.js"></script>
<script type="text/javascript" src="assets/js/fittext.js"></script>
<script type="text/javascript" src="assets/js/app.js"></script>
<script type="text/javascript" src="assets/js/respond.min.js"></script>

</body>

</html>
