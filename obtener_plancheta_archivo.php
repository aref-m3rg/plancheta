<?php
/**
 * Proxy autenticado para servir imágenes de planchetas (JPG/PNG/GIF) sin exponer URL estática a /planchetas/archivos/.
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
	echo '<!DOCTYPE html><html><head><meta charset="utf-8"><title>Acceso denegado</title></head><body><p>Debe iniciar sesi&oacute;n para ver este archivo.</p></body></html>';
	exit;
}

$archivoRaw = '';
if (isset($_POST['archivo'])) {
	$archivoRaw = $_POST['archivo'];
} elseif (isset($_GET['archivo'])) {
	$archivoRaw = $_GET['archivo'];
}

$archivoParam = basename($archivoRaw);

if ($archivoParam === '') {
	header('HTTP/1.1 400 Bad Request');
	header('Content-Type: text/html; charset=utf-8');
	echo '<!DOCTYPE html><html><head><meta charset="utf-8"><title>Solicitud incorrecta</title></head><body><p>Falta el par&aacute;metro requerido.</p></body></html>';
	exit;
}

if (!preg_match('/^[A-Za-z0-9._-]+\.(jpe?g|png|gif)$/i', $archivoParam)) {
	header('HTTP/1.1 400 Bad Request');
	header('Content-Type: text/html; charset=utf-8');
	echo '<!DOCTYPE html><html><head><meta charset="utf-8"><title>Solicitud incorrecta</title></head><body><p>El nombre del archivo no es v&aacute;lido.</p></body></html>';
	exit;
}

$baseDir = rtrim(WWW_ROOT, "/\\") . str_replace('/', DIRECTORY_SEPARATOR, PLANCHETAS_PATH);
$baseReal = @realpath($baseDir);
if ($baseReal === false || !is_dir($baseReal)) {
	header('HTTP/1.1 404 Not Found');
	header('Content-Type: text/html; charset=utf-8');
	echo '<!DOCTYPE html><html><head><meta charset="utf-8"><title>No encontrado</title></head><body><p>El recurso solicitado no est&aacute; disponible.</p></body></html>';
	exit;
}

$candidate = $baseReal . DIRECTORY_SEPARATOR . $archivoParam;
$fileReal = @realpath($candidate);

if ($fileReal === false || !is_file($fileReal)) {
	header('HTTP/1.1 404 Not Found');
	header('Content-Type: text/html; charset=utf-8');
	echo '<!DOCTYPE html><html><head><meta charset="utf-8"><title>No encontrado</title></head><body><p>El archivo solicitado no existe o ya no est&aacute; disponible.</p></body></html>';
	exit;
}

$baseNorm = strtolower(str_replace('/', DIRECTORY_SEPARATOR, rtrim($baseReal, '/\\')) . DIRECTORY_SEPARATOR);
$fileNorm = strtolower(str_replace('/', DIRECTORY_SEPARATOR, $fileReal));
if (strpos($fileNorm, $baseNorm) !== 0) {
	header('HTTP/1.1 404 Not Found');
	header('Content-Type: text/html; charset=utf-8');
	echo '<!DOCTYPE html><html><head><meta charset="utf-8"><title>No encontrado</title></head><body><p>El recurso solicitado no est&aacute; disponible.</p></body></html>';
	exit;
}

if (!is_readable($fileReal)) {
	header('HTTP/1.1 403 Forbidden');
	header('Content-Type: text/html; charset=utf-8');
	echo '<!DOCTYPE html><html><head><meta charset="utf-8"><title>Acceso denegado</title></head><body><p>No se puede leer el archivo.</p></body></html>';
	exit;
}

$ext = strtolower(pathinfo($fileReal, PATHINFO_EXTENSION));
$mime = 'application/octet-stream';
if ($ext === 'jpg' || $ext === 'jpeg') {
	$mime = 'image/jpeg';
} elseif ($ext === 'png') {
	$mime = 'image/png';
} elseif ($ext === 'gif') {
	$mime = 'image/gif';
}

$dispName = basename($fileReal);
$dispName = str_replace(array("\r", "\n", '"'), '', $dispName);

header('Content-Type: ' . $mime);
header('Content-Disposition: inline; filename="' . $dispName . '"');
header('Content-Length: ' . (string) filesize($fileReal));
readfile($fileReal);
exit;
