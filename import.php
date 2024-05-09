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

move_uploaded_file($_FILES["uploaded_file"]["tmp_name"], 'files/import.csv');

$file_name = 'files/import.csv';
if ($file_handle = fopen($file_name, "r")) {
    fgetcsv($file_handle);
    while ($data = fgetcsv($file_handle)) {
        // verificare se email è già inserita
        // fare validazioni
        $stmt = $pdo->prepare("
            INSERT INTO users
            (username, email, password, image)
            VALUES
            (:username, :email, :password, :image)"
        );
        $stmt->execute([
            'username' => $data[1],
            'email' => $data[2] ?: null,
            'password' => $data[3] ?: null,
            'image' => $data[4] ?: null,
        ]);
    }
    fclose($file_handle);
}