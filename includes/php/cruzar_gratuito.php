<?php
include('../dependencia/conexion.php');
$sql="select  distinct det_repor_aseso.aliado, enc_procesadas.cod_estado, enc_procesadas.asesor, enc_procesadas.id_cliente, tipo_encuesta.nombre as encuesta, enc_procesadas.arch_pdf, enc_procesadas.cliente, enc_procesadas.fecha_filtro, enc_procesadas.ciudad, enc_procesadas.id_fasfield, det_repor_aseso.det_servi_tomado, det_repor_aseso.n_cuotas, det_repor_aseso.valor, det_repor_aseso.tipo_pago, det_repor_aseso.aliado from enc_procesadas, det_repor_aseso, tipo_encuesta where tipo_encuesta.tipo_encuesta=enc_procesadas.tipo_encuesta and enc_procesadas.id_fasfield=det_repor_aseso.id_fasfield and enc_procesadas.tipo_encuesta=2 and enc_procesadas.id_cliente!='0' and det_repor_aseso.resul_visita='Visitado y fue gratuito el diagnóstico' order by enc_procesadas.fecha_filtro desc";
$query=pg_query($conexion, $sql);
$rows=pg_num_rows($query);
			
			if($rows){
						while($datos=pg_fetch_assoc($query)){
							echo $datos['id_fasfield'];

						echo $update="update enc_procesadas set cod_estado=6 where id_fasfield='".$datos['id_fasfield']."' ";
							 $query2=pg_query($conexion, $update);
								//if($query)
							//	echo "1";
							//	else
							//	echo "2";
						}
			}
