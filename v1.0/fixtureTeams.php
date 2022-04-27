<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and object files
include_once '../config/database.php';
include_once '../objects/fixtureTeams.php';

// instantiate database and product object
$database = new Database();
$db = $database->getConnection();

// initialize object
$fixture_teams = new FixtureTeams($db);

$stmt = $fixture_teams->GetFixtureTeams(strval($_GET['fixture_id']));
$num = $stmt->rowCount();

// check if more than 0 record found
if ($num > 0) {

    // products array
    $fixtures_teams_arr = array();
    $fixtures_teams_arr["status"] = "success";
    $fixtures_teams_arr["message"] = "success";
    $fixtures_teams_arr["records"] = array();
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);

        $fixtures_teams_item = array(
            "id" => $id,
            "lineupteam_id" => $lineupteam_id,
            "primary_color" => $primary_color,
            "secondary_color" => $secondary_color,
            "country_id" => $country_id,
            "league_image" => $league_image,
            "firstname" => $firstname,
            "lastname" => $lastname,
            "image_path" => $image_path,
            "battingstyle" => $battingstyle,
            "bowlingstyle" => $bowlingstyle,
            "positionname" => $positionname,
            "lineupcaptain" => $lineupcaptain,
            "lineupwicketkeeper" => $lineupwicketkeeper,
            "lineupsubstitution" => $lineupsubstitution
        );

        array_push($fixtures_teams_arr["records"], $fixtures_teams_item);
    }

    // set response code - 200 OK
    http_response_code(200);

    // show products data in json format
    echo json_encode($fixtures_teams_arr);
} else {

    // set response code - 404 Not found
    http_response_code(404);

    // tell the user no products found
    echo json_encode(
        array("message" => "No Fixture Teams found.")
    );
}
