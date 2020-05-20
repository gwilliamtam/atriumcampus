<?php
use App\Loans as Loans;
require_once('app/Loans.php');

$loans = new Loans;
$loans->connect();
$allLoans = $loans->all();
$loans->disconnect();

var_dump($allLoans);

include("header.php");
?>

<div class="content">
SOME CONTENT GOES HERE
</div>

<?php
include("footer.php");
