<?php

$valor = 0;
$desde = '';
$hasta = '';
$calcular = 0;

function convertir_a_metros($valor, $unidad_desde)
{
    switch ($unidad_desde) {
        case "Milimetros":
            return $valor / 1000;
            break;
        case "Centimetros":
            return $valor / 100;
            break;
        case "Decimetros":
            return $valor / 10;
            break;
        case "Metro":
            return $valor * 1;
            break;
        case "Decametro":
            return $valor * 10;
            break;
        case "Hectometro":
            return $valor * 100;
            break;
        case "Kilometro":
            return $valor * 1000;
            break;
        default:
            return "Unidad de medida no soportada";
            break;
    }
}

function convertir_desde_metros($valor, $unidad_hasta){
    switch ($unidad_hasta) {
        case "Milimetros":
            return $valor * 1000;
            break;
        case "Centimetros":
            return $valor * 100;
            break;
        case "Decimetros":
            return $valor * 10;
            break;
        case "Metro":
            return $valor * 1;
            break;
        case "Decametro":
            return $valor / 10;
            break;
        case "Hectometro":
            return $valor / 100;
            break;
        case "Kilometro":
            return $valor / 1000;
            break;
        default:
            return "Unidad de medida no soportada";
            break;
    }
}


if (isset($_POST['valor'])) {
    $valor = $_POST['valor'];
    $desde = $_POST['desde'];
    $hasta = $_POST['hasta'];
    $resultado1 = convertir_a_metros($valor,$desde);
    $calcular = convertir_desde_metros($resultado1,$hasta);
}

?>


<!doctype html>
<html lang="en">

<head>
  <title>Title</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
</head>

<body>
  <header>
  </header>
  <main class="container">
    <form method="POST" action="">
        <hastaiv class="row mt-4">
            <div class="col-sm-12">
                <div class="form-floating mb-3">
                  <input type="number" class="form-control" name="valor" id="valor" placeholder="">
                  <label for="valor">Valor</label>
                </div>    
            </div>
            <div class="col-sm-12">
                <div class="mb-3">
                    <label for="desde" class="form-label">Desde</label>
                    <select class="form-select form-select-lg" name="desde" id="desde">
                        <option value="">Select one</option>
                        <option value="Milimetros">Milimetros</option>
                        <option value="Centimetros">Centimetros</option>
                        <option value="Decimetros">Decimetros</option>
                        <option value="Metro">Metro</option>
                        <option value="Decametro">Decametro</option>
                        <option value="Hectometro">Hectometro</option>
                        <option value="Kilometro">Kilometro</option>
                    </select>
                </div>
            </div>

            <div class="col-sm-12">
                <div class="mb-3">
                    <label for="hasta" class="form-label">Hasta</label>
                    <select class="form-select form-select-lg" name="hasta" id="hasta">
                        <option value="">Select one</option>
                        <option value="Milimetros">Milimetros</option>
                        <option value="Centimetros">Centimetros</option>
                        <option value="Decimetros">Decimetros</option>
                        <option value="Metro">Metro</option>
                        <option value="Decametro">Decametro</option>
                        <option value="Hectometro">Hectometro</option>
                        <option value="Kilometro">Kilometro</option>
                    </select>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="d-grid gap-2">
                  <button type="submit" name="" id="" class="btn btn-outline-dark">Convertir</button>
                </div>
            </div>
            <div class="col-sm-6">
                   <input type="text" name="" id="input" class="form-control" value="<?php echo $calcular;?>">
            </div>
        </div>
    </form>
    
  </main>
  <footer>
  </footer>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
    integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"
    integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
  </script>
</body>

</html>