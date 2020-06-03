<!DOCTYPE html>
<html lang="es_Es">
    <head>
        <meta charset="utf-8">
        <title>DISEÑO HUMANO</title>
        <meta name="description" content="Piseño Humano">
        <meta name="keywords" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="author" content="Hementxe.com">

        <!-- ============ Google fonts ============ -->
        <link href="http://fonts.googleapis.com/css?family=Lato:100,300,400,700,400italic" rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Playball' rel='stylesheet' type='text/css'>
        <!-- ============ Bootstrap core CSS ============ -->
        <link href="<?=base_url();?>assets/pag/css/bootstrap.min.css" rel="stylesheet" type="text/css" />

        <!-- ============ Add custom CSS here ============ -->
        <link href="<?=base_url();?>assets/pag/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="<?=base_url();?>assets/pag/css/animate.css" rel="stylesheet" type="text/css" />
        <link href="<?=base_url();?>assets/pag/css/style.css" rel="stylesheet" type="text/css" />

        <!-- ============ Special CSS for Animation ============ -->
        <style type="text/css">#anim-fs {position: absolute;height: 100%;width: 100%;}</style>
    </head>

<body id="anim-fs">

<!-- ===== Loading ===== -->
    <div class="globload">
        <div class="snaker animated fadeIn">
            <div class="circle1"></div>
            <div class="circle2"></div>
            <div class="circle3"></div>
            <div class="circle4"></div>
            <div class="circle5"></div>
            <div class="circle6"></div>
            <h6>LOADING</h6>
        </div>
    </div>
    <!-- ===== Loading ===== -->


    <!-- ************** START / GLISS MAP ************** -->
    <div id="map">
        <div class="container">
            <div class="col-xs-12 align-reduce">
                <a class="backoff">
                    <div class="reducing">
                        <i class="fa fa-compress"></i>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <!-- ************** END / GLISS MAP ************** -->

    <!-- <div id="pattern"></div> -->

    <h1 class="tlt">DISEÑO HUMANO</h1>

    <!-- ************** START / MAIN FUTURE ************** -->
    <section id="main-future" class="opacity-0">

        <div id="main-content">
            <div class="principal container">

                <h1 style="font-family: 'Playball', cursive;  letter-spacing: 5px;" id="tit-main">www.DISEÑOHUMANO.org</h1>
                <span class="border"></span>
                <h4>Página en construcción</h4>

                <!-- ************** START / COUNTDOWN ************** -->

                <div id="countdown_dashboard">

                    <div class="col-md-3 col-sm-3 col-xs-12 dash-glob">
                        <div class="dash days_dash">

                            <div class="digit">0</div>
                            <div class="digit">0</div>
                            <span class="dash_title">Días</span>
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-3 col-xs-12 dash-glob">
                        <div class="dash hours_dash">
                            <div class="digit">0</div>
                            <div class="digit">0</div>
                            <span class="dash_title">Horas</span>
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-3 col-xs-12 dash-glob">
                        <div class="dash minutes_dash">
                            <div class="digit">0</div>
                            <div class="digit">0</div>
                            <span class="dash_title">Minutos</span>
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-3 col-xs-12 dash-glob">
                        <div class="dash seconds_dash">
                            <div class="digit">0</div>
                            <div class="digit">0</div>
                            <span class="dash_title">Segundos</span>
                        </div>
                    </div>

                </div>

                <!-- *************** END / COUNTDOWN *************** -->

            </div>






        </div> <!-- * END / Main content * -->
    </section>
    <!-- ************** END / MAIN FUTURE ************** -->

    <div id="progress2" class="opacity-0">
        <div class="percent"></div>
        <div class="pbar"></div>
    </div>

    <div class="container">
        <div id="subscribe">
            <form method="POST" id="notifyMe" action="<?=base_url();?>assets/pag/php/notify-me.php">
                <div class="form-group">
                    <div class="controls">
                        <input type="text" id="mail-sub" name="email" placeholder="Write your email and stay tuned!" class="form-control email srequiredField">
                    </div>
                </div>
                <button class="btn btn-lg submit">Subscribe</button>
            </form>
        </div>
    </div>

    <div class="container">
        <div id="close-map">
            <a id="close-map-top" class="fa-close-map">
                <i class="fa fa-angle-double-up"></i>
            </a>
        </div>
    </div>

    <audio id="beep-two" preload="auto">
        <source src="<?=base_url();?>assets/pag/sounds/glass-tone.mp3" />
    </audio>

    <!-- ============ Javascript ============ -->
    <script type="text/javascript" src="<?=base_url();?>assets/pag/js/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="<?=base_url();?>assets/pag/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?=base_url();?>assets/pag/js/jquery.lwtCountdown-1.0.js"></script>
    <script type="text/javascript" src="<?=base_url();?>assets/pag/js/jquery.vegas.js"></script>
    <script type="text/javascript" src="<?=base_url();?>assets/pag/js/jquery.popupoverlay.js"></script>
    <script type="text/javascript" src="<?=base_url();?>assets/pag/js/jquery.swipebox.js"></script>
    <script type="text/javascript" src="<?=base_url();?>assets/pag/js/fss.js"></script>

    <script type="text/javascript" src="<?=base_url();?>assets/pag/js/jquery-ui-1.8.16.custom.min.js"></script>
    <script type="text/javascript" src="<?=base_url();?>assets/pag/js/script.js"></script>
    <script type="text/javascript" src="<?=base_url();?>assets/pag/js/notifyMe.js"></script>
    <script type="text/javascript" src="<?=base_url();?>assets/pag/js/jquery.lettering.js"></script>
    <script type="text/javascript" src="<?=base_url();?>assets/pag/js/jquery.textillate.js"></script>
    <script type="text/javascript" src="<?=base_url();?>assets/pag/js/future.js"></script>

    <script>

        /* ============= *** Flat Surface Shader *** ============= */

        topcontainer = document.getElementById('anim-fs');
        renderer = new FSS.CanvasRenderer();
        scene = new FSS.Scene();
        // light = new FSS.Light('#0d2656', '#fc000f');
        light = new FSS.Light('#11424B', '#91C7D2');
        geometry = new FSS.Plane(topcontainer.offsetWidth, topcontainer.offsetHeight, 18, 12);
        material = new FSS.Material('#ffffff', '#ffffff');
        mesh = new FSS.Mesh(geometry, material);
        now = Date.now();
        start = Date.now();

        function initialise() {
            scene.add(mesh);
            scene.add(light);
            topcontainer.appendChild(renderer.element);
            window.addEventListener('resize', resize);
        }

        function resize() {
            renderer.setSize(topcontainer.offsetWidth, topcontainer.offsetHeight);
        }

        function animate() {
            now = Date.now() - start;
            light.setPosition(300 * Math.sin(now * 0.001), 150 * Math.cos(now * 0.0005), 150);
            renderer.render(scene);
            requestAnimationFrame(animate);
        }

        initialise();
        resize();
        animate();
    </script>
    <script>;( function( $ ) {$( '.swipebox' ).swipebox();} )( jQuery );</script>


  </body>
</html>