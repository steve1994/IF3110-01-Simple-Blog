<?php
	// Buat koneksi ke phpmyadmin sekaligus database tubesweb1
	// Asumsi : database tubesweb1 sudah dibuat secara manual
	$connection = mysqli_connect('localhost:1234', "root", "", "tubesweb1");
	if (mysqli_connect_errno())
	{
		echo "Failed to connect to MySQL: " .mysqli_connect_error();
	}
	
	// Asumsi : tabel daftarpost sudah dibuat secara manual dalam database tubesweb1
	// Langsung lakukan insert data dari form ke tabel daftarpost
	$judul = $_POST['Judul'];
	$tanggal = $_POST['Tanggal'];
	$content = $_POST['Konten'];
	$insertquery = "INSERT INTO daftarpost ('Judul', 'Tanggal', 'IsiPostHTML') VALUES ('$judul','$tanggal','$content')";
	
	if (!mysqli_query($connection, $insertquery))
	{
		die('Error: '. mysqli_error($connection));
	}
	
	mysqli_close($connection);
?>