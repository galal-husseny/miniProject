<?php

include_once "header.php";

?>
<!-- Breadcrumb Area Start -->
<div class="breadcrumb-area bg-image-3 ptb-150">
    <div class="container">
        <div class="breadcrumb-content text-center">
            <h3>Change Password</h3>
            <ul>
                <li><a href="index.html">Home</a></li>
                <li class="active">Change Password</li>
            </ul>
        </div>
    </div>
</div>
<div class="login-register-area ptb-100">
    <div class="container">
        <div class="row">
            <div class="col-lg-7 col-md-12 ml-auto mr-auto">
                <div class="login-register-wrapper">
                    <div class="login-register-tab-list nav">
                        <a class="active" data-toggle="tab" href="#lg1">
                            <h4> Change Password </h4>
                        </a>
                    </div>
                    <div class="tab-content">
                        <div id="lg1" class="tab-pane active">
                            <div class="login-form-container">
                                <div class="login-register-form">

                                    <form method="POST">


                                        <?php

                                            if(!empty($_GET) && isset($_GET['email'])){
                                                include_once "User.php";
                                                $check = new User();
                                                $check->setEmail($_GET['email']);
                                                $result = $check->getUserByEmail();
                                                if(!empty($result)){
                                                    $user = $result->fetch_object();

                                                }else{
                                                    $errors['email'] = "<div class='alert alert-danger'>Email Dosen't Exists </div>";
                                                }

                                            }else{
                                                // go to 404 page
                                                header('Location:404.php');
                                                die;
                                            }

                                        if (isset($_POST['passInfo']) && $_POST['new_password'] && $_POST['confirm_password']) {
                                            $check->setPass($_POST['new_password']);

                                            $errors = [];
                                            if ($check->getPass() == $user->password) {
                                                $errors['same_pass'] = "<div class='alert alert-danger'> Password dosen't change </div>";
                                            }

                                            if ($_POST['new_password'] != $_POST['confirm_password']) {
                                                $errors['confirm_pass'] = "<div class='alert alert-danger'> Password not confirmed </div>";
                                            }
                                            $pattern = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/";
                                            if (!preg_match($pattern, $_POST['new_password'])) {
                                                $errors['regex_pass'] = "<div class='alert alert-danger'> Minimum eight characters, at least one uppercase letter, one lowercase letter, one number and one special character: </div>";
                                            }

                                            if (empty($errors)) {
                                                $check->setId($user->id);
                                                $result = $check->updatePassword();
                                                if ($result) {
                                                    $_SESSION['user'] = $user;
                                                   header('Location:index.php');
                                                } else {
                                                    $errors['serverError'] = "<div class='alert alert-danger'> Something Went wrong </div>";
                                                }
                                            }

                                            // $user->setPass($_POST['new_password']);
                                            // $user->setPass($_POST['confirm_password']);
                                        }
                                        ?>
                                        <div class="account-info-wrapper">
                                        
                                            <?php
                                            echo (isset($errors['email']) ? $errors['email'] : '');
                                             
                                            ?>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12">
                                                <div class="billing-info">
                                                    <label>New Password</label>
                                                    <input type="password" name="new_password">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <?php
                                                echo (isset($errors['regex_pass']) ? $errors['regex_pass'] : '');
                                                echo (isset($errors['same_pass']) ? $errors['same_pass'] : '');

                                                ?>
                                            </div>
                                            <div class="col-lg-12 col-md-12">
                                                <div class="billing-info">
                                                    <label>Password Confirm</label>
                                                    <input type="password" name="confirm_password">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <?php
                                                echo (isset($errors['confirm_pass']) ? $errors['confirm_pass'] : '');
                                                ?>
                                            </div>
                                        </div>
                                        <div class="billing-back-btn">
                                           
                                            <div class="billing-btn">
                                                <button name="passInfo">Continue</button>
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



<?php include_once "footer.php" ?>