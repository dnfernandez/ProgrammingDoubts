<?php

//file: /model/PreguntaMapper.php

require_once(__DIR__ . "/../core/PDOConnection.php");

require_once(__DIR__ . "/../model/Usuario.php");
require_once(__DIR__ . "/../model/Pregunta.php");
require_once(__DIR__ . "/../model/Respuesta.php");

class PreguntaMapper
{
    private $db;

    public function __construct()
    {
        $this->db = PDOConnection::getInstance();
    }

    /**
     * Metodo que devuelve el codPre mas alto
     */

    public function ultimoCodPre(){
        $stmt = $this->db->query("select max(codPre) from pregunta;");
        return $stmt->fetch(PDO::FETCH_BOTH);
    }

    /**
     * Metodo para comprobar si existe la pregunta
     * @param $pregunta
     * @return bool
     */
    public function existePregunta($idPregunta)
    {
        $stmt = $this->db->prepare("SELECT count(codPre) FROM pregunta where codPre=?");
        $stmt->execute(array($idPregunta));

        if ($stmt->fetchColumn() > 0) {
            return true;
        }
    }

    /**
     * Metodo para listar todas las preguntas
     * si se le pasa un texto busca que en el
     * titulo o texto haya ese texto
     */

    public function listarPreguntas($texto=NULL)
    {
        $stmt = $this->db->prepare("select pregunta.codPre, pregunta.titulo, pregunta.texto, pregunta.fecha, pregunta.etiquetas, pregunta.autor,
                                  (select count(*) from respuesta where pregunta.codPre=respuesta.codPre) as contador from pregunta
                                  where pregunta.titulo like :elemento or pregunta.texto like :elemento2
                                    group by codPre order by pregunta.fecha desc ");
        $stmt->execute(array(':elemento' => '%'.$texto.'%', ':elemento2' => '%'.$texto.'%'));
        $posts_db = $stmt->fetchAll(PDO::FETCH_BOTH);
        return $posts_db;
    }

    /**
     * Metodo para listar todas las preguntas de un autor
     */

    public function listarPreguntasAutor($user)
    {
        $stmt = $this->db->prepare("select pregunta.codPre, pregunta.titulo, pregunta.texto, pregunta.fecha, pregunta.etiquetas, pregunta.autor,
                                  (select count(*) from respuesta where pregunta.codPre=respuesta.codPre) as contador from pregunta
                                    where pregunta.autor=? group by codPre order by pregunta.fecha desc");
        $stmt->execute(array($user));
        $posts_db = $stmt->fetchAll(PDO::FETCH_BOTH);
        return $posts_db;
    }

    /**
     * Metodo para listar todas las preguntas de una etiqueta
     */
    public function listarPreguntasEtiqueta($etiqueta)
    {
        $stmt = $this->db->prepare("select pregunta.codPre, pregunta.titulo, pregunta.texto, pregunta.fecha, pregunta.etiquetas, pregunta.autor,
                                  (select count(*) from respuesta where pregunta.codPre=respuesta.codPre) as contador from pregunta where BINARY etiquetas like ? order by fecha desc");
        $stmt->execute(array('%' . $etiqueta . '%'));
        $posts_db = $stmt->fetchAll(PDO::FETCH_BOTH);
        return $posts_db;
    }


    /**
     * Metodo para listar una pregunta por su codigo
     */

    public function listarPreguntaCod($codPre)
    {
        $stmt = $this->db->prepare("SELECT * FROM pregunta where pregunta.codPre=?");
        $stmt->execute(array($codPre));
        $post = $stmt->fetchAll(PDO::FETCH_BOTH);

        if ($post != null) {
            return $post;
        } else {
            return NULL;
        }
    }

    /**
     * Metodo para listar las respuestas de una pregunta
     * por su codigo
     */

    public function listarComentarios($codPre)
    {
        $stmt = $this->db->prepare("select codPre, codRes, texto, fecha,
                            autor, likesPos, likesNeg from respuesta where codPre=? order by fecha DESC");
        $stmt->execute(array($codPre));
        $resp_db = $stmt->fetchAll(PDO::FETCH_BOTH);

        return $resp_db;
    }

    /**
     * Metodo para contar el
     * numero de respuestas
     */

    public function contarRespuestas($codPre)
    {
        $stmt = $this->db->prepare("select count(*) from respuesta where codPre=?");
        $stmt->execute(array($codPre));

        return $stmt->fetch(PDO::FETCH_BOTH);

    }

    public function  insertar(Pregunta $pregunta)
    {
        $stmt = $this->db->prepare("insert into pregunta(codPre, titulo, texto, fecha, etiquetas, autor) values (?,?,?,?,?,?)");
        $stmt->execute(array($pregunta->getCodPre(), $pregunta->getTitulo(), $pregunta->getTexto(), $pregunta->getFecha(), $pregunta->getEtiquetas(), $pregunta->getAutor()));

    }

    public function  actualizar(Pregunta $pregunta)
    {
        $stmt = $this->db->prepare("update pregunta set titulo=?, texto =?, fecha=?, etiquetas=? where codPre =? ");
        $stmt->execute(array($pregunta->getTitulo(), $pregunta->getTexto(), $pregunta->getFecha(), $pregunta->getEtiquetas(), $pregunta->getCodPre()));
    }

    public function eliminar($codPre)
    {
        $stmt = $this->db->prepare("delete from pregunta where codPre=?");
        $stmt->execute(array($codPre));
    }

    /**
     * Metodo que lista las etiquetas existentes en la base de datos
     */
    function listarEtiquetasTotales(){
        $stmt = $this->db->prepare("SHOW COLUMNS FROM pregunta LIKE 'etiquetas'");
        $stmt->execute();
        $row=$stmt->fetch(PDO::FETCH_BOTH);
        $cadena = $row[1];
        $patron=array();
        $patron[0] = '/set/';
        $patron[1] = '/\(/';
        $patron[2] = '/\)/';
        $patron[3] = '/\'/';
        $sustitución = '';
        $lEtiq=preg_replace($patron, $sustitución, $cadena);
        return $lEtiq;
    }

}