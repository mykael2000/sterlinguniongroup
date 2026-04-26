<?php
include("../dashboard/includes/connection.php");

$time = 'daily';
$sql = "SELECT * FROM users WHERE time = '$time'";
$query = mysqli_query($conn,$sql);


while($fetch = mysqli_fetch_assoc($query)){
    $userid = $fetch['id'];
    $profit_amount = $fetch['profit_amount'];
    $total = $fetch['total_balance'];
    
    $amount = $total * ($profit_amount/100);
    $total_profit = $fetch['total_profit'] + $amount;
    $useremail = $fetch['email'];
    $newBal = $fetch['total_balance'] + $amount;
    $tranx_id = rand(100000,999999);
    $type = "profit";
    $address = "";
    $status = "completed";
    $coin = $fetch['currency'];
    $limit = $fetch['account_limit'];
    if($total <= $limit){
        $upsql = "UPDATE users set total_balance = '$newBal', total_profit = '$total_profit' WHERE id = '$userid'";
        $upquery = mysqli_query($conn, $upsql);
        
        $sqlpde = "INSERT INTO history (client_id, tranx_id, email, type, coin, address, amount, status) VALUES ( '$userid', '$tranx_id', '$useremail', '$type', '$coin', '$address', '$amount', '$status')";
        $stmtde = mysqli_query($conn, $sqlpde);
        echo "Task Completed";
    }else{
        echo "Account Limit Reached";
    }
    
}
echo "Daily";