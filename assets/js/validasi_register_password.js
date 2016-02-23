function ValidasiPassword() {
	var CryptoJS = require("CryptoJS");
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
	var CryptoJS = require("CryptoJS");
	var password = document.forms["validate"]["Password"].value;
	var hash256_password = CryptoJS.SHA256(password);
	document.forms["validate"]["Password"].value = hash256_password;
	return true;
}