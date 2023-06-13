<?php include("../includes/header.php");
$errors = [];

if (isset($_POST['crearArticulo'])) {
    $database = new Basemysql();
    $db = $database->connect();

    $title = trim($_POST['titulo']);
    $text = trim($_POST['texto']);

    if ($_FILES['imagen']['error'] > 0) {
        array_push($errors, "Debe seleccionar un archivo.");
    }
    if (empty($title) || $title === "") {
        array_push($errors, "El campo titulo es requerido.");
    }
    if (empty($text) || $text === "") {
        array_push($errors, "El campo texto es requerido.");
    }

    if (count($errors) === 0) {
        $image = $_FILES['imagen']['name'];
        $imageArray = explode('.', $image);
        $random = rand(1000, 9999);
        $imageNewName = $imageArray[0] . $random . '.' . $imageArray[count($imageArray) - 1];

        $rutaFinal = "../img/articulos/$imageNewName";
        if (move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaFinal)) {
            $params = array(
                'title' => $title,
                'image' => $imageNewName,
                'text' => $text,
            );

            $articuloModel = new Articulo($db);
            if ($articuloModel->create($params)) {
                $mensaje = "Articulo creado correctamente";
                header('Location:articulos.php?mensaje=' . urlencode($mensaje));
            };
        };
    }
}


?>

<div class="row">

</div>

<div class="row">
    <div class="col-sm-6">
        <h3>Crear un Nuevo Artículo</h3>
    </div>
</div>
<div class="row">
    <div class="col-sm-6 offset-3">
        <?php if (count($errors) > 0) { ?>
            <div class="alert alert-danger text-center" role="alert">
                    <?php foreach ($errors as $error) { ?>
                        <span></span><?php echo $error ?></span><br>
                    <?php } ?>
            </div>
        <?php } ?>
        <form method="POST" action="" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="titulo" class="form-label">Título:</label>
                <input type="text" class="form-control" name="titulo" id="titulo" placeholder="Ingresa el título">
            </div>
            <div class="mb-3">
                <label for="imagen" class="form-label">Imagen:</label>
                <input type="file" class="form-control" name="imagen" id="apellidos" placeholder="Selecciona una imagen">
            </div>
            <div class="mb-3">
                <label for="texto">Texto</label>
                <textarea class="form-control" placeholder="Escriba el texto de su artículo" name="texto" style="height: 200px"></textarea>
            </div>

            <br />
            <button type="submit" name="crearArticulo" class="btn btn-primary w-100"><i class="bi bi-person-bounding-box"></i> Crear Nuevo Artículo</button>
        </form>
    </div>
</div>
<?php include("../includes/footer.php") ?>