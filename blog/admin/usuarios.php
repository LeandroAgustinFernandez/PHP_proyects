<?php include("../includes/header.php");

$database = new Basemysql();
$db = $database->connect();

$usuariosModel = new Usuario($db);
$usuarios = $usuariosModel->getAll();

?>


<div class="row">
    <div class="col-sm-6">
        <h3>Lista de Usuarios</h3>
    </div>
</div>
<div class="row mt-2 caja">
    <div class="col-sm-12">
        <?php if (isset($_GET['mensaje'])) { ?>
            <div class="alert alert-success" role="alert">
                <?php echo $_GET['mensaje']; ?>
            </div>
        <?php } ?>
        <table id="tblUsuarios" class="display" style="width:100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>Fecha de Creación</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usuarios as $usuario) { ?>
                    <tr>
                        <td><?php echo $usuario->id ?></td>
                        <td><?php echo $usuario->nombre ?></td>
                        <td><?php echo $usuario->email ?></td>
                        <td><?php echo $usuario->role ?></td>
                        <td><?php echo $usuario->fecha_creacion ?></td>
                        <td>
                            <a href="editar_usuario.php?id=<?php echo $usuario->id ?>" class="btn btn-warning"><i class="bi bi-pencil-fill"></i></a>
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
        $('#tblUsuarios').DataTable();
    });
</script>