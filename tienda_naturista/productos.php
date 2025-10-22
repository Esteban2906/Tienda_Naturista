<?php
include('includes/header.php');
include('db.php');

// Mostrar mensaje de éxito si existe
if (isset($_SESSION['success'])) {
    echo '<div class="alert alert-success text-center">'.$_SESSION['success'].'</div>';
    unset($_SESSION['success']);
}

// Consulta de productos con su categoría
$query = "SELECT p.id_producto, p.nombre_producto, p.precio, p.stock, c.nombre_categoria 
          FROM productos p
          INNER JOIN categorias c ON p.id_categoria = c.id_categoria
          ORDER BY p.id_producto ASC";
$result = $conn->query($query);
?>

<div class="container mt-4">

  <!-- 🔙 BOTONES DE NAVEGACIÓN -->
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Productos</h3>
    <div>
      <a href="index.php" class="btn btn-secondary me-2">🏠 Cerrar Sesión</a>
      <a href="dashboard.php" class="btn btn-info me-2">📊 Ir al Dashboard</a>
      <a href="agregar_producto.php" class="btn btn-success">+ Agregar producto</a>
    </div>
  </div>

  <table class="table table-striped table-hover text-center">
    <thead class="table-success">
      <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Categoría</th>
        <th>Precio</th>
        <th>Stock</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      <?php if ($result->num_rows > 0): ?>
        <?php while($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?= $row['id_producto']; ?></td>
            <td><?= htmlspecialchars($row['nombre_producto']); ?></td>
            <td><?= htmlspecialchars($row['nombre_categoria']); ?></td>
            <td>$<?= number_format($row['precio'], 2); ?></td>
            <td><?= $row['stock']; ?></td>
            <td>
              <a href="editar_producto.php?id=<?= $row['id_producto']; ?>" class="btn btn-warning btn-sm">Editar</a>
              <a href="eliminar_producto.php?id=<?= $row['id_producto']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que deseas eliminar este producto?');">Eliminar</a>
            </td>
          </tr>
        <?php endwhile; ?>
      <?php else: ?>
        <tr>
          <td colspan="6">No hay productos registrados.</td>
        </tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>

<?php include('includes/footer.php'); ?>
