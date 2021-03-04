<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entries</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand company-name" href="index.php">Millhouse</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="entries.php">? <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Kategorier
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
        <a class="dropdown-item" href="clothes.php">Kläder</a>
          <a class="dropdown-item" href="accessories.php">Accesoarer</a>
          <a class="dropdown-item" href="interior.php">Inredning</a>
        </div>
      </li>
    </ul>
    <span class="navbar-text">
    <?php
session_start();
if(isset($_SESSION['username']) && isset($_SESSION['password']) && isset($_SESSION['role'])) {
echo "<h5>Välkommen " . $_SESSION['username'] . "</h5>";
echo '<a href="logout.php">Logga ut</a>';
} else {
  header("location:index.php");
}


if(isset($_POST['create_entry'])){
  
  include 'includes/database_connection.php';

  //$image = $_FILES['image'];
  $title = $_POST['title'];
  $date = $_POST['date'];
  $categories = $_POST['categories'];
  $entry_text = $_POST['entry_text'];
  $userId = $_SESSION['Id'];

  if(empty($title) || empty($date) || empty($categories) || empty($entry_text)){
    header("Location: entries.php?entries=empty");
    die();
  }

$upload_folder = "images/"; 
$image_file = $upload_folder . basename($_FILES['image']['name']);
$file_type = strtolower(pathinfo($image_file, PATHINFO_EXTENSION));



  if(isset($title)) {
    $verify = getimagesize($_FILES['image']['tmp_name']);

if($verify == false) {
  echo "the file not an image";
  die();
}
  }

if(file_exists($image_file)){
  echo " file already exist";
  die();
}
  
if($_FILES['image']['size']>1000000) {
echo "The file is too big"; 
die; 
}


if($file_type != "png" && $file_type != "gif" && $file_type != "jpg" && $file_type != "jpeg") {
  echo "you can only upload ..";
  die();
}

if (move_uploaded_file($_FILES['image']['tmp_name'], $image_file)){

  $sql = "INSERT INTO Entries (Title, Entry, EntryDate, CategoryId, UsersId, Image) VALUES(:title_IN, :entry_IN, :entryDate_IN, :categoryId_IN, :usersId_IN, :image_IN)";
  $stm = $pdo->prepare($sql);
  $stm->bindParam(':title_IN', $title);
  $stm->bindParam(':entry_IN', $entry_text);
  $stm->bindParam(':entryDate_IN', $date);
  $stm->bindParam(':categoryId_IN', $categories);
  $stm->bindParam(':usersId_IN', $userId);
  $stm->bindParam(':image_IN', $image_file);

  if($stm->execute()) {
    header("Location: entries.php?entries=success");
  } else {
    header("Location: entries.php?entries=error");
  }
  
}
}
?>
    </span>
  </div>
</nav>
<div class="hero">
<div class="login-page">
  <div class="form">
  <h3>Skapa inlägg</h3>
    <form class="login-form" action="" method="POST" enctype="multipart/form-data">
      <input type="text" placeholder="title" name="title"/>
      <input type="date" name="date"/>
      <select name="categories" id="select">
      <option value="1">Kläder</option>
      <option value="2">Accesoarer</option>
      <option value="3">Inredning</option>
      </select>
      <input type="file" name="image">
      <textarea name="entry_text" id="textarea" cols="30" rows="10" placeholder="skriv ditt inlägg här..."></textarea>
      <input id="button" type="submit" value="Skapa inlägg" name="create_entry">
    </form>
    <?php 
if(!isset($_GET['entries'])) {
  die();
}
else {
  $entries = $_GET['entries'];

  if($entries == "empty"){
    echo "<p class='error_form'> Vänligen fyll i alla rutor </p>";
    die();
  }
    elseif($entries == "success"){
    /*echo "<p class='success_form'> Du har skapat ett konto</p>";*/
    header("location:index.php");
    die();
  } elseif($entries == "error"){
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


