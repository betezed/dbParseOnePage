<?php
$host_name = "localhost";
$db_name = "dataiku";
$table_name = "census_learn_sql";
$user_name = "root";
$user_password = "toor";

try {
    $db = new PDO('mysql:host=' . $host_name . ';dbname=' . $db_name, $user_name, $user_password);
} catch (PDOException $e) {
    print "Erreur !: " . $e->getMessage() . "<br/>";
    die();
}
