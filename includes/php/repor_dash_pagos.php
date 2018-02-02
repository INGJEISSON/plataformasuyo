
<section class="dashboard-counts no-padding-bottom">
            <div class="container-fluid">
              <div class="row bg-white has-shadow">
                <!-- Item -->
                <div class="col-xl-3 col-sm-6">
                
               
                    	<table width="117" border="1" cellpadding="0" cellspacing="0" class="table">
                              <tr align="center">
                                <td height="28" colspan="2" bgcolor="#0099FF" style="color:#FFF"><strong>Prospectos</strong></td>
                              </tr>
                              <tr style="font-size:12px" align="center">
                                <td width="105" height="28"><strong>Encuesta Propectos</strong></td>
                                <td width="142"> <strong>Encuesta Promotor</strong></td>
                          </tr>
                              <tr  style="font-size:16px;" align="center">
                                <td><?php echo $prospectos ?> </td>
                                <td><?php echo $n_pros_nom ?></td>
                              </tr>
                    </table>                    
                </div>
                 <div class="col-xl-9 col-sm-6 col-xs-3">
                
               
                    	<table width="287" border="1" cellpadding="0" cellspacing="0" class="table responsive">
                              <tr align="center">
                                <td height="28" colspan="5" bgcolor="#0099FF" style="color:#FFF"><strong>Diagnósticos</strong></td>
                              </tr>
                              <tr style="font-size:12px" align="center">
                                <td width="77" height="28"> <div class="brand-text brand-big hidden-lg-down"><strong>Gratuito</strong></div>
                                      <div class="brand-text brand-small"><strong>Grat</strong></div></td>
                                <td width="83"> <div class="brand-text brand-big hidden-lg-down"><strong>Vendidos</strong></div>
                                      <div class="brand-text brand-small"><strong>Vend</strong></div></td>
                                <td width="133"><strong><div class="brand-text brand-big hidden-lg-down"><strong>Valor Ingresado</strong></div>
                                      <div class="brand-text brand-small"><strong>V.Ingreso</strong></div></strong></td>                            
                                <td width="87"><strong><div class="brand-text brand-big hidden-lg-down"><strong>Documentos Entregados</strong></div>
                                      <div class="brand-text brand-small"><strong>DocuEntr.</strong></div></strong></td>
                          </tr>
                              <tr  style="font-size:16px" align="center">
                                <td><?php echo $gratuito; ?></td>
                                <td><?php echo $vendidos; ?></td>
                                <td>$<?php echo number_format($v_diagnos); ?></td>                               
                                <td><?php echo $entr_diag; ?></td>
                              </tr>
                    </table>                    
                  
                </div>
                
                  <div class="col-xl-12 col-sm-12">
                
               
                    	<table width="292" border="1" cellpadding="0" cellspacing="0" class="table responsive">
                              <tr align="center">
                                <td height="28" colspan="7" bgcolor="#0099FF" style="color:#FFF"><strong>Servicios</strong></td>
                              </tr>
                              <tr style="font-size:12px" align="center">
                                <td width="50" height="28"><strong><div class="brand-text brand-big hidden-lg-down"><strong>Vendidos</strong></div>
                                      <div class="brand-text brand-small"><strong>Vend</strong></div></strong></td>
                                <td width="90"> <div class="brand-text brand-big hidden-lg-down"><strong>Valor ingresado</strong></div>
                                      <div class="brand-text brand-small"><strong>V.Ingreso</strong></div></strong></td>
                                <td width="86"><strong><div class="brand-text brand-big hidden-lg-down"><strong>Valor ingresado por recaudo</strong></div>
                                      <div class="brand-text brand-small"><strong>V.IngRec</strong></div></td>
                                <td width="56"><div class="brand-text brand-small">
                                  <div class="brand-text brand-big hidden-lg-down"><strong>Valor ingresado Serv Express</strong></div>
                                  <strong>V.ingreso Express</strong>
                                </div></td>
                                <td width="56"><div class="brand-text brand-small">
                                  <div class="brand-text brand-big hidden-lg-down"><strong>NO vendidos</strong></div>
                                <strong>NOvend</strong></div></td>
                                <td width="56"><div class="brand-text brand-small">
                                  <div class="brand-text brand-big hidden-lg-down"><strong>Pendientes por venta</strong></div>
                                <strong>PenVent</strong></div></td>
                                <td width="56"><div class="brand-text brand-big hidden-lg-down"><strong>NO viables</strong></div>
                                <div class="brand-text brand-small"><strong>NOviabl</strong></div></td>
                          </tr>
                              <tr style="font-size:16px" align="center">
                                <td><?php echo $tom_servsi; ?> </td>
                                <td>$<?php echo number_format($valor_serv); ?></td>
                                <td>$<?php echo number_format($recaudo_cuotas); ?></td>
                                <td>$<?php echo number_format($recaudo_express); ?></td>
                                <td><?php echo $tom_servno; ?></td>
                                <td><?php echo $tom_servpendventa; ?></td>
                                <td><?php echo $tom_servnoviable; ?></td>
                              </tr>
                    </table>                    
                  
                </div>
                
                <div class="col-xl-6 col-sm-6">                
               
                    	<table width="345" border="1" cellpadding="0" cellspacing="0" class="table" id="1">
                              <tr align="center">
                                <td height="28" colspan="3" bgcolor="#0099FF" style="color:#FFF"><strong>Seguimiento de créditos</strong></td>
                              </tr>
                               <tr style="font-size:12px" align="center">
                                <td width="84"><strong>Concretados</strong></td>
                                <td width="78"> <strong>No concretados</strong></td>
                                <td width="144"><strong>Valor ingresado por crédito</strong></td>
                          </tr>
                              <tr  style="font-size:12px">
                                <td><?php echo $aprob_credito; ?> </td>
                                <td><?php echo $repro_credito; ?> </td>
                                <td><?php echo number_format($valor_credito); ?> </td>
                              </tr>
                    </table>           
                </div>
                <div class="col-xl-4 col-sm-6">      
                    	<table width="359" border="1" cellpadding="0" cellspacing="0" class="table responsive">
                              <tr align="center">
                                <td height="28" colspan="4" bgcolor="#0099FF" style="color:#FFF"><strong>Créditos dirgidos por aliado</strong></td>
                              </tr>
                               <tr style="font-size:12px" align="center">
                                <td width="80" height="28"><strong>FMSD</strong></td>
                                <td width="101"> <strong>Interactuar</strong></td>
                                <td width="98"><strong>Creditos Orbe</strong></td>
                                <td width="62"><strong>Av villas</strong></td>
                          </tr>
                              <tr  style="font-size:16px" align="center">
                                <td><?php echo $r1 ?></td>
                                <td><?php echo $r3 ?></td>
                                <td><?php echo $r2 ?></td>
                                <td><?php echo $r4 ?></td>
                              </tr>
                    </table>    
                </div>

 				<div class="col-xl-4 col-sm-6">      
                    	<table width="359" border="1" cellpadding="0" cellspacing="0" class="table">
                              <tr align="center">
                                <td width="341" height="28" colspan="4" bgcolor="#0099FF" style="color:#FFF"><strong>Valor total <?php if(isset($_POST['ciudad'])!='Todos'){ ?> ingresado por la regional <?php }  ?> </strong></td>
                              </tr>
                              <tr  style="font-size:18px" align="center">
                                <td height="28" colspan="4"><strong>$<?php echo number_format($v_diagnos+$recaudo_cuotas+$valor_serv+$recaudo_express+$valor_credito) ?></strong></td>
                          </tr>
                    </table>    
                </div>                
 			                <div class="col-xl-3 col-sm-6">
                     <div class="item d-flex align-items-center">
                        <div><a href="includes/php/map_ases_prom.php" target="_blank"><img src='img/map-pin-location.jpg' width='80' height='80'></a></div>
                        <div class="title"><span>Seguimiento Asesor y Promotor</span>:</div>
                     </div>
                    <div class="number"><strong></strong></div>
                </div>
              </div>
             </div>
            </div>
          </section>        
                
               <div class="col-lg-12">
                  <div class="bar-chart-example card">
                    <div class="card-body" id="detalle_dash">    
                    Para ver la información más detallada haga clic en <a style="cursor: pointer;"  id="info_general" href="javascript:;"><u>"Ver información"</u></a></div>                
                    
                  </div>
                </div>



             

<script type="text/javascript">
$(document).ready(function () {

  var fecha_1="<?php echo "$_POST[fecha_1]" ?>";
    var fecha_2="<?php echo "$_POST[fecha_2]" ?>";
    var ciudad="<?php echo "$_POST[ciudad]" ?>";
    var asesor="<?php echo "$_POST[asesor]" ?>";
    
    var datos='tipo='+1+'&fecha_1='+fecha_1+'&fecha_2='+fecha_2+'&ciudad='+ciudad+'&asesor='+asesor+'&vistas='+11;

        $.ajax({
              type: "POST",
              data: datos,
              url: "includes/php/g_procesos.php",
              success: function(valor){

                $("#detalle_dash").html(valor);

              }

        });

	

});


  
</script>         