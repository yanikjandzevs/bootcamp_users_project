<?php
define("PARTS_DIR", __DIR__ . '/parts/');

function part(string $part_name, array $variables = []) {
  extract($variables);
  include(PARTS_DIR . $part_name . '.php');
}

function storeError(string $error_msg) {
  file_put_contents(__DIR__ . '/error.log', date('d.m.Y. H:i:s') . ' ' . $error_msg . PHP_EOL, FILE_APPEND);
}
