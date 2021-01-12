<?php

include_once "header.php";
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
// Load Composer's autoloader
require 'vendor/autoload.php';

?>
 <div class="breadcrumb-area bg-image-3 ptb-150">
            <div class="container">
                <div class="breadcrumb-content text-center">
					<h3>Forget Password</h3>
                    <ul>
                        <li><a href="index.html">Home</a></li>
                        <li class="active">Forget Password</li>
                    </ul>
                </div>
            </div>
</div>
<div class="container">
    <div class="row">
        <div class="offset-4 col-4">
            <form method="POST" class="my-5">
                    <?php
                        if(isset($_POST['verfiy'])){
                            include_once "User.php";
                            $checkEmail = new User();
                            $checkEmail->setEmail($_POST['email']);
                            $result = $checkEmail->checkEmail();
                            if(!empty($result)){
                                // email exists
                                $code = rand(10000,99999);
                                $checkEmail->setCode($code);
                                $result = $checkEmail->updateCode();
                                if($result){
                                    //send mail
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
                                        $mail->addAddress($checkEmail->getEmail());     // Add a recipient

                                        // Content
                                        $mail->isHTML(true);                                  // Set email format to HTML
                                        $mail->Subject = 'Verfication Code';
                                        $mail->Body    = "Your verification code: <b>".$checkEmail->getCode()."</b>";

                                        $mail->send();
                                        header('Location:checkCode.php?email='.$checkEmail->getEmail().'&forget=true');
                                        // echo 'Message has been sent';
                                    } catch (Exception $e) {
                                        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                                    }
                                }else{
                                    $errors['serverError'] = "<div class='alert alert-danger'> Something Went Wrong </div>";
                                }
                            }else{
                                // email dosent exist
                                $errors['email'] = "<div class='alert alert-danger'> Email dosent exists </div>";
                            }

                        }
                    ?>
                    <div class="form-group">
                        <div class="form-group">
                            <?php
                            echo(isset($errors['serverError']) ? $errors['serverError'] : '');

                            ?>

                        </div>
                        <div class="form-group">
                          <label for="code">Email Address</label>
                          <input type="text"
                            class="form-control" name="email" id="code" aria-describedby="helpId" placeholder="">
                          <small id="helpId" class="form-text text-muted">Please enter your email</small>
                        </div>
                        <div class="form-group">
                            <?php
                                   echo(isset($errors['email']) ? $errors['email'] : ''); 

                        ?>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-success rounded" name="verfiy"> Verify </button> 
                        </div>
                    </div>
            </form>
        </div>
    </div>
</div>

<?php
include_once "footer.php";

?>