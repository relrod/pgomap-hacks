<?php
$pgomap_root = '/srv/PokemonGo-Map';
date_default_timezone_set('America/New_York');

$p = json_decode(file_get_contents($pgomap_root.'/static/locales/pokemon.en.json'), true);

class DB extends SQLite3 {
  function __construct() {
    global $pgomap_root;
    $this->open($pgomap_root.'/pogom.db', SQLITE3_OPEN_READONLY);
  }
}

$db = new DB();
