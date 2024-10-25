<?php

class Database
{
    private $dbhost = DBHOST;
    private $dbuser = DBUSER;
    private $dbpass = DBPASS;
    private $dbname = DBNAME;
    public $conn;

    public function connect()
    {
        $this->conn = new mysqli ($this->dbhost, $this->dbuser, $this->dbpass, $this->dbname);
        if($this->conn->connect_error)
        {
            die("Connection failed: ". $this->conn->connect_error);
        }

        return $this->conn;
    }
}