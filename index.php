<?php
$dataset = $_GET["dataset"];
$xmls = array(
				'architecturalheritage',
				'beaches',
				'bicycleroutes',
				'botanicalroutes',
				'carmotorbikeroutes',
				'caves',
				'churches-monasteries',
				'e4',
				'gorges',
				'healthservices',
				'museums',
				'organisations',
				'rockclimbingroutes',
				'shelters',
				'sights'
			);
			?>
<!DOCTYPE html>
<html> 
<head> 
  <meta http-equiv="content-type" content="text/html; charset=UTF-8" /> 
  <title>Hack4Med</title> 
  <script src="http://maps.google.com/maps/api/js?sensor=false" 
          type="text/javascript"></script>
	<style>
	#map {
	width: 100%;
	height: 100%;
	max-height: 100%;
	position: relative;
	background-color: rgb(229, 227, 223);
	overflow: hidden;
	-webkit-transform: translateZ(0px);
	}
	html, body{
	height: 100%;
	margin: 0;
	}
	</style>
</head> 
<body>
  <div id="map" style=""></div>

  <script type="text/javascript">
    var locations = [
		<?php

	//for($x=0;  $x<sizeof($xmls); $x++){
		$xml=simplexml_load_file("opendata/".$xmls[$dataset].".xml");
		for($i=0; $i<sizeof($xml->property); $i++){
			$name = (string)$xml->property[$i]->name;
			//$name = preg_replace('#[^\w()/.%\-&]#',"",$name);
			$name = str_replace("'","",$name);
			$name = str_replace("<","",$name);
			$name = str_replace("<","",$name);
			$key = str_replace(" ","%20",$name);
			$key = htmlspecialchars($key);
			$latitude = $xml->property[$i]->latitude;
			$longitude = $xml->property[$i]->longitude;
			
			$keyword = $key;//.'%20'.$xmls[$dataset];
			$jsrc = "https://ajax.googleapis.com/ajax/services/search/images?v=1.0&q=".$keyword;
			$json = file_get_contents($jsrc);
			$jset = json_decode($json, true);
			//print_r($jset);
			$image = $jset["responseData"]["results"][2]["url"];
			
			if($i<sizeof($xml->property)-1)
				echo '["'.$name.'",'.$latitude.','.$longitude.','.$i.',"'.$image.'"],';
			else
				echo '["'.$name.'",'.$latitude.','.$longitude.','.$i.',"'.$image.'"]';
		}
		//break;
	//}
		?>
    ];

    var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 9,
      center: new google.maps.LatLng(locations[0][1], locations[0][2]),
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
          infowindow.setContent('<div class="info_contenct">'+locations[i][0]+'<br /><img src="'+locations[i][4]+'" /></div>');
          infowindow.open(map, marker);
        }
      })(marker, i));
    }
  </script>
</body>
</html>
<?php
/*
for($i=0; $i<100; $i++){
	$jsrc = "https://ajax.googleapis.com/ajax/services/search/images?v=1.0&q=knosos";
	$json = file_get_contents($jsrc);
	$jset = json_decode($json, true);
	echo '<img src="'.$jset["responseData"]["results"][0]["url"].'" />';
}
*/


$xmls = array(
				'architecturalheritage',
				'beaches',
				'bicycleroutes',
				'botanicalroutes',
				'carmotorbikeroutes',
				'caves',
				'churches-monasteries',
				'e4',
				'gorges',
				'healthservices',
				'museums',
				'organisations',
				'rockclimbingroutes',
				'shelters',
				'sights'
			);
for($x=0;  $x<sizeof($xmls); $x++){
	$xml=simplexml_load_file("opendata/".$xmls[0].".xml");

	for($i=0; $i<sizeof($xml->property); $i++){
		$name = (string)$xml->property[$i]->name;
		$latitude = $xml->property[$i]->latitude;
		$longitude = $xml->property[$i]->longitude;
		
		//echo $latitude.' '.$longitude.' '.$name.'<br />';
	}
}
?>