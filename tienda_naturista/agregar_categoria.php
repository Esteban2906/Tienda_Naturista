<?php
include('includes/header.php');
include('db.php');

// Iniciar sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Procesar el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre']);

    if (empty($nombre)) {
        $_SESSION['error'] = "⚠️ Debe ingresar un nombre de categoría.";
    } else {
        $stmt = $conn->prepare("INSERT INTO categorias (nombre_categoria) VALUES (?)");
        $stmt->bind_param("s", $nombre);

        if ($stmt->execute()) {
            $_SESSION['success'] = "✅ Categoría agregada correctamente.";
            header('Location: categorias.php');
            exit;
        } else {
            $_SESSION['error'] = "❌ Error al agregar la categoría. Intente nuevamente.";
        }

        $stmt->close();
    }
}
?>

<div class="container py-5">
  <div class="card shadow-lg mx-auto" style="max-width: 500px; border-radius: 1rem;">
    <div class="card-body">
      <h4 class="mb-4 text-center text-success fw-bold">➕ Agregar Categoría</h4>

      <!-- Mensaje de error o éxito -->
      <?php if (!empty($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
      <?php endif; ?>

      <form method="POST" action="">
        <div class="mb-3">
          <label class="form-label fw-semibold">Nombre de la categoría</label>
          <input type="text" name="nombre" class="form-control border-success" placeholder="Ej: Suplementos naturales" required>
        </div>

        <div class="d-flex justify-content-between">
          <a href="categorias.php" class="btn btn-outline-secondary">
            ⬅ Volver
          </a>
          <button type="submit" class="btn btn-success">
            💾 Guardar
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php include('includes/footer.php'); ?>
