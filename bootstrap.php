<?php
require_once "../vendor/autoload.php";
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();
define('DBHOST', $_ENV['DBHOST']);
define('DBUSER', $_ENV['DBUSER']);
define('DBPASS', $_ENV['DBPASS']);
define('DBNAME', $_ENV['DBNAME']);
define('DBPORT', $_ENV['DBPORT']);
define('CLIENT', new Google_Client());

CLIENT->setClientId($_ENV["CLIENTID"]);
CLIENT->setClientSecret($_ENV["CLIENTSECRET"]);
CLIENT->setRedirectUri($_ENV["REDIRECTURI"]);
CLIENT->addScope("email");