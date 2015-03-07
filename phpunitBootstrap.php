<?php

require 'vendor/autoload.php';

$directory = new RecursiveDirectoryIterator('src/etanNitram');
$recIterator = new RecursiveIteratorIterator($directory);
$regex = new RegexIterator($recIterator, '/\.php$/i');

foreach($regex as $name => $item) {
    require_once($name);
}
