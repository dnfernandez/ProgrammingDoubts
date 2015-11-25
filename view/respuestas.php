<?php
//file: view/posts/view.php
require_once(__DIR__ . "/../core/ViewManager.php");
$view = ViewManager::getInstance();
$pregunta = $view->getVariable("pregunta");
$respuestas = $view->getVariable("preguntaRes");
$usuario=$view->getVariable("currentusername");
if(isset($usuario))$currentuser=$usuario->getUsuario();
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
                        <?php echo $pre["titulo"]; ?></h4>
                    <div class="textoP pregTexto">
                        <?php echo htmlentities($pre["texto"]); ?>
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
                          <?= i18n("preguntado por")?> <?php echo $pre["autor"] . " ";
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
                    <div class="textoR" id="<?php echo $res["codRes"];?>">
                        <?php echo htmlentities($res["texto"]); ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8">
                    <div class="likes">
                        <form action="index.php?controller=respuesta&amp;action=votar" method="POST" name="formLikes" role="form">
                            <span class="numLP"><?php echo $res["likesPos"]; ?></span>
                            <button type="submit" name="tipo" value="likesPos"
                                    class="glyphicon glyphicon-thumbs-up"></button>
                            <span class="numLN"><?php echo $res["likesNeg"]; ?></span>
                            <button type="submit" name="tipo" value="likesNeg"
                                    class="glyphicon glyphicon-thumbs-down"></button>
                            <input type="hidden" name="codPre" value="<?php echo $res['codPre'] ?>"/>
                            <input type="hidden" name="codRes" value="<?php echo $res["codRes"] ?>"/>
                            <input type="hidden" name="cont" value="<?php echo $cont ?>"/>
                            <span class="flash"><?php if($contadorError == $cont) echo $error["votado"];?></span>
                            <span class="flash"><?php if(!isset($currentuser) && $contadorError == $cont) echo $view->popFlash();?></span>
                        </form>
                    </div>
                </div>
                <div class="col-md-4 autor">
                      <?= i18n("respondido por")?> <?php echo $res["autor"] . " ";
                    $date = new DateTime($res["fecha"]);
                    echo $date->format('d-m-Y'); ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>	
</div>