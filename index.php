<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link rel="stylesheet" href="css/newstyle.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand company-name" href="#">Millhouse</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Kategorier
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="#">Kläder</a>
          <a class="dropdown-item" href="#">Accesoarer</a>
          <a class="dropdown-item" href="#">Inredning</a>
        </div>
      </li>
    </ul>
    <span class="navbar-text">
    
<?php
session_start();
if(isset($_SESSION['username']) && isset($_SESSION['password'])) {
echo "<h5>Välkommen " . $_SESSION['username'] . "</h5>";
echo '<a href="logout.php">Sign Out</a>';
} else {
  header("location:login.php");
}
?>
       <!-- <a href="logout.php">Sign Out</a>-->
    </span>
  </div>
</nav>

<div class="site">
	<div class="hero">
		<h1 class="h1hero">Millhouse's Blog</h1>
	</div>

	<section class="section">
		<h2>A Section</h2>
		<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Itaque, minus laudantium excepturi incidunt voluptate impedit quisquam. Dicta sed, ea perferendis consequuntur expedita nesciunt nam quae omnis voluptatibus corporis. Voluptate, cumque?</p>
	</section>
	<section class="section">
		<h2>A Section</h2>
		<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Itaque, minus laudantium excepturi incidunt voluptate impedit quisquam. Dicta sed, ea perferendis consequuntur expedita nesciunt nam quae omnis voluptatibus corporis. Voluptate, cumque?</p>
	</section>
	<section class="section">
		<h2>A Section</h2>
		<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Itaque, minus laudantium excepturi incidunt voluptate impedit quisquam. Dicta sed, ea perferendis consequuntur expedita nesciunt nam quae omnis voluptatibus corporis. Voluptate, cumque?</p>
	</section>
	<section class="section">
		<h2>A Section</h2>
		<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Itaque, minus laudantium excepturi incidunt voluptate impedit quisquam. Dicta sed, ea perferendis consequuntur expedita nesciunt nam quae omnis voluptatibus corporis. Voluptate, cumque?</p>
	</section>
	<footer>
		<p>Millhouse AB</p>
	</footer>
</div>
</body>
</html>