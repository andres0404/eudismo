<?php
    include_once("../../business/class.sessions.php");// clase para inicio de sesion
    SessionPostulantes::verificarSesion();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admin</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="../bower_components/bootstrap/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../bower_components/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="../bower_components/Ionicons/css/ionicons.min.css">
    <link rel="stylesheet" href="../bower_components/select2/dist/css/select2.min.css">
    <link rel="stylesheet" href="../dist/css/skins/_all-skins.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
          page. However, you can choose any other skin. Make sure you
          apply the skin class to the body tag so the changes take effect. -->
    <link rel="stylesheet" href="../dist/css/skins/skin-blue.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="../plugins/iCheck/flat/blue.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <script src="../js/stores.js"></script>
    <script src="../js/translate.js"></script>
    <script src="../js/functions.js"></script>
    <style>
        .example-modal .modal {
          position: relative;
          top: auto;
          bottom: auto;
          right: auto;
          left: auto;
          display: block;
          z-index: 1;
        }

        .example-modal .modal {
          background: transparent !important;
        }
    </style>
</head>

<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        <!-- Main Header -->
        <header class="main-header">
            <!-- Logo -->
            <a href="#" class="logo">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <span class="logo-mini"><b>A</b>E</span>
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg"><b>App</b>EUDISTA</span>
            </a>
            <!-- Header Navbar -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                    <span class="sr-only">Toggle navigation</span>
                </a>
                <!-- Navbar Right Menu -->
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <!-- User Account Menu -->
                        <li class="dropdown user user-menu">
                            <!-- Menu Toggle Button -->
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <!-- The user image in the navbar-->
                                <img src="../../resources/img/user.png" class="user-image" alt="User Image">
                                <!-- hidden-xs hides the username on small devices so only the image appears. -->
                                <span class="hidden-xs"> Admin</span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- The user image in the menu -->
                                <li class="user-header">
                                    <img src="../../resources/img/user.png" class="img-circle" alt="User Image">
                                    <p> Administrador</p>
                                </li>

                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-right">
                                        <a href="../../business/class.sessions.php?kill=1" class="btn btn-default btn-flat" ocvn>Cerrar sesión</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <!-- Left side column. contains the logo and sidebar -->
        <aside class="main-sidebar">
            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel">
                    <div class="pull-left image">
                        <img src="../../resources/img/logo-115.png" class="img-circle" alt="User Image">
                    </div>
                    <div class="pull-left info">
                        <p>Administrador</p>
                        <!-- Status -->
                        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                    </div>
                </div>
                <!-- Sidebar Menu -->
                <ul class="sidebar-menu" data-widget="tree">
                    <li class="header">MENÚ DE NAVEGACIÓN</li>
                    <li>
                        <a href="../cjm/">
                            <i class="fa fa-home"></i> <span>La CJM</span>
                        </a>
                    </li>                   
                    <li class="active">
                        <a href="../temas/">
                            <i class="fa fa-area-chart"></i> <span>Temas fundamentales</span>
                        </a>
                    </li>                                  
                    <li>
                        <a href="../formar/">
                            <i class="fa fa-area-chart"></i> <span>Formar a Jesús</span>
                        </a>
                    </li>                                  
                    <li>
                        <a href="../oraciones/">
                            <i class="fa fa-area-chart"></i> <span>Oraciones</span>
                        </a>
                    </li>                                  
                    <li>
                        <a href="../cantos/">
                            <i class="fa fa-area-chart"></i> <span>Cantos Eudistas</span>
                        </a>
                    </li>                                  
                    <li>
                        <a href="../familia/">
                            <i class="fa fa-area-chart"></i> <span>La gran familia Eudista</span>
                        </a>
                    </li>                                                                    
                    <li>
                        <a href="../novedades/">
                            <i class="fa fa-area-chart"></i> <span>Novedades / Noticias</span>
                        </a>
                    </li>     
                    <li>
                        <a href="./">
                            <i class="fa fa-area-chart"></i> <span>Testimonios</span>
                        </a>
                    </li>    
                    
                    
                </ul>
            <!-- /.sidebar-menu -->
            </section>
        <!-- /.sidebar -->
        </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
    <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1 id="studentNames"></h1>
        </section>
        <!-- Main content -->
        <section class="content container-fluid">
            <section class="content">
                <div class="row">
 
                    <div class="col-md-12">
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">Testimonios</h3>
                                <!-- /.box-tools -->
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body no-padding">

                                <div class="table-responsive mailbox-messages">
                                    <!-- Custom tabs (Language with tabs)-->
                                    <div class="nav-tabs-custom">
                                      <!-- Tabs within a box -->
                                        <ul class="nav nav-tabs">
                                            <li class="active">
                                                <a href="#lg-es" data-toggle="tab">
                                                    <img src="../../resources/img/langs/co.png" style="width: 15px;margin-top: -2px;"/>
                                                     Español
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#lg-en" data-toggle="tab"  onclick="csl.init(10, 16, 'en', 2)">
                                                    <img src="../../resources/img/langs/us.png" style="width: 18px;margin-top: -2px;"/>
                                                    Inglés
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#lg-fr" data-toggle="tab"  onclick="csl.init(10, 16, 'fr', 3)">
                                                    <img src="../../resources/img/langs/fr.png" style="width: 18px;margin-top: -2px;"/>
                                                    Francés
                                                </a>
                                            </li>     
                                            <li>
                                                <a href="#lg-de" data-toggle="tab"  onclick="csl.init(10, 16, 'de', 4)">
                                                    <img src="../../resources/img/langs/de.png" style="width: 18px;margin-top: -2px;"/>
                                                    Alemán
                                                </a>
                                            </li>                                             
                                            <li>
                                                <a href="#lg-it" data-toggle="tab" onclick="csl.init(10, 16, 'it', 5)">
                                                    <img src="../../resources/img/langs/it.png" style="width: 18px;margin-top: -2px;"/>
                                                    Italiano
                                                </a>
                                            </li>   
                                            <li>
                                                <a href="#lg-pt" data-toggle="tab" onclick="csl.init(10, 16, 'pt', 6)">
                                                    <img src="../../resources/img/langs/pt.png" style="width: 18px;margin-top: -2px;"/>
                                                    Portugués
                                                </a>
                                            </li>  
                                        </ul>
                                        <div class="tab-content no-padding">
                                            <div class="chart tab-pane active" id="lg-es" style="position: relative;"></div>
                                            <div class="chart tab-pane" id="lg-en" style="position: relative;"></div>
                                            <div class="chart tab-pane" id="lg-fr" style="position: relative;"></div>
                                            <div class="chart tab-pane" id="lg-de" style="position: relative;"></div>
                                            <div class="chart tab-pane" id="lg-it" style="position: relative;"></div>
                                            <div class="chart tab-pane" id="lg-pt" style="position: relative;"></div>
                                        </div>

                                    </div>
                                    
                                    
                                    
                                  <!-- /.table -->
                                </div>
                                <!-- /.mail-box-messages -->
                            </div>

                        </div>
                    </div>
                    <!-- /. box -->
                </div>
                <!-- /.col -->
            <!-- /.row -->
            </section>

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Main Footer -->
    <footer class="main-footer">
        <!-- To the right -->
        <div class="pull-right hidden-xs">
          Campus Virtual Uniminuto
        </div>
        <!-- Default to the left -->
        <strong>Copyright &copy; 2016 <a href="http://uvd.uniminuto.edu/" target="blank">UVD Uniminuto</a>.</strong>
    </footer>


    <!-- /.control-sidebar -->
    <!-- Add the sidebar's background. This div must be placed
    immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
    
    
    
</div>
<!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 3 -->
<script src="../bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.min.js"></script>
<!-- Select2 -->
<script src="../bower_components/select2/dist/js/select2.full.min.js"></script>
<script>
    $('.select2').select2()
    csl.init(10, 16, 'es', 1);
    var arrD = [10, 16];
</script>
</body>
</html>