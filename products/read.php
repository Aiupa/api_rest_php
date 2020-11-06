<?php
// Headers requis
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Method GET
if($_SERVER['REQUEST_METHOD'] == 'GET'){
    // database & methods
    include_once '../config/Database.php';
    include_once '../models/Products.php';

    // database
    $database = new Database();
    $db = $database->getConnection();

    // products
    $item = new Products($db);

    // data
    $stmt = $item->read();

    // if product >= 1
    if($stmt->rowCount() > 0){
        // array
        $arrayItems = [];
        $arrayItems['produits'] = [];
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);

            $prod = [
                "id" => $id,
                "name" => $name,
                "description" => $description,
                "price" => $price,
                "categories_id" => $categories_id,
                "categories_name" => $categories_name
            ];

            $arrayItems['produits'][] = $prod;
        }

        // code 200 OK
        http_response_code(200);

        // JSON Encode
        echo json_encode($arrayItems);
    }

} else {
    // error
    http_response_code(405);
    echo json_encode(["message" => "La méthode n'est pas autorisée"]);
}