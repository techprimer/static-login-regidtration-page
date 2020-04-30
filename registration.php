<?php
require_once "config.php";

$firstname=$lastname = $emailid = $username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = $firstname_err = $lastname_err = $emailid_err = "";

if ($_SERVER['REQUEST_METHOD'] == "POST"){

    // Check if username is empty
    if(empty(trim($_POST["username"]))){
             echo"<font color = '#fff'><p align='center' >Username cannot be blank</p></font>";
    }
    else{
        $sql = "SELECT id FROM account WHERE username = ?";
        $stmt = mysqli_prepare($conn, $sql); die(mysqli_error($conn));
        if($stmt)
        {
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Set the value of param username
            $param_username = trim($_POST['username']);

            // Try to execute this statement
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                if(mysqli_stmt_num_rows($stmt) == 1)
                {
                    $username_err = "This username is not available "; 
                    //echo "$username_err";
                    echo "<script type='text/javascript'>  window.onload = function(){alert(\"$username_err\");}</script>";
                }
                else{
                    $username = trim($_POST['username']);
                }
            }
            else{
                echo "Something went wrong";
            }
        }
    }
    mysqli_stmt_close($stmt);


            // Check for password
            if(empty(trim($_POST['password']))){
                $password_err = "Password cannot be blank";
            }
            elseif(strlen(trim($_POST['password'])) < 5){
                $password_err = "Password cannot be less than 5 characters";
                echo "<script type='text/javascript'>  window.onload = function(){alert(\"$password_err\");}</script>";
            }
            else{
                $password = trim($_POST['password']);
            }

            // Check for confirm password field
            if(trim($_POST['password']) !=  trim($_POST['confirm_password'])){
                $password_err = "Password and Confirm Password do not match";
                echo "<script type='text/javascript'> window.onload = function(){alert(\"$password_err\");}</script>";

            }

            //check for firstname
            if(empty(trim($_POST['firstname']))){
                $firstname_err = "firstname  compulsory";
            }
            else{
                $firstname = trim($_POST['firstname']);
            }
            //check for lastname
            if(empty(trim($_POST['lastname']))){
                $lastname_err = "lastname compulsory";
            }
            else{
                $lastname = trim($_POST['lastname']);
            }

            //check for email
           if(empty(trim($_POST['emailid']))){
                    $emailid_err = "lastname compulsory";
                }
                else{
                    $emailid = trim($_POST['emailid']);
                }

            


            // If there were no errors, go ahead and insert into the database
            if(empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($emailid_err))
            {
                $sql = "INSERT INTO account (firstname, lastname, emailid, username, password) VALUES (?, ? , ?, ?, ?)";
                $stmt = mysqli_prepare($conn, $sql);
                if ($stmt)
                {
                    mysqli_stmt_bind_param($stmt, "sssss", $param_firstname , $param_lastname , $param_emailid , $param_username, $param_password);

                    // Set these parameters
                    $param_firstname =$firstname;
                    $param_lastname = $lastname;
                    $param_emailid = $emailid;
                    $param_username = $username;
                    $param_password = password_hash($password, PASSWORD_DEFAULT);

                    // Try to execute the query
                    if (mysqli_stmt_execute($stmt))
                    {
                        header("location: login.php");
                    }
                    else{
                        echo "Something went wrong... cannot redirect!";
                    }
                }
                mysqli_stmt_close($stmt);
            }
            mysqli_close($conn);
            }

?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="HandheldFriendly" content="true">
		<title>klassyink signup form</title>
        <link rel="icon" href="kicon.png">
		<link rel="stylesheet" href="regstylingsheet.css">
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
                    </li>
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
            

		<div class="wrap">
			<img src="avtar.jpg" class="userimage" width="100%">
			<h2>signup form</h2>

			<form autocomplete="off" action="" method="POST">
				<input type="text"  name="firstname" placeholder="First Name .." required="" />
				<input type="text"  name="lastname" placeholder="Last Name .." required="" />
				<input type="text"  name="username" placeholder="User Name .." required="" />
				<input type="email"  pattern=".+@gmail.com" name="emailid" placeholder="Email Id .." data-toggle="tooltip" data-placement="top" title="please provide email-address which contain domain as gmail.com" required="" />
				<input type="password"  name="password" placeholder="Password  .." autocomplete="new-password" required="" />
				<input type="password"  name="confirm_password" placeholder="re-enter Password  .." autocomplete="new-password" required="" />
				<!--<input type="submit" value="submit">-->
                <button type="submit" value="submit" >Register</button><br> 
                <p class="login_link">already have an account?
                <a href="login.php">login here</a></p>
			</form>
		</div>
     </body>   

</html>