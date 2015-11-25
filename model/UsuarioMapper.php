<?php

//file: model/UsuarioMapper.php

require_once(__DIR__ . "/../core/PDOConnection.php");

class UsuarioMapper
{
    private $db;

    /**
     * UsuarioMapper constructor.
     */
    public function __construct()
    {
        $this->db = PDOConnection::getInstance();
    }

    public function insertar($usuario){
        $stmt = $this->db->prepare("INSERT INTO usuario VALUES (?,?,?)");
        $stmt->execute(array($usuario->getUsuario(),$usuario->getNombre(),$usuario->getContrasenha()));
    }

    public function existeUsuario($user){
        $stmt = $this->db->prepare("SELECT count(usuario) FROM usuario where usuario=?");
        $stmt->execute(array($user));

        if($stmt ->fetchColumn() >0){
            return true;
        }
    }

    public function comprobarUsuario($user, $contrasenha){
        $stmt = $this->db->prepare("SELECT count(usuario) FROM usuario where usuario=? and contrasenha=?");
        $stmt->execute(array($user, $contrasenha));

        if($stmt->fetchColumn()>0){
            return true;
        }
    }

    public function  actualizar(Usuario $usuario)
    {
        $stmt = $this->db->prepare("update usuario set nombre=?, contrasenha=? where usuario=? ");
        $stmt->execute(array($usuario->getNombre(), $usuario->getContrasenha(), $usuario->getUsuario()));
    }

}