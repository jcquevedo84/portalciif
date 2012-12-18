var resize_timer; 
function initResize() 
{
	if (navigator.appName.indexOf("Microsoft")!=-1) 
    {
        clearTimeout(resize_timer);
        resize_timer = setTimeout("redirecciona()",500); 
    } 
    else 
    {
    	redirecciona();
    }
}
function objLeft(obj) 
{	
    return parseInt(obj.style.left || obj.offsetLeft);
}
function objTop(obj) 
{
    return parseInt(obj.style.top || obj.offsetTop);
}
function objW(obj) 
{
	return parseInt( obj.style.width || obj.clientWidth );
}
function objH(obj) 
{		
    return parseInt( obj.style.height || obj.clientHeight);    
}
function ini()
{
	window.onresize = function(){redirecciona();}
	redirecciona();
}
function redirecciona(pagina)
{
	//alert('aqui');
	// Margenes de la aplicación de la ventana
    var lMargin  = 15; // LEFT  
    var rMargin  = 15; // RIGHT
    var tMargin  = 10; // TOP
    var bMargin  = 10; // BOTTOM
    var winix = 0, winiy = 0;
    if(typeof( window.innerWidth ) == 'number' ) 
    {
      //Non-IE
      winix = window.innerWidth;
      winiy = window.innerHeight;
    } 
    else if( document.documentElement && ( document.documentElement.clientWidth || document.documentElement.clientHeight ) ) 
    {
      //IE 6+ in 'standards compliant mode'
      winix = document.documentElement.clientWidth;
      winiy = document.documentElement.clientHeight;
    } 
    else if( document.body && ( document.body.clientWidth || document.body.clientHeight ) ) 
    {
      //Compatible con IE 4 
      winix = document.body.clientWidth;
      winiy = document.body.clientHeight;
    }
    var varPag = document.getElementById(pagina);
    var pagH = objH(varPag);
    var pagW  = objW(varPag);
    varPag.style.left= (winix - pagW)/2;
    varPag.style.top = tMargin;
    //varPag.style.bottom = bMargin;
}
function inacnivelpro(valor)
{
	var i=1;
	var combo;
	var aux;
	
	if(valor!=0)
	{
		aux="clave"+i;
		combo=document.getElementById(aux);
		while(combo)
		{
			combo.disabled=true;
			i++;
			aux="clave"+i;
			combo=document.getElementById(aux);
		}
		
	}
	else
	{
		aux="clave"+i;
		combo=document.getElementById(aux);
		while(combo)
		{
			combo.disabled=false;
			i++;
			aux="clave"+i;
			combo=document.getElementById(aux);
		}
	}
}