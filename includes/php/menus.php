
<div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav slimscrollsidebar">
                <div class="sidebar-head">
                    <h3><span class="fa-fw open-close"><i class="ti-close ti-menu"></i></span> <span class="hide-menu">Navigation</span></h3> </div>
                <ul class="nav" id="side-menu">

<?php

        $sql="select distinct menu.descripcion, menu.ruta, menu.cod_menu FROM permisos_menu, menu where permisos_menu.cod_menu=menu.cod_menu and permisos_menu.cod_usuario='".$_SESSION['cod_usuario']."' and permisos_menu.cod_permiso=5 ";
                $query=mysqli_query($conexion, $sql);
            $rows=mysqli_num_rows($query);

                    if($rows){ // Encontró menus...  y sub menus habilitados..

                                            $i=2;
                                            
                                            while($datos=mysqli_fetch_assoc($query)){    

    $sql2="select  submenu.descripcion, submenu.ruta, submenu.comentario from submenu, permisos_menu where submenu.cod_submenu=permisos_menu.cod_submenu and permisos_menu.cod_menu='".$datos['cod_menu']."' and permisos_menu.cod_permiso=5 and  permisos_menu.cod_usuario='".$_SESSION['cod_usuario']."' order by submenu.m_order ";
                                                $query2=mysqli_query($conexion, $sql2);
                                                $rows2=mysqli_num_rows($query2);          
                                           
?>


                    
                    <li> <a href="index.html" class="waves-effect"><span class="hide-menu"><?php echo utf8_encode($datos['descripcion']); ?></a>
                                              <?php
                                                                    
                                                    if($rows2){

                                                ?>
                        <ul class="nav nav-second-level">
                                        <?php
                                                            $j=2;
                                                                    while($datos2=mysqli_fetch_assoc($query2)){
                                                    ?>
                            <li> <a href="javascript:;" id='var<?php echo $i."".$j ?>'><span class="hide-menu"><?php echo utf8_encode($datos2['descripcion']); ?></span></a> </li>

                                                                    <script>
                                                                                                $(document).ready(function(){


                                                                                                            $("#var<?php echo $i."".$j ?>").click(function(){
                                                                                                               

                                                                                                                    $('#carga_modulo').show();
                                                                                                                       $("#contenido").toggle();    
                                                                                                                                  $("#contenido").empty();        
                                                                                                                                    $("#contenido").load("includes/php/<?php echo $datos2['ruta'] ?>",
                                                                                                                                           function(){                                  
                                                                                                                                              $('#carga_modulo').hide();
                                                                                                                                              $("#contenido").show();
                                                                                                                                               $("#footer").show();
                                                                                                                                          }                               
                                                                                                                     );     
                                                                                                            });
                                                                                                            
                                                                                                });
                                                                                    </script> 
                                            <?php
                                                                                $j++;

                                                                     } // Fin bucle de los submenús...
                                             ?>
                           
                        </ul>
                    </li>
                    <?php
                                                            

                                                         }
                                                   $i++;
                                                }// Fin bucle de los menús...
        
                    }               

            ?>


                    
                </ul>
            </div>
</div>