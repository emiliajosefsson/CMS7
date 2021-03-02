<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</head>
<body>
<!--Ska millhouse vara klickbart? -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand company-name" href="#">Millhouse</a>
</nav>

<?php
if(isset($_POST['login'])){
include 'includes/database_connection.php';

$salt = "haue7ahh%/he=(**påjhfi2";
$username = $_POST['username'];
$userPassword = $_POST['password']; 

if(empty($username) || empty($userPassword) ) {
  header("Location: login.php?login=empty");
  die();
} 

else {
$userPassword = md5($userPassword.$salt);
$stm = $pdo->prepare("SELECT COUNT(Id), Username, Password, Role, Id FROM Users WHERE Username=:username_IN AND Password=:password_IN");

$stm->bindParam(":username_IN", $username);
$stm->bindParam(":password_IN", $userPassword); 
$stm->execute(); 


/*möjligen att vi ska lägga till här i if statement role för att skapa olika sessions beroende på admin eller 
user??*/
$return = $stm->fetch();

  if($return['Role'] == "Admin"){
    $role = $return['Role'];
   }

  $id = $return['Id'];

if($return[0]>0) {
session_start();  
$_SESSION['username'] = $username;
$_SESSION['password'] = $userPassword; 
$_SESSION['role'] = $role;
$_SESSION['Id'] = $id;

header("Location:index.php");
} else {
  header("Location: login.php?login=wrong");
  die();
}
}
};
?>

<div class="login-page">
  <div class="form">
  <h3>Sign in to your account</h3>
    <form class="login-form" action="login.php" method="POST">
      <input type="text" placeholder="username" name="username"/>
      <input type="password" placeholder="password" name="password"/>
      <input id="button" type="submit" value="login" name="login">
      <p class="message">Not registered? <a href="register.php">Create an account</a></p>
    </form>
    <?php
    if(!isset($_GET['login'])) {
    die();
    }
    else {
    $login = $_GET['login'];

    if($login == "empty"){
    echo "<p class='error_form'> Vänligen fyll i alla rutor </p>";
    die();
    } elseif($login == "wrong"){
    echo "<p class='error_form'> Användarnamnet eller lösenordet är fel </p>";
    die();
    }
  };
    ?>
  </div>
</div>
</body>
</html>