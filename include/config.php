<?php
$DB_HOST = 'localhost';
$DB_USER = 'root';
$DB_PASSWORD = '';
$DB_DATABASE = 'affiliate_db';

try {
    $db = new PDO("mysql:host=$DB_HOST;dbname=$DB_DATABASE;charset=utf8", $DB_USER, $DB_PASSWORD);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$db->exec("set names utf8mb4");
} catch (Exception $e) {
    echo "Failed to connect to MySQL: " . $e->getMessage();
}

?>
