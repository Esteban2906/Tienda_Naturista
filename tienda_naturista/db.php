<?php
$servername = "localhost";
$username = "tienda_user";
$password = "Tienda2025@Secure"; 
$dbname = "tienda_naturista";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>

