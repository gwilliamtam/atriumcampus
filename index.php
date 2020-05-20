<?php
use App\Loans as Loans;
require_once('app/Loans.php');

$loans = new Loans;
#$loans->populate();
$allLoans = $loans->all();

include("header.php");
?>

<div class="container">
    <table class="table loans-table">
        <thead>
        <tr>
            <th scope="col">Id</th>
            <th scope="col">First Name</th>
            <th scope="col">Middle Initial</th>
            <th scope="col">Last Name</th>
            <th scope="col">Loan</th>
            <th scope="col">Value</th>
            <th scope="col">LTV</th>
            <th scope="col">Action</th>
        </tr>
        </thead>
        <tbody>
    <?php
    foreach ($allLoans as $key => $loan) {
	echo <<<HTML
        <tr class="studen-row" student-id="{$loan['id']}">
            <td>{$loan['id']}</td>
            <td>{$loan['first_name']}</td>
            <td>{$loan['middle_initial']}</td>
            <td>{$loan['last_name']}</td>
            <td>{$loan['loan']}</td>
            <td>{$loan['value']}</td>
            <td></td>
            <td>
                <button class="btn btn-primary">Update</button>
            </td>
        </tr>
HTML;
    }
    ?>
    <tr>
        <td colspan="7"></td>
        <td>
            <button class="btn btn-primary add-student">Add Student</button>
        </td>
    </tr>
        </tbody>
    </table>
    <div class="">
        <button class="btn btn-primary save-changes">Save Changes</button>
    </div>
</div>

<div class="modal" tabindex="-1" role="dialog" id="editor">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <input type="text" class="form-control" id="first-name" placeholder="First Name" maxlength="30">
                    <small id="first-name-help" class="form-text text-muted">First Name</small>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" id="middle-initial" placeholder="Middle Initial" maxlength="1">
                    <small id="middle-initial-help" class="form-text text-muted">Middle Initial</small>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" id="last-name" placeholder="Last Name" maxlength="30">
                    <small id="last-name-help" class="form-text text-muted">Last Name</small>
                </div>
                <div class="form-group">
                    <input type="number" class="form-control" id="loan" placeholder="Loan" maxlength="13">
                    <small id="loan-help" class="form-text text-muted">Loan</small>
                </div>
                <div class="form-group">
                    <input type="number" class="form-control" id="value" placeholder="Value" maxlength="13">
                    <small id="value-help" class="form-text text-muted">Value</small>
                </div>
                <div class="form-group">
                    <input type="number" class="form-control" id="loan-to-value" placeholder="LTV" readonly>
                    <small id="loan-to-value-help" class="form-text text-muted">Loan-To-Value</small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary">Add / Update</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        let loans = new Loans();
        loans.load()
    });

</script>
<script>
    class Loans
    {
        load() {
            $(".add-student").on("click", function() {
                $('#editor').modal('show');
            }) ;
        }
    }
</script>

<?php
include("footer.php");
