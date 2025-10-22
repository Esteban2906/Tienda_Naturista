<?php
include('includes/header.php');
include('db.php');
session_start();

// Obtener categorías para el select
$query = "SELECT id_categoria, nombre_categoria FROM categorias";
$resultado_categorias = $conn->query($query);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre']);
    $precio = floatval($_POST['precio']);
    $stock = intval($_POST['stock']);
    $id_categoria = intval($_POST['id_categoria']);

    if (empty($nombre) || $precio <= 0 || $stock < 0 || $id_categoria <= 0) {
        echo '<div class="alert alert-danger">⚠️ Todos los campos son obligatorios y deben tener valores válidos.</div>';
    } else {
        $stmt = $conn->prepare("INSERT INTO productos (nombre_producto, precio, stock, id_categoria) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sdii", $nombre, $precio, $stock, $id_categoria);

        if ($stmt->execute()) {
            $_SESSION['success'] = "✅ Producto agregado correctamente.";
            header('Location: productos.php');
            exit;
        } else {
            echo '<div class="alert alert-danger">❌ Error al agregar el producto.</div>';
        }

        $stmt->close();
    }
}
?>

<div class="card mx-auto mt-4" style="max-width: 600px;">
  <div class="card-body">
    <h4 class="text-center mb-4">➕ Agregar Producto</h4>
    <form method="POST">
      <div class="mb-3">
        <label class="form-label">Nombre del producto</label>
        <input type="text" name="nombre" class="form-control" placeholder="Ej: Crema de Aloe Vera" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Precio ($)</label>
        <input type="number" step="0.01" name="precio" class="form-control" placeholder="Ej: 25.00" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Stock</label>
        <input type="number" name="stock" class="form-control" placeholder="Ej: 10" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Categoría</label>
        <select name="id_categoria" class="form-select" required>
          <option value="">Seleccione una categoría</option>
          <?php while ($cat = $resultado_categorias->fetch_assoc()) { ?>
            <option value="<?= $cat['id_categoria'] ?>"><?= $cat['nombre_categoria'] ?></option>
          <?php } ?>
        </select>
      </div>

      <div class="d-flex justify-content-between">
        <a href="productos.php" class="btn btn-secondary">⬅ Volver</a>
        <button type="submit" class="btn btn-success">💾 Guardar producto</button>
      </div>
    </form>
  </div>
</div>

<?php include('includes/footer.php'); ?>
