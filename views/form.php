<?php include('header.php'); ?>

<h2>Editar Credencial</h2>
<form action="../controllers/CredencialController.php?action=edit&id=<?= $credencial['id'] ?>" method="POST" enctype="multipart/form-data">
    <input type="text" name="usuario" value="<?= $credencial['usuario'] ?>" class="form-control" required><br><br>
   

    <input type="submit" value="Guardar Cambios" class="btn btn-primary">
</form>

<?php include('footer.php'); ?>
