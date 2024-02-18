<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "MyMilkSupply";

// Connection
$connection = new mysqli($servername, $username, $password, $database);

$PREFERENCE_ID = "";
$MILK_TYPE = "";
$BRAND = "";
$PACKAGING_TYPE = "";

$errorMessage = "";
$successMessage = "";

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // GET method: show data of preference

    if (!isset($_GET["PREFERENCE_ID"])) {
        header("location:/MilkSupply/consumer/index.php");
        exit;
    }
    $PREFERENCE_ID = $_GET["PREFERENCE_ID"];

    // Read row from database
    $sql = "SELECT * FROM CUSTOMER_PREFERENCES WHERE PREFERENCE_ID=$PREFERENCE_ID";
    $result = $connection->query($sql);
    $row = $result->fetch_assoc();
    if (!$row) {
        header("location:/MilkSupply/consumer/index.php");
        exit;
    }
    $PREFERENCE_ID = $row["PREFERENCE_ID"];
    $MILK_TYPE = $row["MILK_TYPE"];
    $BRAND = $row["BRAND"];
    $PACKAGING_TYPE = $row["PACKAGING_TYPE"];
    
} else {
    // POST method
    $PREFERENCE_ID = $_POST["PREFERENCE_ID"];
    $MILK_TYPE = $_POST["MILK_TYPE"];
    $BRAND = $_POST["BRAND"];
    $PACKAGING_TYPE = $_POST["PACKAGING_TYPE"];
 

    do {
        if (empty($PREFERENCE_ID) || empty($MILK_TYPE) || empty($BRAND)) {
            $errorMessage = "Preference id , Milk Type and Brand are compulsory fields";
            break;
        }

        // Update preference entered
        $sql = "UPDATE CUSTOMER_PREFERENCES " .
               "SET MILK_TYPE='$MILK_TYPE', BRAND='$BRAND', PACKAGING_TYPE='$PACKAGING_TYPE' " .
               "WHERE PREFERENCE_ID =$PREFERENCE_ID";

        $result = $connection->query($sql);

        if (!$result) {
            $errorMessage = "Invalid query: " . $connection->error;
            break;
        }

        $successMessage = "Preference updated successfully";
        header('Refresh: 1; URL=/MilkSupply/consumer/index.php');
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
        <h2>Update Preference</h2>
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
            <input type="hidden" name="PREFERENCE_ID" value="<?php echo $PREFERENCE_ID; ?>">
            <div class="row mb-3">
                <label class="col sm-3 col-form-label">PREFERENCE ID</label>
                <div class="col sm-6">
                    <input type="text" class="form-control" name="PREFERENCE_ID" value="<?php echo $PREFERENCE_ID; ?>" readonly>
                </div>
            </div>

            <div class="row mb-3">
                <label class="col sm-3 col-form-label">MILK TYPE</label>
                <div class="col sm-6">
                    <input type="text" class="form-control" name="MILK_TYPE" value="<?php echo $MILK_TYPE; ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col sm-3 col-form-label">BRAND</label>
                <div class="col sm-6">
                    <input type="text" class="form-control" name="BRAND" value="<?php echo $BRAND; ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col sm-3 col-form-label">PACKAGING TYPE</label>
                <div class="col sm-6">
                    <input type="text" class="form-control" name="PACKAGING_TYPE" value="<?php echo $PACKAGING_TYPE; ?>">
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
                    <a class="btn btn-outline-primary" href="/MilkSupply/consumer/index.php" role="button">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</body>
</html>

