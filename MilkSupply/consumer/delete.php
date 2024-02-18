<?php
    if( isset($_GET["PREFERENCE_ID"])){
    $PREFERENCE_ID= $_GET["PREFERENCE_ID"];

    $servername="localhost";
    $username="root";
    $password="";
    $database="MyMilkSupply";

    //connection
    $connection = new mysqli($servername,$username,$password,$database);

    //sql
    $sql="DELETE FROM CUSTOMER_PREFERENCES WHERE PREFERENCE_ID=$PREFERENCE_ID";
    $connection->query($sql);
    }

    header("location:/MilkSupply/consumer/index.php");
    exit;
?>