<?php
function connectDatabase()
{
    $host = 'localhost'; // Ganti sesuai host Anda
    $dbname = 'cadh5373_ikatan_kematian_warga'; // Ganti sesuai nama database Anda
    $username = 'root'; // Ganti sesuai username database Anda
    $password = ''; // Ganti sesuai password database Anda

    try {
        $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
        return null;
    }
}
