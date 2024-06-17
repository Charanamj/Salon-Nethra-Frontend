<?php ob_start(); ?>
<?php include 'header.php';?>

<main id="main">
<head>
<script src="<?= SYSTEM_PATH ?>assets/js/sweetalert2.all.js"></script>
</head>
<body>

    <?php
    extract($_POST);
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        extract($_POST);
        $customer_email = dataClean($customer_email);
        $customer_password = dataClean($customer_password);

        $messages = array();

        if (empty($customer_email)) {
            $messages['customer_email'] = "The User Name should not be empty ..!";
        }
        if (!empty($customer_email)) {
            $db = dbConn();
            $sql = "SELECT * FROM  tbl_customers WHERE customer_email='$customer_email'";
            $result = $db->query($sql);
            if ($result->num_rows > 0) {
                $psw = sha1($customer_password);
                $rowpsw = $result->fetch_assoc();
                $dbuserpsw = $rowpsw['customer_password'];
                if ($psw === $dbuserpsw) {
                    $_SESSION['LogId'] = $rowpsw['customer_id'];
                    $_SESSION['LogTitle'] = $rowpsw['customer_title'];
                    $_SESSION['LogGender'] = $rowpsw['customer_gender'];
                    $_SESSION['LogFirstname'] = $rowpsw['customer_firstname'];
                    $_SESSION['LogLastname'] = $rowpsw['customer_lastname'];
                    $_SESSION['LogIdnum'] = $rowpsw['customer_nic'];
                    $_SESSION['LogAddressline1'] = $rowpsw['customer_addressline1'];
                    $_SESSION['LogAddressline2'] = $rowpsw['customer_addressline2'];
                    $_SESSION['LogEmail'] = $rowpsw['customer_email'];
                    $_SESSION['LogTelNo'] = $rowpsw['customer_mobilenumber'];
                    $_SESSION['LogImg'] = $rowpsw['customer_image'];
                    $_SESSION['LogUserName'] = $rowpsw['customer_username'];
                    $_SESSION['LogPasw'] = $rowpsw['customer_password'];

                    echo "<script>
        Swal.fire({
            title: 'Logged in!',
            text: 'Login Successful !.',
            icon: 'success',
            confirmButtonText: 'OK'
        }).then(() => {
            window.location.href = 'http://localhost/SMS/web/index.php'; // Redirect to success page
        });
</script>";                     
                } else {
                    $messages['customer_password'] = "The Password is wrong";
                }
            } else {
                $messages['customer_email'] = "This email is not in the database";
            }

        }

        if (empty($customer_password)) {
            $messages['customer_password'] = "The Password Should not be empty";
        }
    }
    ?>
<section>
      <div class="container" data-aos="fade-up">

        <div class="section-title">
          <h2>Log in</h2>
          <p>Log in From Here</p>
        </div>

        <div class="row justify-content-center">
          <div class="col-lg-7 mt-5 mt-lg-0 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="200">
          <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <div class="form-group mt-3">
                            <label for="name">Email Address</label>
                            <input type="text" class="form-control" name="customer_email" value="<?= @$customer_email ?>" placeholder="Enter your email address">
                            <span class="text-danger"><?= @$messages['customer_email'] ?></span>
                          </div>
                        <div class="form-group mt-3">
                            <label for="name">Password</label>
                            <input type="text" class="form-control" name="customer_password" value="<?= @$customer_password ?>" placeholder="Enter password">
                            <span class="text-danger"><?= @$messages['customer_password'] ?></span>
                          </div>
                        <a href="forgetpassword.php">Forgot password</a>
            <p>Don't have an account ? <a href="register.php">Sign Up Here</a> </p>
              <div class="text-center"><button type="submit">Log in</button></div>
            </form>
          </div>
        </div>
      </div>
</section>
</body>
</main>
<?php
include 'footer.php';
?>