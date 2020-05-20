<?php

use App\Loans as Loans;
require_once('app/Loans.php');

$loans = new Loans;
#$loans->populate();
$allLoans = $loans->all();

include("header.php");
?>

<div class="container">
    <table class="table table-striped" id="loans-table">
        <thead>
        <tr>
            <th scope="col"  class="text-left">Id</th>
            <th scope="col"  class="text-left">First Name</th>
            <th scope="col"  class="text-left">Middle Initial</th>
            <th scope="col"  class="text-left">Last Name</th>
            <th scope="col"  class="text-right">Loan</th>
            <th scope="col"  class="text-right">Value</th>
            <th scope="col"  class="text-right">LTV %</th>
            <th scope="col"  class="text-center">Action</th>
        </tr>
        </thead>
        <tbody>
    <?php
    foreach ($allLoans as $key => $loan) {
	echo <<<HTML
        <tr>
            <td>{$loan['id']}</td>
            <td>{$loan['first_name']}</td>
            <td>{$loan['middle_initial']}</td>
            <td>{$loan['last_name']}</td>
            <td class="text-right">{$loan['loan']}</td>
            <td class="text-right">{$loan['value']}</td>
            <td class="text-right">{$loan['ltv']}</td>
            <td class="text-center">
                <button class="btn btn-primary update-row">Update</button>
            </td>
        </tr>
HTML;
    }
    ?>
        </tbody>
    </table>
</div>
<div class="container">
    <div class="row">
        <div class="col text-center">
            <button class="btn btn-primary add-student">Add Student</button>
        </div>
        <div class="col text-center">
            <button class="btn btn-primary save-changes">Save Changes</button>
        </div>
    </div>
</div>

<div class="modal" tabindex="-1" role="dialog" id="editor">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Enter Student Information</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <input type="text" class="form-control" id="first-name" placeholder="Enter First Name" maxlength="30">
                    <small id="first-name-help" class="form-text text-muted">First Name</small>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" id="middle-initial" placeholder="Enter Middle Initial" maxlength="1">
                    <small id="middle-initial-help" class="form-text text-muted">Middle Initial</small>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" id="last-name" placeholder="Enter Last Name" maxlength="30">
                    <small id="last-name-help" class="form-text text-muted">Last Name</small>
                </div>
                <div class="form-group">
                    <input type="number" class="form-control" id="loan" placeholder="Enter Loan" maxlength="13">
                    <small id="loan-help" class="form-text text-muted">Loan</small>
                </div>
                <div class="form-group">
                    <input type="number" class="form-control" id="value" placeholder="Enter Value" maxlength="13">
                    <small id="value-help" class="form-text text-muted">Value</small>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" id="loan-to-value" placeholder="LTV" readonly>
                    <small id="loan-to-value-help" class="form-text text-muted">Loan-To-Value</small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="add-update">Add / Update</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        load();
    });

    function load() {
        $(".add-student").on("click", function() {
            $('#editor').modal('show');
        });

        $("#loan").on('change', function() {
            updateLTV();
        });

        $("#value").on('change', function() {
            updateLTV();
        });

        $('#add-update').on('click', function() {
            if (validateAddStudent()) {
                $('#editor').modal('hide');
                addRow();
            };
        });
    }

    function addRow()
    {
        let table = document.getElementById('loans-table');
        let row = table.insertRow(-1);

        let cellId = row.insertCell(0);
        cellId.innerHTML = '';

        let cellName = row.insertCell(1);
        cellName.innerHTML = $('#first-name').val();

        let cellMiddle = row.insertCell(2);
        cellMiddle.innerHTML = $('#middle-initial').val();

        let cellLast = row.insertCell(3);
        cellLast.innerHTML = $('#last-name').val();

        let cellLoan = row.insertCell(4);
        cellLoan.innerHTML = $('#loan').val();
        cellLoan.className = 'text-right';

        let cellValue = row.insertCell(5);
        cellValue.innerHTML = $('#value').val();
        cellValue.className = 'text-right';

        let cellLTV = row.insertCell(6);
        cellLTV.innerHTML = $('#loan-to-value').val();
        cellLTV.className = 'text-right';

        let cellAction = row.insertCell(7);
        cellAction.innerHTML = '<button class="btn btn-primary update-row">Update</button>';
        cellAction.className = 'text-center';
    }

    function validateAddStudent()
    {
        if ($('#first-name').val()
            && $('#last-name').val()
            && $('#loan').val()
            && $('#value').val()
        ) {
            return true;
        }
        return false;
    }

    function updateLTV() {

        const loan = $('#loan').val();
        const value = $('#value').val();
        console.log('updating LTV with ', loan, value);
        let ltv = 0;
        if (value && loan) {
            if (loan != 0) {
                ltv = (loan / value) * 100;
            }
        }
        $('#loan-to-value').val(ltv.toFixed(2));
    }
</script>

<?php
include("footer.php");
