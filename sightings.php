<?php
require 'common.php';

function lat_lon($sighting) {
  return '{lat: '.$sighting['latitude'].', lng: '.$sighting['longitude'].'}';
}

function to_eastern_time($time) {
  $datetime = new DateTime($time);
  $est_time = new DateTimeZone('America/New_York');
  $datetime->setTimezone($est_time);
  return $datetime->format('Y-m-d H:i:s');
}

$pid = $_GET['id'];
$stmt = $db->prepare('SELECT * FROM pokemon where pokemon_id=:id');
$stmt->bindValue(':id', $pid, SQLITE3_INTEGER);
$result = $stmt->execute();
$num_results = 0;
$sightings = array();
while ($row = $result->fetchArray()) {
  $num_results++;
  $sightings[] = $row;
}
?>

<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Rarity</title>
    <style>#map { height: 500px; }</style>
  </head>
  <body>
    <h2>I have seen <?php echo $num_results; ?> <?php echo $p[$pid]; ?>.</h2>
    <a href="rarity.php">Click here for a rarity index</a>
    <hr />
    <div id="map"></div>
    <script>
      function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 10,
          center: {lat: 41.106858, lng: -80.645983}
        });

        <?php
        $n = 0;
        foreach ($sightings as $sighting) {
          $n++;
        ?>
          marker<?php echo $n; ?> = new google.maps.Marker({
            position: <?php echo lat_lon($sighting); ?>, map: map, title: 'Sighting <?php echo $n; ?>', icon: '/static/icons/<?php echo $pid; ?>.png'
          });
          marker<?php echo $n; ?>.addListener('click', function() {
            (new google.maps.InfoWindow({content: "Despawned: <?php echo to_eastern_time($sighting['disappear_time']); ?>"})).open(map, marker<?php echo $n; ?>);
          });
        <?php } ?>
      }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC8zoy_8-3AAr9qecW8sQXVkRc6G8P-sk4&callback=initMap&libraries=places,geometry" async defer></script>

    Sightings:<br />
    <table>
      <tr>
        <th>Despawn Time (Eastern Time)</th>
      </tr>
      <?php
      $n = 0;
      foreach ($sightings as $sighting) {
        $n++;
      ?>
        <tr><td onclick="google.maps.event.trigger(marker<?php echo $n; ?>, 'click')"><?php echo to_eastern_time($sighting['disappear_time']); ?></td></tr>
      <?php } ?>
    </table>
  </body>
</html>
