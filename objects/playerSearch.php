<?php
class PlayerSearch
{

    // database connection and table name
    private $conn;
    private $table_name = "Players";

    // object properties
    public $image_path;
    public $fullname;

    // constructor with $db as database connection
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // read leagues
    function GetPlayerImage($playerNames, $playerCountry)
    {
        $arrPlayerNames = explode(",", $playerNames);
        $sqlPlayerNames = "";
        foreach ($arrPlayerNames as $value) {
            if (empty($sqlPlayerNames)) {
                $sqlPlayerNames .= "'" . $value . "'";
            } else {
                $sqlPlayerNames .= ",'" . $value . "'";
            }
        }
        // select all query
        $query = "SELECT fullname, image_path
                FROM
                    " . $this->table_name . " Left Join Countries On Players.country_id = Countries.id where Players.fullname in (" . $sqlPlayerNames . ") and Countries.name = '" . $playerCountry . "'";
        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }
}
