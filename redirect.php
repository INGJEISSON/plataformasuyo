<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
Espere por favor .....
<script type="text/javascript">
                                                
  parent.location='portal.php';
</script>-->


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
Espere por favor .....
<script type="text/javascript">

var token=localStorage.getItem("token");
 							       var datos2='consul_clave_pc='+1+'&regisid='+1+'&token='+token;
                                     $.ajax({            
                                            type: "POST",
                                            data: datos2,
                                            url: 'includes/php/modulos/function/devices.php',
                                            success: function(valor2){
                                            	
                                                   if(valor2!=3){
                                                   		if(localStorage.getItem("clave_pc")==valor2){ // Verifico si la clave depositada al equipo confirmó identidad en el día actual.
                                                    	  localStorage.setItem("clave_pc", valor2);
                                                    	 // alert("jeisson");                                                    	  
                                                    	   parent.location='portal.php';
                                                   		}else{
                                                   			//alert("jeisson2");
                                                   			
                                                   			 parent.location='doble_auth.php'; // Genero otra identidad al equipo..

                                                   		}
                                                   		
                                                       
                                                   }
                                            }
                                      });  
</script>