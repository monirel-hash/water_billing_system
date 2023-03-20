<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Login Page</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
</head>
<body>
  <div class="container">
    <div class="row">
      <div class="col-md-4 col-md-offset-4">
        <h2 class="text-center">Login Page</h2>
        <form method="post" action="login.php">
          <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" class="form-control" name="username" required>
          </div>
          <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" class="form-control" name="password" required>
          </div>
          <button type="submit" class="btn btn-primary">Login</button>
        </form>
        <?php
        session_start();

        if (isset($_POST['username']) && isset($_POST['password'])) {
          // connect to the database
          //$db = mysqli_connect('localhost', 'root', 'root', 'water_billing_system');
          require_once 'config.php';


          // get the username and password from the input fields
          $username = $_POST['username'];
          $password = $_POST['password'];

          // query the users table to check if the user exists
          $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
          $result = mysqli_query($db, $query);

          if (mysqli_num_rows($result) == 1) {
            // if the user exists, redirect to the home page
            $_SESSION['username'] = $username;
            header('location: index.php');
          } else {
            // if the user does not exist, display an error message
            echo '<div class="alert alert-danger" role="alert">
            Invalid username or password. Please try again.</div>';
          }
        }
        ?>
      </div>
    </div>
  </div>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</body>
</html>
