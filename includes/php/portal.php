<?php
date_default_timezone_set('America/Bogota');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="img/suyo_colombia_img.jpg">
    <title>Plataforma Suyo (Beta)</title>
    <!-- Bootstrap Core CSS -->
    <link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css" rel="stylesheet">
        <!-- animation CSS -->
    <link href="css/animate.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/style.css" rel="stylesheet">
    <!-- color CSS -->
    <link href="css/colors/megna-dark.css" id="theme" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />
     <script src="plugins/bower_components/jquery/dist/jquery.min.js"></script>

<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.css">  
<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.4.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/buttons/1.4.2/js/buttons.flash.min.js"></script>
<script type="text/javascript" charset="utf8" src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
<script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/buttons/1.4.2/js/buttons.html5.min.js"></script>
<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/buttons/1.4.2/js/buttons.print.min.js"></script>
<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/buttons/1.4.2/js/buttons.colVis.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js"></script>   


<script src="js/charts/js/highcharts.js"></script>
<script src="js/charts/js/modules/exporting.js"></script>
</head>

<body class="fix-header">
    <!-- ============================================================== -->
    <!-- Preloader -->
    <!-- ============================================================== -->
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
        </svg>
    </div>
    <!-- ============================================================== -->
    <!-- Wrapper -->
    <!-- ============================================================== -->
    <div id="wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <nav class="navbar navbar-default navbar-static-top m-b-0">
            <div class="navbar-header">
                <div class="top-left-part">
                    <!-- Logo -->
                    <a class="logo" href="index.html">
                        <!-- Logo icon image, you can use font-icon also --><b>
                        <!--This is dark logo icon--><img src="img/suyo_colombia_img.jpg" alt="home" class="dark-logo" /><!--This is light logo icon--><img src="img/suyo_colombia_img.jpg" alt="home" class="light-logo" width="30" height="30" />
                     </b>
                        <!-- Logo text image you can use text also --><span class="hidden-xs">
                        <!--This is dark logo text--><img src="img/suyo_colombia_img.jpg" alt="home" class="dark-logo" /><font color='black'>SUYO COLOMBIA</font>
                     </span> </a>
                </div>
                <!-- /Logo -->
                <!-- Search input and Toggle icon -->
               <?php include('includes/php/notificacion.php') ?>
                <ul class="nav navbar-top-links navbar-right pull-right">
                    <li>
                        <form  class="app-search hidden-sm hidden-xs m-r-10">
                            <input type="text" placeholder="Buscar clientes" autocomplete="off" id="buscarcliente" class="form-control"> <a href="javascript:;"><i class="fa fa-search"></i></a> </form>
                    </li>
                    <li class="dropdown">
                        <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#"> <img src="<?php echo $_SESSION['imagen'] ?>" alt="user-img" width="36" class="img-circle"><b class="hidden-xs"><?php echo $_SESSION['nombre'] ?></b><span class="caret"></span> </a>
                        <ul class="dropdown-menu dropdown-user animated flipInY">
                            <li>
                                <div class="dw-user-box">
                                    <div class="u-img"><img src="<?php echo $_SESSION['imagen'] ?>" alt="user" /></div>
                                    <div class="u-text">
                                        <h4><?php echo $_SESSION['nombre'] ?></h4>
                                        <p class="text-muted"><?php echo $_SESSION['email']  ?></p><a href="profile.html" class="btn btn-rounded btn-danger btn-sm">Ver Perfil</a></div>
                                </div>
                            </li>
                            <li role="separator" class="divider"></li>                          
                            <li><a href="#"><i class="ti-wallet"></i> Mis activides</a></li>
                            <li><a href="#"><i class="ti-email"></i> Mensajes</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="#"><i class="ti-settings"></i> Configuración de cuenta</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="javascript:;" id="logout"><i class="fa fa-power-off"></i> Logout</a></li>
                        </ul>
                        <!-- /.dropdown-user -->
                    </li>
                    <!-- /.dropdown -->
                </ul>
            </div>
            <!-- /.navbar-header -->
            <!-- /.navbar-top-links -->
            <!-- /.navbar-static-side -->
        </nav>
        <!-- End Top Navigation -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <?php include('includes/php/menus.php') ?>
        <!-- ============================================================== -->
        <!-- End Left Sidebar -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page Content -->
        <!-- ============================================================== -->
        <div id="page-wrapper">
            <center><img src="img/loading.gif" id="carga_modulo"></center>
                         <div id='contenido'>           
                         </div>
            <!-- /.container-fluid -->
              <?php include('includes/php/footer.php') ?>
        </div>
        <!-- ============================================================== -->
        <!-- End Page Content -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
   

    <
    <!-- Bootstrap Core JavaScript -->
    <script src="bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- Menu Plugin JavaScript -->
    <script src="plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js"></script>
    <!--slimscroll JavaScript -->
    <script src="js/jquery.slimscroll.js"></script>
    <!--Wave Effects -->
    <script src="js/waves.js"></script>
    <!-- Custom Theme JavaScript -->
    <script src="js/custom.min.js"></script> 

<

    <script src="plugins/bower_components/toast-master/js/jquery.toast.js"></script>    <!--Style Switcher -->
    <script src="plugins/bower_components/styleswitcher/jQuery.style.switcher.js"></script>
  

    <script type="text/javascript">
   
        $(document).ready(function(){


            $('#carga_modulo').show();
                                               $("#contenido").toggle();    
                                                             $("#contenido").empty();        
                                                                          $("#contenido").load("includes/php/dahsboard_usu.php",
                                                                                       function(){                                  
                                                                                               $('#carga_modulo').hide();
                                                                                                 $("#contenido").show();
                                                                                                    $("#footer").show();
                                              }                               
                             );    


                $("#logout").click(function(){
                
                var datos='logout='+1;
                     $.ajax({
            
                        type: "POST",
                        data: datos,
                        url: 'includes/php/logout.php',
                        success: function(valor){
                           
                               if(valor==1)
                               parent.location='index.php';
                               else
                               alert("No se pudo cerrar sesi杌妌, contacte con el administrador");
                        }
                  });
                
            });
                $("#dashboard").click(function(){

                             $('#carga_modulo').show();
                                               $("#contenido").toggle();    
                                                             $("#contenido").empty();        
                                                                          $("#contenido").load("includes/php/dahsboard_usu.php",
                                                                                       function(){                                  
                                                                                               $('#carga_modulo').hide();
                                                                                                 $("#contenido").show();
                                                                                                    $("#footer").show();
                                              }                               
                             );    
                     });

$('#buscarcliente').typeahead({
  source: function(query, result)
  {
   $.ajax({
    url:"includes/php/fetch.php",
    method:"POST",
    data:{query:query},
    dataType:"json",
    success:function(data)
    {
     result($.map(data, function(item){
      return item;
     }));
    }
   })
  }
 });




        });
    </script>
</body>

</html>
