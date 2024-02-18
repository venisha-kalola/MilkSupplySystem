<?php
$servername="localhost";
$username="root";
$password="";
$database="MyMilkSupply";

//connection
$connection = new mysqli($servername,$username,$password,$database);

$Product_Id = "";
$Product_Name = "";
$Quantity = "";
$Unit_Price = "";
$Expiry_Date = "";
 
$errorMessage = "";
$successMessage = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
    $Product_Id = $_POST["Product_Id"];
    $Product_Name = $_POST["Product_Name"];
    $Quantity = $_POST["Quantity"];
    $Unit_Price = $_POST["Unit_Price"];
    $Expiry_Date = $_POST["Expiry_Date"];

    do {
        if (empty($Product_Id) || empty($Product_Name) || empty($Quantity) || empty($Unit_Price) || empty($Expiry_Date))
        {
            $errorMessage = "All are compulsary fields";
            break;
        }
    // Check if Product Id already exists
    $checkQuery = "SELECT Product_Id FROM Product_Inventory WHERE Product_Id = '$Product_Id'";
    $checkResult = $connection->query($checkQuery);

    if ($checkResult->num_rows > 0) {
         $errorMessage = "Product Id '$Product_Id' already exists. Please choose a different Product Id.";
        break;
    }

        // new product entered

            $sql = "INSERT INTO Product_Inventory (Product_Id, Product_Name, Quantity, Unit_Price, Expiry_Date) " .
                   "VALUES ('$Product_Id', '$Product_Name', '$Quantity', '$Unit_Price', '$Expiry_Date')";
        
   
    $result = $connection->query($sql);

    if (!$result) {
        $errorMessage = "Invalid query: " . $connection->error;
    break;
    }

        $Product_Id = "";
        $Prodcut_Name = "";
        $Quantity = "";
        $Unit_Price = "";
        $Expiry_Date = "";

        $successMessage = "Product added successfully";
        header('Refresh: 1; URL=/Suppliers/index.php');

        //exit;

    } while (false);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="/MilkSupply/style.css">
    <title>My Milk Supply</title>   
     
</head>
<body>
    <div class="container my-5 custom-container ">
        <h2>New Product</h2>
<br>
        <?php
        if (!empty($errorMessage)) {
            echo "
            <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                <strong>$errorMessage</strong>
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>
            ";
        }
        ?>

<form method="post">
            <div class="row mb-3">
                <label class="col sm-3 col-form-label">Product Id</label>
                <div class="col sm-6">
                    <input type="text" class="form-control" name="Product_Id" value="<?php echo $Product_Id; ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col sm-3 col-form-label">Product Name</label>
                <div class="col sm-6">
                <input type="text" class="form-control" name="Product_Name" value="<?php echo $Product_Name; ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col sm-3 col-form-label">Quantity</label>
                <div class="col sm-6">
                    <input type="text" class="form-control" name="Quantity" value="<?php echo $Quantity; ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col sm-3 col-form-label">Unit Price</label>
                <div class="col sm-6">
                    <input type="text" class="form-control" name="Unit_Price" value="<?php echo $Unit_Price; ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col sm-3 col-form-label">Expiry Date</label>
                <div class="col sm-6">
                    <input type="date" class="form-control" name="Expiry_Date" value="<?php echo $Expiry_Date; ?>">
                </div>
            </div>

            <?php
            if (!empty($successMessage)) {
                echo "
                <div class='row mb-3'>
                    <div class='offset-sm-3 col-sm-6'>
                        <div class='alert alert-success alert-dismissible fade show' role='alert'>
                            <strong>$successMessage</strong>
                            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                        </div>
                    </div>
                </div>
                ";
            }
            ?>

            <div class="row mb-3">
                <div class="offset-sm-3 col-sm-3 d-grid">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                <div class="col-sm-3 d-grid">
                <a class="btn btn-outline-primary" href="/MilkSupply/Suppliers/index.php" role="button">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
