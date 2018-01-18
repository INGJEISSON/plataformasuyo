<script>
  $(document).ready(function(){
      $(".edicion2").colorbox({
          iframe:false, 
          width:"100%", 
          height:"100%",
          overlayClose:false,
          //escKey:
          });

      });

</script>

<table width="916" border="0" class="table responsive">
                                    <tr>
                                      <td width="159"><strong>Actividad: </strong></td>
                                      <td width="161"><strong>Detalle</strong></td>
                                    </tr>
                                     <?php
                                     $i=1;
                                   while($datos2=pg_fetch_assoc($query3)){

                                          // Consultamos la última observacion de la actividad... 

                                 $sql1="select observacion from activ_diag where cod_activi_etapa='".$datos2['cod_activi_etapa']."' and id_elab_diag='".$_POST['id_elab_diag']."' order by id_activi_diag desc limit 1 ";
                                   $query1=pg_query($conexion, $sql1);
                                   $datos1=pg_fetch_assoc($query1);



                                 ?>
                                    <tr>
                                     
                                      <td height="46"><?php echo ($datos2['descripcion'])?></td>
                                      <td><?php echo $datos1['observacion'] ?></td>
                                    </tr>
                                     <?php
                                             $i++;
                                              }
                                     ?>
                                  </table>