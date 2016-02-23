function ValidasiPassword() {
	var password = document.forms["validate_registrasi"]["Password"].value;
	var confirm_password = document.forms["validate_registrasi"]["ConfirmPassword"].value;
	if (password==confirm_password) {
		var hash256_password = CryptoJS.SHA256(password);
		document.forms["validate_registrasi"]["Password"].value = hash256_password;
		return true;
	} else {
		alert('Password dan Konfirmasi Password Tidak Sama');
		return false;
	}
}

function HashPassword() {
	var password = document.forms["validate"]["Password"].value;
	var hash256_password = CryptoJS.SHA256(password);
	document.forms["validate"]["Password"].value = hash256_password;
	return true;
}

function ValidasiEmailRegistrasi() // Fungsi untuk mengeluarkan pop up message jika format email tidak valid atau tidak diisi
{
	// Dapatkan  value email pada saat submit
	var email = document.forms["validate_registrasi"]["Email"].value;

	// Lakukan validasi email
	if (email=="" || email==null)
	{
		alert("Email harus diisi.");
		return false;
	}
	else
	{
		if (validateEmail(email)) // Format email valid
		{
			return true;
		}
		else
		{
			alert("Format Email tidak valid"); return false;
		}
	}
}
function validateEmail(email) // Regex untuk mengecek penulisan email (mengandung @ dan .)
{
	var regex = /^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/;
	return (regex).test(email);
}