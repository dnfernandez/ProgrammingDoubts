<?php
//file: view/posts/view.php
require_once(__DIR__ . "/../core/ViewManager.php");
$view = ViewManager::getInstance();
$pregunta = $view->getVariable("pregunta");
$respuestas = $view->getVariable("preguntaRes");
$comRespuestas = $view->getVariable("comentariosRespuestas");
$usuario = $view->getVariable("currentusername");
if (isset($usuario)) $currentuser = $usuario->getUsuario();
$error = $view->getVariable("errors");
$contadorError = $view->getVariable("contadorError");
?>
<!-- Page Content -->
<div class="col-md-9 " id="cuerpoP">
    <?php foreach ($pregunta as $pre): ?>
        <div class="row preguntas pregDes">
            <div class="row">
                <div class="col-md-12">
                    <h4 class=" textoP pregTitulo">
                        <?php echo htmlentities($pre["titulo"]); ?></h4>

                    <div class="textoP pregTexto">
                        <?php echo nl2br(htmlentities($pre["texto"])); ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8">
                    <div class="row parte1">
                        <div class="tagsR">
                            <?php
                            $etiq = explode(',', $pre[4]);
                            for ($j = 0; $j < substr_count($pre[4], ',') + 1; $j++) {
                                echo '<a href="index.php?controller=pregunta&amp;action=listarXEtiq&amp;accionEtiq=' . $etiq[$j] . '" class="tagsP">';
                                echo $etiq[$j];
                                echo '</a>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="autor">
                        <?= i18n("preguntado por") ?><?php echo htmlentities(" ".$pre["autor"]) . " ";
                        $date = new DateTime($pre["fecha"]);
                        echo $date->format('d-m-Y'); ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach;
    $cont = 0; ?>
    <?php foreach ($respuestas as $res): $cont++; ?>
        <div class="row respuestas">
            <div class="row parte1">
                <div class="col-md-12">
                    <div class="textoR" id="<?php echo $res["codRes"]; ?>">
                        <?php echo nl2br(htmlentities($res["texto"])); ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8">
                    <div class="likes">
                        <form action="index.php?controller=respuesta&amp;action=votar" method="POST" name="formLikes"
                              role="form">
                            <span class="numLP"><?php echo $res["likesPos"]; ?></span>
                            <button type="submit" name="tipo" value="likesPos"
                                    class="glyphicon glyphicon-thumbs-up"></button>
                            <span class="numLN"><?php echo $res["likesNeg"]; ?></span>
                            <button type="submit" name="tipo" value="likesNeg"
                                    class="glyphicon glyphicon-thumbs-down"></button>
                            <input type="hidden" name="codPre" value="<?php echo $res['codPre'] ?>"/>
                            <input type="hidden" name="codRes" value="<?php echo $res["codRes"] ?>"/>
                            <input type="hidden" name="cont" value="<?php echo $cont ?>"/>
                            <span class="flash"><?php if ($contadorError == $cont) echo $error["votado"]; ?></span>
                            <span
                                class="flash"><?php if (!isset($currentuser) && $contadorError == $cont) echo $view->popFlash(); ?></span>
                        </form>
                    </div>
                </div>
                <div class="col-md-4 autor">
                    <?= i18n("respondido por") ?><?php echo htmlentities(" ".$res["autor"]) . " ";
                    $date = new DateTime($res["fecha"]);
                    echo $date->format('d-m-Y'); ?>
                    <?php if (isset($currentuser)) {
                        echo '<div class="divBtnRes">';
                        echo '<button class="btnRes" onclick="show_form6(' . $res["codRes"] . ')" type="button" >' . i18n("Responder") . '</button>';
                        echo '</div>';
                    } ?>
                </div>
            </div>
        </div>
        <!-- Comentarios de respuesta-->
        <?php foreach ($comRespuestas as $comRes):
            if ($comRes["respuesta_codRes"] == $res["codRes"]) {
                ?>
                <div class="col-md-3 bordeRR"><br></div>
                <div class="row respuestasR">
                    <div class="row parte1">
                        <div class="col-md-9">
                            <div class="textoR">
                                <?php echo nl2br(htmlentities($comRes["texto"]));?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8">

                        </div>
                        <div class="col-md-4 autor">
                            <?= i18n("respondido por") ?> <?php echo htmlentities($comRes["autor"]);?>
                        </div>
                    </div>
                </div>
                <?php
            }
        endforeach;
    endforeach; ?>
</div>

<!--Formulario para crear respuesta de respuesta-->
<div id="formRespuestaR">
    <div class="formRespuestaR">
        <form id="formResR" class="form" class="form" action="index.php?controller=respuesta&amp;action=crearComentario"
              method="POST" name="formResR" role="form">
            <div class="form-group" id="div-text2R">
                <label><?= i18n("Introduzca el texto de la respuesta") ?></label><br>
                <?php $tradFC = i18n("El campo no puede estar vac\u00edo") ?>
                <textarea class="form-control" name="texto" id="comText2R"
                          onblur="validateText2R('<?php echo $tradFC; ?>')"></textarea>
                <input type="hidden" name="codPre" value="<?php echo $_GET['codPre'] ?>"/>
                <input type="hidden" name="autor" value="<?php echo $currentuser; ?>"/>
            </div>
            <div id="formComR">

            </div>
            <div class="form-group botonFP">
                <button type="reset" class="btn btn-default" onclick="hide_form6()"><?= i18n("Cancelar") ?></button>
                <button type="button" class="btn btn-default"
                        onclick="validateDatosRR('<?php echo $tradFC; ?>')"><?= i18n("Responder") ?></button>
            </div>
        </form>
    </div>
</div>