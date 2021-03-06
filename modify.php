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
<?php
session_start();
?>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand company-name" href="index.php">Millhouse</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
      <?php
  
  if(isset($_SESSION['role'])){
     echo '<a class="nav-link" href="entries.php">Skapa inlägg <span class="sr-only">(current)</span></a>';
    }
    ?>
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
if(isset($_SESSION['username']) && isset($_SESSION['password']) && isset($_SESSION['role'])) {
echo "<h5>Välkommen " . $_SESSION['username'] . "</h5>";
echo '<a href="logout.php" class="r-link link text-underlined" id="logout-link">Sign Out</a>';
} else {
  header("location:index.php");
}


  include 'includes/database_connection.php';

  $stm = $pdo->prepare("SELECT Title, Entry, EntryDate, CategoryId FROM Entries WHERE Id=:id_IN");
  $stm->bindParam(":id_IN", $_GET['id']);
  $sucess = $stm->execute();
  if(!$sucess){
      header("location: modify.php?modify=error");
  }

$entryData = $stm->fetch();
 $entryId = $_GET['id'];



if(isset($_POST['change_entry'])){

    $title_change = $_POST['title'];
    $categories_change = $_POST['categories'];
    $entry_text_change = $_POST['entry_text'];

    $upload_folder = "images/"; 
    $image_file = $upload_folder . basename($_FILES['image']['name']);
    $file_type = strtolower(pathinfo($image_file, PATHINFO_EXTENSION));


if(empty($title_change) ||  empty($entry_text_change) || empty($file_type)) {
        header("Location: modify.php?id=$entryId&&modify=empty");
        die();
    }
    
  
  $verify = getimagesize($_FILES['image']['tmp_name']);

  if($verify == false) {
    header("Location: modify.php?id=$entryId&&modify=notImage");
      die();
  }
    
  if($_FILES['image']['size']>1000000) {
    header("Location: modify.php?id=$entryId&&modify=big");
    die();
  }
  
  if($file_type != "png" && $file_type != "gif" && $file_type != "jpg" && $file_type != "jpeg") {
    header("Location: modify.php?id=$entryId&&modify=incorrect");
      die();
  }

  
if (move_uploaded_file($_FILES['image']['tmp_name'], $image_file)){

        $sql = "UPDATE Entries SET Entry = :entry_IN, Title = :title_IN, CategoryId = :categoryId_IN, Image = :image_IN WHERE Entries.Id = :id_IN";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":entry_IN", $entry_text_change);
        $stmt->bindParam(":title_IN", $title_change);
        $stmt->bindParam(":categoryId_IN", $categories_change);
        $stmt->bindParam(':image_IN', $image_file);
        $stmt->bindParam(":id_IN", $_POST['id']);

  if($stmt->execute()) {
    header("Location: modify.php?modify=success");
  } else {
    header("Location: modify.php?modify=error");
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
  <h3>Ändra inlägg</h3>
    <form class="login-form" action="" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?=$_GET['id']?>">
      <input type="text" name="title" value="<?=$entryData['Title']?>">
      <select name="categories" id="select">
      <option value="">Kategorier</option>
      <option value="1">Kläder</option>
      <option value="2">Accesoarer</option>
      <option value="3">Inredning</option>
      </select>
      <input type="file" name="image">
      <textarea name="entry_text" id="textarea" cols="30" rows="10"><?=$entryData['Entry']?></textarea>
      <input id="button" type="submit" value="Ändra inlägg" name="change_entry">
    </form>
    <?php 
if(!isset($_GET['modify'])) {
  die();
}
else {
  $modify = $_GET['modify'];

  if($modify == "empty"){
    echo "<p class='error_form'> Vänligen fyll i alla rutor </p>";
    die();
  }
    elseif($modify == "success"){
    header("location:index.php");
    die();
  } elseif($modify == "error"){
    echo "<p class='error_form'> Något gick fel</p>";
    die();
  }elseif($modify == "notImage"){
    echo "<p class='error_form'>Filen du laddade upp är inte en bild</p>";
    die();
  }
  
  elseif($modify == "big"){
    echo "<p class='error_form'>Bilden du laddade upp är för stor</p>";
    die();
  }
  elseif($modify == "incorrect"){
    echo "<p class='error_form'>Du kan endast ladda upp följande filtyper: png, gif, jpeg, jpg</p>";
    die();
  }

}

?>

    </div>
    </div>
    </div>
    </body>
</html>