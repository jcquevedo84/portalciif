function printPage() {
	if (window.print) {
		agree = confirm('¿Quieres imprimir la página?');
		if (agree) window.print(); 
   	}
}