<?php
session_start();
// check if the user is logged in
if (!isset($_SESSION['username'])) {
    header('location: login.php');
}

// connect to the database
//$db = mysqli_connect('localhost', 'root', 'root', 'water_billing_system');
require_once 'config.php';


// get the search term if provided
$search_term = isset($_GET['search']) ? $_GET['search'] : '';

// retrieve the clients from the database
if (!empty($search_term)) {
    // if search term is provided, filter the clients by name or email
    $query = "SELECT * FROM clients WHERE name LIKE '%$search_term%' OR contact_number LIKE '%$search_term%'";
} else {
    // if search term is not provided, retrieve all clients
    $query = "SELECT * FROM clients";
}

$result = mysqli_query($db, $query);

// check if there's an error in the query execution
if (!$result) {
    echo "Failed to execute query: " . mysqli_error($db);
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Client List</title>
    <!-- Bootstrap styles -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
        crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <h2 class="my-4">Client List</h2>
        <form method="get" action="client_list.php" class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" type="search" name="search" placeholder="Search"
                aria-label="Search" value="<?php echo $search_term; ?>">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
        </form>
        <br>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Contact No.</th>
                    <th>Address</th>
                    <th>Edit</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['contact_number']; ?></td>
                    <td><?php echo $row['address']; ?></td>
                    <td>
                      <a href="edit_client.php?id=<?php echo $row['id']; ?>" class="btn btn-primary">Edit</a>
                      <a href="billing.php?client_id=<?php echo $row['id']; ?>" class="btn btn-success">Add Billing</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <br>
        <a href="new_client.php" class="btn btn-primary">New Client</a>
        <a href="index.php" class="btn btn-secondary">Back to Home</a>
        <a href="logout.php" class="btn btn-danger">Logout</a>
    </div>

    <!-- Bootstrap scripts -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</body>
</html>

<?php mysqli_free_result($result); ?>
<?php mysqli_close($db); ?>
