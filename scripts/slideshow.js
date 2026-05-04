//*************** CONFIGURACIÓN ***************//

//***** Ruta de las fotografías *****//
var _RUTA_FOTOS = "slide_fotos/";	// guarda la ruta (relativa) donde se encuentran las fotografías.
							// Por defecto, slide_fotos

//***** Rutas de las imágenes del slideshow y de las css *****//
var _SLIDE_IMG = "slide_img/";
var _SLIDE_CSS = "slide_css/";

//***** Nombre del campo imagen a utilizar, por defecto *****//
var _SLIDE_NOMBRE_IMG = "_SLIDE_NOMBRE_IMG";

//***** Modos del slide *****//
var _MODO_SLIDE = "normal";	// normal - Solo anterior y siguiente
						// full_mode - Muestra todos los controles

//***** velocidad del slide *****//
var _VELOCIDAD_SLIDE = 1000;	// en milisegundos

//******************* MOTOR *******************//
// constructor
function Slideshow(nombre_objeto)
{
	if(nombre_objeto == null)
	{
		this.nombre_objeto = "mySlide";
	}else{
		this.nombre_objeto = nombre_objeto;
	}
	this.lista_imagenes = new Array(); // lista de imágenes a usar
	this.posicion = 0; // posición de inicio
	// métodos
	this.agregar_imagen = agregar_imagen;
	this.en_marcha = false;
	
	this.siguiente = siguiente;
	this.anterior = anterior;
	this.primera = primera;
	this.ultima = ultima;
	this.auto = auto;
	this.stop = stop;
	
	this.crear_slide = crear_slide;
}

// agregar imagen
// se pueden agragar varias imágenes a la vez, separadas por comas (,)
function agregar_imagen(lista)
{
	for(i = this.lista_imagenes.length; i < agregar_imagen.arguments.length; i++)
	{
		this.lista_imagenes[i] = agregar_imagen.arguments[i];
	}
}

// anterior y siguiente
function siguiente()
{
	this.posicion++;
	if(this.posicion >= this.lista_imagenes.length)
	{
		this.posicion = 0;
	}
	document.getElementById(this.nombre_imagen).src = _RUTA_FOTOS + this.lista_imagenes[this.posicion];
}

function anterior()
{
	this.posicion--;
	if(this.posicion < 0)
	{
		this.posicion = this.lista_imagenes.length - 1;
	}
	document.getElementById(this.nombre_imagen).src = _RUTA_FOTOS + this.lista_imagenes[this.posicion];
}

// primera y última
function primera()
{
	this.posicion = 0;
	document.getElementById(this.nombre_imagen).src = _RUTA_FOTOS + this.lista_imagenes[this.posicion];
}

function ultima()
{
	this.posicion = this.lista_imagenes.length - 1;
	document.getElementById(this.nombre_imagen).src = _RUTA_FOTOS + this.lista_imagenes[this.posicion];
}

// stop y auto
function auto()
{
	this.en_marcha = true;
	if( this.posicion >= this.lista_imagenes.length-1 )
	{
		this.posicion = 0;
	}else{
		this.posicion++;
	}
	document.getElementById(this.nombre_imagen).src = _RUTA_FOTOS + this.lista_imagenes[this.posicion];
	slide_id = setTimeout(this.nombre_objeto + ".auto()", _VELOCIDAD_SLIDE);
}

function stop()
{
	if( this.en_marcha )
		clearTimeout(slide_id);
}
// crear slide
// crea el slide con todos sus comportamientos
function crear_slide()
{
	salida = "";
	salida = "<table border='1' cellspacing='0' cellpadding='0' align='center' width='100%'>";
	salida += "<tr>";
	salida += "<td align='center' valign='middle'";
	if( _MODO_SLIDE == "normal" )
	{
		 salida += " colspan='2'>";
	}else{
		salida += " colspan='6'>";
	}
	if(this.lista_imagenes.length == 0)
	{
		salida += "<b>No hay imagenes</b>";
	}else{
		salida += "<img border='0' id='"+ this.nombre_imagen +"' style='height:150px' src='" + _RUTA_FOTOS + this.lista_imagenes[this.posicion] +"'>";
	}
	salida += "</td>";
	if(this.lista_imagenes.length != 0)
	{
		// si hay imágenes definidas
		salida += "</tr>";
		// botón de primera
		if(_MODO_SLIDE == "full_mode" )
		{
			salida += "<td align='center'>";
			salida += "<a id='primera' href='#' onClick='" + this.nombre_objeto + ".primera(); return false;'><img border='0' title='Primero' src='../iconos/16x16/media-skip-backward.gif'></a>";
			salida +="</td>";
		}
		// botones de anterior y siguiente
		salida += "<td align='center'>";
		salida += "<a id='anterior' href='#' onClick='" + this.nombre_objeto + ".anterior(); return false;'><img border='0' title='Anterior' src='../iconos/16x16/media-seek-backward.gif'></a>";
		salida += "</td>";
		salida += "<td align='center'>";
		salida += "<a id='siguiente' href='#' onClick='" + this.nombre_objeto + ".siguiente(); return false;'><img border='0' title='Siguiente' src='../iconos/16x16/media-seek-forward.gif'></a>";
		salida += "</td>";
		// botón de última
		if(_MODO_SLIDE == "full_mode" )
		{
			salida += "<td align='center'>";
			salida += "<a id='ultima' href='#' onClick='" + this.nombre_objeto + ".ultima(); return false;'><img border='0' title='Última' src='../iconos/16x16/media-skip-forward.gif'></a>";
			salida += "</td>";
		}
		// controles de reproducción automática
		if(_MODO_SLIDE == "full_mode" )
		{
			salida += "<td align='center'>";
			salida += "<a id='auto' href='#' onClick='" + this.nombre_objeto + ".auto();'><img border='0' title='Auto' src='../iconos/16x16/media-playback-start.gif'></a>";
			salida += "</td>";
			
			salida += "<td align='center'>";
			salida += "<a id='stop' href='#' onClick='" + this.nombre_objeto + ".stop();'><img border='0' title='Stop' src='../iconos/16x16/media-playback-pause.gif'></a>";
			salida += "</td>";
		}
		salida += "<tr>";
	}
	salida += "</table>";
	
	document.writeln(salida);
}