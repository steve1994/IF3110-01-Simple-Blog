function Load(ID_post)
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
	xmlhttp.open("GET","komentar.php?q="+ID_post,true);
	xmlhttp.send();
}
