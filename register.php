<?php 
include_once "header.php";
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
					<h3>Register</h3>
                    <ul>
                        <li><a href="index.html">Home</a></li>
                        <li class="active">Register</li>
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
                                <a  class="active"  data-toggle="tab" href="#lg2">
                                    <h4> register </h4>
                                </a>
                            </div>
                          
                                <div id="lg2" class="tab-pane active">
                                    <div class="login-form-container">
                                        <div class="login-register-form">
                                            <form method="POST">
                                                <?php
                                                if(!empty($_POST)){
                                                
                                                    $pattern = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/";
                                                    // var_dump( ); 
                                                    $error =[];
                                                    if(!preg_match($pattern, $_POST['password'])){
                                                        $error['match'] = "<div class='alert alert-danger'> Minimum eight characters, at least one uppercase letter, one lowercase letter, one number and one special character: </div>";
                                                    }   

                                                    if($_POST['password'] != $_POST['password_confirmation']){
                                                        $error['confirm'] = "<div class='alert alert-danger'> Password dosen't match </div>";
                                                    }





                                                    if(empty($error)){
                                                        include_once "User.php";
                                                        $newUser = new User();
                                                        $newUser->setName($_POST['name']);
                                                        $newUser->setPhone($_POST['phone']);
                                                        $newUser->setEmail($_POST['email']);
                                                        $newUser->setGender($_POST['gender']);
                                                        $newUser->setPass($_POST['password']);
                                                        $newUser->setCode(rand(10000,99999));
                                                        $result = $newUser->insertData();
                                                        if($result){
                                                            // send code

                                                            // Instantiation and passing `true` enables exceptions
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
                                                                $mail->addAddress($newUser->getEmail(), $newUser->getName());     // Add a recipient

                                                                // Content
                                                                $mail->isHTML(true);                                  // Set email format to HTML
                                                                $mail->Subject = 'Verfication Code';
                                                                $mail->Body    = "Your verification code: <b>".$newUser->getCode()."</b>";

                                                                $mail->send();
                                                                header('Location:checkCode.php?email='.$newUser->getEmail());
                                                                // echo 'Message has been sent';
                                                            } catch (Exception $e) {
                                                                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                                                            }



                                                        }else{
                                                            echo "<div class='alert alert-danger'> Something Went Wrong </div>";
                                                        }
                                                    }
                                                    

                                                }
                                                
                                                ?>
                                                <input type="text" name="name" placeholder="Full Name" value="<?php echo(isset($_POST['name']) ? $_POST['name'] : '' )?>">
                                                <input type="password" name="password" placeholder="Password" value="<?php echo(isset($_POST['password']) ? $_POST['password'] : '' )?>">
                                                <?php echo(isset($error['match']) ? $error['match'] : '' )?>
                                                <input type="password" name="password_confirmation" placeholder="Confirm Passwrod" value="<?php echo(isset($_POST['password_confirmation']) ? $_POST['password_confirmation'] : '' )?>">
                                                <?php echo(isset($error['confirm']) ? $error['confirm'] : '' )?>
                                                <input type="email" name="email" placeholder="Email" value="<?php echo(isset($_POST['email']) ? $_POST['email'] : '' )?>">
                                                <input type="phone" name="phone" placeholder="Phone" value="<?php echo(isset($_POST['phone']) ? $_POST['phone'] : '' )?>">
                                                <select name="gender" id="">
                                                    <option <?php echo ((isset($_POST['gender']) && $_POST['gender'] == 'f')  ? 'selected' :  '' )?> value="f">Female</option>
                                                    <option <?php echo ((isset($_POST['gender']) && $_POST['gender'] == 'm') ? 'selected' : '') ?> value="m">Male</option>
                                                </select>
                                                <br><br>
                                                <div class="row">
                                                    <div class="offset-9 col-3">
                                                        <div class="button-box">
                                                            <button type="submit"><span>Register</span></button>
                                                        </div>
                                                    </div>
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
<?php 
include_once "footer.php";

 ?>

