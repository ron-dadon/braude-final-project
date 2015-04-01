<?php
// Configuration file path
define('CONFIGURATION_FILE', '../application/configuration/configuration.ini');

require_once '../framework/trident.php';

$app = new Application();

$app->start();