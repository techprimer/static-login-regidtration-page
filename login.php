<?php
//This script will handle login
session_start();

// check if the user is already logged in

require_once "config.php";

$username = $password = "";
$err = "";

// if request method is post
if ($_SERVER['REQUEST_METHOD'] == "POST"){
    if(empty(trim(isset($_POST['username']))) || empty(trim(isset($_POST['password']))))
    {
        $err = "Please enter username + password";
        
    }
    else{
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
    }


if(empty($err))
{
    $sql = "SELECT id, username, password FROM account WHERE username = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $param_username);
    $param_username = $username;
    
    
    // Try to execute this statement
    if(mysqli_stmt_execute($stmt)){
        mysqli_stmt_store_result($stmt);
        if(mysqli_stmt_num_rows($stmt) == 1)
                {
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt))
                    {
                        if(password_verify($password, $hashed_password))
                        {
                            // this means the password is corrct. Allow user to login
                            session_start();
                            $_SESSION["username"] = $username;
                            $_SESSION["id"] = $id;
                            $_SESSION["loggedin"] = true;

                            //Redirect user to welcome page
                            header("location: welcome.php");
                            
                        }
                    }

                }
        else
        {
            $err ="please enter valid username and password";
            echo "<script type='text/javascript'> window.onload = function(){alert(\"$err\");}</script>";
          
        }
       

    }
}    


}


?>




<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>klassyink login form</title>
        <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="HandheldFriendly" content="true">
        <link rel="stylesheet" href="loginstyle.css">
        <link rel="icon" href="kicon.png">
        <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    </head>
    <body>
        <div class="main">
            <nav >
            <img src="klogo.png"  width="200" height="65" >
                <ul class="nav-links">
                    <li><a href="#home">HOME</a></li>
                    <li class="sub-menu"><a href="#">CATEGORIES</a>
                        <ul>
                            <li><a href="#home">T-shirt</a></li>
                            <li><a href="#home">mobile cover</a></li>
                        </ul>
                    <li><a href="#">BLOG</a></li>
                    <li><a href="#about us">ABOUTUS</a></li>
                    <li><a href="#contact">CONTACT</a></li>
                </ul>

                <div class="lines">
                   <i class="fa fa-bars" aria-hidden="true" ></i>
                </div>
            </nav>
              <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
              <script type="text/javascript">
                    $(document).ready(function(){
                         $('ul li').click(function(){
                             $(this).siblings().removeClass('active');
                            $(this).toggleClass('active');
                           
                })
            })
            
        </script>
            <script src="app.js"></script>
        </div>
            
        <div class="box">
            <img src="logo2.jpg" class="userimage" >
            <h2>LOGIN FORM</h2>
            
            <form action="" method="post" autocomplete="off">
                <div class="inputbox">
                    <input type="text" name="username" required="">
                    <label>Username</label>
                </div>
                <div class="inputbox">
                    <input type="password" name="password" required="">
                    <label>Password</label>
                </div>
                <button type="submit"   name="submit" value="login">LOGIN</button> 
                <a href="forgotpasswd.php" >Forgot password?</a><br>
                <div class="login_link"
                <p>don't have account?
                <a href="registration.php">signup here</a></p>
                </div>                
            </form>
        </div>
    </body>
</html>    





