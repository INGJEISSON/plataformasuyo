<?php
if($_POST['vistas']==2) // Vista de menús.
$sql="select * from menu ";

          $query=pg_query($conexion, $sql);
          $rows=pg_num_rows($query);

?>


<script>
  $(document).ready(function(){        
       /* $(".edicion").colorbox({
          iframe:false, 
          width:"100%", 
          height:"100%",
          overlayClose:false,
          //escKey:
          });    */      
  });
</script>

<?php if($_POST['vistas']==2){ // Vista de menús.
?>

<div class="row">
                    <div class="col-sm-12">
                        <div class="white-box">
                            <h3 class="box-title m-b-0">LISTADO DE MENUS</h3>
                            <div class="table-responsive">
       <table id="table_id" class='table responsive' cellspacing="0" width="100%">
        <thead>
            <tr>
                <th width="2%">#</th>
                <th width="6%">Nombre del menú</th>
                <th width="11%">Campo</th>
                <th width="7%">Ruta</th>               
                <th width="10%">Fecha de creación</th>
                <th width="15%">Ver/Editar</th>
            </tr>
        </thead>
        <tbody>
         <?php
                $i=1;
                while($datos=pg_fetch_assoc($query)){
      
                    ?>
            <tr>
                <td><?php echo $i ?></td>
                <td><?php echo ($datos["descripcion"]) ?></td>
                <td><?php echo ($datos['campo']) ?></td>
                <td><?php echo ($datos['ruta']) ?></td>
                <td><?php echo ($datos['fecha_registro']) ?></td>
               <td><a href="includes/php/submenus.php?cod_menu=<?php echo $datos['cod_menu']; ?>" tittle='Revisar' class="edicion"><img src='img/edit.png' alt="" width="24" height="24"></a></td>       
          </tr>
             <?php
       $i++;
           }
    ?>
     </tbody>
    </table>
     </div>
                        </div>
                    </div>
                </div>

  <?php
}
?> 
 <script type="text/javascript">
    
$(document).ready(function () {
 $('#table_id').DataTable();
    
});
</script>