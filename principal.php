<!DOCTYPE html>
<?php
error_reporting( E_NOTICE ); // avoid notice
 require_once 'Dbconfig.php';
?>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Galería de imagenes</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
  <!-- JavaScript Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</head>
<body>
<div class="container-lg">
	<div class="row">
      <form method="post" enctype="multipart/form-data" class="form-horizontal">
       <table class="table table-bordered table-responsive">
          <tr>
           <td><label class="control-label">Buscar Fotos</label></td>
              <td><input class="form-control" type="text" name="nombre" placeholder="Nombre Imagen"  /></td>
          </tr>
          <tr>
              <td colspan="2"><button type="submit" name="btnbuscar"  class="btn btn-danger">
              <span class="glyphicon glyphicon-save"></span> &nbsp; Buscar
              </button>
              </td>
          </tr>
          </table>
   </form>
<?php
      $busqueda=$_POST['nombre'];
 if(isset($busqueda)){
    $stmt = $DB_con->prepare("SELECT id, imagen, nombre, descripcion FROM imagenes WHERE nombre like '%$busqueda%' "
            . "or   descripcion like '%$busqueda%'  ");
 }
 else{
  $stmt = $DB_con->prepare('SELECT id, imagen, nombre, descripcion FROM imagenes ORDER BY nombre ASC');
 }
 $stmt->execute();
 if($stmt->rowCount() > 0)
 {
  while($row=$stmt->fetch(PDO::FETCH_ASSOC))
  {
   extract($row);
   ?>
   <div class="col-xs-3">
    <p class="page-header"><?php echo $nombre."&nbsp;/&nbsp;".$descripcion; ?></p>
    <img src="imagenes/<?php echo $row['imagen']; ?>" class="img-rounded" width="250px" height="250px" />
    <p class="page-header">
    </p>
   </div>       
   <?php
  }
 }
 else
 {
  ?>
        <div class="col-xs-12">
         <div class="alert alert-warning">
             <span class="glyphicon glyphicon-info-sign"></span> &nbsp; Archivo No encontrado ...
            </div>
        </div>
        <?php
 }
?>
</div>
  <button onclick="location.href='agregar.php';" class="btn btn-warning">Agregar una foto</button>
</div>
</body>
</html>