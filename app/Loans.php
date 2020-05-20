<?php

namespace App;

use mysqli;

class Loans
{
    private $conn;

    public function connect()
    {
        $servername = "dev-db1.cluster-ccyyfxhqobvx.us-east-1.rds.amazonaws.com";
        $username = "guillermo";
        $password = "XAtqYbM2ZLQYUU2VzD7qAkAmfrEeVx6a";
        $dbname = "guillermo_test";

        $this->conn = new mysqli($servername, $username, $password, $dbname);

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function disconnect()
    {
        $this->conn->close();
    }

    public function all()
    {
        $sql = "SELECT id, first_name, middle_initial, last_name, loan, value FROM test limit 10";
        $result = $this->conn->query($sql);

        if ($result->num_rows > 0) {
            // output data of each row
            return $result;
        }
        return null;
    }
}
