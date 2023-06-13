<?php include("includes/header_front.php");
$errors = [];
$id = $_GET['id'];

$database = new Basemysql();
$db = $database->connect();

$articulosModel = new Articulo($db);
$articulo = $articulosModel->get($id);

$usuariosModel = new Usuario($db);
$comentariosModel = new Comentario($db);
$comentarios = $comentariosModel->getByArticle($id);

if (isset($_POST['enviarComentario'])) {
    if (!isset($_POST['comentario']) || trim($_POST['comentario']) === "") array_push($errors, 'No puede enviarse un comentario vacio.');
    if (count($errors) === 0) {
        $comentario = $_POST['comentario'];
        $article_id = $_POST['articulo'];
        $usuario = $usuariosModel->getByEmail($_POST['usuario']);
        $usuario_id = $usuario[0]->id;
        $params = array(
            'coment' => $comentario,
            'article_id' => $article_id,
            'user_id' => $usuario_id,
        );

        if ($comentariosModel->create($params)) {
            $mensaje = 'El comentario se registro correctamente, pasara a revision.';
        }
    }
}

?>



<div class="container-fluid">

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h1><?php echo $articulo->titulo; ?></h1>
                </div>
                <div class="card-body">
                    <div class="text-center">
                        <img class="img-fluid img-thumbnail" src="img/articulos/<?php echo $articulo->imagen; ?>">
                    </div>
                    <p class="px-5"><?php echo $articulo->texto; ?></p>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-sm-12">
            <div class="card p-5">
                <?php if (count($errors) > 0) { ?>
                    <div class="alert alert-danger text-center" role="alert">
                        <?php foreach ($errors as $error) { ?>
                            <span><?php echo $error ?></span>
                        <?php } ?>
                    </div>
                <?php } ?>
                <?php if (isset($mensaje)) { ?>
                    <div class="alert alert-success text-center" role="alert">
                        <span><?php echo $mensaje; ?></span>
                    </div>
                <?php } ?>
                <form method="POST" action="">
                    <input type="hidden" name="articulo" value="<?php echo $articulo->id; ?>">
                    <div class="mb-3">
                        <label for="usuario" class="form-label">Usuario:</label>
                        <input type="text" class="form-control" name="usuario" id="usuario" value="<?php echo $_SESSION['email'] ?>" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="comentario">Comentario</label>
                        <textarea class="form-control" name="comentario" style="height: 200px"></textarea>
                    </div>

                    <br />
                    <button type="submit" name="enviarComentario" class="btn btn-primary w-100"><i class="bi bi-person-bounding-box"></i> Crear Nuevo Comentario</button>
                </form>
            </div>
        </div>
    </div>

</div>

<div class="row">
    <h3 class="text-center mt-5">Comentarios</h3>

    <?php foreach ($comentarios as $comentario) { ?>
        <h4><i class="bi bi-person-circle"></i> <?php echo $comentario->email; ?></h4>
        <p> <?php echo $comentario->comentario; ?></p>
    <?php  } ?>

</div>

</div>
<?php include("includes/footer.php") ?>