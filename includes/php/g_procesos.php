<?php
include('../dependencia/conexion.php');
      // Agregamos archivo....
$fecha_registro=date('Y-m-d H:mm:ss');
//comprobamos que sea una petición ajax
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') 
{

    //obtenemos el archivo a subir
    @$file = $_FILES['archivo']['name'];

    //comprobamos si existe un directorio para subir el archivo
    //si no es así, lo creamos
    if(!is_dir("files/")) 
        mkdir("files/", 0777);
     
    //comprobamos si el archivo ha subido
    if ($file && move_uploaded_file($_FILES['archivo']['tmp_name'],"../files/".$file))
    {
       sleep(3);//retrasamos la petición 3 segundos

            // insertamos archivos...
              $insert="insert into tmp_archiv (nom_archivo) values('".$file."') ";
              $query=pg_query($conexion, $insert);

                  if($query)
                    $_SESSION['nom_archivo']=$file;



       echo $file;//devolvemos el nombre del archivo para pintar la imagen
    }
}else{
    throw new Exception("Error Processing Request", 1);   
}


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
                                if(!is_dir("files/")) 
                                    mkdir("files/", 0777);
                                 
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
                           /* while($datos=pg_fetch_assoc($query_asesor)){

                                   
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
                            }*/


                          $sql711="select distinct enc_procesadas.asesor from enc_procesadas, det_repor_aseso where $parametro enc_procesadas.id_fasfield=det_repor_aseso.id_fasfield and  enc_procesadas.tipo_encuesta=2 and det_repor_aseso.resul_visita='Visitado y Pagado' and enc_procesadas.fecha_filtro between '".$_POST['fecha_1']."' and '".$_POST['fecha_2']."' ";
                        $query_asesor11=pg_query($conexion, $sql711);
                        $rows=pg_num_rows($query_asesor11);
                              $i=1;
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

                           /*while($datos78=pg_fetch_assoc($query78)){

                                   
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
                            }*/

                           

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
              
                    if($query){
                      $sql2="select seguimientos.fecha_registro, seguimientos.archivo, seguimientos.observacion, estado.descripcion as estado, estado.cod_estado, usuarios.nombre as usuario from seguimientos, usuarios, estado where seguimientos.cod_usuario=usuarios.cod_usuario and seguimientos.cod_estado=estado.cod_estado and seguimientos.id_fasfield='".$_POST['id_fasfield']."' and seguimientos.cod_usuario!=0 and seguimientos.tipo_seguimiento='".$_POST['tipo_seguimiento']."' order by seguimientos.id_segui_llam desc  ";
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
                          }
                      include('history_revi.php');
                      
                    }
                    $_SESSION['nom_archivo']="";


              }
              else
                echo "2"; // Problema interno (técnico).            

      } 
      
         if(isset($_POST['revi_revi_call'])){ // Agregar revisión de call center.  y otras revisiones..
                
                            
                         $sql2="select seguimientos.fecha_registro, seguimientos.archivo, seguimientos.observacion, estado.descripcion as estado, estado.cod_estado, usuarios.nombre as usuario from seguimientos, usuarios, estado where seguimientos.cod_usuario=usuarios.cod_usuario and seguimientos.cod_estado=estado.cod_estado and seguimientos.id_fasfield='".$_POST['id_fasfield']."' and seguimientos.cod_usuario!=0 and seguimientos.tipo_seguimiento='".$_POST['tipo_seguimiento']."' order by seguimientos.id_segui_llam desc  ";
                        $query2=pg_query($conexion, $sql2);
                          $rows2=pg_num_rows($query2);
                      include('history_revi.php');
         
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
              
              if($_POST['listar_usuarios'])
               include('list_usuarios.php');
              
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

            $insert="insert into activ_serv (cod_activi_etapa, id_serv_cliente, observacion, cod_usu_respon, fecha_actividad) values('".$_POST['cod_activi_etapa']."', '".$_POST['id_serv_cliente']."', '".$_POST['observacion']."', '".$_SESSION['cod_usuario']."', '".$_POST['fecha_actividad']."') ";
            $query=pg_query($conexion, $insert);
                    

              if($query){
              
                    if($query){
                    $sql2="select usuarios.nombre as usuario, activ_serv.observacion, activ_serv.fecha_actividad, activ_serv.fecha_registro, etapa_activ.descripcion as etapa, activi_etapa.descripcion as actividad from usuarios, etapa_activ, activ_serv, activi_etapa where usuarios.cod_usuario=activ_serv.cod_usu_respon and etapa_activ.cod_etapa=activi_etapa.cod_etapa and activ_serv.cod_activi_etapa=activi_etapa.cod_activi_etapa and activ_serv.id_serv_cliente='".$_POST['id_serv_cliente']."' order by activ_serv.id_activi_serv desc ";
                          $query2=pg_query($conexion, $sql2);
                          $rows2=pg_num_rows($query2);
                         include('history_revi2.php');
                    }
              }
              else
                echo "2"; // Problema interno (técnico).            

      } 
       if(isset($_POST['revi_serv'])){ //  Agregar actividades del servicio.
                            
                      $sql2="select usuarios.nombre as usuario, activ_serv.observacion, activ_serv.fecha_actividad, activ_serv.fecha_registro, etapa_activ.descripcion as etapa, activi_etapa.descripcion as actividad from usuarios, etapa_activ, activ_serv, activi_etapa where usuarios.cod_usuario=activ_serv.cod_usu_respon and etapa_activ.cod_etapa=activi_etapa.cod_etapa and activ_serv.cod_activi_etapa=activi_etapa.cod_activi_etapa and activ_serv.id_serv_cliente='".$_POST['id_serv_cliente']."' order by activ_serv.id_activi_serv desc ";
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



                    $sql="insert into asigna_serv (id_serv_cliente, cod_usu_coor, cod_usuario, fecha_filtro) values('".$_POST['id_serv_cliente']."', '".$_SESSION['cod_usuario']."', '".$_POST['cod_usu_resp']."', '".$fecha_registro."') ";
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

                           $sql="select * from enc_procesadas where id_cliente='".$_POST['id_cliente']."' ";
                           $query=pg_query($conexion, $sql);
                           $rows=pg_num_rows($query);

                                if(isset($rows)){
                                      // insertamos cliente 

                                   echo  $sql2="insert into documentacion (cod_cliente, apellidos, nombres, tipo_docu) values('".$_POST['id_cliente']."', '".$_POST['apellidos']."', '".$_POST['nombre']."', '".$_POST['tipo_docu']."', '') ";

                                   $carpeta_cliente=$_POST['nombre']."_".$_POST['apellidos']."_".$_POST['id_cliente'];
                                                mkdir('../files/clientes/'.$carpeta_cliente); // Creamos carpeta inicial...
                                                  // Creamos subcarpetas
                                                  mkdir('../files/clientes/'.$carpeta_cliente."/Documentos de propiedad");
                                                  mkdir('../files/clientes/'.$carpeta_cliente."/Facturas y contratos");
                                                  mkdir('../files/clientes/'.$carpeta_cliente."/Otros documentos");
                                                  mkdir('../files/clientes/'.$carpeta_cliente."/Analisis de caso");
                                    //$query2=pg_query($conexion, $sql2);

                                         /* if($query2){

                                                  // Creamos carpeta del cliente..  
                                              $carpeta_cliente=$_POST['nombres']."_".$_POST['apellidos']."_".$_POST['cod_cliente'];
                                                mkdir('files/'.$carpeta_cliente); // Creamos carpeta inicial...
                                                  // Creamos subcarpetas
                                                  mkdir('files/'.$carpeta_cliente."/Documentos de propiedad");
                                                  mkdir('files/'.$carpeta_cliente."/Facturas y contratos");
                                                  mkdir('files/'.$carpeta_cliente."/Otros documentos");
                                                  mkdir('files/'.$carpeta_cliente."/Analisis de caso");

                                                  echo "1";// Carpeta creada 



                                          }*/

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

            }
?>