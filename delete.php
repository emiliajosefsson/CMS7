<?php
include 'includes/database_connection.php';

$id = $_GET['id'];
$sql = "DELETE FROM Entries WHERE Entries.Id = $id";
$stm = $pdo->prepare($sql);

if($stm->execute()){
    header("location: index.php");
} else {
    echo "Något gick fel";
}

?>