<?php
class Continents{

    // database connection and table name
    private $conn;
    private $table_name = "Continents";

    // object properties
    public $id;
    public $name;
    public $updated_at;

    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // read continents
    function GetContinents(){

        // select all query
        $query = "SELECT
                    id, name, updated_at
                FROM
                    " . $this->table_name;
        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }

    function GetContinentsByID($id){
        // select all query
        $query = "SELECT
                    id, name, updated_at
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
