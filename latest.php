<?php
require 'common.php';
$grouped = $db->query('select * from pokemon group by pokemon_id having count(*) = 1 order by disappear_time desc limit 25;');
$rows = array();
?>
<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Latest NEW Pokemon</title>
    <style>
      td { border: 1px solid black; }
      .map { height: 150px; width: 250px; }
    </style>
  </head>
  <body>
    <h2>Latest NEW Pokemon</h2>
    <hr />
    <table>
      <tr>
        <th>Name (#)</th>
        <th>Despawned</th>
        <th>Location</th>
      </tr>
      <?php
        while ($row = $grouped->fetchArray()) {
          $rows[] = $row;
      ?>
      <tr>
        <td><?php echo $p[$row['pokemon_id']]; ?> (#<?php echo $row['pokemon_id']; ?>)</td>
        <td>
          <a href="sightings.php?id=<?php echo $row['pokemon_id']; ?>">
            <?php echo to_eastern_time($row['disappear_time']); ?>
          </a>
        </td>
        <?php /* We can cheat, pokemon_id is unique because of our query. Let's key the div on it! */ ?>
        <td><div class="map" id="map_<?php echo $row['pokemon_id']; ?>"></div></td>
      </tr>
     <?php } ?>
    </table>
    <script>
      function initMap() {
        <?php foreach ($rows as $row) { ?>
        var map_<?php echo $row['pokemon_id']; ?> = new google.maps.Map(document.getElementById('map_<?php echo $row['pokemon_id']; ?>'), {
          zoom: 15,
          center: <?php echo lat_lon($row); ?>
        });

        marker_<?php echo $row['pokemon_id']; ?> = new google.maps.Marker({
          position: <?php echo lat_lon($row); ?>, map: map_<?php echo $row['pokemon_id']; ?>, icon: '/static/icons/<?php echo $row['pokemon_id']; ?>.png'
        });
      <?php } ?>
      }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC8zoy_8-3AAr9qecW8sQXVkRc6G8P-sk4&callback=initMap&libraries=places,geometry" async defer></script>
  </body>
</html>
