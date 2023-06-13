<?php include("../includes/header.php");

$database = new Basemysql();
$db = $database->connect();

$comentariosModel = new Comentario($db);
$comentarios = $comentariosModel->getAll();

?>

<div class="row">
    <div class="col-sm-6">
        <h3>Lista de Comentarios</h3>
    </div>
</div>
<div class="row mt-2 caja">
    <div class="col-sm-12">
        <?php if (isset($_GET['mensaje'])) { ?>
            <div class="alert alert-success" role="alert">
                <?php echo $_GET['mensaje']; ?>
            </div>
        <?php } ?>
        <table id="tblContactos" class="display" style="width:100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Comentario</th>
                    <th>Usuario</th>
                    <th>Artículo</th>
                    <th>Estado</th>
                    <th>Fecha de creación</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($comentarios as $comentario) { ?>
                    <tr>
                        <td> <?php echo $comentario->id; ?> </td>
                        <td> <?php echo $comentario->comentario; ?> </td>
                        <td> <?php echo $comentario->email; ?> </td>
                        <td> <?php echo $comentario->titulo; ?> </td>
                        <td> <?php echo ($comentario->estado === 1) ? 'Aprobado' : 'Pendiente'; ?> </td>
                        <td> <?php echo $comentario->fecha_creacion; ?> </td>
                        <td>
                            <a href="editar_comentario.php?id=<?php echo $comentario->id; ?>" class="btn btn-warning"><i class="bi bi-pencil-fill"></i></a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<?php include("../includes/footer.php") ?>

<script>
    $(document).ready(function() {
        $('#tblContactos').DataTable();
    });
</script>