<?php
$connect = new mysqli("184.168.99.250", "neerajmalkani", "secure@MySQL", "cricketdb"); //Connect PHP to MySQL Database
$service_url = "https://cricket.sportmonks.com/api/v2.0/players?api_token=9zC8IKVOFPGJyGkyrGk9n1eEpSEeDIyjWqprJYO9vMZ5Yyo9HSgfmWc0y7U7";
$curl = curl_init($service_url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$team = curl_exec($curl);
curl_close($curl);
$team = json_decode($team);
$array = (array) $team->data;
$query = "";
$query .= "TRUNCATE TABLE Players;";
foreach ($array as $row) {
  $pid = (is_null($row->id) ? "NULL" : $row->id);
  $country_id = (is_null($row->country_id) ? "NULL" : $row->country_id);
  $firstname = "'" . str_replace("'","\'",$row->firstname) . "'";
  $lastname = "'" . str_replace("'","\'",$row->lastname) . "'";
  $fullname = "'" . str_replace("'","\'",$row->fullname) . "'";
  $image_path = "'" . $row->image_path . "'";
  $dateofbirth = "'" . $row->dateofbirth . "'";
  $gender = "'" . $row->gender . "'";
  $battingstyle = "'" . $row->battingstyle . "'";
  $bowlingstyle = "'" . $row->bowlingstyle . "'";
  $positionid = (is_null($row->position->id) ? "NULL" : $row->position->id);
  $positionname = "'" . $row->position->name . "'";
  $updated_at = "'" . $row->updated_at . "'";  
  $query .= "INSERT INTO Players (id, country_id, firstname, lastname, fullname, image_path, dateofbirth, gender, battingstyle, positionresource, positionid, positionname, updated_at) 
  VALUES ($pid, $country_id, $firstname, $lastname, $fullname, $image_path, $dateofbirth, $gender, $battingstyle, $bowlingstyle, $positionid, $positionname, $updated_at);";
}

echo $query;

if ($connect->multi_query($query) === TRUE) {
  echo "New records created successfully";
} else {
  echo "Error: " . $query . "<br>" . $connect->error;
}