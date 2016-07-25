<?php
require 'common.php';
$grouped = $db->query('SELECT pokemon_id, count(pokemon_id) FROM pokemon GROUP BY pokemon_id ORDER BY count(pokemon_id) DESC;');
$count = $db->querySingle('SELECT count(*) from pokemon;');
?>
<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Rarity</title>
    <style>
      td { border: 1px solid black; }
    </style>
  </head>
  <body>
    <table>
      <tr>
        <th>Name (#)</th>
        <th>Occurrences</th>
        <th>Percentage</th>
      </tr>
      <?php while ($row = $grouped->fetchArray()) { ?>
      <tr>
        <td><?php echo $p[$row['pokemon_id']]; ?> (#<?php echo $row['pokemon_id']; ?>)</td>
        <td>
          <a href="sightings.php?id=<?php echo $row['pokemon_id']; ?>">
            <?php echo $row['count(pokemon_id)']; ?>
          </a>
        </td>
        <td>
          <?php echo round(($row['count(pokemon_id)'] / $count) * 100, 3) ?>%
        </td>
      </tr>
      <?php } ?>
    </table>
  </body>
</html>
