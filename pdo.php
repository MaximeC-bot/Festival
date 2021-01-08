<?php
$host = "localhost";
$port = "3306";
$database = "M3104";
$user = "root";
$password = "root";

$db = new PDO("mysql:host=$host;port=$port;dbname=$database", $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)); // Connexion à la base de donnée
$db->exec("SET NAMES UTF8");
$db->exec("SET lc_time_names = 'fr_FR'");
