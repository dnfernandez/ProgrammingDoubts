<?php

//file: /model/Usuario.php

require_once(__DIR__ . "/../core/ValidationException.php");

class Usuario
{

    private $user;
    private $nombre;
    private $contrasenha;

    /**
     * Usuario constructor.
     * @param $user
     * @param $nombre
     * @param $contrasenha
     */
    public function __construct($user=NULL, $nombre=NULL, $contrasenha=NULL)
    {
        $this->user = $user;
        $this->nombre = $nombre;
        $this->contrasenha = $contrasenha;
    }

    /**
     * @return null
     */
    public function getUsuario()
    {
        return $this->user;
    }

    /**
     * @param null $user
     */
    public function setUsuario($user)
    {
        $this->user = $user;
    }

    /**
     * @return null
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @param null $nombre
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    /**
     * @return null
     */
    public function getContrasenha()
    {
        return $this->contrasenha;
    }

    /**
     * @param null $contrasenha
     */
    public function setContrasenha($contrasenha)
    {
        $this->contrasenha = $contrasenha;
    }

    /**
     * Método para comprobar si el
     * objeto usuario es
     * válido para el registro
     */

    public function validoParaCrear()
    {
        $errors = array();
        if (strlen($this->user) < 1) {
            $errors["usuario"] = "El campo usuario no puede estar vacio";
        }
        if (strlen($this->nombre) < 1) {
            $errors["nombre"] = "El campo nombre no puede estar vacio";
        }
        if (strlen($this->contrasenha) < 6 && strlen($this->contrasenha) > 15) {
            $errors["contrasenha"] = "El campo contrseña no puede estar vacio";
        }
        if (sizeof($errors) > 0) {
            throw new ValidationException ($errors, "usuario no valido");
        }
    }

    /**
     * Método para comprobar si el
     * objeto usuario es
     * válido para modificarse
     */

    public function validoParaActualizar()
    {
        $errors = array();

        if (!isset($this->user)) {
            $errors["user"] = "user es obligatorio";
        }

        try {
            $this->validoParaCrear();
        } catch (ValidationException $ex) {
            foreach ($ex->getErrors() as $key => $error) {
                $errors[$key] = $error;
            }
        }

        if (sizeof($errors) > 0) {
            throw new ValidationException($errors, "usuario no valido");
        }
    }

}