<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and object files
include_once '../config/database.php';
include_once '../objects/fixtureScorecard.php';

// instantiate database and product object
$database = new Database();
$db = $database->getConnection();

// initialize object
$fixture_scorecard = new FixtureScorecards($db);

//if(strval($_GET['type']) == "bat") {
    $stmt = $fixture_scorecard->GetFixtureScorecardBatting(strval($_GET['fixture_id']));
//} 
// else if(strval($_GET['type']) == "bowl") {
//     $stmt = $fixture_scorecard->GetFixtureScorecardBowling(strval($_GET['fixture_id']));      
// }
$num = $stmt->rowCount();
echo $num

// // check if more than 0 record found
// if ($num > 0) {

//     // products array
//     $fixtures_scorecard_arr = array();
//     $fixtures_scorecard_arr["status"] = "success";
//     $fixtures_scorecard_arr["message"] = "success";
//     $fixtures_scorecard_arr["records"] = array();
//     // retrieve our table contents
//     // fetch() is faster than fetchAll()
//     // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
//     while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
//         // extract row
//         // this will make $row['name'] to
//         // just $name only
//         extract($row);
//         $fixtures_scorecard_item = array();
//     if(strval($_GET['type']) == "bat") {
//         $fixtures_scorecard_item = array(
//             "fixture_id" => $fixture_id,
//             "team_name" => $team_name,
//             "team_flag" => $team_flag,
//             "innings" => $innings,
//             "batsman_player_name" => $batsman_player_name,
//             "bowler_player_name" => $bowler_player_name,
//             "ball" => $ball,
//             "score" => $score,
//             "four_x" => $four_x,
//             "six_x" => $six_x,
//             "fow_score" => $fow_score,
//             "fow_balls" => $fow_balls,
//             "rate" => $rate,
//             "catch_stump_player_name" => $catch_stump_player_name,
//             "how_out" => $how_out
//         );
//     } else if(strval($_GET['type']) == "bowl") {
//         $fixtures_scorecard_item = array(
//             "fixture_id" => $fixture_id,
//             "team_name" => $team_name,
//             "team_flag" => $team_flag,
//             "innings" => $innings,
//             "bowler_player_name" => $bowler_player_name,
//             "overs" => $overs,
//             "medians" => $medians,
//             "runs" => $runs,
//             "wickets" => $wickets,
//             "wide" => $wide,
//             "noball" => $fow_balls,
//             "rate" => $rate
//         );
//     }

//         array_push($fixtures_scorecard_arr["records"], $fixtures_scorecard_item);
//     }

//     // set response code - 200 OK
//     http_response_code(200);

//     // show products data in json format
//     echo json_encode($fixtures_scorecard_arr);
// } else {

//     // set response code - 404 Not found
//     http_response_code(404);

//     // tell the user no products found
//     echo json_encode(
//         array("message" => "No Fixture Scorecard found.")
//     );
// }
