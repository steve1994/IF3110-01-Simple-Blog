function LoadListKomentar()
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
	xmlhttp.open("GET","listkomentar.php?q1="+form_komentar.ID_post.value,true);
	xmlhttp.send();
}