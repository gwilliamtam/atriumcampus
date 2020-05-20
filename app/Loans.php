<?php

namespace App;

use mysqli;

class Loans
{
    private $conn;

    public function isLocal()
    {
        if ($_SERVER['DOCUMENT_ROOT'] == '/Users/gwilliamson/Projects/atriumcampus') {
            return true;
        }
        return false;
    }

    public function connect()
    {
        if (!$this->isLocal()) {
            $servername = "dev-db1.cluster-ccyyfxhqobvx.us-east-1.rds.amazonaws.com";
            $username = "guillermo";
            $password = "XAtqYbM2ZLQYUU2VzD7qAkAmfrEeVx6a";
            $dbname = "guillermo_test";

            $this->conn = new mysqli($servername, $username, $password, $dbname);

            if ($this->conn->connect_error) {
                die("Connection failed: " . $this->conn->connect_error);
            }
        }
    }

    public function disconnect()
    {
        if ($this->conn) {
            $this->conn->close();
        }
    }

    public function populate()
    {
        $this->connect();

        $sql = "insert into test (id, first_name, middle_initial, last_name, loan, value) values 
                    (1, 'Guillermo', 'A', 'Williamson', 3000, 2750)";
        $this->conn->query($sql);

        $sql = "insert into test (id, first_name, middle_initial, last_name, loan, value) values 
                    (2, 'Carolina', '', 'Williamson', 2500, 2350)";
        $this->conn->query($sql);

	$this->disconnect();
    }

    public function all()
    {
        if (!$this->isLocal()) {
            $this->connect();
            $sql = "SELECT id, first_name, middle_initial, last_name, loan, value,
                     (if (value=0, 0, format(loan/value*100, 2))) as ltv
                    FROM test";
            $result = $this->conn->query($sql);

            if ($result->num_rows > 0) {
                // output data of each row
                return $result->fetch_all(MYSQLI_ASSOC);
            }
            $this->disconnect();
        }

        return [];
    }
}
