<?php
include('../dependencia/conexion.php');

	$sql1="select * from servicios where cod_servicio='".$_GET['cod_servicio']."' ";
	$query1=pg_query($conexion, $sql1);
	$datos1=pg_fetch_assoc($query1);

	$sql3="select * from  tipo_mod_cost ";
	$query3=pg_query($conexion, $sql3);
	
	// COnsultamos las opciones según el tipo de modelo....
	
	$query4="select * from opc_cotiz_serv where tipo_mod_cost=1";
	$sql4=pg_query($conexion, $query4);
	
	$query5="select * from opc_cotiz_serv where tipo_mod_cost=2";
	$sql5=pg_query($conexion, $query5);
	
	

 
?>
 
 <p><strong>COTIZACIÓN DEL SERVICIO: <?php echo ($datos1['nom_servicio']) ?></strong></p>
 
<div class="form-group row">
                          <label class="col-sm-9 form-control-label">Seleccione Modalidad:</label>
                          <div class="col-sm-9">
                            <select name="select" id="tipo_mod_cost" class="form-control">
                               <option value="0"> SELECCIONE</option>
                            <?php while($datos3=pg_fetch_assoc($query3)){ ?>
                              <option value="<?= $datos3['tipo_mod_cost'] ?>"> <?php echo ($datos3['descripcion']) ?></option>
                              <?php } ?>
                            </select>
                           
                        </div>
</div>


 <div id="mod_1">
<p><strong>MODELO 1: Sólo asesoría. (Iva incluido).</strong></p>
<table width="484" border="0" class="table">
   <tr>
     <td width="377"><strong>Nombre</strong></td>
     <td width="91"><strong>Valor</strong></td>
   </tr>
    <?php while($datos4=pg_fetch_assoc($sql4)){ 

    			// Consultamos el valor de la opción del servicio...
    				$sqlf="select valor from cotiz_serv where id_serv_recom='".$_GET['id_serv_recom']."' and cod_op_cotiz='".$datos4['cod_op_cotiz']."' ";
    				$queryf=pg_query($conexion, $sqlf);
    				$datosf=pg_fetch_assoc($queryf);
    	?>
   <tr>
     <td> <?php echo ($datos4['descripcion']) ?></td>
     <td><input type="number" name="valor[]" class="form-control" id="valor" value="<?php echo $datosf['valor'] ?>">
    </td>
   </tr>
   <?php } ?>
</table>
<p><input type="button" name="textfield" id="grabar" class="btn btn-primary" value="Grabar"></p>
  </div>
<p>
<div id="mod_2">
 <strong>MODELO 2: Servicio completo (asesoría, análisis, acompañamiento, trámites) (Iva incluid</strong>o).</p>
<table width="484" border="0" class="table">
  <tr>
    <td width="377"><strong>Nombre</strong></td>
    <td width="91"><strong>Valor</strong></td>
  </tr>
  <?php while($datos5=pg_fetch_assoc($sql5)){ 


    			// Consultamos el valor de la opción del servicio...
    				$sqlf="select valor from cotiz_serv where id_serv_recom='".$_GET['id_serv_recom']."' and cod_op_cotiz='".$datos5['cod_op_cotiz']."' ";
    				$queryf=pg_query($conexion, $sqlf);
    				$datosf=pg_fetch_assoc($queryf);
  	?>
  <tr>
    <td><?php echo ($datos5['descripcion']) ?></td>
    <td><input type="number" name="valor2[]" class="form-control" id="valor2" value="<?php echo $datosf['valor'] ?>"></td>
  </tr>
  <?php } ?>
</table>
<p><input type="button" name="textfield" id="grabar2" class="btn btn-primary" value="Grabar"></p>

</div> 
  <script>
$(document).ready(function(){
$("#mod_1").hide();
$("#mod_2").hide();

	

		$("#tipo_mod_cost").change(function(){
				var tipo_mod_cost=$("#tipo_mod_cost").val();
						if(tipo_mod_cost==1){
							$("#mod_1").show();
							$("#mod_2").hide();
						}else if(tipo_mod_cost==2){
							$("#mod_1").hide();
							$("#mod_2").show();
						}else{
							$("#mod_1").hide();
							$("#mod_2").hide();
						}
						
				
		});


		

		
		$("#grabar").click(function(){
			
			
			var tipo_mod_cost=$("#tipo_mod_cost").val();
			var id_serv_recom= <?php echo $_GET['id_serv_recom']; ?>;

			var valor = ''; 
							$("input[type='number'][name='valor[]']").each( 
									function() 
									{ 											   
											
										valor +='valor[]='+this.value+'&';												
																				        
									}
							);
			
				
		  var datos='valor[]='+valor+'&tipo_mod_cost='+tipo_mod_cost+'&cotiz_serv='+1+'&id_serv_recom='+id_serv_recom;	
		  
		  			 $.ajax({
								type: "POST",
								data: datos,
								url: 'g_procesos.php',
								success: function(valor){
										if(valor==1){
											alert("Información actualizada correctamente");
										}else{
											alert("Ocurrió un problema técnico, por favor comuníquese con el administrador");
										}
								}
						 
					 });

		
		});

		$("#grabar2").click(function(){
			
			
			var tipo_mod_cost=$("#tipo_mod_cost").val();
			var id_serv_recom= <?php echo $_GET['id_serv_recom']; ?>;
			
				var valor = ''; 
							$("input[type='number'][name='valor2[]']").each( 
									function() 
									{ 											   
											
										valor +='valor[]='+this.value+'&';												
																				        
									}
							);
		  var datos='valor[]='+valor+'&tipo_mod_cost='+tipo_mod_cost+'&cotiz_serv='+1+'&id_serv_recom='+id_serv_recom;	
		  
		  			 $.ajax({
								type: "POST",
								data: datos,
								url: 'g_procesos.php?'+datos,
								success: function(valor){
										if(valor==1){
											alert("Información actualizada correctamente");
										}else{
											alert("Ocurrió un problema técnico, por favor comuníquese con el administrador");
										}
								}
						 
					 });

		
		});
});
  </script>
  <!--<iframe src="subir_archivo_diag.php?id_fasfield=<?php echo $_GET['id_serv_recom'] ?>&campo=3" scrolling="no" height="200" width="400" />-->