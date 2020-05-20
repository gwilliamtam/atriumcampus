<?php
use App\Loans as Loans;
require_once('app/Loans.php');

$loans = new Loans;
$loans->connect();
$allLoans = $loans->all();
$loans->disconnect();

var_dump($allLoans);
?>

<div class="content">

</div>

