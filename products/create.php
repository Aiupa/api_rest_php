<?php
// Headers require
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Cheking method
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    // add files and database
    include_once '../config/Database.php';
    include_once '../models/Products.php';

    // database
    $database = new Database();
    $db = $database->getConnection();

    // Product instance
    $item = new Products($db);

    // got information
    $donnees = json_decode(file_get_contents("php://input"));
    
    if(!empty($donnees->nom) && !empty($donnees->description) && !empty($donnees->prix) && !empty($donnees->categories_id)){
        // data ok
        // hydrate
        $item->nom = $donnees->nom;
        $item->description = $donnees->description;
        $item->prix = $donnees->prix;
        $item->categories_id = $donnees->categories_id;

        if($item->create()){
            // create ok
            // code 201
            http_response_code(201);
            echo json_encode(["message" => "The data has been added"]);
        } else {
            // if create isnt ok
            // code 503
            http_response_code(503);
            echo json_encode(["message" => "The data has not been added"]);         
        }
    }
} else {
    // error code
    http_response_code(405);
    echo json_encode(["message" => "Method isn't authrorized"]);
}