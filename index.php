<?php
use App\Loans as Loans;
require_once('app/Loans.php');

$loans = new Loans;
$loans->connect();
$loans->populate();
$allLoans = $loans->all();
$loans->disconnect();

include("header.php");
?>

<div class="container">
    <table class="table loans-table">
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
    foreach ($allLoans as $key => $loan) {
	echo <<<HTML
        <tr>
            <td>{$loan['id']}</td>
            <td>{$loan['first_name']}</td>
            <td>{$loan['middle']}</td>
            <td>{$loan['last_name']}</td>
            <td>{$loan['loan']}</td>
            <td>{$loan['value']}</td>
            <td></td>
        </tr>
HTML;
    }
    ?>
            <tr>
                <td></td>
                <td>
                    <div class="form-group">
                        <input type="text" class="form-control" id="first-name" name="firstName" placeholder="First Name" maxlength="30">
                        <small id="first-name-help" class="form-text text-muted">First Name</small>
                    </div>
                </td>
                <td>
                    <div class="form-group">
                        <input type="text" class="form-control" id="middle" name="middle" placeholder="Middle" maxlength="1">
                        <small id="middle-help" class="form-text text-muted">Middle</small>
                    </div>
                </td>
                <td>
                    <div class="form-group">
                        <input type="text" class="form-control" id="last-name" name="lastName" placeholder="Last Name" maxlength="30">
                        <small id="last-name-help" class="form-text text-muted">Last Name</small>
                    </div>
                </td>
                <td>
                    <div class="form-group">
                        <input type="number" class="form-control" id="loan" name="loan" placeholder="Loan" maxlength="13">
                        <small id="loan-help" class="form-text text-muted">Loan</small>
                    </div>
                </td>
                <td>
                    <div class="form-group">
                        <input type="number" class="form-control" id="value" name="value" placeholder="Value" maxlength="13">
                        <small id="value-help" class="form-text text-muted">Value</small>
                    </div>
                </td>
                <td>
                    <div class="form-group">
                        <input type="number" class="form-control" id="value" placeholder="LTV" readonly>
                        <small id="loan-to-value-help" class="form-text text-muted">Loan-To-Value</small>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>

<?php
include("footer.php");
