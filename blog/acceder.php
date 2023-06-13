<?php include("includes/header_front.php");
$errors = [];

$database = new Basemysql();
$db = $database->connect();

$usuariosModel = new Usuario($db);
if (isset($_POST['acceder'])) {
    if (!isset($_POST['email']) || trim($_POST['email']) === "") array_push($errors, 'El campo email es requerido.');
    if (!isset($_POST['password']) || trim($_POST['password']) === "") array_push($errors, 'El campo password es requerido.');
    if (count($errors) === 0) {
        $params = array(
            'email' => $_POST['email'],
            'password' => md5($_POST['password'])
        );
        if ($usuariosModel->login($params)) {
            $_SESSION['autenticado'] = true;
            $_SESSION['email'] = $_POST['email'];

            echo "<script> location.href = '" . RUTA_FRONT . "'</script>";
        }
    }
}

?>


<div class="container-fluid">
    <h1 class="text-center">Acceso de Usuarios</h1>
    <div class="row">
        <div class="col-sm-6 offset-3">
            <div class="card">
                <div class="card-header">
                    Ingresa tus datos para acceder
                </div>
                <div class="card-body">
                    <?php if (count($errors) > 0) { ?>
                        <div class="alert alert-danger text-center" role="alert">
                            <?php foreach ($errors as $error) { ?>
                                <span></span><?php echo $error ?></span><br>
                            <?php } ?>
                        </div>
                    <?php } ?>
                    <form method="POST" action="">



                        <div class="mb-3">
                            <label for="email" class="form-label">Email:</label>
                            <input type="email" class="form-control" name="email" placeholder="Ingresa el email">
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password:</label>
                            <input type="password" class="form-control" name="password" placeholder="Ingresa el password">
                        </div>

                        <br />
                        <button type="submit" name="acceder" class="btn btn-primary w-100"><i class="bi bi-person-bounding-box"></i> Acceder</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
<?php include("includes/footer.php") ?>