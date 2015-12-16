<?php

require_once(__DIR__ . "/../model/Pregunta.php");
require_once(__DIR__ . "/../model/PreguntaMapper.php");
require_once(__DIR__ . "/../model/Respuesta.php");
require_once(__DIR__ . "/../model/RespuestaMapper.php");
require_once(__DIR__ . "/../model/Usuario.php");

require_once(__DIR__ . "/../core/ViewManager.php");
require_once(__DIR__ . "/../controller/BaseController.php");

class RespuestaController extends BaseController
{

    private $respuestaMapper;
    private $preguntaMapper;

    public function __construct()
    {
        parent::__construct();
        $this->respuestaMapper = new RespuestaMapper();
        $this->preguntaMapper = new PreguntaMapper();
    }

    /**
     * Accion de crear una respuesta a una pregunta
     */

    public function crear()
    {
        if (!isset($this->currentUser)) {
            throw new Exception("Se requiere login para responder");
        } else {

            if (isset($_POST["codPre"])) {
                $codPregunta=$_POST["codPre"];
                $pregunta = $this->preguntaMapper->existePregunta($codPregunta);

                if($pregunta!=true){
                    throw new Exception("no existe pregunta con id: ".$codPregunta);
                }

                $respuesta=new Respuesta();
                $codigo = $this->respuestaMapper->ultimoCodRes($codPregunta);
                $codigoRes = $codigo[0] + 1;
                $fecha = getdate();
                $fechaMaq = $fecha['year'] . "-" . $fecha['mon'] . "-" . $fecha['mday'];
                $respuesta->setCodPre($codPregunta);
                $respuesta->setCodRes($codigoRes);
                $respuesta->setTexto($_POST["texto"]);
                $respuesta->setFecha($fechaMaq);
                $respuesta->setAutor($this->currentUser->getUsuario());
                $respuesta->setLikesPos("0");
                $respuesta->setLikesNeg("0");

                try{
                    $respuesta->validoParaCrear();
                    $this->respuestaMapper->insertar($respuesta);
                    $this->view->redirect("pregunta", "verPregunta","codPre=".$codPregunta);
                }catch (ValidationException $ex){
                    $errors = $ex->getErrors();
                    $this->view->setVariable("pregunta", $pregunta, true);
                    $this->view->setVariable("errors", $errors, true);
                    $this->view->redirect("pregunta", "verPregunta","codPre=".$codPregunta);
                }
            }
            else {
                throw new Exception("No existe el codPre");
            }
        }
    }

    /**
     * Accion de crear un comentario a una respuesta de una pregunta
     */

    public function crearComentario()
    {
        if (!isset($this->currentUser)) {
            throw new Exception("Se requiere login para responder");
        } else {

            if (isset($_POST["codPre"]) && isset($_POST["codRes"])) {
                $codPregunta=$_POST["codPre"];
                $codRespuesta=$_POST["codRes"];
                $autor=$_POST["autor"];
                $texto=$_POST["texto"];

                try{
                    if(!$this->preguntaMapper->existePregunta($codPregunta) || !$this->respuestaMapper->existeRespuesta($codPregunta, $codRespuesta) || !isset($autor) || !isset($texto)){
                        throw new Exception("Faltan datos");
                    }
                    $this->respuestaMapper->insertarComentarioRespuesta($codPregunta, $codRespuesta,$autor, $texto);
                    $this->view->redirect("pregunta", "verPregunta","codPre=".$codPregunta."#".($codRespuesta-1));
                }catch (ValidationException $ex){
                    $errors = $ex->getErrors();
                    $this->view->setVariable("errors", $errors, true);
                    $this->view->redirect("pregunta", "verPregunta","codPre=".$codPregunta."#".($codRespuesta-1));
                }
            }
            else {
                throw new Exception("No existe el codPre o codRes");
            }
        }
    }

    public function votar(){
        if (!isset($this->currentUser)) {
            $this->view->setFlash(i18n("Se requiere login para votar"));  
            $contador=$_POST["cont"];
            $this->view->setVariable("contadorError",$contador,true);
            $this->view->redirect("pregunta", "verPregunta","codPre=".$_POST["codPre"]."#".($_POST["codRes"]-1));
        } else {
            if (isset($_POST["codPre"]) && isset($_POST["codRes"])) {
                $contador=$_POST["cont"];
                $codigoPre=$_POST["codPre"];
                $codigoRes=$_POST["codRes"];
                $usuario=$this->currentUser->getUsuario();;
                $tipo=$_POST["tipo"];
                try{
                    $this->respuestaMapper->comprobarVoto($codigoPre,$codigoRes,$usuario,$tipo);
                    $this->view->redirect("pregunta", "verPregunta","codPre=".$codigoPre."#".($codigoRes-1));
                }catch (ValidationException $ex){
                    $errors = $ex->getErrors();
                    //$this->view->setVariable("pregunta", $pregunta, true);
                    $this->view->setVariable("errors", $errors, true);
                    $this->view->setVariable("contadorError",$contador,true);
                    $this->view->redirect("pregunta", "verPregunta","codPre=".$codigoPre."#".($codigoRes-1));
                }
            }
        }
    }
}