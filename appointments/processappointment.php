<?php
include '../header.php';
include '../assets/phpmail/mail.php';
?>
<?php
extract($_POST);
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $appointmentNo = $_SESSION["selectedappno"];

    if (empty($message)) {
        $db = dbConn();
        $AddDate = date('Y-m-d');
        $appointment_status = 1;
        $loggedCustomerId = $_SESSION['cLogId'];
        $customername = $_SESSION['cLogFirstname'] . $_SESSION['cLogLastname'];
        $customer_Selected_Timeslot=$_SESSION['selectedtimeslot'];
        //  $sql1 = "SELECT * FROM tbl_appointments WHERE customer_id='$loggedCustomerId' AND booking_date='$bookeddate' 
        // AND time_slot_id='$time_slot_name'";
        // $db->query($sql1);
        // $result1 = $db->query($sql1);
        echo $sql = "INSERT INTO tbl_appointments(appointment_no, service_category, service_name, customer_id, customer_name, booking_date,
        time_slot_id, appointment_status, add_date, appointment_price, app_advance_pay, app_remain_pay, app_staff_pay, 
        app_utility_pay, app_profit_pay) 
        VALUES ('$appointmentNo','$service_category_id','$service_name','$loggedCustomerId', '$customername', '$bookeddate','$customer_Selected_Timeslot',
        '$appointment_status','$AddDate','$service_price','$advancepay','$remainpay','$service_staff_fee','$staff_utility_fee','$staff_profit_fee')";
        $db->query($sql);

        
        // $sql = "INSERT INTO tbl_payments(customer_id, appointment_id, payment_slip_file, date) 
        //                 VALUES ('$loggedCustomerId','$appointmentNo','$new_slip','$AddDate')";
        // $db->query($sql);

        //  $sql1 = "UPDATE tbl_appointments SET appointment_status= '$appointment_status' WHERE appointment_id= '$appointmentNo'";
        // $db->query($sql1);

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
                    text: 'You will recieve an email that contains the booking details !.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.location.href = 'http://localhost/SMS/web/appointments/confirmappointment.php'; // Redirect to Home page
                });
        </script>";
        
    }
}

?>  
<main id="main">
    <section>
        <div class="container" data-aos="fade-up">
<div class="row">
    <div class="col-6"><div class="row justify-content-center">
                <h1>Summary of Your Appointment</h1> 
                <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">        
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
                        echo $sql = "SELECT * FROM  tbl_services WHERE service_id='$serviceName'"; 
                        $result = $db->query($sql);
                        $row = $result->fetch_assoc();
                        $selectedservicename = $row['service_name'];
                        $selectedservicecat = $row['service_category_id'];
                        $stafffee = $row['service_staff_fee'];
                        $utilityfee = $row['staff_utility_fee'];
                        $Totalprofit = $row['staff_profit_fee'];
                        ?>
                        <label for="exampleInputName1">Service Name</label>
                        <input type="text" name="service_name" value="<?= $selectedservicename ?>" readonly>
                        <input type="hidden" name="service_name" value="<?= $serviceName ?>">    
                        <input type="hidden" name="service_category_id" value="<?= $selectedservicecat ?>">
                        <input type="text" name="service_staff_fee" value="<?= $stafffee ?>">
                        <input type="text" name="staff_utility_fee" value="<?= $utilityfee ?>">
                        <input type="text" name="staff_profit_fee" value="<?= $Totalprofit ?>">                       
                    </div>
                    <div class="form-group mt-3">
                    <?php
                        $db = dbConn();
                        $dayId= $_SESSION["dayId"];
                        $IdenDay= $dayId;
                        $customer_Selected_Timeslot = $_SESSION['selectedtimeslot'];
                        $sql10 = "SELECT * FROM  tbl_time_slots WHERE time_slot_id = $customer_Selected_Timeslot ";
                        $result10 = $db->query($sql10);
                        $row10 = $result10->fetch_assoc();
                         $row10["time_slot_id"];
                        ?>
                        <label for="exampleInputName1">Time Slot Name</label>
                        <input type="text" name="" value="<?= $row10["time_slot_name"] ?>" readonly>
                        <input type="hidden" name="time_slot_name" value="<?= $row10["time_slot_id"] ?>"> 
                    </div>
                    <div class="form-group mt-3">
                    <?php
                        $db = dbConn();
                        $dayId= $_SESSION["dayId"];
                        $timeslotperiod = $_SESSION["timeslotid"];
                        $IdenDay= $dayId;
                        $sql = "SELECT * FROM  tbl_time_slots WHERE time_slot_id = $timeslotperiod ";
                        $result = $db->query($sql);
                        $row = $result->fetch_assoc();
                        ?>
                        <label for="exampleInputName1">Time Period</label>
                        <input type="text" id="exampleInputName1" name="time_slot_name_start_time" value="<?= $row['time_slot_start_time'] . " - " . " " . $row['time_slot_end_time'] ?>" readonly>
                        <input type="hidden" id="exampleInputName1" name="time_slot_name_start_time" value="<?= $row['time_slot_start_time'] . " to " . " " . $row['time_slot_end_time'] ?>"> 
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
                        <input type="text" id="exampleInputName1" name="service_price" value= "<?= $selectedserviceprice ?>" readonly>
                        <input type="hidden" id="exampleInputName1" name="service_price" value="<?= $selectedserviceprice ?>"> 
                    </div>
                    <div class="form-group mt-3">
                        <label for="exampleInputName1">Advance to be made</label>
                        <?php
                        $advancePay = ($selectedserviceprice/100)*20;
                        $remainPay = $selectedserviceprice - $advancePay;
                        ?>
                        <input type="text" id="exampleInputName1" name="advancepay" value="<?= $advancePay ?>" readonly>
                        <input type="hidden" id="exampleInputName1" name="advancepay" value="<?= $advancePay ?>">
                        <input type="text" id="exampleInputName1" name="remainpay" value="<?= $remainPay ?>">
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary me-2">Book Appointment</button>
</form>
                    </div>
            </div>
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
