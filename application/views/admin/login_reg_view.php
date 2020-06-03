<!DOCTYPE html>
<!--[if lt IE 7 ]> <html lang="es" class="no-js ie6 lt8"> <![endif]-->
<!--[if IE 7 ]>    <html lang="es" class="no-js ie7 lt8"> <![endif]-->
<!--[if IE 8 ]>    <html lang="es" class="no-js ie8 lt8"> <![endif]-->
<!--[if IE 9 ]>    <html lang="es" class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html lang="es" class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="UTF-8" />
        <!-- <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">  -->
        <title>Autenticación de Usuarios</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        <meta name="description" content="" />
        <meta name="keywords" content="" />
        <meta name="author" content="Publianuncio.es" />
        <link rel="shortcut icon" href="<?=base_url()?>uploads/<?= get_imagen("favicon")?>">
        <link rel="stylesheet" type="text/css" href="<?= base_url();?>css/demo.css" />
        <link rel="stylesheet" type="text/css" href="<?= base_url();?>css/style3.css" />
        <link rel="stylesheet" type="text/css" href="<?= base_url();?>css/animate-custom.css" />
    </head>
    <body>
        <div class="container">
            <header>
                <h1>PANEL DE CONTROL <span><a href="<?=base_url();?>" style="color:#FF0013"><?=NOMBRE_PORTAL_NOTACION_URL?></a></span></h1>
            </header>
            <section>               
                <div id="container_demo" >
                    <!-- hidden anchor to stop jump http://www.css3create.com/Astuce-Empecher-le-scroll-avec-l-utilisation-de-target#wrap4  -->
                    <a class="hiddenanchor" id="tologin"></a>
                    
                    <div id="wrapper">
                        <div id="login" class="animate form">
                            <form  method="POST" action="<?= base_url().'admin/acceso/login' ?>" autocomplete="on"> 
                                <h1>Log in</h1>
                                <div style="color:red"><?=$mensaje_error;?></div>
                                <p> 
                                    <label for="usuario" class="uname" data-icon="u" > Nombre de Usuario </label>
                                    <input id="username" name="usuario" required="required" type="text" placeholder="Username"/>
                                </p>
                                <p> 
                                    <label for="password" class="youpasswd" data-icon="p"> Contraseña </label>
                                    <input id="password" name="password" required="required" type="password" placeholder="eg. X8df!90EO" /> 
                                </p>
                                <p class="keeplogin"> 
                                    <input type="checkbox" name="loginkeeping" id="loginkeeping" value="loginkeeping" /> 
                                    <label for="loginkeeping">Mantener la sesión iniciada</label>
                                    
                                    <a href="<?=site_url('usuarios/recordar_password')?>"><label>¿Ha olvidado su password?</label></a>
                                </p>
                                <p class="login button volver"> 
                                    <input type="button" value="Volver" onclick="history.back(-1)"/> 
                                </p>
                                <p class="login button"> 
                                    <input type="submit" value="Iniciar Sesión" /> 
                                </p>
                            </form>
                        </div>
                    </div>
                </div>  
            </section>
        </div>
    </body>
</html>