<?php
include("../includes/header.php");

$id = $_GET['id'];

$database = new Basemysql();
$db = $database->connect();

$articulosModel = new Articulo($db);
$articulo = $articulosModel->get($id);

$errors = [];

if (isset($_POST['editarArticulo'])) {
    $title = trim($_POST['titulo']);
    $text = trim($_POST['texto']);

    if (empty($title) || $title === "") {
        array_push($errors, "El campo titulo es requerido.");
    }
    if (empty($text) || $text === "") {
        array_push($errors, "El campo texto es requerido.");
    }

    if (count($errors) === 0) {
        if ($_FILES['imagen']['name'] !== "") {
            $image = $_FILES['imagen']['name'];
            $imageArray = explode('.', $image);
            $random = rand(1000, 9999);
            $imageNewName = $imageArray[0] . $random . '.' . $imageArray[count($imageArray) - 1];

            $rutaFinal = "../img/articulos/$imageNewName";
            if (move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaFinal)) {
                unlink("../img/articulos/$articulo->imagen");
                $params = array(
                    "id" => $id,
                    'title' => $title,
                    'image' => $imageNewName,
                    'text' => $text,
                );

                if ($articulosModel->update($params)) {
                    $mensaje = "Articulo modificado correctamente";
                    header('Location:articulos.php?mensaje=' . urlencode($mensaje));
                };
            };
        } else {
            $params = array(
                "id" => $id,
                'title' => $title,
                'text' => $text,
            );

            if ($articulosModel->update($params)) {
                $mensaje = "Articulo modificado correctamente";
                header('Location:articulos.php?mensaje=' . urlencode($mensaje));
            };
        }
    }
}

if (isset($_POST['borrarArticulo'])) {
    if($articulosModel->delete($id)){
        $mensaje = "El articulo se elimino correctamente";
        header('Location:articulos.php?mensaje=' . urlencode($mensaje));
    }
}

?>

<div class="row">

</div>

<div class="row">
    <div class="col-sm-6">
        <h3>Editar Artículo</h3>
    </div>
</div>
<div class="row">
    <div class="col-sm-6 offset-3">
        <?php if (count($errors) > 0) { ?>
            <div class="alert alert-danger text-center" role="alert">
                <?php foreach ($errors as $error) { ?>
                    <p><?php echo $error ?></p>
                <?php } ?>
            </div>
        <?php } ?>
        <form method="POST" action="" enctype="multipart/form-data">

            <input type="hidden" name="id" value="<?php echo $articulo->id; ?>">

            <div class="mb-3">
                <label for="titulo" class="form-label">Título:</label>
                <input type="text" class="form-control" name="titulo" id="titulo" value="<?php echo $articulo->titulo; ?>">
            </div>

            <div class="mb-3">
                <img class="img-fluid img-thumbnail" src="<?php echo RUTA_FRONT ?>img/articulos/<?php echo $articulo->imagen; ?>">
            </div>

            <div class="mb-3">
                <label for="imagen" class="form-label">Imagen:</label>
                <input type="file" class="form-control" name="imagen" id="imagen" placeholder="Selecciona una imagen">
            </div>
            <div class="mb-3">
                <label for="texto">Texto</label>
                <textarea class="form-control" placeholder="Escriba el texto de su artículo" name="texto" style="height: 200px">
               <?php echo $articulo->texto; ?>
                </textarea>
            </div>

            <br />
            <button type="submit" name="editarArticulo" class="btn btn-success float-left"><i class="bi bi-person-bounding-box"></i> Editar Artículo</button>

            <button type="submit" name="borrarArticulo" class="btn btn-danger float-right"><i class="bi bi-person-bounding-box"></i> Borrar Artículo</button>
        </form>
    </div>
</div>
<?php include("../includes/footer.php") ?>