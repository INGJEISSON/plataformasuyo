<?php
include('../dependencia/conexion.php');
        // Consultamos los datos del cliente..
        $sql="select * from cliente where cod_cliente='".$_GET['cod_cliente']."' ";
        $query=pg_query($conexion, $sql);
        $datos=pg_fetch_assoc($query);

        // Consultamos la cantidad diagnósticos que tiene el cliente..

        // Consultamos la cantidad de servicios que tiene el cleinte..

        $sql3="select  * from serv_cliente where cod_cliente='".$_GET['cod_cliente']."' ";
        $query3=pg_query($conexion, $sql3);
        $rows3=pg_num_rows($query3);


        //Buscamos la multimedia relacionada con el cliente, 
         $sql_mult="select distinct enc_procesadas.id_cliente, enc_procesadas.arch_pdf, enc_procesadas.id_fasfield, tipo_encuesta.nombre as encuesta from enc_procesadas, tipo_encuesta where enc_procesadas.tipo_encuesta=tipo_encuesta.tipo_encuesta and enc_procesadas.id_cliente='".$_GET['cod_cliente']."' and enc_procesadas.tipo_encuesta=1 limit 1 ";
        $query_mult=pg_query($conexion, $sql_mult);
        $datos2=pg_fetch_assoc($query_mult);
          $archivo_pdf2=$datos2['arch_pdf'];

            /// Listamos la multimedia.
         $sql_mult2="select * from archivos where id_fastfield='".$datos2['id_fasfield']."' ";
          $query_mult2=pg_query($conexion, $sql_mult2);

             /// Listamos los archivos de facturas multimedia.
         $sql_mult3="select * from archivos where id_fastfield='".$datos2['id_fasfield']."' ";
          $query_mult2=pg_query($conexion, $sql_mult2);



// Listamos los servicios del cliente..

          $s="select distinct  serv_cliente.cod_usuario, serv_cliente.id_serv_cliente, servicios.nom_servicio, servicios.cod_servicio,  acuer_pago.descripcion as acuer_pago, serv_cliente.porc_pagado, serv_cliente.valor, estado.descripcion as estado from acuer_pago, servicios, estado, serv_cliente where  servicios.cod_servicio=serv_cliente.cod_servicio  and acuer_pago.cod_acuer_pago=serv_cliente.cod_acuer_pago and estado.cod_estado=serv_cliente.cod_estado and serv_cliente.cod_cliente='".$_GET['cod_cliente']."' ";
          $q=pg_query($conexion, $s);
          $t=pg_query($conexion,$s);
          $rowsq=pg_num_rows($q);

          //Listamos los responsables de los servicios

           $s1="select distinct usuarios.foto, usuarios.nombre as usuarios, usuarios.tipo_usuario, usuarios.telefono_1, serv_cliente.cod_servicio from usuarios,  serv_cliente where usuarios.cod_usuario=serv_cliente.cod_usuario and serv_cliente.cod_cliente='".$_GET['cod_cliente']."' ";
          $q1=pg_query($conexion, $s1);

          // Listamos las comunicaciones que ha tenido el cliente...

         



          
?>
 <script src="../../plugins/bower_components/jquery/dist/jquery.min.js"></script>
 <link href="../../bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />
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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.2.5/jquery.fancybox.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.2.5/jquery.fancybox.min.js"></script>

 <!-- Bootstrap Core JavaScript -->
    <script src="../../bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- Menu Plugin JavaScript -->
    <script src="../../plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js"></script>
    <!--slimscroll JavaScript -->
    <script src="../../js/jquery.slimscroll.js"></script>
    <!--Wave Effects -->
    <script src="../../js/waves.js"></script>
    <!-- Custom Theme JavaScript -->
    <script src="../../js/custom.min.js"></script> 


<script>


$(document).ready(function(){
 $("[data-fancybox]").fancybox({
    iframe : {
        css : {
            width : '1024px',
            height: '600px'
        }
    }
});  

 $("#v_otros").click(function(){
    var cod_cliente="<?php echo "$_GET[cod_cliente]" ?>";
    var id_fasfield="<?php echo "$datos2[id_fasfield]" ?>";

    var datos='vista_docu='+1+'&cod_cliente='+cod_cliente+'&id_cate_docu='+3+'&id_fasfield='+id_fasfield;

                    $.ajax({
                            type: "POST",
                            url: '../../includes/php/g_procesos.php',
                            data: datos,
                            success: function(valor){

                                 $("#content_docu").empty();
                                    $("#content_docu").html(valor);
                            }

                    });
 });

  $("#v_facturas").click(function(){
    var cod_cliente="<?php echo "$_GET[cod_cliente]" ?>";
    var id_fasfield="<?php echo "$datos2[id_fasfield]" ?>";

    var datos='vista_docu='+1+'&cod_cliente='+cod_cliente+'&id_cate_docu='+2+'&id_fasfield='+id_fasfield;

                    $.ajax({
                            type: "POST",
                            url: '../../includes/php/g_procesos.php',
                            data: datos,
                            success: function(valor){

                                 $("#content_docu").empty();
                                    $("#content_docu").html(valor);
                            }

                    });
 });

  $("#v_ana_caso").click(function(){
    var cod_cliente="<?php echo "$_GET[cod_cliente]" ?>";
    var id_fasfield="<?php echo "$datos2[id_fasfield]" ?>";

    var datos='vista_docu='+1+'&cod_cliente='+cod_cliente+'&id_cate_docu='+4+'&id_fasfield='+id_fasfield;

                    $.ajax({
                            type: "POST",
                            url: '../../includes/php/g_procesos.php',
                            data: datos,
                            success: function(valor){

                                 $("#content_docu").empty();
                                    $("#content_docu").html(valor);
                            }

                    });
 });

});


</script>
 <div class="container-fluid">
                <div class="row bg-title">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title">PERFIL DEL CLIENTE</h4>  <?php echo $datos['nombre'] ?>  </div>
                   
                    <!-- /.col-lg-12 -->
                </div>
                <!-- row -->
                <div class="row">
                    <div class="col-md-4 col-xs-12">
                        <div class="white-box">
                            <div class="user-bg"> <img width="50%" alt="user" align="text-center" src="../../img/Profile.png"> </div>
                            <div class="user-btm-box">
                                <!-- .row -->
                                <div class="row text-center m-t-10">
                                    <div class="col-md-6 b-r"><strong>Nombre</strong>
                                        <p><?php echo $datos['nombre'] ?> </p>
                                    </div>
                                    <div class="col-md-6"><strong>Ciudad</strong>
                                       <p><?php echo $datos['ciudad'] ?> </p>
                                    </div>
                                </div>
                                <!-- /.row -->
                                <hr>
                                <!-- .row -->
                                <div class="row text-center m-t-10">
                                    <div class="col-md-6 b-r"><strong>Ubicación de Predios</strong>
                                        <p><img src='../../img/map-pin-location.jpg' width='80' height='80'></p>
                                    </div>
                                    <div class="col-md-6"><strong>Teléfono</strong>
                                        <p><?php echo $datos['telefono_1'] ?> </p>
                                    </div>
                                </div>
                                <!-- /.row -->
                                <hr>
                                <!-- .row -->
                                <div class="row text-center m-t-10">
                                    <div class="col-md-12"><strong>Dirección</strong>
                                       <p><?php echo $datos['direccion_predio'] ?> </p>
                                    </div>
                                </div>
                                <hr>
                                <!-- /.row -->
                                <div class="col-md-4 col-sm-4 text-center">
                                    <p class="text-purple">Prospectos</i></p>
                                    <h1></h1> </div>
                                <div class="col-md-4 col-sm-4 text-center">
                                    <p class="text-blue">Diagnósticos</p>
                                    <h1></h1> </div>
                                <div class="col-md-4 col-sm-4 text-center">
                                    <p class="text-danger">Servicios</p>
                                    <h1><?php echo $rows3 ?></h1> </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-8 col-xs-12">
                        <div class="white-box">
                            <!-- .tabs -->
                            <ul class="nav nav-tabs tabs customtab">
                                <li class="active tab">
                                    <a href="#comunicacion" data-toggle="tab"> <span class="visible-xs"><i class="fa fa-home"></i></span> <span class="hidden-xs">Comunicaciones</span> </a>
                                </li>
                                <li class="tab">
                                    <a href="#diagnosticos" data-toggle="tab"> <span class="visible-xs"><i class="fa fa-user"></i></span> <span class="hidden-xs">Diagnósticos</span> </a>
                                </li>
                                <li class="tab">
                                    <a href="#servicios" data-toggle="tab" aria-expanded="false"> <span class="visible-xs"><i class="fa fa-cog"></i></span> <span class="hidden-xs">Servicios</span> </a>
                                </li>
                                <li class="tab">
                                    <a href="#documentos" data-toggle="tab" aria-expanded="false"> <span class="visible-xs"><i class="fa fa-cog"></i></span> <span class="hidden-xs">Documentos</span> </a>
                                </li>   

                                <li class="tab">
                                    <a href="#responsables_caso" data-toggle="tab" aria-expanded="false"> <span class="visible-xs"><i class="fa fa-cog"></i></span> <span class="hidden-xs">Responsables del caso</span> </a>
                                </li>                               
                            </ul>
                            <!-- /.tabs -->
                            <div class="tab-content">
                                <!-- .tabs 1 -->
                                <div class="tab-pane active" id="comunicacion">
                                    <div class="steamline">

                                    <?php 
                                         if( $rowsq){   
                                         $i=1;   
                                         $no_reg=1;                                     
                                             while ($datos=pg_fetch_assoc($t)){ 

                                                          $sql11="select seguimientos.fecha_registro, seguimientos.archivo, seguimientos.observacion, estado.descripcion as estado, estado.cod_estado, usuarios.nombre as usuario, usuarios.foto from seguimientos, usuarios, estado where seguimientos.cod_usuario=usuarios.cod_usuario and seguimientos.cod_estado=estado.cod_estado and seguimientos.id_fasfield='".$datos['id_serv_cliente']."' and seguimientos.cod_usuario!=0 and seguimientos.tipo_seguimiento=6 order by seguimientos.id_segui_llam desc limit 3  ";
                                                        $query11=pg_query($conexion, $sql11);
                                                        @$datos11=pg_fetch_assoc($query11);
                                                        $rows=pg_num_rows($query11);    

                                                                if($rows){
                                                                                             
                                        ?> 
                               
                                        
                                        <div class="sl-item">
                                            <div class="sl-left"> <img src="<?php echo $datos11['foto']  ?>" alt="user" class="img-circle" /> </div>
                                            <div class="sl-right">
                                                <div class="m-l-40"> <a href="#" class="text-info"><?php echo $datos11['usuario']  ?></a> <span class="sl-date"><?php echo $datos11['fecha_registro']  ?></span>
                                                    <div class="m-t-20 row">
                                                        <div class="col-md-2 col-xs-12"><b>Caso: </b> <?php echo $datos['nom_servicio']  ?> </div>
                                                        <div class="col-md-9 col-xs-12">
                                                            <p><?php echo $datos11['observacion']  ?></p></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> 
                                    <?php 
                                                                }else{
                                                                    $no_reg++;
                                                                    
                                                                }
                                                               
                                                    $i++;
                                                    }
                                                        if($no_reg==$i)
                                                            echo "Ninguna registro de comunicación hasta ahora";
                                            }
                                        ?> 


                                    </div>
                                </div>
                                <!-- /.tabs1 -->
                                <!-- .tabs2 -->
                                <div class="tab-pane" id="diagnosticos">

                                Estado del diagnóstico  (Modúlo en desarrollo)
                                <!--  <div class="row">
                                        <div class="col-md-3 col-xs-6 b-r"> <strong>Full Name</strong>
                                            <br>
                                            <p class="text-muted">Johnathan Deo</p>
                                        </div>
                                        <div class="col-md-3 col-xs-6 b-r"> <strong>Mobile</strong>
                                            <br>
                                            <p class="text-muted">(123) 456 7890</p>
                                        </div>
                                        <div class="col-md-3 col-xs-6 b-r"> <strong>Email</strong>
                                            <br>
                                            <p class="text-muted">johnathan@admin.com</p>
                                        </div>
                                        <div class="col-md-3 col-xs-6"> <strong>Location</strong>
                                            <br>
                                            <p class="text-muted">London</p>
                                        </div>
                                    </div>
                                  <hr>
                                    <p class="m-t-30">Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt.Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim.</p>
                                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries </p>
                                    <p>It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                                    <h4 class="font-bold m-t-30">Skill Set</h4>
                                    <hr>
                                    <h5>Wordpress <span class="pull-right">80%</span></h5>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width:80%;"> <span class="sr-only">50% Complete</span> </div>
                                    </div>
                                    <h5>HTML 5 <span class="pull-right">90%</span></h5>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-custom" role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100" style="width:90%;"> <span class="sr-only">50% Complete</span> </div>
                                    </div>
                                    <h5>jQuery <span class="pull-right">50%</span></h5>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:50%;"> <span class="sr-only">50% Complete</span> </div>
                                    </div>
                                    <h5>Photoshop <span class="pull-right">70%</span></h5>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:70%;"> <span class="sr-only">50% Complete</span> </div>
                                    </div>-->
                                </div>
                                <!-- /.tabs2 -->
                                <!-- .tabs3 -->
                               
                                <div class="tab-pane" id="servicios">

                                         <?php 
                                         if( $rowsq){
                                            $i=1;
                                             while ($datos=pg_fetch_assoc($q)){ 

                                                         $sql11="select  usuarios.nombre as usuario, activ_serv.observacion, activ_serv.fecha_actividad, activ_serv.fecha_registro, etapa_activ.descripcion as etapa, activi_etapa.descripcion as actividad from usuarios, etapa_activ, activ_serv, activi_etapa where usuarios.cod_usuario=activ_serv.cod_usu_respon and etapa_activ.cod_etapa=activi_etapa.cod_etapa and activ_serv.cod_activi_etapa=activi_etapa.cod_activi_etapa and activ_serv.id_serv_cliente='".$datos['id_serv_cliente']."' order by activ_serv.id_activi_serv desc limit 1 ";
                                                        $query11=pg_query($conexion, $sql11);
                                                        @$datos11=pg_fetch_assoc($query11);
                                                                                             
                                        ?> 
                               
                                    <div class="row">
                                        <div class="col-md-3 col-xs-6 b-r"> <strong><font color='red'>Servicio #<?php echo $i ?></font></strong>
                                            <br>
                                            <p class="text-muted"> <?php echo $datos['nom_servicio']  ?> </p>
                                        </div>
                                        <div class="col-md-3 col-xs-6 b-r"> <strong>Estado</strong>
                                            <br>
                                            <p class="text-muted"><?php echo $datos11['etapa']; ?></p>
                                        </div>
                                        <div class="col-md-3 col-xs-6 b-r"> <strong>Última actuación</strong>
                                            <br>
                                            <p class="text-muted"><?php echo $datos11['actividad']; ?></p>
                                        </div>
                                        <div class="col-md-3 col-xs-6"> <strong>Detalle</strong>
                                            <br>
                                            <p class="text-muted"><?php echo $datos11['observacion']; ?></p>
                                        </div>
                                        <div class="col-md-3 col-xs-6"> <strong>Fecha ult.actuación</strong>
                                            <br>
                                            <p class="text-muted"><?php echo $datos11['fecha_actividad']; ?></p>
                                        </div>

                                        <div class="col-md-3 col-xs-6"> <strong>Responsable</strong>
                                            <br>
                                                     <p class="text-muted"><?php echo $datos11['usuario']; ?></p>
                                        </div>

                                        <div class="col-md-3 col-xs-6"> <strong>Ver seguimiento</strong>
                                                 <br>
                                                     <p class="text-muted"><a data-fancybox data-type="iframe" style="cursor: pointer;" data-src="includes/php/ver_seguimiento.php?id_serv_cliente=<?php echo $datos['id_serv_cliente'] ?>&cod_servicio=<?php echo $datos['cod_servicio'] ?>&cod_cliente=<?php echo $_GET['cod_cliente'] ?>" class='edicion'>Visualizar</a></p>
                                        </div>

                                        <div class="col-md-12 col-xs-12 b-r"></strong>
                                            
                                           <hr>
                                        </div>
                                    </div>

                                             <?php 
                                             $i++;
                                                  }
                                         }

                                    ?> 

                                </div> 

                                <div class="tab-pane" id="documentos">
                                   <div class="row">
                                        <div class="col-md-3 col-xs-6 b-r"> <strong>Documentos de propiedad</strong>
                                            <br>
                                            <p class="text-muted">Visualizar</p>
                                        </div>
                                        <div class="col-md-3 col-xs-6 b-r"> <strong>Facturas y contratos</strong>
                                            <br>
                                            <p class="text-muted"><a id='v_facturas' href="javascript:;">Visualizar</a></p>
                                        </div>
                                        <div class="col-md-3 col-xs-6 b-r"> <strong>Otros documentos</strong>
                                            <br>
                                           <p class="text-muted"><a id='v_otros' href="javascript:;">Visualizar</a></p>
                                        </div>
                                        <div class="col-md-3 col-xs-6"> <strong>Análisis de caso</strong>
                                            <br>
                                            <p class="text-muted"><a id='v_ana_caso' href="javascript:;">Visualizar</a></p>
                                        </div>

                                        <div class="col-md-3 col-xs-6"> <strong>Encuesta Diagnóstico</strong>
                                            <br>
                                            <p class="text-muted"><a data-fancybox data-type="iframe" style="cursor: pointer;" data-src="http://52.40.169.155/fastfield/<?php echo $datos2['encuesta'] ?>/procesados/<?php echo $datos2['id_fasfield']."/".$archivo_pdf2 ?>" tittle='Revisar'><img src="../../img/icono_pdf.png" width="31" height="31"></a></p>
                                        </div>

                                        <div class="col-md-3 col-xs-6"> <strong>Adjuntar archivos</strong>
                                            <br>
                                            <p class="text-muted"><a data-fancybox data-type="iframe" style="cursor: pointer;" data-src='add_docu.php?id_cliente=<?php echo $_GET['cod_cliente'] ?>'>Ingresar</a></p>
                                           
                                        </div>
                                    </div>

                                    <div class="row" id='content_docu'>
                                        <div class="col-md-12 col-xs-12 b-r"> 
                                       
                                        </div>
                                        
                                    </div>


                                </div> 

                                <div class="tab-pane" id="responsables_caso">
                                    <!-- Diagnósticos-->
                                      <!-- <div class="col-md-4 col-sm-4">
                                            <div class="white-box">
                                                <div class="row">
                                                    <div class="col-md-4 col-sm-4 text-center">
                                                        <a href="contact-detail.html"><img src="../plugins/images/users/genu.jpg" alt="user" class="img-circle img-responsive"></a>
                                                    </div>
                                                    <div class="col-md-8 col-sm-8">
                                                        <h3 class="box-title m-b-0">JUAN PABLO MONTOYA</h3>
                                                        <p>
                                                            <address>
                                                                <b>Asignación:</b> 2017-01-11
                                                                <br/>
                                                                <b>Caso: </b>Diagnóstico
                                                                <br/>
                                                                <b>Area: </b>Técnico
                                                                <br/>
                                                                <abbr title="Teléfono"><b>Teléfono: </b></abbr>(123) 456-7890
                                                            </address>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>-->
                                          <hr>
                                        <!-- Servicios-->

                                        <?php 
                                             while ($datos=pg_fetch_assoc($q1)){ 

                                                $sql="select servicios.nom_servicio from servicios where cod_servicio='".$datos['cod_servicio']."' ";
                                                $query=pg_query($conexion, $sql);
                                                $datos2=pg_fetch_assoc($query);

                                                $sql2="select grupo_usuarios.descripcion as area from tipo_usuario, grupo_usuarios where tipo_usuario.cod_grupo=grupo_usuarios.cod_grupo and tipo_usuario.tipo_usuario='".$datos['tipo_usuario']."' ";
                                                $query3=pg_query($conexion, $sql2);
                                                $datos3=pg_fetch_assoc($query3);
                                        ?> 
                                        <div class="col-md-4 col-sm-4">
                                            <div class="white-box">
                                                <div class="row">
                                                    <div class="col-md-4 col-sm-4 text-center">
                                                        <a href="contact-detail.html"><img src="<?php echo $datos['foto'] ?>" alt="user" class="img-circle img-responsive"></a>
                                                    </div>
                                                    <div class="col-md-8 col-sm-8">
                                                        <h3 class="box-title m-b-0"><?php echo $datos['usuarios'] ?> </h3>
                                                        <p>
                                                            <address>
                                                                <b>Asignación:</b>
                                                                <br/>
                                                                <b>Caso: </b><?php echo $datos2['nom_servicio'] ?>
                                                                <br/>
                                                                <b>Area: </b><?php echo $datos3['area'] ?>
                                                                <br/>
                                                                <abbr title="Teléfono"><b>Teléfono: </b></abbr> <?php echo $datos['telefono_1'] ?>
                                                            </address>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <?php 
                                           }
                                        ?> 
                                         
                                </div> 
                                <!-- /.tabs3 -->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
                <!-- ============================================================== -->
                <!-- Right sidebar -->
                <!-- ============================================================== -->
                <!-- .right-sidebar -->
                <
                <!-- ============================================================== -->
                <!-- End Right sidebar -->
                <!-- ============================================================== -->
            </div>
                

                 <div id='repor'>   
            
                </div>

                <!-- /.row -->
<script type="text/javascript">
      /*global $, document*/
$(document).ready(function () {
    
$("#cargando2").hide(); 
    $('#example23').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    }); 
        
                $("#registrar").click(function(){

                        var nombre = $("#nombre").val();
                        var apellidos = $("#apellidos").val();
                        var tipo_docu = $("#tipo_docu").val();
                        var id_cliente= $("#id_cliente").val();
                        var cod_bodega= $("#cod_bodega").val();
                        var cod_estante= $("#cod_estante").val();
                        var ubicacion =$("#ubicacion").val();

                        if(id_cliente!=0 && cod_bodega!=0 && cod_estante!=0 && ubicacion!=0 && tipo_docu!=0){


                                var datos ='g_add_docu='+1+'&nombre='+nombre+'&apellidos='+apellidos+'&tipo_docu='+tipo_docu+'&create='+1+'&id_cliente='+id_cliente+'&cod_bodega='+cod_bodega+'&cod_estante='+cod_estante+'&ubicacion='+ubicacion;

                                                $.ajax({
                                                     type: "POST",
                                                     data: datos,
                                                     url: '../../includes/php/g_procesos.php',
                                                     success: function(valor){

                                                                if(valor==1){

                                                                    alert("Registro realizado correctamente");
                                                                  var datos='g_add_docu='+1+'&listar_usuarios='+1;
    $.ajax({
                                                     type: "POST",
                                                     data: datos,
                                                     url: 'includes/php/g_procesos.php',
                                                     success: function(valor){
                                                            $("#repor").html(valor);
                                                            
                                                     }

                                                });

                                                                }else if(valor==2){
                                                                    alert("Ocurrió un problema al registrar el usuario");
                                                                }
                                                                else if(valor==3){
                                                                    alert("El Cliente y/o empleado ya existe");
                                                                }
                                                     }

                                                });
                        }else
                        alert("Por favor complete los campos con asterícos son obligatorios");

                });

});

  
</script>  