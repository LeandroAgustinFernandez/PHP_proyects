<?php

class ClientsController
{

    function index()
    {
        $clientsModel = new ClientModel();
        $clients = $clientsModel->index('clientes');
        $json = array("Detail" => $clients);
        echo json_encode($json);
        return;
    }

    function create($params)
    {
        $errors = $this->validateInputs($params);
        if (count($errors) > 0) {
            $json = array("status" => 404, "errors" => $errors);
            echo json_encode($json);
            return;
        }
        $clientModel = new ClientModel();
        $clientExist = $clientModel->get('clientes', $params['email']);
        if ($clientExist) {
            $json = array("status" => 404, "error" => "The email already exists.");
            echo json_encode($json);
            return;
        }
        $params["id_client"] = $this->generateKey($params['last_name'] . $params['first_name'] . $params['email']);
        $params["secret_key"] = $this->generateKey($params['email'] . $params['first_name'] . $params['last_name']);
        $params["created_at"] = date('Y-m-d h:i:s');
        $params["updated_at"] = date('Y-m-d h:i:s');
        $response = $clientModel->insert('clientes', $params);
        $json = ($response) 
            ? array("payload" => $response) 
            : array("status" => 404, "payload" => "There was an error with the register.");
        echo json_encode($json);
        return;
    }

    private function validateInputs($params)
    {
        $errors = [];
        if (isset($params["first_name"])) {
            if ($params["first_name"] === "") {
                array_push($errors, ["first_name" => "The first_name is required"]);
            } else if (!preg_match(REGEX_TEXT, $params['first_name'])) {
                array_push($errors, ["first_name" => "The first_name field must be a string"]);
            }
        }
        if (isset($params["last_name"])) {
            if ($params["last_name"] === "") {
                array_push($errors, ["last_name" => "The last_name is required"]);
            } else if (!preg_match(REGEX_TEXT, $params['last_name'])) {
                array_push($errors, ["last_name" => "The last_name field must be a string"]);
            }
        }
        if (isset($params["email"])) {
            if ($params["email"] === "") {
                array_push($errors, ["email" => "The email is required"]);
            } else if (!preg_match(REGEX_EMAIL, $params['email'])) {
                array_push($errors, ["email" => "The email format isn't correct"]);
            }
        }
        return $errors;
    }

    private function generateKey($string)
    {
        return str_replace("$", "c", crypt($string, '$2a$07$afartwetsdAD52356FEDGsfhsd$'));
    }
}
