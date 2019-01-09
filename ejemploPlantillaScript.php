<?php require_once( $_SERVER['DOCUMENT_ROOT'] . '/ejemplo/_comun/includes/script.php');
//GLOBALES
define('PATH_NAME', dirname($_SERVER['SCRIPT_NAME']));
define('DOMAIN', 'http://www.vuestrodominio.net');
define('URL', DOMAIN . PATH_NAME);
$fileImages = array('pgr.jpg', 'pch.jpg'); //MANTENERLO TAL CUAL ?>
<?php $language = 'es'; ?>
<?php $title = 'SustituirPorElTitulo'; //Título de la página, por ejemplo: "Programación de Robots Lego Mindstorms" en el caso de que fuese el indice o index ?>
<?php $titleLibro = 'DE LOS RELATOS QUE SORPRENDEN A LOS HECHOS QUE INDIGNAN. ACERCAMIENTO A LA HISTORIA CULTURAL DEMOLÓGICA DE CELAYA  '; ?>
<?php $keyWords = ' '; //Palabras clave, por ejemplo: "robots,lego,programación,etc" ?>
<?php $metaDescripcion = ' '; //Descripción del artóculo que se va a publicar. ?>
<?php $type = 'libro-page'; //Hace referencia al tipo de documento, si es tesis doctoral o si es libro. Valores a introducir:
                   //Si es el index del libro: "libro-index"
                   //Si es el índice del libro: "libro-indice"
                   //Si son páginas del libro: "libro-page"
                   //Si es el index de la tesis: "tesisDoctoral-index"
                   //Si es el índice de la tesis: "tesisDoctoral-indice"
                   //Si son páginas de la tesis: "tesisDoctoral-page" 
?>
<?php $file = '430.zip'; //Nombre del fichero comprimido en zip ?>
<?php $isbn = 'ISBN-13: 978-84-691-6571-3 '; //Número de ISBN. NOTA: En caso que no dispongamos de ISBN establecerlo en FALSE ?>
<?php $nRegistro = 'Nº Registro: 08/88742'; //Número de registro. NOTA: En caso que no dispongamos de Número de Registro establecerlo en FALSE?>
<?php $universidad = ' '; ?>
<?php $emailUser = 'riconsoto@hotmail.com'; ?>
<?php $author = '<strong>Ricardo Contreras Soto</strong><br />'; ?>
<?php

  function recopilaDatos($type) {
  global $file, $title, $titleLibro, $fileImages, $isbn, $nRegistro, $universidad, $author, $emailUser;
  $temp = explode("-", $type);
  if ( $temp[1] == 'index' ){
    $fileImage = $fileImages[0];
  } else {
    $fileImage = $fileImages[1];
  }
  ob_start();

?>

  <div class="cabecera<?php echo ucwords($temp[0]); ?>"> <!--INICIO - cabeceraContent  -->

<?php cajaSocial($file, $titleLibro); ?>


	<a href="<?php echo URL . '/#indice' ; ?>" title="<?php echo 'Leer libro ' . ucwords(mb_strtolower($titleLibro)); ?>" target="_self" >
	<img src="<?php echo URL . '/' . $fileImage; ?>"<?php echo ($temp[1] == 'index') ? 'width="300px" height="400"' : 'width="100" height="133"'; ?> alt="<?php echo $titleLibro; ?>" class="<?php echo ucwords($temp[0]) . ucwords($temp[1]); ?>" />
	</a>

	<h1><?php echo mb_strtoupper($titleLibro); ?></h1>
	<span class="autor<?php echo ucwords($temp[0]); ?>"><?php echo $author; ?>

<?php
	if ($temp[1] == 'index') {
	?>
		<?php echo ( $universidad ) ? $universidad . '<br />': ''; ?>
		<a href="mailto:<?php echo strtolower($emailUser); ?>"><?php echo strtolower($emailUser); ?></a></span>
	<p class="isbn-Reg"><?php echo $isbn . '<br />' . $nRegistro; ?></p>

	<h3 style="font-size: 14px;"><a href="<?php echo $file; ?>" title="Descargar Libro <?php echo ucwords(mb_strtolower($titleLibro)); ?> en PDF">Descargar en PDF</a></h3>
	
<?php
	} else {
	?>
	</span> <?php //CIERRE ETIQUETA SPAN DE LA CLASE "autor" ?>
	<p><a href="index.htm#indice" title="Ir al índice de <?php echo ucwords(mb_strtolower($titleLibro)); ?>">Volver al índice</a></p>
<?php
	}
	?>

  
	</div> <!-- FIN -cabecera$temp -->

<?php if ($temp[1] == 'index') { ?>
  <div class="cabeceraSinopsis"> <!-- INICIO - cabeceraSinopsis -->
  </div> <!--FIN - cabeceraSinopsis -->
<?php } ?>
	<div class="cuerpo<?php echo ucwords($temp[1]); ?>">

<!-- Aquí EMPIEZA el contenido -->








<!-- Aquí TERMINA el contenido -->

	</div>

	
  <div class="cabeceraPie"> <!-- INICIO - cabeceraPie -->
<p><a href="index.htm" title="<?php echo $titleLibro; ?>">Volver al índice</a></p>
	<ul>
		<li><a href="http://www.vuestrodominio.net/libros-gratis/" title="Libros gratis">Leer más libros</a></li>
		<li><a href="http://www.vuestrodominio.net/cursecon/libreria/como-publicar.htm" title="¿Cómo publicar?">Soy autor ¿Cómo puedo publicar mi libro?</a></li>
		<li><a href="http://www.vuestrodominio.net" title="Enciclopedia y Biblioteca Virtual de las Ciencias Sociales, Económicas y Jurídicas">Página principal</a></li>
	</ul>

  </div><!-- FIN - cabeceraPie -->

<?php

  $body = ob_get_contents();
  ob_end_clean();

  return $body;
  
  }
?>
<?php 
  $body = recopilaDatos($type);
  generate_HTML($title, $type, $keyWords, $metaDescripcion, $body, $language);

?>
