<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Startsida</title>
    <link rel="stylesheet" href="css/style.css" type="text/css">
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
if(isset($_SESSION['username']) && isset($_SESSION['password']) ) {
echo "<h5>Välkommen " . $_SESSION['username'] . "</h5>";
echo '<a href="logout.php">Logga ut</a>';
} else {
  header("location:login.php");
}
?>
    </span>
  </div>
</nav>        
<div class="site">
	<div class="hero">
		<h1 class="h1hero">Millhouses Blogg</h1>
	</div>
  <?php
include 'includes/database_connection.php';


$stm = $pdo->query("SELECT Title, Entry, EntryDate, CategoryId, Entries.Id, Image, CategoryName FROM Entries JOIN Categories ON Entries.CategoryId = Categories.Id ORDER BY EntryDate DESC");

while($row = $stm->fetch()):
    ?>
  <section class="section">
  <h2><?=$row['Title']?></h2>
  <p> <?=$row['EntryDate']?></p>
  <p> <?=$row['CategoryName']?></p>
  <img src="<?=$row['Image']?>" alt="EntriesImage"><br></br>
		<p> <?=$row['Entry']?></p>
<?php
if(isset($_SESSION['role'])){
   echo "<a href='delete.php?id=".$row['Id']."'>Ta bort</a></br>";
   echo "<a href='modify.php?id=".$row['Id']."'>Ändra</a></br>";
}
echo "<a class='entry_button' href='comments.php?id=".$row['Id']."'>Se inlägg och kommentera</a>";
?>
	</section>
  <?php  endwhile;

        ?>
	<footer>
		<p>Millhouse AB</p>
	</footer>
</div>
</body>
</html>


