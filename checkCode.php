<?php

include_once "header.php";
?>

<div class="container">
    <div class="row">
        <div class="offset-4 col-4">
            <form method="POST" class="my-5">
                <?php
                    if(!empty($_GET) && isset($_GET['email'])){
                        include_once "User.php";
                        $check = new User();
                        $check->setEmail($_GET['email']);


                    }else{
                        // go to 404 page
                        header('Location:404.php');
                    }

                    if(!empty($_POST)){
                        $check->setCode($_POST['code']);
                        $result = $check->checkCode();
                        if(!empty($result)){
                            // user verified 
                            $user = $result->fetch_object();
                            $check->setStatus(1);
                            $result2 = $check->updateStatus();
                            if($result2){
                                // logged in user
                                $_SESSION['user'] = $user;
                                header('Location:index.php');
                            }else{
                                echo "<div class='alert alert-danger'> SomeThing Went Wrong</div>";
                            }
                        }else{
                            // user not verified
                            echo "<div class='alert alert-danger'> Wrong Code</div>";
                        }

                    }
                ?>
                    <div class="form-group">
                        <div class="form-group">
                          <label for="code">Code</label>
                          <input type="text"
                            class="form-control" name="code" id="code" aria-describedby="helpId" placeholder="">
                          <small id="helpId" class="form-text text-muted">check email to get code</small>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-success rounded"> Check Code </button> 
                        </div>
                    </div>
            </form>
        </div>
    </div>
</div>

<?php
include_once "footer.php";

?>