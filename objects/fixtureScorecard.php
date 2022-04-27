<?php
class FixtureScorecards
{

    // database connection and table name
    private $conn;

    // object properties
    public $fixture_id;
    public $team_name;
    public $team_flag;
    public $innings;
    public $batsman_player_name;
    public $bowler_player_name;
    public $ball;
    public $score;
    public $four_x;
    public $six_x;
    public $fow_score;
    public $fow_balls;
    public $rate;
    public $catch_stump_player_name;
    public $how_out;

    public $overs;
    public $medians;
    public $runs;
    public $wickets;
    public $wide;
    public $noball;

    // constructor with $db as database connection
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // read scorecard
    function GetFixtureScorecardBatting($fixture_id)
    {
        // select all query
        $query = "SELECT 
        fixture_id,
        (Select name from Teams where id = team_id Limit 1) As team_name,
        (Select image_path from Teams where id = team_id Limit 1) As team_flag,
        scoreboard As innings,
        (Select fullname from Players where id = player_id Limit 1) As batsman_player_name,
        (Select fullname from Players where id = bowling_player_id Limit 1) As bowler_player_name,
        ball,
        score,
        four_x,
        six_x,
        fow_score,
        fow_balls,
        rate,
        (Select fullname from Players where id = catch_stump_player_id Limit 1) As catch_stump_player_name,
        (Select name from Scores where id = score_id Limit 1) As how_out
        FROM FixtureBatting 
        where fixture_id=" . $fixture_id;

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }

    function GetFixtureScorecardBowling($fixture_id)
    {
        // select all query
        $query = "SELECT 
        fixture_id,
        (Select name from Teams where id = team_id Limit 1) As team_name,
        (Select image_path from Teams where id = team_id Limit 1) As team_flag,
        scoreboard As innings,
        (Select fullname from Players where id = player_id Limit 1) As bowler_player_name,
        overs,
        medians,
        runs,
        wickets,
        wide,
        noball,
        rate
        FROM FixtureBowling 
        where fixture_id=" . $fixture_id;

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }
}
