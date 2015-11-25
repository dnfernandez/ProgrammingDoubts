<?php

require_once(__DIR__ . "/../model/Usuario.php");
require_once(__DIR__ . "/../model/UsuarioMapper.php");
require_once(__DIR__ ."/../core/I18n.php");
require_once(__DIR__ . "/../core/ViewManager.php");
require_once(__DIR__ . "/../controller/BaseController.php");

class UsuarioController extends BaseController
{
    private $usuarioMapper;

    public function __construct()
    {
        parent::__construct();
        $this->usuarioMapper = new UsuarioMapper();
    }

    /**
     * Accion de login
     */

    public function login(){
        if(isset($_POST["username"])){
            if($this->usuarioMapper->comprobarUsuario($_POST["username"], $_POST["pass"])){
                $_SESSION["currentuser"]=$_POST["username"];
                $this->view->redirect("pregunta","index");
                $this->view->setVariable("currentusername",$_POST["username"]);
                //$this->currentUser = $this->view->getVariable("currentusername");
            }else{
                $errors = array();
                $errors["general"] = "Usuario no valido";
                $this->view->setVariable("errors", $errors);
            }
        }
        $this->view->redirect("pregunta","index");
    }

    /**
     * Accion de logout
     */
    public function logout() {
        session_destroy();
        $this->view->redirect("pregunta","index");

    }

    /**
     * Accion de registrar
     */

    public function registrar(){
        $usuario = new Usuario();
        if(isset($_POST["username"])){
            $usuario->setUsuario($_POST["username"]);
            $usuario->setNombre($_POST["nombre"]);
            $usuario->setContrasenha($_POST["pass"]);

            try{
                $usuario->validoParaCrear();
                if(!$this->usuarioMapper->existeUsuario($_POST["username"])){
                    $this->usuarioMapper->insertar($usuario);
                    $this->view->setFlash(i18n("Usuario")." ".$usuario->getUsuario()." ".i18n("creado correctamente"));
                    $this->view->redirect("pregunta","index");
                }else{
                    $errors=array();
                    $errors["username"] = "Ya existe un usuario";
                    $this->view->setVariable("errors",$errors);
                    $this->view->setFlash(i18n("Ya existe un usuario"));
                }
            }catch (ValidationException $ex){
                $errors = $ex->getErrors();
                $this->view->setVariable("errors",$errors);
            }
        }

        $this->view->setVariable("usuario",$usuario);
        $this->view->redirect("pregunta","index");
    }

    /**
     * Accion de modificar datos
     */

    public function modificarDatos(){
        $usuario = new Usuario();
        if(isset($_POST["username"])){
            $usuario->setUsuario($_POST["username"]);
            $usuario->setNombre($_POST["nombre"]);
            $usuario->setContrasenha($_POST["pass"]);
            try{
                $usuario->validoParaActualizar();
                if($this->usuarioMapper->existeUsuario($_POST["username"])){
                    $this->usuarioMapper->actualizar($usuario);
                    $this->view->setFlash("Usuario ".$usuario->getUsuario()." actualizado correctamente");
                    $this->view->redirect("pregunta","index");
                }else{
                    $errors=array();
                    $errors["username"] = "Error al modificar";
                    $this->view->setVariable("errors",$errors);
                    $this->view->setFlash("Error al modificar");
                }
            }catch (ValidationException $ex){
                $errors = $ex->getErrors();
                $this->view->setVariable("errors",$errors);
            }
        }

        $this->view->setVariable("usuario",$usuario);
        $this->view->redirect("pregunta","index");

    }
}