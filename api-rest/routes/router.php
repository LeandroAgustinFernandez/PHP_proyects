<?php
$arrayRoutes = explode('/', $_SERVER['REQUEST_URI']);
// echo "<pre>".print_r($arrayRoutes)."</pre>";
if (count(array_filter($arrayRoutes)) == 2) {
    $json = array("Detail" => "Not found");
    echo json_encode($json);
    return;
} else {
    if (count(array_filter($arrayRoutes)) === 3) {
        if ($arrayRoutes[3] === 'courses') {
            $courses = new CoursesController();
            if (isset($_SERVER['REQUEST_METHOD'])) {
                if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                    $courses->index();
                } else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $params = array(
                        "title" => $_POST["title"],
                        "description" => $_POST["description"],
                        "instructor" => $_POST["instructor"],
                        "image" => $_POST["image"],
                        "price" => $_POST["price"],
                        "id_creator" => $_POST["id_creator"]
                    );
                    $courses->create($params);
                }
            }
        };
        if ($arrayRoutes[3] === 'clients') {
            $clients = new ClientsController();
            if (isset($_SERVER['REQUEST_METHOD'])) {
                if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                    $clients->index();
                } else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $params = array(
                        "first_name" => $_POST['first_name'],
                        "last_name" => $_POST['last_name'],
                        "email" => $_POST['email']
                    );
                    $clients->create($params);
                }
            }
        };
    } else if (count(array_filter($arrayRoutes)) === 4) {
        if ($arrayRoutes[3] === 'courses' && is_numeric($arrayRoutes[4])) {
            $id = $arrayRoutes[4];
            $courses = new CoursesController();
            if (isset($_SERVER['REQUEST_METHOD'])) {
                if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                    $courses->show($id);
                } else if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
                    $courses->delete($id);
                } else if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
                    parse_str(file_get_contents('php://input'), $params);
                    $courses->update($id, $params);
                }
            }
        };
    }
}
