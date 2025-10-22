<?php
// eliminar_categoria.php
session_start();
include('db.php');

if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['error'] = "ID de categoría inválido.";
    header('Location: categorias.php');
    exit;
}

$id = intval($_GET['id']);

// Verificar si la categoría existe
$stmt = $conn->prepare("SELECT nombre_categoria FROM categorias WHERE id_categoria = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$res = $stmt->get_result();
if ($res->num_rows === 0) {
    $_SESSION['error'] = "Categoría no encontrada.";
    header('Location: categorias.php');
    exit;
}
$nombre = $res->fetch_assoc()['nombre_categoria'];
$stmt->close();

// Verificar si hay productos asociados
$stmt = $conn->prepare("SELECT COUNT(*) AS total FROM productos WHERE id_categoria = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$res = $stmt->get_result();
$count = $res->fetch_assoc()['total'];
$stmt->close();

if ($count > 0) {
    // Opción A: evitar borrado si hay productos
    $_SESSION['error'] = "No se puede eliminar la categoría \"$nombre\" porque tiene {$count} producto(s). Mueve o elimina los productos primero.";

    // --- Si prefieres opción B: desvincular productos (poner id_categoria NULL) y luego eliminar,
    // comentar la línea anterior y descomentar las siguientes:
    /*
    $conn->begin_transaction();
    $stmt = $conn->prepare("UPDATE productos SET id_categoria = NULL WHERE id_categoria = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    $stmt = $conn->prepare("DELETE FROM categorias WHERE id_categoria = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        $conn->commit();
        $_SESSION['success'] = "Categoría \"$nombre\" eliminada. Los productos fueron desvinculados.";
    } else {
        $conn->rollback();
        $_SESSION['error'] = "Error al eliminar la categoría.";
    }
    $stmt->close();
    */
} else {
    // No hay productos asociados: eliminar seguro
    $stmt = $conn->prepare("DELETE FROM categorias WHERE id_categoria = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        $_SESSION['success'] = "Categoría \"$nombre\" eliminada correctamente.";
    } else {
        $_SESSION['error'] = "Error al eliminar la categoría. Intenta de nuevo.";
    }
    $stmt->close();
}

$conn->close();
header('Location: categorias.php');
exit;
