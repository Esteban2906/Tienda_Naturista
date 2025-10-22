<?php
// eliminar_producto.php
session_start();
include('db.php');

if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['error'] = "ID de producto inválido.";
    header('Location: productos.php');
    exit;
}

$id = intval($_GET['id']);

// Opcional: antes de borrar, podrías obtener el nombre para el mensaje
$stmt = $conn->prepare("SELECT nombre_producto FROM productos WHERE id_producto = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$res = $stmt->get_result();
if ($res->num_rows === 0) {
    $_SESSION['error'] = "Producto no encontrado.";
    header('Location: productos.php');
    exit;
}
$producto = $res->fetch_assoc()['nombre_producto'];
$stmt->close();

// Delete
$stmt = $conn->prepare("DELETE FROM productos WHERE id_producto = ?");
$stmt->bind_param("i", $id);
if ($stmt->execute()) {
    $_SESSION['success'] = "Producto \"{$producto}\" eliminado correctamente.";
} else {
    $_SESSION['error'] = "Error al eliminar el producto. Intenta de nuevo.";
}
$stmt->close();
$conn->close();

header('Location: productos.php');
exit;
