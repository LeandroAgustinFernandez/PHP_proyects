<?php include("includes/header_front.php");

$errors = [];

$database = new Basemysql();
$db = $database->connect();

$usuariosModel = new Usuario($db);

if (isset($_POST['registrarse'])) {
    $name = $_POST['nombre'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmar_password = $_POST['confirmar_password'];

    if (trim($name) === "") array_push($errors, 'El campo nombre es requerido.');
    if (trim($email) === "") array_push($errors, 'El campo email es requerido.');
    if (!preg_match("/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/", trim($email))) array_push($errors, 'El campo email no cumple con el formato solicitado.');
    if (trim($password) === "") array_push($errors, 'El campo password es requerido.');
    if (trim($confirmar_password) === "") array_push($errors, 'El campo confirmar password es requerido.');
    if ($password !== $confirmar_password) array_push($errors, 'Confirmar password no coincide con el password proporcionado.');

    if (count($errors) === 0) {
        $userExist = $usuariosModel->getByEmail($email);
        if (!empty($userExist[0]->email)) {
            array_unshift($errors, 'El email ya existe');
        } else {
            $cryptPassword = md5($password);
            $params = array(
                'name' => $name,
                'email' => $email,
                'password' => $cryptPassword,
            );

            if ($usuariosModel->create($params)) {
                $mensaje = "El registro fue exitoso!";
            };
        };
    }
}

?>

<div class="container-fluid">
    <h1 class="text-center">Registro de Usuarios</h1>
    <div class="row">
        <div class="col-sm-6 offset-3">
            <div class="card">
                <div class="card-header">
                    Regístrate para poder comentar
                </div>
                <div class="card-body">
                    <?php if (isset($mensaje)) { ?>
                        <div class="alert alert-success text-center" role="alert">
                            <?php echo $mensaje; ?>
                        </div>
                    <?php } ?>
                    <?php if (count($errors) > 0) { ?>
                        <div class="alert alert-danger text-center" role="alert">
                            <?php foreach ($errors as $error) { ?>
                                <span></span><?php echo $error ?></span><br>
                            <?php } ?>
                        </div>
                    <?php } ?>
                    <form method="POST" action="">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre:</label>
                            <input type="text" class="form-control" name="nombre" placeholder="Ingresa el nombre">
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email:</label>
                            <input type="email" class="form-control" name="email" placeholder="Ingresa el email">
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password:</label>
                            <input type="password" class="form-control" name="password" placeholder="Ingresa el password">
                        </div>

                        <div class="mb-3">
                            <label for="confirmarPassword" class="form-label">Confirmar password:</label>
                            <input type="password" class="form-control" name="confirmar_password" placeholder="Ingresa la confirmación del password">
                        </div>

                        <br />
                        <button type="submit" name="registrarse" class="btn btn-primary w-100"><i class="bi bi-person-bounding-box"></i> Registrarse</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
<?php include("includes/footer.php") ?>