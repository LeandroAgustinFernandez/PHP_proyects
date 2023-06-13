<?php include("../includes/header.php");

$errors = [];
$id = $_GET['id'];

$database = new Basemysql();
$db = $database->connect();

$comentariosModel = new Comentario($db);
$comentario = $comentariosModel->get($id);

if (isset($_POST['editarComentario'])) {
    if (!isset($_POST['cambiarEstado']) || $_POST['cambiarEstado'] === '') {
        array_push($errors, 'Debe seleccionar un estado para el comentario.');
    }
    if(count($errors) === 0) {
        $params = array(
            'id'=>$id,
            'state' => $_POST['cambiarEstado']
        );
        $response = $comentariosModel->update($params);
        if ($response) {
            $mensaje = "Comentario modificado correctamente";
            header("Location:comentarios.php?mensaje=$mensaje");
        } else {
            array_push($errors, $response);
        }
    }
}

if (isset($_POST['borrarComentario'])) {
    $response = $comentariosModel->delete($id);
    if ($response) {
        $mensaje = "Comentario eliminado correctamente";
        header("Location:comentarios.php?mensaje=$mensaje");
    } else {
        array_push($errors, $response);
    }
}
?>

<div class="row">

</div>

<div class="row">
    <div class="col-sm-6">
        <h3>Editar Comentario</h3>
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
        <form method="POST" action="">
            <input type="hidden" name="id" value="<?php echo $comentario->id ?>">

            <div class="mb-3">
                <label for="texto">Texto</label>
                <textarea class="form-control" placeholder="Escriba el texto de su artículo" name="texto" style="height: 200px" readonly>
                <?php echo $comentario->comentario ?>
                </textarea>
            </div>

            <div class="mb-3">
                <label for="usuario" class="form-label">Usuario:</label>
                <input type="text" class="form-control" value="<?php echo $comentario->email ?>" readonly>
            </div>

            <div class="mb-3">
                <label for="cambiarEstado" class="form-label">Cambiar estado:</label>
                <select class="form-select" name="cambiarEstado" aria-label="Default select example">
                    <option value="">--Seleccionar una opción--</option>
                    <option value="1" <?php echo ($comentario->estado === 1) ? 'selected' : ''; ?>>Aprobado</option>
                    <option value="0" <?php echo ($comentario->estado === 0) ? 'selected' : ''; ?>>No Aprobado</option>
                </select>
            </div>

            <br />
            <button type="submit" name="editarComentario" class="btn btn-success float-left"><i class="bi bi-person-bounding-box"></i> Editar Comentario</button>

            <button type="submit" name="borrarComentario" class="btn btn-danger float-right"><i class="bi bi-person-bounding-box"></i> Borrar Comentario</button>
        </form>
    </div>
</div>
<?php include("../includes/footer.php") ?>