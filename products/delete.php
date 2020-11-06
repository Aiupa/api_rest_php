<?php
// Headers requis
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Verify if we using correctly DELETE
if($_SERVER['REQUEST_METHOD'] == 'DELETE'){
    // include database & methods
    include_once '../config/Database.php';
    include_once '../models/Products.php';

    // database
    $database = new Database();
    $db = $database->getConnection();

    // products
    $item = new Products($db);

    // Got product's id
    $donnees = json_decode(file_get_contents("php://input"));

    if(!empty($donnees->id)){
        $item->id = $donnees->id;

        if($item->delete()){
            // if DELETE is ok
            // code 200
            http_response_code(200);
            echo json_encode(["message" => "Delete : Done"]);
        } else {
            // if delete isnt made
            // code 503
            http_response_code(503);
            echo json_encode(["message" => "Delete was not made"]);         
        }
    }
} else {
    // error
    http_response_code(405);
    echo json_encode(["message" => "La méthode n'est pas autorisée"]);
}