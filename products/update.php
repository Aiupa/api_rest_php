<?php
// Headers requis
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Method UPDATE
if($_SERVER['REQUEST_METHOD'] == 'PUT'){
    // database & methods
    include_once '../config/Database.php';
    include_once '../models/Products.php';

    // database
    $database = new Database();
    $db = $database->getConnection();

    // products
    $item = new Products($db);

    $donnees = json_decode(file_get_contents("php://input"));
    
    if(!empty($donnees->id) && !empty($donnees->name) && !empty($donnees->description) && !empty($donnees->price) && !empty($donnees->categories_id)){
        // Hydrate
        $item->id = $donnees->id;
        $item->name = $donnees->name;
        $item->description = $donnees->description;
        $item->price = $donnees->price;
        $item->categories_id = $donnees->categories_id;

        if($item->update()){
            // update ok
            // code 200
            http_response_code(200);
            echo json_encode(["message" => "La modification a été effectuée"]);
        } else {
            // update isnt ok
            // code 503
            http_response_code(503);
            echo json_encode(["message" => "La modification n'a pas été effectuée"]);         
        }
    }
} else {
    http_response_code(405);
    echo json_encode(["message" => "La méthode n'est pas autorisée"]);
}