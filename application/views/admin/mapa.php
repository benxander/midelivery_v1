<style>
#mapa_input_box{width:100%;}
#mapa_display_as_box{width:100%;}
.gm-style .gm-style-mtc label,.gm-style .gm-style-mtc div{font-weight:400}
.gm-style .gm-style-cc span,.gm-style .gm-style-cc a,.gm-style .gm-style-mtc div{font-size:10px}
@media print {  .gm-style .gmnoprint, .gmnoprint {    display:none  }}@media screen {  .gm-style .gmnoscreen, .gmnoscreen {    display:none  }}
.gm-style{font-family:Roboto,Arial,sans-serif;font-size:11px;font-weight:400;text-decoration:none}
#cuadro_mapa{width:100%;}
  #mapCanvas {height: 500px;float: center;}
  .desactivado{ cursor: not-allowed;}
</style>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script languaje="javascript">
// VARIABLES GLOBALES JAVASCRIPT
var geocoder;
var marker;
var latLng;
var latLng2;
var map;
var image = '<?=base_url()?>images/puntero/cursor_divinas.png';
var formulario = document.getElementById('crudForm');
// INICiALIZACION DE MAPA
function initialize() {
geocoder = new google.maps.Geocoder();	
  latLng = new google.maps.LatLng(<?=$latitud?> ,<?=$longitud?>);
  map = new google.maps.Map(document.getElementById('mapCanvas'), {
    zoom:<?=$zoom?>,
    center: latLng,
    mapTypeId:google.maps.MapTypeId.ROADMAP  });


// CREACION DEL MARCADOR  
    marker = new google.maps.Marker({
    position: latLng,
    title: 'Arrastra el marcador hasta el sitio exacto',
    map: map,
	icon: image,
    draggable: true
  });
 
 

 
// Escucho el CLICK sobre el mama y si se produce actualizo la posicion del marcador 
     google.maps.event.addListener(map, 'click', function(event) {
     updateMarker(event.latLng);
   });
  
  // Inicializo los datos del marcador
  //    updateMarkerPosition(latLng);
     
      geocodePosition(latLng);
 
  // Permito los eventos drag/drop sobre el marcador
  google.maps.event.addListener(marker, 'dragstart', function() {
    // updateMarkerAddress('Arrastrando...');
  });
 
  google.maps.event.addListener(marker, 'drag', function() {
    // updateMarkerStatus('Arrastrando...');
    updateMarkerPosition(marker.getPosition());
  });
 
 google.maps.event.addListener(marker, 'dragend', function() {
    // updateMarkerStatus('Arrastre finalizado');
    geocodePosition(marker.getPosition());
  });
  

 
}


// Permito la gesti¢n de los eventos DOM
google.maps.event.addDomListener(window, 'load', initialize);

// ESTA FUNCION OBTIENE LA DIRECCION A PARTIR DE LAS COORDENADAS POS
function geocodePosition(pos) {
  geocoder.geocode({
    latLng: pos
  }, function(responses) {
    if (responses && responses.length > 0) {
      updateMarkerAddress(responses[0].formatted_address);
    } else {
      updateMarkerAddress('No puedo encontrar esta direccion.');
    }
  });
}

// OBTIENE LA DIRECCION A PARTIR DEL LAT y LON DEL FORMULARIO
function codeLatLon() { 
      str= formulario.lng.value+" , "+formulario.lat.value;
      latLng2 = new google.maps.LatLng(formulario.lat.value ,formulario.lng.value);
      marker.setPosition(latLng2);
      map.setCenter(latLng2);
      geocodePosition (latLng2);
      // formulario.direccion.value = str+" OK";
}

// OBTIENE LAS COORDENADAS DESDE lA DIRECCION EN LA CAJA DEL FORMULARIO
function codeAddress() {

		var provincia_nombre = $("#provincia option:selected").text();
		var municipio_nombre = $("#distrito option:selected").text();

        var address = formulario.direccion.value +'-'+ municipio_nombre +'-'+ provincia_nombre + '- España';
          geocoder.geocode( { 'address': address}, function(results, status) {
          if (status == google.maps.GeocoderStatus.OK) {
             updateMarkerPosition(results[0].geometry.location);
			 map.setZoom(17);
             marker.setPosition(results[0].geometry.location);
             map.setCenter(results[0].geometry.location);
           } else {
            alert('ERROR : ' + status);
          }
        });
      }

// OBTIENE LAS COORDENADAS DESDE lA DIRECCION EN LA CAJA DEL FORMULARIO
function codeAddress2 (address) {
          
          geocoder.geocode( { 'address': address}, function(results, status) {
          if (status == google.maps.GeocoderStatus.OK) {
             updateMarkerPosition(results[0].geometry.location);
             marker.setPosition(results[0].geometry.location);
             map.setCenter(results[0].geometry.location);
             // formulario.direccion.value = address;
           } else {
            alert('ERROR : ' + status);
          }
        });
      }

function updateMarkerStatus(str) {
  // formulario.direccion.value = str;
}

// RECUPERO LOS DATOS LON LAT Y DIRECCION Y LOS PONGO EN EL FORMULARIO
function updateMarkerPosition (latLng) {
  formulario.lng.value =latLng.lng();
  formulario.lat.value = latLng.lat();
}

function updateMarkerAddress(str) {
  // formulario.direccion.value = str;
}

// ACTUALIZO LA POSICION DEL MARCADOR
function updateMarker(location) {
        marker.setPosition(location);
        updateMarkerPosition(location);
        geocodePosition(location);
      }



function cargar_mapa(){
		formulario.direccion.value = '';
		var provincia_nombre = $("#provincia option:selected").text();
		var municipio_nombre = $("#municipio option:selected").text();
		var pais='España';
		var address = municipio_nombre+'-'+ provincia_nombre+'-'+ pais;
		// alert(address);
		geocoder.geocode( { 'address': address}, function(results, status) {
          if (status == google.maps.GeocoderStatus.OK) {
			 map.setZoom(15);
             updateMarkerPosition(results[0].geometry.location);
             marker.setPosition(results[0].geometry.location);
             map.setCenter(results[0].geometry.location);
             // formulario.direccion.value = address;
           } else {
            alert('ERROR : ' + status);
          }
        });
	};

</script>

<button id="ubicar" class="desactivado" type="button" onclick="codeAddress()" disabled='disabled' title="Debes colocar una dirección">Ubicar Dirección en el Mapa</button>
<div id="mapCanvas" style="position: relative; overflow: hidden; transform: translateZ(0px); background-color: rgb(229, 227, 223);"></div>

<br>