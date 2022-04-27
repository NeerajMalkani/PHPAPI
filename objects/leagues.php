<?php
class Leagues{

    // database connection and table name
    private $conn;
    private $table_name = "Leagues";

    // object properties
    public $id;
    public $name;
    public $code;
    public $image_path;
    public $type;
    public $updated_at;

    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // read leagues
    function GetLeagues(){

        // select all query
        $query = "SELECT
                    id, name, code, image_path, type, updated_at
                FROM
                    " . $this->table_name;
        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }

    function GetLeaguesByID($id){
        // select all query
        $query = "SELECT
                    id, name, code, image_path, type, updated_at
                FROM
                    " . $this->table_name . " where id=" . $id;
        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }

}
?>
