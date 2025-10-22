<?php
include('includes/header.php');
include('db.php');

if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['error'] = "ID de categoría no válido.";
    header('Location: categorias.php');
    exit;
}

$id = intval($_GET['id']);

// Obtener categoría actual
$stmt = $conn->prepare("SELECT * FROM categorias WHERE id_categoria=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 0) {
    $_SESSION['error'] = "Categoría no encontrada.";
    header('Location: categorias.php');
    exit;
}
$categoria = $result->fetch_assoc();
$stmt->close();

// Actualizar categoría
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];

    $stmt = $conn->prepare("UPDATE categorias SET nombre_categoria=? WHERE id_categoria=?");
    $stmt->bind_param("si", $nombre, $id);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Categoría actualizada correctamente.";
        header('Location: categorias.php');
        exit;
    } else {
        echo '<div class="alert alert-danger">Error al actualizar la categoría.</div>';
    }
}
?>

<div class="card mx-auto" style="max-width: 500px;">
  <div class="card-body">
    <h4 class="mb-4 text-center">✏️ Editar Categoría</h4>
    <form method="POST">
      <div class="mb-3">
        <label class="form-label">Nombre de la categoría</label>
        <input type="text" name="nombre" class="form-control" value="<?= htmlspecialchars($categoria['nombre_categoria']); ?>" required>
      </div>

      <div class="d-flex justify-content-between">
        <a href="categorias.php" class="btn btn-secondary">⬅ Volver</a>
        <button type="submit" class="btn btn-primary">💾 Guardar cambios</button>
      </div>
    </form>
  </div>
</div>

<?php include('includes/footer.php'); ?>
