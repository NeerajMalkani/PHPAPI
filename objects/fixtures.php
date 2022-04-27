<?php
class Fixtures
{

    // database connection and table name
    private $conn;
    private $table_name = "Fixtures";
    private $table_name1 = "FixtureRuns";

    // object properties
    public $id;
    public $is_live;
    public $league_name;
    public $league_image;
    public $match_name;
    public $local_team_id;
    public $local_team_name;
    public $local_team_code;
    public $local_team_flag;
    public $local_team_score;
    public $local_team_overs;
    public $local_team_wickets;
    public $local_team_inning;
    public $visitor_team_id;
    public $visitor_team_name;
    public $visitor_team_code;
    public $visitor_team_flag;
    public $visitor_team_score;
    public $visitor_team_overs;
    public $visitor_team_wickets;
    public $visitor_team_inning;
    public $toss_won_team;
    public $total_overs_played;
    public $won_id;
    public $type;
    public $status;
    public $note;
    public $elected;
    public $starting_at;

    // constructor with $db as database connection
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // read continents
    function GetFixtures()
    {

        // select all query
        $query = "SELECT
              	  Fixtures.id, 
                  (Case When EXISTS (Select id from FixtureLive where id = Fixtures.id) THEN 1 ELSE 0 END) As is_live,
              	  (SELECT name FROM Leagues WHERE id = Fixtures.league_id LIMIT 0, 1) As league_name,
                  (SELECT image_path FROM Leagues WHERE id = Fixtures.league_id LIMIT 0, 1) As league_image,
              	  Fixtures.round As match_name,
                  
                  Fixtures.localteam_id,
                  (SELECT name FROM Teams WHERE id = Fixtures.localteam_id LIMIT 0, 1) As local_team_name,
              	  (SELECT code FROM Teams WHERE id = Fixtures.localteam_id LIMIT 0, 1) As local_team_code,
                  (SELECT image_path FROM Teams WHERE id = Fixtures.localteam_id LIMIT 0, 1) As local_team_flag,
                  IFNULL((SELECT score FROM FixtureRuns WHERE FixtureRuns.fixture_id = Fixtures.id AND FixtureRuns.team_id = Fixtures.localteam_id LIMIT 0, 1),0) As local_team_score,
                  IFNULL((SELECT overs FROM FixtureRuns WHERE FixtureRuns.fixture_id = Fixtures.id AND FixtureRuns.team_id = Fixtures.localteam_id LIMIT 0, 1),0) As local_team_overs,
                  IFNULL((SELECT wickets FROM FixtureRuns WHERE FixtureRuns.fixture_id = Fixtures.id AND FixtureRuns.team_id = Fixtures.localteam_id LIMIT 0, 1),0) As local_team_wickets,
                  IFNULL((SELECT inning FROM FixtureRuns WHERE FixtureRuns.fixture_id = Fixtures.id AND FixtureRuns.team_id = Fixtures.localteam_id LIMIT 0, 1),0) As local_team_inning,
                  
                  Fixtures.visitorteam_id,
                  (SELECT name FROM Teams WHERE id = Fixtures.visitorteam_id LIMIT 0, 1) As visitor_team_name,
              	  (SELECT code FROM Teams WHERE id = Fixtures.visitorteam_id LIMIT 0, 1) As visitor_team_code,
                  (SELECT image_path FROM Teams WHERE id = Fixtures.visitorteam_id LIMIT 0, 1) As visitor_team_flag,
                  IFNULL((SELECT score FROM FixtureRuns WHERE FixtureRuns.fixture_id = Fixtures.id AND FixtureRuns.team_id = Fixtures.visitorteam_id LIMIT 0, 1),0) As visitor_team_score,
                  IFNULL((SELECT overs FROM FixtureRuns WHERE FixtureRuns.fixture_id = Fixtures.id AND FixtureRuns.team_id = Fixtures.visitorteam_id LIMIT 0, 1),0) As visitor_team_overs,
                  IFNULL((SELECT wickets FROM FixtureRuns WHERE FixtureRuns.fixture_id = Fixtures.id AND FixtureRuns.team_id = Fixtures.visitorteam_id LIMIT 0, 1),0) As visitor_team_wickets,
                  IFNULL((SELECT inning FROM FixtureRuns WHERE FixtureRuns.fixture_id = Fixtures.id AND FixtureRuns.team_id = Fixtures.visitorteam_id LIMIT 0, 1),0) As visitor_team_inning,

                  (SELECT name FROM Teams WHERE id = Fixtures.toss_won_team_id LIMIT 0, 1) As toss_won_team,
                  (CASE WHEN Fixtures.localteam_id = Fixtures.winner_team_id THEN 1 WHEN Fixtures.visitorteam_id = Fixtures.winner_team_id THEN 2 ELSE 3 END) AS won_id,

                  Fixtures.total_overs_played,  
                  Fixtures.type,
                  Fixtures.status,
                  Fixtures.note,
                  Fixtures.elected,
                  Fixtures.starting_at

                  FROM Fixtures
                  WHERE (starting_at BETWEEN DATE_SUB(UTC_Date(), INTERVAL 1 DAY) AND DATE_ADD(UTC_Date(), INTERVAL 1 DAY)) OR Fixtures.id IN (Select id from FixtureLive)
                  ORDER BY is_live desc, FIELD(status, 'NS', '1st Innings', '2nd Innings', '3rd Innings', '4th Innings', 'Stump Day 1', 'Stump Day 2', 'Stump Day 3', 'Stump Day 4', 'Innings Break', 'Tea Break', 'Lunch', 'Dinner', 'Postp.', 'Int.', 'Aban.', 'Delayed', 'Cancl.', 'Finished'), FIELD(type, 'ODI', 'T20I', 'Test/5day', 'T20', 'Test', 'T10', '4day'), starting_at";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }

    function GetFixturesByFilter($filterStart, $filterEnd)
    {

        // select all query
        $query = "SELECT
              	  Fixtures.id,
                  (Case When EXISTS (Select id from FixtureLive where id = Fixtures.id) THEN 1 ELSE 0 END) As is_live,
              	  (SELECT name FROM Leagues WHERE id = Fixtures.league_id LIMIT 0, 1) As league_name,
                  (SELECT image_path FROM Leagues WHERE id = Fixtures.league_id LIMIT 0, 1) As league_image,
              	  Fixtures.round As match_name,

                  (SELECT name FROM Teams WHERE id = Fixtures.localteam_id LIMIT 0, 1) As local_team_name,
              	  (SELECT code FROM Teams WHERE id = Fixtures.localteam_id LIMIT 0, 1) As local_team_code,
                  (SELECT image_path FROM Teams WHERE id = Fixtures.localteam_id LIMIT 0, 1) As local_team_flag,
                  IFNULL((SELECT score FROM FixtureRuns WHERE FixtureRuns.fixture_id = Fixtures.id AND FixtureRuns.team_id = Fixtures.localteam_id LIMIT 0, 1),0) As local_team_score,
                  IFNULL((SELECT overs FROM FixtureRuns WHERE FixtureRuns.fixture_id = Fixtures.id AND FixtureRuns.team_id = Fixtures.localteam_id LIMIT 0, 1),0) As local_team_overs,
                  IFNULL((SELECT wickets FROM FixtureRuns WHERE FixtureRuns.fixture_id = Fixtures.id AND FixtureRuns.team_id = Fixtures.localteam_id LIMIT 0, 1),0) As local_team_wickets,
                  IFNULL((SELECT inning FROM FixtureRuns WHERE FixtureRuns.fixture_id = Fixtures.id AND FixtureRuns.team_id = Fixtures.localteam_id LIMIT 0, 1),0) As local_team_inning,

                  (SELECT name FROM Teams WHERE id = Fixtures.visitorteam_id LIMIT 0, 1) As visitor_team_name,
              	  (SELECT code FROM Teams WHERE id = Fixtures.visitorteam_id LIMIT 0, 1) As visitor_team_code,
                  (SELECT image_path FROM Teams WHERE id = Fixtures.visitorteam_id LIMIT 0, 1) As visitor_team_flag,
                  IFNULL((SELECT score FROM FixtureRuns WHERE FixtureRuns.fixture_id = Fixtures.id AND FixtureRuns.team_id = Fixtures.visitorteam_id LIMIT 0, 1),0) As visitor_team_score,
                  IFNULL((SELECT overs FROM FixtureRuns WHERE FixtureRuns.fixture_id = Fixtures.id AND FixtureRuns.team_id = Fixtures.visitorteam_id LIMIT 0, 1),0) As visitor_team_overs,
                  IFNULL((SELECT wickets FROM FixtureRuns WHERE FixtureRuns.fixture_id = Fixtures.id AND FixtureRuns.team_id = Fixtures.visitorteam_id LIMIT 0, 1),0) As visitor_team_wickets,
                  IFNULL((SELECT inning FROM FixtureRuns WHERE FixtureRuns.fixture_id = Fixtures.id AND FixtureRuns.team_id = Fixtures.visitorteam_id LIMIT 0, 1),0) As visitor_team_inning,

                  (SELECT name FROM Teams WHERE id = Fixtures.toss_won_team_id LIMIT 0, 1) As toss_won_team,
                  (CASE WHEN Fixtures.localteam_id = Fixtures.winner_team_id THEN 1 WHEN Fixtures.visitorteam_id = Fixtures.winner_team_id THEN 2 ELSE 3 END) AS won_id,
                  
                  Fixtures.total_overs_played,
                  Fixtures.type,
                  Fixtures.status,
                  Fixtures.note,
                  Fixtures.elected,
                  Fixtures.starting_at

                  FROM Fixtures
                  WHERE starting_at BETWEEN '" . $filterStart . "' AND '" . $filterEnd . "' OR Fixtures.id IN (Select id from FixtureLive)
                  ORDER BY is_live desc, FIELD(status, 'NS', '1st Innings', '2nd Innings', '3rd Innings', '4th Innings', 'Stump Day 1', 'Stump Day 2', 'Stump Day 3', 'Stump Day 4', 'Innings Break', 'Tea Break', 'Lunch', 'Dinner', 'Postp.', 'Int.', 'Aban.', 'Delayed', 'Cancl.', 'Finished'), FIELD(type, 'ODI', 'T20I', 'Test/5day', 'T20', 'Test', 'T10', '4day'), starting_at";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }
}
