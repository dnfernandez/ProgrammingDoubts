<?php

require_once(__DIR__ . "/../model/Pregunta.php");
require_once(__DIR__ . "/../model/PreguntaMapper.php");
require_once(__DIR__ . "/../model/Respuesta.php");
require_once(__DIR__ . "/../model/Usuario.php");

require_once(__DIR__ . "/../core/ViewManager.php");
require_once(__DIR__ . "/../controller/BaseController.php");

class PreguntaController extends BaseController
{

    private $preguntaMapper;

    public function __construct()
    {
        parent::__construct();

        $this->preguntaMapper = new PreguntaMapper();
    }

    /**
     * Accion de listar todas las preguntas en la pantalla de inicio
     */
    public function index()
    {
        if (isset($_POST['busqueda'])) {
            $texto = $_POST['busqueda'];
            $preguntas = $this->preguntaMapper->listarPreguntas($texto);
        } else {
            $preguntas = $this->preguntaMapper->listarPreguntas();
        }
        $this->view->setVariable("preguntas", $preguntas);

        //Mandamos todas las etiquetas para poder visualizarlas
        $etiqTot = $this->preguntaMapper->listarEtiquetasTotales();
        $this->view->setVariable("etiqTot", $etiqTot);

        //Creamos la vista
        $this->view->render("inicio");
    }

    /**
     * Accion de listar todas las preguntas en la pantalla de inicio
     * referentes a una etiqueta
     */
    public function listarXEtiq()
    {
        $etiq = $_GET["accionEtiq"];

        $preguntas = $this->preguntaMapper->listarPreguntasEtiqueta($etiq);
        $this->view->setVariable("preguntas", $preguntas);

        //Mandamos todas las etiquetas para poder visualizarlas
        $etiqTot = $this->preguntaMapper->listarEtiquetasTotales();
        $this->view->setVariable("etiqTot", $etiqTot);

        //Creamos la vista
        $this->view->render("inicio");
    }

    /**
     * Accion de listar todas las preguntas en la pantalla de inicio
     * referentes a un autor
     */
    public function listarXAutor()
    {
        $autor = $this->currentUser->getUsuario();

        $preguntas = $this->preguntaMapper->listarPreguntasAutor($autor);
        $this->view->setVariable("preguntas", $preguntas);

        //Mandamos todas las etiquetas para poder visualizarlas
        $etiqTot = $this->preguntaMapper->listarEtiquetasTotales();
        $this->view->setVariable("etiqTot", $etiqTot);
        $estado = true;
        $this->view->setVariable("autorMispreguntas", $estado);

        //Creamos la vista
        $this->view->render("inicio");
    }

    /**
     * @throws Exception
     * Accion de ver todas las respuestas de una pregunta concreta
     */

    public function verPregunta()
    {
        if (!isset($_GET["codPre"])) {
            throw new Exception("codPre es obligatorio");
        }
        $codPregunta = $_GET["codPre"];

        $pregunta = $this->preguntaMapper->listarPreguntaCod($codPregunta);
        $preguntaRes = $this->preguntaMapper->listarComentarios($codPregunta);

        if ($pregunta == NULL) {
            throw new Exception("No existe pregunta con codPre " . $codPregunta . header("Location: index.php"));
        }

        //Mandamos todas las etiquetas para poder visualizarlas
        $etiqTot = $this->preguntaMapper->listarEtiquetasTotales();
        $this->view->setVariable("etiqTot", $etiqTot);

        //Indicamos si la vista va ser de respuestas para poder cambiar el boton de formular pregunta
        //$this->view->setFlash("respuestas");
        $this->view->setNombreVista("respuestas");

        //Mandamos la pregunta y sus respuestas
        $this->view->setVariable("pregunta", $pregunta);
        $this->view->setVariable("preguntaRes", $preguntaRes);

        //Creamos la vista
        $this->view->render("respuestas");

    }

    /**
     * Accion de crear nueva pregunta
     */

    public function crear()
    {
        if (!isset($this->currentUser)) {
            throw new Exception("Se requiere login para preguntar");
        } else {

            $pregunta = new Pregunta();
            if (isset($_POST["submitCrear"]) && isset($_POST["titulo"]) && isset($_POST["etiquetas"])) {
                $codigo = $this->preguntaMapper->ultimoCodPre();
                $codigoPre = $codigo[0] + 1;
                $fecha = getdate();
                $fechaMaq = $fecha['year'] . "-" . $fecha['mon'] . "-" . $fecha['mday'];
                $pregunta->setCodPre($codigoPre);
                $pregunta->setTitulo($_POST["titulo"]);
                $pregunta->setTexto($_POST["texto"]);
                $pregunta->setFecha($fechaMaq);
                $etiquetasMaq = "";
                $tamaño = sizeof($_POST["etiquetas"]);
                $cont = 0;
                foreach ($_POST["etiquetas"] as $etiq) {
                    $etiquetasMaq .= $etiq;
                    $cont++;
                    if ($cont < $tamaño) $etiquetasMaq .= ",";
                }
                $pregunta->setEtiquetas($etiquetasMaq);
                $pregunta->setAutor($this->currentUser->getUsuario());

                try {
                    $pregunta->validoParaCrear();
                    $this->preguntaMapper->insertar($pregunta);
                    $this->view->redirect("pregunta", "index");
                } catch (ValidationException $ex) {
                    $errors = $ex->getErrors();
                    $this->view->setVariable("errors", $errors);
                }
            }else{
				echo "Upss! no deberías estar aquí";
				echo "<br>Redireccionando...";
				header("Refresh: 5; index.php?controller=pregunta&action=index");
			}
        }
    }

    public function edicion()
    {
        if (isset($_POST["accion"]) && isset($_POST["codPre"])) {
            $codigoPre = $_POST["codPre"];
            if ($_POST["accion"] == "borrar") {
                try {
                    $this->preguntaMapper->eliminar($codigoPre);
                    $this->view->redirect("pregunta", "listarXAutor");
                } catch (ValidationException $ex) {
                    $errors = $ex->getErrors();
                    $this->view->setVariable("errors", $errors);
                }
            }
            if ($_POST["accion"] == "modificar") {
				if(isset($_POST["etiquetas"]) && isset($_POST["titulo"])){
					$pregunta = new Pregunta();
					$fecha = getdate();
					$fechaMaq = $fecha['year'] . "-" . $fecha['mon'] . "-" . $fecha['mday'];
					$pregunta->setCodPre($codigoPre);
					$pregunta->setTitulo($_POST["titulo"]);
					$pregunta->setTexto($_POST["texto"]);
					$pregunta->setFecha($fechaMaq);
					$etiquetasMaq = "";
					$tamaño = sizeof($_POST["etiquetas"]);
					$cont = 0;
					foreach ($_POST["etiquetas"] as $etiq) {
						$etiquetasMaq .= $etiq;
						$cont++;
						if ($cont < $tamaño) $etiquetasMaq .= ",";
					}
					$pregunta->setEtiquetas($etiquetasMaq);
					$pregunta->setAutor($this->view->getVariable("currentusername"));
					try {
						$pregunta->validoParaActualizar();
						$this->preguntaMapper->actualizar($pregunta);
						$this->view->redirect("pregunta", "listarXAutor");
					} catch (ValidationException $ex) {
						$errors = $ex->getErrors();
						$this->view->setVariable("errors", $errors);
					}
				}else{
					echo "Upss! no deberías estar aquí";
					echo "<br>Redireccionando...";
					header("Refresh: 5; index.php?controller=pregunta&action=index");
				}
            }
        } else{
				echo "Upss! no deberías estar aquí";
				echo "<br>Redireccionando...";
				header("Refresh: 5; index.php?controller=pregunta&action=index");
		}
    }

}