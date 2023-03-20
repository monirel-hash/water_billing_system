<?php
session_start();

// redirect to login page if user is not logged in
if (!isset($_SESSION['username'])) {
    header('location: login.php');
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Home Page</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container">
        <h2>Home Page</h2>
        <p>Welcome, <?php echo $_SESSION['username']; ?>!</p>
        <a href="client_list.php" class="btn btn-primary">Client List</a>
        <a href="new_client.php" class="btn btn-primary">New Client Form</a>
        <form method="post" action="logout.php" style="display: inline;">
            <input type="submit" value="Logout" class="btn btn-danger">
        </form>
    </div>
</body>
</html>
