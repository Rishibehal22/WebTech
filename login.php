<?php
//This script handles login

session_start();

// Check if the user is already logged in

if(isset($_SESSION['username'])){
  header("location: index.php");
  exit;
}

require_once "config.php";

$username = $password = "";
$username_err = $password_err = "";

//if request method is post

if($_SERVER['REQUEST_METHOD'] == "POST"){
  if(empty(trim($_POST['username']))){
    $username_err = "Please enter username";
  }
  elseif(empty(trim($_POST['password']))){
    $password_err = "Please enter password";
  }
  else{
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
  }
}

if(empty($username_err) && empty($password_err)){
  $sql = "SELECT id, username, password FROM users WHERE username = ?";
  $stmt = mysqli_prepare($conn, $sql);
  mysqli_stmt_bind_param($stmt, "s", $param_username);
  $param_username = $username;
  
  //Try to execute this statement

  if(mysqli_stmt_execute($stmt)){
    mysqli_stmt_store_result($stmt);
    if(mysqli_stmt_num_rows($stmt) == 1){
      mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
      if(mysqli_stmt_fetch($stmt)){
        if(password_verify($password, $hashed_password)){
          //password verified, Hence, begin the user session
          session_start();
          $_SESSION["username"] = $username;
          $_SESSION["id"] = $id;
          $_SESSION["loggedin"] = TRUE;

          //Redirect user to welcome page

          header("location: index.php");
        }
      }
    }
  }
}


?>

<!doctype html>
<html lang="en">
  <head>


    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> H&H</title>

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
      <img src="assets/images/banner101.png" alt="Him's and Her's logo" width="1140" height="200" style="margin-left: 2px;">
  </div>

</div>
      
     
    </ul>
  </div>
</nav>

<div class="container mt-4">
<h3>Please Login Here:</h3>
<hr>

<form action="" method="post">
  <div class="form-group">
    <label for="exampleInputEmail1">Username</label>
    <input type="text" name="username" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Username">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Password</label>
    <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Enter Password">
  </div>
  <div style="display: flex; justify-content: center; align-items: center; height: 200px;">
    <button type="submit" class="btn btn-primary" style="margin-right: 10px;">Sign in</button>
    <a class="nav-link" href="register.php" ><button type="button" class="btn btn-primary">Sign up</button></a>
  </div>

</form>



</div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>