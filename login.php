<?php
// forzar respuesta UTF-8 al menos para esta página
header('Content-Type: text/html; charset=utf-8');

if (isset($_POST['enviar']) && ($_POST['enviar'] == "Iniciar sesión") ) {

	$cnx = mysql_connect('localhost', 'blog', 'qweasd') or die ('Ha fallado la conexi&oacute;n: '.mysql_error());
	mysql_select_db('blog', $cnx) or die ('Error al seleccionar la Base de Datos: '.mysql_error());

	$result = mysql_query('SELECT * FROM users WHERE user=\''.$_POST['log'].'\'');
    if($row = mysql_fetch_array($result)){
        if( $row['pass'] == $_POST['pwd'] ){		
			setcookie("registrado","yes"); //expira en 60 minutos
			//setcookie("registrado","yes",time()+36000); //expira en 60 minutos
			session_start();
			$_SESSION["user_id"]=$row['id'];
			$_SESSION["user_name"]=$row['name'];
			$_SESSION["institute_id"]=$row['institute_id'];
			header("location: planchetas/");
		} 			
	}
	//mysql_free_result($cnx);
	mysql_close();	
} 
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html dir="ltr" xmlns="http://www.w3.org/1999/xhtml" lang="es-ES"><head>
	<title>Dirección General de Catastro › Iniciar sesión</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<link rel="stylesheet" href="login.css" type="text/css" media="all">
<link rel="stylesheet" href="colors-fresh.css" type="text/css" media="all">
</head><body class="login">
<!-- ñoñada á -->
<div id="login">

<form name="loginform" id="loginform" method="post">
	<p>
		<label>Nombre de usuario<br>
		<input name="log" id="user_login" class="input" value="" size="20" tabindex="10" type="text"></label>
	</p>
	<p>
		<label>Contraseña<br>
		<input name="pwd" id="user_pass" class="input" value="" size="20" tabindex="20" type="password"></label>
	</p>
	<p class="submit">
		<input name="enviar" id="enviar" value="Iniciar sesión" tabindex="100" type="submit">
		<input name="testcookie" value="1" type="hidden">
	</p>
	<p>
		<label><font size="1"> </font><br>
	</p>
	<p>
		<label><font size="1"> </font><br>
	</p>	
	<p>
		<!--<label><font size="1" color="red"><b>*Sesión caduca en 30 minutos despues de iniciar</b></font><br>-->
	</p>
	<p>
		<label><font size="2" color="#000000">De requerir acceso, enviar pedido<br>por correo a la dirección: catastrotdf@aref.gob.ar<br>Con asunto: PLANCHETA ONLINE</font>
	</p>
	<p>
		<label><font size="1"> </font><br>
	</p>	
</form>

</div>

<p id="backtoblog"><a href="http://economia.tierradelfuego.gov.ar/catastro-2/" title="¿Te has perdido?"><b>&#8592;Volver a Gerencia de Catastro Provincial</b></a></p>

<script type="text/javascript">
try{document.getElementById('user_login').focus();}catch(e){}
</script>
</body></html>