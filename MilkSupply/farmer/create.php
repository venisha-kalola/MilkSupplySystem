<?php
$servername="localhost";
$username="root";
$password="";
$database="MyMilkSupply";

//connection
$connection = new mysqli($servername,$username,$password,$database);

$ExpenseID = "";
$ExpenseDate = "";
$ExpenseType = "";
$ExpenseDescription = "";
$Amount = "";

$errorMessage = "";
$successMessage = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ExpenseID = $_POST["ExpenseID"];
    $ExpenseDate = $_POST["ExpenseDate"];
    $ExpenseType = $_POST["ExpenseType"];
    $ExpenseDescription = $_POST["ExpenseDescription"];
    $Amount = $_POST["Amount"];

    do {
        if (empty($ExpenseID) || empty($ExpenseType) || empty($Amount)) {
            $errorMessage = "Expense id , type and Amount are compulsary fields";
            break;
        }
    // Check if ExpenseID already exists
    $checkQuery = "SELECT ExpenseID FROM FarmExpenses WHERE ExpenseID = '$ExpenseID'";
    $checkResult = $connection->query($checkQuery);

    if ($checkResult->num_rows > 0) {
         $errorMessage = "Expense ID '$ExpenseID' already exists. Please choose a different Expense ID.";
        break;
    }

        // new expense entered
        if (empty($ExpenseDate) && empty($ExpenseDescription)) {
            $sql = "INSERT INTO FarmExpenses (ExpenseID, ExpenseType, Amount) " .
                   "VALUES ('$ExpenseID', '$ExpenseType', '$Amount')";
        } else if (empty($ExpenseDate)) {
            $sql = "INSERT INTO FarmExpenses (ExpenseID, ExpenseType, ExpenseDescription, Amount) " .
                   "VALUES ('$ExpenseID', '$ExpenseType', '$ExpenseDescription', '$Amount')";
        } else if (empty($ExpenseDescription)) {
            $sql = "INSERT INTO FarmExpenses (ExpenseID, ExpenseDate, ExpenseType, Amount) " .
                   "VALUES ('$ExpenseID', '$ExpenseDate', '$ExpenseType', '$Amount')";
        } else {
            $sql = "INSERT INTO FarmExpenses (ExpenseID, ExpenseDate, ExpenseType, ExpenseDescription, Amount) " .
                   "VALUES ('$ExpenseID', '$ExpenseDate', '$ExpenseType', '$ExpenseDescription', '$Amount')";
        }
        
   
    $result = $connection->query($sql);

    if (!$result) {
        $errorMessage = "Invalid query: " . $connection->error;
    break;
    }

        $ExpenseID = "";
        $ExpenseDate = "";
        $ExpenseType = "";
        $ExpenseDescription = "";
        $Amount = "";

        $successMessage = "Expense added successfully";
        header('Refresh: 1; URL=/MilkSupply/farmer/index.php');

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
        <h2>New Expense</h2>
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
                <label class="col sm-3 col-form-label">Expense Id</label>
                <div class="col sm-6">
                    <input type="text" class="form-control" name="ExpenseID" value="<?php echo $ExpenseID; ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col sm-3 col-form-label">Expense Date</label>
                <div class="col sm-6">
                    <input type="date" class="form-control" name="ExpenseDate" value="<?php echo $ExpenseDate; ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col sm-3 col-form-label">Expense Type</label>
                <div class="col sm-6">
                    <input type="text" class="form-control" name="ExpenseType" value="<?php echo $ExpenseType; ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col sm-3 col-form-label">Description</label>
                <div class="col sm-6">
                    <input type="text" class="form-control" name="ExpenseDescription" value="<?php echo $ExpenseDescription; ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col sm-3 col-form-label">Amount</label>
                <div class="col sm-6">
                    <input type="text" class="form-control" name="Amount" value="<?php echo $Amount; ?>">
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
                <a class="btn btn-outline-primary" href="/MilkSupply/index.php" role="button">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
