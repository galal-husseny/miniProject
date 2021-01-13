<?php
include_once "header.php";
if (!isset($_SESSION['user'])) {
    header('Location:index.php');
}
include_once "User.php";
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
// Load Composer's autoloader
require 'vendor/autoload.php';
include_once "Address.php";

?>

<!-- Breadcrumb Area Start -->
<div class="breadcrumb-area bg-image-3 ptb-150">
    <div class="container">
        <div class="breadcrumb-content text-center">
            <h3>MY ACCOUNT</h3>
            <ul>
                <li><a href="index.html">Home</a></li>
                <li class="active">My Account</li>
            </ul>
        </div>
    </div>
</div>
<!-- Breadcrumb Area End -->
<!-- my account start -->
<div class="checkout-area pb-80 pt-100">
    <div class="container">
        <div class="row">
            <div class="ml-auto mr-auto col-lg-9">
                <div class="checkout-wrapper">
                    <div id="faq" class="panel-group">
                        <div class="panel panel-default">
                            <form method="POST" enctype="multipart/form-data">

                                <div class="panel-heading">
                                    <h5 class="panel-title"><span>1</span> <a data-toggle="collapse" data-parent="#faq" href="#my-account-1">Edit your account information </a></h5>
                                </div>
                                <div id="my-account-1" class="panel-collapse collapse <?php echo (isset($_POST['info']) ? 'show' : '') ?>">
                                    <?php
                                    // information form logic
                                    // print_r($_POST);
                                    if (isset($_POST['info']) && $_POST['name']  && $_POST['phone'] && $_POST['gender']) {

                                        $updatedData = new User();
                                        $updatedData->setId($_SESSION['user']->id);
                                        $updatedData->setName($_POST['name']);
                                        $updatedData->setGender($_POST['gender']);
                                        $updatedData->setPhone($_POST['phone']);

                                        if ($_FILES['photo']['name']) {
                                            $directory = 'uploads/users/';
                                            $extension = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
                                            $imageName = time() . '.' . $extension;
                                            $fullPath = $directory . $imageName;

                                            $errors = [];
                                            $success = [];
                                            if ($_FILES['photo']['size'] > 100000) {
                                                $errors['size'] = "<div class='alert alert-danger'> you must upload image less than 1 MegaByte </div>";
                                            }

                                            $arrayExt = ['png', 'jpg', 'jpeg'];
                                            if (!in_array($extension, $arrayExt)) {
                                                $errors['ext'] = "<div class='alert alert-danger'> you must upload image with extension png,jpg,jpeg </div>";
                                            }

                                            if (empty($errors)) {
                                                move_uploaded_file($_FILES['photo']['tmp_name'], $fullPath);
                                                $updatedData->setPhoto($imageName);
                                                $_SESSION['user']->photo = $updatedData->getPhoto();
                                            }
                                        }

                                        $result = $updatedData->updateProfileInfo();
                                        if ($result) {
                                            $success['updateInfo'] = "<div class='alert alert-success'>Information has been updated</div>";
                                            $_SESSION['user']->name = $_POST['name'];
                                            $_SESSION['user']->gender = $_POST['gender'];
                                            $_SESSION['user']->phone = $_POST['phone'];
                                        } else {
                                            $errors['serverError'] = "<div class='alert alert-danger'> Something Went wrong </div>";
                                        }
                                    }
                                    ?>
                                    <div class="panel-body">
                                        <div class="billing-information-wrapper">
                                            <div class="account-info-wrapper">
                                                <h4>My Account Information</h4>
                                                <h5>Your Personal Details</h5>
                                                <?php
                                                echo (isset($errors['serverError']) ? $errors['serverError'] :  '');
                                                if (empty($errors)) {
                                                    echo (isset($success['updateInfo']) ? $success['updateInfo'] :  '');
                                                }
                                                ?>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12 col-md-12">
                                                    <div class="row">
                                                        <div class="offest-4 col-4">
                                                            <img src="uploads/users/<?php echo $_SESSION['user']->photo; ?>" alt="" class="rounded" style="width:100%;">
                                                            <input type="file" name="photo" id="">
                                                        </div>
                                                        <div class="col-12">
                                                            <?php
                                                            echo (isset($errors['size']) ? $errors['size'] :  '');
                                                            echo (isset($errors['ext']) ? $errors['ext'] :  '');
                                                            ?>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="col-lg-12 col-md-12">
                                                    <div class="billing-info">
                                                        <label>Full Name</label>
                                                        <input type="text" name="name" value="<?php echo $_SESSION['user']->name; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6">
                                                    <div class="billing-info">
                                                        <label>Phone</label>
                                                        <input type="phone" name="phone" value="<?php echo $_SESSION['user']->phone; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6">
                                                    <div class="billing-info">
                                                        <label>Gender</label>
                                                        <select name="gender" id="">
                                                            <option <?php echo ($_SESSION['user']->gender == 'f' ? 'selected' : '') ?> value="f">Female</option>
                                                            <option <?php echo ($_SESSION['user']->gender == 'm' ? 'selected' : '') ?> value="m">Male</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="billing-back-btn">
                                                <div class="billing-back">
                                                    <a href="#"><i class="ion-arrow-up-c"></i> back</a>
                                                </div>
                                                <div class="billing-btn">
                                                    <button name="info">Continue</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>

                        </div>
                        <div class="panel panel-default">
                            <form method="POST">
                                <div class="panel-heading">
                                    <h5 class="panel-title"><span>2</span> <a data-toggle="collapse" data-parent="#faq" href="#my-account-2">Change your Email </a></h5>
                                </div>
                                <div id="my-account-2" class="panel-collapse collapse <?php echo (isset($_POST['emailInfo']) ? 'show' : '') ?>">
                                    <div class="panel-body">
                                        <div class="billing-information-wrapper">
                                            <?php
                                            if (isset($_POST['emailInfo']) && $_POST['email']) {
                                                $newEmail = new User();
                                                // $newEmail->setEmail($_POST['email']);
                                                $errors = [];
                                                if ($_POST['email'] == $_SESSION['user']->email) {
                                                    $errors['email'] = "<div class='alert alert-danger'> Email Not changed </div>";
                                                }

                                                if (empty($errors)) {
                                                    $newEmail->setId($_SESSION['user']->id);
                                                    $newEmail->setEmail($_POST['email']);
                                                    $newEmail->setStatus(2);
                                                    $code = rand(10000, 99999);
                                                    $newEmail->setCode($code);
                                                    $result = $newEmail->updateEmail();
                                                    if ($result) {

                                                        $_SESSION['user']->email = $newEmail->getEmail();
                                                        $_SESSION['user']->status = $newEmail->getStatus();
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
                                                            $mail->addAddress($newEmail->getEmail());     // Add a recipient

                                                            // Content
                                                            $mail->isHTML(true);                                  // Set email format to HTML
                                                            $mail->Subject = 'Verfication Code';
                                                            $mail->Body    = "Your verification code: <b>" . $newEmail->getCode() . "</b>";

                                                            $mail->send();
                                                            header('Location:checkCode.php?email=' . $newEmail->getEmail());
                                                            // echo 'Message has been sent';
                                                        } catch (Exception $e) {
                                                            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                                                        }
                                                    } else {
                                                        $errors['serverError'] = "<div class='alert alert-danger'> Email already exists </div>";
                                                    }
                                                }
                                            }
                                            ?>
                                            <div class="row">
                                                <div class="col-12">
                                                    <?php
                                                    echo (isset($errors['serverError']) ? $errors['serverError'] :  '');
                                                    ?>
                                                </div>
                                                <div class="col-lg-12 col-md-12">
                                                    <div class="billing-info">
                                                        <label>Email Address</label>
                                                        <input type="email" name="email" value="<?php echo $_SESSION['user']->email ?>">
                                                    </div>



                                                </div>
                                                <div class="col-12">
                                                    <?php
                                                    echo (isset($errors['email']) ? $errors['email'] :  '');
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="billing-back-btn">
                                                <div class="billing-back">
                                                    <a href="#"><i class="ion-arrow-up-c"></i> back</a>
                                                </div>
                                                <div class="billing-btn">
                                                    <button name="emailInfo">Continue</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="panel panel-default">
                            <form method="POST">
                                <div class="panel-heading">
                                    <h5 class="panel-title"><span>2</span> <a data-toggle="collapse" data-parent="#faq" href="#my-account-5">Change your password </a></h5>
                                </div>
                                <div id="my-account-5" class="panel-collapse collapse  <?php echo (isset($_POST['passInfo']) ? 'show' : '') ?>"">
                                <div class=" panel-body">
                                    <div class="billing-information-wrapper">
                                        <?php
                                        if (isset($_POST['passInfo']) && $_POST['old_password'] && $_POST['new_password'] && $_POST['confirm_password']) {
                                            $updatedPass = new User();
                                            $updatedPass->setId($_SESSION['user']->id);
                                            $updatedPass->setPass($_POST['old_password']);
                                            $errors = [];

                                            if ($updatedPass->getPass() != $_SESSION['user']->password) {
                                                $errors['old_pass'] = "<div class='alert alert-danger'> Wrong Password </div>";
                                            }
                                            $updatedPass->setPass($_POST['new_password']);
                                            if ($updatedPass->getPass() == $_SESSION['user']->password) {
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
                                                $result = $updatedPass->updatePassword();
                                                if ($result) {
                                                    $success['updateInfo'] = "<div class='alert alert-success'>Information has been updated</div>";
                                                    $_SESSION['user']->password = $updatedPass->getPass();
                                                } else {
                                                    $errors['serverError'] = "<div class='alert alert-danger'> Something Went wrong </div>";
                                                }
                                            }

                                            // $updatedPass->setPass($_POST['new_password']);
                                            // $updatedPass->setPass($_POST['confirm_password']);
                                        }
                                        ?>
                                        <div class="account-info-wrapper">
                                            <h4>Change Password</h4>
                                            <h5>Your Password</h5>
                                            <?php
                                            if (empty($errors)) {
                                                echo (isset($success['updateInfo']) ? $success['updateInfo'] : '');
                                            }
                                            ?>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12">
                                                <div class="billing-info">
                                                    <label>Old Password</label>
                                                    <input type="password" name="old_password">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <?php
                                                echo (isset($errors['old_pass']) ? $errors['old_pass'] : '');
                                                ?>
                                            </div>

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
                                            <div class="billing-back">
                                                <a href="#"><i class="ion-arrow-up-c"></i> back</a>
                                            </div>
                                            <div class="billing-btn">
                                                <button name="passInfo">Continue</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                        </form>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h5 class="panel-title"><span>3</span> <a data-toggle="collapse" data-parent="#faq" href="#my-account-3">Modify your address book entries </a></h5>
                        </div>
                        <div id="my-account-3" class="panel-collapse collapse <?php echo (  (isset($_POST['addAddress']) ||  isset($_POST['deleteAddress']) ||  isset($_POST['editAddress'])) ? 'show' : '') ?> ">
                            <div class="panel-body">
                                <div class="billing-information-wrapper">
                                    <?php
                                    if (isset($_POST['addAddress']) && $_POST['street']  && $_POST['region_id']  && $_POST['floor']  && $_POST['bulding']  && $_POST['flat']) {
                                        $address = new Address();
                                        $address->setStreet($_POST['street']);
                                        $address->setFloor($_POST['floor']);
                                        $address->setBulding($_POST['bulding']);
                                        $address->setFlat($_POST['flat']);
                                        $address->setDetails($_POST['details']);
                                        $address->setRegionId($_POST['region_id']);
                                        $address->setUserId($_SESSION['user']->id);
                                        $result = $address->insertData();
                                        $errors = [];
                                        $success = [];
                                        if ($result) {
                                            $success['updateInfo'] = "<div class='alert alert-success'>Information has been updated</div>";
                                        } else {
                                            $errors['serverError'] = "<div class='alert alert-danger'> Something Went wrong </div>";
                                        }
                                    }
                                    ?>
                                    <div class="account-info-wrapper">
                                        <h4>Address Book Entries</h4>
                                        <?php echo (isset($success['updateInfo']) ? $success['updateInfo'] : '') ?>
                                        <?php echo (isset($errors['serverError']) ? $errors['serverError'] : '') ?>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12">
                                            <form method="POST">

                                                <div class="form-row">
                                                    <div class="form-group col-md-12">
                                                        <label for="inputEmail4">Street</label>
                                                        <input type="text" name="street" class="form-control" id="inputEmail4">
                                                    </div>

                                                </div>

                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <label for="inputPassword4">Bulding</label>
                                                        <input type="number" name="bulding" class="form-control" id="inputPassword4">
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="inputAddress2">Flat</label>
                                                        <input type="number" name="flat" class="form-control" id="inputAddress2" placeholder="Apartment, studio, or floor">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="inputAddress">Floor</label>
                                                    <input type="text" name="floor" class="form-control" id="inputAddress" placeholder="1234 Main St">
                                                </div>

                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <label for="inputCity">Details</label>
                                                        <textarea name="details" id="" class="form-control" cols="30" rows="10"></textarea>
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <label for="inputState">Regions</label>
                                                        <select name="region_id" class="form-control">
                                                            <?php
                                                            include_once "City.php";
                                                            $cities = new City();
                                                            $result = $cities->selectData();
                                                            if (!empty($result)) {
                                                                $allCities = $result->fetch_all(MYSQLI_ASSOC);
                                                                // print_r($allCities);die;
                                                                foreach ($allCities as $key => $value) {
                                                            ?>
                                                                    <optgroup label="<?php echo $value['name']; ?>">
                                                                        <?php
                                                                        include_once "Region.php";
                                                                        $region = new Region();
                                                                        $region->setCityId($value['id']);
                                                                        $result2 = $region->getRegionsByCity();
                                                                        if (!empty($result2)) {
                                                                            $regions = $result2->fetch_all(MYSQLI_ASSOC);
                                                                            foreach ($regions as $key1 => $value1) {
                                                                        ?>
                                                                                <option value="<?php echo $value1['id'] ?>"><?php echo $value1['name'] ?></option>
                                                                        <?php
                                                                            }
                                                                        }
                                                                        ?>

                                                                    </optgroup>
                                                            <?php
                                                                }
                                                            } else {
                                                            }
                                                            ?>

                                                        </select>
                                                    </div>

                                                </div>
                                                <br>
                                                <button name="addAddress" class="btn btn-primary">Add New Address </button>
                                                <br>
                                            </form>
                                        </div>
                                    </div>
                                    <?php
                                    if (isset($_POST['deleteAddress'])) {
                                        
                                        $delete = new Address();
                                        $delete->setId($_POST['id']);
                                        $result = $delete->deleteData();
                                    }
                                    if (isset($_POST['editAddress'])) {
                                        
                                        $address = new Address();
                                        $address->setStreet($_POST['street']);
                                        $address->setFloor($_POST['floor']);
                                        $address->setBulding($_POST['bulding']);
                                        $address->setFlat($_POST['flat']);
                                        $address->setDetails($_POST['details']);
                                        $address->setRegionId($_POST['region_id']);
                                        $address->setUserId($_SESSION['user']->id);
                                        $address->setId($_POST['id']);
                                        $address->updateData();
                                    }
                                    ?>                  
                                    <div class="entries-wrapper">
                                        <?php
                                        $allAddresses = new Address();
                                        $allAddresses->setUserId($_SESSION['user']->id);
                                        $result = $allAddresses->getAddressByUserId();
                                        if (!empty($result)) {
                                            $addresses = $result->fetch_all(MYSQLI_ASSOC);
                                            $i = 1;
                                            foreach ($addresses as $key => $value) {
                                        ?>
                                                <form method="POST">

                                                    <div class="row">


                                                        <div class="col-lg-6 col-md-6 d-flex align-items-center justify-content-center">
                                                            <div class="entries-info text-center">
                                                                <h1>Address <?php echo $i;
                                                                            $i++; ?></h1>
                                                                <input type="hidden" value="<?php echo $value['id'] ?>" name="id">
                                                                <div class="form-row">
                                                                    <div class="form-group col-md-12">
                                                                        <label for="inputEmail4">Street</label>
                                                                        <input type="text" name="street" class="form-control" id="inputEmail4" value="<?php echo $value['street'] ?>">
                                                                    </div>

                                                                </div>

                                                                <div class="form-row">
                                                                    <div class="form-group col-md-6">
                                                                        <label for="inputPassword4">Bulding</label>
                                                                        <input type="number" name="bulding" class="form-control" id="inputPassword4" value="<?php echo $value['building'] ?>">
                                                                    </div>
                                                                    <div class="form-group col-md-6">
                                                                        <label for="inputAddress2">Flat</label>
                                                                        <input type="number" name="flat" class="form-control" id="inputAddress2" placeholder="Apartment, studio, or floor" value="<?php echo $value['flat'] ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="inputAddress">Floor</label>
                                                                    <input type="text" name="floor" class="form-control" id="inputAddress" placeholder="1234 Main St" value="<?php echo $value['floor'] ?>">
                                                                </div>

                                                                <div class="form-row">
                                                                    <div class="form-group col-md-6">
                                                                        <label for="inputCity">Details</label>
                                                                        <textarea name="details" id="" class="form-control" cols="30" rows="10"><?php echo $value['details'] ?></textarea>
                                                                    </div>
                                                                    <div class="form-group col-md-4">
                                                                        <label for="inputState">Regions</label>
                                                                        <select name="region_id" class="form-control">
                                                                            <?php
                                                                            include_once "City.php";
                                                                            $cities = new City();
                                                                            $result = $cities->selectData();
                                                                            if (!empty($result)) {
                                                                                $allCities = $result->fetch_all(MYSQLI_ASSOC);
                                                                                // print_r($allCities);die;
                                                                                foreach ($allCities as $key1 => $value1) {
                                                                            ?>
                                                                                    <optgroup label="<?php echo $value1['name']; ?>">
                                                                                        <?php
                                                                                        include_once "Region.php";
                                                                                        $region = new Region();
                                                                                        $region->setCityId($value1['id']);
                                                                                        $result2 = $region->getRegionsByCity();
                                                                                        if (!empty($result2)) {
                                                                                            $regions = $result2->fetch_all(MYSQLI_ASSOC);
                                                                                            foreach ($regions as $key2 => $value2) {
                                                                                        ?>
                                                                                                <option <?php echo ($value['region_id'] == $value2['id'] ? 'selected' : '') ?> value="<?php echo $value2['id'] ?>"><?php echo $value2['name'] ?></option>
                                                                                        <?php
                                                                                            }
                                                                                        }
                                                                                        ?>

                                                                                    </optgroup>
                                                                            <?php
                                                                                }
                                                                            } else {
                                                                            }
                                                                            ?>

                                                                        </select>
                                                                    </div>

                                                                </div>

                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 d-flex align-items-center justify-content-center">
                                                            <div class="entries-edit-delete text-center">
                                                                <button class="btn btn-warning rounded" name="editAddress"> Edit </button>
                                                                <button class="btn btn-danger rounded" name="deleteAddress"> Delete </button>
                                                            </div>
                                                        </div>


                                                        <hr>
                                                    <?php
                                                

                                                    ?>

                                                    </div>
                                                </form>
                                            <?php }
                                        } ?>
                                    </div>
                                   
                                   
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h5 class="panel-title"><span>4</span> <a href="wishlist.html">Modify your wish list </a></h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<!-- my account end -->

<?php
include_once "footer.php";
?>