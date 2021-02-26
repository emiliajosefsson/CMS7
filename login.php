<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

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
$stm = $pdo->prepare("SELECT COUNT(id), username, password FROM users WHERE username=:username_IN AND password=:password_IN");

$stm->bindParam(":username_IN", $username);
$stm->bindParam(":password_IN", $userPassword); 
$stm->execute(); 

/*möjligen att vi ska lägga till här i if statement role för att skapa olika sessions beroende på admin eller 
user??*/
$return = $stm->fetch();
if($return[0]>0) {
session_start();  
$_SESSION['username'] = $username;
$_SESSION['password'] = $userPassword; 
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