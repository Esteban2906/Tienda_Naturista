<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tienda Naturista</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">
  <style>
    body { font-family: 'Open Sans', sans-serif; background-color: #f7faf7; }
    nav.navbar { background-color: #2e8b57; }
    .navbar-brand, .nav-link, .navbar-text { color: #fff !important; }
    .btn-success { background-color: #2e8b57; border-color: #2e8b57; }
    .btn-success:hover { background-color: #256b44; }
  </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold" href="#">🌿 Tienda Naturista</a>
    <div class="collapse navbar-collapse justify-content-end">
      <ul class="navbar-nav">
        <li class="nav-item"><a class="nav-link" href="productos.php">Productos</a></li>
        <li class="nav-item"><a class="nav-link" href="categorias.php">Categorías</a></li>
      </ul>
    </div>
  </div>
</nav>
<div class="container my-5">
