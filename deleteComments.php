<?php
if(!isset($_SESSION['username']) && !isset($_SESSION['password']) && !isset($_SESSION['role'])) {

    header("location:login.php");
  }

include 'includes/database_connection.php';

$commentId = $_GET['commentid'];
$entryId = $_GET['id'];
$sql = "DELETE FROM Comments WHERE Comments.Id = $commentId";
$stm = $pdo->prepare($sql);

if($stm->execute()){
    header("location: comments.php?id=$entryId");
} else {
    echo "Något gick fel";
}

?> 


