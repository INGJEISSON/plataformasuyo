<?php
include('../dependencia/conexion.php');
      // Agregamos archivo....
date_default_timezone_set('America/Bogota');
$fecha_registro=date('Y-m-d H:i:s');
$fecha_filtro=date('Y-m-d');
// Verificamos que el usuario esté autenticado..

if(isset($_SESSION['cod_usuario'])){

      if(isset($_POST['add_revision'])){ // Agregar revisión...


          // Verificamos quién está realizando la revisión.....
          if($_SESSION['cod_grupo']==6 or $_SESSION['cod_grupo']==1) // Coordiandor de operaciones.  o Super administrador
            $tipo_revision=1; // Control de calidad
          else if($_SESSION['cod_grupo']==3 or $_SESSION['cod_grupo']==1) // Analítico....  o Super administrador
            $tipo_revision=2; 
          else if($_SESSION['cod_grupo']==8 or $_SESSION['cod_grupo']==1) // Asesor...  o Super administrador
            $tipo_revision=3; // Asesor
          
        

           $insert="insert into revision_diag (tipo_revision, id_fasfield, observ, cod_user, nom_archivo, cod_estado) values('".$tipo_revision."', '".$_POST['id_fasfield']."', '".($_POST['observacion'])."', '".$_SESSION['cod_usuario']."', '".$_SESSION['nom_archivo']."', '".$_POST['cod_estado']."') ";
        $query=pg_query($conexion, $insert);

              if($query){
              //  echo "1"; // se agregó la revisión..
                  // Luego borramos el 
                $delete="delete from tmp_archiv where nom_archivo='".$_SESSION['nom_archivo']."' ";
                $query=pg_query($conexion, $delete);
                    if($query){
                      echo "1";
                      $_SESSION['nom_archivo']=" ";
                    }
              }
              else
                echo "2"; // Problema interno (técnico).            

      } 
      if(isset($_POST['check_visto'])){ // Revisamos que haya visto el documento).

          // Revisamos que el diagnóstico exista.

          $sql="select id_fasfield from revision_diag where id_fasfield='".$_POST['id_fasfield']."' ";
          $query=pg_query($conexion, $sql);
          $rows=pg_num_rows($query);
              if($rows){

              $udpate="update revision_diag set visto=1 where id_revision='".$_POST['id_revision']."' ";
              $query=pg_query($conexion, $update);
                    if($query)
                      echo "1"; // Ha visto el archivo....
                    else
                      echo "2"; // Problema técnico..
  
              }
      }
      


        if(isset($_POST['add_serv'])){ // Agregar y cotizar servicios // Elaboración de diagnósticos.
        

            if(isset($_POST['crea_serv_recom'])){ // Crear servicio a recomendar

                // Verificamos que el servicio aún no esté recomendado..
                  $sql2="select cod_servicio from serv_recom_diag where cod_servicio='".$_POST['cod_servicio']."' ";
                  $query2=pg_query($conexion, $sql2); 
                  $rows=pg_num_rows($query2);

                      if($rows)
                        echo "3"; // Servicio ya se encuentra recomendado en el diagnóstico..
                      
                      else{ // AHora insertarmos el servicio recomendado..

                         // Buscamos el nombre del producto y plazo sugerido del servico (defecto).

                        $sql3="select * from produc_servi where cod_servicio='".$_POST['cod_servicio']."' ";
                        $query3=pg_query($conexion, $sql3);
                        $rows3=pg_num_rows($query3);
                        
                                if($rows3){
                                  $dato3=pg_fetch_assoc($query3);
                                  $cod_product_serv=$dato3['cod_produc_serv'];
                                }
                                else
                                  $cod_product_serv=0;
                          
                    $insert="insert into serv_recom_diag (id_elab_diag, cod_servicio, pr_serv_n, cod_produc_serv) values('".$_POST['id_elab_diag']."', '".$_POST['cod_servicio']."', '".$_POST['pr_servi_n']."', '".$cod_product_serv."' ) ";
                         $query=pg_query($conexion, $insert);
                            if($query)
                              echo "1";
                            else
                              echo "2"; // Problema técnico...

                      }

            } 
            
            if(isset($_POST['list_serv'])){ // Listar servicios recomendados a cotizar.

              include('list_serv.php');
            } 
            
            //else if(isset($_POST['serv_cotizar'])) // Ver panel para servicio recomendar y cotizar...
              //  include('serv_cotizar.php');  
          }

          if(isset($_POST['g_elab_diag'])){ //Graando elaboración de diagnósticos.


                // Conustamos que no haya un diagnóstico creado
             $sql="select id_fasfield from elab_diag where id_fasfield='".$_POST['id_fasfield']."' ";
              $query=pg_query($conexion, $sql);
              $rows=pg_num_rows($query);

                  if($rows){ // Si encontró entonces actualice...

                     // Equipo analítico
                    if($_SESSION['cod_grupo']==3){
                  $update="update elab_diag set fecha='".$_POST['fecha']."', direccion='".$_POST['direccion']."', cond_serv='".$_POST['cond_serv']."', elab_analitic='".$_POST['elab_analitic']."', apr_analitic='".$_POST['apr_analitic']."', llamada_client='".$_POST['llamada_client']."', pagina_web='".$_POST['pagina_web']."', consult_ent='".$_POST['consult_ent']."', pot='".$_POST['pot']."', der_peticion='".$_POST['der_peticion']."' where id_fasfield='".$_POST['id_fasfield']."' ";
                $update2="update estados_diag set estado_anali='".$_POST['cod_estado_ana']."' where id_fasfield='".$_POST['id_fasfield']."' ";
                  }

                     // Equipo Legal
                    else if($_SESSION['cod_grupo']==4){
                      $update="update elab_diag set dir_form_igac='".$_POST['dir_form_igac']."', barrio='".$_POST['barrio']."', municipio='".$_POST['municipio']."', f_nec_form='".$_POST['f_nec_form']."', par_predio_client='".$_POST['par_predio_client']."', analis_client='".$_POST['analis_client']."', msg_info='".$_POST['msg_info']."', f_esp_legal='".$_POST['f_esp_legal']."', aport_client_legal='".$_POST['aport_client_legal']."', elab_legal='".$_POST['elab_legal']."', apr_legal='".$_POST['apr_legal']."', llamada_client='".$_POST['llamada_client']."', pagina_web='".$_POST['pagina_web']."', consult_ent='".$_POST['consult_ent']."', pot='".$_POST['pot']."', der_peticion='".$_POST['der_peticion']."', aport_legal='".$_POST['aport_legal']."' where id_fasfield='".$_POST['id_fasfield']."' ";
                    $update2="update estados_diag set estado_legal='".$_POST['cod_estado_leg']."' where id_fasfield='".$_POST['id_fasfield']."' ";
                  }
                    
                     // Equipo técnico
                    else if($_SESSION['cod_grupo']==5){

                      $update="update elab_diag set f_nec_legal='".$_POST['f_nec_legal']."', f_ubic_coor='".$_POST['f_ubic_coor']."', f_cons_lic='".$_POST['f_cons_lic']."', f_riesg_inun='".$_POST['f_riesg_inun']."', f_riesg_remo='".$_POST['f_riesg_remo']."', f_riesg_proct='".$_POST['f_riesg_proct']."', tipol_cant_constr='".$_POST['tipol_cant_constr']."', alt_cant_pisos='".$_POST['alt_cant_pisos']."', dim_frent_lote='".$_POST['dim_frent_lote']."', dim_frent_const='".$_POST['dim_frent_const']."', dist_lad_lot='".$_POST['dist_lad_lot']."', dist_lot_izq='".$_POST['dist_lot_izq']."', dist_lot_der='".$_POST['dist_lot_der']."', area_catastral='".$_POST['area_catastral']."', area_docu='".$_POST['area_docu']."', ara_docu_es_de='".$_POST['ara_docu_es_de']."', area_med_de='".$_POST['area_med_de']."', raz_cumpl='".$_POST['raz_cumpl']."', f_esp_tecn='".$_POST['f_esp_tecn']."', aport_client_tecni='".$_POST['aport_client_tecni']."', aport_tecni='".$_POST['aport_tecni']."', apro_tecnico='".$_POST['apro_tecnico']."', elab_tecnico='".$_POST['elab_tecnico']."', area_lote='".$_POST['area_lote']."' where id_fasfield='".$_POST['id_fasfield']."' ";
                    $update2="update estados_diag set estado_tecn='".$_POST['cod_estado_tec']."' where id_fasfield='".$_POST['id_fasfield']."' ";
                    
                  }
                     // Usuario super administrador..
                    else{
                  $update="update elab_diag set fecha='".$_POST['fecha']."', direccion='".$_POST['direccion']."', cond_serv='".$_POST['cond_serv']."', elab_analitic='".$_POST['elab_analitic']."', apr_analitic='".$_POST['apr_analitic']."', llamada_client='".$_POST['llamada_client']."', pagina_web='".$_POST['pagina_web']."', consult_ent='".$_POST['consult_ent']."', pot='".$_POST['pot']."', der_peticion='".$_POST['der_peticion']."', dir_form_igac='".$_POST['dir_form_igac']."', barrio='".$_POST['barrio']."', municipio='".$_POST['municipio']."', f_nec_form='".$_POST['f_nec_form']."', par_predio_client='".$_POST['par_predio_client']."', analis_client='".$_POST['analis_client']."', msg_info='".$_POST['msg_info']."', f_esp_legal='".$_POST['f_esp_legal']."', aport_client_legal='".$_POST['aport_client_legal']."', elab_legal='".$_POST['elab_legal']."', apr_legal='".$_POST['apr_legal']."', f_nec_legal='".$_POST['f_nec_legal']."', f_ubic_coor='".$_POST['f_ubic_coor']."', f_cons_lic='".$_POST['f_cons_lic']."', f_riesg_inun='".$_POST['f_riesg_inun']."', f_riesg_remo='".$_POST['f_riesg_remo']."', f_riesg_proct='".$_POST['f_riesg_proct']."', tipol_cant_constr='".$_POST['tipol_cant_constr']."', alt_cant_pisos='".$_POST['alt_cant_pisos']."', dim_frent_lote='".$_POST['dim_frent_lote']."', dim_frent_const='".$_POST['dim_frent_const']."', dist_lad_lot='".$_POST['dist_lad_lot']."', dist_lot_izq='".$_POST['dist_lot_izq']."', dist_lot_der='".$_POST['dist_lot_der']."', area_catastral='".$_POST['area_catastral']."', area_docu='".$_POST['area_docu']."', ara_docu_es_de='".$_POST['ara_docu_es_de']."', area_med_de='".$_POST['area_med_de']."', raz_cumpl='".$_POST['raz_cumpl']."', f_esp_tecn='".$_POST['f_esp_tecn']."', aport_client_tecni='".$_POST['aport_client_tecni']."', aport_tecni='".$_POST['aport_tecni']."', apro_tecnico='".$_POST['apro_tecnico']."', area_lote='".$_POST['area_lote']."', aport_legal='".$_POST['aport_legal']."', elab_tecnico='".$_POST['elab_tecnico']."'  where id_fasfield='".$_POST['id_fasfield']."' ";
                
                $update2="update estados_diag set estado_anali='".$_POST['cod_estado_ana']."', estado_tecn='".$_POST['cod_estado_tec']."',  estado_legal='".$_POST['cod_estado_leg']."'  where id_fasfield='".$_POST['id_fasfield']."' ";
                
                  }
                  
                  // Verificamos los estados de los equipos
          $sql="select * from estados_diag where estado_legal=2 and estado_tecn=2 and estado_anali=2 and id_fasfield='".$_POST['id_fasfield']."'  ";
          $querysql=pg_query($conexion, $sql);
          $rowsql=pg_num_rows($querysql);
          
                if($rowsql){
                    $fecha_registro=date('Y-m-d H:mm:ss');
                    $update3="update elab_diag set cod_estado=11, fecha_fin_registro='".$fecha_registro."' where id_fasfield='".$_POST['id_fasfield']."'"; 
                    $query3=pg_query($conexion, $update3);
                }

                      $query=pg_query($conexion, $update);
                    $query2=pg_query($conexion, $update2);
                    
              // Actualizamos los estados de los equipos      

                          if($query && $query2)
                            echo "1";
                          else
                            echo "2"; // Problema técnico...

                  }


          }

          if(isset($_POST['cotiz_serv'])){ // Cotizando servicios...

              $query4="select * from opc_cotiz_serv where tipo_mod_cost='".$_POST['tipo_mod_cost']."'";
            $sql4=pg_query($conexion, $query4);
            $rows=pg_num_rows($sql4);

                if($rows){



                    for($i=0;$i<$rows;$i++){

                     $datos4=pg_fetch_assoc($sql4);

                      // BUscamos que el codigo no esté registrrado para insertarlo o actualizar su valor..

                     $sqlt="select * from cotiz_serv where id_serv_recom='".$_POST['id_serv_recom']."' and cod_op_cotiz='".$datos4['cod_op_cotiz']."' ";
                     $queryt=pg_query($conexion, $sqlt);
                     $rowst=pg_num_rows($queryt);

                          if($i==0){

                             $separar= explode('=',$_POST['valor'][$i]);
                             $valor_primer=$separar[1];
                              if($rowst){ // Actualizamos..

                                $insert="update cotiz_serv set valor='".$valor_primer."' where id_serv_recom='".$_POST['id_serv_recom']."' and cod_op_cotiz='".$datos4['cod_op_cotiz']."' ";

                              }else{ // Insertamos..

                              $insert="insert into cotiz_serv (id_serv_recom, cod_op_cotiz, valor) values('".$_POST['id_serv_recom']."', '".$datos4['cod_op_cotiz']."', '".$valor_primer."' ) ";

                              }

                          }else{

                              if($rowst){ // Actualizamos..

                                $insert="update cotiz_serv set valor='".$_POST['valor'][$i]."' where id_serv_recom='".$_POST['id_serv_recom']."' and cod_op_cotiz='".$datos4['cod_op_cotiz']."' ";

                              }else{ // Insertamos..

                              $insert="insert into cotiz_serv (id_serv_recom, cod_op_cotiz, valor) values('".$_POST['id_serv_recom']."', '".$datos4['cod_op_cotiz']."', '".$_POST['valor'][$i]."' ) ";

                              }
                          }

                          $queryy=pg_query($conexion, $insert);

                    }

                          if($queryy)
                            echo "1";
                          else
                            echo "2";
                }

          }
           // Agregamos foto de los servicios
           if(isset($_GET['agr_foto'])){
               
                           if($_GET['campo']==1)
                           $campo="foto_aser_sit_act";
                           else if($_GET['campo']==2) 
                           $campo="foto_graf_all_serv";
                           else if($_GET['campo']==3) 
                           $campo="foto_graf_serv";
               
                     if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') 
                            {
                            
                                //obtenemos el archivo a subir
                                $file = $_FILES['archivo']['name'];
                            
                                //comprobamos si existe un directorio para subir el archivo
                                //si no es así, lo creamos
                                /*if(!is_dir("files/")) 
                                    mkdir("files/", 0777);*/
                                 
                                //comprobamos si el archivo ha subido
                                if ($file && move_uploaded_file($_FILES['archivo']['tmp_name'],"../files/doc_elab_diag/".$file))
                                {
                                   sleep(3);//retrasamos la petición 3 segundos
                                            
                                               if($_GET['campo']<=2)
                                           $insert="update elab_diag set $campo='".$file."' where id_fasfield='".$_GET['id_fasfield']."' ";
                                           else
                                           $insert="update serv_recom_diag set $campo='".$file."' where id_serv_recom='".$_GET['id_fasfield']."' ";
                                           
                                          $query=pg_query($conexion, $insert);
                                   echo $file;//devolvemos el nombre del archivo para pintar la imagen
                                }
                            }else{
                                throw new Exception("Error Processing Request", 1);   
                            }                    
                                    

           }

           if(isset($_POST['gene_dash_direct'])){  // GGenerar dashboard  de directores y asesores..


                  if($_POST['tipo_informe']==1){

                      if($_POST['ciudad']=='Todos')  // Si son todas las ciudad
                      $parametro='';
                      else if($_POST['ciudad']=='solbaq')  // Si son todas las ciudad
                      $parametro="(enc_procesadas.ciudad='Barranquilla' or enc_procesadas.ciudad='Soledad')  and ";
                      else
                      $parametro="enc_procesadas.ciudad='".($_POST['ciudad'])."' and";

                    

                        // Consulto la cantidad de prospectos que tiene la regional.
                        $sql="select cod_enc_proc from enc_procesadas where $parametro tipo_encuesta=5 and fecha_filtro between '".$_POST['fecha_1']."' and '".$_POST['fecha_2']."' ";
                        $query=pg_query($conexion, $sql);
                        $prospectos=pg_num_rows($query);

                         // Consulto la cantidad de diagnósticos que tiene la regional.
                       $sql2="select cod_enc_proc from enc_procesadas where $parametro tipo_encuesta=1 and fecha_filtro between '".$_POST['fecha_1']."' and '".$_POST['fecha_2']."'";
                        $query2=pg_query($conexion, $sql2);
                        $diagnosticos=pg_num_rows($query2);

                         // Consulto la cantidad de prreporte de asesores que tiene la regional.
                        $sql3="select cod_enc_proc from enc_procesadas where $parametro tipo_encuesta=2 and fecha_filtro between '".$_POST['fecha_1']."' and '".$_POST['fecha_2']."'";
                        $query3=pg_query($conexion, $sql3);
                        $repor_asesores=pg_num_rows($query3);


                         // Consulto la cantidad de numero de prospectos de promotores  que tiene la regional.
                        $sql4="select sum(n_pros_prom) as n_pros_nom from enc_procesadas where $parametro tipo_encuesta=3 and fecha_filtro between '".$_POST['fecha_1']."' and '".$_POST['fecha_2']."'";
                        $query4=pg_query($conexion, $sql4);
                        $repor_promotores=pg_num_rows($query4);
                            if($repor_promotores){
                                $datos_prom=pg_fetch_assoc($query4);
                              $n_pros_nom=$datos_prom['n_pros_nom'];
                            }

                        //Buscamos los asesores de la ciudad específica.

                        $sql_asesor="select distinct asesor from enc_procesadas where $parametro fecha_filtro between '".$_POST['fecha_1']."' and '".$_POST['fecha_2']."' and tipo_encuesta=5 ";
                        $query_asesor=pg_query($conexion, $sql_asesor);
                        $rows=pg_num_rows($query_asesor);
                              $i=1;
                              $nom_asesor=0;
                               $prospectos_ase=0;
                          


                           $sql711="select distinct enc_procesadas.asesor from enc_procesadas, det_repor_aseso where $parametro enc_procesadas.id_fasfield=det_repor_aseso.id_fasfield and enc_procesadas.tipo_encuesta=2 and det_repor_aseso.resul_visita='Visitado y pagado' and enc_procesadas.cod_estado=6 and enc_procesadas.fecha_filtro between '".$_POST['fecha_1']."' and '".$_POST['fecha_2']."' ";
                        $query_asesor11=pg_query($conexion, $sql711);
                        $rows=pg_num_rows($query_asesor11);
                              $i=1;

                                 // SUmamos el dinero recaudado por Diagnóstico Vistado y Pagado


                        $sql71="select distinct enc_procesadas.cliente, det_repor_aseso.valor, enc_procesadas.id_fasfield from enc_procesadas, det_repor_aseso where $parametro enc_procesadas.id_fasfield=det_repor_aseso.id_fasfield and enc_procesadas.tipo_encuesta=2 and det_repor_aseso.resul_visita='Visitado y pagado' and enc_procesadas.cod_estado=6 and enc_procesadas.fecha_filtro between '".$_POST['fecha_1']."' and '".$_POST['fecha_2']."' ";
                          $query71=pg_query($conexion, $sql71);
                        $rows_71=pg_num_rows($query71); 
                               $v_diagnos=0;
                              if($rows_71){                                 

                                  $v_diagnos=0;
                                  while($datos71=pg_fetch_assoc($query71)){
                                    $v_diagnos=$datos71['valor']+$v_diagnos;
                                  }                                 
                              }
                            
                           /* while($datos=pg_fetch_assoc($query_asesor11)){

                                   
                                     if($i==$rows)
                                     $nom_asesor2.="'".$datos['asesor']."'";
                                     else
                                     $nom_asesor2.="'".$datos['asesor']."', ";

                                   //COntamos los prospectos realizados del asesor.

                                        // Consulto la cantidad de prospectos que tiene la regional.
                                       $sql6="select count(enc_procesadas.asesor) as total from enc_procesadas, det_repor_aseso where $parametro enc_procesadas.id_fasfield=det_repor_aseso.id_fasfield and  enc_procesadas.tipo_encuesta=2 and det_repor_aseso.resul_visita='Visitado y Pagado' and enc_procesadas.fecha_filtro between '".$_POST['fecha_1']."' and '".$_POST['fecha_2']."' and  enc_procesadas.asesor='".$datos['asesor']."' ";
                                        $query6=pg_query($conexion, $sql6);
                                        $vend5=pg_num_rows($query6);
                                        @$datos5=pg_fetch_assoc($query6);

                                            if($i==$rows)
                                           $vend_ase.=$datos5['total'];
                                               else
                                             $vend_ase.=$datos5['total'].", ";

                              $i++;
                            }*/

                       $sql78="select distinct det_repor_aseso.resul_visita from enc_procesadas, det_repor_aseso where  $parametro enc_procesadas.id_fasfield=det_repor_aseso.id_fasfield and enc_procesadas.tipo_encuesta=2 and (resul_visita='".('Visitado y no interesado')."' or resul_visita='".('Visitado y reagendado (Se fue hasta la vivienda y el cliente pidió un cambio en la agenda de la visita)')."' or  resul_visita='".('Llamado y no se logró contactar (antes de la visita no se logró confirmación)')."' or  resul_visita='".('Visitado y no se logró contactar (se fue hasta la vivienda y no se logró confirmación)')."') and enc_procesadas.fecha_filtro between '".$_POST['fecha_1']."' and '".$_POST['fecha_2']."' ";
                            $query78=pg_query($conexion, $sql78);
                        $rows78=pg_num_rows($query78);
                                  $i=1;

                         

                         
  // Consulto los diagnósticos que no tomaron el servicio
                       $sql8="select det_repor_aseso.tom_serv from enc_procesadas, det_repor_aseso where $parametro  enc_procesadas.id_fasfield=det_repor_aseso.id_fasfield and enc_procesadas.tipo_encuesta=2 and det_repor_aseso.tom_serv='No' and enc_procesadas.fecha_filtro between '".$_POST['fecha_1']."' and '".$_POST['fecha_2']."' ";
                        $query8=pg_query($conexion, $sql8);
                        $tom_servno=pg_num_rows($query8);
                       // Consulto los diagnósticos que tomaron el servicio
                       
                        $sql9="select det_repor_aseso.tom_serv from enc_procesadas, det_repor_aseso where $parametro enc_procesadas.id_fasfield=det_repor_aseso.id_fasfield and enc_procesadas.tipo_encuesta=2 and det_repor_aseso.tom_serv='Si' and enc_procesadas.fecha_filtro between '".$_POST['fecha_1']."' and '".$_POST['fecha_2']."' ";
                        $query9=pg_query($conexion, $sql9);
                        $tom_servsi=pg_num_rows($query9); 
                        
                         // Consulto los diagnósticos pendientes por venta
                        $sql10="select det_repor_aseso.tom_serv from enc_procesadas, det_repor_aseso where $parametro enc_procesadas.id_fasfield=det_repor_aseso.id_fasfield and enc_procesadas.tipo_encuesta=2 and det_repor_aseso.tom_serv='Pendiente de venta' and enc_procesadas.fecha_filtro between '".$_POST['fecha_1']."' and '".$_POST['fecha_2']."' ";
                        $query10=pg_query($conexion, $sql10);
                        $tom_servpendventa=pg_num_rows($query10); 
                        
                          // Consulto los diagnósticos pendientes por venta
                        $sql11="select det_repor_aseso.tom_serv from enc_procesadas, det_repor_aseso where $parametro enc_procesadas.id_fasfield=det_repor_aseso.id_fasfield and enc_procesadas.tipo_encuesta=2 and det_repor_aseso.tom_serv='No viable' and enc_procesadas.fecha_filtro between '".$_POST['fecha_1']."' and '".$_POST['fecha_2']."' ";
                        $query11=pg_query($conexion, $sql11);
                        $tom_servnoviable=pg_num_rows($query11);
                        

                        /// Recuado de cuotas..
                           $sql127="select distinct enc_procesadas.cliente, det_repor_aseso.valor, enc_procesadas.id_fasfield from enc_procesadas, det_repor_aseso where $parametro enc_procesadas.id_fasfield=det_repor_aseso.id_fasfield and enc_procesadas.tipo_encuesta=2 and det_repor_aseso.tipo_visita='".'Recuado de cuotas'."' and enc_procesadas.cod_estado=6 and  enc_procesadas.fecha_filtro between '".$_POST['fecha_1']."' and '".$_POST['fecha_2']."' ";
                           $query127=pg_query($conexion, $sql127);
                         $rows_recaudo=pg_num_rows($query127); 
                              $recaudo_cuotas=0;
                              if($rows_recaudo){                                  

                                  $recaudo_cuotas=0;
                                  while($datosrec=pg_fetch_assoc($query127)){
                                    $recaudo_cuotas=$datosrec['valor']+$recaudo_cuotas;
                                  }


                              }

                         /// Servicios express
                          $sql1278="select distinct enc_procesadas.cliente, det_repor_aseso.valor, enc_procesadas.id_fasfield from enc_procesadas, det_repor_aseso where $parametro enc_procesadas.id_fasfield=det_repor_aseso.id_fasfield and enc_procesadas.tipo_encuesta=2 and det_repor_aseso.resul_visita='".'Servicio Express'."' and enc_procesadas.cod_estado=6 and enc_procesadas.fecha_filtro between '".$_POST['fecha_1']."' and '".$_POST['fecha_2']."' ";
                           $query1278=pg_query($conexion, $sql1278);
                         $rows_recaudo8=pg_num_rows($query1278); 
                               $recaudo_express=0;
                              if($rows_recaudo8){
                                  
                                  $recaudo_express=0;
                                  while($datosrec=pg_fetch_assoc($query1278)){
                                    $recaudo_express=$datosrec['valor']+$recaudo_express;
                                  }

                              }
                        
                          /// Gratuitos.

                      $sql124="select enc_procesadas.id_fasfield, det_repor_aseso.resul_visita from enc_procesadas, det_repor_aseso where $parametro enc_procesadas.id_fasfield=det_repor_aseso.id_fasfield and enc_procesadas.tipo_encuesta=2 and det_repor_aseso.resul_visita='".('Visitado y fue gratuito el diagnóstico')."' and enc_procesadas.fecha_filtro between '".$_POST['fecha_1']."' and '".$_POST['fecha_2']."' ";
                        $query124=pg_query($conexion, $sql124);
                     $gratuito=pg_num_rows($query124); 
                     
                     
                        /// Vistado y pagado.

                       $sql125="select enc_procesadas.id_fasfield, det_repor_aseso.resul_visita from enc_procesadas, det_repor_aseso where $parametro enc_procesadas.id_fasfield=det_repor_aseso.id_fasfield and enc_procesadas.tipo_encuesta=2 and det_repor_aseso.resul_visita='Visitado y pagado' and enc_procesadas.cod_estado=6 and enc_procesadas.fecha_filtro between '".$_POST['fecha_1']."' and '".$_POST['fecha_2']."' ";
                        $query125=pg_query($conexion, $sql125);
                      $vendidos=pg_num_rows($query125); 

                          /// Entrega de diagnóstico.
                      
                       $sql126="select enc_procesadas.id_fasfield, det_repor_aseso.resul_visita from enc_procesadas, det_repor_aseso where $parametro enc_procesadas.id_fasfield=det_repor_aseso.id_fasfield and enc_procesadas.tipo_encuesta=2 and det_repor_aseso.resul_visita='".('Entrega de diagnÃ³stico')."'  and enc_procesadas.fecha_filtro between '".$_POST['fecha_1']."' and '".$_POST['fecha_2']."' ";
                        $query126=pg_query($conexion, $sql126);
                      $entr_diag=pg_num_rows($query126); 
                        


                          $sql126="select enc_procesadas.id_fasfield, det_repor_aseso.resul_visita from enc_procesadas, det_repor_aseso where $parametro enc_procesadas.id_fasfield=det_repor_aseso.id_fasfield and enc_procesadas.tipo_encuesta=2 and det_repor_aseso.resul_visita='".('Entrega de diagnÃ³stico')."' and enc_procesadas.fecha_filtro between '".$_POST['fecha_1']."' and '".$_POST['fecha_2']."' ";
                        $query126=pg_query($conexion, $sql126);
                      $entr_diag=pg_num_rows($query126); 
                        // Sumamos los servicios express..



                        //Consulto creditos por aliado

                          $s1="select enc_procesadas.id_fasfield, det_repor_aseso.aliado from enc_procesadas, det_repor_aseso where $parametro enc_procesadas.id_fasfield=det_repor_aseso.id_fasfield and enc_procesadas.tipo_encuesta=2 and det_repor_aseso.aliado='FMSD' and enc_procesadas.fecha_filtro between '".$_POST['fecha_1']."' and '".$_POST['fecha_2']."'";
                          $q1=pg_query($conexion, $s1);
                          $r1=pg_num_rows($q1);

                          $s2="select enc_procesadas.id_fasfield, det_repor_aseso.aliado from enc_procesadas, det_repor_aseso where $parametro enc_procesadas.id_fasfield=det_repor_aseso.id_fasfield and enc_procesadas.tipo_encuesta=2 and det_repor_aseso.aliado='Creditos Orbe' and enc_procesadas.fecha_filtro between '".$_POST['fecha_1']."' and '".$_POST['fecha_2']."'";
                          $q2=pg_query($conexion, $s2);
                          $r2=pg_num_rows($q2);

                          $s3="select enc_procesadas.id_fasfield, det_repor_aseso.aliado from enc_procesadas, det_repor_aseso where $parametro enc_procesadas.id_fasfield=det_repor_aseso.id_fasfield and enc_procesadas.tipo_encuesta=2 and det_repor_aseso.aliado='Interactuar' and enc_procesadas.fecha_filtro between '".$_POST['fecha_1']."' and '".$_POST['fecha_2']."'";
                          $q3=pg_query($conexion, $s3);
                          $r3=pg_num_rows($q3);

                          $s4="select enc_procesadas.id_fasfield, det_repor_aseso.aliado from enc_procesadas, det_repor_aseso where $parametro enc_procesadas.id_fasfield=det_repor_aseso.id_fasfield and enc_procesadas.tipo_encuesta=2 and det_repor_aseso.aliado='Av villas' and enc_procesadas.fecha_filtro between '".$_POST['fecha_1']."' and '".$_POST['fecha_2']."'";
                          $q4=pg_query($conexion, $s4);
                          $r4=pg_num_rows($q4);

                          // Sumo el valor ingresado por los aliados y aprobados... 

                           $s5="select sum(det_repor_aseso.valor) as valor from enc_procesadas, det_repor_aseso where $parametro enc_procesadas.id_fasfield=det_repor_aseso.id_fasfield and enc_procesadas.tipo_encuesta=2 and enc_procesadas.cod_estado=6 and det_repor_aseso.tipo_pago='Credito'  and enc_procesadas.fecha_filtro between '".$_POST['fecha_1']."' and '".$_POST['fecha_2']."'";
                          $q5=pg_query($conexion, $s5);
                          $r5=pg_num_rows($q5);
                              if($r5){
                                $datos5=pg_fetch_assoc($q5);
                                $valor_credito=$datos5['valor'];
                              }

                          // Consulto los creditos aprobados por aliados..

                          $s6="select  distinct enc_procesadas.id_fasfield from enc_procesadas, det_repor_aseso where $parametro enc_procesadas.id_fasfield=det_repor_aseso.id_fasfield and enc_procesadas.tipo_encuesta=2 and enc_procesadas.cod_estado=6  and det_repor_aseso.tipo_pago='Credito' and enc_procesadas.fecha_filtro between '".$_POST['fecha_1']."' and '".$_POST['fecha_2']."'";
                          $q6=pg_query($conexion, $s6);
                          $aprob_credito=pg_num_rows($q6);


                          $s7="select distinct enc_procesadas.id_fasfield, det_repor_aseso.aliado from enc_procesadas, det_repor_aseso where $parametro enc_procesadas.id_fasfield=det_repor_aseso.id_fasfield and enc_procesadas.tipo_encuesta=2 and  det_repor_aseso.tipo_pago='Credito' and (enc_procesadas.cod_estado=7 or enc_procesadas.cod_estado=1) and enc_procesadas.fecha_filtro between '".$_POST['fecha_1']."' and '".$_POST['fecha_2']."'";
                          $q7=pg_query($conexion, $s7);
                          $repro_credito=pg_num_rows($q7);



                            // SUmar todos los valores 

                         $sql91="select distinct enc_procesadas.cliente, det_repor_aseso.valor, enc_procesadas.id_fasfield from enc_procesadas, det_repor_aseso where $parametro enc_procesadas.id_fasfield=det_repor_aseso.id_fasfield and enc_procesadas.tipo_encuesta=2 and det_repor_aseso.tom_serv='Si' and enc_procesadas.cod_estado=6 and enc_procesadas.fecha_filtro between '".$_POST['fecha_1']."' and '".$_POST['fecha_2']."' and det_repor_aseso.aliado='' ";
                        $query91=pg_query($conexion, $sql91);
                        $rows91=pg_num_rows($query91);
                              $valor_serv=0;
                              if($rows91){

                                $valor_serv=0;
                                while($datos91=pg_fetch_assoc($query91)){

                                      $valor_serv=$valor_serv+$datos91['valor'];
                                }
                              }

                      //  @$valor_serv=pg_fetch_assoc($query91); 

                            //$valor_serv=$valor_serv['valor'];
                        
                        
                        // Diagnósticos gratuitos....
                        $_POST['asesor']=0;
                        
                        // if($_SESSION['cod_grupo']==1)
                           include('repor_dash_direc2.php');    
                          //  else
                           // echo "Estamos trabajandoa aquí, por favor intenta mas tarde.";                   

                  }else{ // Reporte en excel...
                       

                        include('repor_dash_excel_direc.php');  

                  }
                  

           }
             if(isset($_POST['gene_dash_direct3'])){  // Generar informe Paolo

                  if($_POST['tipo_informe']==1){


                      if($_POST['ciudad']=='Todos')  // Si son todas las ciudad
                      $parametro='';
                      else if($_POST['ciudad']=='solbaq')  // Si son todas las ciudad
                      $parametro="(enc_procesadas.ciudad='Barranquilla' or enc_procesadas.ciudad='Soledad')  and ";
                      else
                      $parametro="enc_procesadas.ciudad='".($_POST['ciudad'])."' and";

                    

                        // Consulto la cantidad de prospectos que tiene la regional.
                        $sql="select cod_enc_proc from enc_procesadas where $parametro tipo_encuesta=5 and fecha_filtro between '".$_POST['fecha_1']."' and '".$_POST['fecha_2']."' ";
                        $query=pg_query($conexion, $sql);
                        $prospectos=pg_num_rows($query);

                         // Consulto la cantidad de diagnósticos que tiene la regional.
                       $sql2="select cod_enc_proc from enc_procesadas where $parametro tipo_encuesta=1 and fecha_filtro between '".$_POST['fecha_1']."' and '".$_POST['fecha_2']."'";
                        $query2=pg_query($conexion, $sql2);
                        $diagnosticos=pg_num_rows($query2);

                         // Consulto la cantidad de prreporte de asesores que tiene la regional.
                        $sql3="select cod_enc_proc from enc_procesadas where $parametro tipo_encuesta=2 and fecha_filtro between '".$_POST['fecha_1']."' and '".$_POST['fecha_2']."'";
                        $query3=pg_query($conexion, $sql3);
                        $repor_asesores=pg_num_rows($query3);


                         // Consulto la cantidad de numero de prospectos de promotores  que tiene la regional.
                        $sql4="select sum(n_pros_prom) as n_pros_nom from enc_procesadas where $parametro tipo_encuesta=3 and fecha_filtro between '".$_POST['fecha_1']."' and '".$_POST['fecha_2']."'";
                        $query4=pg_query($conexion, $sql4);
                        $repor_promotores=pg_num_rows($query4);
                            if($repor_promotores){
                                $datos_prom=pg_fetch_assoc($query4);
                              $n_pros_nom=$datos_prom['n_pros_nom'];
                            }

                        //Buscamos los asesores de la ciudad específica.

                        $sql_asesor="select distinct asesor from enc_procesadas where $parametro fecha_filtro between '".$_POST['fecha_1']."' and '".$_POST['fecha_2']."' and tipo_encuesta=5 ";
                        $query_asesor=pg_query($conexion, $sql_asesor);
                        $rows=pg_num_rows($query_asesor);
                              $i=1;
                            while($datos=pg_fetch_assoc($query_asesor)){

                                   
                                     if($i==$rows)
                                     $nom_asesor.="'".$datos['asesor']."'";
                                     else
                                     $nom_asesor.="'".$datos['asesor']."', ";

                                   //COntamos los prospectos realizados del asesor.

                                        // Consulto la cantidad de prospectos que tiene la regional.
                                        $sql5="select cod_enc_proc from enc_procesadas where  $parametro tipo_encuesta=5 and asesor='".$datos['asesor']."'    and fecha_filtro between '".$_POST['fecha_1']."' and '".$_POST['fecha_2']."' ";
                                        $query5=pg_query($conexion, $sql5);
                                        $prospectos5=pg_num_rows($query5);

                                            if($i==$rows)
                                           $prospectos_ase.=$prospectos5;
                                               else
                                            $prospectos_ase.=$prospectos5.", ";


                                       $sql6="select cod_enc_proc from enc_procesadas where $parametro tipo_encuesta=1 and asesor='".$datos['asesor']."' and fecha_filtro between '".$_POST['fecha_1']."' and '".$_POST['fecha_2']."' ";
                                        $query6=pg_query($conexion, $sql6);
                                        $diagno6=pg_num_rows($query6);

                                            if($i==$rows)
                                            $diagno_ase.=$diagno6;
                                            else
                                            $diagno_ase.=$diagno6.", ";

                              $i++;
                            }


                          $sql711="select distinct enc_procesadas.asesor from enc_procesadas, det_repor_aseso where $parametro enc_procesadas.id_fasfield=det_repor_aseso.id_fasfield and  enc_procesadas.tipo_encuesta=2 and det_repor_aseso.resul_visita='Visitado y Pagado' and enc_procesadas.fecha_filtro between '".$_POST['fecha_1']."' and '".$_POST['fecha_2']."' ";
                        $query_asesor11=pg_query($conexion, $sql711);
                        $rows=pg_num_rows($query_asesor11);
                              $i=1;
                            while($datos=pg_fetch_assoc($query_asesor11)){

                                   
                                     if($i==$rows)
                                     $nom_asesor2.="'".$datos['asesor']."'";
                                     else
                                     $nom_asesor2.="'".$datos['asesor']."', ";

                                   //COntamos los prospectos realizados del asesor.

                                        // Consulto la cantidad de prospectos que tiene la regional.
                                       $sql6="select count(enc_procesadas.asesor) as total from enc_procesadas, det_repor_aseso where $parametro enc_procesadas.id_fasfield=det_repor_aseso.id_fasfield and  enc_procesadas.tipo_encuesta=2 and det_repor_aseso.resul_visita='Visitado y Pagado' and enc_procesadas.fecha_filtro between '".$_POST['fecha_1']."' and '".$_POST['fecha_2']."' and  enc_procesadas.asesor='".$datos['asesor']."' ";
                                        $query6=pg_query($conexion, $sql6);
                                        $vend5=pg_num_rows($query6);
                                        @$datos5=pg_fetch_assoc($query6);

                                            if($i==$rows)
                                           $vend_ase.=$datos5['total'];
                                               else
                                             $vend_ase.=$datos5['total'].", ";

                              $i++;
                            }

                       $sql78="select distinct det_repor_aseso.resul_visita from enc_procesadas, det_repor_aseso where  $parametro enc_procesadas.id_fasfield=det_repor_aseso.id_fasfield and enc_procesadas.tipo_encuesta=2 and (resul_visita='".('Visitado y no interesado')."' or resul_visita='".('Visitado y reagendado (Se fue hasta la vivienda y el cliente pidió un cambio en la agenda de la visita)')."' or  resul_visita='".('Llamado y no se logró contactar (antes de la visita no se logró confirmación)')."' or  resul_visita='".('Visitado y no se logró contactar (se fue hasta la vivienda y no se logró confirmación)')."') and enc_procesadas.fecha_filtro between '".$_POST['fecha_1']."' and '".$_POST['fecha_2']."' ";
                            $query78=pg_query($conexion, $sql78);
                        $rows78=pg_num_rows($query78);
                                  $i=1;
                           while($datos78=pg_fetch_assoc($query78)){

                                   
                                      if($i==$rows78)
                                     $resul_visita.="'".$datos78['resul_visita']."'";
                                     else
                                     $resul_visita.="'".$datos78['resul_visita']."', ";

                                        // Consulto la cantidad de prospectos que tiene la regional.
                                      $sql512="select enc_procesadas.id_fasfield from enc_procesadas, det_repor_aseso where  $parametro enc_procesadas.id_fasfield=det_repor_aseso.id_fasfield and enc_procesadas.tipo_encuesta=2 and det_repor_aseso.resul_visita='".$datos78['resul_visita']."' and enc_procesadas.fecha_filtro between '".$_POST['fecha_1']."' and '".$_POST['fecha_2']."' ";
                                        $query512=pg_query($conexion, $sql512);
                                      $rows512=pg_num_rows($query512);


                                            if($i==$rows)
                                           $rows_resul_visit.=$rows512;
                                               else
                                            $rows_resul_visit.=$rows512.", ";
                              $i++;
                            }

                           

                           //select distinct enc_procesadas.asesor from enc_procesadas, det_repor_aseso where enc_procesadas.id_fasfield=det_repor_aseso.id_fasfield and  enc_procesadas.tipo_encuesta=2 and resul_visita='Visitado y Pagado' and enc_procesadas.fecha_filtro between '2017-10-01' and '2017-10-16'

                         

                            //Resultado de las visitas.

                         /*$sql7="select distinct det_repor_aseso.resul_visita from enc_procesadas, det_repor_aseso where  $parametro enc_procesadas.id_fasfield=det_repor_aseso.id_fasfield and enc_procesadas.tipo_encuesta=2 and resul_visita<>'' and enc_procesadas.fecha_filtro between '".$_POST['fecha_1']."' and '".$_POST['fecha_2']."' ";
                            $query7=pg_query($conexion, $sql7);

                                  $i=1;
                            while($datos7=pg_fetch_assoc($query7)){

                                   
                                     if($i==$rows)
                                     $resul_visita.="'".$datos7['resul_visita']."'";
                                     else
                                     $resul_visita.="'".$datos7['resul_visita']."', ";

                                        // Consulto la cantidad de prospectos que tiene la regional.
                                      $sql51="select enc_procesadas.id_fasfield from enc_procesadas, det_repor_aseso where  $parametro enc_procesadas.id_fasfield=det_repor_aseso.id_fasfield and enc_procesadas.tipo_encuesta=2 and det_repor_aseso.resul_visita='".$datos7['resul_visita']."' and enc_procesadas.fecha_filtro between '".$_POST['fecha_1']."' and '".$_POST['fecha_2']."' ";
                                        $query51=pg_query($conexion, $sql51);
                                      $rows51=pg_num_rows($query51);


                                            if($i==$rows)
                                           $rows_resul_visit.=$rows51;
                                               else
                                            $rows_resul_visit.=$rows51.", ";
                              $i++;
                            }*/
                          
                          
                          //Resultado de las visitas. 2

                           /* $sql77="select distinct det_repor_aseso.tipo_visita from enc_procesadas, det_repor_aseso where $parametro enc_procesadas.id_fasfield=det_repor_aseso.id_fasfield and  enc_procesadas.tipo_encuesta=2 and tipo_visita<>'' and enc_procesadas.fecha_filtro between '".$_POST['fecha_1']."' and '".$_POST['fecha_2']."' ";
                            $query77=pg_query($conexion, $sql77);

                                  $i=1;
                            while($datos77=pg_fetch_assoc($query77)){

                                   
                                     if($i==$rows)
                                      $tipo_visita.="'".$datos77['tipo_visita']."'";
                                     else
                                     $tipo_visita.="'".$datos77['tipo_visita']."', ";

                                        // Consulto la cantidad de prospectos que tiene la regional.
                                        $sql511="select enc_procesadas.id_fasfield from enc_procesadas, det_repor_aseso where $parametro enc_procesadas.id_fasfield=det_repor_aseso.id_fasfield and enc_procesadas.tipo_encuesta=2 and det_repor_aseso.tipo_visita='".$datos77['tipo_visita']."' and enc_procesadas.fecha_filtro between '".$_POST['fecha_1']."' and '".$_POST['fecha_2']."' ";
                                        $query511=pg_query($conexion, $sql511);
                                        $rows511=pg_num_rows($query511);


                                            if($i==$rows)
                                           $rows_tipo_visit.=$rows511;
                                               else
                                            $rows_tipo_visit.=$rows511.", ";
                              $i++;
                            }*/



                            // SUmamos el dinero recaudado por Diagnóstico Vistado y Pagado


                       $sql71="select distinct enc_procesadas.cliente, det_repor_aseso.valor, enc_procesadas.id_fasfield from enc_procesadas, det_repor_aseso where $parametro enc_procesadas.id_fasfield=det_repor_aseso.id_fasfield and  enc_procesadas.tipo_encuesta=2 and resul_visita='Visitado y Pagado' and seguimientos.id_fasfield=enc_procesadas.id_fasfield and enc_procesadas.cod_estado=6 and  enc_procesadas.fecha_filtro between '".$_POST['fecha_1']."' and '".$_POST['fecha_2']."' ";
                          $query71=pg_query($conexion, $sql71);
                        $rows_71=pg_num_rows($query71); 
                              $v_diagnos=0;
                              if($rows_71){                                 

                                  $v_diagnos=0;
                                  while($datos71=pg_fetch_assoc($query71)){
                                    $v_diagnos=$datos71['valor']+$v_diagnos;
                                  }                                 
                              }
                            
  // Consulto los diagnósticos que no tomaron el servicio
                       $sql8="select det_repor_aseso.tom_serv from enc_procesadas, det_repor_aseso where $parametro  enc_procesadas.id_fasfield=det_repor_aseso.id_fasfield and enc_procesadas.tipo_encuesta=2 and det_repor_aseso.tom_serv='No' and enc_procesadas.fecha_filtro between '".$_POST['fecha_1']."' and '".$_POST['fecha_2']."' ";
                        $query8=pg_query($conexion, $sql8);
                        $tom_servno=pg_num_rows($query8);
                       // Consulto los diagnósticos que tomaron el servicio
                       
                        $sql9="select det_repor_aseso.tom_serv from enc_procesadas, det_repor_aseso where $parametro enc_procesadas.id_fasfield=det_repor_aseso.id_fasfield and enc_procesadas.tipo_encuesta=2 and det_repor_aseso.tom_serv='Si' and enc_procesadas.fecha_filtro between '".$_POST['fecha_1']."' and '".$_POST['fecha_2']."' ";
                        $query9=pg_query($conexion, $sql9);
                        $tom_servsi=pg_num_rows($query9); 
                        
                         // Consulto los diagnósticos pendientes por venta
                        $sql10="select det_repor_aseso.tom_serv from enc_procesadas, det_repor_aseso where $parametro enc_procesadas.id_fasfield=det_repor_aseso.id_fasfield and enc_procesadas.tipo_encuesta=2 and det_repor_aseso.tom_serv='Pendiente de venta' and enc_procesadas.fecha_filtro between '".$_POST['fecha_1']."' and '".$_POST['fecha_2']."' ";
                        $query10=pg_query($conexion, $sql10);
                        $tom_servpendventa=pg_num_rows($query10); 
                        
                          // Consulto los diagnósticos pendientes por venta
                        $sql11="select det_repor_aseso.tom_serv from enc_procesadas, det_repor_aseso where $parametro enc_procesadas.id_fasfield=det_repor_aseso.id_fasfield and enc_procesadas.tipo_encuesta=2 and det_repor_aseso.tom_serv='No viable' and enc_procesadas.fecha_filtro between '".$_POST['fecha_1']."' and '".$_POST['fecha_2']."' ";
                        $query11=pg_query($conexion, $sql11);
                        $tom_servnoviable=pg_num_rows($query11);
                        

                        /// Recuado de cuotas..
                          $sql127="select distinct enc_procesadas.cliente, det_repor_aseso.valor, enc_procesadas.id_fasfield from enc_procesadas, det_repor_aseso where $parametro enc_procesadas.id_fasfield=det_repor_aseso.id_fasfield and enc_procesadas.tipo_encuesta=2 and det_repor_aseso.tipo_visita='".'Recuado de cuotas'." and enc_procesadas.cod_estado=6 and  enc_procesadas.fecha_filtro between '".$_POST['fecha_1']."' and '".$_POST['fecha_2']."' ";
                           $query127=pg_query($conexion, $sql127);
                         $rows_recaudo=pg_num_rows($query127); 
                              
                              if($rows_recaudo){                                  

                                  $recaudo_cuotas=0;
                                  while($datosrec=pg_fetch_assoc($query127)){
                                    $recaudo_cuotas=$datosrec['valor']+$recaudo_cuotas;
                                  }


                              }

                         /// Servicios express
                          $sql1278="select distinct enc_procesadas.cliente, det_repor_aseso.valor, enc_procesadas.id_fasfield from enc_procesadas, det_repor_aseso where $parametro enc_procesadas.id_fasfield=det_repor_aseso.id_fasfield and enc_procesadas.tipo_encuesta=2 and det_repor_aseso.resul_visita='".'Servicio Express'."' and enc_procesadas.cod_estado=6 and enc_procesadas.fecha_filtro between '".$_POST['fecha_1']."' and '".$_POST['fecha_2']."' ";
                           $query1278=pg_query($conexion, $sql1278);
                         $rows_recaudo8=pg_num_rows($query1278); 
                              
                              if($rows_recaudo8){
                                  
                                  $recaudo_express=0;
                                  while($datosrec=pg_fetch_assoc($query1278)){
                                    $recaudo_express=$datosrec['valor']+$recaudo_express;
                                  }

                              }
                        
                          /// Gratuitos.

                      $sql124="select enc_procesadas.id_fasfield, det_repor_aseso.resul_visita from enc_procesadas, det_repor_aseso where $parametro enc_procesadas.id_fasfield=det_repor_aseso.id_fasfield and enc_procesadas.tipo_encuesta=2 and det_repor_aseso.resul_visita='".('Visitado y fue gratuito el diagnóstico')."' and enc_procesadas.fecha_filtro between '".$_POST['fecha_1']."' and '".$_POST['fecha_2']."' ";
                        $query124=pg_query($conexion, $sql124);
                     $gratuito=pg_num_rows($query124); 
                     
                     
                        /// Vistado y pagado.

                       $sql125="select enc_procesadas.id_fasfield, det_repor_aseso.resul_visita from enc_procesadas, det_repor_aseso where $parametro enc_procesadas.id_fasfield=det_repor_aseso.id_fasfield and enc_procesadas.tipo_encuesta=2 and det_repor_aseso.resul_visita='Visitado y pagado' and enc_procesadas.cod_estado=6 and enc_procesadas.fecha_filtro between '".$_POST['fecha_1']."' and '".$_POST['fecha_2']."' ";
                        $query125=pg_query($conexion, $sql125);
                      $vendidos=pg_num_rows($query125); 

                          /// Entrega de diagnóstico.
                      
                       $sql126="select enc_procesadas.id_fasfield, det_repor_aseso.resul_visita from enc_procesadas, det_repor_aseso where $parametro enc_procesadas.id_fasfield=det_repor_aseso.id_fasfield and enc_procesadas.tipo_encuesta=2 and det_repor_aseso.resul_visita='".('Entrega de diagnÃ³stico')."'  and enc_procesadas.fecha_filtro between '".$_POST['fecha_1']."' and '".$_POST['fecha_2']."' ";
                        $query126=pg_query($conexion, $sql126);
                      $entr_diag=pg_num_rows($query126); 
                        


                          $sql126="select enc_procesadas.id_fasfield, det_repor_aseso.resul_visita from enc_procesadas, det_repor_aseso where $parametro enc_procesadas.id_fasfield=det_repor_aseso.id_fasfield and enc_procesadas.tipo_encuesta=2 and det_repor_aseso.resul_visita='".('Entrega de diagnÃ³stico')."' and enc_procesadas.fecha_filtro between '".$_POST['fecha_1']."' and '".$_POST['fecha_2']."' ";
                        $query126=pg_query($conexion, $sql126);
                      $entr_diag=pg_num_rows($query126); 
                        // Sumamos los servicios express..



                        //Consulto creditos por aliado

                          $s1="select enc_procesadas.id_fasfield, det_repor_aseso.aliado from enc_procesadas, det_repor_aseso where $parametro enc_procesadas.id_fasfield=det_repor_aseso.id_fasfield and enc_procesadas.tipo_encuesta=2 and det_repor_aseso.aliado='FMSD' and enc_procesadas.fecha_filtro between '".$_POST['fecha_1']."' and '".$_POST['fecha_2']."'";
                          $q1=pg_query($conexion, $s1);
                          $r1=pg_num_rows($q1);

                          $s2="select enc_procesadas.id_fasfield, det_repor_aseso.aliado from enc_procesadas, det_repor_aseso where $parametro enc_procesadas.id_fasfield=det_repor_aseso.id_fasfield and enc_procesadas.tipo_encuesta=2 and det_repor_aseso.aliado='Creditos Orbe' and enc_procesadas.fecha_filtro between '".$_POST['fecha_1']."' and '".$_POST['fecha_2']."'";
                          $q2=pg_query($conexion, $s2);
                          $r2=pg_num_rows($q2);

                          $s3="select enc_procesadas.id_fasfield, det_repor_aseso.aliado from enc_procesadas, det_repor_aseso where $parametro enc_procesadas.id_fasfield=det_repor_aseso.id_fasfield and enc_procesadas.tipo_encuesta=2 and det_repor_aseso.aliado='Interactuar' and enc_procesadas.fecha_filtro between '".$_POST['fecha_1']."' and '".$_POST['fecha_2']."'";
                          $q3=pg_query($conexion, $s3);
                          $r3=pg_num_rows($q3);

                          $s4="select enc_procesadas.id_fasfield, det_repor_aseso.aliado from enc_procesadas, det_repor_aseso where $parametro enc_procesadas.id_fasfield=det_repor_aseso.id_fasfield and enc_procesadas.tipo_encuesta=2 and det_repor_aseso.aliado='Av villas' and enc_procesadas.fecha_filtro between '".$_POST['fecha_1']."' and '".$_POST['fecha_2']."'";
                          $q4=pg_query($conexion, $s4);
                          $r4=pg_num_rows($q4);

                          // Sumo el valor ingresado por los aliados y aprobados... 

                           $s5="select sum(det_repor_aseso.valor) as valor from enc_procesadas, det_repor_aseso where $parametro enc_procesadas.id_fasfield=det_repor_aseso.id_fasfield and enc_procesadas.tipo_encuesta=2 and enc_procesadas.cod_estado=6 and det_repor_aseso.tipo_pago='Credito'  and enc_procesadas.fecha_filtro between '".$_POST['fecha_1']."' and '".$_POST['fecha_2']."'";
                          $q5=pg_query($conexion, $s5);
                          $r5=pg_num_rows($q5);
                              if($r5){
                                $datos5=pg_fetch_assoc($q5);
                                $valor_credito=$datos5['valor'];
                              }

                          // Consulto los creditos aprobados por aliados..

                          $s6="select  distinct enc_procesadas.id_fasfield from enc_procesadas, det_repor_aseso where $parametro enc_procesadas.id_fasfield=det_repor_aseso.id_fasfield and enc_procesadas.tipo_encuesta=2 and enc_procesadas.cod_estado=6  and det_repor_aseso.tipo_pago='Credito' and enc_procesadas.fecha_filtro between '".$_POST['fecha_1']."' and '".$_POST['fecha_2']."'";
                          $q6=pg_query($conexion, $s6);
                          $aprob_credito=pg_num_rows($q6);


                          $s7="select distinct enc_procesadas.id_fasfield, det_repor_aseso.aliado from enc_procesadas, det_repor_aseso where $parametro enc_procesadas.id_fasfield=det_repor_aseso.id_fasfield and enc_procesadas.tipo_encuesta=2 and  det_repor_aseso.tipo_pago='Credito' and (enc_procesadas.cod_estado=7 or enc_procesadas.cod_estado=1) and enc_procesadas.fecha_filtro between '".$_POST['fecha_1']."' and '".$_POST['fecha_2']."'";
                          $q7=pg_query($conexion, $s7);
                          $repro_credito=pg_num_rows($q7);



                            // SUmar todos los valores 

                       $sql91="select distinct enc_procesadas.cliente, det_repor_aseso.valor, enc_procesadas.id_fasfield from enc_procesadas, det_repor_aseso where $parametro enc_procesadas.id_fasfield=det_repor_aseso.id_fasfield and enc_procesadas.tipo_encuesta=2 and det_repor_aseso.tom_serv='Si' and enc_procesadas.cod_estado=6 and enc_procesadas.fecha_filtro between '".$_POST['fecha_1']."' and '".$_POST['fecha_2']."' ";
                        $query91=pg_query($conexion, $sql91);
                        $rows91=pg_num_rows($query91);
                              if($rows91){

                                $valor_serv=0;
                                while($datos91=pg_fetch_assoc($query91)){

                                      $valor_serv=$valor_serv+$datos91['valor'];
                                }
                              }
                      //  @$valor_serv=pg_fetch_assoc($query91); 

                            //$valor_serv=$valor_serv['valor'];
                        
                        
                        // Diagnósticos gratuitos....
                        
                        
                        // if($_SESSION['cod_grupo']==1)
                           include('repor_dash_direc4.php');    
                          //  else
                           // echo "Estamos trabajandoa aquí, por favor intenta mas tarde.";                   

                  }else{ // Reporte en excel...
                       

                        include('repor_dash_excel_direc.php');  

                  }
                  

           }
           
           


           if(isset($_POST['gene_dash_asesor'])){  // GGenerar dashboard  para el asesor específico....


                
                      if($_POST['asesor']=='Todos')  // Si son todas las ciudad
                      $parametro='';
                      else if($_POST['asesor']=='solbaq')  // Si son todas las ciudad
                      $parametro="(enc_procesadas.ciudad='Barranquilla' or enc_procesadas.ciudad='Soledad')  and ";
                      else
                      $parametro="enc_procesadas.asesor='".($_POST['asesor'])."' and";

                    

                        // Consulto la cantidad de prospectos que tiene la regional.
                        $sql="select cod_enc_proc from enc_procesadas where $parametro tipo_encuesta=5 and fecha_filtro between '".$_POST['fecha_1']."' and '".$_POST['fecha_2']."' ";
                        $query=pg_query($conexion, $sql);
                        $prospectos=pg_num_rows($query);

                         // Consulto la cantidad de diagnósticos que tiene la regional.
                       $sql2="select cod_enc_proc from enc_procesadas where $parametro tipo_encuesta=1 and fecha_filtro between '".$_POST['fecha_1']."' and '".$_POST['fecha_2']."'";
                        $query2=pg_query($conexion, $sql2);
                        $diagnosticos=pg_num_rows($query2);

                         // Consulto la cantidad de prreporte de asesores que tiene la regional.
                        $sql3="select cod_enc_proc from enc_procesadas where $parametro tipo_encuesta=2 and fecha_filtro between '".$_POST['fecha_1']."' and '".$_POST['fecha_2']."'";
                        $query3=pg_query($conexion, $sql3);
                        $repor_asesores=pg_num_rows($query3);


                         // Consulto la cantidad de numero de prospectos de promotores  que tiene la regional.
                        $sql4="select sum(n_pros_prom) as n_pros_nom from enc_procesadas where $parametro tipo_encuesta=3 and fecha_filtro between '".$_POST['fecha_1']."' and '".$_POST['fecha_2']."'";
                        $query4=pg_query($conexion, $sql4);
                        $repor_promotores=pg_num_rows($query4);
                            if($repor_promotores){
                                $datos_prom=pg_fetch_assoc($query4);
                              $n_pros_nom=$datos_prom['n_pros_nom'];
                            }

                        //Buscamos los asesores de la ciudad específica.

                        $sql_asesor="select distinct asesor from enc_procesadas where $parametro fecha_filtro between '".$_POST['fecha_1']."' and '".$_POST['fecha_2']."' and tipo_encuesta=5 ";
                        $query_asesor=pg_query($conexion, $sql_asesor);
                        $rows=pg_num_rows($query_asesor);
                              $i=1;
                               $nom_asesor=0;
                               $prospectos_ase=0;
                               $diagno_ase=0;
                            while($datos=pg_fetch_assoc($query_asesor)){

                                   
                                     if($i==$rows)
                                     $nom_asesor.="'".$datos['asesor']."'";
                                     else
                                     $nom_asesor.="'".$datos['asesor']."', ";

                                   //COntamos los prospectos realizados del asesor.

                                        // Consulto la cantidad de prospectos que tiene la regional.
                                        $sql5="select cod_enc_proc from enc_procesadas where  $parametro tipo_encuesta=5 and asesor='".$datos['asesor']."'    and fecha_filtro between '".$_POST['fecha_1']."' and '".$_POST['fecha_2']."' ";
                                        $query5=pg_query($conexion, $sql5);
                                        $prospectos5=pg_num_rows($query5);

                                            if($i==$rows)
                                           $prospectos_ase.=$prospectos5;
                                               else
                                            $prospectos_ase.=$prospectos5.", ";


                                       $sql6="select cod_enc_proc from enc_procesadas where $parametro tipo_encuesta=1 and asesor='".$datos['asesor']."' and fecha_filtro between '".$_POST['fecha_1']."' and '".$_POST['fecha_2']."' ";
                                        $query6=pg_query($conexion, $sql6);
                                        $diagno6=pg_num_rows($query6);

                                            if($i==$rows)
                                            $diagno_ase.=$diagno6;
                                            else
                                            $diagno_ase.=$diagno6.", ";

                              $i++;
                            }


                          $sql711="select distinct enc_procesadas.asesor from enc_procesadas, det_repor_aseso where $parametro enc_procesadas.id_fasfield=det_repor_aseso.id_fasfield and  enc_procesadas.tipo_encuesta=2 and det_repor_aseso.resul_visita='Visitado y Pagado' and enc_procesadas.fecha_filtro between '".$_POST['fecha_1']."' and '".$_POST['fecha_2']."' ";
                        $query_asesor11=pg_query($conexion, $sql711);
                        $rows=pg_num_rows($query_asesor11);
                              $i=1;
                              $nom_asesor2=0;
                              $vend_ase=0;
                            while($datos=pg_fetch_assoc($query_asesor11)){

                                   
                                     if($i==$rows)
                                     $nom_asesor2.="'".$datos['asesor']."'";
                                     else
                                     $nom_asesor2.="'".$datos['asesor']."', ";

                                   //COntamos los prospectos realizados del asesor.

                                        // Consulto la cantidad de prospectos que tiene la regional.
                                       $sql6="select count(enc_procesadas.asesor) as total from enc_procesadas, det_repor_aseso where $parametro enc_procesadas.id_fasfield=det_repor_aseso.id_fasfield and  enc_procesadas.tipo_encuesta=2 and det_repor_aseso.resul_visita='Visitado y Pagado' and enc_procesadas.fecha_filtro between '".$_POST['fecha_1']."' and '".$_POST['fecha_2']."' and  enc_procesadas.asesor='".$datos['asesor']."' ";
                                        $query6=pg_query($conexion, $sql6);
                                        $vend5=pg_num_rows($query6);
                                        @$datos5=pg_fetch_assoc($query6);

                                            if($i==$rows)
                                           $vend_ase.=$datos5['total'];
                                               else
                                             $vend_ase.=$datos5['total'].", ";

                              $i++;
                            }

                       $sql78="select distinct det_repor_aseso.resul_visita from enc_procesadas, det_repor_aseso where  $parametro enc_procesadas.id_fasfield=det_repor_aseso.id_fasfield and enc_procesadas.tipo_encuesta=2 and (resul_visita='".('Visitado y no interesado')."' or resul_visita='".('Visitado y reagendado (Se fue hasta la vivienda y el cliente pidió un cambio en la agenda de la visita)')."' or  resul_visita='".('Llamado y no se logró contactar (antes de la visita no se logró confirmación)')."' or  resul_visita='".('Visitado y no se logró contactar (se fue hasta la vivienda y no se logró confirmación)')."') and enc_procesadas.fecha_filtro between '".$_POST['fecha_1']."' and '".$_POST['fecha_2']."' ";
                            $query78=pg_query($conexion, $sql78);
                        $rows78=pg_num_rows($query78);
                                  $i=1;
                                  $resul_visita=0;
                                  $rows_resul_visit=0;
                           while($datos78=pg_fetch_assoc($query78)){

                                   
                                      if($i==$rows78)
                                     $resul_visita.="'".$datos78['resul_visita']."'";
                                     else
                                     $resul_visita.="'".$datos78['resul_visita']."', ";

                                        // Consulto la cantidad de prospectos que tiene la regional.
                                      $sql512="select enc_procesadas.id_fasfield from enc_procesadas, det_repor_aseso where  $parametro enc_procesadas.id_fasfield=det_repor_aseso.id_fasfield and enc_procesadas.tipo_encuesta=2 and det_repor_aseso.resul_visita='".$datos78['resul_visita']."' and enc_procesadas.fecha_filtro between '".$_POST['fecha_1']."' and '".$_POST['fecha_2']."' ";
                                        $query512=pg_query($conexion, $sql512);
                                      $rows512=pg_num_rows($query512);


                                            if($i==$rows)
                                           $rows_resul_visit.=$rows512;
                                               else
                                            $rows_resul_visit.=$rows512.", ";
                              $i++;
                            }

                           

                           //select distinct enc_procesadas.asesor from enc_procesadas, det_repor_aseso where enc_procesadas.id_fasfield=det_repor_aseso.id_fasfield and  enc_procesadas.tipo_encuesta=2 and resul_visita='Visitado y Pagado' and enc_procesadas.fecha_filtro between '2017-10-01' and '2017-10-16'

                         

                            //Resultado de las visitas.

                         /*$sql7="select distinct det_repor_aseso.resul_visita from enc_procesadas, det_repor_aseso where  $parametro enc_procesadas.id_fasfield=det_repor_aseso.id_fasfield and enc_procesadas.tipo_encuesta=2 and resul_visita<>'' and enc_procesadas.fecha_filtro between '".$_POST['fecha_1']."' and '".$_POST['fecha_2']."' ";
                            $query7=pg_query($conexion, $sql7);

                                  $i=1;
                            while($datos7=pg_fetch_assoc($query7)){

                                   
                                     if($i==$rows)
                                     $resul_visita.="'".$datos7['resul_visita']."'";
                                     else
                                     $resul_visita.="'".$datos7['resul_visita']."', ";

                                        // Consulto la cantidad de prospectos que tiene la regional.
                                      $sql51="select enc_procesadas.id_fasfield from enc_procesadas, det_repor_aseso where  $parametro enc_procesadas.id_fasfield=det_repor_aseso.id_fasfield and enc_procesadas.tipo_encuesta=2 and det_repor_aseso.resul_visita='".$datos7['resul_visita']."' and enc_procesadas.fecha_filtro between '".$_POST['fecha_1']."' and '".$_POST['fecha_2']."' ";
                                        $query51=pg_query($conexion, $sql51);
                                      $rows51=pg_num_rows($query51);


                                            if($i==$rows)
                                           $rows_resul_visit.=$rows51;
                                               else
                                            $rows_resul_visit.=$rows51.", ";
                              $i++;
                            }*/
                          
                          
                          //Resultado de las visitas. 2

                           /* $sql77="select distinct det_repor_aseso.tipo_visita from enc_procesadas, det_repor_aseso where $parametro enc_procesadas.id_fasfield=det_repor_aseso.id_fasfield and  enc_procesadas.tipo_encuesta=2 and tipo_visita<>'' and enc_procesadas.fecha_filtro between '".$_POST['fecha_1']."' and '".$_POST['fecha_2']."' ";
                            $query77=pg_query($conexion, $sql77);

                                  $i=1;
                            while($datos77=pg_fetch_assoc($query77)){

                                   
                                     if($i==$rows)
                                      $tipo_visita.="'".$datos77['tipo_visita']."'";
                                     else
                                     $tipo_visita.="'".$datos77['tipo_visita']."', ";

                                        // Consulto la cantidad de prospectos que tiene la regional.
                                        $sql511="select enc_procesadas.id_fasfield from enc_procesadas, det_repor_aseso where $parametro enc_procesadas.id_fasfield=det_repor_aseso.id_fasfield and enc_procesadas.tipo_encuesta=2 and det_repor_aseso.tipo_visita='".$datos77['tipo_visita']."' and enc_procesadas.fecha_filtro between '".$_POST['fecha_1']."' and '".$_POST['fecha_2']."' ";
                                        $query511=pg_query($conexion, $sql511);
                                        $rows511=pg_num_rows($query511);


                                            if($i==$rows)
                                           $rows_tipo_visit.=$rows511;
                                               else
                                            $rows_tipo_visit.=$rows511.", ";
                              $i++;
                            }*/



                            // SUmamos el dinero recaudado por Diagnóstico Vistado y Pagado


                        $sql71="select distinct enc_procesadas.cliente, det_repor_aseso.valor, enc_procesadas.id_fasfield from enc_procesadas, det_repor_aseso where $parametro enc_procesadas.id_fasfield=det_repor_aseso.id_fasfield and  enc_procesadas.tipo_encuesta=2 and resul_visita='Visitado y Pagado'  and enc_procesadas.cod_estado=6 and  enc_procesadas.fecha_filtro between '".$_POST['fecha_1']."' and '".$_POST['fecha_2']."' ";
                          $query71=pg_query($conexion, $sql71);
                        $rows_71=pg_num_rows($query71); 
                              $v_diagnos=0;
                              if($rows_71){                                 

                                  $v_diagnos=0;
                                  while($datos71=pg_fetch_assoc($query71)){
                                    $v_diagnos=$datos71['valor']+$v_diagnos;
                                  }                                 
                              }
                            
  // Consulto los diagnósticos que no tomaron el servicio
                       $sql8="select det_repor_aseso.tom_serv from enc_procesadas, det_repor_aseso where $parametro  enc_procesadas.id_fasfield=det_repor_aseso.id_fasfield and enc_procesadas.tipo_encuesta=2 and det_repor_aseso.tom_serv='No' and enc_procesadas.fecha_filtro between '".$_POST['fecha_1']."' and '".$_POST['fecha_2']."' ";
                        $query8=pg_query($conexion, $sql8);
                        $tom_servno=pg_num_rows($query8);
                       // Consulto los diagnósticos que tomaron el servicio
                       
                        $sql9="select det_repor_aseso.tom_serv from enc_procesadas, det_repor_aseso where $parametro enc_procesadas.id_fasfield=det_repor_aseso.id_fasfield and enc_procesadas.tipo_encuesta=2 and det_repor_aseso.tom_serv='Si' and enc_procesadas.fecha_filtro between '".$_POST['fecha_1']."' and '".$_POST['fecha_2']."' ";
                        $query9=pg_query($conexion, $sql9);
                        $tom_servsi=pg_num_rows($query9); 
                        
                         // Consulto los diagnósticos pendientes por venta
                        $sql10="select det_repor_aseso.tom_serv from enc_procesadas, det_repor_aseso where $parametro enc_procesadas.id_fasfield=det_repor_aseso.id_fasfield and enc_procesadas.tipo_encuesta=2 and det_repor_aseso.tom_serv='Pendiente de venta' and enc_procesadas.fecha_filtro between '".$_POST['fecha_1']."' and '".$_POST['fecha_2']."' ";
                        $query10=pg_query($conexion, $sql10);
                        $tom_servpendventa=pg_num_rows($query10); 
                        
                          // Consulto los diagnósticos pendientes por venta
                        $sql11="select det_repor_aseso.tom_serv from enc_procesadas, det_repor_aseso where $parametro enc_procesadas.id_fasfield=det_repor_aseso.id_fasfield and enc_procesadas.tipo_encuesta=2 and det_repor_aseso.tom_serv='No viable' and enc_procesadas.fecha_filtro between '".$_POST['fecha_1']."' and '".$_POST['fecha_2']."' ";
                        $query11=pg_query($conexion, $sql11);
                        $tom_servnoviable=pg_num_rows($query11);
                        

                        /// Recuado de cuotas..
                           $sql127="select distinct enc_procesadas.cliente, det_repor_aseso.valor, enc_procesadas.id_fasfield from enc_procesadas, det_repor_aseso where $parametro enc_procesadas.id_fasfield=det_repor_aseso.id_fasfield and enc_procesadas.tipo_encuesta=2 and det_repor_aseso.tipo_visita='".'Recuado de cuotas'."' and enc_procesadas.cod_estado=6 and  enc_procesadas.fecha_filtro between '".$_POST['fecha_1']."' and '".$_POST['fecha_2']."' ";
                           $query127=pg_query($conexion, $sql127);
                         $rows_recaudo=pg_num_rows($query127); 
                               $recaudo_cuotas=0;
                              if($rows_recaudo){                                  

                                  $recaudo_cuotas=0;
                                  while($datosrec=pg_fetch_assoc($query127)){
                                    $recaudo_cuotas=$datosrec['valor']+$recaudo_cuotas;
                                  }


                              }

                         /// Servicios express
                          $sql1278="select distinct enc_procesadas.cliente, det_repor_aseso.valor, enc_procesadas.id_fasfield from enc_procesadas, det_repor_aseso where $parametro enc_procesadas.id_fasfield=det_repor_aseso.id_fasfield and enc_procesadas.tipo_encuesta=2 and det_repor_aseso.resul_visita='".'Servicio Express'."' and enc_procesadas.cod_estado=6 and enc_procesadas.fecha_filtro between '".$_POST['fecha_1']."' and '".$_POST['fecha_2']."' ";
                           $query1278=pg_query($conexion, $sql1278);
                         $rows_recaudo8=pg_num_rows($query1278); 
                               $recaudo_express=0;
                              if($rows_recaudo8){
                                  
                                  $recaudo_express=0;
                                  while($datosrec=pg_fetch_assoc($query1278)){
                                    $recaudo_express=$datosrec['valor']+$recaudo_express;
                                  }

                              }
                        
                          /// Gratuitos.

                      $sql124="select enc_procesadas.id_fasfield, det_repor_aseso.resul_visita from enc_procesadas, det_repor_aseso where $parametro enc_procesadas.id_fasfield=det_repor_aseso.id_fasfield and enc_procesadas.tipo_encuesta=2 and det_repor_aseso.resul_visita='".('Visitado y fue gratuito el diagnóstico')."' and enc_procesadas.fecha_filtro between '".$_POST['fecha_1']."' and '".$_POST['fecha_2']."' ";
                        $query124=pg_query($conexion, $sql124);
                     $gratuito=pg_num_rows($query124); 
                     
                     
                        /// Vistado y pagado.

                       $sql125="select enc_procesadas.id_fasfield, det_repor_aseso.resul_visita from enc_procesadas, det_repor_aseso where $parametro enc_procesadas.id_fasfield=det_repor_aseso.id_fasfield and enc_procesadas.tipo_encuesta=2 and det_repor_aseso.resul_visita='Visitado y pagado' and enc_procesadas.cod_estado=6 and enc_procesadas.fecha_filtro between '".$_POST['fecha_1']."' and '".$_POST['fecha_2']."' ";
                        $query125=pg_query($conexion, $sql125);
                      $vendidos=pg_num_rows($query125); 

                          /// Entrega de diagnóstico.
                      
                       $sql126="select enc_procesadas.id_fasfield, det_repor_aseso.resul_visita from enc_procesadas, det_repor_aseso where $parametro enc_procesadas.id_fasfield=det_repor_aseso.id_fasfield and enc_procesadas.tipo_encuesta=2 and det_repor_aseso.resul_visita='".('Entrega de diagnÃ³stico')."'  and enc_procesadas.fecha_filtro between '".$_POST['fecha_1']."' and '".$_POST['fecha_2']."' ";
                        $query126=pg_query($conexion, $sql126);
                      $entr_diag=pg_num_rows($query126); 
                        


                          $sql126="select enc_procesadas.id_fasfield, det_repor_aseso.resul_visita from enc_procesadas, det_repor_aseso where $parametro enc_procesadas.id_fasfield=det_repor_aseso.id_fasfield and enc_procesadas.tipo_encuesta=2 and det_repor_aseso.resul_visita='".('Entrega de diagnÃ³stico')."' and enc_procesadas.fecha_filtro between '".$_POST['fecha_1']."' and '".$_POST['fecha_2']."' ";
                        $query126=pg_query($conexion, $sql126);
                      $entr_diag=pg_num_rows($query126); 
                        // Sumamos los servicios express..



                        //Consulto creditos por aliado

                          $s1="select enc_procesadas.id_fasfield, det_repor_aseso.aliado from enc_procesadas, det_repor_aseso where $parametro enc_procesadas.id_fasfield=det_repor_aseso.id_fasfield and enc_procesadas.tipo_encuesta=2 and det_repor_aseso.aliado='FMSD' and enc_procesadas.fecha_filtro between '".$_POST['fecha_1']."' and '".$_POST['fecha_2']."'";
                          $q1=pg_query($conexion, $s1);
                          $r1=pg_num_rows($q1);

                          $s2="select enc_procesadas.id_fasfield, det_repor_aseso.aliado from enc_procesadas, det_repor_aseso where $parametro enc_procesadas.id_fasfield=det_repor_aseso.id_fasfield and enc_procesadas.tipo_encuesta=2 and det_repor_aseso.aliado='Creditos Orbe' and enc_procesadas.fecha_filtro between '".$_POST['fecha_1']."' and '".$_POST['fecha_2']."'";
                          $q2=pg_query($conexion, $s2);
                          $r2=pg_num_rows($q2);

                          $s3="select enc_procesadas.id_fasfield, det_repor_aseso.aliado from enc_procesadas, det_repor_aseso where $parametro enc_procesadas.id_fasfield=det_repor_aseso.id_fasfield and enc_procesadas.tipo_encuesta=2 and det_repor_aseso.aliado='Interactuar' and enc_procesadas.fecha_filtro between '".$_POST['fecha_1']."' and '".$_POST['fecha_2']."'";
                          $q3=pg_query($conexion, $s3);
                          $r3=pg_num_rows($q3);

                          $s4="select enc_procesadas.id_fasfield, det_repor_aseso.aliado from enc_procesadas, det_repor_aseso where $parametro enc_procesadas.id_fasfield=det_repor_aseso.id_fasfield and enc_procesadas.tipo_encuesta=2 and det_repor_aseso.aliado='Av villas' and enc_procesadas.fecha_filtro between '".$_POST['fecha_1']."' and '".$_POST['fecha_2']."'";
                          $q4=pg_query($conexion, $s4);
                          $r4=pg_num_rows($q4);

                          // Sumo el valor ingresado por los aliados y aprobados... 

                           $s5="select sum(det_repor_aseso.valor) as valor from enc_procesadas, det_repor_aseso where $parametro enc_procesadas.id_fasfield=det_repor_aseso.id_fasfield and enc_procesadas.tipo_encuesta=2 and enc_procesadas.cod_estado=6 and det_repor_aseso.tipo_pago='Credito'  and enc_procesadas.fecha_filtro between '".$_POST['fecha_1']."' and '".$_POST['fecha_2']."'";
                          $q5=pg_query($conexion, $s5);
                          $r5=pg_num_rows($q5);
                              if($r5){
                                $datos5=pg_fetch_assoc($q5);
                                $valor_credito=$datos5['valor'];
                              }

                          // Consulto los creditos aprobados por aliados..

                          $s6="select  distinct enc_procesadas.id_fasfield from enc_procesadas, det_repor_aseso where $parametro enc_procesadas.id_fasfield=det_repor_aseso.id_fasfield and enc_procesadas.tipo_encuesta=2 and enc_procesadas.cod_estado=6  and det_repor_aseso.tipo_pago='Credito' and enc_procesadas.fecha_filtro between '".$_POST['fecha_1']."' and '".$_POST['fecha_2']."'";
                          $q6=pg_query($conexion, $s6);
                          $aprob_credito=pg_num_rows($q6);


                          $s7="select distinct enc_procesadas.id_fasfield, det_repor_aseso.aliado from enc_procesadas, det_repor_aseso where $parametro enc_procesadas.id_fasfield=det_repor_aseso.id_fasfield and enc_procesadas.tipo_encuesta=2 and  det_repor_aseso.tipo_pago='Credito' and (enc_procesadas.cod_estado=7 or enc_procesadas.cod_estado=1) and enc_procesadas.fecha_filtro between '".$_POST['fecha_1']."' and '".$_POST['fecha_2']."'";
                          $q7=pg_query($conexion, $s7);
                          $repro_credito=pg_num_rows($q7);



                            // SUmar todos los valores 

                         $sql91="select distinct enc_procesadas.cliente, det_repor_aseso.valor, enc_procesadas.id_fasfield from enc_procesadas, det_repor_aseso where $parametro enc_procesadas.id_fasfield=det_repor_aseso.id_fasfield and enc_procesadas.tipo_encuesta=2 and det_repor_aseso.tom_serv='Si' and enc_procesadas.cod_estado=6 and enc_procesadas.fecha_filtro between '".$_POST['fecha_1']."' and '".$_POST['fecha_2']."' and det_repor_aseso.aliado='' ";
                        $query91=pg_query($conexion, $sql91);
                        $rows91=pg_num_rows($query91);
                              $valor_serv=0;
                              if($rows91){

                                $valor_serv=0;
                                while($datos91=pg_fetch_assoc($query91)){

                                      $valor_serv=$valor_serv+$datos91['valor'];
                                }
                              }

                      //  @$valor_serv=pg_fetch_assoc($query91); 

                            //$valor_serv=$valor_serv['valor'];
                        
                        
                        // Diagnósticos gratuitos....
                        
                        
                        // if($_SESSION['cod_grupo']==1)
                           include('repor_dash_direc2.php');    
                          //  else
                           // echo "Estamos trabajandoa aquí, por favor intenta mas tarde.";                   

                  
                  

                  

           }
       if(isset($_POST['add_revi_call'])){ // Agregar revisión de call center.


          // Verificamos quién está realizando la revisión.....
          if($_SESSION['cod_grupo']==6 or $_SESSION['cod_grupo']==1) // Coordiandor de operaciones.  o Super administrador
            $tipo_revision=1; // Control de calidad
          else if($_SESSION['cod_grupo']==3 or $_SESSION['cod_grupo']==1) // Analítico....  o Super administrador
            $tipo_revision=2; 
          else if($_SESSION['cod_grupo']==8 or $_SESSION['cod_grupo']==1) // Asesor...  o Super administrador
            $tipo_revision=3; // Asesor
          
         

       $insert="insert into seguimientos (tipo_seguimiento, id_fasfield, cod_usuario, observacion, cod_estado,  fecha_agenda, archivo) values('".$_POST['tipo_seguimiento']."',  '".$_POST['id_fasfield']."', '".$_SESSION['cod_usuario']."',  '".($_POST['observacion'])."', '".$_POST['cod_estado']."', '".$_POST['fecha_agenda']."', '".$_SESSION['nom_archivo']."' ) ";
        $query=pg_query($conexion, $insert);
            
            if($_POST['cod_estado']==22){
                $update="update det_repor_aseso set valor='".$_POST['observacion']."'  where id_fasfield='".$_POST['id_fasfield']."' ";
                $query6=pg_query($conexion, $update);
            }
            
        

              if($query){

                        if($_POST['tipo_seguimiento']<8)
              
                         $sql2="select seguimientos.fecha_registro, seguimientos.archivo, seguimientos.observacion, estado.descripcion as estado, estado.cod_estado, usuarios.nombre as usuario from seguimientos, usuarios, estado where seguimientos.cod_usuario=usuarios.cod_usuario and seguimientos.cod_estado=estado.cod_estado and seguimientos.id_fasfield='".$_POST['id_fasfield']."' and seguimientos.cod_usuario!=0 and seguimientos.tipo_seguimiento='".$_POST['tipo_seguimiento']."' order by seguimientos.id_segui_llam desc  ";
                       else{
                            if($_POST['tipo_seguimiento']==8)
                                $sql2="select seguimientos.fecha_registro, seguimientos.archivo, seguimientos.observacion, afectaciones.descripcion as estado, usuarios.nombre as usuario from seguimientos, usuarios, afectaciones where seguimientos.cod_usuario=usuarios.cod_usuario and seguimientos.cod_estado=afectaciones.tipo_afect and seguimientos.id_fasfield='".$_POST['id_fasfield']."' and seguimientos.cod_usuario!=0 and seguimientos.tipo_seguimiento='".$_POST['tipo_seguimiento']."' order by seguimientos.id_segui_llam desc  ";

                             else if($_POST['tipo_seguimiento']==14 || $_POST['tipo_seguimiento']==15){

                                   if($_POST['tipo_seguimiento']==14){

                             /// echo "Entró aquí";

                                  $_POST['pr_servi_n']="";
                                                     // Verificamos que el servicio aún no esté recomendado..
                                       $sql2="select cod_servicio from serv_recom_diag where cod_servicio='".$_POST['cod_estado']."' ";
                                      $query2=pg_query($conexion, $sql2); 
                                      $rows=pg_num_rows($query2);

                                          if($rows)
                                            echo "3"; // Servicio ya se encuentra recomendado en el diagnóstico..
                                          
                                          else{ // AHora insertarmos el servicio recomendado..

                                             // Buscamos el nombre del producto y plazo sugerido del servico (defecto).

                                            $sql3="select * from produc_servi where cod_servicio='".$_POST['cod_estado']."' ";
                                            $query3=pg_query($conexion, $sql3);
                                            $rows3=pg_num_rows($query3);
                                            
                                                    if($rows3){
                                                      $dato3=pg_fetch_assoc($query3);
                                                      $cod_product_serv=$dato3['cod_produc_serv'];
                                                    }
                                                    else
                                                      $cod_product_serv=0;                                              
                                        $insert="insert into serv_recom_diag (id_elab_diag, cod_servicio, pr_serv_n, cod_produc_serv) values('".$_POST['id_fasfield']."', '".$_POST['cod_estado']."', '".$_POST['pr_servi_n']."', '".$cod_product_serv."' ) ";
                                             
                                             $query=pg_query($conexion, $insert);
                                               /* if($query)
                                                  echo "1";
                                                else
                                                  echo "2"; // Problema técnico...*/
                                          }
                              }


                                  $sql2="select seguimientos.fecha_registro, seguimientos.archivo, seguimientos.observacion, servicios.nom_servicio as estado, usuarios.nombre as usuario from seguimientos, usuarios, servicios where seguimientos.cod_usuario=usuarios.cod_usuario and seguimientos.cod_estado=servicios.cod_servicio and seguimientos.id_fasfield='".$_POST['id_fasfield']."' and seguimientos.cod_usuario!=0 and seguimientos.tipo_seguimiento='".$_POST['tipo_seguimiento']."' order by seguimientos.id_segui_llam desc  ";  
                                }

                       }

                          $query2=pg_query($conexion, $sql2);
                          $rows2=pg_num_rows($query2);
                          
                          


                              if($_POST['tipo_seguimiento']==5){
                      // actualizamos el valor aprobado y su estado
                            $update1="update  det_repor_aseso set valor='".$_POST['observacion']."'  where id_fasfield='".$_POST['id_fasfield']."' ";
                            $query1=pg_query($conexion, $update1);

                            $update1="update  enc_procesadas set cod_estado='".$_POST['cod_estado']."'  where id_fasfield='".$_POST['id_fasfield']."' ";
                            $query1=pg_query($conexion, $update1);
                          }
                          
                          


                      if($_POST['tipo_seguimiento']==2){
                      // actualizamos el valor aprobado y su estado
                          
                            $update1="update  enc_procesadas set cod_estado='".$_POST['cod_estado']."'  where id_fasfield='".$_POST['id_fasfield']."' ";
                            $query1=pg_query($conexion, $update1);

                                  // Verificamos aprobación del cliente y lo agregamos

                             /*  if($_POST['cod_estado']==6){ // Si aprobado, lo agrgamos al grupo de clientes..

                                            //Consultamos los datos del cliente
                                          $sql3="select enc_procesadas.id_cliente, enc_procesadas.Asesor, enc_procesadas.ciudad, enc_procesadas.direccion, enc_procesadas.telefono, enc_procesadas.Barrio, det_repor_aseso.resul_visita, det_repor_aseso.tom_serv, det_repor_aseso.valor, det_repor_aseso.tipo_pago  from det_repor_aseso, enc_procesadas where det_repor_aseso.id_fasfield=enc_procesadas.id_fasfield and enc_procesadas.id_fasfield='".$_POST['id_fasfield']."' ";
                                          $query3=pg_query($conexion, $sql3);
                                          $datos=pg_fetch_assoc($query3);

                                              // Verificamos que no esté registrado
                                              $sql4="select cod_cliente from cliente where cod_cliente='".$datos['id_cliente']."'";
                                              $query4=pg_query($coenxion, $sql4); 
                                                $rows4=pg_num_rows($query4);

                                                  if($rows4==0){ // SI no está registrado entonces..

                                                            $insert="insert into cliente (id_fasfield, cod_cliente, nombre, tipo_cliente, ciudad, barrio, direccion_predio, telefono_1) values('".$_POST['id_fasfield']."', '".$datos['id_cliente']."', '".$datos['cliente']."', 1, '".$datos['ciudad']."', '".$datos['Barrio']."', '".$datos['direccion']."', '".$datos['telefono']."') ";
                                                             $query4=pg_query($conexion, $insert);

                                                          // Ahora creamos la carpeta del cliente..

                                                               // insertamos cliente   
                                                        $carpeta_cliente=$datos['cliente'];
                                                        $md5_carp=$clave:md5($carpeta_cliente);                                                                                

                                                          $sql2="insert into documentacion (cod_cliente,  nombres, apellidos, tipo_docu, ciudad, cod_bodega, cod_estante, ubicacion, usr_codif) values('".$_POST['id_cliente']."', '".$_POST['cliente']."', '', 2, '', 1, 1, 1, '".$md5_carp."') ";                                                       
                                                                     
                                                          $query2=pg_query($conexion, $sql2);

                                                               if($query2){
                                                                  mkdir('../files/clientes/'.$md5_carp); // Creamos carpeta inicial...
                                                                        // Creamos subcarpetas
                                                                       mkdir('../files/clientes/'.$md5_carp."/Documentos de propiedad");
                                                                       mkdir('../files/clientes/'.$md5_carp."/Facturas y contratos");
                                                                      mkdir('../files/clientes/'.$md5_carp."/Otros documentos");
                                                                        mkdir('../files/clientes/'.$md5_carp."/Analisis de caso");

                                                                        echo "1";// Carpeta creada 
                                                                }
                                                    } // Fin si no encontró el cliente...
                                                 
                                                 // Veriquemos el tipo de encuesta....

                                              if($datos['resul_visita']=='Visitado y pagado'){   // Es un diagnóstico entonces.. registramos el diagnóstico nuevo del cliente..                                                
                                                $insert2="insert into diagno_client (id_fasfield, cod_cliente, ciudad, direccion, cod_estado) values('".$_POST['id_fasfield']."', '".$datos['id_cliente']."', '".$datos['ciudad']."', '".$datos['direccion']."', 23) ";
                                                $query2=pg_query($insert2);

                                              } else  if($datos['tom_serv']=='Si'){ // Es un servicio nuevo 


                                                    $serv_tomados=$datos['serv_tomados'];
                                                    $separar=explode(',',$serv_tomados); 

                                                          for($i=0;$i<count($separar);$i++){

                                                                $cod_servicio=$separar[$i];

                                                                if(is_integer($cod_servicio)){ // Si es un código de servicio entonces...

                                                                  //Verificamos que el servicio no se haya registrado al cliente..
                                                                $sql31="select serv_cliente where cod_servicio='".$cod_servicio."' and cod_cliente='".$datos['id_cliente']."' ";
                                                                $query31=pg_query($conexion, $sql31);
                                                                $rows31=pg_num_rows($query31);

                                                                          if($rows31==0){ // EL servicio no se ha registrado enttonces... agréguelo..
                                                                              
                                                                              if($datos['tipo_pago']=='Contado'){
                                                                               $insert2="insert into serv_cliente (asesor, cod_servicio, cod_estado, cod_cliente, valor, fecha_registro, cod_usuario, cod_acuer_pago, id_list_despleg) values('".$datos['asesor']."', '".$cod_servicio."', 23, '".$datos['cod_cliente']."', '".$datos['valor']."', '".$fecha_registro."', 92, 1, 1)  ";
                                                                                $queryinser=pg_query($conexion, $insert2); // INsertamos el cliente..
                                                                              }

                                                                          }      

                                                                } // FIn Si es un codigo de servicio...
                                                          }

                                              }  // Fin si es un servicio nuevo..... tomado por el cliente.

                                  }*/
                          }
                      include('history_revi.php');                      
                    
                    $_SESSION['nom_archivo']="";
              }
              else
                echo "2"; // Problema interno (técnico).            

      } 
      
         if(isset($_POST['revi_revi_call'])){ // Agregar revisión de call center.  y otras revisiones..
                
                      if($_POST['tipo_seguimiento']<8) 
                       $sql2="select seguimientos.fecha_registro, seguimientos.archivo, seguimientos.observacion, estado.descripcion as estado, estado.cod_estado, usuarios.nombre as usuario from seguimientos, usuarios, estado where seguimientos.cod_usuario=usuarios.cod_usuario and seguimientos.cod_estado=estado.cod_estado and seguimientos.id_fasfield='".$_POST['id_fasfield']."' and seguimientos.cod_usuario!=0 and seguimientos.tipo_seguimiento='".$_POST['tipo_seguimiento']."' order by seguimientos.id_segui_llam desc  ";
                     else{
                           if($_POST['tipo_seguimiento']==8)  /// Sin son afectaciones..
                           $sql2="select seguimientos.fecha_registro, seguimientos.archivo, seguimientos.observacion, afectaciones.descripcion as estado, usuarios.nombre as usuario from seguimientos, usuarios, afectaciones where seguimientos.cod_usuario=usuarios.cod_usuario and seguimientos.cod_estado=afectaciones.tipo_afect and seguimientos.id_fasfield='".$_POST['id_fasfield']."' and seguimientos.cod_usuario!=0 and seguimientos.tipo_seguimiento='".$_POST['tipo_seguimiento']."' order by seguimientos.id_segui_llam desc  ";
                           else if($_POST['tipo_seguimiento']==14 or $_POST['tipo_seguimiento']==15)
                            $sql2="select seguimientos.fecha_registro, seguimientos.archivo, seguimientos.observacion, servicios.nom_servicio as estado, usuarios.nombre as usuario from seguimientos, usuarios, servicios where seguimientos.cod_usuario=usuarios.cod_usuario and seguimientos.cod_estado=servicios.cod_servicio and seguimientos.id_fasfield='".$_POST['id_fasfield']."' and seguimientos.cod_usuario!=0 and seguimientos.tipo_seguimiento='".$_POST['tipo_seguimiento']."' order by seguimientos.id_segui_llam desc  ";
                     }
                        

                        $query2=pg_query($conexion, $sql2);
                          $rows2=pg_num_rows($query2);
                      include('history_revi.php');
         
         }

         // Listamos los servicios
          if(isset($_POST['list_servicios'])){

                                  // Listamos los nombres de los servicios
                            $sql2="select serv_recom_diag.id_serv_recom, servicios.nom_servicio, servicios.cod_servicio from serv_recom_diag, servicios where serv_recom_diag.cod_servicio=servicios.cod_servicio and id_elab_diag='".$_POST['id_elab_diag']."' ";

                             $query2=pg_query($conexion, $sql2);
                             $rows2=pg_num_rows($query2);
                                if($rows2)
                               include('list_servicios.php');
                             else
                              echo "Aun no se encuentran servicios a cotizar";

          }


          if(isset($_POST['listar_actividades_diag'])){


                if($_POST['tipo']==1){
                  $etapa=1;

                               $sql3="select id_activi_diag as cod_activi_etapa, descripcion  from activi_etapa_diag where cod_etapa='".$etapa."' and cod_equipo='".$_POST['cod_equipo']."'  and id_activi_diag between 9 and 19 order by id_activi_diag ";
                                   $query3=pg_query($conexion, $sql3); 
                              
                }

                elseif($_POST['tipo']==2){
                  $etapa=1;

                               $sql3="select id_activi_diag as cod_activi_etapa, descripcion  from activi_etapa_diag where cod_etapa='".$etapa."' and cod_equipo='".$_POST['cod_equipo']."'  and id_activi_diag between 24 and 62 order by id_activi_diag ";
                                 
                                              
                                 

                }
                elseif($_POST['tipo']==3){
                  $etapa=1;

                               $sql3="select id_activi_diag as cod_activi_etapa, descripcion  from activi_etapa_diag where cod_etapa='".$etapa."' and cod_equipo='".$_POST['cod_equipo']."'  and id_activi_diag between 78 and 85 order by id_activi_diag ";
                                   $query3=pg_query($conexion, $sql3); 
                                   

                }

               elseif($_POST['tipo']==4){
                  $etapa=1;

                               $sql3="select id_activi_diag as cod_activi_etapa, descripcion  from activi_etapa_diag where cod_etapa='".$etapa."' and cod_equipo='".$_POST['cod_equipo']."'  and id_activi_diag between 65 and 77 order by id_activi_diag ";
                                   $query3=pg_query($conexion, $sql3); 

                }

                elseif($_POST['tipo']==5 ){ // Listado de variables de  revisión de bases de datos
                  $etapa=1;

                               $sql3="select id_activi_diag as cod_activi_etapa, descripcion  from activi_etapa_diag where cod_etapa='".$etapa."' and cod_equipo='".$_POST['cod_equipo']."'  and id_activi_diag between 86 and 91 order by id_activi_diag ";
                                   $query3=pg_query($conexion, $sql3); 

                }

                elseif($_POST['tipo']==6 ){ // Listado de variables de  revisión de mapas colaborativos
                  $etapa=1;

                               $sql3="select id_activi_diag as cod_activi_etapa, descripcion  from activi_etapa_diag where cod_etapa='".$etapa."' and cod_equipo='".$_POST['cod_equipo']."'  and id_activi_diag between 92 and 97 order by id_activi_diag ";
                                   $query3=pg_query($conexion, $sql3); 
                                
                }
                              
                  // Listar actividades del diagnósticos
                $query3=pg_query($conexion, $sql3); 
                  $rows5=pg_num_rows($query3);
                        if($rows5){
                          include('listar_actividades_diag.php');
                        }


          }
         
         if(isset($_POST['revi_revi_call2'])){ // Agregar revisión de call center.  y otras revisiones..
                
                            
                         $sql2="select seguimientos.fecha_registro, seguimientos.archivo, seguimientos.observacion, estado.descripcion as estado, estado.cod_estado, usuarios.nombre as usuario from seguimientos, usuarios, estado where seguimientos.cod_usuario=usuarios.cod_usuario and seguimientos.cod_estado=estado.cod_estado and seguimientos.id_fasfield='".$_POST['id_fasfield']."' and seguimientos.cod_usuario!=0 and seguimientos.tipo_seguimiento='".$_POST['tipo_seguimiento']."' order by seguimientos.id_segui_llam desc limit 1  ";
                        $query2=pg_query($conexion, $sql2);
                          $rows2=pg_num_rows($query2);
                      include('history_revi.php');
         
         }

        if(isset($_POST['gene_agend_asesor'])){
          include('list_agenda_ase.php');
        }

        if(isset($_POST['incon_pago'])){
          include('list_incosis.php');
        }


        if(isset($_POST['g_user'])){ // Gestión de usuarios y permisos..

              if(isset($_POST['create'])){ // Creando un usuario..


                if(isset($_POST['bus_rol'])){ // Buscamos el tipo de usuario..


                      $sql="select * from tipo_usuario where cod_grupo='".$_POST['id_grupo']."' ";
                      $query=pg_query($conexion, $sql);
                      $rows=pg_num_rows($query);
                          if($rows){


                                while($row_consulta2 = pg_fetch_assoc($query))           
                               echo   $resp="<option value='".$row_consulta2[tipo_usuario]."'>".utf8_encode($row_consulta2[descripcion])."</option>";   

                          }else
                          echo   $resp="<option value=0>Ningun rol (tipo de usuario)</option>";


                }else{ // Creamos el usuario

                    // Verificamos que esté creado.

                                              $sql="select * from usuarios where email='".trim($_POST['email'])."' ";
                      $query=pg_query($conexion, $sql);
                      $rows2=pg_num_rows($query);

                          if($rows2==0){ // Si no está creando entonces registre..
                          
                          //echo "algo";
                            
$insert5="insert into usuarios (email, nombre, apellidos, tipo_usuario, cod_estado) values('".$_POST['email']."', '".$_POST['nombre']."', '".$_POST['apellidos']."', '".$_POST['tipo_usuario']."', 1) ";
                          $query2=pg_query($conexion, $insert5);

                                                          if($query2){
                                                              include('list_usuarios.php');
                                echo "1";
                                                          }
                                  else
                                echo "3"; // Problema técnico..*/
                          }
                          else
                            echo "2"; // El usuario ya existe.

                }

              }
              
              if(isset($_POST['listar_usuarios']))
               include('list_usuarios.php');

            if(isset($_POST['acuali_perfil'])){ // Actualización de perfil

                  $sql="select cod_usuario from usuarios where cod_usuario='".$_SESSION['cod_usuario']."' limit 1 ";
                  $query=pg_query($conexion, $sql);
                  $rows=pg_num_rows($query);

                        if($rows==1){  // Encontró usuario..

                              $insert="update usuarios set telefono_1='".$_POST['telefono_1']."', id_usuario='".$_POST['id_usuario']."', profesion='".$_POST['profesion']."', correo_alt='".$_POST['correo_alt']."', direccion_casa='".$_POST['direccion_casa']."', telefono_casa='".$_POST['telefono_casa']."', nombre='".$_POST['nombre']."', apellidos='".$_POST['apellidos']."', actuali_perfil=1 where cod_usuario='".$_SESSION['cod_usuario']."' ";
                              $query_insert=pg_query($conexion, $insert);
                                  if($query_insert)
                                    echo "1";
                                  else 
                                    echo "2";
                        }

            }
              
              /*if($_POST['']){  // Para borrar usuariuo (Deshabilita mejor)..



              }*/

              /*if($_POST['g_permisos_user']){ /// Gestionamos los permisos... según el menu..


                  if($_POST['bus_submenu']){ // Buscamos el submenu

                        $sql="select * from submenu where cod_menu='".$_POST['cod_menu']."' ";
                        $query=pg_query($conexion, $sql);
                        $rows=pg_num_fields($query);

                              if($rows){

                              }

                  }else{ // Creamos el permiso al menú según el usuario...

                        // Verifcamos que no tenga acceso aún..
                      $sql="select * from permisos_menu where cod_usuario='".$_POST['cod_usuario']."' and cod_menu='".$_POST['cod_menu']."' and cod_submenu='".$_POST['cod_submenu']."' ";
                      $query=pg_query($conexion, $sql);
                      $rows=pg_num_rows($query);

                          if($rows==0){
                            $insert="insert into permisos_menu (cod_menu, cod_submenu, cod_permiso, cod_usuario) values('".$_POST['cod_menu']."', '".$_POST['cod_submenu']."', '".$_POST['cod_permiso']."', '".$_POST['cod_usuario']."') ";
                            $query=mysqñ_query($insert);

                                if($query){

                                  echo "1";


                                }else
                                 echo "2"; // Problema técncico...


                          }else

                  }


              } */



        }

         // Registrar información de servicios ("Segumimientos ")

        if(isset($_POST['g_serv'])){


                // Verificamos el cliente
                  $sql="select * from  serv_cliente where id_serv_cliente='".$_POST['id_serv_cliente']."' ";
                  $query=pg_query($conexion, $sql);
                  $rows=pg_num_rows($query);

                        if($rows){
                            
                              // Actualizamos los datos básicos.

                           $sql2="update serv_cliente set n_folio_inm='".$_POST['n_folio_inm']."', refe_catas='".$_POST['refe_catas']."',  firm_contrato='".$_POST['firm_contrato']."', fecha_firm_contr='".$_POST['fecha_firm_contr']."', tiempo_compros='".$_POST['tiempo_compros']."', fecha_compro_contr='".$_POST['fecha_compro_contr']."', poder_aut_nece='".$_POST['poder_aut_nec']."', poder_aut='".$_POST['poder_aut']."', fecha_ini_tramite='".$_POST['fecha_ini_tramite']."', enti_tramite='".$_POST['enti_tramite']."', radicado='".$_POST['radicado']."',id_list_despleg='".$_POST['cod_estado_segui']."', resu_serv='".($_POST['resu_serv'])."', coment_serv='".($_POST['coment_serv'])."', cod_estado_venc='".$_POST['cod_estado_venc']."' where id_serv_cliente='".$_POST['id_serv_cliente']."' ";
                           $update=pg_query($conexion, $sql2);

                          $sql3="update cliente set barrio='".$_POST['barrio']."', direccion_predio='".$_POST['direccion']."' where cod_cliente='".$_POST['cod_cliente']."' ";
                          $update2=pg_query($conexion, $sql3);
                         

                              if($update && $update2)
                                echo "1";
                              else
                                echo "2";
                    
                        }else
                        echo "Identificación del cliente no se pudo obtener, puede que su sesión haya expirado por tiempo sin actividad";

        }


    if(isset($_POST['add_revi_serv'])){ // Agregar actividades del servicio.

          // Verificamos quién está realizando la revisión.....
          if($_SESSION['cod_grupo']==6 or $_SESSION['cod_grupo']==1) // Coordiandor de operaciones.  o Super administrador
            $tipo_revision=1; // Control de calidad
          else if($_SESSION['cod_grupo']==3 or $_SESSION['cod_grupo']==1) // Analítico....  o Super administrador
            $tipo_revision=2; 
          else if($_SESSION['cod_grupo']==8 or $_SESSION['cod_grupo']==1) // Asesor...  o Super administrador
            $tipo_revision=3; // Asesor

               @$s1="select * from activ_etapa_devol where id_activi_devol='".$_POST['cod_activi_etapa']."' ";
              @$q=pg_query($conexion, $s1);
              @$d=pg_fetch_assoc($q);

              // Consultamos el cod del serviicio

            @$s2="select * from serv_cliente where id_serv_cliente='".$_POST['id_serv_cliente']."' ";
              @$q2=pg_query($conexion, $s2);
              @$d2=pg_fetch_assoc($q2);

                  // Verificamos que la etapa no esté  registrada
                  $f="select * from activi_etapa where  cod_activi_etapa='".$_POST['cod_activi_etapa']."' " ;
                  $g=pg_query($conexion, $f);
                  $r=pg_num_rows($g);
                      if($r==0){
                            if($d['cod_etapa']==''){
                              $d['cod_etapa']=12;
                              $d['descripcion']="Remitido a devolucion";

                            }
          // INsetamos nueva actividad (devolución al servicio  especitivi)
             $insert2="insert into activi_etapa (cod_activi_etapa, cod_etapa, cod_servicio, check_1, descripcion) values('".$_POST['cod_activi_etapa']."',   '".$d['cod_etapa']."', '".$d2['cod_servicio']."', 1, '".$d['descripcion']."' )";
            $query2=pg_query($conexion, $insert2);

                      }

             $insert="insert into activ_serv (cod_activi_etapa, id_serv_cliente, observacion, cod_usu_respon, fecha_actividad, archivo) values('".$_POST['cod_activi_etapa']."', '".$_POST['id_serv_cliente']."', '".$_POST['observacion']."', '".$_SESSION['cod_usuario']."', '".$_POST['fecha_actividad']."', '".$_SESSION['nom_archivo']."') ";
            $query=pg_query($conexion, $insert);

                  if($_POST['cod_activi_etapa']==732){ // SI está remitido a devoluciones entonces..

                       // Verificamos que no esté en devolución..

                        $sql6="select * from devolucion where id_serv_cliente='".$_POST['id_serv_cliente']."' ";
                        $query6=pg_query($conexion, $sql6);
                          $rows6=pg_num_rows($query6);

                              if($rows6==0){                                
                                // REgistrelo en devoluciones...
                               $insert5="insert into devolucion (id_serv_cliente, v_ejecutado, p_identificado) values('".$_POST['id_serv_cliente']."', 0, '".$_POST['observacion']."') ";
                               $query_insert=pg_query($conexion, $insert5);

                              }

                  } 
                    

              if($query){
              
                  
                    $sql2="select usuarios.nombre as usuario, activ_serv.observacion, activ_serv.fecha_actividad, activ_serv.fecha_registro, activ_serv.archivo, etapa_activ.descripcion as etapa, activi_etapa.descripcion as actividad from usuarios, etapa_activ, activ_serv, activi_etapa where usuarios.cod_usuario=activ_serv.cod_usu_respon and etapa_activ.cod_etapa=activi_etapa.cod_etapa and activ_serv.cod_activi_etapa=activi_etapa.cod_activi_etapa and activ_serv.id_serv_cliente='".$_POST['id_serv_cliente']."' order by activ_serv.id_activi_serv desc ";
                          $query2=pg_query($conexion, $sql2);
                          $rows2=pg_num_rows($query2);
                         include('history_revi2.php');
                  
              }
              else
                echo "2"; // Problema interno (técnico).            

      } 

     if(isset($_POST['add_revi_diag'])){ // Agregar actividades del servicio.

          // Verificamos quién está realizando la revisión.....
          if($_SESSION['cod_grupo']==6 or $_SESSION['cod_grupo']==1) // Coordiandor de operaciones.  o Super administrador
            $tipo_revision=1; // Control de calidad
          else if($_SESSION['cod_grupo']==3 or $_SESSION['cod_grupo']==1) // Analítico....  o Super administrador
            $tipo_revision=2; 
          else if($_SESSION['cod_grupo']==8 or $_SESSION['cod_grupo']==1) // Asesor...  o Super administrador
            $tipo_revision=3; // Asesor

            $insert="insert into activ_diag (cod_activi_etapa, id_elab_diag, observacion, cod_usu_respon, fecha_actividad, fecha_registro) values('".$_POST['cod_activi_etapa']."', '".$_POST['id_elab_diag']."', '".$_POST['observacion']."', '".$_SESSION['cod_usuario']."', '".$_POST['fecha_actividad']."', '".$fecha_registro."') ";
            $query=pg_query($conexion, $insert);
                    

              if($query){

                 if($_POST['tipo']==1){
                  $parametro='9 and 19';
                  
                }

                elseif($_POST['tipo']==2){
                   $parametro='24 and 62';
                 
                }
                elseif($_POST['tipo']==3){
                   $parametro='78 and 85';


                }

               elseif($_POST['tipo']==4){
                 $parametro='65 and 77';                
                }

                elseif($_POST['tipo']==5 ){ // Listado de variables de  revisión de bases de datos
                  $parametro='86 and 91'; 
                
                }

                elseif($_POST['tipo']==6 ){ // Listado de variables de  revisión de mapas colaborativos
                 $parametro='92 and 97'; 
                  }
              
                  
                    $sql2="select usuarios.nombre as usuario, activ_diag.observacion, activ_diag.fecha_actividad, activ_diag.fecha_registro, etapa_activ.descripcion as etapa, activi_etapa_diag.descripcion as actividad from usuarios, etapa_activ, activ_diag, activi_etapa_diag where usuarios.cod_usuario=activ_diag.cod_usu_respon and etapa_activ.cod_etapa=activi_etapa_diag.cod_etapa and activ_diag.cod_activi_etapa=activi_etapa_diag.id_activi_diag and activ_diag.id_elab_diag='".$_POST['id_elab_diag']."' and activi_etapa_diag.id_activi_diag between $parametro order by activ_diag.id_activi_diag desc ";
                          $query2=pg_query($conexion, $sql2);
                          $rows2=pg_num_rows($query2);
                         include('history_revi2.php');
                  
              }
              else
                echo "2"; // Problema interno (técnico).            

      } 

      // Buscamos listas desplegables de los campos de los diagnósticos.

      if(isset($_POST['b_lista_despleg_diag'])){


              $sql="select  * from deta_list_despleg where tipo_lista='".$_POST['cod_activi_etapa']."' ";
                      $query=pg_query($conexion, $sql);
                      $rows=pg_num_rows($query);
                          if($rows){

                             
                                while($row_consulta2 = pg_fetch_assoc($query))           
                            echo   $resp="<option value='".$row_consulta2[descripcion]."'>".($row_consulta2[descripcion])."</option>"; 

                          }else
                          echo  $resp="<option value=2>Ninguno</option>";
      }



       if(isset($_POST['revi_serv'])){ //  Agregar actividades del servicio.
                            
                      $sql2="select usuarios.nombre as usuario, activ_serv.observacion, activ_serv.fecha_actividad, activ_serv.fecha_registro,  activ_serv.archivo, etapa_activ.descripcion as etapa, activi_etapa.descripcion as actividad from usuarios, etapa_activ, activ_serv, activi_etapa where usuarios.cod_usuario=activ_serv.cod_usu_respon and etapa_activ.cod_etapa=activi_etapa.cod_etapa and activ_serv.cod_activi_etapa=activi_etapa.cod_activi_etapa and activ_serv.id_serv_cliente='".$_POST['id_serv_cliente']."' order by activ_serv.id_activi_serv desc ";
                        $query2=pg_query($conexion, $sql2);
                          $rows2=pg_num_rows($query2);
                      include('history_revi2.php');
         
         }
         if(isset($_POST['revi_serv_diag'])){ //  Agregar actividades del diagnóstico
                      
                      if($_POST['tipo']==1){
                  $parametro='9 and 19';
                  
                }

                elseif($_POST['tipo']==2){
                   $parametro='24 and 62';
                 
                }
                elseif($_POST['tipo']==3){
                   $parametro='78 and 85';


                }

               elseif($_POST['tipo']==4){
                 $parametro='65 and 77';                
                }

                elseif($_POST['tipo']==5 ){ // Listado de variables de  revisión de bases de datos
                  $parametro='86 and 91'; 
                
                }

                elseif($_POST['tipo']==6 ){ // Listado de variables de  revisión de mapas colaborativos
                 $parametro='92 and 97'; 
                  }       
                     
                  $sql2="select usuarios.nombre as usuario, activ_diag.observacion, activ_diag.fecha_actividad, activ_diag.fecha_registro, etapa_activ.descripcion as etapa, activi_etapa_diag.descripcion as actividad from usuarios, etapa_activ, activ_diag, activi_etapa_diag where usuarios.cod_usuario=activ_diag.cod_usu_respon and etapa_activ.cod_etapa=activi_etapa_diag.cod_etapa and activ_diag.cod_activi_etapa=activi_etapa_diag.id_activi_diag and activ_diag.id_elab_diag='".$_POST['id_elab_diag']."' and activi_etapa_diag.id_activi_diag between $parametro order by activ_diag.id_activi_diag desc ";
                     $query2=pg_query($conexion, $sql2);
                          $rows2=pg_num_rows($query2);
                      include('history_revi2.php');
         
         }

          if(isset($_POST['revi_serv2_diag'])){//  Agregar actividades del diagnóstico
                            
                     $sql2="select usuarios.nombre as usuario, activ_diag.observacion, activ_diag.fecha_actividad, activ_diag.fecha_registro, etapa_activ.descripcion as etapa, activi_etapa.descripcion as actividad from usuarios, etapa_activ, activ_diag, activi_etapa where usuarios.cod_usuario=activ_diag.cod_usu_respon and etapa_activ.cod_etapa=activi_etapa.cod_etapa and activ_diag.cod_activi_etapa=activi_etapa.cod_activi_etapa and activ_diag.id_elab_diag='".$_POST['id_elab_diag']."' order by activ_diag.id_activi_diag desc ";
                        $query2=pg_query($conexion, $sql2);
                          $rows2=pg_num_rows($query2);
                      include('history_revi2.php');
         
         }
         
         if(isset($_POST['revi_serv2'])){ //  Agregar actividades del servicio.
                
                            
                      $sql2="select usuarios.nombre as usuario, activ_serv.observacion, activ_serv.fecha_actividad, activ_serv.fecha_registro, etapa_activ.descripcion as etapa, activi_etapa.descripcion as actividad from usuarios, etapa_activ, activ_serv, activi_etapa where usuarios.cod_usuario=activ_serv.cod_usu_respon and etapa_activ.cod_etapa=activi_etapa.cod_etapa and activ_serv.cod_activi_etapa=activi_etapa.cod_activi_etapa and activ_serv.id_serv_cliente='".$_POST['id_serv_cliente']."' order by activ_serv.id_activi_serv desc limit 1 ";
                        $query2=pg_query($conexion, $sql2);
                          $rows2=pg_num_rows($query2);
                      include('history_revi2.php');
         
         }
         
          if(isset($_POST['mis_servicios'])){ // Listamos lo servicios.
          
                 $sql="select * from usuarios where email='".$_POST['email']."' ";
                    $query=pg_query($conexion, $sql);
                    $rows=pg_num_rows($query);
                            if($rows){
                                
                                $datos=pg_fetch_assoc($query);
                                        include('servicios.php');    
                                
                            }
          
          }

          if(isset($_POST['asig_servicio'])){



                    $sql="insert into asigna_serv (id_serv_cliente, cod_usu_coor, cod_usu_respon, fecha_filtro, fecha_radic_serv) values('".$_POST['id_serv_cliente']."', '".$_SESSION['cod_usuario']."', '".$_POST['cod_usu_resp']."', '".$fecha_filtro."', '') ";
                    $query=pg_query($conexion, $sql);

                          if($query){
                                    $update="update serv_cliente set cod_usuario='".$_POST['cod_usu_resp']."' where id_serv_cliente='".$_POST['id_serv_cliente']."' ";
                                    $query2=pg_query($conexion, $update);
                                        if($query2)
                                          echo "1"; // Registro exitoso...
                                        else
                                          echo "3"; // Ocurrió un error técnico....
                          }
                          else
                            echo "2"; // Ocurrió un problema al registrar la información.

          }

           if(isset($_POST['mis_diagnosticos'])){ // Listamos lo servicios.
          
              $sql="select * from usuarios where email='".$_POST['email']."' ";
                    $query=pg_query($conexion, $sql);
                    $rows=pg_num_rows($query);
                            if($rows){
                              
                                $datos=pg_fetch_assoc($query);
                                        include('diagnosticos.php');    
                                
                            }
          
          }

          


          if(isset($_POST['asig_diagnostico'])){ // Asignación de diagnóstico



                    $sql="insert into asigna_diag (id_elab_diag, cod_usu_coor, cod_usu_respon, fecha_filtro, fecha_registro) values('".$_POST['id_elab_diag']."', '".$_SESSION['cod_usuario']."', '".$_POST['cod_usu_resp']."', '".$fecha_filtro."', '".$fecha_registro."') ";
                    $query=pg_query($conexion, $sql);

                          if($query){

                            // Buscamos si el usuario es de legal o de técnico
                              $sq="select * from usuarios where cod_usuario='".$_POST['cod_usu_resp']."' ";
                              $qr=pg_query($conexion, $sq);
                              $rows=pg_num_rows($qr);
                              $d=pg_fetch_assoc($qr);

                                    if($d['tipo_usuario']==19)
                                      $parametro='cod_usu_legal=';
                                    else if($d['tipo_usuario']==21)
                                      $parametro='cod_usu_tecnico=';

                                   $update="update diagno_client set $parametro'".$_POST['cod_usu_resp']."' where id_elab_diag='".$_POST['id_elab_diag']."' ";
                                    $query2=pg_query($conexion, $update);
                                        if($query2)
                                          echo "1"; // Registro exitoso...
                                        else
                                          echo "3"; // Ocurrió un error técnico....
                          }
                          else
                            echo "2"; // Ocurrió un problema al registrar la información.

          }
		  
		  if(isset($_POST['g_actuali_cliente'])){
			  
			  	if($_POST['tipo']==2){  // Actualizar servicios
							// Verificamos si existe el cliente..
							
					$sql="select * from  cliente where cod_cliente='".$_POST['cod_cliente_origin']."' ";
					$query=pg_query($conexion, $sql);
					$rows=pg_num_rows($query);
								if($rows){
											// actualizamos datos
							    $sql="update cliente set cod_cliente='".$_POST['cod_cliente']."', nombre='".$_POST['cliente']."', barrio='".$_POST['barrio']."', ciudad='".$_POST['ciudad']."', telefono_1='".$_POST['telefono_1']."' where cod_cliente='".$_POST['cod_cliente_origin']."' ";
								$query2=pg_query($conexion, $sql);
											if($query2){
											  echo  $update2="update segumientos set respuesta='".$_POST['respuesta']."', fecha_registro2='".$fecha_registro."' where id_fasfield='".$_POST['id_serv_cliente']."' ";
											   $sql2=pg_query($conexion, $udapte2);
											   
											        if($sql2)
											        	echo "1";
											   	    else
											   	    echo "2";
											}
										
											else
											echo "2";
								}
				}



          }

            if(isset($_POST['g_add_docu'])){ // registro de información documental..

                  
                  if(isset($_POST['create'])){ // Creando un usuario.. (empleado o cliente)

                        // Buscamos si se encuentra el usuario registrado...

                           $sql="select * from documentacion where cod_cliente='".$_POST['id_cliente']."' ";
                           $query=pg_query($conexion, $sql);
                           $rows=pg_num_rows($query);

                                if($rows==0){
                                    
                                   // insertamos cliente   
                                  $carpeta_cliente=$_POST['nombre']."_".$_POST['apellidos']."_".$_POST['id_cliente'];
                                  $md5_carp=md5($carpeta_cliente);                                                                                

                                    $sql2="insert into documentacion (cod_cliente, apellidos, nombres, tipo_docu, ciudad, cod_bodega, cod_estante, ubicacion, usr_codif) values('".$_POST['id_cliente']."', '".$_POST['apellidos']."', '".$_POST['nombre']."', '".$_POST['tipo_docu']."', '', '".$_POST['cod_bodega']."', '".$_POST['cod_estante']."', '".$_POST['ubicacion']."', '".$md5_carp."') ";

                                   //$carpeta_cliente=$_POST['nombre']."_".$_POST['apellidos']."_".$_POST['id_cliente'];
                                               
                                    $query2=pg_query($conexion, $sql2);

                                         if($query2){
                                            mkdir('../files/clientes/'.$md5_carp); // Creamos carpeta inicial...
                                                  // Creamos subcarpetas
                                                 mkdir('../files/clientes/'.$md5_carp."/Documentos de propiedad");
                                                 mkdir('../files/clientes/'.$md5_carp."/Facturas y contratos");
                                                mkdir('../files/clientes/'.$md5_carp."/Otros documentos");
                                                  mkdir('../files/clientes/'.$md5_carp."/Analisis de caso");

                                                  echo "1";// Carpeta creada 



                                          }

                                } else
                                echo "3"; // El cliente ya existe..




                  }
                  if(isset($_POST['create_docu'])){

                        if(isset($_SESSION['nom_archivo'])){
                                  // Agregamos el registro a la docuemetación..
                                $sql="insert into detall_documento (id_cate_docu, cod_estado, cod_cliente, ruta, cod_usuario) values('".$_POST['id_cate_docu']."', 3, '".$_POST['cod_cliente']."', '".$_SESSION['nom_archivo']."', '".$_SESSION['cod_usuario']."')";
                                $query=pg_query($conexion, $sql);
                                    if($query)
                                      echo "1"; //
                                    else
                                      echo "2";
                        }else
                        echo "2"; // No ha agregado la documetación..
                  }

                  if(isset($_POST['listar_usuarios'])){

                        include('list_usuarios_docu.php');
                  }

                  if(isset($_POST['listar_documentos'])){
                      include('list_documentos.php');
                  }

            }


            if(isset($_GET['b_cliente'])){

                $q = strtolower($_GET["q"]);

                    $sql="select + from documentacion where cod_cliente LIKE '%$q%' or apellidos LIKE '%$q%' or nombres LIKE '%$q%' ";
                    $query=pg_query($conexion, $sql);
                    $rows=pg_num_rows($query);


                        if($rows){  
                           $data = array();
                                while($rs = pg_fetch_assoc($rsd)) { 
                                $cname[]= $rs['id_cliente'].", ".($rs['apellidos'])." ".$rs['nombres']." ";
                              //  echo $cname."\n";
                                }
                               echo json_encode($data);
                        }

            }

            if(isset($_POST['g_menus'])){

                  if(isset($_POST['create'])){

                      // COnsultamos que el menú no haya sido creado

                        $sql="select * from menu where descripcion='".trim($_POST['descripcion'])."' ";
                        $query=pg_query($conexion, $sql);
                        $rows=pg_num_rows($query);

                           if($rows==1)
                                echo "3"; // EL Menú ya fué creado ..
                            else{

                                  $sql="insert into menu (campo, descripcion, ruta) values('".$_POST['campo']."',  '".$_POST['descripcion']."', '".$_POST['ruta']."' ) ";
                                  $query=pg_query($conexion, $sql);

                                      if($query){
                                        echo "1";
                                          include('vistas.php');
                                      }
                                      else
                                        echo "2"; // Problema técnico..
                            }

                  }

                  if(isset($_POST['submenu'])){

                        $sql="select * from menu where descripcion='".trim($_POST['descripcion'])."' ";
                        $query=pg_query($conexion, $sql);
                        $rows=pg_num_rows($query);
                              if($rows==1)
                                echo "3";  // Ya existe un submenú iugal..
                              else{

                                      $sql="insert into submenu(cod_menu, descripcion, ruta, m_order, comentario) values('".$_POST['cod_menu']."', '".$_POST['descripcion']."', '".$_POST['ruta']."', '".$_POST['m_order']."','".$_POST['comentario']."') ";
                                      $query=pg_query($conexion, $sql);

                                          if($query){
                                              echo "1";
                                               // include('vistas.php');

                                          }else
                                          echo "2"; // Problema técnico..
                              }
                  }

            }

            if(isset($_POST['g_permisos'])){

                  $sql="select * from permisos_menu where cod_submenu='".$_POST['cod_submenu']."' and cod_usuario='".$_POST['cod_usuario']."' ";
                  $query=pg_query($conexion, $sql);
                  $rows=pg_num_rows($query);

                          if($rows){ // SI encontro el permiso del usuario entonteces actualice..
                            $datos=pg_fetch_assoc($query);

                              $sql2="update permisos_menu set cod_permiso='".$_POST['cod_estado']."' where id='".$datos['id']."' ";

                          }else
                          $sql2="insert into permisos_menu (cod_submenu, cod_permiso, cod_usuario) values('".$_POST['cod_submenu']."','".$_POST['cod_estado']."', '".$_POST['cod_usuario']."') ";

                          $query2=pg_query($conexion,$sql2);

                              if($query2)
                                 include('vistas.php');

            }
             
              // Gestión de tareas.
            if(isset($_POST['g_tareas'])){

                  if(isset($_POST['create'])){  // Crear una tarea manual..  

                    // Consultamos que la tarea no haya sido ya creada por el usuario

                        $sql="select * from tareas where nombre='".trim($_POST['nombre'])."' and cod_usu_emisor='".$_SESSION['cod_usuario']."' and cod_proyecto='".$_POST['cod_proyecto']."' ";
                        $query=pg_query($conexion, $sql);
                        $rows=pg_num_rows($query);                        
                             
                               if($rows==0){
                                  // Ahora creamos tarea del usuario.. /tipo de generación manual..
                            $insert="insert into tareas (tipo_gene, fecha_venci, cod_usu_emisor, n_repet, tipo_termino, descripcion, prioridad, fecha_inicio, cod_proyecto, nombre) values(2, '".$_POST['fecha_venci']."', '".$_SESSION['cod_usuario']."', '".$_POST['n_repet']."', '".$_POST['tipo_termino']."', '".$_POST['descripcion']."', '".$_POST['prioridad']."', '".$_POST['fecha_ini']."', '".$_POST['cod_proyecto']."', '".$_POST['nombre']."') ";
                              $query2=pg_query($conexion, $insert);
                                }
                                    
                                    if(isset($query2) or $rows==1){
                                      // consultamos el id de la tarea del usuario..
                                      $sql="select max(id_tarea) as id_tarea from tareas  where cod_usu_emisor='".$_SESSION['cod_usuario']."' ";
                                      $query=pg_query($conexion, $sql);
                                      $datos=pg_fetch_assoc($query);

                                          //Buscamos si ya se anexó la tarea al usuario..
                                          $sql2="select id_tarea from asigna_tareas where id_tarea='".$datos['id_tarea']."' and cod_usu_asignado='".$_POST['cod_usu_asignado']."' ";
                                          $query2=pg_query($conexion, $sql2);
                                          $rows2=pg_num_rows($query2);

                                                  if($rows2==0){
                                                    $insert="insert into asigna_tareas (id_tarea, cod_usu_asignado) values('".$datos['id_tarea']."', '".$_POST['cod_usu_asignado']."' ) ";
                                                     $query3=pg_query($conexion, $insert);
                                                  }
                                                  else 
                                                    $sal=1;

                                                      if(isset($query3) or $sal==1)
                                                        echo "1"; // Tarea asignada al usuario..
                                                      else
                                                        echo "2"; // Problema técnico..
                                          }

                                 
                        } // Fin de creación de tarea...
                        
            }

            // Doble autenticación..

            if(isset($_POST['ingresar_auth'])){

                  // Verificamos que el código generado sea el correcto
                    $sql="select * from doble_auth where cod_usuario='".$_SESSION['cod_usuario']."' and fecha_filtro='".$fecha_filtro."' and cod_estado=3 and clave='".$_POST['clave_auth']."'  ";
                    $query=pg_query($conexion, $sql);
                    $rows=pg_num_rows($query);

                        if(isset($rows)){
                          $_SESSION['doble_auth']=$_POST['clave_auth'];
                          echo "1";
                            $sql="update  doble_auth set cod_estado=4 where cod_usuario='".$_SESSION['cod_usuario']."' and fecha_filtro='".$fecha_filtro."'  ";
                          $query=pg_query($conexion, $sql);
                          $rows=pg_num_rows($query);
                        }
                        else
                          echo "2";

            }

             if(isset($_POST['r_sms'])){ // Reenviar mensaje de doble autenticación...

                  // Verificamos que el código generado sea el correcto
                    $sql="select * from doble_auth where cod_usuario='".$_SESSION['cod_usuario']."' and fecha_filtro='".$fecha_filtro."' and cod_estado=3   ";
                    $query=pg_query($conexion, $sql);
                    $rows=pg_num_rows($query);
                    $dt=pg_fetch_assoc($query);

                        if(isset($rows)){
                          include('envia_sms2.php');
                         
                        }
                        else
                          echo "2";

            }


             if(isset($_POST['add_segui_devol'])){ //Actualización datos (Devolución)

                  // Verificamos que exista el servicio del cliente a devolver..

                    $sql="select * from devolucion where id_serv_cliente='".$_POST['id_serv_cliente']."' ";
                    $query=pg_query($conexion, $sql);
                    $rows=pg_num_rows($query);
                        if(isset($rows)){

                            if($_POST['cod_serv_reemplazo']=='')
                              $_POST['cod_serv_reemplazo']=0;

                            // Actualizamos datos
                   $update="update devolucion set v_ejecutado='".$_POST['v_ejecutado']."', p_identificado='".$_POST['p_identificado']."', res_problema='".$_POST['res_problema']."',  cod_serv_remplazo='".$_POST['cod_serv_reemplazo']."', exp_caso='".$_POST['exp_caso']."', costo_suyo_devol='".$_POST['costo_suyo_devol']."', costo_suyo_conti='".$_POST['costo_suyo_conti']."', v_cotizado='".$_POST['v_cotizado']."', v_pago_cliente='".$_POST['v_pago_cliente']."' where id_serv_cliente='".$_POST['id_serv_cliente']."' ";
                               $query=pg_query($conexion, $update);
                                if($query)
                                  echo "1";
                                else
                                  echo "2";
                        }
                        else
                          echo "3";

            }
            

            if(isset($_POST['vistas'])){ // Generador de vistas
                    include('vistas.php');
            }

             if(isset($_POST['vista_docu'])){ // Generador de vistas de documentos. (archivos)
                    include('vistas_docu.php');
            }

            // Crear listas desplegables
            if(isset($_POST['g_list_despleg'])){
              echo "jei";

                 
                  if(isset($_POST['create'])){



                                // Consultamos la descripcion real de la lista desplegable

                           $s="select * from activi_etapa_diag where id_activi_diag='".$_POST['descripcion']."' ";
                              $q=pg_query($conexion, $s);
                              $d=pg_fetch_assoc($q);


                      // COnsultamos que el menú no haya sido creado

                        $sql="select tipo_lista from listas_despleg where descripcion='".trim($d['descripcion'])."' ";
                        $query=pg_query($conexion, $sql);
                        $rows=pg_num_rows($query);

                           if($rows==1)
                                echo "3"; // La lista desplegable ya existe.
                            else{

                                  $sql="insert into listas_despleg (tipo_lista, categoria, descripcion) values('".$_POST['descripcion']."', 1, '".$d['descripcion']."' ) ";
                                  $query=pg_query($conexion, $sql);

                                      if($query){
                                        echo "1";
                                          include('vistas.php');
                                      }
                                      else
                                        echo "2"; // Problema técnico..
                            }

                  }

                  if(isset($_POST['det_list'])){ /// Detalle de la lista desplegable

                         $sql="select * from deta_list_despleg where descripcion='".trim($_POST['descripcion'])."' and tipo_lista='".$_POST['tipo_lista']."' ";
                        $query=pg_query($conexion, $sql);
                        $rows=pg_num_rows($query);
                              if($rows==1)
                                echo "3";  // Ya existe el detalle de la lista desplegable
                              else{

                                      $sql="insert into deta_list_despleg(tipo_lista, descripcion,descripcion2) values('".$_POST['tipo_lista']."', '".$_POST['descripcion']."', '') ";
                                     $query=pg_query($conexion, $sql);

                                          if($query){
                                              echo "1";
                                                include('vistas.php');

                                          }else
                                          echo "2"; // Problema técnico..
                              }
                  }

            
            }


  }else
  echo "Tu sesión ha caducado inactividad en el sistema, por favor refresca la página e inicia nuevamente"; // Sesión cadudad por tiempo sin actividad..

?>