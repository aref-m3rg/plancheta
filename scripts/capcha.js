var valor;
function DrawCaptcha(){
	var a = Math.ceil(Math.random() * 10)+ '';
	var b = Math.ceil(Math.random() * 10)+ '';       
	var c = Math.ceil(Math.random() * 10)+ '';  
	valor = a + b + c;
	document.getElementById("txtCaptcha").value = ' ' + a + ' ' + b + ' ' + ' ' + c + ' ';
}

function ValidCaptcha(){
	var str1 = document.getElementById('txtCaptcha').value;
	var str2 = document.getElementById('txtInputCaptcha').value;
	if (valor === str2) return true;        
	return false;
}