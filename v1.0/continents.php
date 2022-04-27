<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and object files
include_once '../config/database.php';
include_once '../objects/continents.php';

// instantiate database and product object
$database = new Database();
$db = $database->getConnection();

// initialize object
$continents = new Continents($db);

$stmt = $continents->GetContinents();
$num = $stmt->rowCount();

// check if more than 0 record found
if($num>0){

    // products array
    $continents_arr=array();
    $continents_arr["status"]="success";
    $continents_arr["message"]="success";
    $continents_arr["records"]=array();
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);

        $continents_item=array(
            "id" => $id,
            "name" => $name,
            "updated_at" => $updated_at
        );

        array_push($continents_arr["records"], $continents_item);
    }

    // set response code - 200 OK
    http_response_code(200);

    // show products data in json format
    echo json_encode($continents_arr);
} else{

    // set response code - 404 Not found
    http_response_code(404);

    // tell the user no products found
    echo json_encode(
        array("message" => "No continents found.")
    );
}
