<?php
$sql="select documentacion.usr_codif,  detalle_docu.cod_cliente, categorias_docu.descripcion as categoria, detalle_docu.ruta as archivo, usuarios.nombre, usuarios.apellidos, estado.descripcion as estado from documentacion, detalle_docu, categorias_docu, estado, usuarios where estado.cod_estado=detalle_docu.cod_estado and documentacion.cod_cliente=detalle_docu.cod_cliente and categorias_docu.id_cate_docu=detalle_docu.id_cate_docu and usuarios.cod_usuario=detalle_docu.cod_usuario and detalle_docu.cod_cliente='".$_POST['cod_cliente']."' and detalle_docu.id_cate_docu='".$_POST['id_cate_docu']."' ";
					$query=pg_query($conexion, $sql);
					$rows=pg_num_rows($query);

       /// Listamos la multimedia.
         $sql_mult2="select * from archivos where id_fastfield='".$_POST['id_fasfield']."' ";
          $query_mult2=pg_query($conexion, $sql_mult2);

        // Listamos facturas
       if($_POST['id_cate_docu']==2){
      $sql_mult3="select id_fasfield from enc_procesadas where id_cliente='".$_POST['cod_cliente']."' and tipo_encuesta=2 ";  
         $query_mult3=pg_query($conexion, $sql_mult3);
      }


?>


<div class="row">
                    <div class="col-sm-12">
                        <div class="white-box">
                            <h3 class="box-title m-b-0">LISTADO DOCUMENTOS DE USUARIO</h3>
                            <div class="table-responsive">
       <table id="table_id6" class='table responsive' cellspacing="0" width="100%">
        <thead>
            <tr>
                <th width="2%">#</th>
                <th width="6%">Categoria</th>
                <th width="11%">Archivo</th>
                <th width="7%">Estado</th>
                <th width="15%">Ver</th>
                <th width="15%">Editar</th>
            </tr>
        </thead>
        <tbody>
         <?php
                $i=1;
                while($datos=pg_fetch_assoc($query)){
			
                    ?>
            <tr>
                <td><?php echo $i ?></td>
                <td><?php echo ($datos["categoria"]) ?></td>
                <td><?php echo ($datos['archivo']) ?></td>
                <td><?php echo ($datos['estado']) ?></td>
            <td><a data-fancybox="images" data-width="1500" data-height="1000" href="../files/clientes/<?php echo $datos['usr_codif']; ?>/<?php echo $datos['categoria']; ?>/<?php echo $datos['archivo']; ?>" tittle='Agregar documentacion' >Ver</a></td>       
            <td><a href="includes/php/add_docu.php?id_cliente=<?php echo $datos['cod_cliente']; ?>" tittle='Agregar documentacion' class="edicion">Deshabilitar</a></td>             
          </tr>
             <?php
			 $i++;
           }
	  ?>
     </tbody>
    </table>
 <?php
               if($_POST['id_cate_docu']==3){
                    ?>

     <table id="table_id61" class='table responsive' cellspacing="0" width="100%">
        <thead>
            <tr>
                <th width="2%">#</th>              
                <th width="11%">Archivo</th>                
                <th width="15%">Ver</th>             
            </tr>
        </thead>
        <tbody>
         <?php
                $i=1;
                   while ($d_archivos=pg_fetch_assoc($query_mult2)){       
          ?>
            <tr>
                <td><?php echo $i ?></td>              
                <td><img src="http://52.40.169.155/fastfield/diagnosticos_2017/<?php echo $d_archivos['ruta'] ?>" height="64" width="64"></td>             
            <td><a data-fancybox="images" data-width="1500" data-height="1000" href="http://52.40.169.155/fastfield/diagnosticos_2017/<?php echo $d_archivos['ruta'] ?>"" tittle='Agregar documentacion' >Ver</a></td>   
          </tr>
             <?php
       $i++;
           }
    ?>
     </tbody>
    </table>
   <?php
               }// Fin si estoy mostrando solo documentos..
   ?>
    <?php
               if($_POST['id_cate_docu']==2){
                    ?>
     <table id="table_id62" class='table responsive' cellspacing="0" width="100%">
        <thead>
            <tr>
                <th width="2%">#</th>              
                <th width="11%">Archivo</th>                
                <th width="15%">Ver</th>             
            </tr>
        </thead>
        <tbody>
         <?php
                $i=1;
                   while ($datos=pg_fetch_assoc($query_mult3)){    

                               $sql_mult2="select ruta from archivos where id_fastfield='".$datos['id_fasfield']."' ";
                               $query_mult2=pg_query($conexion, $sql_mult2);  
                               
                                    while ($d_archivos=pg_fetch_assoc($query_mult2)){   
                    ?>
            <tr>
                <td><?php echo $i ?></td>              
                <td><img src="http://52.40.169.155/fastfield/repor_asesores/<?php echo $d_archivos['ruta'] ?>" height="64" width="64"></td>             
            <td><a data-fancybox="images" data-width="1500" data-height="1000" href="http://52.40.169.155/fastfield/repor_asesores/<?php echo $d_archivos['ruta'] ?>"" tittle='Agregar documentacion' >Ver</a></td>   
          </tr>
             <?php
                                    $i++;
                                  }
       
           }
    ?>
     </tbody>
    </table>

      <?php
               }// Fin si estoy facturas..
      ?>


     </div>
                        </div>
                    </div>
                </div> 

 <script type="text/javascript">
    
$(document).ready(function () {
 $('#table_id6').DataTable();
  $('#table_id61').DataTable();
$('#table_id62').DataTable();

   
});
</script>