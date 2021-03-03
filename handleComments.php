<?php
session_start();
include 'includes/database_connection.php';

//if(isset($_POST['create_comment'])){
  
  $comment_date = $_POST['comment_date'];
  $comment_text = $_POST['comment_text'];
  $userId = $_SESSION['Id'];  
  $username = $_SESSION['username'];
  $entryId = $_GET['id'];

  if(empty($comment_date) || empty($comment_text)) {
    header("Location: comments.php?id=$entryId&&comment=empty");
    die();
  }

  $sql = "INSERT INTO Comments (EntriesId, Comment, CommentDate, UsersId) VALUES(:entriesId_IN, :comment_IN, :commentDate_IN, :usersId_IN)";
  $stmt = $pdo->prepare($sql);
  $stmt->bindParam(':entriesId_IN', $entryId);
  $stmt->bindParam(':comment_IN', $comment_text);
  $stmt->bindParam(':commentDate_IN', $comment_date);
  $stmt->bindParam(':usersId_IN', $userId);

  if($stmt->execute()) {
    //header("Location: handleComments.php?comment=success");
    header("Location: comments.php?id=$entryId");
  } else {
    //header("Location: handleComments.php?comment=error");
    header("Location: comments.php?id=$entryId&&comment=error");
 // }
};
?>