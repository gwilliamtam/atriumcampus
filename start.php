<?php
use App\Loans as Loans;
require_once('app/Loans.php');

$loans = new Loans;
$loans->connect();
$allLoans = $loans->all();
$loans->disconnect();

include("header.php");
?>

<div class="container">
    <table class="table">
        <thead>
        <tr>
            <th scope="col">Id</th>
            <th scope="col">First Name</th>
            <th scope="col">Middle</th>
            <th scope="col">Last Name</th>
            <th scope="col">Loan</th>
            <th scope="col">Value</th>
            <th scope="col">LTV</th>
        </tr>
        </thead>
        <tbody>
    <?php

    foreach ($allLoans as $loan) {
    ?>
        <tr>
            <th scope="row">{{ $loan['id']}}</th>
            <td>{{ $loan['id']}}</td>
            <td>{{ $loan['first_name']}}</td>
            <td>{{ $loan['middle']}}</td>
            <td>{{ $loan['last_name']}}</td>
            <td>{{ $loan['loan']}}</td>
            <td>{{ $loan['value']}}</td>
            <td></td>
        </tr>
    <?php
    }

    ?>
        </tbody>
    </table>
</div>

<?php
include("footer.php");
