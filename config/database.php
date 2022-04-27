<?php
class Database{

    // specify database credentials
    private $host = "184.168.99.250";
    private $db_name = "cricketdb";
    private $username = "neerajmalkani";
    private $password = "secure@MySQL";
    public $conn;

    // get the database connection
    public function getConnection(){

        $this->conn = null;

        try{
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        }catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }
}
?>
