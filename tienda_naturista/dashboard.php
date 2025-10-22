<?php include('db.php'); ?>

<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <title>Dashboard | Tienda Naturista</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body>

  <nav class="navbar navbar-expand-lg navbar-dark bg-success">
    <div class="container-fluid">
      <a class="navbar-brand fw-bold" href="#">🌿 Tienda Naturista</a>
      <div class="collapse navbar-collapse">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a href="dashboard.php" class="nav-link active">Inicio</a></li>
          <li class="nav-item"><a href="productos.php" class="nav-link">Productos</a></li>
          <li class="nav-item"><a href="categorias.php" class="nav-link">Categorías</a></li>
          <li class="nav-item"><a href="index.php" class="nav-link text-warning">Salir</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="container py-5">
    <h3 class="fw-bold text-success mb-4">Panel de Control</h3>

    <?php
      $totalProductos = $conn->query("SELECT COUNT(*) AS total FROM productos")->fetch_assoc()['total'];
      $totalCategorias = $conn->query("SELECT COUNT(*) AS total FROM categorias")->fetch_assoc()['total'];
      $stockTotal = $conn->query("SELECT SUM(stock) AS total FROM productos")->fetch_assoc()['total'];
    ?>

    <div class="row text-center">
      <div class="col-md-4 mb-3">
        <div class="card shadow-sm border-0">
          <div class="card-body">
            <h4 class="text-success"><?= $totalProductos ?></h4>
            <p class="text-muted">Productos registrados</p>
          </div>
        </div>
      </div>
      <div class="col-md-4 mb-3">
        <div class="card shadow-sm border-0">
          <div class="card-body">
            <h4 class="text-success"><?= $totalCategorias ?></h4>
            <p class="text-muted">Categorías</p>
          </div>
        </div>
      </div>
      <div class="col-md-4 mb-3">
        <div class="card shadow-sm border-0">
          <div class="card-body">
            <h4 class="text-success"><?= $stockTotal ?></h4>
            <p class="text-muted">Stock total</p>
          </div>
        </div>
      </div>
    </div>
  </div>

  </body>
</html>
