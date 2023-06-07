<?php
require_once "Config.php";

$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";

if($_SERVER['REQUEST_METHOD'] == "POST"){
    //Check if username is empty

    if(empty(trim($_POST["username"]))){
        $username_err = "Username cannot be empty";
    }
    else{
        $sql = "SELECT id FROM users WHERE username = ?";
        $stmt = mysqli_prepare($conn, $sql); // preparing the statement
        if($stmt ){
            mysqli_stmt_bind_param($stmt, "s",  $param_username);

            //Setting the value of param username

            $param_username = trim($_POST['username']);

            //Try to execute the statement

            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "Username already taken";
                }
                else{
                    $username = trim($_POST['username']); 
                }
            }
            else{
              echo "Something went wrong";
            }
        }
    }
    mysqli_stmt_close($stmt);
}

// Check for Password

if(empty($_POST['password'])){
  $password_err = "Password cannot be blank";
}
elseif(strlen(trim($_POST['password'])) < 8){
  $password_err = "Password cannot be less than 8 characters";
}
else{
  $password = trim($_POST['password']);
}

// Check for Confirm Password

if(trim($_POST['password']) != trim($_POST['confirm_password'])){
  $confirm_password_err = "Passwords should match";
}

//if there is no error go ahead and insert into database

if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
  $sql = " INSERT INTO users (username, password) VAlUES(?, ?)";
  $stmt = mysqli_prepare($conn, $sql);
  if($stmt){
    mysqli_stmt_bind_param($stmt, 'ss', $param_username, $param_password);

    // Set these Parameters

    $param_username = $username;
    $param_password = password_hash($password, PASSWORD_DEFAULT);

    //Try to execute the query

    if(mysqli_stmt_execute($stmt)){
      header("location: login.php");
    }
    else{
      echo "Something went wrong... Cannot redirect";
    }
  }
  mysqli_stmt_close($stmt);
}
mysqli_close($conn);


?>








<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--
      - favicon
    -->
    <link rel="shortcut icon" href="/assets/images/logo/favicon-2.ico"  type="image/x-icon">

    <!--
      - custom css link
    -->
    <link rel="stylesheet" href="./assets/css/style-prefix.css">

    <!--
      - google font link
    -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap"
    rel="stylesheet">
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>Him's & Her's</title>
  </head>
  <body>
  <div class="header-main">

<div class="container">
    <img src="assets/images/banner101.png" alt="Him's and Her's logo" width="1140" height="175" style="margin-left: 2px;">
</div>

</div>
    </div>
    </nav>
    <div class="container mt-4">
        <h2><center>Registration<center></h2><hr>
    <form class="row g-3" action ="" method="post">
  <div class="col-md-6">
    <label for="inputEmail4" class="form-label">Username</label>
    <input type="text" class="form-control" name="username" id="inputEmail4" placeholder="username">
  </div>
  <div class="col-md-6">
    <label for="inputPassword4" class="form-label">Password</label>
    <input type="password" class="form-control" name="password" id="inputPassword4" placeholder="Password">
  </div>
  <div class="col-12">
    <label for="inputPassword4" class="form-label">Confirm Password</label>
    <input type="password" class="form-control" name="confirm password" id="inputPassword4" placeholder="Confirm Password">
  </div>
  <div class="col-12">
    <label for="inputAddress2" class="form-label">Address 2</label>
    <input type="text" class="form-control" id="inputAddress2" placeholder="Apartment, studio, or floor">
  </div>
  <div class="col-md-6">
    <label for="inputCity" class="form-label">City</label>
    <input type="text" class="form-control" id="inputCity">
  </div>
  <div class="col-md-4">
    <label for="inputState" class="form-label">State</label>
    <select id="inputState" class="form-select">
      <option selected>Choose...</option>
      <option>...</option>
    </select>
  </div>
  <div class="col-md-2">
    <label for="inputZip" class="form-label">Zip</label>
    <input type="text" class="form-control" id="inputZip">
  </div>
  <div style="display: flex; justify-content: center; align-items: center; height: 200px;">
    <button type="submit" class="btn btn-primary">Sign up</button>
  </div>
  <div style="display: flex; justify-content: center; align-items: center; height: 200px:">
    Already have an account ?<a href="login.php">Sign in<a>
  </div>
</form>


</div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js" integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js" integrity="sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ" crossorigin="anonymous"></script>
  </body>
</html>