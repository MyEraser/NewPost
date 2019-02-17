<html>
<head>
  
  <title>Pontos de terminais</title>
  <script src="http://maps.google.com/maps/api/js?sensor=TRUE" type="text/javascript"></script>
</head>
<body class=''>
   <div class='table-title'> Endereços e Contatos </div>


    <div class='col-md-12'>
        <div id="map" class='map col-md-12' style="height: 600px;">
        </div>
    </div>
    <!-- estruturando tabela com detalhes dos locais -->
  
    </div>

    <div class='col-md-12 table-wrapper-scroll-y'>    
        <table class='table table-striped tabelaLocais'>
            <thead class='black white-text'>
              <tr>
                <th scope='col'>code</th>
                <th scope='col'>name</th>                            
                <th scope='col'>usable</th>
                <th scope='col'>boxnum  </th>
                <th scope='col'>hotline </th>
                <th scope='col'>email</th>
                <th scope='col'>address_type </th>
                <th scope='col'>address</th>
                <th scope='col'>number </th>
                <th scope='col'>complement  </th>
                <th scope='col'>district</th>
                <th scope='col'>city</th>
                <th scope='col'>state </th>
                <th scope='col'>zip </th>
                <th scope='col'>latitude</th>
                <th scope='col'>longitude</th>
                <th scope='col'>weektime </th>
                <th scope='col'>weekendtime </th>
                <th scope='col'>opdays </th>
                <th scope='col'>thumb</th>
                <th scope='col'>photo</th>
                <th scope='col'>province</th>                          
              </tr>
            </thead>
            <tbody class='table table-striped' >
              <?php
                echo $tabela_locais;
              ?>
            </tbody>
        </table>

    </div>

<!-- Precisei colocar o javascript aqui, 
  para que seja possível receber os dados que são exibidos tanto na view quanto nos marcadores, 
  pois alguns tem intervalos de horário que não podem ser exibidos fora de intervalo-->

<script type="text/javascript">
    //os dados dos locais precisam ser estruturados no formato adequado javascript
    <?php echo "var locations = ". json_encode($cordenadas).";"; ?>

    var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 5,
      center: new google.maps.LatLng(-17.2834536,-44.7350334),
      mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    var infowindow = new google.maps.InfoWindow();

    var marker, i;

    for (i = 0; i < locations.length; i++) { 
      marker = new google.maps.Marker({
        position: new google.maps.LatLng(locations[i][1], locations[i][2]),
        map: map
      });

      google.maps.event.addListener(marker, 'click', (function(marker, i) {
        return function() {
          infowindow.setContent(locations[i][0]);
          infowindow.open(map, marker);
        }
      })(marker, i));
    }

  </script>
</body>


</html>
