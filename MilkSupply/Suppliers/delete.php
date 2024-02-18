<?php
    if( isset($_GET["Product_Id"])){
    $Product_Id= $_GET["Product_Id"];

    $servername="localhost";
    $username="root";
    $password="";
    $database="MyMilkSupply";

    //connection
    $connection = new mysqli($servername,$username,$password,$database);

    //sql
    $sql="DELETE FROM Product_Inventory WHERE Product_Id=$Product_Id";
    $connection->query($sql);
    }

    header("location:/MilkSupply/suppliers/index.php");
    exit;
?>