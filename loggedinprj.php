
<?php

session_start();
$diaryContent = "";

if(array_key_exists("id", $_COOKIE)){

   $_SESSION['id'] = $_COOKIE['id'];

}

if(array_key_exists("id",$_SESSION)){

   include("connection.php");
   $query = "SELECT diary FROM `users` WHERE id = ".mysqli_real_escape_string($conn,$_SESSION['id'])." LIMIT 1";
    $row = mysqli_fetch_array(mysqli_query($conn,$query));
    $diaryContent = $row['diary'];

} else {

    header("Location: project.php");
    
}
include("header.php"); 
?>
<nav class="navbar navbar-light bg-faded navbar-fixed-top">
  <a class="navbar-brand" id="SecretDiary" href="#">Secret Diary</a>

  <div class="pull-xs-right">

    <a href="project.php?logout=1"><button class="btn btn-success" type="submit">Logout</button></a>
  </div>
</nav> 

<div class="container-fluid">
    <textarea id="diary" class="form-control"><?php echo $diaryContent; ?></textarea>
</div>

<?php

 include("footer.php");

 ?>
