<?php

$host = 'localhost';
$db   = 'ifoa_blog';
$user = 'root';
$pass = '';

$dsn = "mysql:host=$host;dbname=$db";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

$pdo = new PDO($dsn, $user, $pass, $options);


$stmt = $pdo->query("SELECT * FROM users");
$users = $stmt->fetchAll();

$file_name = 'files/export.csv';
$file_handle = fopen($file_name, 'w');

if($users) {
    fputcsv($file_handle, array_keys($users[0]));
}

foreach ($users as $row) {
    fputcsv($file_handle, $row);
}

fclose($file_handle);

?>