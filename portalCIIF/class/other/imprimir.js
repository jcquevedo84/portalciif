function printPage() {
	if (window.print) {
		agree = confirm('�Quieres imprimir la p�gina?');
		if (agree) window.print(); 
   	}
}