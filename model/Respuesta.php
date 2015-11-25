<?php

//file: /model/Respuesta.php

require_once(__DIR__ . "/../core/ValidationException.php");

class Respuesta
{
    private $codPre;
    private $codRes;
    private $texto;
    private $fecha;
    private $autor;
    private $likesPos;
    private $likesNeg;

    /**
     * Respuesta constructor.
     * @param $codPre
     * @param $codRes
     * @param $texto
     * @param $fecha
     * @param $autor
     * @param $likesPos
     * @param $likesNeg
     */
    public function __construct($codPre=NULL, $codRes=NULL, $texto=NULL, $fecha=NULL, $autor=NULL, $likesPos=NULL, $likesNeg=NULL)
    {
        $this->codPre = $codPre;
        $this->codRes = $codRes;
        $this->texto = $texto;
        $this->fecha = $fecha;
        $this->autor = $autor;
        $this->likesPos = $likesPos;
        $this->likesNeg = $likesNeg;
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
    public function getCodRes()
    {
        return $this->codRes;
    }

    /**
     * @param mixed $codRes
     */
    public function setCodRes($codRes)
    {
        $this->codRes = $codRes;
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
     * @return mixed
     */
    public function getLikesPos()
    {
        return $this->likesPos;
    }

    /**
     * @param mixed $likesPos
     */
    public function setLikesPos($likesPos)
    {
        $this->likesPos = $likesPos;
    }

    /**
     * @return mixed
     */
    public function getLikesNeg()
    {
        return $this->likesNeg;
    }

    /**
     * @param mixed $likesNeg
     */
    public function setLikesNeg($likesNeg)
    {
        $this->likesNeg = $likesNeg;
    }

    /**
     * Método para comprobar si el
     * objeto repuesta es
     * válido para el registro
     * en la base de datos
     */

    public function validoParaCrear()
    {
        $errors = array();
        if (strlen($this->texto) < 1) {
            $errors["text"] = "El campo texto no puede estar vacio";
        }
        if (sizeof($errors) > 0) {
            throw new ValidationException ($errors, "pregunta no valida");
        }
    }

    /**
     * Método para comprobar si el
     * objeto respuesta es
     * válido para modificarse
     */

    public function validoParaActualizar()
    {
        $errors = array();

        if (!isset($this->codPre)) {
            $errors["codPre"] = "codPre es obligatorio";
        }

        if (!isset($this->codRes)) {
            $errors["codRes"] = "codRes es obligatorio";
        }

        try {
            $this->validoParaCrear();
        } catch (ValidationException $ex) {
            foreach ($ex->getErrors() as $key => $error) {
                $errors[$key] = $error;
            }
        }

        if (sizeof($errors) > 0) {
            throw new ValidationException($errors, "respuesta no valida");
        }
    }


}