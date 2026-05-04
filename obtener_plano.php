<?php
/**
 * Proxy autenticado para servir PDFs de planos sin exponer la ruta real en el cliente.
 * Compatible con PHP 5.6 / 7.x.
 */

session_start();

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'configuracion_general.php';

$authed = false;
if (!empty($_SESSION['user_id'])) {
	$authed = true;
}
if (!$authed && isset($_COOKIE['registrado']) && $_COOKIE['registrado'] === 'yes') {
	$authed = true;
}
if (!$authed) {
	header('HTTP/1.1 403 Forbidden');
	header('Content-Type: text/html; charset=utf-8');
	echo '<!DOCTYPE html><html><head><meta charset="utf-8"><title>Acceso denegado</title></head><body><p>Debe iniciar sesi&oacute;n para ver este documento.</p></body></html>';
	exit;
}

// POST evita que depto/plano aparezcan en la barra de direcciones al abrir en nueva pestaña; GET se mantiene por compatibilidad.
$deptoRaw = '';
$planoRaw = '';
if (isset($_POST['depto']) || isset($_POST['plano'])) {
	$deptoRaw = isset($_POST['depto']) ? $_POST['depto'] : '';
	$planoRaw = isset($_POST['plano']) ? $_POST['plano'] : '';
} else {
	$deptoRaw = isset($_GET['depto']) ? $_GET['depto'] : '';
	$planoRaw = isset($_GET['plano']) ? $_GET['plano'] : '';
}
$depto = basename($deptoRaw);
$planoParam = basename($planoRaw);

if ($depto === '' || $planoParam === '') {
	header('HTTP/1.1 400 Bad Request');
	header('Content-Type: text/html; charset=utf-8');
	echo '<!DOCTYPE html><html><head><meta charset="utf-8"><title>Solicitud incorrecta</title></head><body><p>Faltan par&aacute;metros requeridos.</p></body></html>';
	exit;
}

$allowedDeptos = array();
if (isset($GLOBALS['planosFolders']) && is_array($GLOBALS['planosFolders'])) {
	$allowedDeptos = array_values($GLOBALS['planosFolders']);
}
if (empty($allowedDeptos)) {
	$allowedDeptos = array('ushuaia', 'rio_grande', 'tolhuin');
}
if (!in_array($depto, $allowedDeptos, true)) {
	header('HTTP/1.1 403 Forbidden');
	header('Content-Type: text/html; charset=utf-8');
	echo '<!DOCTYPE html><html><head><meta charset="utf-8"><title>Acceso denegado</title></head><body><p>Solicitud no v&aacute;lida.</p></body></html>';
	exit;
}

if (!preg_match('/^[A-Za-z0-9._-]+$/', $planoParam)) {
	header('HTTP/1.1 400 Bad Request');
	header('Content-Type: text/html; charset=utf-8');
	echo '<!DOCTYPE html><html><head><meta charset="utf-8"><title>Solicitud incorrecta</title></head><body><p>El nombre del documento no es v&aacute;lido.</p></body></html>';
	exit;
}

$baseDir = WWW_ROOT . PLANOS_PATH . DS . $depto;
$baseReal = @realpath($baseDir);
if ($baseReal === false || !is_dir($baseReal)) {
	header('HTTP/1.1 404 Not Found');
	header('Content-Type: text/html; charset=utf-8');
	echo '<!DOCTYPE html><html><head><meta charset="utf-8"><title>No encontrado</title></head><body><p>El documento solicitado no est&aacute; disponible.</p></body></html>';
	exit;
}

$candidate = $baseReal . DS . $planoParam;
$fileReal = false;

if (@is_file($candidate)) {
	$fileReal = @realpath($candidate);
} else {
	$stem = preg_replace('/\.(pdf|PDF)$/', '', $planoParam);
	if ($stem !== '' && preg_match('/^[A-Za-z0-9._-]+$/', $stem)) {
		$matches = @glob($baseReal . DS . $stem . '.pdf');
		if (!$matches || count($matches) === 0) {
			$matches = @glob($baseReal . DS . $stem . '.PDF');
		}
		if ($matches && count($matches) === 1) {
			$fileReal = @realpath($matches[0]);
		}
	}
}

if ($fileReal === false || !is_file($fileReal)) {
	header('HTTP/1.1 404 Not Found');
	header('Content-Type: text/html; charset=utf-8');
	echo '<!DOCTYPE html><html><head><meta charset="utf-8"><title>No encontrado</title></head><body><p>El documento solicitado no existe o ya no est&aacute; disponible.</p></body></html>';
	exit;
}

$baseNorm = strtolower(str_replace('/', DS, rtrim($baseReal, '/\\')) . DS);
$fileNorm = strtolower(str_replace('/', DS, $fileReal));
if (strpos($fileNorm, $baseNorm) !== 0) {
	header('HTTP/1.1 404 Not Found');
	header('Content-Type: text/html; charset=utf-8');
	echo '<!DOCTYPE html><html><head><meta charset="utf-8"><title>No encontrado</title></head><body><p>El documento solicitado no est&aacute; disponible.</p></body></html>';
	exit;
}

if (!is_readable($fileReal)) {
	header('HTTP/1.1 403 Forbidden');
	header('Content-Type: text/html; charset=utf-8');
	echo '<!DOCTYPE html><html><head><meta charset="utf-8"><title>Acceso denegado</title></head><body><p>No se puede leer el documento.</p></body></html>';
	exit;
}

$dispName = basename($fileReal);
$dispName = str_replace(array("\r", "\n", '"'), '', $dispName);

header('Content-Type: application/pdf');
header('Content-Disposition: inline; filename="' . $dispName . '"');
header('Content-Length: ' . (string) filesize($fileReal));
readfile($fileReal);
exit;
