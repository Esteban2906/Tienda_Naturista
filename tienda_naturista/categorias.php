<?php
// categorias.php (reemplazar tu archivo actual por este)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (session_status() === PHP_SESSION_NONE) session_start();

// usar require_once para forzar error si faltan archivos
require_once 'includes/header.php';
require_once 'db.php';

// Obtener categorías
$sql = "SELECT * FROM categorias ORDER BY id_categoria";
$result = $conn->query($sql);
if ($result === false) {
    $_SESSION['error'] = "Error en la consulta: " . $conn->error;
}
?>

<div class="d-flex justify-content-between align-items-center mb-3">
  <h2 class="text-success">Categorías</h2>
  <a href="agregar_categoria.php" class="btn btn-success">+ Agregar categoría</a>
</div>

<?php
// Mensajes
if (!empty($_SESSION['success'])) {
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">'
         . $_SESSION['success'] .
         '<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>';
    unset($_SESSION['success']);
}
if (!empty($_SESSION['error'])) {
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">'
         . $_SESSION['error'] .
         '<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>';
    unset($_SESSION['error']);
}
?>

<div class="card shadow-sm">
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover mb-0">
        <thead class="table-success">
          <tr>
            <th style="width:60px">ID</th>
            <th>Nombre</th>
            <th style="width:220px">Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
              <tr>
                <td><?= $row['id_categoria'] ?></td>
                <td><?= htmlspecialchars($row['nombre_categoria']) ?></td>
                <td>
                  <a href="editar_categoria.php?id=<?= $row['id_categoria'] ?>" class="btn btn-warning btn-sm">Editar</a>
                  <a href="eliminar_categoria.php?id=<?= $row['id_categoria'] ?>" class="btn btn-danger btn-sm"
                     onclick="return confirm('¿Seguro que deseas eliminar esta categoría?');">Eliminar</a>
                </td>
              </tr>
            <?php endwhile; ?>
          <?php else: ?>
            <tr><td colspan="3" class="text-center py-4">No hay categorías todavía.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?php require_once 'includes/footer.php'; ?>
