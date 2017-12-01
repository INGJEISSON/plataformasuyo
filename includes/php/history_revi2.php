<table width="1015" border="0" class="table responsive">
                             <tr>
                               <td width="39"><strong>#</strong></td>
                               <td width="181"><strong>Fecha y hora de revisión:</strong></td>
                               <td width="78"><strong>Etapa:</strong></td>
                               <td width="288"><strong>Actividad:</strong></td>
                               <td width="148"><strong>Fecha de actividad</strong></td>
                               <td width="125"><strong>Observación:</strong></td>
                               <td width="126"><strong>Realizado:</strong></td>
                             </tr>
                             <?php
                             $i=1;
                             while($datos2=pg_fetch_assoc($query2)){
                             ?>
                             <tr>
                               <td><?php echo $i; ?></td>
                               <td><?php echo $datos2['fecha_registro'] ?></td>
                               <td><?php echo strtoupper(($datos2['etapa'])) ?></td>
                               <td style="alignment-adjust:auto"><?php echo ($datos2['actividad']) ?></td>
                               <td><?php echo $datos2['fecha_actividad'] ?></td>
                               <td><?php echo $datos2['observacion'] ?></td>
                               <td><?php echo $datos2['usuario'] ?></td>
                             </tr>
                              <?php
                                $i++;
                              }
                             ?>
                           </table>