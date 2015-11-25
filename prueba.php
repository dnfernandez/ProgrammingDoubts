<?php

require_once(__DIR__ . "./model/Usuario.php");
require_once(__DIR__ . "./model/UsuarioMapper.php");
require_once(__DIR__ . "./model/Pregunta.php");
require_once(__DIR__ . "./model/PreguntaMapper.php");
require_once(__DIR__ . "./model/Respuesta.php");
require_once(__DIR__ . "./model/RespuestaMapper.php");


$respuesta=new Respuesta();
$respuestaMapper= new RespuestaMapper();
$codigo = $respuestaMapper->ultimoCodRes("1");

/*foreach ($codigo as $cod){
	echo $cod["maximo"];
	echo "<br>";
	$codigoRes = $cod["maximo"] + 1;
	echo $codigoRes;
	echo "<br>";
}*/
echo $codigo[0];
if($respuestaMapper->existeRespuesta(1,1)){
	echo " respuesta insertada<br>";
}

/*$usuario = new Usuario("yamalingre","yaiza","abc123.");
$usuarioMapper = new UsuarioMapper();

if($usuarioMapper->comprobarUsuario($usuario->getUsuario(), $usuario->getContrasenha())){
	echo "Valido <br>";
}

$usuario = new Usuario("yamalingre","yaizaam","abc123..");
$usuarioMapper->actualizar($usuario);

$pregunta = new Pregunta("100","Titulo","Texto","2012-10-25","Html","yamalingre");
$preguntaMapper = new PreguntaMapper();

if(!$preguntaMapper->existePregunta($pregunta->getCodPre())){
	$preguntaMapper->insertar($pregunta);
	echo "pregunta insertada<br>";
}*/

/*if($preguntaMapper->existePregunta($pregunta->getCodPre())){
	$pregunta = new Pregunta("100","Titulo","Otra cosa","2012-10-25","Html","yamalingre");
	$preguntaMapper->actualizar($pregunta);
	echo "pregunta modificada<br>";
}

if($preguntaMapper->existePregunta($pregunta->getCodPre())){
	$preguntaMapper->eliminar($pregunta);
	echo "pregunta eliminada<br>";
}*/
/*$posts = $preguntaMapper->listarPreguntas("Otr");
foreach ($posts as $post) {
	$date = new DateTime($post["fecha"]);
	echo $post["codPre"]."	".$post["titulo"] ."	". $post["texto"] ."	". $date->format('d-m-Y') ."	". $post["etiquetas"] ."	". $post["autor"] ." ". $post[6]. "<br>";
}*/

/*$posts = $preguntaMapper->listarPreguntasAutor($usuario->getUsuario());
foreach ($posts as $post) {
	$date = new DateTime($post["fecha"]);
	echo $post["codPre"]."	". $post["contador"] . "<br>";
}*/

/*$posts = $preguntaMapper->listarPreguntasEtiqueta("C++");
foreach ($posts as $post) {
	$date = new DateTime($post["fecha"]);
	echo $post["codPre"]."	este ". $post[6] . "<br>";
}*/

/*
$posts = $preguntaMapper->listarPreguntaCod($pregunta->getCodPre());
foreach ($posts as $post) {
	$date = new DateTime($post["fecha"]);
	//echo $post["codPre"]."	".$post["titulo"] ."	". $post["texto"] ."	". $date->format('d-m-Y') ."	". $post["etiquetas"] ."	". $post["autor"] . "<br>";
	echo $post[1]."<br>";
}*/


/*$posts = $preguntaMapper->listarComentarios($pregunta->getCodPre());
foreach ($posts as $post) {
	$date = new DateTime($post["fecha"]);
	echo $post["codPre"]."	".$post["codRes"] ."	". $post["texto"] ."	". $date->format('d-m-Y') ."	". $post["autor"] ."	". $post["likesPos"] . "	". $post["likesNeg"]."<br>";
}*/

/*$posts = $preguntaMapper->contarRespuestas($pregunta->getCodPre());
echo $posts[0];*/

/*$respuesta = new Respuesta("100","102","Esto es","2015-02-25","dnfernandez","20","3");
$respuestaMapper = new RespuestaMapper();

if(!$respuestaMapper->existeRespuesta($respuesta->getCodPre(),$respuesta->getCodRes())){
	$respuestaMapper->insertar($respuesta);
	echo "respuesta insertada<br>";
}

$respuestaMapper->sumarLikesPos($respuesta->getCodPre(), $respuesta->getCodRes());
$respuestaMapper->sumarLikesNeg($respuesta->getCodPre(), $respuesta->getCodRes());


echo 'Hola '.$usuario->getNombre().' bonita<br>';
$etiqTot=$preguntaMapper->listarEtiquetasTotales();
$etiq=explode(',',$etiqTot);
for($j=0; $j<substr_count($etiqTot,',')+1;$j++){
	echo '<li><a href="index.php?accionEtiq='.$etiq[$j].'" class="nav_li">';
		echo $etiq[$j];
	echo '</a></li>';

}

$posts = $preguntaMapper->ultimoCodPre();
echo $posts[0];

$fecha=getdate();
$fechaMaq=$fecha['year']."-".$fecha['mon']."-".$fecha['mday'];
echo "<br>".$fechaMaq;

$pregunta = new Pregunta();
/*$codigo=$preguntaMapper->ultimoCodPre();
            $codigoPre=$codigo[0]+1;
            $fecha=getdate();
            $fechaMaq=$fecha['year']."-".$fecha['mon']."-".$fecha['mday'];
            $pregunta->setCodPre($codigoPre);
            $pregunta->setTitulo("Este ese aqul");
            $pregunta->setTexto("Fanfan");
            $pregunta->setFecha($fechaMaq);
            $etiquetasMaq="Html, CSS, PHP";
            foreach ( $_POST["etiquetas"] as $etiq ) {
                $etiquetasMaq.=$etiq.",";
            }
            $pregunta->setEtiquetas($etiquetasMaq);
            $pregunta->setAutor("dnfernandez");
*/
//$pregunta = new Pregunta("103","Titulo sa","Texto sa","2012-10-25","Html","dnfernandez");

/*$codigo=$preguntaMapper->ultimoCodPre();
            $codigoPre=$codigo[0]+1;
            $fecha=getdate();
            $fechaMaq=$fecha['year']."-".$fecha['mon']."-".$fecha['mday'];
            $pregunta->setCodPre($codigoPre);
			$pregunta->setTitulo("Este ese aqul");
            $pregunta->setTexto("Fanfan");
            $pregunta->setFecha($fechaMaq);
			$pregunta->setEtiquetas("Html,C++");
            $pregunta->setAutor("dnfernandez");
				
if(!$preguntaMapper->existePregunta($pregunta->getCodPre())){
	$preguntaMapper->insertar($pregunta);
	echo "pregunta insertada<br>";
}*/

			
//$respuesta = new Respuesta("100","100","tanto da","2015-02-25","dnfernandez","20","3");
//$respuestaMapper = new RespuestaMapper();

//$respuestaMapper->comprobarVoto($respuesta->getCodPre(),$respuesta->getCodRes(),$respuesta->getAutor(),'likesPos');
//$respuestaMapper->comprobarVoto($respuesta->getCodPre(),$respuesta->getCodRes(),"donicosio",'likesNeg');



