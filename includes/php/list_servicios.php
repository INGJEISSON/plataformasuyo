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
                                      <td width="159"><strong>Servicio a cotizar: </strong></td>
                                      <td width="161"><strong>Costo opción 1</strong></td>
                                     <td width="161"><strong>Costo opción 2</strong></td>                                
                                      <td width="66"><strong>Cotizar</strong></td>
                                    </tr>
                                     <?php
                              $i=1;
                              while($datos2=pg_fetch_assoc($query2)){
                      ?>
                                    <tr>
                                     
                                      <td height="46"><?php echo ($datos2['nom_servicio']) ?></td>
                                      <td></td>
                                      <td></td>                                     
                                      <td><strong><a  class='edicion2' href="cotizacion.php?cod_servicio=<?php echo ($datos2['cod_servicio']) ?>&id_serv_recom=<?php echo ($datos2['id_serv_recom']) ?>" class="btn btn-primary">COTIZAR</a></strong></td>
                                      
                                    </tr>
                                     <?php
                      $i++;
                                              }
                        ?>
                                  </table>