<?php
/**
 * @file index.php
 * @brief Página para generar y mostrar credenciales con un diseño dinámico.
 * @details Contiene un formulario para ingresar datos de credenciales y una tabla para mostrar las credenciales guardadas.
 *
 * @package Views
 */

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generador de Credencial</title>
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
        <h2 id="formulario" class="text-center mb-4">Formulario de Credencial</h2>
        <h2 class="text-center mb-4">MIGUEL ANGEL ARREOLA RENTERIA LISI 4-1</h2>
        <form action="../controllers/CredencialController.php?action=create" method="POST" enctype="multipart/form-data" class="bg-white p-4 rounded shadow">
            <!-- Campos del formulario -->
            <div class="mb-3">
                <label for="usuario" class="form-label">Usuario:</label>
                <input type="text" id="usuario" name="usuario" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre:</label>
                <input type="text" id="nombre" name="nombre" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="apellidos" class="form-label">Apellidos:</label>
                <input type="text" id="apellidos" name="apellidos" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="estado" class="form-label">Estado:</label>
                <input type="text" id="estado" name="estado" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="pais" class="form-label">País:</label>
                <input type="text" id="pais" name="pais" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="tipo_sangre" class="form-label">Tipo de Sangre:</label>
                <input type="text" id="tipo_sangre" name="tipo_sangre" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="emergencia" class="form-label">Contacto de Emergencia:</label>
                <input type="text" id="emergencia" name="emergencia" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="telefono_emergencia" class="form-label">Teléfono de Emergencia:</label>
                <input type="text" id="telefono_emergencia" name="telefono_emergencia" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="enfermedad" class="form-label">Enfermedad:</label>
                <input type="text" id="enfermedad" name="enfermedad" class="form-control">
            </div>
            <div class="mb-3">
                <label for="alergia" class="form-label">Alergia:</label>
                <input type="text" id="alergia" name="alergia" class="form-control">
            </div>
            <div class="mb-3">
                <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento:</label>
                <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="vigencia" class="form-label">Vigencia:</label>
                <input type="date" id="vigencia" name="vigencia" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="foto" class="form-label">Foto de Perfil:</label>
                <input type="file" id="foto" name="foto" class="form-control" accept="image/*">
            </div>
            <button type="submit" class="btn btn-success"><i class="fas fa-check-circle"></i> Generar Credencial</button>
        </form>

        <!-- Tabla de credenciales -->
        <h2 class="text-center mt-5">Credenciales Guardadas</h2>
        <table class="table table-striped table-bordered mt-4">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Usuario</th>
                    <th>Nombre</th>
                    <th>Apellidos</th>
                    <th>Estado</th>
                    <th>País</th>
                    <th>Tipo de Sangre</th>
                    <th>Contacto de Emergencia</th>
                    <th>Teléfono</th>
                    <th>Fecha de Nacimiento</th>
                    <th>Vigencia</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                require_once '../models/CredencialModel.php';
                $model = new CredencialModel();
                $credenciales = $model->getCredenciales();

                foreach ($credenciales as $credencial) {
                    echo "<tr>
                            <td>{$credencial['id']}</td>
                            <td>{$credencial['usuario']}</td>
                            <td>{$credencial['nombre']}</td>
                            <td>{$credencial['apellidos']}</td>
                            <td>{$credencial['estado']}</td>
                            <td>{$credencial['pais']}</td>
                            <td>{$credencial['tipo_sangre']}</td>
                            <td>{$credencial['contacto_emergencia']}</td>
                            <td>{$credencial['telefono_emergencia']}</td>
                            <td>{$credencial['fecha_nacimiento']}</td>
                            <td>{$credencial['vigencia']}</td>
                            <td>
                                <a href='../controllers/CredencialController.php?action=edit&id={$credencial['id']}' class='btn btn-warning btn-sm'><i class='fas fa-edit'></i> Editar</a>
                                <a href='../controllers/CredencialController.php?action=delete&id={$credencial['id']}' class='btn btn-danger btn-sm'><i class='fas fa-trash'></i> Eliminar</a>
                                <a href='../controllers/CredencialController.php?action=viewPdf&id={$credencial['id']}' class='btn btn-primary btn-sm'><i class='fas fa-eye'></i> Ver PDF</a>
                            </td>
                        </tr>";
                }
                ?>
            </tbody>
        </table>
    </main>

    <!-- Footer -->
   <?php 
   include_once('../views/footer.php');
   ?>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
