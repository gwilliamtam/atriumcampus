<?php
use App\Loans as Loans;
require_once('app/Loans.php');

$loans = new Loans;
$loans->listLoans();
