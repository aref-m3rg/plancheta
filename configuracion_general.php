<?php
/*
 * Configuraciones para el proyecto Catastro TDF
 */

/* Notificaciones
----------------------------------------------------------------------------- */
define( 'NOTIFICATIONS_EMAIL', 'alertas@divisiongis.com');
define( 'NOTIFICATIONS_FROM_EMAIL', 'no-reply@divisiongis.com');
define( 'NOTIFICATIONS_FROM_NAME', 'Requerimientos Catastro TDF');
define( 'NOTIFICATIONS_SMTP_HOST', 'mail.divisiongis.com');
define( 'NOTIFICATIONS_SMTP_USER', 'notificaciones@divisiongis.com');
define( 'NOTIFICATIONS_SMTP_PASSWORD', 'GTOYLzkMlTWP4LTjjb4B');

define( 'NOTIFICATIONS_TDF_FROM_EMAIL', 'catastro@tierradelfuego.gov.ar');
define( 'NOTIFICATIONS_TDF_FROM_NAME', 'Direccion General de Catastro TDF');
define( 'NOTIFICATIONS_TDF_SMTP_HOST', 'mail.tierradelfuego.gov.ar');
define( 'NOTIFICATIONS_TDF_SMTP_USER', 'catastrotdf');
define( 'NOTIFICATIONS_TDF_SMTP_PASSWORD', 'Tdf36002');

/* Filesystem
----------------------------------------------------------------------------- */
// Carpeta root del proyecto
define( 'WWW_ROOT', 'C:\inetpub\wwwroot\catastro_tdf' );
define( 'BASE_URL', 'https://catastro.aref.gob.ar/catastro_tdf' );
// Alias para el separador de directorios del sistemas
define( 'DS', DIRECTORY_SEPARATOR );


/* Planchetas
----------------------------------------------------------------------------- */
// Archivos de imagen en disco (idealmente fuera del document root; lectura vía obtener_plancheta_archivo.php)
define( 'PLANCHETAS_FILESYSTEM_ROOT', 'C:\inetpub\catastro_tdf\planchetas\archivos' );
// Ruta bajo el sitio (referencia histórica / enlaces legacy)
define( 'PLANCHETAS_PATH', '/planchetas/archivos' );
define( 'PLANCHETAS_PATH_URL', 'https://catastro.aref.gob.ar/catastro_tdf/planchetas/archivos' );


/* Planos
----------------------------------------------------------------------------- */
// Planos escaneados en disco (fuera del document root; lectura vía obtener_plano.php)
define('PLANOS_NUEVOS_FILESYSTEM_ROOT', 'C:\inetpub\catastro_tdf\tecnica\planos_nuevos');
// Ruta bajo el sitio (referencia histórica / URLs relativas al dominio)
define('PLANOS_PATH', '/tecnica/planos_nuevos');
// Adjuntos de plano en disco (fuera del document root; lectura vía obtener_plano_adjunto.php)
define('PLANOS_ATTACHED_FILESYSTEM_ROOT', 'C:\inetpub\catastro_tdf\tecnica\planos');
define('PLANOS_ATTACHED_PATH', '/tecnica/planos');
// Snapshots de planos en disco (fuera del document root; lectura vía obtener_plano_snapshot.php)
define('PLANOS_SNAPSHOTS_FILESYSTEM_ROOT', 'C:\inetpub\catastro_tdf\tecnica\planos_snapshots');
define('PLANOS_SNAPSHOTS_PATH', '/tecnica/planos_snapshots');

// Nombres de las carpetas que contienen los planos por departamento
$GLOBALS['planosFolders'] = array( 1 => 'ushuaia', 2 => 'rio_grande', 3 => 'tolhuin' );


/* ArcGIS
----------------------------------------------------------------------------- */
define('ARCGIS_VERSION', 10);
