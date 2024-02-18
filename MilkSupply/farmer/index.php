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
        <h2>List of Farm Expenses</h2>
        <br>
        <a class="btn btn-primary" href="/MilkSupply/farmer/create.php" role="button">Add New Expense</a>
        <br>
        <br>
        <table class="table">
            <thead>
                <tr>
                    <th>Expense ID</th>
                    <th>Expense Date</th>
                    <th>Expense Type</th>
                    <th>Description</th>
                    <th>Amount</th>
                    <th>Edits</th>
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
                $sql = "SELECT * FROM FarmExpenses";
                $result = $connection->query($sql);
                
                //check query
                if(!$result){
                    die("Invalid query: " . $connection->error);
                }

                while($row = $result->fetch_assoc()){
                    echo "
                    <tr>
                        <td>$row[ExpenseID]</td>
                        <td>$row[ExpenseDate]</td>
                        <td>$row[ExpenseType]</td>
                        <td>$row[ExpenseDescription]</td>
                        <td>$row[Amount]</td>
                        <td>
                            <a class='btn btn-primary btn-sm' href='/MilkSupply/farmer/edit.php?ExpenseID=$row[ExpenseID]'>Edit</a>
                            <a class='btn btn-danger btn-sm' href='/MilkSupply/farmer/delete.php?ExpenseID=$row[ExpenseID]''>Delete</a>
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
