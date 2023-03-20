<?php
session_start();
// check if the user is logged in
if (!isset($_SESSION['username'])) {
    header('location: login.php');
}

// define variables and initialize with empty values
$name = $address = $contact_number = "";
$name_err = $address_err = $contact_number_err = "";

// process form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // validate name
    if (empty(trim($_POST["name"]))) {
        $name_err = "Please enter a name.";
    } else {
        $name = trim($_POST["name"]);
    }

    // validate address
    if (empty(trim($_POST["address"]))) {
        $address_err = "Please enter an address.";
    } else {
        $address = trim($_POST["address"]);
    }

    // validate contact number
    if (empty(trim($_POST["contact_number"]))) {
        $contact_number_err = "Please enter a contact number.";
    } else {
        $contact_number = trim($_POST["contact_number"]);
    }

    // check input errors before inserting into database
    if (empty($name_err) && empty($address_err) && empty($contact_number_err)) {

        // connect to the database
        //$db = mysqli_connect('localhost', 'root', 'root', 'water_billing_system');
        require_once 'config.php';


        // prepare an insert statement
        $query = "INSERT INTO clients (name, address, contact_number) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($db, $query);

        // bind parameters to the statement
        mysqli_stmt_bind_param($stmt, "sss", $name, $address, $contact_number);

        // execute the statement
        mysqli_stmt_execute($stmt);

        // check if there's an error in the query execution
        if (mysqli_stmt_errno($stmt)) {
            echo "Failed to execute query: " . mysqli_stmt_error($stmt);
            exit();
        }

        // close the statement
        mysqli_stmt_close($stmt);

        // close the database connection
        mysqli_close($db);

        // redirect to the client list page
        header("location: client_list.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>New Client</title>
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<!-- Bootstrap JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
	<div class="container">
		<h2>New Client</h2>
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
			<div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
				<label>Name</label>
				<input type="text" name="name" class="form-control" value="<?php echo $name; ?>">
				<span class="help-block"><?php echo $name_err; ?></span>
			</div>
			<div class="form-group <?php echo (!empty($address_err)) ? 'has-error' : ''; ?>">
				<label>Address</label>
				<textarea name="address" class="form-control"><?php echo $address; ?></textarea>
				<span class="help-block"><?php echo $address_err; ?></span>
			</div>
			<div class="form-group <?php echo (!empty($contact_number_err)) ? 'has-error' : ''; ?>">
				<label>Contact Number</label>
				<input type="text" name="contact_number" class="form-control" value="<?php echo $contact_number; ?>">
				<span class="help-block"><?php echo $contact_number_err; ?></span>
			</div>
			<input type="submit" class="btn btn-primary" value="Add Client">
			<a href="client_list.php" class="btn btn-default">Back to Client List</a>
			<a href="index.php" class="btn btn-default">Back to Home</a>
			<a href="logout.php" class="btn btn-default">Logout</a>
		</form>
	</div>
</body>
</html>
