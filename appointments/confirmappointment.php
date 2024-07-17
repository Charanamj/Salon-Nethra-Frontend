<?php
include '../header.php';
?>

<?php
extract($_POST);
// if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   
//     $service_name = dataClean($service_name);

//     $message = array();

//     if (empty($service_name)) {
//         $message['service_name'] = "The service name should be select...!";
//     }
//     if (!empty($time_slot_name)) {
//         $sql = "SELECT * FROM tbl_appointments WHERE booking_date='$bookeddate'AND time_slot_id='$time_slot_name'";
//         $db = dbConn();
//         $results = $db->query($sql);
//         if ($results->num_rows >= 3) {
//             $message['time_slot_name'] = "This date cannot enter in the database";    
//         }
//     }
//     if (!isset($_SESSION['cLogId'])) {
//         $message['time_slot_namez'] = "This date cannot enter in the database";
//         echo "<script>
//                 Swal.fire({
//                     title: 'Error!',
//                     text: 'You have to Login to the system to make bookings !.',
//                     icon: 'error',
//                     confirmButtonText: 'OK'
//                 }).then(() => {
//                     window.location.href = 'http://localhost/SMS/web/login.php?app=yes'; // Redirect to login page
//                 });
//         </script>";
//     }else{
//         $_SESSION["servicename"] = $service_name;
//         $_SESSION["timeslot"] = $time_slot_name;
//     }
//     if (empty($service_name)) {
//         $message['service_name'] = "The service name should be select...!";
//     }
//     if (empty($message)) {
//         $db = dbConn();
//         $AddDate = date('y-m-d');
//         $appointmentNo = date('YmdHis');
//         $bookDate = $_SESSION["bookeddate"];
//         $loggedCustomerId = $_SESSION['cLogId'];
//         $sql1 = "SELECT * FROM tbl_services WHERE service_id= $service_name";
//         $result1 = $db->query($sql1);
//         $row1 = $result1->fetch_assoc();
//         $servicecategory = $row1['service_category_id'];
//         $appstatus = 1;
//         $sql = "INSERT INTO tbl_appointments(appointment_no, service_category, service_name, customer_id, booking_date, time_slot_id, appointment_status, add_date) 
//                         VALUES ('$appointmentNo','$servicecategory','$service_name','$loggedCustomerId','$bookDate','$time_slot_name','$appstatus','$AddDate')";
//         $db->query($sql);
        


//         echo "<script>
//                 Swal.fire({
//                     title: 'Success!',
//                     text: 'You have sucessfully made a booking !.',
//                     icon: 'success',
//                     confirmButtonText: 'OK'
//                 }).then(() => {
//                     window.location.href = 'http://localhost/SMS/web/appointments/paymentsection.php'; // Redirect to success page
//                 });
//         </script>";
//     }
// }
?>
<main id="main">
    <section>
        <div class="container" data-aos="fade-up">
<div class="row">
    <div class="col-6">            <div class="row justify-content-center">
                <h1>Payment Section</h1>         
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
                        <label for="exampleInputName1">Service Price</label>
                        <input type="text" id="exampleInputName1" name="serviceprice" value="Rs. <?= $_SESSION["serviceprice"] ?>" readonly>
                        <input type="hidden" id="exampleInputName1" name="serviceprice" value="Rs. <?= $_SESSION["serviceprice"] ?>"> 
                    </div>
            </div>
        </div>
    <div class="col-6">            
        <div class="row justify-content-center">
                <h1>Payment Section</h1>
                <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                <div class="form-group mt-3">
                <?php
                        $db = dbConn();
                        $dayId= $_SESSION["dayId"];
                        $IdenDay= $dayId;
                        $loggedCustomerId = $_SESSION['cLogId'];
                        echo $sql5 = "SELECT * FROM  tbl_appointments WHERE customer_id = '$loggedCustomerId' AND appointment_status = '1' ";
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
                    </div>
                <div class="form-group mt-3">
                        <label for="exampleInputName1">Upload your Bank Transfer Slip from here</label>
                        <input type="file" id="exampleInputName1" name="bookeddate" value="<?= $_SESSION["bookeddate"] ?>" readonly>
                        <input type="hidden" id="exampleInputName1" name="bookeddate" value="<?= $_SESSION["bookeddate"] ?>">
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary me-2">Confirm</button>
                    </div>
                </form>
            </div></div>
</div>
<br>z

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