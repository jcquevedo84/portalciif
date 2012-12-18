function abrirVentana(url, ancho, alto)
{
	var nuevaVentana = window.open('', "_blank","titlebar=no,toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no,copyhistory=no,width=" + ancho + ",height=" + alto + ",top=250,left=250");
	nuevaVentana.document.write(url);
	nuevaVentana.document.close();
	//nuevaVentana.document.write('<H1>Popup Test!</H1>');
	nuevaVentana.focus();
}