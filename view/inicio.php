<?php
//file: view/posts/view.php
require_once(__DIR__ . "/../core/ViewManager.php");
$view = ViewManager::getInstance();
$preguntas = $view->getVariable("preguntas");
$estado=$view->getVariable("autorMispreguntas");
$etiqTot = $view->getVariable("etiqTot");
$codPreMod=0;
?>
<!-- Page Content -->
    <div class="col-md-9 " id="cuerpoP">
        <?php foreach ($preguntas as $pregunta): ?>
            <!--------------------------------------------Pregunta-------------------------------------------------->
            <div class="row preguntas">
                <div class="col-md-2">
                    <div class="row parte1">
                        <?php echo $pregunta[6]; ?> <?= i18n("Respuestas")?>
                    </div>
                    <div class="row parte1">
                        <?php $date = new DateTime($pregunta["fecha"]); echo $date->format('d-m-Y');?>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="row parte1">
                        <?php
                            echo '<a href="index.php?controller=pregunta&amp;action=verPregunta&amp;codPre='.$pregunta['codPre'].'">';
                            echo $pregunta["titulo"];
                            echo'</a>';
                        ?>
                    </div>
                    <div class="row parte1">
                        <?php
                        $etiq=explode(',',$pregunta[4]);
                        for($j=0; $j<substr_count($pregunta[4],',')+1;$j++){
                            echo '<a href="index.php?controller=pregunta&amp;action=listarXEtiq&amp;accionEtiq='.$etiq[$j].'" class="tagsP">';
                            echo $etiq[$j];
                            echo '</a>';

                        }
                        ?>
                    </div>
                </div>
                <?php if($estado==true) {
                    echo '<div class="col-md-2 edicion">
                                 <div class="row parte1">
                                    <button class="btnMod" onclick="show_form5('.$pregunta["codPre"].')" type="button" ">'.i18n("Modificar").'</button>
                                 </div>
                                <form action="index.php?controller=pregunta&amp;action=edicion" method="POST" name="formLikes">
                                     <div class="row parte1">
                                        <input type="hidden" name="accion" value="borrar">
                                        <input type="hidden" name="codPre" value=' . $pregunta["codPre"] . '>
                                        <button class="btnMod">'.i18n("Borrar").'</button>
                                     </div>
                                 </form>
                        </div>';
                }?>
            </div>
        <?php endforeach; ?>
    </div>
<!--Formulario para modificar pregunta-->
<div id="formPreguntaM">
    <div class="formPreguntaM">
        <form id="formPregM" class="form" action="index.php?controller=pregunta&amp;action=edicion" method="POST" name="formPregM" role="form">
            <div class="form-group" id="div-titM">
                <label><?php echo $tradP = i18n("Introduzca el t&iacute;tulo de la pregunta"); ?></label><br>
				<?php $tradP = i18n("El campo no puede estar vac\u00edo") ?>
                <input type="text" class="form-control" name="titulo" id="comTitM" onblur="validateTitM('<?php echo $tradP ;?>')">
            </div>
            <div class="form-group" id="div-textM">
                <label><?php echo $tradP1 = i18n("Introduzca el texto de la pregunta"); ?></label><br>
                <textarea class="form-control" name="texto" id="comTextM" onblur="validateTextM('<?php echo $tradP1 ;?>')"></textarea>
            </div>
            <div class="form-group" id="div-etiqM">
                <label><?php echo $tradP = i18n("Seleccione las etiquetas de la pregunta"); ?></label><br>
                <div class="etiqFormM">
                    <?php
                    $etiq=explode(',',$etiqTot);
                    $cont=substr_count($etiqTot,',')+1;
                    for($j=0; $j<$cont;$j++){
                        $i=$j+1;
                        echo '<label class="checkbox-inline">';
                        echo '<input type="checkbox" id="comEtiqM" name="etiquetas[]'.$i.'" value="'.$etiq[$j].'">';
                        echo " ". $etiq[$j]."</label>";
                        if($cont/2-1==$j) echo "<br><br>";
                    }
                    echo '<input type="hidden" name="submitCrear" value="'.$cont.'"/>';
                    ?>
                    <input type="hidden" name="accion" value='modificar'>
                </div>
                <div id="formPreguntaMF">

                </div>
            </div>
            <div class="form-group botonFP">
                <button type="reset" class="btn btn-default" onclick="hide_form5()"><?= i18n("Cancelar")?></button>
				<?php $tradMP1 = i18n("Seleccione alguna etiqueta") ?>
                <button type="button" class="btn btn-default" onclick="validateDatosPM('<?php echo $tradMP1 ;?>')"><?= i18n("Modificar")?></button>
            </div>
        </form>
    </div>
</div>
