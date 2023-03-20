<?php
// Include database configuration
require_once "config.php";

// Get input data
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate required fields
    // if (empty($client_id) and empty($previous_reading) and empty($present_reading) and empty($price_per_meter)) {
    //     header("Location: billing.php?status=error");
        
    // }
    // Validate required fields



    if (empty($_POST['client_id']) || empty($_POST['previous_reading']) || empty($_POST['present_reading']) || empty($_POST['price_per_meter'])) {
        echo "MEOW";
        var_dump($_POST);
        header("Location: billing.php?status=error");
        exit;
    }

    $client_id = isset($_POST['client_id']) ? $_POST['client_id'] : null;
    $previous_reading = isset($_POST['previous_reading']) ? $_POST['previous_reading'] : null;
    $present_reading = isset($_POST['present_reading']) ? $_POST['present_reading'] : null;
    $price_per_meter = isset($_POST['price_per_meter']) ? $_POST['price_per_meter'] : null;

    // Calculate the bill amount
    $consumption = $present_reading - $previous_reading;
    $bill_amount = $consumption * $price_per_meter;

    // Prepare the SQL statement
    $sql = "INSERT INTO bills (client_id, previous_reading, present_reading, price_per_meter, bill_amount, bill_date) VALUES (?, ?, ?, ?, ?, ?)";
    $statement = mysqli_prepare($db, $sql);
    $bill_date = date('Y-m-d H:i:s');
    mysqli_stmt_bind_param($statement, "iiidss", $client_id, $previous_reading, $present_reading, $price_per_meter, $bill_amount, $bill_date);
    mysqli_stmt_execute($statement);

    // Check if the insertion was successful
    
    if (mysqli_affected_rows($db) >= 0) {
        header("Location: client_list.php?status=success");
    } else {
        header("Location: billing.php?status=error");
    }
}

// Close statement and database connection
mysqli_stmt_close($statement);
mysqli_close($db);
?> 

