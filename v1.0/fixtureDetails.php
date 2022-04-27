<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and object files
include_once '../config/database.php';
include_once '../objects/fixtureDetails.php';

// instantiate database and product object
$database = new Database();
$db = $database->getConnection();

// initialize object
$fixture_details = new FixtureDetails($db);

$stmt = $fixture_details->GetFixtureDetails(strval($_GET['fixture_id']));
$num = $stmt->rowCount();

// check if more than 0 record found
if ($num > 0) {

    // products array
    $fixtures_arr = array();
    $fixtures_arr["status"] = "success";
    $fixtures_arr["message"] = "success";
    $fixtures_arr["records"] = array();
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);

        $fixtures_item = array(
            "id" => $id,
            "is_live" => $is_live,
            "league_name" => $league_name,
            "league_image" => $league_image,
            "match_name" => $match_name,
            "localteam_id" => $localteam_id,
            "local_team_name" => $local_team_name,
            "local_team_code" => $local_team_code,
            "local_team_flag" => $local_team_flag,
            "local_team_score" => $local_team_score,
            "local_team_overs" => $local_team_overs,
            "local_team_wickets" => $local_team_wickets,
            "local_team_inning" => $local_team_inning,
            "visitorteam_id" => $visitorteam_id,
            "visitor_team_name" => $visitor_team_name,
            "visitor_team_code" => $visitor_team_code,
            "visitor_team_flag" => $visitor_team_flag,
            "visitor_team_score" => $visitor_team_score,
            "visitor_team_overs" => $visitor_team_overs,
            "visitor_team_wickets" => $visitor_team_wickets,
            "visitor_team_inning" => $visitor_team_inning,
            "toss_won_team" => $toss_won_team,
            "elected" => $elected,
            "type" => $type,
            "status" => $status,
            "note" => $note,
            "starting_at" => $starting_at,
            "first_umpire" => $first_umpire,
            "second_umpire" => $second_umpire,
            "tv_umpire" => $tv_umpire,
            "referee" => $referee,
            "venue_name" => $venue_name,
            "venue_city" => $venue_city,
            "venue_image" => $venue_image,
            "venue_capacity" => $venue_capacity
        );

        array_push($fixtures_arr["records"], $fixtures_item);
    }

    // set response code - 200 OK
    http_response_code(200);

    // show products data in json format
    echo json_encode($fixtures_arr);
} else {

    // set response code - 404 Not found
    http_response_code(404);

    // tell the user no products found
    echo json_encode(
        array("message" => "No Fixtures found.")
    );
}
