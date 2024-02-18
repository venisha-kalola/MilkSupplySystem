<?php
    if( isset($_GET["ExpenseID"])){
    $ExpenseID= $_GET["ExpenseID"];

    $servername="localhost";
    $username="root";
    $password="";
    $database="MyMilkSupply";

    //connection
    $connection = new mysqli($servername,$username,$password,$database);

    //sql
    $sql="DELETE FROM FarmExpenses WHERE ExpenseID=$ExpenseID";
    $connection->query($sql);
    }

    header("location: /MilkSupply/farmer/index.php");
    exit;
?>