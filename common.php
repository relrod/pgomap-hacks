<?php
require 'config.php';
date_default_timezone_set('UTC');

function lat_lon($sighting) {
  return '{lat: '.$sighting['latitude'].', lng: '.$sighting['longitude'].'}';
}

function to_eastern_time($time) {
  $datetime = new DateTime($time);
  $est_time = new DateTimeZone('America/New_York');
  $datetime->setTimezone($est_time);
  return $datetime->format('Y-m-d H:i:s');
}

$p = json_decode(file_get_contents($pgomap_root.'/static/locales/pokemon.en.json'), true);

class DB extends SQLite3 {
  function __construct() {
    global $pgomap_root;
    $this->open($pgomap_root.'/pogom.db', SQLITE3_OPEN_READONLY);
  }
}

$db = new DB();
