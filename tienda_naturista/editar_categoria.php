<?php
include_once 'includes/header.php';
include_once 'db.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['error'] = "ID de categoría no válido.";
    header('Location: categorias.php');
    exit;
}

$id = intval($_GET['id']);

$stmt = $conn->prepare("SELECT * FROM categorias WHERE id_categoria = ?");
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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre']);

    $stmt = $conn->prepare("UPDATE categorias SET nombre_categoria = ? WHERE id_categoria = ?");
    $stmt->bind_param("si", $nombre, $id);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Categoría actualizada correctamente.";
        header('Location: categorias.php');
        exit;
    } else {
        echo '<div class="alert alert-danger text-center">Error al actualizar la categoría.</div>';
    }

    $stmt->close();
}
?>
<div class="container py-5">
  <div class="card shadow-lg mx-auto" style="max-width: 500px; border-radius: 1rem;">
    <div class="card-body">
      <h4 class="mb-4 text-center text-primary fw-bold">✏️ Editar Categoría</h4>
      <form method="POST">
        <div class="mb-3">
          <label for="nombre" class="form-label fw-semibold">Nombre de la categoría</label>
          <input type="text" id="nombre" name="nombre" class="form-control border-primary" 
                 value="<?= htmlspecialchars($categoria['nombre_categoria']); ?>" required>
        </div>
        <div class="d-flex justify-content-between">
          <a href="categorias.php" class="btn btn-outline-secondary">⬅ Volver</a>
          <button type="submit" class="btn btn-primary">💾 Guardar cambios</button>
        </div>
      </form>
    </div>
  </div>
</div>
<?php include_once 'includes/footer.php'; ?>

<?php include('includes/footer.php'); ?>

