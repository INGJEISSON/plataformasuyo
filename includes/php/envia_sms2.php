<?php
$telefono="57".$_SESSION['telefono'];                       
                                                                $mensaje=$_SESSION['nombre'].",  su token de seguridad es: ".$_SESSION['clave_auth2'];
                                                                $curl = curl_init();
                                                                $from="Suyo Colombia";
                                                                $number=$telefono;
                                                                $msg=$mensaje;

                                                                 $url = 'https://api.hablame.co/sms/envio/';
                                                              $data = array(
                                                                'cliente' => 10010646, //Numero de cliente
                                                                'api' => 'IlHFpX4NJNt2UOOluEHC8oseMCmvKD', //Clave API suministrada
                                                                'numero' => $telefono, //numero o numeros telefonicos a enviar el SMS (separados por una coma ,)
                                                                'sms' => $mensaje, //Mensaje de texto a enviar
                                                                'fecha' => '', //(campo opcional) Fecha de envio, si se envia vacio se envia inmediatamente (Ejemplo: 2017-12-31 23:59:59)
                                                                'referencia' => 'Suyo Colombia', //(campo opcional) Numero de referencio ó nombre de campaña
                                                              );

                                                              $options = array(
                                                                  'http' => array(
                                                                      'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                                                                      'method'  => 'POST',
                                                                      'content' => http_build_query($data)
                                                                  )
                                                              );
                                                              $context  = stream_context_create($options);
                                                              $result = json_decode((file_get_contents($url, false, $context)), true);

                                                              if ($result["resultado"]===0) {
                                                               // $access=1; // Acceso permitido..

                                                                //print 'Se ha enviado el SMS exitosamente';

                                                              } else {
                                                                print 'ha ocurrido un error!!';
                                                              }

                                                               /* curl_setopt_array($curl, array(
                                                                  CURLOPT_URL => "http://api.infobip.com/sms/1/text/single",
                                                                  CURLOPT_RETURNTRANSFER => true,
                                                                  CURLOPT_ENCODING => "",
                                                                  CURLOPT_MAXREDIRS => 10,
                                                                  CURLOPT_TIMEOUT => 30,
                                                                  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                                                  CURLOPT_CUSTOMREQUEST => "POST",
                                                                  CURLOPT_POSTFIELDS => "{ \"from\":\"$from\", \"to\":\"$number\", \"text\":\"$msg\" }",
                                                                  CURLOPT_HTTPHEADER => array(
                                                                    "accept: application/json",
                                                                    "authorization: Basic c3V5bzpKZWlzc29uMTk5MQ==",
                                                                    "content-type: application/json"
                                                                  ),
                                                                ));

                                                                $response = curl_exec($curl);
                                                                $err = curl_error($curl);

                                                                curl_close($curl);

                                                                if ($err) {
                                                                //  echo "cURL Error #:" . $err;
                                                                } else {
                                                                //  echo $response;
                                                                }*/