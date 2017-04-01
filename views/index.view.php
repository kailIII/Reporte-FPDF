


<div class="container">
  <div class="row">
 
    <div class="col-md-6 col-md-offset-3">
      <h1>Consulta de Estatus de Soporte</h1>
      <form method="POST" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <div class="form-group">
          <input type="text" class="form-control texto-cedula" id="exampleInputEmail1" name="cedula"  placeholder="Escribe tu Cedula">
        </div>
          <?php if(!empty($errores)): ?>
            <div class="error">
                <ul>
                    <?php echo $errores; ?>
                </ul>
            </div>
         <?php endif; ?>

      <button type="submit" class="btn btn-success">Consultar Estatus</button>
      </form>
    
    </div>
  </div>
</div>

<?php require 'views/footer.php'; ?>

