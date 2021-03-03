<?php

$dsn = "mysql:host=localhost;dbname=Millhouse";
$user = "root";
$password = "";
$pdo = new PDO($dsn, $user, $password);

?> 





<!-- SELECT Comment, Username, CommentDate, Title, Entry, EntryDate, CategoryId, Entries.Id 
FROM Comments 
JOIN Users ON Comments.UsersId = Users.Id 
JOIN Entries ON Comments.EntriesId = Entries.Id WHERE Entries.Id = $entryId AND EntriesId = $entryId; -->