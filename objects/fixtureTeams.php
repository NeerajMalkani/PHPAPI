<?php
class FixtureTeams
{

    // database connection and table name
    private $conn;

    // object properties
    public $id;
    public $lineupteam_id;
    public $primary_color;
    public $secondary_color;
    public $firstname;
    public $lastname;
    public $image_path;
    public $battingstyle;
    public $bowlingstyle;
    public $positionname;
    public $lineupcaptain;
    public $lineupwicketkeeper;
    public $lineupsubstitution;

    // constructor with $db as database connection
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // read continents
    function GetFixtureTeams($fixture_id)
    {

        // select all query
        $query = "SELECT FixtureLineup.id, 
        lineupteam_id,
        (Select primary_color from Teams where id = FixtureLineup.lineupteam_id LIMIT 1) as primary_color,
        (Select secondary_color from Teams where id = FixtureLineup.lineupteam_id LIMIT 1) as secondary_color,
        firstname, 
        lastname, 
        FixtureLineup.image_path, 
        battingstyle, 
        bowlingstyle, 
        positionname, 
        lineupcaptain, 
        lineupwicketkeeper, 
        lineupsubstitution 
        FROM FixtureLineup
        WHERE fixture_id=" . $fixture_id;

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }
}
