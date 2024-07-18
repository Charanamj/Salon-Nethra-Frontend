<?php
include '../header.php';
include '../assets/phpmail/mail.php';
?>

<main id="main">
    <section>
        <div class="container" data-aos="fade-up">
<div class="row">
    <div class="col-6"><div class="row justify-content-center">
                <h1>Summary of Your Appointment</h1>         
                <div class="form-group mt-3">
                        <label for="exampleInputName1">Appointment No</label><?php
                        @$selectedAppDate = $_SESSION["selectedappno"]; 
                        ?>
                        <input type="text" id="exampleInputName1" name="appno" value="<?= @$selectedAppDate ?>" readonly>
                        <input type="hidden" id="exampleInputName1" name="appno" value="<?= @$selectedAppDate ?>">
                    </div>
                <div class="form-group mt-3">
                        <label for="exampleInputName1">Appointment Date</label>
                        <input type="text" id="exampleInputName1" name="bookeddate" value="<?= $_SESSION["bookeddate"] ?>" readonly>
                        <input type="hidden" id="exampleInputName1" name="bookeddate" value="<?= $_SESSION["bookeddate"] ?>">
                    </div>
                    <div class="form-group mt-3">
                    <?php
                        $db = dbConn();
                        @$serviceName = $_SESSION["servicename"];
                        $sql = "SELECT * FROM  tbl_services WHERE service_id='$serviceName'"; 
                        $result = $db->query($sql);
                        $row = $result->fetch_assoc();
                        $selectedservicename = $row['service_name'];
                        ?>
                        <label for="exampleInputName1">Service Name</label>
                        <input type="text" id="exampleInputName1" name="service_name" value="<?= $selectedservicename ?>" readonly>
                        <input type="hidden" id="exampleInputName1" name="service_name" value="<?= $selectedservicename ?>">                           
                    </div>
                    <div class="form-group mt-3">
                    <?php
                        $db = dbConn();
                        $dayId= $_SESSION["dayId"];
                        $IdenDay= $dayId;
                        $sql = "SELECT * FROM  tbl_time_slots WHERE time_slot_day_id = $IdenDay ";
                        $result = $db->query($sql);
                        $row = $result->fetch_assoc();
                        ?>
                        <label for="exampleInputName1">Time Slot Name</label>
                        <input type="text" id="exampleInputName1" name="time_slot_name" value="<?= $row["time_slot_name"] ?>" readonly>
                        <input type="hidden" id="exampleInputName1" name="time_slot_name" value="<?= $row["time_slot_name"] ?>"> 
                    </div>
                    <div class="form-group mt-3">
                    <?php
                        $db = dbConn();
                        $dayId= $_SESSION["dayId"];
                        $IdenDay= $dayId;
                        $sql = "SELECT * FROM  tbl_time_slots WHERE time_slot_day_id = $IdenDay ";
                        $result = $db->query($sql);
                        $row = $result->fetch_assoc();
                        ?>
                        <label for="exampleInputName1">Time Period</label>
                        <input type="text" id="exampleInputName1" name="time_slot_name" value="<?= $row['time_slot_start_time'] . " - " . " " . $row['time_slot_end_time'] ?>" readonly>
                        <input type="hidden" id="exampleInputName1" name="time_slot_name" value="<?= $row['time_slot_start_time'] . " to " . " " . $row['time_slot_end_time'] ?>"> 
                    </div>
                    <div class="form-group mt-3">
                        <?php 
                        @$serviceName = $_SESSION["servicename"];
                        $sql = "SELECT * FROM  tbl_services WHERE service_id='$serviceName'"; 
                        $result = $db->query($sql);
                        $row = $result->fetch_assoc();
                        $selectedserviceprice = $row['service_price'];
                        ?>
                        <label for="exampleInputName1">Service Price</label>
                        <input type="text" id="exampleInputName1" name="serviceprice" value="Rs. <?= $selectedserviceprice ?>" readonly>
                        <input type="hidden" id="exampleInputName1" name="serviceprice" value="Rs. <?= $selectedserviceprice ?>"> 
                    </div>
                    <div class="form-group mt-3">
                        <label for="exampleInputName1">Advance to be made</label>
                        <input type="text" id="exampleInputName1" name="serviceprice" value="Rs. <?= ($selectedserviceprice/100)*20 ?>" readonly>
                        <input type="hidden" id="exampleInputName1" name="serviceprice" value="Rs. <?= ($selectedserviceprice/100)*20 ?>"> 
                    </div>
            </div>
        </div>
<?php
extract($_POST);
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $appointmentNo = dataClean($app_no);
    $paymentSlip = $_FILES['payment_slip'];

    if (empty($app_no)) {
    $message['app_no'] = "The appointment No should be select...!";
    }

    if ($_FILES['payment_slip']['name'] != "") {
        $paymentSlip = $_FILES['payment_slip'];
        $filename = $paymentSlip['name'];
        $filetmpname = $paymentSlip['tmp_name'];
        $filesize = $paymentSlip['size'];
        $fileerror = $paymentSlip['error'];
        //take file extension
        $file_ext = explode(".", $filename);
        $file_ext = strtolower(end($file_ext));
        //select allowed file type
        $allowed = array("jpg", "jpeg", "png", "gif");
        //check wether the file type is allowed
        if (in_array($file_ext, $allowed)) {
            if ($fileerror === 0) {
                //file size gives in bytes
                if ($filesize <= 40000000) {
                    //giving appropriate file name. Can be duplicate have to validate using function
                    $new_slip = uniqid('', true) . $app_no . '.' . $file_ext;
                    //directing file destination
                    $file_path = "../assets/img/payments/" . $new_slip;
                    //moving binary data into given destination
                    if (move_uploaded_file($filetmpname, $file_path)) {
                        "The file is uploaded successfully";
                    } else {
                        $message['file_error'] = "File is not uploaded";
                    }
                } else {
                    $message['file_error'] = "File size is invalid";
                }
            } else {
                $message['file_error'] = "File has an error";
            }
        } else {
            $message['file_error'] = "Invalid File type";
        }
    }
    if (empty($message)) {
        $db = dbConn();
        $AddDate = date('y-m-d');
        $appointment_status = 2;
        $loggedCustomerId = $_SESSION['cLogId'];
        $sql = "INSERT INTO tbl_payments(customer_id, appointment_id, payment_slip_file, date) 
                        VALUES ('$loggedCustomerId','$appointmentNo','$new_slip','$AddDate')";
        $db->query($sql);

        echo $sql1 = "UPDATE tbl_appointments SET appointment_status= '$appointment_status' WHERE appointment_id= '$appointmentNo'";
        $db->query($sql1);

        $customer_email = $_SESSION['cLogEmail'];
        $customer_firstname = $_SESSION['cLogFirstname'];
        $customer_lastname = $_SESSION['cLogLastname'];

        $to = $customer_email;
        $toname = $customer_firstname . $customer_lastname;
        $subject = 'Confirmation of Booking - Salon Nethra';
        $body = "<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Responsive Email Template</title>
</head>
<body style='font-family: 'Poppins', Arial, sans-serif'>
    <table width='100%'' border='0' cellspacing='0' cellpadding='0'>
        <tr>
            <td align='center' style='padding: 20px;''>
                <table class='content' width='600' border='0' cellspacing='0' cellpadding='0' style='border-collapse: collapse; border: 1px solid #cccccc;'>
                    <!-- Header -->
                    <tr>
                        <td class='header' style='background-color: #345C72; padding: 40px; text-align: center; color: white; font-size: 24px;>
                        Responsive Email Template
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td class='body' style='padding: 40px; text-align: left; font-size: 16px; line-height: 1.6;'>
                        Hello, $customer_firstname $customer_lastname <br>
                        Welcome to Salon Nethra, Thank you for register with us. Your Account has been successfully created 
                        <br><br>
                            
                        </td>
                    </tr>

                    <!-- Call to action Button -->
                    <tr>
                        <td style='padding: 0px 40px 0px 40px; text-align: center;'>
                            <!-- CTA Button -->
                            <table cellspacing='0' cellpadding='0' style='margin: auto;''>
                                <tr>
                                    <td align='center' style='background-color: #345C72; padding: 10px 20px; border-radius: 5px;'>
                                        <a href='https://www.yourwebsite.com' target='_blank' style='color: #ffffff; text-decoration: none; font-weight: bold;'>Book an Free Consulatation</a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td class='body' style='padding: 40px; text-align: left; font-size: 16px; line-height: 1.6;'>
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Veniam corporis sint eum nemo animi velit exercitationem impedit.             
                        </td>
                    </tr>
                    <!-- Footer -->
                    <tr>
                        <td class='footer' style='background-color: #333333; padding: 40px; text-align: center; color: white; font-size: 14px;'>
                        Copyright &copy; 2024 | salonnethra
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>";
                            $alt = 'Booking Confirmation';
                            send_email($to, $toname, $subject, $body, $alt);

        echo "<script>
                Swal.fire({
                    title: 'You Have Successfully Made a Booking!',
                    text: 'Thank You for your Payment, You will recieve an email that contains the booking details !.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.location.href = 'http://localhost/SMS/web/index.php'; // Redirect to Home page
                });
        </script>";
        
    }

}

?>       
    <div class="col-6">            
        <div class="row justify-content-center">
                <h1>Payment Section</h1>
                <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">
                <div class="form-group mt-3">
                <?php
                        $db = dbConn();
                        $dayId= $_SESSION["dayId"];
                        $IdenDay= $dayId;
                        $loggedCustomerId = $_SESSION['cLogId'];
                        $sql5 = "SELECT * FROM  tbl_appointments WHERE customer_id = '$loggedCustomerId' AND appointment_status = '1' ";
                        $result5 = $db->query($sql5);
                        ?>
                        <label for="exampleInputName1">Select your appointment No:</label>
                        <select type="text" id="exampleInputName1" name="app_no">
                            <option value="">--</option>
                            <?php
                            while ($row5 = $result5->fetch_assoc()) {
                                ?>
                                <option value="<?= $row5['appointment_id'] ?>"><?= $row5['appointment_no'] ?></option>
                                <?php
                            }
                            ?>
                        </select>
                        <span class="text-danger"><?= @$message['app_no'] ?></span>
                    </div>
                <div class="form-group mt-3">
                        <label for="exampleInputName1">Upload your Bank Transfer Slip from here</label>
                        <input type="file" id="exampleInputName1" name="payment_slip" value="<?= @$payment_slip ?>">
                        <span class="text-danger"><?= @$message['payment_slip'] ?></span>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary me-2">Confirm</button>
                    </div>
                </form>
            </div></div>
</div>
<br>
            <h5>Conditions</h5><br>
            <h6>*You have to do the full payment here....</h6>
            <h6>*You have to do the full payment here....</h6>
        </div>
        </div>
    </section>
</main>
<?php
include '../footer.php';
?>
