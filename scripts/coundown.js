var tiempo = 30;
function cuentaRegresiva(){
	if (tiempo > 0){tiempo--;}
	else{tiempo=30;DrawCaptcha();}
	document.getElementById("countdown").value=tiempo;
	setTimeout("cuentaRegresiva()",1000);
}