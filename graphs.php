<?php
require 'common.php';
$grouped = $db->query('SELECT pokemon_id, count(pokemon_id) FROM pokemon GROUP BY pokemon_id ORDER BY count(pokemon_id) DESC;');
$count = $db->querySingle('SELECT count(*) from pokemon;');
?>
<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Graphs</title>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Pokemon', 'Sightings'],
          <?php while ($row = $grouped->fetchArray()) { ?>
          ['<?php echo $p[$row['pokemon_id']]; ?>', <?php echo $row['count(pokemon_id)']; ?>],
          <?php } ?>
        ]);

        var options = {
          title: 'Pokemon Rarity'
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
      }
    </script>
  </head>
  <body>
    <div id="piechart" style="width: 900px; height: 500px;"></div>
  </body>
</html>
