<?php include_once "header.php";
if(isset($_SESSION['user'])){
    header('Location:index.php');
}
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
// Load Composer's autoloader
require 'vendor/autoload.php';
?>
        <!-- Breadcrumb Area Start -->
        <div class="breadcrumb-area bg-image-3 ptb-150">
            <div class="container">
                <div class="breadcrumb-content text-center">
					<h3>LOGIN</h3>
                    <ul>
                        <li><a href="index.html">Home</a></li>
                        <li class="active">Login</li>
                    </ul>
                </div>
            </div>
        </div>
		<!-- Breadcrumb Area End -->
        <div class="login-register-area ptb-100">
            <div class="container">
                <div class="row">
                    <div class="col-lg-7 col-md-12 ml-auto mr-auto">
                        <div class="login-register-wrapper">
                            <div class="login-register-tab-list nav">
                                <a class="active" data-toggle="tab" href="#lg1">
                                    <h4> login </h4>
                                </a>
                            </div>
                            <div class="tab-content">
                                <div id="lg1" class="tab-pane active">
                                    <div class="login-form-container">
                                        <div class="login-register-form">
                                            <?php
                                                if(!empty($_POST)){
                                                    $errors = [];
                                                    $email = $_POST['email'];
                                                    $password = $_POST['password'];
                                                    include_once "User.php";
                                                    $user = new User();
                                                    $user->setEmail($email);
                                                    $user->setPass($password);
                                                    $result = $user->login();
                                                    if(!empty($result)){
                                                        $loggedUser = $result->fetch_object();
                                                        if($loggedUser->status == 1){
                                                            $_SESSION['user'] = $loggedUser;
                                                            header('Location:index.php');
                                                        }elseif($loggedUser->status == 2){
                                                            // send code
                                                            $mail = new PHPMailer(true);

                                                            try {
                                                                //Server settings
                                                                // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
                                                                $mail->isSMTP();                                            // Send using SMTP
                                                                $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
                                                                $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                                                                $mail->Username   = 'ntiecommerce585@gmail.com';                     // SMTP username
                                                                $mail->Password   = 'NTI@123456';                               // SMTP password
                                                                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                                                                $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

                                                                //Recipients
                                                                $mail->setFrom('ntiecommerce585@gmail.com', 'NTI Ecoomerce');
                                                                $mail->addAddress($loggedUser->email, $loggedUser->name);     // Add a recipient

                                                                // Content
                                                                $mail->isHTML(true);                                  // Set email format to HTML
                                                                $mail->Subject = 'Verfication Code';
                                                                $mail->Body    = "Your verification code: <b>".$loggedUser->code."</b>";

                                                                $mail->send();
                                                                header('Location:checkCode.php?email='.$loggedUser->email);
                                                                // echo 'Message has been sent';
                                                            } catch (Exception $e) {
                                                                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                                                            }
                                                            // header to CHECK CODE page
                                                        }else{

                                                        }
                                                        
                                                    }else{
                                                       $errors['login'] = "<div class='alert alert-danger'> Wrong Email Or Password </div>";
                                                    }

                                                }
                                            ?>
                                            <form method="post">
                                                <input type="email" name="email" placeholder="Email">
                                                <input type="password" name="password" placeholder="Password">
                                                <?php echo(isset($errors['login']) ? $errors['login'] : '') ?>
                                                <div class="button-box">
                                                    <div class="login-toggle-btn">
                                                        <input type="checkbox">
                                                        <!-- <label>Remember me</label> -->
                                                        <a href="#">Forgot Password?</a>
                                                    </div>

                                                    <button type="submit"><span>Login</span></button>
                                                </div>
                                            </form>
                                            
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer style Start -->
<?php include_once "footer.php" ?>

