<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "MyMilkSupply";

// Connection
$connection = new mysqli($servername, $username, $password, $database);

$ExpenseID = "";
$ExpenseDate = "";
$ExpenseType = "";
$ExpenseDescription = "";
$Amount = "";

$errorMessage = "";
$successMessage = "";

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // GET method: show data of expense

    if (!isset($_GET["ExpenseID"])) {
        header("location:/MilkSupply/farmer/index.php");
        exit;
    }
    $ExpenseID = $_GET["ExpenseID"];

    // Read row from database
    $sql = "SELECT * FROM FarmExpenses WHERE ExpenseID=$ExpenseID";
    $result = $connection->query($sql);
    $row = $result->fetch_assoc();
    if (!$row) {
        header("location:/MilkSupply/farmer/index.php");
        exit;
    }
    $ExpenseID = $row["ExpenseID"];
    $ExpenseDate = $row["ExpenseDate"];
    $ExpenseType = $row["ExpenseType"];
    $ExpenseDescription = $row["ExpenseDescription"];
    $Amount = $row["Amount"];
} else {
    // POST method
    $ExpenseID = $_POST["ExpenseID"];
    $ExpenseDate = $_POST["ExpenseDate"];
    $ExpenseType = $_POST["ExpenseType"];
    $ExpenseDescription = $_POST["ExpenseDescription"];
    $Amount = $_POST["Amount"];

    do {
        if (empty($ExpenseID) || empty($ExpenseType) || empty($Amount)) {
            $errorMessage = "Expense id , type and Amount are compulsory fields";
            break;
        }

        // Update expense entered
        $sql = "UPDATE FarmExpenses " .
               "SET ExpenseDate='$ExpenseDate', ExpenseType='$ExpenseType', ExpenseDescription='$ExpenseDescription', Amount='$Amount' " .
               "WHERE ExpenseID =$ExpenseID";

        $result = $connection->query($sql);

        if (!$result) {
            $errorMessage = "Invalid query: " . $connection->error;
            break;
        }

        $successMessage = "Expense updated successfully";
        header('Refresh: 1; URL=/MilkSupply/farmer/index.php');
        // exit;

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
    <div class="container my-5 custom-container">
        <h2>Update Expense</h2>
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
            <input type="hidden" name="ExpenseID" value="<?php echo $ExpenseID; ?>">
            <div class="row mb-3">
                <label class="col sm-3 col-form-label">Expense Id</label>
                <div class="col sm-6">
                    <input type="text" class="form-control" name="ExpenseID" value="<?php echo $ExpenseID; ?>" readonly>
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
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
                <div class="col-sm-3 d-grid">
                    <a class="btn btn-outline-primary" href="/MilkSupply/farmer/index.php" role="button">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</body>
</html>

