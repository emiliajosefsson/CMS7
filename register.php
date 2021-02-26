<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
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
  <h3>Create a new account</h3>
    <form class="login-form" action="register.php" method="POST">
      <input type="text" placeholder="* username" name="username"/>
      <input type="password" placeholder="* password" name="password"/>
      <input id="button" type="submit" value="create account" name="create">
      <p class="message">Already registered? <a href="login.php">Sign in</a></p>
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
        /*echo "<p class='success_form'> Du har skapat ett konto</p>";*/
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
</body>
</html>