<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrera</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand company-name" href="login.php">Millhouse</a>
</nav>
<div class="hero">
<?php


if(isset($_POST['create'])){
  
include 'includes/database_connection.php';


$username = $_POST['username'];
$password = $_POST['password'];

 if(empty($username) || empty($password) ) {
  header("Location: register.php?signup=empty");
  die();
}
else {
  $salt = "haue7ahh%/he=(**påjhfi2";
$password = md5($password.$salt);
$stmt = $pdo->query("SELECT username FROM Users");


while($row = $stmt->fetch()){
  if($row['username'] == $username){
    header("Location: register.php?signup=exist");
      die();
   }}


$sql = "INSERT INTO Users (username, password) VALUES(:username_IN, :password_IN)";
$stm = $pdo->prepare($sql);
$stm->bindParam(':username_IN', $username);
$stm->bindParam(':password_IN', $password);

if($stm->execute()) {
  header("Location: register.php?signup=success");
} else {
  header("Location: register.php?signup=error");
}
}}

?>

<div class="login-page">
  <div class="form">
  <h3>Skapa ett nytt konto</h3>
    <form class="login-form" action="register.php" method="POST">
      <input type="text" placeholder="* användarnamn" name="username"/>
      <input type="password" placeholder="* lösenord" name="password"/>
      <input id="button" type="submit" value="skapa konto" name="create">
      <p class="message">Har du redan ett konto? <a href="login.php">Logga in här</a></p>
    </form>
    <?php
    if(!isset($_GET['signup'])) {
      die();
    }
    else {
      $signup = $_GET['signup'];

      if($signup == "empty"){
        echo "<p class='error_form'> Vänligen fyll i alla rutor </p>";
        die();
      } elseif($signup == "exist"){
        echo "<p class='error_form'> Användarnamnet används redan </p>";
        die();
      } elseif($signup == "success"){
        header("location:login.php");
        die();
      } elseif($signup == "error"){
        echo "<p class='error_form'> Något gick fel</p>";
        die();
      }

    }

    ?>
  </div>
</div>
  </div>
</body>
</html>