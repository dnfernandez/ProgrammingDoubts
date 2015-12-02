<?php
require_once(__DIR__ . "/../../core/ViewManager.php");
$view = ViewManager::getInstance();
$usuario=$view->getVariable("currentusername");
if(isset($usuario))$currentuser=$usuario->getUsuario();
$vista=$view->getNombreVista();
$etiqTot = $view->getVariable("etiqTot");
?><!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Programming Doubts es una web encargada en la ayuda de problemas de programación">
    <meta name="author" content="Diego y Alex">

    <!--<link rel="icon" type="image/ico" href="Images/Icono.ico" />-->
    <link rel="icon" type="image/ico" href="Images/Icono.ico"/>
    <title>Programming Doubts</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/estilo.css" rel="stylesheet">

    <script src="js/javascript.js" type="text/javascript" ></script>

</head>

<body>
<nav class="navbar navbar-default navbar-fixed-top" id="cabeceraT" role="navigation">
    <div class="container">
        <div class="navbar-header" id="hlogo">
            <div class="container-fluid">
                <div class="row-fluid">
                    <a class="navbar-brand" rel="home" href="index.php?controller=pregunta&amp;action=index" title="Programming Doubts">
                        <img class="logo img-responsive" alt="Logo" src="Images/Logo.svg">
                    </a>
                </div>
            </div>
        <?php if (!isset($currentuser)): ?>
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Sesión y Registro</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        <?php endif ?>
        </div>
        <?php if (!isset($currentuser)): ?>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <form class="navbar-form navbar-right" action="index.php?controller=usuario&amp;action=login" method="POST" >
                <div class="form-group">
                    <input placeholder="<?= i18n("Usuario")?>" class="form-control" type="text" name="username">
                </div>
                <div class="form-group">
                    <input placeholder="<?= i18n("Contrase&ntilde;a")?>" class="form-control" type="password" name="pass">
                </div>
                <button type="submit" class="btn btn-default" name="entrar"><?= i18n("Entrar")?></button>
				
                <p>
                    <button type="button" class="btn btn-default navbar-btn" onclick="show_form2()"><?= i18n("Registrarse")?></button>
                    <span class="errorR"><?php echo $view->popFlash();?></span>
                </p>
            </form>
			
        </div>
		
        <?php else: ?>
            <ul class="nav navbar-right listaDes">
                <li class="dropdown">
                    <br><br><br>
                    <!--<img class="usuario img-responsive" alt="Imagen usuario" src="Images/usuario.svg">-->
                    <a href="#" class="dropdown-toggle btnUsuario" data-toggle="dropdown"><i class="fa fa-user"><?php echo $currentuser; ?></i>  <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a onclick="show_form3()"><i class="fa fa-fw fa-user"></i><?= i18n("Modificar datos")?> </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="index.php?controller=pregunta&amp;action=listarXAutor"<i class="fa fa-fw fa-user"></i><?= i18n("Mis preguntas")?> </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="index.php?controller=usuario&amp;action=logout"><i class="fa fa-fw fa-power-off"></i><?= i18n("Cerrar sesi&oacute;n")?> </a>
                        </li>
                    </ul>
                </li>
            </ul>
        <?php endif ?>
    </div>
</nav>
<div class="container" id="principal">
    <div class="row ">
        <!----------------------------------- El centro viene aqui ----------------------------------------------------------->
        <?= $view->getFragment(ViewManager::DEFAULT_FRAGMENT) ?>
        <div class="col-md-3">
            <div class="sidebar">
				<div class="row parte2">
				<?php
					include(__DIR__."/language_select_element.php");
				?>
				</div>
				<?php if (isset($currentuser)):
				echo'<div class="row parte2">';														
                        if (!$vista=="respuestas"): ?>
                            <button type="button" class="btn btn-imp"  onclick="show_form1()"><?= i18n("Formular pregunta")?></button>
                        <?php else: ?>
                            <button type="button" class="btn btn-imp"  onclick="show_form4() "><?= i18n("Responder pregunta")?></button>
                        <?php
                        endif;
						echo"</div>";
                    endif;
                    ?>
                
                <div class="row parte2">
                    <form class="form-inline" action="index.php?controller=pregunta&amp;action=index" method="POST" role="form">
                        <div class="form-group">
                            <input type="text" name="busqueda" class="form-control" placeholder="<?= i18n("Buscar")?>">
                            <button type="submit" class="btn btn-default glyphicon glyphicon-search"></button>
                        </div>
                    </form>
                </div>
                <div class="row parte2 tags">
                    <ul>
                        <?php
                            $etiq=explode(',',$etiqTot);
                            for($j=0; $j<substr_count($etiqTot,',')+1;$j++){
                                echo '<li><a href="index.php?controller=pregunta&amp;action=listarXEtiq&amp;accionEtiq='.$etiq[$j].'" class="nav_li">';
                                echo $etiq[$j];
                                echo '</a></li>';

                            }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!--Formulario para crear pregunta--> <!--Falta por traducir en la parte javascript los validate-->  
    <div id="formPregunta">
        <div class="formPregunta">
            <form id="formPreg" class="form" action="index.php?controller=pregunta&amp;action=crear" method="POST" name="formPreg" role="form">
                <div class="form-group" id="div-tit">
                    <label><?= i18n("Introduzca el t&iacute;tulo de la pregunta")?></label><br>
					<?php $tradFCP = i18n("El campo no puede estar vac\u00edo") ?>
					<input type="text" class="form-control" name="titulo" id="comTit" onblur="validateTit('<?php echo $tradFCP ;?>')">
				</div>
                <div class="form-group" id="div-text">
                    <label><?= i18n("Introduzca el texto de la pregunta")?></label><br>
                    <textarea class="form-control" name="texto" id="comText" onblur="validateText('<?php echo $tradFCP ;?>')"></textarea>
                </div>
                <div class="form-group" id="div-etiq">
                    <label><?= i18n("Seleccione las etiquetas de la pregunta")?></label><br>
                    <div class="etiqForm">
                        <?php
                            $etiq=explode(',',$etiqTot);
                            $cont=substr_count($etiqTot,',')+1;
                            for($j=0; $j<$cont;$j++){
                                $i=$j+1;
                                echo '<label class="checkbox-inline">';
                                echo '<input type="checkbox" id="comEtiq" name="etiquetas[]'.$i.'" value="'.$etiq[$j].'">';
                                echo " ". $etiq[$j]."</label>";
                                if($cont/2-1==$j) echo "<br><br>";
                            }
                            echo '<input type="hidden" name="submitCrear" value="'.$cont.'"/>';
                        ?>
                        </div>
                </div>
                <div class="form-group botonFP">
                    <button type="reset" class="btn btn-default" onclick="hide_form1()"><?= i18n("Cancelar")?></button>
					<?php $tradFCP1 = i18n("Seleccione alguna etiqueta") ?>
                    <button type="button" class="btn btn-default" onclick="validateDatosP('<?php echo $tradFCP ;?>','<?php echo $tradFCP1 ;?>')"><?= i18n("Formular")?></button>
                </div>
            </form>
        </div>
    </div>
    <!--Formulario para registrarse-->
    <div id="formRegistro">
        <div class="formRegistro">
            <form id="registerform" name="registro" class="form" action="index.php?controller=usuario&amp;action=registrar" method="POST" role="form">
                <div class="form-group" id="div-name">
                    <label><?= i18n("Usuario")?></label><br>
					<?php $trad = i18n("El campo no puede estar vac\u00edo") ?>
                    <input type="text" name="username" class="form-control" id="register-name" onblur="validateName('<?php echo $trad ;?>')">
                </div>
                <div class="form-group" id="div-name2">
                    <label><?= i18n("Nombre")?></label><br>
					<?php $tradFR1 = i18n("El campo nombre no puede estar vac\u00edo") ?>
                    <input type="text" name="nombre" class="form-control" id="register-name2" onblur="validateName2('<?php echo $tradFR1 ;?>')">
                </div>
                <div class="form-group" id="div-password">
                    <label><?= i18n("Contrase&ntildea")?></label><br>
					<?php $tradFR2 = i18n("Las contrase\u00f1as no coinciden ,deben tener un n\u00famero ,una letra y entre 6 y 15 caracteres") ?>
                    <input type="password" name="pass" id="register-password" class="form-control" onblur="validatePassword('<?php echo $tradFR2 ;?>')">
                </div>
                <div class="form-group" id="div-repeatPassword">
                    <label><?= i18n("Repetir contrase&ntildea")?></label><br>
                    <input type="password"  id="register-repeatPassword" class="form-control" name="cont2" onblur="validatePassword('<?php echo $tradFR2 ;?>')">
                </div>
                <div class="form-group botonFP">
                    <button type="reset" class="btn btn-default" onclick="hide_form2()"><?= i18n("Cancelar")?></button>
                    <button type="button" class="btn btn-default" onclick="validateDatos('<?php echo $trad;?>','<?php echo $tradFR1;?>','<?php echo $tradFR2;?>')"><?= i18n("Registrarse")?></button>
                </div>
            </form>
        </div>
    </div>
    <!--Formulario para modificarDatos-->
    <div id="formModificarD">
        <div class="formModificarD">
            <form id="modifform" name="modificarDatos" class="form" action="index.php?controller=usuario&amp;action=modificarDatos" method="POST" role="form">
                <div class="form-group" id="div-nameM">
                    <label><?= i18n("Usuario")?></label><br>
                    <input type="text" class="form-control" id="modif-name" disabled placeholder="<?php echo $currentuser;?>">
                    <?php echo '<input type="hidden" name="username" value="'.$currentuser.'">';?>
                </div>
                <div class="form-group" id="div-name2M">
                    <label><?= i18n("Nombre")?></label><br>
					<?php $tradFM = i18n("El campo no puede estar vac\u00edo") ?>
                    <input type="text" class="form-control" name="nombre" id="modif-name2" onblur="validateNameModif2('<?php echo $tradFM ;?>')">
                </div>
                <div class="form-group" id="div-passwordM">
                    <label><?= i18n("Contrase&ntildea")?></label><br>
					<?php $tradFM1 = i18n("El campo nombre no puede estar vac\u00edo") ?>
                    <input type="password"  id="register-passwordM" class="form-control" name="pass" onblur="validatePasswordModif('<?php echo $tradFM1 ;?>')">
                </div>
                <div class="form-group" id="div-repeatPasswordM">
                    <label><?= i18n("Repetir contrase&ntildea")?></label><br>
					<?php $tradFM2 = i18n("Las contrase\u00f1as no coinciden ,deben tener un n\u00famero ,una letra y entre 6 y 15 caracteres") ?>
                    <input type="password"  id="register-repeatPasswordM" class="form-control" name="cont2" onblur="validatePasswordModif('<?php echo $tradFM2 ;?>')">
                </div>
                <div class="form-group botonFP">
                    <button type="reset" class="btn btn-default" onclick="hide_form3()"><?= i18n("Cancelar")?></button>
                    <button type="button" class="btn btn-default" onclick="validateDatos2('<?php echo $tradFM ;?>','<?php echo $tradFM1 ;?>')"><?= i18n("Modificar datos")?></button>
                </div>
            </form>
        </div>
    </div>
    <!--Formulario para crear respuesta-->
    <div id="formRespuesta">
        <div class="formRespuesta">
            <form id="formRes" class="form" class="form" action="index.php?controller=respuesta&amp;action=crear" method="POST" name="formRes" role="form">
                <div class="form-group" id="div-text2">
                    <label><?= i18n("Introduzca el texto de la respuesta")?></label><br>
					<?php $tradFC = i18n("El campo no puede estar vac\u00edo") ?>
                    <textarea class="form-control" name="texto" id="comText2" onblur="validateText2('<?php echo $tradFC ;?>')"></textarea>
                    <input type="hidden" name="codPre" value="<?php echo $_GET['codPre']?>"/>
                </div>
                <div class="form-group botonFP">
                    <button type="reset" class="btn btn-default" onclick="hide_form4()"><?= i18n("Cancelar")?></button>
                    <button type="button" class="btn btn-default" onclick="validateDatosR('<?php echo $tradFC ;?>')"><?= i18n("Responder")?></button>
                </div>
            </form>
        </div>
    </div>
</div>



<!-- jQuery Version 1.11.1 -->
<script src="js/jquery.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.min.js"></script>

<!-- notify -->
<script src="js/notify.js"></script>

</body>

</html>