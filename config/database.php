<?php
function connectDatabase()
{
    $host = 'localhost'; // Ganti sesuai host Anda
    $dbname = 'cadh5373_ikatan_kematian_warga'; // Ganti sesuai nama database Anda
    $username = 'cadh5373_drezhary'; // Ganti sesuai username database Anda
    $password = 'D1ckyR3zh4ry'; // Ganti sesuai password database Anda

    try {
        $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
        ini_set('display_errors', 1);
        error_reporting(E_ALL);

        return null;
    }
}
