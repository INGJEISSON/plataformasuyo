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


                                 ?>
                                    <tr>
                                     
                                      <td height="46"><?php echo ($datos2['descripcion'])?></td>
                                      <td></td>
                                    </tr>
                                     <?php
                                             $i++;
                                              }
                                     ?>
                                  </table>