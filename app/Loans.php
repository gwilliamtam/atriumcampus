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
            require("credentials.php");

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

    public function saveTable()
    {
        $table = [];
        $rowsToDelete = [];
        if (!empty($_POST)) {
            if (array_key_exists('table', $_POST)) {
                $table = json_decode($_POST['table']);
            }
            if (array_key_exists('rowsToDelete', $_POST)) {
                $rowsToDelete = json_decode($_POST['rowsToDelete']);
            }
        }
        if (!$this->isLocal()) {
            $this->connect();
            if (!empty($rowsToDelete)) {
                $deleteQuery = "delete from test where id in (". implode(',', $rowsToDelete) .")";
                $result = $this->conn->query($deleteQuery);
            }

            if (!empty($table)) {
                $dataInsertQuery = '';
                foreach ($table as $row) {
                    if (!empty($row->id)) {
                        // update existent rows
                        // next release will check if row need to be updated
                        $updateQuery = <<<UPDATE
                            update test set first_name = '{$row->firstName}', 
                                middle_initial = '{$row->middleInitial}', 
                                last_name = '{$row->lastName}', 
                                loan = '{$row->loan}', 
                                value = '{$row->value}' 
                                where id = {$row->id}
UPDATE;
                        $this->conn->query($updateQuery);
                    } else {
                        // set data for insert query
                        $dataInsertQuery = "('" . $row->firstName
                            . "','" . $row->middleInitial
                            . "','" .  $row->lastName
                            . "','" .  $row->loan
                            . "','" .  $row->value
                            . "')";
                    }
                }
            }
            if (!empty($dataInsertQuery)) {
                // insert new rows
                $insertQuery = "insert into test (first_name, middle_initial, last_name, loan, value) values " . $dataInsertQuery;
                $this->conn->query($insertQuery);
            }

            $this->disconnect();
        }

    }
}
