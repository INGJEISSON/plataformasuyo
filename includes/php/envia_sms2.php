<?php
$telefono="57".$_SESSION['telefono'];                       
                                                                $mensaje=$_SESSION['nombre'].", su código de doble autenticación es: ".$_SESSION['clave_auth2'];
                                                                $curl = curl_init();
                                                                $from="Suyo Colombia";
                                                                $number=$telefono;
                                                                $msg=$mensaje;

                                                                curl_setopt_array($curl, array(
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
                                                                }