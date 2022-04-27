<?php
class FixtureDetails
{

    // database connection and table name
    private $conn;

    // object properties
    public $id;
    public $is_live;
    public $league_name;
    public $league_image;
    public $match_name;
    public $localteam_id;
    public $local_team_name;
    public $local_team_code;
    public $local_team_flag;
    public $local_team_score;
    public $local_team_overs;
    public $local_team_wickets;
    public $local_team_inning;
    public $visitorteam_id;
    public $visitor_team_name;
    public $visitor_team_code;
    public $visitor_team_flag;
    public $visitor_team_score;
    public $visitor_team_overs;
    public $visitor_team_wickets;
    public $visitor_team_inning;
    public $toss_won_team;
    public $elected;
    public $type;
    public $status;
    public $note;
    public $starting_at;
    public $first_umpire;
    public $second_umpire;
    public $tv_umpire;
    public $referee;
    public $venue_name;
    public $venue_city;
    public $venue_image;
    public $venue_capacity;

    // constructor with $db as database connection
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // read continents
    function GetFixtureDetails($fixture_id)
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
                  Fixtures.elected,

                  Fixtures.type,
                  Fixtures.status,
                  Fixtures.note,
                  Fixtures.starting_at,

                  (SELECT fullname FROM Officials WHERE id = Fixtures.first_umpire_id LIMIT 0, 1) As first_umpire,
                  (SELECT fullname FROM Officials WHERE id = Fixtures.second_umpire_id LIMIT 0, 1) As second_umpire,
                  (SELECT fullname FROM Officials WHERE id = Fixtures.tv_umpire_id LIMIT 0, 1) As tv_umpire,
                  (SELECT fullname FROM Officials WHERE id = Fixtures.referee_id LIMIT 0, 1) As referee,

                  (SELECT name FROM Venues WHERE id = Fixtures.venue_id LIMIT 0, 1) As venue_name,
    			  (SELECT city FROM Venues WHERE id = Fixtures.venue_id LIMIT 0, 1) As venue_city,
    			  (SELECT image_path FROM Venues WHERE id = Fixtures.venue_id LIMIT 0, 1) As venue_image,
     			  (SELECT capacity FROM Venues WHERE id = Fixtures.venue_id LIMIT 0, 1) As venue_capacity

                  FROM Fixtures
                  WHERE id= " . $fixture_id;

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }
}
