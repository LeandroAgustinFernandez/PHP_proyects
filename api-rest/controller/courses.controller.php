<?php

class CoursesController
{
    function index()
    {
        if (isset($_SERVER['PHP_AUTH_USER']) && $_SERVER['PHP_AUTH_PW']) {
            if ($this->isAuthorized([
                "id_client" => $_SERVER['PHP_AUTH_USER'],
                "secret_key" => $_SERVER['PHP_AUTH_PW']
            ])) {
                $courseModel = new CoursesModel();
                $courses = $courseModel->index('cursos');
                $json = array("total_courses" => count($courses), "courses" => $courses);
                echo json_encode($json, true);
                return;
            } else {
                $json = array("status" => 403, "error" => "Wrong credentials");
                echo json_encode($json, true);
                return;
            }
        }
        $json = array("status" => 401, "error" => "You don't have authorization");
        echo json_encode($json, true);
        return;
    }

    function show($id)
    {
        if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])) {
            if ($this->isAuthorized(["id_client" => $_SERVER['PHP_AUTH_USER'], "secret_key" => $_SERVER['PHP_AUTH_PW']])) {
                $courseModel = new CoursesModel();
                $course = $courseModel->getById('cursos', $id);
                if (!$course) {
                    $json = array("status" => 404, "error" => "The course doesn't exist");
                } else {
                    $json = array("status" => 200, "course" => $course);
                }
                echo json_encode($json);
                return;
            } else {
                $json = array("status" => 403, "error" => "Wrong credentials.");
                echo json_encode($json, true);
                return;
            }
        }
        $json = array("status" => 401, "error" => "You don't have authorization");
        echo json_encode($json, true);
        return;
    }

    function create($params)
    {
        if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])) {
            if ($this->isAuthorized([
                "id_client" => $_SERVER['PHP_AUTH_USER'],
                "secret_key" => $_SERVER['PHP_AUTH_PW']
            ])) {
                $errors = $this->validateInputs($params);
                if (count($errors)) {
                    $json = array("status" => 404, "errors" => $errors);
                    echo json_encode($json);
                    return;
                }
                $courseModel = new CoursesModel();
                $course = $courseModel->getByTitle('cursos', $params['title']);
                if ($course) {
                    $json = array("status" => 404, "error" => "The course already exists");
                    echo json_encode($json, true);
                    return;
                }
                $params["created_at"] = date("Y-m-d h:i:s");
                $params["updated_at"] = date("Y-m-d h:i:s");
                $response = $courseModel->insert('cursos', $params);
                $json = ($response)
                    ? array("payload" => $response)
                    : array("status" => 500, "payload" => "There was an error creating the course.");
                echo json_encode($json);
                return;
            } else {
                $json = array("status" => 403, "error" => "Wrong credentials");
                echo json_encode($json, true);
                return;
            }
        }
        $json = array("status" => 401, "error" => "You don't have authorization");
        echo json_encode($json, true);
        return;
    }

    function delete($id)
    {
        if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])) {
            if ($this->isAuthorized(["id_client" => $_SERVER['PHP_AUTH_USER'], "secret_key" => $_SERVER['PHP_AUTH_PW']])) {
                $courseModel = new CoursesModel();
                $course = $courseModel->getById('cursos', $id);
                if (!$course) {
                    $json = array("status" => 404, "error" => "The course doesn't exist");
                }
                $response = $courseModel->delete('cursos',$id);
                $json = array("payload"=>$response);
                echo json_encode($json);
                return;
            } else {
                $json = array("status" => 403, "error" => "Wrong credentials.");
                echo json_encode($json, true);
                return;
            }
        }
        $json = array("status" => 401, "error" => "You don't have authorization");
        echo json_encode($json, true);
        return;
        $json = array("Detail" => "Courses View => DELETE METHOD => $id");
        echo json_encode($json);
        return;
    }

    function update($id, $params)
    {
        if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])) {
            if ($this->isAuthorized([
                "id_client" => $_SERVER['PHP_AUTH_USER'],
                "secret_key" => $_SERVER['PHP_AUTH_PW']
            ])) {
                $errors = $this->validateInputs($params);
                if (count($errors)) {
                    $json = array("status" => 404, "errors" => $errors);
                    echo json_encode($json);
                    return;
                }
                $courseModel = new CoursesModel();
                $course = $courseModel->getByTitle('cursos', $params['title']);
                if ($course && $course['id'] !== $id) {
                    $json = array("status" => 404, "error" => "The course already exists");
                    echo json_encode($json, true);
                    return;
                }
                $params["updated_at"] = date("Y-m-d h:i:s");
                $response = $courseModel->update('cursos', $id, $params);
                $json = ($response)
                    ? array("payload" => $response)
                    : array("status" => 500, "payload" => "There was an error updating the course.");
                echo json_encode($json);
                return;
            } else {
                $json = array("status" => 403, "error" => "Wrong credentials");
                echo json_encode($json, true);
                return;
            }
        }
        $json = array("status" => 401, "error" => "You don't have authorization");
        echo json_encode($json, true);
        return;
    }

    private function isAuthorized($credentials)
    {
        $clientModel = new ClientModel();
        $client = $clientModel->getByCredentials('clientes', $credentials);
        return $client;
    }

    private function validateInputs($params)
    {
        $errors = [];
        foreach ($params as $key => $value) {
            if ($value === "") {
                array_push($errors, ["$key" => "The $key field is required"]);
            }
        }
        if (!preg_match(REGEX_ALLCHAR, trim($params["title"]))) {
            array_push($errors, ["title" => "The title don't have a valid format"]);
        }
        if (!preg_match(REGEX_ALLCHAR, trim($params["description"]))) {
            array_push($errors, ["description" => "The description don't have a valid format"]);
        }
        if (!preg_match(REGEX_TEXT, trim($params["instructor"]))) {
            array_push($errors, ["instructor" => "The instructor don't have a valid format"]);
        }
        if (!preg_match(REGEX_ALLCHAR, trim($params["image"]))) {
            array_push($errors, ["image" => "The image don't have a valid format"]);
        }
        if (!preg_match(REGEX_ALLCHAR, trim($params["price"]))) {
            array_push($errors, ["price" => "The price don't have a valid format"]);
        }
        if (!preg_match(REGEX_NUMBERS, trim($params["id_creator"]))) {
            array_push($errors, ["id_creator" => "The id_creator don't have a valid format"]);
        }
        return $errors;
    }
}
