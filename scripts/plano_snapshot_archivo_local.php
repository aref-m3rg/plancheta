<?php
/**
 * Resuelve el path local de un archivo en snapshots de planos (solo basename, ya validado).
 *
 * @param string $archivoParam nombre de archivo (sin rutas)
 * @return string|false ruta absoluta legible o false
 */
function plano_snapshot_archivo_local_path_validated($archivoParam) {
	if (!defined('PLANOS_SNAPSHOTS_FILESYSTEM_ROOT')) {
		return false;
	}
	$baseDir = rtrim(PLANOS_SNAPSHOTS_FILESYSTEM_ROOT, "/\\");
	$baseReal = @realpath($baseDir);
	if ($baseReal === false || !is_dir($baseReal)) {
		return false;
	}

	$candidate = $baseReal . DIRECTORY_SEPARATOR . $archivoParam;
	$fileReal = @realpath($candidate);
	if ($fileReal === false || !is_file($fileReal)) {
		return false;
	}

	$baseNorm = strtolower(str_replace('/', DIRECTORY_SEPARATOR, rtrim($baseReal, '/\\')) . DIRECTORY_SEPARATOR);
	$fileNorm = strtolower(str_replace('/', DIRECTORY_SEPARATOR, $fileReal));
	if (strpos($fileNorm, $baseNorm) !== 0) {
		return false;
	}

	if (!is_readable($fileReal)) {
		return false;
	}

	return $fileReal;
}
