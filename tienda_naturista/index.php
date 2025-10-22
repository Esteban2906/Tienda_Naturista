<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tienda Naturista - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body class="bg-light d-flex justify-content-center align-items-center vh-100">

    <div class="card shadow-lg p-4" style="width: 22rem;">
      <h3 class="text-center mb-4 text-success fw-bold">🌿 Tienda Naturista</h3>
      <form action="dashboard.php" method="POST">
        <div class="mb-3">
          <label class="form-label">Usuario</label>
          <input type="text" class="form-control" name="usuario" placeholder="Ingrese su usuario">
        </div>
        <div class="mb-3">
          <label class="form-label">Contraseña</label>
          <input type="password" class="form-control" name="contraseña" placeholder="Ingrese su contraseña">
        </div>
        <button type="submit" class="btn btn-success w-100">Iniciar sesión</button>
      </form>
      <p class="text-center mt-3 text-muted small">* Login no funcional (solo demo)</p>
    </div>

  </body>
</html>
