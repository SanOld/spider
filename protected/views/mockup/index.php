<!DOCTYPE html>
<html lang="en">
    <head>

        <title>Login | SPIder</title>
        <?php include('templates/head.php'); ?>
        

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
        <!--[if lt IE 9]>
          <script src="js/html5shiv.js"></script>
          <script src="js/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="bg">
        <div id="page">
            <!-- Header -->
            <header class="top-head container-fluid">
               <div class="container">
                    <div class="logo p-0 m-t-10 m-b-10 col-lg-6">
                       <span>
                           <img src="images/logo.png" alt="logo">
                       </span>
                   </div>
                   <div class="logo p-0 m-t-20 m-b-15 col-lg-6">
                       <a target="_blank" href="http://service.berlin.de/senatsverwaltungen/" class="pull-right">
                           <img src="images/logo2.png" alt="logo">
                       </a>
                   </div>
               </div>
            </header>
            <!-- Header Ends -->

            <div class="pace pace-inactive">
                <div data-progress="99" data-progress-text="100%" style="transform: translate3d(100%, 0px, 0px);" class="pace-progress">
                    <div class="pace-progress-inner"></div>
                </div>
                <div class="pace-activity"></div>
            </div>

            <div class="wrapper-page animated fadeInDown">
                <div class="panel panel-color panel-primary">
                    <div class="panel-heading"> 
                       <h3 class="text-center m-t-10">Mitglieder Login</h3>
                    </div> 

                    <form id="loginForm" class="cmxform form-horizontal m-t-40" action="home-dashboard.php">
                        <div class="alert alert-danger text-center">
                            Bitte geben Sie die markierten Felder korrekt ein.
                        </div>
                        <div class="form-group has-feedback">
                            <label class="col-xs-12" for="username">Benutzername</label>
                            <div class="col-xs-12 wrap-line">
                                <input class="form-control" type="text" id="username" name="username" autofocus>
                                <span class="glyphicon glyphicon-remove form-control-feedback"></span>
                                <span class="glyphicon glyphicon-ok form-control-feedback"></span>
                            </div>
                        </div>
                        <div class="form-group has-feedback">
                            <label class="col-xs-12" for="password">Passwort</label>
                            <div class="col-xs-12 wrap-line">
                                <input class="form-control" type="password" id="password" name="password" >
                                <span class="glyphicon glyphicon-remove form-control-feedback"></span>
                                <span class="glyphicon glyphicon-ok form-control-feedback"></span>
                            </div>
                        </div>

                        <div class="form-group ">
                            <div class="col-xs-12">
                                <label class="cr-styled">
                                    <input checked="checked" type="checkbox">
                                    <i class="fa"></i> 
                                    Login speichern
                                </label>
                            </div>
                        </div>
                        
                        <div class="form-group text-right">
                            <div class="col-xs-12">
                                <button class="btn btn-block btn-lg btn-purple w-md custom-btn" type="submit">Anmelden</button>
                            </div>
                        </div>
                        <div class="form-group m-t-20">
                            <div class="col-sm-12 text-center">
                                <a href="forgot-password.php">Ihr Passwort vergessen?</a>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="m-t-30">
                    <address class="ng-scope">
                        <strong>Stiftung SPI</strong><br/>
                        Programmagentur Jugendsozialarbeit an Berliner Schulen<br/>
                        Schicklerstr. 5-7<br/>
                        10179 Berlin
                        <p class="m-t-10">Tel.: +49 30 2888-496-0<br />
                        Fax.: +49 30 2888-496-20</p>
                        <p class="m-t-10"><a target="_blank" href="mailto:programmagentur@stiftung-spi.de">Email Senden</a><br/>
                        <a target="_blank" href="http://www.spi-programmagentur.de">www.spi-programmagentur.de</a></p>
                    </address>
                </div>
            </div>
        </div>

        <div class="footer">
            <div class="container">
                <div class="col-lg-12">
                    <a target="_blank" href="http://www.stiftung-spi.de" class="pull-right m-l-15">
                        <img src="images/logo3.png" alt="logo">
                    </a>
                </div>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
        <!-- js placed at the end of the document so the pages load faster -->
        <script src="js/bootstrap.js"></script>
        <script src="js/pace.js"></script>
        <script src="js/wow.js"></script>

        <!--common script for all pages-->
        <script src="js/jquery.js"></script>

        <!-- validation form -->
        <script src="js/jquery.validate.min.js"></script>
        <script src="js/form-validation-init.js"></script>

        <script src="js/sweet-alert.min.js"></script>
        
    </body>
</html>