<?php
include('includes/header.php');
include('db.php');

// ✅ Solo inicia sesión si no está activa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: productos.php');
    exit;
}

$id = intval($_GET['id']);

// Obtener datos del producto
$stmt = $conn->prepare("SELECT * FROM productos WHERE id_producto = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$producto = $result->fetch_assoc();

if (!$producto) {
    echo "<div class='alert alert-danger mt-4 text-center'>❌ Producto no encontrado.</div>";
    exit;
}

// Obtener categorías
$query_cat = "SELECT id_categoria, nombre_categoria FROM categorias";
$categorias = $conn->query($query_cat);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre']);
    $precio = floatval($_POST['precio']);
    $stock = intval($_POST['stock']);
    $id_categoria = intval($_POST['id_categoria']);

    if (empty($nombre) || $precio <= 0 || $stock < 0 || $id_categoria <= 0) {
        echo '<div class="alert alert-danger mt-3">⚠️ Todos los campos son obligatorios y deben tener valores válidos.</div>';
    } else {
        $stmt = $conn->prepare("UPDATE productos SET nombre_producto = ?, precio = ?, stock = ?, id_categoria = ? WHERE id_producto = ?");
        $stmt->bind_param("sdiii", $nombre, $precio, $stock, $id_categoria, $id);

        if ($stmt->execute()) {
            $_SESSION['success'] = "✅ Producto actualizado correctamente.";
            header('Location: productos.php');
            exit;
        } else {
            echo '<div class="alert alert-danger mt-3">❌ Error al actualizar el producto.</div>';
        }

        $stmt->close();
    }
}
?>

<div class="card mx-auto mt-4" style="max-width: 600px;">
  <div class="card-body">
    <h4 class="text-center mb-4">✏️ Editar Producto</h4>
    <form method="POST">
      <div class="mb-3">
        <label class="form-label">Nombre del producto</label>
        <input type="text" name="nombre" class="form-control" 
               value="<?= htmlspecialchars($producto['nombre_producto']) ?>" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Precio ($)</label>
        <input type="number" step="0.01" name="precio" class="form-control" 
               value="<?= htmlspecialchars($producto['precio']) ?>" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Stock</label>
        <input type="number" name="stock" class="form-control" 
               value="<?= htmlspecialchars($producto['stock']) ?>" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Categoría</label>
        <select name="id_categoria" class="form-select" required>
          <option value="">Seleccione una categoría</option>
          <?php while ($cat = $categorias->fetch_assoc()): ?>
            <option value="<?= $cat['id_categoria'] ?>" 
              <?= $cat['id_categoria'] == $producto['id_categoria'] ? 'selected' : '' ?>>
              <?= htmlspecialchars($cat['nombre_categoria']) ?>
            </option>
          <?php endwhile; ?>
        </select>
      </div>

      <div class="d-flex justify-content-between">
        <a href="productos.php" class="btn btn-secondary">⬅ Volver</a>
        <button type="submit" class="btn btn-primary">💾 Guardar cambios</button>
      </div>
    </form>
  </div>
</div>

<?php include('includes/footer.php'); ?>
