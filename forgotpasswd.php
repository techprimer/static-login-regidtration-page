<?php

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'register');

// Try connecting to the Database
$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

$msg="";
if($_POST)
{
	$emailid = $_POST["emailid"];

		$sql = "SELECT * FROM account WHERE emailid = '{$emailid}'" or die(mysqli_error) ;
		$result = mysqli_query($conn,$sql);
		$user = mysqli_fetch_array($result) ;



	if($user > 0)
	{	
			

			// Import PHPMailer classes into the global namespace
			// These must be at the top of your script, not inside a function
		

				// Load Composer's autoloader
				require_once('class.PHPMailer.php');
				require_once('class.smtp.php');

				require('maildemo/vendor/autoload.php');
				// Instantiation and passing `true` enables exceptions
				$mail = new PHPMailer(true);

		
			    //Server settings
			    $mail->SMTPDebug = 2;                                       // Enable verbose debug output
			    $mail->isSMTP();                                            // Set mailer to use SMTP
			    $mail->Host       = 'smtp.gmail.com'; 
			    $mail->SMTPOptions = array(
								   'ssl' => array(
										'verify_peer' => false,
										'verify_peer_name' => false,
										'allow_self_signed' => true
										    )
										);

			     // Specify main and backup SMTP servers
			    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
			    $mail->Username   = '';                     // SMTP username
			    $mail->Password   = '';                               // SMTP password
			    $mail->SMTPSecure = 'ssl';                                  // Enable TLS encryption, `ssl` also accepted
			    $mail->Port       = 465;                                    // TCP port to connect to

			    $mail->setFrom('from@example.com', 'Mailer');
			    $mail->addAddress('joe@example.net', 'Joe User');     // Add a recipient
			    $mail->addAddress('ellen@example.com');               // Name is optional
			    $mail->addReplyTo('info@example.com', 'Information');
			    $mail->addCC('cc@example.com');
			    $mail->addBCC('bcc@example.com');

			    // Attachments
			    $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
			    $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

			    // Content
			    $mail->isHTML(true);                                  // Set email format to HTML
			    $mail->Subject = 'Here is the subject';
			    $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
			    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';



				if(!$mail->Send()) {
					$msg = 'Problem in Sending Password Recovery Email';
				} else {
					$msg = 'Please check your email to reset password!';
				}

		}

	
	else{
		$msg = "<font color='red'>emailid not found in our database</font>";

	}
}

?>

<!DOCTYPE html>
<html>
<head>
	<title> forgot password</title>
	<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
	<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
	 <link rel="icon" href="kicon.png">
	<link rel="stylesheet" href="demo1.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
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
	
 <div class="form-gap"></div>
<div class="container">
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
            
             <div class="panel-body">
                <div class="text-center">
                 <h3><i class="fa fa-lock fa-4x"></i></h3>
                  <h2 class="text-center" >Forgot Password?</h2>
                  <p>You can reset your password here.</p>
                  <div class="panel-body">
    
                    <form id="register-form" role="form" autocomplete="off" class="form" method="post">
    
                      <div class="form-group">
                        <div class="input-group">
                          <span class="input-group-addon"><i class="glyphicon glyphicon-envelope color-blue"></i></span>
                          <input id="email" name="emailid" placeholder="email address" class="form-control"  type="email">
                        </div>
                      </div>
                      <div class="form-group">
                        <input name="recover-submit" class="btn btn-lg btn-primary btn-block" value="Reset Password" type="submit">
                      </div>
                      
                      <input type="hidden" class="hide" name="token" id="token" value=""> 
                    </form>
    
                  </div>
                </div>
              </div>
            </div>
          </div>
	</div>
</div>

</body>
</html>