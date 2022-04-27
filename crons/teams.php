<?php
$connect = new mysqli("184.168.99.250", "neerajmalkani", "secure@MySQL", "cricketdb"); //Connect PHP to MySQL Database
$service_url = "https://cricket.sportmonks.com/api/v2.0/teams?api_token=9zC8IKVOFPGJyGkyrGk9n1eEpSEeDIyjWqprJYO9vMZ5Yyo9HSgfmWc0y7U7";
$curl = curl_init($service_url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$team = curl_exec($curl);
curl_close($curl);
$team = json_decode($team);
$array = (array) $team->data;
$query = "";
$query .= "TRUNCATE TABLE Teams;";
foreach ($array as $row) {
  $tid = (is_null($row->id) ? "NULL" : $row->id);
  $name = "'" . $row->name . "'";
  $code = "'" . $row->code . "'";
  $image_path = "'" . $row->image_path . "'";
  $national_team = boolval(".$row->national_team.") ? 'true' : 'false';
  $country_id = (is_null($row->country_id) ? "NULL" : $row->country_id);
  $updated_at = "'" . $row->updated_at . "'";  
  $query .= "INSERT INTO Teams (id, name, code, image_path, country_id, national_team, updated_at) VALUES ($tid, $name, $code, $image_path, $country_id, $national_team, $updated_at);";
}

if ($connect->multi_query($query) === TRUE) {
  echo "New records created successfully";
} else {
  echo "Error: " . $query . "<br>" . $connect->error;
}
