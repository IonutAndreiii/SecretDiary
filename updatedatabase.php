<?php

  session_start();
  if(array_key_exists("content",$_POST)){
   
    include("connection.php");

    $query = "UPDATE `users` SET `diary` = '".mysqli_real_escape_string($conn, $_POST['content'])."' WHERE id= ".mysqli_real_escape_string($conn, $_SESSION['id'])." LIMIT 1";
   
       mysqli_query($conn, $query);
            
}
?>