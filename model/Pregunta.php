<?php

//file: /model/Pregunta.php

require_once(__DIR__ . "/../core/ValidationException.php");

class Pregunta
{
    private $codPre;
    private $titulo;
    private $texto;
    private $fecha;
    private $etiquetas;
    private $autor;

    /**
     * Pregunta constructor.
     * @param $codPre
     * @param $titulo
     * @param $texto
     * @param $fecha
     * @param $etiquetas
     * @param $autor
     */
    public function __construct($codPre=NULL, $titulo=NULL, $texto=NULL, $fecha=NULL, $etiquetas=NULL, $autor=NULL)
    {
        $this->codPre = $codPre;
        $this->titulo = $titulo;
        $this->texto = $texto;
        $this->fecha = $fecha;
        $this->etiquetas = $etiquetas;
        $this->autor = $autor;
    }

    /**
     * @return mixed
     */
    public function getCodPre()
    {
        return $this->codPre;
    }

    /**
     * @param mixed $codPre
     */
    public function setCodPre($codPre)
    {
        $this->codPre = $codPre;
    }

    /**
     * @return mixed
     */
    public function getTitulo()
    {
        return $this->titulo;
    }

    /**
     * @param mixed $titulo
     */
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;
    }

    /**
     * @return mixed
     */
    public function getTexto()
    {
        return $this->texto;
    }

    /**
     * @param mixed $texto
     */
    public function setTexto($texto)
    {
        $this->texto = $texto;
    }

    /**
     * @return mixed
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * @param mixed $fecha
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
    }

    /**
     * @return mixed
     */
    public function getEtiquetas()
    {
        return $this->etiquetas;
    }

    /**
     * @param mixed $etiquetas
     */
    public function setEtiquetas($etiquetas)
    {
        $this->etiquetas = $etiquetas;
    }

    /**
     * @return mixed
     */
    public function getAutor()
    {
        return $this->autor;
    }

    /**
     * @param mixed $autor
     */
    public function setAutor($autor)
    {
        $this->autor = $autor;
    }

    /**
     * Método para comprobar si el
     * objeto pregunta es
     * válido para el registro
     * en la base de datos
     */

    public function validoParaCrear()
    {
        $errors = array();
        if (strlen($this->titulo) < 1) {
            $errors["titulo"] = "El campo titulo no puede estar vacio";
        }
        if (strlen($this->texto) < 1) {
            $errors["text"] = "El campo texto no puede estar vacio";
        }
        if (sizeof($this->etiquetas) < 1) {
            $errors["etiquetas"] = "El campo etiquetas no puede estar vacio";
        }
        if (sizeof($errors) > 0) {
            throw new ValidationException ($errors, "pregunta no valida");
        }
    }

    /**
     * Método para comprobar si el
     * objeto pregunta es
     * válido para modificarse
     */

    public function validoParaActualizar()
    {
        $errors = array();

        if (!isset($this->codPre)) {
            $errors["codPre"] = "codPre es obligatorio";
        }

        try {
            $this->validoParaCrear();
        } catch (ValidationException $ex) {
            foreach ($ex->getErrors() as $key => $error) {
                $errors[$key] = $error;
            }
        }

        if (sizeof($errors) > 0) {
            throw new ValidationException($errors, "pregunta no valida");
        }
    }

}