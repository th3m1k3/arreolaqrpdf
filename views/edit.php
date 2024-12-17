<?php
/**
 * Lógica para cargar los datos de la credencial a editar.
 */
if (isset($credencial)) {
    $usuario = htmlspecialchars($credencial['usuario']);
    $nombre = htmlspecialchars($credencial['nombre']);
    $apellidos = htmlspecialchars($credencial['apellidos']);
    $estado = htmlspecialchars($credencial['estado']);
    $pais = htmlspecialchars($credencial['pais']);
    $tipo_sangre = htmlspecialchars($credencial['tipo_sangre']);
    $contacto_emergencia = htmlspecialchars($credencial['contacto_emergencia']);
    $telefono_emergencia = htmlspecialchars($credencial['telefono_emergencia']);
    $enfermedad = htmlspecialchars($credencial['enfermedad']);
    $alergia = htmlspecialchars($credencial['alergia']);
    $fecha_nacimiento = $credencial['fecha_nacimiento'];
    $vigencia = $credencial['vigencia'];
} else {
    echo "Credencial no encontrada.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Credencial</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <!-- Header -->
    <?php require_once '../views/header.php'; ?>

    <!-- Main Content -->
    <main class="container py-5">
        <h2 id="formulario" class="text-center mb-4">Editar Credencial</h2>
        <h2 id="formulario" class="text-center mb-4">MIGUEL ANGEL ARREOLA RENTERIA LISI 4-1</h2>
        <form action="../controllers/CredencialController.php?action=update&id=<?php echo $credencial['id']; ?>" method="POST" enctype="multipart/form-data" class="bg-white p-4 rounded shadow">
            <div class="mb-3">
                <label for="usuario" class="form-label">Usuario:</label>
                <input type="text" id="usuario" name="usuario" value="<?php echo $usuario; ?>" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre:</label>
                <input type="text" id="nombre" name="nombre" value="<?php echo $nombre; ?>" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="apellidos" class="form-label">Apellidos:</label>
                <input type="text" id="apellidos" name="apellidos" value="<?php echo $apellidos; ?>" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="estado" class="form-label">Estado:</label>
                <input type="text" id="estado" name="estado" value="<?php echo $estado; ?>" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="pais" class="form-label">País:</label>
                <input type="text" id="pais" name="pais" value="<?php echo $pais; ?>" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="tipo_sangre" class="form-label">Tipo de Sangre:</label>
                <input type="text" id="tipo_sangre" name="tipo_sangre" value="<?php echo $tipo_sangre; ?>" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="emergencia" class="form-label">Contacto de Emergencia:</label>
                <input type="text" id="emergencia" name="emergencia" value="<?php echo $contacto_emergencia; ?>" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="telefono_emergencia" class="form-label">Teléfono de Emergencia:</label>
                <input type="text" id="telefono_emergencia" name="telefono_emergencia" value="<?php echo $telefono_emergencia; ?>" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="enfermedad" class="form-label">Enfermedad:</label>
                <input type="text" id="enfermedad" name="enfermedad" value="<?php echo $enfermedad; ?>" class="form-control">
            </div>
            <div class="mb-3">
                <label for="alergia" class="form-label">Alergia:</label>
                <input type="text" id="alergia" name="alergia" value="<?php echo $alergia; ?>" class="form-control">
            </div>
            <div class="mb-3">
                <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento:</label>
                <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" value="<?php echo $fecha_nacimiento; ?>" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="vigencia" class="form-label">Vigencia:</label>
                <input type="date" id="vigencia" name="vigencia" value="<?php echo $vigencia; ?>" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="foto" class="form-label">Foto de Perfil (opcional):</label>
                <input type="file" id="foto" name="foto" class="form-control" accept="image/*">
            </div>
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Actualizar Credencial</button>
        </form>
    </main>

    <!-- Footer -->
    <?php 
   include_once('../views/footer.php');
   ?>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
