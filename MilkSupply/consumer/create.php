<?php
$servername="localhost";
$username="root";
$password="";
$database="MyMilkSupply";

//connection
$connection = new mysqli($servername,$username,$password,$database);

$PREFERENCE_ID = "";
$MILK_TYPE = "";
$BRAND = "";
$PACKAGING_TYPE = "";

$errorMessage = "";
$successMessage = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $PREFERENCE_ID = $_POST["PREFERENCE_ID"];
    $MILK_TYPE = $_POST["MILK_TYPE"];
    $BRAND = $_POST["BRAND"];
    $PACKAGING_TYPE = $_POST["PACKAGING_TYPE"];

    do {
        if (empty($PREFERENCE_ID) || empty($BRAND) || empty($PACKAGING_TYPE)) {
            $errorMessage = "Preference id , Brand and Packaging Type are compulsary fields";
            break;
        }
    // Check if PreferenceID already exists
    $checkQuery = "SELECT PREFERENCE_ID FROM CUSTOMER_PREFERENCES WHERE PREFERENCE_ID = '$PREFERENCE_ID'";
    $checkResult = $connection->query($checkQuery);

    if ($checkResult->num_rows > 0) {
         $errorMessage = "Preference ID '$PREFERENCE_ID' already exists. Please choose a different Preference ID.";
        break;
    }

        // new preference entered
        if (empty($MILK_TYPE)) {
            $sql = "INSERT INTO CUSTOMER_PREFERENCES (PREFERENCE_ID,BRAND,PACKAGING_TYPE) " .
                   "VALUES ('$PREFERENCE_ID','$BRAND','$PACKAGING_TYPE')";
        } else  {
            $sql = "INSERT INTO CUSTOMER_PREFERENCES (PREFERENCE_ID,MILK_TYPE, BRAND,PACKAGING_TYPE) " .
                   "VALUES ('$PREFERENCE_ID','$MILK_TYPE','$BRAND','$PACKAGING_TYPE')";
        } 
        
   
    $result = $connection->query($sql);

    if (!$result) {
        $errorMessage = "Invalid query: " . $connection->error;
    break;
    }

        $PREFERENCE_ID = "";
        $MILK_TYPE = "";
        $BRAND = "";
        $PACKAGING_TYPE = "";
       

        $successMessage = "Preference added successfully";
        header('Refresh: 1; URL= /MilkSupply/consumer/index.php');

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
        <h2>New Preference</h2>
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
                <label class="col sm-3 col-form-label">PREFERENCE ID</label>
                <div class="col sm-6">
                    <input type="text" class="form-control" name="PREFERENCE_ID" value="<?php echo $PREFERENCE_ID; ?>">
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
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                <div class="col-sm-3 d-grid">
                <a class="btn btn-outline-primary" href="/MilkSupply/consumer/index.php" role="button">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
