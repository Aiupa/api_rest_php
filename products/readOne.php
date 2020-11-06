<?php
// Headers requis
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if($_SERVER['REQUEST_METHOD'] == 'GET'){
    include_once '../config/Database.php';
    include_once '../models/Products.php';

    $database = new Database();
    $db = $database->getConnection();
    $item = new Products($db);

    $donnees = json_decode(file_get_contents("php://input"));

    if(!empty($donnees->id)){
        $item->id = $donnees->id;

        $item->readOne();

        if($item->name != null){

            $prod = [
                "id" => $item->id,
                "name" => $item->name,
                "description" => $item->description,
                "price" => $item->price,
                "categories_id" => $item->categories_id,
                "categories_name" => $item->categories_name
            ];
            http_response_code(200);

            echo json_encode($prod);
        } else {
            http_response_code(404);
         
            echo json_encode(array("message" => "Product did not exist"));
        }
        
    }
} else {
    http_response_code(405);
    echo json_encode(["message" => "Method unauthorized"]);
}