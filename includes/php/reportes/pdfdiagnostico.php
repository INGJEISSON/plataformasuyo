<?php
include('../../dependencia/conexion.php');
if(isset($_GET['id_elab_diag'])){
 $id_elab_diag=base64_decode($_GET['id_elab_diag']);

        if(is_numeric($id_elab_diag)){

          $sql="select * from diagno_client where id_elab_diag='".$id_elab_diag."' ";
          $query=pg_query($conexion, $sql);
          $rows=pg_num_rows($query);
          $datos=pg_fetch_assoc($query);

          $sql2="select * from cliente where cod_cliente='".$datos['cod_cliente']."' ";
          $query2=pg_query($conexion, $sql2);
          $rows2=pg_num_rows($query2);
          $datos2=pg_fetch_assoc($query2);

          // Buscamos los servicios cotizados

          $sql21="select serv_recom_diag.id_serv_recom, servicios.nom_servicio, servicios.cod_servicio from serv_recom_diag, servicios where serv_recom_diag.cod_servicio=servicios.cod_servicio and id_elab_diag='".$id_elab_diag."' ";
          $query21=pg_query($conexion, $sql21);
          $query22=pg_query($conexion, $sql21);
      $rows22=pg_num_rows($conexion, $sql21);
          // Buscamos los párrafos  realizados por el diagnóstico

          $sql3="select id_parraf_diag from parraf_diag where id_elab_diag='".$id_elab_diag."' limit 1 ";
          $query3=pg_query($conexion, $sql3);
          $rows3=pg_num_rows($query3);
        
                if($rows3){
                                $sql1="select descripcion as observacion from parraf_diag where id_elab_diag='".$id_elab_diag."' and cod_parrafo=1 ";
                                   $query1=pg_query($conexion, $sql1);
                                   $datos1=pg_fetch_assoc($query1);

                                  $nec_ident=$datos1['observacion'];

                                      $sql1="select descripcion as observacion from parraf_diag where id_elab_diag='".$id_elab_diag."' and cod_parrafo=2 ";
                                   $query1=pg_query($conexion, $sql1);
                                   $datos1=pg_fetch_assoc($query1);

                                   $situa_actual=$datos1['observacion'];

                                     $sql1="select descripcion as observacion from parraf_diag where id_elab_diag='".$id_elab_diag."' and cod_parrafo=3 ";
                                   $query1=pg_query($conexion, $sql1);
                                   $datos1=pg_fetch_assoc($query1);

                                   $ana_fis_amb=$datos1['observacion'];

                                     $sql1="select descripcion as observacion from parraf_diag where id_elab_diag='".$id_elab_diag."' and cod_parrafo=4 ";
                                   $query1=pg_query($conexion, $sql1);
                                   $datos1=pg_fetch_assoc($query1);

                                   $ana_fis_pro=$datos1['observacion'];

                                $sql1="select descripcion as observacion from parraf_diag where id_elab_diag='".$id_elab_diag."' and cod_parrafo=5 ";
                                   $query1=pg_query($conexion, $sql1);
                                   $datos1=pg_fetch_assoc($query1);

                                     $titula_predio=$datos1['observacion'];

                                    $sql1="select descripcion as observacion from parraf_diag where id_elab_diag='".$id_elab_diag."' and cod_parrafo=6 ";
                                   $query1=pg_query($conexion, $sql1);
                                   $datos1=pg_fetch_assoc($query1);

                                     $form_predio=$datos1['observacion'];

                                     $sql1="select descripcion as observacion from parraf_diag where id_elab_diag='".$id_elab_diag."' and cod_parrafo=7 ";
                                   $query1=pg_query($conexion, $sql1);
                                   $datos1=pg_fetch_assoc($query1);

                                     $otrs_situa=$datos1['observacion'];
                   
                   
                // Buscamos las amenanzas registradas
                
                

                }


$tipol_cant_constr=explode(",",$datos['tipol_cant_constr']);

$area_lote=explode(",",$datos['area_lote']);
$alt_cant_pisos=explode(",",$datos['alt_cant_pisos']);

$dim_frent_lote=explode(",",$datos['dim_frent_lote']);
$dim_frent_const=explode(",",$datos['dim_frent_const']);
$dist_lad_lot=explode(",",$datos['dist_lad_lot']);
$dist_lot_izq=explode(",",$datos['dist_lot_izq']);
$dist_lot_der=explode(",",$datos['dist_lot_der']);

        }

}

if($rows==1){

?>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

<page backtop="40mm" backbottom="7mm" backleft="30mm" backright="10mm"> 
        <page_header style='text-align: right;'> 
               <img src="img/Logo.png" />
          
          </page_header> 

           <page_footer> 
              ALGO ALGO
          </page_footer>
<style type="text/css">
.fuente_letra {
 /* font-family: "TrebuchetMS";*/
}

.gris_texto{
    color: #5b5b5f;
    font-size:18px
}
.turquesa{
  color: #00BEBE;
  font-size:12px
}
.verde{
  color: #96C832;
}
.naranja{
  color: #FF6400;
}
.verde_azul{
  color: #FF424F; 
}
.azul{
  color: #255590;
}
.azul_clarol{
  color: #0082C8;
}
.verde{
  color: #96C832;
  
}
.tabla_tecnico{
  background-image:url(img/Imagen1.png);
  background-position:center;
  background-repeat:no-repeat;
  text-align:center;
  color: #255590;
  font-weight: bold; font-size: 10px

}
.tabla_tecnico2{
  background-image:url(img/Marco_Texto.png);  
  background-repeat:no-repeat;
  background-size:1024px 60px;

}
.documentos{
  
  background-image:url(img/Documento-Diagnostico_03.png);
  background-position:cover;
  /*background-repeat:no-repeat;*/
  text-align:center;
  color: #255590;
  font-weight: bold; font-size: 14px;
/* background-size: 25px 50px;*/
}
  
</style>


<body class="fuente_letra">
   <page_header style='text-align: right;'> 
               <img src="img/Logo.png" width="124" height="49" />
          
</page_header> 
     <br>
  <br><br><br><br>
  <table width="349" border="0" cellpadding="0" cellspacing="0" class="azul" >
    <tr>
      <td>12 de Febrero de 2017</td>
    </tr>
    <tr>
      <td width="349"><span style="font-size:37px; font-weight: bold">DIAGNÓSTICO<br>
      DE PROPIEDAD</span><span class="azul" style="font-size:"><img src="img/Linea_Titulo.png" width="260" height="12" /></span></td>
    </tr>
  </table>
<table width="438" border="0">
  <tr>
    <td width="323" class="turquesa"><p >Sr. <?php echo $datos2['nombre']; ?> </p></td>
    <td width="105">&nbsp;</td>
  </tr>
  <tr>
    <td><p class="gris_texto"><?php echo $datos['direccion'] ?></p></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td ><p class="gris_texto"><?php echo $datos['municipio'] ?>, Colombia</p></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<table width="690" border="0" >
  <tr style="text-align:justify">
    <td width="22" height="155" style="background-color: #39C; width:10px; border-left:solid #39C"></td>
    <td width="346"><p class="gris_texto">Por medio de la presente nos permitimos en
      primera medida agradecer la confianza quen ha depositado en Suyo y en todo el grupo de profesionales que hay detrás de esta empre
        sa de impacto social. Respondiendo al servicio que adquirió con nosotros, hacemos entrega de su documento de diagnóstico de propiedad en el cual resumimos el análisis  legal y técnico que hemos realizado de su caso; así mismo señalamos la viabilidad y el tipo de servicio que requiere, con todos los costos asociados. Recuerde preguntar a su asesor de ventas</p></td>
    <td width="16">&nbsp;</td>
    <td width="288"><p class="gris_texto"> por las diferentes opciones de financiación que brindamos a través de nuestros aliados.Finalmente, quisiera reiterarle que sabemos
      que su hogar es su bien más preciado, por
      esto no defraudaremos su voto de confianza.
      Esperamos que pueda tomar los servicios
      recomendados con nosotros, Suyo y todo su
      equipo humano estará esperándole para
    asesorarlo y guiarlo de forma personalizada.</p></td>
  </tr>
</table>
<p>&nbsp;</p>
<table width="200" border="0">
  <tr>
    <td><img src="img/foto.png" width="684" height="202" /></td>
  </tr>
</table>
<br><br><br>
<br>
<table width="200" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><img src="img/firma_mateo.png" width="149" height="88" /></td>
  </tr>
  <tr>
    <td><strong>MATTHEW ALEXANDER</strong></td>
  </tr>
  <tr class="gris_texto">
    <td>Gerente General></td>
  </tr>
  <tr class="gris_texto">
    <td>Suyo Colombia SAS</td>
  </tr>
</table>
      <page pageset="old">

            <page_header style='text-align: right;'> 
               <img src="img/Logo.png" width="124" height="49" />
          
          </page_header> 
           <page_footer> 
              ALGO ALGO
          </page_footer>

   <br>
  <br><br><br><br><br><br>
        <table width="280" border="0" cellpadding="0" cellspacing="0" class="azul" >
          <tr>
            <td width="35"><img src="img/Barra_Subtitulo.png" alt="" width="23" height="111" /></td>
            <td width="245"><span style="font-size:40px">01</span><span style="font-size:27px; font-weight: bold"><br>
              ESTADO ACTUAL<span style="font-size:17px;"><br>
                DEL USUARIO Y EL PREDIO</span></span></td>
          </tr>
        </table><br>
        <table width="691" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                      <td width="286"><p class="azul_clarol">USUARIO</p></td>
                      <td width="252"><p class="azul_clarol">IDENTIFICACIÓN</p></td>
                      <td width="139">&nbsp;</td>
                    </tr>
                    <tr>
                      <td><p class="gris_texto"><?php echo $datos2['nombre'] ?></p></td>
                      <td><p class="gris_texto"><?php echo $datos['cod_cliente'] ?></p></td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td><p class="azul_clarol">DIRECCIÓN</p></td>
                      <td><p class="azul_clarol">BARRIO</p></td>
                      <td><p class="azul_clarol">MUNICIPIO</p></td>
                    </tr>
                    <tr>
                      <td><p class="gris_texto"><?php echo $datos['dir_form_igac'] ?></p></td>
                      <td><p class="gris_texto"><?php echo $datos['barrio'] ?></p></td>
                      <td><p class="gris_texto"><?php echo $datos['municipio'] ?></p></td>
                    </tr>
                    <tr>
                      <td><p class="azul_clarol">FOLIO MATRÍCULA</p></td>
                      <td><p class="azul_clarol">REFERENCIA CATASTRAL</p></td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td><p class="gris_texto"></p></td>
                      <td><p class="gris_texto"></p></td>
                      <td>&nbsp;</td>
                    </tr>
                  </table>
                  <table width="200" border="0" align="center">
                    <tr>
                      <td><img src="img/foto_chada.png" width="683" height="249"></td>
                    </tr>
                  </table>
                  <p>&nbsp;</p>
                  <p class="azul" style="font-size:17px; font-weight:bold">NECESIDAD IDENTIFICADA</p>
                  <table width="931" border="0">
                    <tr style="text-align: justify;">
                      <td width="11" height="162"><img src="img/Barra_Parrafo1.png" alt="" width="10" height="153" /></td>
                      <td width="910" class="gris_texto"  style="width:auto" ><?php echo $nec_ident ?></td>                      
                    </tr>
                  </table>
        <p style="font-style:italic; font-size:14px; width:auto" >A continuación presentamos el análisis de su caso y las posibilidades de servicios para darle respuesta a sus deseso y, en caso de no ser posible, las diferentes alternativas que le podemos brindar</p>
                 

</page>

            <page pageset="old"> 
               <br>
  <br><br><br><br><br><br>
   
                  <p class="azul" style="font-size:15px; font-weight:bold">SITUACIÓN ACTUAL</p>
                  <p class="turquesa" style="font-size:11px; font-weight:bold">DESCRIPCIÓN DEL PREDIO Y DE LA CONSTRUCCIÓN</p>
              <table width="200" border="0">
                <tr style="text-align:justify">
                      <td><p class="gris_texto" style="font-size:14px; width:auto;"><?php echo $situa_actual ?></p>
                  </td>
                    </tr>
                  </table><br>
              <table width="782" border="0">
                <tr>
                      <td width="70"><span class="turquesa" style="font-size:11px; font-weight:bold"><img src="img/Barra_Foto.png" alt="" width="70" height="143" /></span></td>
                      <td width="702">&nbsp;</td>
                </tr>
              </table>
<p class="turquesa" style="font-size:11px; font-weight:bold"><span class="turquesa" style="font-size:11px; font-weight:bold">Análisis del cumplimiento del plan de ordanimiento territorial con respecto a las características ambientales:</span></p>
<table width="752" border="0">
  <tr style="text-align:justify">
    <td width="11" height="24"><img src="img/Vineta_Verde.png" width="11" height="22"></td>
    <td width="731"><p class="gris_texto" style="font-size:14px; width:auto">No se encuentra en zona de amenaza y riesgo por inundación</p></td>
  </tr>
</table>
                      

</page>

         <page pageset="old"> 
            <br>
  <br><br><br><br><br><br>
  <p class="turquesa" style="font-size:11px; font-weight:bold"><span class="turquesa" style="font-size:11px; font-weight:bold">Análisis del cumplimiento del plan de ordanimiento territorial con respecto a las características físicas de la propiedad:</span></p>
                      <table width="455" height="440" border="0" align="center" cellpadding="0" cellspacing="0" class="tabla_tecnico">
                          <tr>
                            <td height="32" colspan="4">ALTURA: Cantidad de pisos construidos</td>
                            <td width="137" style="text-align:center">TIPOLOGIA: Cantidad de viviendas por construcción<br></td>
                            <td colspan="4" rowspan="2">&nbsp;</td>
                          </tr>
                          <tr>
                            <td height="18" colspan="4"><span style="text-align:center"><?php echo $alt_cant_pisos[0]." | ".$alt_cant_pisos[1]." | ".$alt_cant_pisos[2] ?></span></td>
                            <td style="text-align:center"><?php echo $tipol_cant_constr[0]." | ".$tipol_cant_constr[1]." | ".$tipol_cant_constr[2] ?></td>
                          </tr>
                          <tr>
                            <td colspan="4">&nbsp;</td>
                            <td rowspan="4">&nbsp;</td>
                            <td width="46" rowspan="4"><br>
                              <br>
                              <br>
                              <br>
                              <br>
                              <br>
                              <br>
                              <br>
                              <br>
                              <br>
                              <br>
                              <br></td>
                            <td width="67">Distancia entre el lado izquierdo
                            del lote y la construcción</td>
                          </tr>
                          <tr>
                            <td width="68" height="62"><p>Distancia entre el lado
                              derecho del lote
                              y la construcción</p></td>
                            <td width="104">&nbsp;</td>
                            <td height="62">&nbsp;</td>
                            <td rowspan="2">&nbsp;</td>
                            <td><?php echo $dist_lot_izq[0]." | ".$dist_lot_izq[1]." | ".$dist_lot_izq[2] ?></td>
                          </tr>
                          <tr>
                            <td height="18"><span style="text-align:center"><?php echo $dist_lot_der[0]." | ".$dist_lot_der[1]." | ".$dist_lot_der[2] ?></span></td>
                            <td height="18">&nbsp;</td>
                            <td height="18">&nbsp;</td>
                            <td>&nbsp;</td>
                          </tr>
                          <tr>
                            <td height="48" colspan="4">&nbsp;</td>
                            <td>&nbsp;</td>
                          </tr>
                          <tr>
                            <td height="49" colspan="3"><p>&nbsp;</p>
                              <p>&nbsp;</p></td>
                            <td width="3">&nbsp;</td>
                            <td rowspan="3">&nbsp;</td>
                            <td height="81" colspan="4" rowspan="2">&nbsp;</td>
                          </tr>
                          <tr>
                            <td height="66">Dimensión frente de la
                                construcción</td>
                            <td height="66">&nbsp;</td>
                            <td height="66">&nbsp;</td>
                            <td height="66">&nbsp;</td>
                          </tr>
                          <tr>
                            <td height="30" colspan="2"><span style="text-align:center"><?php echo $dim_frent_const[0]." | ".$dim_frent_const[1]." | ".$dim_frent_const[2] ?></span></td>
                            <td height="30">&nbsp;</td>
                            <td height="30">&nbsp;</td>
                            <td height="30" colspan="4">Distancia entre el lado posterior del lote y la construcción</td>
                          </tr>
                          <tr>
                            <td height="45" colspan="3">&nbsp;</td>
                            <td height="45">&nbsp;</td>
                            <td>&nbsp;</td>
                            <td colspan="4"><span style="text-align:center"><?php echo $dist_lad_lot[0]." | ".$dist_lad_lot[1]." | ".$dist_lad_lot[2] ?></span></td>
                          </tr>
                          <tr>
                            <td height="30"><span style="text-align:center">Dimensión frente del lote</span></td>
                            <td height="30">&nbsp;</td>
                            <td>&nbsp;</td>
                            <td height="30">&nbsp;</td>
                            <td>Área del lote según las escritura</td>
                            <td colspan="4">&nbsp;</td>
                          </tr>
                          <tr>
                            <td height="18" colspan="2"><span style="text-align:center"><?php echo $dim_frent_lote[0]." | ".$dim_frent_lote[1]." | ".$dim_frent_lote[2] ?></span></td>
                            <td width="30">&nbsp;</td>
                            <td height="18">&nbsp;</td>
                            <td><span style="text-align:center"><?php echo $area_lote[0]." | ".$area_lote[1]." | ".$area_lote[2] ?></span></td>
                            <td colspan="4">&nbsp;</td>
                          </tr>
              </table>
                      <p>&nbsp;</p>
                      <table width="746" border="0" class="gris_texto" style="font-weight:bold">
                        <tr>
                          <td>CARACTERÍSTICAS</td>
                          <td>PREDIO DEL USUARIO</td>
                          <td>EXIGENCIAS DEL POT</td>
                          <td>CUMPLIMIENTO DE LAS EXIGENCIAS</td>
                        </tr>
                      </table>
                      <table width="735" height="96" border="0" class="tabla_tecnico2">
                        <tr>
                          <td height="92"><p>&nbsp;</p></td>
                        </tr>
                      </table>
      
</page>
         <page pageset="old">
                 
                  <br>
  <br><br><br><br><br><br>
                             <div style="text-align:center">
                              <p style="text-align:left"><span class="turquesa" style="font-size:17px; font-weight:bold">TITULARIDAD DEL PREDIO</span></p>
                              <table width="200" border="0" align="center" class="gris_texto" style="text-align: justify;">
                                <tr style="text-align:justify; font-size:14px; width:auto">
                                   <td><?php echo $titula_predio ?></td>
                                  
                                </tr>
                              </table>
                              <p style="text-align:left"><span class="turquesa" style="font-size:17px; font-weight:bold">FORMA COMO ADQUIRIO EL PREDIO POR EL USUARIO</span></p>
                              <table width="200" border="0" align="center" class="gris_texto" style="text-align: justify;">
                                <tr style="text-align:justify; font-size:14px; width:auto">
                                  <td><?php echo $form_predio ?></td>
                                </tr>
                              </table>
                              <p style="text-align:left"><span class="turquesa" style="font-size:17px; font-weight:bold">OTRAS SITUACIONES RELACIONADAS CON EL PREDIO Y LA CONSTRUCCION</span></p>
                              <table width="200" border="0" align="center" class="gris_texto" style="text-align: justify;">
                                <tr style="text-align:justify; font-size:14px; width:auto">
                                <td><?php echo $form_predio ?></td>
                               
                                </tr>
                              </table>
                       </div>
                 
                 </page>
<page pageset="old"> 

  <table width="280" border="0" cellpadding="0" cellspacing="0" class="azul" >
                <tr>
                  <td width="35"><img src="img/Barra_Subtitulo.png" alt="" width="23" height="111" /></td>
                  <td width="245"><span style="font-size:40px">02</span><span style="font-size:24px; font-weight: bold"><br>SERVICIOS<span style="font-size:17px;"><br>OFRECIDOS</span></span></td>
                </tr>
              </table>
         
<p>Teniendo en cuenta la situación actual y lo que el señor desea, le ofrecemos los siguientes servicios</p>

      </page>

       <page pageset="old">
          <br>
  <br><br><br><br><br><br>
         <table width="280" border="0" cellpadding="0" cellspacing="0" class="azul" >
           <tr>
             <td width="35"><img src="img/Barra_Subtitulo.png" alt="" width="23" height="111" /></td>
             <td width="245"><span style="font-size:40px">03</span><span style="font-size:24px; font-weight: bold"><br>
               INVERSIÓN<span style="font-size:17px;"><br>
                 VALOR Y CONDICIONES</span></span></td>
           </tr>
         </table>
         <p><span class="azul" style="font-size:15px; font-weight:bold">COTIZACIÓN</span></p>
                <table width="772" border="0">
                  <tr style="text-align:justify">
                    <td width="15" height="162"><img src="img/Barra_Parrafo1.png" alt="" width="10" height="153" /></td>
                    <td width="405"><p class="gris_texto">Suyo ofrece sus servicios en dos  modalidades, la primera en donde se  incluye sólo la asesoría, análisis y  acompañamiento legal y técnico, así como  la preparación de documentos  relacionados con el servicio final. Sin  embargo, en este caso es el cliente quien  se hace responsable tanto por realizar  personalmente los trámites relacionados,  como por hacer el pago de los costos  asociados, ante cada entidad  gubernamental correspondiente. En esta  opción el tiempo requerido para realizar  el servicio dependerá en buena parte del  cliente, dado que sería directamente el </p></td>
                    <td width="20">&nbsp;</td>
                    <td width="314"><p class="gris_texto">responsable de realizar los trámites del  proceso.  La segunda modalidad que incluye toda la  asesoría, análisis y acompañamiento de la  opción 1, además del pago de todos los  trámites, costos gubernamentales y  judiciales, e impuestos del servicio (si  aplican). De igual forma, Suyo realizará  directamente todos los trámites  personalmente. En esta opción, sí podemos  estimar el tiempo requerido del servicio,  dado que la misma empresa realiza los  trámites.</p></td>
                  </tr>
                </table>
                <p><span style="font-style:italic; font-size:14px; width:auto">A continuación se resumen los costos para una y otra modalidad de los servicios ofrecidos. Para más detalle de los costos consulte el anexo.</span></p>
                <table width="645" border="0" class="gris_texto" style="width:auto; text-align:justify">
                  <tr style="font-weight:bold">
                    <td width="243">SERVICIO</td>
                    <td width="170">COSTOS MODALIDAD 1 (SÓLO ASESORÍA)</td>
                    <td width="218">COSTOS MODALIDAD 2:  SERVICIO COMPLETO  (Asesoría, Análisis,  Acompañamiento y Trámites) </td>
                  </tr>
                   <?php
                         $i=1;
                           while($datos21=pg_fetch_assoc($query21)){
                  ?>
                  <tr>
                    <td><?php echo ($datos21['nom_servicio']) ?></td>
                    <td style="text-align:right">$</td>
                    <td>$</td>
                  </tr>
                   <?php
                          }
                   ?>
                  <tr class="azul" style="font-weight:bold;">
                    <td>TOTAL</td>
                    <td style="text-align:right">$</td>
                    <td>$</td>
                  </tr>
                  <tr style="font-weight:bold; font-style:italic; text-align:right">
                    <td height="18" colspan="2">&nbsp;</td>
                    <td>*Precios con IVA Incluido</td>
                  </tr>
                </table>

            </page>

       <page pageset="old">     

              <table width="364" border="0" class="azul">
                <tr>
                  <td style="font-weight:bold">ELEMENTOS QUE DECIDE TENER EN CUENTA</td>
                </tr>
                <tr>
                  <td>SI DECIDE ADQUIRIR EL SERVICIO</td>
                </tr>
              </table>

              </page>

       <page pageset="old">
          <br>
  <br><br><br><br><br><br>
         <table width="280" border="0" cellpadding="0" cellspacing="0" class="azul" >
           <tr>
             <td width="35"><img src="img/Barra_Subtitulo.png" alt="" width="23" height="111" /></td>
             <td width="245"><span style="font-size:40px">04</span><span style="font-size:24px; font-weight: bold"><br>
               POLÍTICA DE<span style="font-size:17px;"><br>
                 DEVOLUCIONES</span></span></td>
           </tr>
         </table>
         <p>&nbsp;</p>
         <table width="756" border="0" class="gris_texto">
           <tr style="text-align: justify; width:auto">
                      <td width="18" height="112"><p><img src="img/Barra_Parrafo1.png" alt="" width="12" height="75" /></p>
                      <p>&nbsp;</p></td>
                      <td width="728" style="width:auto">Aunque no podemos asegurarle que su servicio podrá llevarse a buen término, pues pueden presentarse situaciones extraordinarias  atribuibles a un tercero (como una entidad) o casos de fuerza mayor y casos fortuito que lo impidan. Si esto llegara a pasar, podemos asegurarle que nosotros soportamos este riesgo con usted y le devolveremos la totalidad del dinero pagado que no hayamos ejecutado y  el  50% del dinero pagado que ya ejecutamos.   Esta política aplica sólo si decide adquirir los servicios bajo la modalidad 2 de servicio completo (asesoría, análisis, acompañamiento, trámites) (Iva incluido).  Esta política no aplica cuando: </td>
                    </tr>
                  </table>
                  <table width="549" border="0" class="gris_texto" style="text-align: justify; width:auto">
                    <tr style="text-align: justify; width:auto">
                      <td width="12" height="18"><img src="img/Vineta_Verde.png" width="11" height="18"></td>
                      <td width="527">El cliente entrega documentación o información falsa a Suyo. </td>
                    </tr>
                    <tr style="text-align: justify; width:auto">
                      <td height="18"><img src="img/Vineta_Verde.png" alt="" width="11" height="18"></td>
                      <td>El cliente registra testigos que desconozcan el caso o testigos falsos. </td>
                    </tr>
                    <tr style="text-align: justify; width:auto">
                      <td height="34"><img src="img/Vineta_Verde.png" alt="" width="11" height="18"></td>
                      <td>El cliente aporta información incompleta diferente o nueva información a la aportada  para la elaboración de este diagnóstico. </td>
                    </tr>
                    <tr style="text-align: justify; width:auto">
                      <td height="34"><img src="img/Vineta_Verde.png" alt="" width="11" height="18"></td>
                      <td>El cliente omite información pertinente a Suyo, al juez o a entidades gubernamentales  relacionadas con el proceso.</td>
                    </tr>
                    <tr style="text-align: justify; width:auto">
                      <td height="18"><img src="img/Vineta_Verde.png" alt="" width="11" height="18"></td>
                      <td>El cliente no respeta los plazos de pago establecidos por Suyo al vender el servicio. </td>
                    </tr>
                    <tr style="text-align: justify; width:auto">
                      <td height="18"><img src="img/Vineta_Verde.png" alt="" width="11" height="18"></td>
                      <td>Cualquier otra causa atribuible al cliente.</td>
                    </tr>
                  </table>
            </page>

       <page pageset="old">
          <br>
  <br><br><br><br><br><br>
         <table width="280" border="0" cellpadding="0" cellspacing="0" class="azul" >
           <tr>
             <td width="35"><img src="img/Barra_Subtitulo.png" alt="" width="23" height="111" /></td>
             <td width="245"><span style="font-size:40px">05</span><span style="font-size:24px; font-weight: bold"><br>
               TU ALIADO<span style="font-size:17px;"><br>
                 EQUIPO DE TRABAJO</span></span></td>
           </tr>
         </table>
         <table width="200" border="0" style="background-image:url(img/Documento-Diagnostico_031.png); background-position:center; background-repeat:no-repeat;  width:100%; height:700px; position:absoluto; margin-top:-40px" >
           <tr>
             <td height="49">&nbsp;</td>
             <td>&nbsp;</td>
           </tr>
           <tr>
             <td>&nbsp;</td>
             <td>&nbsp;</td>
           </tr>
         </table>
<table width="364" border="0" align="center" class="azul">
    <tr>
      <td style="font-weight:bold">EN ESTE DIAGNÓSTICO</td>
    </tr>
    <tr>
      <td>PARTICIPARON</td>
    </tr>
    </table>
                  <table width="200" border="0" align="center">
                    <tr class="azul" style="font-weight:bold">
                      <td colspan="2">ELABORÓ</td>
                      <td colspan="2">APROBÓ</td>
                    </tr>
                    <tr>
                      <td colspan="4"><img src="img/Linea_Tabla.png" width="477" height="4" /></td>
                    </tr>
                    <tr>
                      <td><img src="img/Vineta_Verde.png" alt="" width="11" height="18"></td>
                      <td>Yor Mary Montes</td>
                      <td>&nbsp;</td>
                      <td>Jarinson Hinestroza Arroyo</td>
                    </tr>
                    <tr>
                      <td width="18"><img src="img/Vineta_Verde.png" alt="" width="11" height="18"></td>
                      <td width="217">Viviana Paola</td>
                      <td width="13">&nbsp;</td>
                      <td width="217">&nbsp;</td>
                    </tr>
                  </table>
        </page>

       <page pageset="old"> 
         
          <table width="280" border="0" cellpadding="0" cellspacing="0" class="azul" >
            <tr>
              <td width="35"><img src="img/Barra_Subtitulo.png" alt="" width="23" height="111" /></td>
              <td width="245"><span style="font-size:40px">06</span><span style="font-size:24px; font-weight: bold"><br>
                ANEXOS<span style="font-size:17px;"><br>
                  DEL DIAGNÓSTICO</span></span></td>
            </tr>
         </table>
          <table width="364" border="0" class="azul">
                    <tr>
                      <td style="font-weight:bold">COTIZACIÓN</td>
                    </tr>
                    <tr>
                      <td>DETALLADA</td>
                    </tr>
         </table>
      <table width="543" border="0">
          <?php 
        $j=1;
                 while($datos22=pg_fetch_assoc($query22)){

                                    if($j==3){
                                      $j=1;
                                      ?>  
                                      JEISSON
                                 <br><br><br><br><br><br><br><br><br><br><br>
                                           <?php 
                                    } 
                                     ?>
                            <tr class="azul" style="font-weight:bold">
                              <td width="461"><?php echo ($datos22['nom_servicio']) ?></td>
                              <td width="72">VALOR</td>
                            </tr>
                                    <?php 
                                      // Listamos los OPCIONES del servicio
                                        $s="select * from tipo_mod_cost";
                                        $q=pg_query($conexion, $s);

                                           while($d=pg_fetch_assoc($q)){

                                                          // Buscamos los detalles de la opción
                                                    $s1="select * from opc_cotiz_serv where tipo_mod_cost='".$d['tipo_mod_cost']."' ";
                                                    $q1=pg_query($conexion, $s1);

                                                                                                 

                                  ?>
                                        <tr class="turquesa" style="font-weight:bold">
                                          <td colspan="2">Opción <?php echo ($d['tipo_mod_cost']) ?>: <?php echo ($d['descripcion']) ?></td>
                                        </tr>
                                          <?php 
                                                $sum=0;
                                                    while($d1=pg_fetch_assoc($q1)){   
                                                        // Buscamos el valor cotizado
                                                            $d2="select valor from cotiz_serv where cod_op_cotiz='".$d1['cod_op_cotiz']."' and id_serv_recom='".$datos22['id_serv_recom']."'  ";
                                                            $q2=pg_query($conexion, $d2);
                                                            $d2=pg_fetch_assoc($q2);
                                                            $sum=$sum+$d2['valor'];
                                          ?>  
                                        <tr style="font-size:11px">
                                          <td><?php echo ($d1['descripcion']) ?></td>
                                          <td style="text-align: right;">$<?php echo (number_format($d2['valor'])) ?></td>
                                        </tr>
                                            <?php
                                                              }// Fin detalle de la cotización

                                                        // Realizamos cálculos (Subtota, retención y total a pagar).
                                                      $subtotal=$sum; // sub total
                                                      $retencion=($subtotal*11)/100; // retención
                                                      $iva=($subtotal*19)/100; // IVA
                                                      $total_apagar=$subtotal+$iva+$retencion; // total a pagar..
                                                  ?> 

                                        <tr style="background-image:url(img/Pie_Pagina.png); background-repeat:no-repeat; background-position:right; background-size:cover">
                                          <td colspan="2">&nbsp;</td>
                                        </tr>
                                        <tr class="azul" style="font-weight:bold">
                                          <td>SUBTOTAL</td>
                                          <td style="text-align: right;">$<?php echo (number_format($subtotal)) ?></td>
                                        </tr>
                                        <tr>
                                          <td>Retención en la fuente - 11%</td>
                                          <td style="text-align: right;">$<?php echo (number_format($retencion)) ?></td>
                                        </tr>
                                        <tr>
                                          <td>IVA - 19%</td>
                                          <td style="text-align: right;">$<?php echo (number_format($iva)) ?></td>
                                        </tr>
                                        <tr style="background-image:url(img/Pie_Pagina.png); background-repeat:no-repeat; background-position:right; background-size:cover">
                                          <td colspan="2">&nbsp;</td>
                                        </tr>
                                        <tr class="azul" style="font-weight:bold">
                                          <td>PRECIO TOTAL</td>
                                          <td style="text-align: right;">$<?php echo (number_format($total_apagar)) ?></td>
                                        </tr>
                                <?php                                              
                                      }   
        $j++;               
    } // Fin listamos los servicios cotizados (Detalle)
  ?>
</table>

                <table width="333" height="98" border="0" style="background-image:url(img/Marco_Texto.png); background-repeat:no-repeat;background-size:cover">
                  <tr>
                    <td width="18" height="86"></td>
                    <td width="305"><table width="443" height="91" border="0">
                      <tr >
                        <td width="10" height="87" class="gris_texto"></td>
                        <td width="181" class="gris_texto" style="text-align:left"><p class="azul" style="font-weight:bold">Notas Aclaratorias: </p>
                         <p> La presente oferta tiene una validez de 30 días.  El trabajo iniciará a partir de la aprobación de la  cotización y su pago correspondiente.</p>
                        </td>
                        <td width="238"  class="gris_texto" style="text-align:left">La presente oferta tiene una validez de 30 días.  El trabajo iniciará a partir de la aprobación de la  cotización y su pago correspondiente.  El trabajo iniciará a partir de la aprobación de la  cotización y su pago correspondiente.</td>
                      </tr>
                    </table></td>
                  </tr>
                </table>
                
</page>
</body>
</page>
<?php
}else
echo "Referencia del diagnóstico inexistente";
?>
