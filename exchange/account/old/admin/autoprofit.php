<?php

include("includes/header.php");

$userid = $_GET['id'];
$amount = $_GET['amount'];
$time = $_GET['time'];
$tranx_id = rand(100000,999999);
$type = "profit";
$address = "";
$status = "completed";
    
$fesql = "SELECT * FROM users WHERE id = '$userid'";
$fequery = mysqli_query($conn,$fesql);
$fetcher = mysqli_fetch_assoc($fequery);
$useremail = $fetcher['email'];
$coin = $fetcher['currency'];
$newBal = $amount + $fetcher['total_balance'];

$upsql = "UPDATE users set total_balance = '$newBal' WHERE id = '$userid'";
mysqli_query($conn, $upsql);

$sqlpde = "INSERT INTO history (client_id, tranx_id, email, type, coin, address, amount, status) VALUES ( '$userid', '$tranx_id', '$useremail', '$type', '$coin', '$address', '$amount', '$status')";
    $stmtde = mysqli_query($conn, $sqlpde);