<?php

use App\Loans as Loans;
require_once('app/Loans.php');

$loans = new Loans;

$loans->saveTable();

$allLoans = $loans->all();

include("header.php");
?>

<div class="container">
    <div class="alert alert-danger d-none" id="alert" role="alert">
        Remember to click the button SAVE LIST or your changes may be lost!
    </div>
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
    $cnt = 0;
    foreach ($allLoans as $key => $loan) {
	    echo <<<HTML
            <tr class="student-row" data-row-number="{$cnt}">
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
	    $cnt ++;
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
            <button class="btn btn-primary save-changes">Save List</button>
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
                    <input type="hidden" class="form-control" id="row-number">
                    <input type="hidden" class="form-control" id="student-id">
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
                <button type="button" class="btn btn-danger mr-auto" id="delete-row">Remove</button>
                <button type="button" class="btn btn-primary" id="add-update">Add / Update</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<form action="/" method="post" id="form">
    <input type="hidden" name="table" id="form-data">
    <input type="hidden" name="rowsToDelete" id="rows-to-delete">
</form>

<script>
    let rowsToDelete = [];

    $(document).ready(function(){
        load();
    });

    function load() {

        $(".add-student").on("click", function() {
            clearModalForm();
            $('#add-update').html('Add');
            $('#delete-row').addClass('d-none');
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
                $('#alert').removeClass('d-none')
                if (rowExists()) {
                    updateRow();
                } else {
                    addRow();
                }
            };
        });

        $('body').on('click', 'button.update-row', function() {
            let row = $(this).parent().parent()
            let cells = row.children()
            $('#row-number').val(row[0].getAttribute('data-row-number'));
            $('#student-id').val(cells[0].innerHTML);
            $('#first-name').val(cells[1].innerHTML);
            $('#middle-initial').val(cells[2].innerHTML);
            $('#last-name').val(cells[3].innerHTML);
            $('#loan').val(cells[4].innerHTML);
            $('#value').val(cells[5].innerHTML);
            $('#loan-to-value').val(cells[6].innerHTML);
            $('#add-update').html('Update');
            $('#delete-row').removeClass('d-none');
            $('#editor').modal('show');
        });

        $('#delete-row').on('click', function() {
            $('#editor').modal('hide');
            deleteRow($('#row-number').val());
        });

        $('.save-changes').on('click', function() {
            console.log('about to save');
            saveTable();
        });
    }

    function saveTable()
    {
        tableData = [];
        let rows = $("body").find(".student-row").toArray();
        console.log(rows);
        rows.forEach(function(row) {
            let rowNumber = row.getAttribute('data-row-number');
            let cells = row.children;
            tableData.push({
                "id": cells[0].innerHTML,
                "firstName": cells[1].innerHTML,
                "middleInitial": cells[2].innerHTML,
                "lastName": cells[3].innerHTML,
                "loan": cells[5].innerHTML,
                "value": cells[6].innerHTML,
            });
        })
        if (tableData.length > 0 || rowsToDelete.length > 0) {
            // submit table and rows to delete... if any
            $('#rows-to-delete').val(JSON.stringify(rowsToDelete));
            $('#form-data').val(JSON.stringify(tableData));
            $('#form').submit();
        } else {
            // just refresh screen
            document.location = '/';
        }
    }

    function rowExists()
    {
        let rowNumber = $("#row-number").val();
        let row = $("body").find("[data-row-number='"+rowNumber+"']");
        if (row.length > 0) {
            return true;
        }
        return false;
    }

    function updateRow()
    {
        let rowNumber = $("#row-number").val();
        let row = $("body").find("[data-row-number='"+rowNumber+"']");
        let cells = row.find('td');
        cells[0].innerHTML = $('#student-id').val();
        cells[1].innerHTML = $('#first-name').val();
        cells[2].innerHTML = $('#middle-initial').val();
        cells[3].innerHTML = $('#last-name').val();
        cells[4].innerHTML = $('#loan').val();
        cells[5].innerHTML = $('#value').val();
        cells[6].innerHTML = $('#loan-to-value').val();
    }

    function totalRows()
    {
        return $('body tr.student-row').length;
    }

    function deleteRow(rowNumber)
    {
        let row = $("body").find("[data-row-number='"+rowNumber+"']");
        let studentId = $('#student-id').val();
        if (rowNumber) {
            if (studentId) {
                rowsToDelete.push(studentId)
            }
            row.remove();
        }
    }

    function addRow()
    {
        let table = document.getElementById('loans-table');
        let row = table.insertRow(-1);
        row.className = 'student-row';
        row.setAttribute('data-row-number', totalRows());

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

    function clearModalForm()
    {
        $('#student-id').val('');
        $('#row-number').val('');
        $('#first-name').val('');
        $('#middle-initial').val('');
        $('#last-name').val('');
        $('#loan').val('');
        $('#value').val('')
        $('#loan-to-value').val('');
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
