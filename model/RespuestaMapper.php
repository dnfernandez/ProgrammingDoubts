<?php

require_once(__DIR__ . "/../core/PDOConnection.php");

require_once(__DIR__ . "/../model/Respuesta.php");
require_once(__DIR__ . "/../model/Usuario.php");
class RespuestaMapper
{

    private $db;

    /**
     * RespuestaMapper constructor.
     */
    public function __construct()
    {
        $this->db = PDOConnection::getInstance();
    }

    /**
     * Metodo que devuelve el codPre mas alto
     */

    public function ultimoCodRes($codPre){
        $stmt = $this->db->prepare("select max(codRes) as maximo from respuesta where codPre=?;");
        $stmt->execute(array($codPre));
        return $stmt->fetch(PDO::FETCH_BOTH);
    }

    /**
     * Metodo para comprobar si existe la respuesta
     * @param $respuesta
     * @return bool
     */
    public function existeRespuesta($idPregunta, $idRespuesta)
    {
        $stmt = $this->db->prepare("SELECT count(codPre) FROM respuesta where codPre=? and codRes=?");
        $stmt->execute(array($idPregunta, $idRespuesta));

        if ($stmt->fetchColumn() > 0) {
            return true;
        }
    }

    public function insertar(Respuesta $respuesta){
        $stmt = $this->db->prepare("insert into respuesta(codPre, codRes, texto, fecha, autor, likesPos, likesNeg) values (?,?,?,?,?,?,?)");
        $stmt->execute(array($respuesta->getCodPre(),$respuesta->getCodRes(),$respuesta->getTexto(),$respuesta->getFecha(),$respuesta->getAutor(),$respuesta->getLikesPos(),$respuesta->getLikesNeg()));
    }

    /**
     * @param $codPre
     * @param $codRes
     * @param $usuario
     * @param $tipo
     * @throws ValidationException
     * Metodo que comprueba si un usuario ha votado, si no ha dado su voto
     * se contabiliza su voto sea positivo o negativo
     */
    public function comprobarVoto($codPre,$codRes,$usuario,$tipo){
        $stmt = $this->db->prepare("select * from usuario_vota_respuesta where respuesta_codPre=? and respuesta_codRes=? and usuario_usuario=?");
        $stmt->execute(array($codPre,$codRes,$usuario));
        $var  = $stmt->fetch(PDO::FETCH_BOTH);
        if($var==NULL) {
            if ($tipo == "likesPos") {
                $stmt = $this->db->prepare("insert into usuario_vota_respuesta(respuesta_codPre, respuesta_codRes, usuario_usuario, votado) values (?,?,?,?)");
                $stmt->execute(array($codPre, $codRes, $usuario,'1'));
                $this->sumarLikesPos($codPre, $codRes);
            } elseif ($tipo = "likesNeg") {
                $stmt = $this->db->prepare("insert into usuario_vota_respuesta(respuesta_codPre, respuesta_codRes, usuario_usuario, votado) values (?,?,?,?)");
                $stmt->execute(array($codPre, $codRes, $usuario,'1'));
                $this->sumarLikesNeg($codPre, $codRes);
            }
        }
        elseif($var[3]=='0'){
            if($tipo=="likesPos"){
                $stmt = $this->db->prepare("update usuario_vota_respuesta set votado=? where respuesta_codPre=? and respuesta_codRes=? and usuario_usuario=?");
                $stmt->execute(array('1',$codPre,$codRes,$usuario));
                $this->sumarLikesPos($codPre,$codRes);
            }elseif($tipo="likesNeg"){
                $stmt = $this->db->prepare("update usuario_vota_respuesta set votado=? where respuesta_codPre=? and respuesta_codRes=? and usuario_usuario=?");
                $stmt->execute(array('1',$codPre,$codRes,$usuario));
                $this->sumarLikesNeg($codPre,$codRes);
            }
        }else{
            $errors = array();
            $errors["votado"] =  i18n("Ya has votado esta respuesta");
            if (sizeof($errors) > 0) {
                throw new ValidationException ($errors, "voto no valido");
            }
        }
    }

    public function sumarLikesPos($codPre, $codRes){
        $stmt = $this->db->prepare("select likesPos from respuesta where codPre=? and codRes = ?");
        $stmt->execute(array($codPre, $codRes));
        $var  = $stmt->fetch(PDO::FETCH_BOTH);
        $sum = $var[0] +1;
        $stmt = $this->db->prepare("update respuesta set likesPos=? where codPre=? and codRes=? ");
        $stmt->execute(array($sum, $codPre, $codRes));

    }

    public function sumarLikesNeg($codPre, $codRes){
        $stmt = $this->db->prepare("select likesNeg from respuesta where codPre=? and codRes = ?");
        $stmt->execute(array($codPre, $codRes));
        $var  = $stmt->fetch(PDO::FETCH_BOTH);
        $sum = $var[0] +1;
        $stmt = $this->db->prepare("update respuesta set likesNeg=? where codPre=? and codRes=? ");
        $stmt->execute(array($sum, $codPre, $codRes));

    }

    /**
     * Metodo para insertar un comentario a una respuesta
     */

    public function insertarComentarioRespuesta($codPre, $codRes, $autor, $comentario){
        $stmt = $this->db->prepare("insert into comentario_respuesta(respuesta_codPre, respuesta_codRes, texto, autor) values (?,?,?,?)");
        $stmt->execute(array($codPre, $codRes, $comentario, $autor));
    }

    /**
     * Listar comentarios de todas las respuestas de una pregunta
     */

    public function obtenerComentarioRespuestas($codPre){
        $stmt = $this->db->prepare("select * from comentario_respuesta where respuesta_codPre=? order by codResR asc");
        $stmt->execute(array($codPre));
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

