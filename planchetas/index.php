<?php
if ( isset($_COOKIE['registrado']) && $_COOKIE['registrado'] == "yes") {
	header("location: ./planchetas.php");
} else { 
	header("location: ../login.php"); 
}
?>