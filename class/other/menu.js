function desplegarDivMenu(menu)
{
	if(document.getElementById(menu).style.display == "none")
	{
		document.getElementById(menu).style.display = "block";
	} else
	{
		document.getElementById(menu).style.display = "none";
	}
}
function resaltarSpan(id,x)
{
	//alert(id);
	if(x == '1')
	{
		document.getElementById(id).style.cursor = "pointer";
		document.getElementById(id).style.fontSize = "12px";
		document.getElementById(id).style.color = "#0000CC";
	}else
	{
		document.getElementById(id).style.cursor = "default";
		document.getElementById(id).style.fontSize = "11px";
		document.getElementById(id).style.color = "#666666";
	}
}