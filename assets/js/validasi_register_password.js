function validateEmail(email) // Regex untuk mengecek penulisan email (mengandung @ dan .)
{
	var regex = /^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/;
	return (regex).test(email);
}

function ValidasiPassword() {
	var password = document.forms["validate_registrasi"]["Password"].value;
	var confirm_password = document.forms["validate_registrasi"]["ConfirmPassword"].value;
	var email = validate_registrasi.Email.value;
	
	if (password==confirm_password) {
		if (validateEmail(email) === true) {
			var hash256_password = CryptoJS.SHA256(password);
			document.forms["validate_registrasi"]["Password"].value = hash256_password;
			return true;
		} else {
			alert("Format Email tidak valid"); 
			return false;
		}
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
