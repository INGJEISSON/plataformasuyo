<table width="1174" border="0" class="table responsive">
                             <tr>
                               <td width="19"><strong>#</strong></td>
                               <td width="95"><strong>Fecha y hora de revisión:</strong></td>
                               <td width="145"><strong>Observación:</strong></td>
                               <td width="95"><strong>Realizado:</strong></td>
                               <td width="70"><strong>Estado:</strong></td>
                               <td width="74"><strong>Archivo:</strong></td>
                               <td width="66"><strong>Acción</strong></td>
                               <td width="162"><strong>Estado (Cumplimiento)</strong></td>
                               <?php  if($_SESSION['tipo_usuario']==1){ ?><td width="161"><strong>Respuesta:</strong></td><?php } ?>
                               <td width="131"><strong>Fecha de registro</strong>:</td>
                               <td width="110"><strong>Realizado</strong>:</td>
                             </tr>
                             <?php
                             $i=1;
                             while($datos2=pg_fetch_assoc($query2)){
                                 
                                 
                                            @$sql6="select * from serv_cliente  where id_serv_cliente='".$_POST['id_fasfield']."' ";
                                             @$query6=pg_query($conexion, $sql6);
                                             @$rows6=pg_num_rows($query6);
                                             @$datos6=pg_fetch_assoc($query6);
                                            
                             ?>
                             <tr>
                               <td><?php echo $i; ?></td>
                               <td><?php echo $datos2['fecha_registro'] ?></td>
                               <td><?php echo ($datos2['observacion']) ?></td>
                               <td><?php echo ($datos2['usuario']) ?></td>
                               <td><?php echo ($datos2['estado']) ?></td>
                               <td><?php if($datos2['archivo']!=""){ ?>
                                 <a href="../files/<?php echo $datos2['archivo'] ?>" target="_blank"><img src="../../img/icono_pdf.png" width="31" height="31"></a>
                               <?php } ?></td>
                               <td><?php  if($_SESSION['tipo_usuario']==1){ ?><a href="../../includes/php/edicion_usu.php?id_serv_cliente=<?php echo $_POST['id_fasfield'] ?>&cod_cliente=<?php echo $datos6['cod_cliente'] ?>&nom_estado=<?php echo $datos2['estado'] ?>&estado=<?php echo $datos2['cod_estado'] ?>" target="_blank">Responder</a><?php } ?></td>
                               <td>&nbsp;</td>
                               <td>&nbsp;</td>
                               <td>&nbsp;</td>
                               <td>&nbsp;</td>
                             </tr>
                              <?php
                                $i++;
                              }
                             ?>
                           </table>