<?php

namespace App;

use mysqli;

class Loans
{
    public function listLoans()
    {

        $servername = "dev-db1.cluster-ccyyfxhqobvx.us-east-1.rds.amazonaws.com";
        $username = "guillermo";
        $password = "XAtqYbM2ZLQYUU2VzD7qAkAmfrEeVx6a";
        $dbname = "guillermo_test";


        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

	$sql = "insert into test (id, first_name, middle_initial, last_name, loan, value) values (1, 'Guillermo', 'A', 'Williamson', 3000, 2750)";
	$result = $conn->query($sql);

        $sql = "SELECT id, first_name, middle_initial, last_name, loan, value FROM test limit 10";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // output data of each row
            while ($row = $result->fetch_assoc()) {
                echo "id: " . $row["id"] .
                    " - Name: " . $row["first_name"] . " " . $row["middle_initial"]  . " " . $row["last_name"]
                    . " Loan/Value " . $row["loan"]  . "/" . $row["value"] . "<br>";
            }
        } else {
            echo "0 results";
        }
        $conn->close();

    }
}
