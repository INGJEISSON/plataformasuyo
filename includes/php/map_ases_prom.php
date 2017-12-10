<?php
include('../dependencia/conexion.php');

$select="select enc_procesadas.asesor, enc_procesadas.tipo_encuesta, enc_procesadas.ciudad,  enc_procesadas.id_cliente, enc_procesadas.telefono, enc_procesadas.cliente, segui_asesor.latitude, segui_asesor.longitude, segui_asesor.visita, segui_asesor.detalle_vis, enc_procesadas.id_fasfield from enc_procesadas, segui_asesor where enc_procesadas.id_fasfield=segui_asesor.id_fasfield  and segui_asesor.latitude<>0 and enc_procesadas.fecha_filtro between '2017-10-01' and '2017-12-30'  ORDER BY enc_procesadas.cliente  DESC";
$query=pg_query($conexion, $select);
$rows=pg_num_rows($query);


?>
<!DOCTYPE html>
<html>
<head>
    
    <title>Seguimiento Asesor</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">    
    <link rel="shortcut icon" type="image/x-icon" href="docs/images/favicon.ico" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.1.0/dist/leaflet.css" integrity="sha512-wcw6ts8Anuw10Mzh9Ytw4pylW8+NAD4ch3lqm9lzAsTxg0GFeJgoAtxuCLREZSC5lUXdVyo/7yfsqFjQ4S+aKw==" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.1.0/dist/leaflet.js" integrity="sha512-mNqn2Wg7tSToJhvHcqfzLMU6J4mkOImSPTxVZAdo+lcPlk+GhZmYgACEe0x35K7YzW1zJ7XyJV/TT1MrdXvMcA==" crossorigin=""></script>    
</head>
<body>

<table width="200" border="0">
  <tr>
    <td><strong>Ciudad</strong></td>
    <td><strong>Encuesta</strong></td>
    <td><strong>Asesor/Promotor</strong></td>
    <td><strong>Acción</strong></td>
  </tr>
  <tr>
    <td><select name="select" id="select">
    </select>
    <label for="select"></label></td>
    <td><select name="select2" id="select2">
      <option value="2">Asesor y Líderes</option>
      <option>Diagnósticos Vendidos</option>
      <option>Servicios Vendidos</option>
      <option value="1">Diagnósticos</option>
      <option value="5">Prospectos</option>
      <option value="4">Promotor</option>
    </select></td>
    <td><select name="select3" id="select3">
    </select></td>
    <td><input type="button" value="Buscar"></td>
  </tr>
</table>


<div id="mapid" style="width: 900px; height: 1000px;" align="center"></div>
<script>

   // var mymap = L.map('mapid').setView([51.505, -0.09], 13);

    var mymap = L.map('mapid', {
center: [6.5283182, -71.9830334],
    zoom: 4
});

    L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoiaW5namVpc3NvbiIsImEiOiJjajRubjQxZjQwMjYyMzN0Y2ptY21zampnIn0.DqoZxHaPfVoKM-n2F8JjaA', {
        maxZoom: 18,
       /*attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, ' +
            '<a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
            'Imagery © <a href="http://mapbox.com">Mapbox</a>',*/
        id: 'mapbox.streets'
    }).addTo(mymap);
    
    var prospecto = L.icon({
   // iconUrl: 'http://app.suyo.io/img/if_1010_location_c_2400515.png',
    iconSize: [38, 10],
    iconAnchor: [22, 94],
    popupAnchor: [-3, -76],
    //shadowUrl: 'http://app.suyo.io/img/if_1010_location_c_2400515.png',
    shadowSize: [38, 10],
    shadowAnchor: [22, 94]
});

<?php while($datos=pg_fetch_assoc($query)){ 
    
    
	$select2="select valor from det_repor_aseso where id_fasfield='".$datos['id_fasfield']."' ";
	$query2=pg_query($conexion, $select2);
	$rows2=pg_num_rows($query2);
		$datos2=pg_fetch_assoc($query2);

	?>
	
    L.marker([<?php echo $datos['latitude']	?>, <?php echo $datos['longitude']?>]).addTo(mymap)
        .bindPopup("<p>Asesor: <?php echo $datos['asesor']	?></p><p>Cliente: <?php echo $datos['cliente']	?></p><p>Visita: <?php echo $datos['visita']	?></p><p>Detalle de visita: <?php echo utf8_decode($datos['detalle_vis'])	?></p><p>Valor: <?php echo (number_format($datos2['valor']))	?></p>");		
		
<?php } ?>
   
    /*L.circle([51.508, -0.11], 500, {
        color: 'red',
        fillColor: '#f03',
        fillOpacity: 0.5
    }).addTo(mymap).bindPopup("I am a circle. ");*/

   L.polygon([
        [41.490, -0.09],
        [41.6, -0.08],
        [41.50, -0.07],
        [41.49, -0.06]
    ]).addTo(mymap).bindPopup("Barranquilla");

    var popup = L.popup();

    /*function onMapClick(e) {
        popup
            .setLatLng(e.latlng)
            .setContent("Coordenadas en este punto " + e.latlng.toString())
            .openOn(mymap);
    }*/

    mymap.on('click', onMapClick);

</script>



</body>
</html>
