<?php

session_start();
$error = "";

 if(array_key_exists("logout",$_GET)){

    unset($_SESSION);
    setcookie("id","", time() - 60*60);
    $_COOKIE["id"] = "";
 } else if((array_key_exists("id",$_SESSION) AND $_SESSION['id']) OR (array_key_exists("id",$_COOKIE) AND $_COOKIE['id'])){

    header("Location: loggedinprj.php"); 
 }

if(array_key_exists("submit",$_POST)){

      include("connection.php");

     if(!$_POST['email']){

        $error .="An email adress is required<br>";

     }
     if(!$_POST['password']){

        $error .="A password is required<br>";
     }
     if($error != ""){

        $error="<p>There were error(s) in your form:</p>".$error;
     } else {
        

        if($_POST["signUp"] == '1'){

            $query = "SELECT id FROM `users` WHERE email = '".mysqli_real_escape_string($conn,$_POST['email'])."' LIMIT 1";
            $result = mysqli_query($conn, $query);
            if(mysqli_num_rows($result)>0){
    
    
                $error .= "That email adress is taken.";
            }else {
    
                $query = "INSERT INTO `users` (`email`,`password`) VALUES('".mysqli_real_escape_string($conn,$_POST['email'])."', '".mysqli_real_escape_string($conn,$_POST['password'])."')";
    
                if(!mysqli_query($conn, $query)){
    
                    $error = "<p>Could not sign you up - please try again later.</p>";
    
                }else {
              
                    $query = "UPDATE `users` SET password = '".md5(md5(mysqli_insert_id($conn)).$_POST['password'])."' WHERE id=".mysqli_insert_id($conn)." LIMIT 1";
                    mysqli_query($conn, $query);
                    $_SESSION['id'] = mysqli_insert_id($conn);
                    if($_POST['stayLoggedIn'] == '1' ){
    
                        setcookie("id",mysqli_insert_id($conn), time() + 60*60*24*365);
    
                    }
                    header("Location: loggedinprj.php");
                }
            } 
 

        } else {

               $query = "SELECT * FROM `users` WHERE email = '".mysqli_real_escape_string($conn,$_POST['email'])."'";
               $result = mysqli_query($conn, $query);
               $row = mysqli_fetch_array($result);
               if(isset($row)){

                $hashedPassword = md5(md5($row['id']).$_POST['password']);
                if($hashedPassword == $row['password']){

                    $_SESSION['id'] = $row['id'];
                    if($_POST['stayLoggedIn'] == '1' ){
    
                        setcookie("id",$row['id'], time() + 60*60*24*365);
    
                    }  
                    header("Location: loggedinprj.php");
 
                } else {
                    $error = "That email/password combination could not be found.";
                }
               } else {

                $error = "That email/password combination could not be found.";
               }

        }
        

     } 
}

?>
     <?php include("header.php"); ?>

    <div class="container" id="homePageContainer">   
    <h1>Secret Diary</h1>
    <p>Store your thoughts permanently and securely.</p>
    <div id="error"><?php if($error!="") {
  
     echo '<div class="alert alert-danger role="alert">'.$error.'</div>';
     
    }; ?></div> 
    
    <form method="post" id="signupform">
    <h5>Interesed? Sign up now.</h5> 
  <div class="form-group">
    <input name="email" type="text" id="email" class="form-control" placeholder="Your email">
  </div>
  <div class="form-group">
    <input type="password" name="password" class="form-control" id="password" placeholder="Password">
  </div>
  <div class="form-check">
    <input type="checkbox" class="largerCheckbox" id="checkbox"  name="stayLoggedIn" value=1>
    <label class="form-check-label" for="checkbox">Stay logged in</label><br>
    <input type="hidden" name="signUp" value="1">
  <input type="submit" class="btn btn-success" name="submit" value="Sign Up!">
  </div>
  <a class="toggleform" id="login">Log In!</a>
  </form>

  <form method="post" id="loginform">
  <h5>Enter your email and password down below.</h5> 
  <div class="form-group">
    <input name="email" type="text" id="email" class="form-control" placeholder="Your email">
  </div>
  <div class="form-group">
    <input type="password" name="password" class="form-control" id="password" placeholder="Password">
  </div>
  <div class="form-check">
    <input type="checkbox" class="largerCheckbox" id="checkbox" name="stayLoggedIn" value=1>
    <label class="form-check-label" for="checkbox">Stay logged in</label><br>
    <input type="hidden" name="signUp" value="0">
  <input type="submit" class="btn btn-success" name="submit" value="Log In!">
  </div>
  <a class="toggleform" id="signup">Sign Up!</a>
  </form>
    </div>
   

<?php include("footer.php"); ?>