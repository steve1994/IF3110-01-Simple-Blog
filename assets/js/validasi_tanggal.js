function KeluarkanValidasi() // Fungsi untuk mengeluarkan pop up message jika format tanggal salah atau tidak valid
{
	// Dapatkan value tanggal pada saat submit
	var tanggal = document.forms["form_new_post"]["Tanggal"].value;
	
	// Simpan tanggal hari ini dengan elemen-elemennya
	var currentdate = new Date();
	var tanggalsekarang = currentdate.getDate();
	var bulansekarang = currentdate.getMonth();
	var tahunsekarang = currentdate.getFullYear();
	
	// Lakukan validasi tanggal
	if (tanggal=="" || tanggal==null)
	{
		alert("Tanggal harus diisi.");
		return false;
	}
	else
	{
		if (validateDate(tanggal)) // sudah dalam format penulisan tanggal dd-mm-yyyy
		{
			var PisahElemenTanggal = tanggal.split("-"); 
			var inputtahun = PisahElemenTanggal[2];
			var inputbulan = PisahElemenTanggal[1];
			var inputtanggal = PisahElemenTanggal[0];
			
			if (inputtahun > tahunsekarang) // bandingkan tahun dengan tahun sekarang
			{
				ProcessImage();
				return true;
			}
			else if (inputtahun < tahunsekarang) 
			{
				alert("Tanggal tidak valid. Masukkan tanggal yang relevan.");return false;
			}
			else
			{
				if (inputbulan > bulansekarang) // bandingkan bulan dengan bulan sekarang
				{
					ProcessImage();
					return true;
				}
				else if (inputbulan < bulansekarang)
				{
					alert("Tanggal tidak valid. Masukkan tanggal yang relevan.");return false;
				}
				else
				{
					if (inputtanggal >= tanggalsekarang) // bandingkan hari dengan hari sekarang
					{
						ProcessImage();
						return true;
					}
					else
					{
						alert("Tanggal tidak valid. Masukkan tanggal yang relevan.");return false;
					}
				}
			}
		}
		else
		{
			alert("Masukkan format tanggal yang valid dengan format : dd-mm-yyyy");return false;
		}
	}
}
function validateDate(date) // Regex untuk mengecek penulisan tanggal
{
	return (/^\d{2}[./-]\d{2}[./-]\d{4}$/).test(date);
}
function ProcessImage() {
	var file_name = document.forms["form_new_post"]["Gambar"].value;
	document.forms["form_new_post"]["path_name"].value = file_name;
}