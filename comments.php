<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comments</title>
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
if(isset($_SESSION['username']) && isset($_SESSION['password'])) {
echo "<h5>Välkommen " . $_SESSION['username'] . "</h5>";
echo '<a href="logout.php">Logga ut</a>';
} else {
  header("location:index.php");
}
?>
    </span>
  </div>
</nav>
<?php
include 'includes/database_connection.php';
$entryId = $_GET['id'];
$stm = $pdo->query("SELECT Title, Entry, EntryDate, CategoryId, Entries.Id, Image, CategoryName FROM Entries JOIN Categories ON Entries.CategoryId = Categories.Id WHERE Entries.Id = $entryId");

while($row = $stm->fetch()):
    ?>
  <section class="section">
		<h2><?=$row['Title']?></h2>
    <p> <?=$row['EntryDate']?></p>
    <p> <?=$row['CategoryName']?></p>
    <img src="<?=$row['Image']?>" alt="EntriesImage">
		<p> <?=$row['Entry']?></p>
<?php
if(isset($_SESSION['role'])){
   echo "<a href='delete.php?id=".$row['Id']."'>Ta bort</a></br>";
   echo "<a href='modify.php?id=".$row['Id']."'>Ändra</a>";

}
?>
	</section>


  <div class="hero">
<div class="login-page">
  <div class="form">
  <h3>Skriv din kommentar</h3>
    <form class="login-form" action="handleComments.php?id=<?=$row['Id']?>" method="POST">
      <input type="date" name="comment_date"/>
      <textarea name="comment_text" id="textarea" cols="30" rows="10" placeholder="skriv din kommentar här..."></textarea>
      <input id="button" type="submit" value="Skicka kommentar" name="create_comment">
    </form>
    <?php
    if(!isset($_GET['comment'])) {
     
      }
      else {
      $comment = $_GET['comment'];
  
      if($comment == "empty"){
      echo "<p class='error_form'> Vänligen fyll i alla rutor </p>";
      
      } elseif($comment == "error"){
        echo "<p class='error_form'> Något gick fel</p>";
       
      }
    }
    ?>
    </div>
    </div>
</div>

  <?php  endwhile;

?>
<section class="section">
            <h3>Kommentarer</h3>
<?php 

$stmt = $pdo->query("SELECT Comment, Username, CommentDate, Comments.Id 
FROM Comments 
JOIN Users ON Comments.UsersId = Users.Id WHERE EntriesId = $entryId ORDER BY CommentDate DESC");
while($row = $stmt->fetch()):
?>
    
            <p><b><?=$row['Username']?></b></p>
            <p><?=$row['CommentDate']?></p>
            <p><?=$row['Comment']?></p>
  
  <?php if(isset($_SESSION['role'])){
   echo "<a href='deleteComments.php?commentid=".$row['Id']."&&id=$entryId'>Ta bort</a></br>";
  };
?>
<?php  endwhile;

?>
  </section>
       
    
    </body>
</html>