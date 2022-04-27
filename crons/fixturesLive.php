<?php
$connect = new mysqli("184.168.99.250", "neerajmalkani", "secure@MySQL", "cricketdb"); //Connect PHP to MySQL Database
$service_url = "https://cricket.sportmonks.com/api/v2.0/livescores?api_token=9zC8IKVOFPGJyGkyrGk9n1eEpSEeDIyjWqprJYO9vMZ5Yyo9HSgfmWc0y7U7";
$curl = curl_init($service_url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$fixturesList = curl_exec($curl);
curl_close($curl);
$fixturesList = json_decode($fixturesList);
$array = (array) $fixturesList->data;
$query = "";
$query .= "TRUNCATE TABLE FixtureLive;";
foreach ($array as $row) {
  $fid = (is_null($row->id) ? "NULL" : $row->id);
  $query .= "INSERT INTO FixtureLive (id) VALUES ($fid);";
}

//echo $query;

if ($connect->multi_query($query) === TRUE) {
  echo "New records created successfully";
} else {
  echo "Error: " . $query . "<br>" . $connect->error;
}
