
<?php
// Include database configuration
//require_once "config.php";

// Database configuration
define('DB_HOST', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'root');
define('DB_NAME', 'water_billing_system');

// Attempt to connect to the database
try {
    $pdo = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USERNAME, DB_PASSWORD);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Error: Could not connect. " . $e->getMessage());
}

// Get input data
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate required fields



    if (empty($_POST['client_id']) || empty($_POST['previous_reading']) || empty($_POST['present_reading']) || empty($_POST['price_per_meter'])) {
        echo "MEOW";
        var_dump($_POST);
        //header("Location: billing.php?status=error");
        exit;
    }

    $client_id = $_POST['client_id'];
    $previous_reading = $_POST['previous_reading'];
    $present_reading = $_POST['present_reading'];
    $price_per_meter = $_POST['price_per_meter'];

    // Calculate the bill amount
    $consumption = $present_reading - $previous_reading;
    $bill_amount = $consumption * $price_per_meter;

    // Prepare the SQL statement
    $sql = "INSERT INTO bills (client_id, previous_reading, present_reading, price_per_meter, bill_amount, bill_date) VALUES (?, ?, ?, ?, ?, ?)";
    $statement = $pdo->prepare($sql);
    $bill_date = date('Y-m-d H:i:s');
    $statement->execute([$client_id, $previous_reading, $present_reading, $price_per_meter, $bill_amount, $bill_date]);

    // Check if the insertion was successful
    
    if ($statement->rowCount() > 0) {
        header("Location: client_list.php?status=success");
    } else {
        header("Location: billing.php?status=error");
    }
}

// Close statement and database connection
$statement = null;
$pdo = null;
?>
