<?php
// Database configuration
define('DB_HOST', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'root');
define('DB_NAME', 'water_billing_system');

// Attempt to connect to the database
$db = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if ($db === false) {
    die('Error: Could not connect. ' . mysqli_connect_error());
}
?>
