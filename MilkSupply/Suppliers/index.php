<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="/MilkSupply/style.css">
    <title>My Milk Supply</title>
</head>
<body>

    <nav class="navbar">
        <div class="nav-container">
        <a class="navbar-home" href="/MilkSupply/index.php">
                <i class="fas fa-house"></i> 
                Home
        </a>
        </div>
        <h2 class="heading">Milk Supply System</h2>
    </nav>

    <div class="container my-5">
        <h2>List of Products</h2>
        <br>
        <a class="btn btn-primary" href="/MilkSupply/Suppliers/create.php" role="button">Add New Product</a>
        <br>
        <br>
        <table class="table">
            <thead>
                <tr>
                <th>Product_Id</th>
                    <th>Product_Name</th>
                    <th>Quantity</th>
                    <th>Unit_Price</th>
                    <th>Expiry_Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $servername="localhost";
                $username="root";
                $password="";
                $database="MyMilkSupply";

                //connection
                $connection = new mysqli($servername,$username,$password,$database);

                //checking connection
                if($connection->connect_error){
                    die("Connection failed: ". $connection->connect_error);
                }

                //sql
                $sql = "SELECT * FROM Product_Inventory";
                $result = $connection->query($sql);
                
                //check query
                if(!$result){
                    die("Invalid query: " . $connection->error);
                }

                while($row = $result->fetch_assoc()){
                    echo "
                    <tr>
                        <td>$row[Product_Id]</td>
                        <td>$row[Product_Name]</td>
                        <td>$row[Quantity]</td>
                        <td>$row[Unit_Price]</td>
                        <td>$row[Expiry_Date]</td>
                        <td>
                            <a class='btn btn-primary btn-sm' href='/MilkSupply/suppliers/edit.php?Product_Id=$row[Product_Id]'>Edit</a>
                            <a class='btn btn-danger btn-sm' href='/MilkSupply/suppliers/delete.php?Product_Id=$row[Product_Id]''>Delete</a>
                        </td>
                    </tr>
                    ";
                }
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
