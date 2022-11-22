<!DOCTYPE html>
<?php
error_reporting( E_NOTICE ); // avoid notice
 require_once 'Dbconfig.php';
 if(isset($_POST['btnsave']))
 {
  $nombre = $_POST['nombre'];//  nombre imagen 
  $descri= $_POST['descri'];
  $imgFile = $_FILES['imagen']['name'];
  $tmp_dir = $_FILES['imagen']['tmp_name'];
  $imgSize = $_FILES['imagen']['size'];
  if(empty($nombre)){
   $errMSG = "Ingresa el nombre de la imagen.";
  }
  else if(empty($imgFile)){
   $errMSG = "Por favor selecciona el archivo de imagen a subir.";
  }
  else
  {
   $upload_dir = 'imagenes/'; // upload directory
   $imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION)); // get image extension
   // valid image extensions
   $valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions
   // rename uploading image
   $userpic = rand(1000,1000000).".".$imgExt;
   // allow valid image file formats
   if(in_array($imgExt, $valid_extensions)){   
    // Check file size '5MB'
    if($imgSize < 5000000)    {
     move_uploaded_file($tmp_dir,$upload_dir.$userpic);
    }
    else{
     $errMSG = "El tamaño de la imagen es muy grande.";
    }
   }
   else{
    $errMSG = "Solo subir archivos JPG, JPEG, PNG & GIF.";  
   }
  }
  // sin errores
  if(!isset($errMSG))
  {
   $stmt = $DB_con->prepare('INSERT INTO imagenes(imagen,nombre,descripcion) VALUES(:imagen, :nombre, :descri)');
   $stmt->bindParam(':imagen',$userpic);
   $stmt->bindParam(':nombre',$nombre);
   $stmt->bindParam(':descri',$descri);
   if($stmt->execute())
   {
    $successMSG = "Se guardo correctamente ...";
    header("refresh:1;principal.php"); // Recarga página
   }
   else
   {
    $errMSG = "Error al insertar la imagen....";
   }
  }
 }
?>
<html>
<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
   <!-- JavaScript Bundle with Popper -->
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
   <title>Agregar foto</title>
</head>
<body>
<div class="container-lg">
   <form method="post" enctype="multipart/form-data" class="form-horizontal">
       <table class="table table-bordered table-responsive">
          <tr>
           <td><label class="control-label">Nombre Imagen</label></td>
              <td><input class="form-control" type="text" name="nombre" placeholder="Nombre Imagen" value="" /></td>
          </tr>
          <tr>
           <td><label class="control-label">Descripción de  Imagen</label></td>
              <td><input class="form-control" type="text" name="descri" placeholder="Descripción"  /></td>
          </tr>
          <tr>
           <td><label class="control-label">Imagen</label></td>
              <td><input class="input-group" type="file" name="imagen" accept="image/*" /></td>
          </tr>
          <tr>
              <td colspan="2"><button type="submit" name="btnsave"  class="btn btn-danger">
              <span class="glyphicon glyphicon-save"></span> &nbsp; Subir
              </button>
              </td>
          </tr>
          </table>
   </form>
</div>
</body>
</html>