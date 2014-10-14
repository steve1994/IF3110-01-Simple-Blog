function ValidasiEmail() // Fungsi untuk mengeluarkan pop up message jika format email tidak valid atau tidak diisi
{
	// Dapatkan  value email pada saat submit
	var email = form_komentar.Email.value;

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
function LoadKomentarAJAX()
{
	if (ValidasiEmail())
	{
		var xmlhttp;
		if (window.XMLHttpRequest)
		{
			xmlhttp=new XMLHttpRequest();
		}
		else
		{
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange=function()
		{
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
				document.getElementById("ListKomentarPost").innerHTML=xmlhttp.responseText;
			}
		}
		xmlhttp.open("GET","komentar.php?q1="+form_komentar.ID_post.value+"&q2="+form_komentar.Nama.value+"&q3="+form_komentar.Email.value+"&q4="+form_komentar.Komentar.value,true);
		xmlhttp.send();
	}
}