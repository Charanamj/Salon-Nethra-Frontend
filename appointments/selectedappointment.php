<?php
include '../header.php';
include '../assets/phpmail/mail.php';
?>
<?php
extract($_POST);
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   
    $service_name = dataClean($service_name);

    $message = array();

    if (empty($service_name)) {
        $message['service_name'] = "The service name should be select...!";
    }
    if (!empty($time_slot_name)) {
        $sql = "SELECT * FROM tbl_appointments WHERE booking_date='$bookeddate'AND time_slot_id='$time_slot_name'";
        $db = dbConn();
        $results = $db->query($sql);
        if ($results->num_rows >= 3) {
            $message['time_slot_name'] = "This date cannot enter in the database";    
        }
    }
    if ((!empty($time_slot_name)) ) {
        $loggedCustomerId = @$_SESSION['cLogId'];
         $sql2 = "SELECT 
                (SELECT COUNT(*) 
                FROM tbl_appointments 
                WHERE customer_id='$loggedCustomerId' 
                AND booking_date='$bookeddate' 
                AND time_slot_id='$time_slot_name') as count, 
                tbl_appointments.*
            FROM tbl_appointments
            WHERE customer_id='$loggedCustomerId' 
            AND booking_date='$bookeddate' 
            AND time_slot_id='$time_slot_name'";
        $db = dbConn();
        $results2 = $db->query($sql2);
        $row2 = $results2->fetch_assoc();
        @$abc = $row2 ['count'];

        if (@$abc == null ) {
            "only one record have"; 
        }else{
            // $message['time_slot_name'] = "The bookings were completed to this date !.";
            echo "<script>
                Swal.fire({
                    title: 'Error!',
                    text: 'Allocated time slots for the slected date is already booked !.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.location.href = 'http://localhost/SMS/web/login.php?app=yes'; // Redirect to login page
                });
        </script>";    
        }
    }
    if (!isset($_SESSION['cLogId'])) {
        $message['time_slot_namez'] = "This date cannot enter in the database";
        echo "<script>
                Swal.fire({
                    title: 'Error!',
                    text: 'You have to Login to the system to make bookings !.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.location.href = 'http://localhost/SMS/web/login.php?app=yes'; // Redirect to login page
                });
        </script>";
    }else{
        $_SESSION["servicename"] = $service_name;
        $_SESSION["timeslot"] = $time_slot_name;
    }
    if (empty($service_name)) {
        $message['service_name'] = "The service name should be select...!";
    }
    if (empty($message)) {
        $db = dbConn();
        $AddDate = date('y-m-d');
        $_SESSION["service_id"] = $service_name;
        $appointmentNo = date('YmdHis');
        $_SESSION["selectedappno"] = $appointmentNo;
        $bookDate = $_SESSION["bookeddate"];
        $loggedCustomerId = $_SESSION['cLogId'];
        $sql1 = "SELECT * FROM tbl_services WHERE service_id= $service_name";
        $result1 = $db->query($sql1);
        $row1 = $result1->fetch_assoc();
        $servicecategory = $row1['service_category_id'];
        $appstatus = 1;
        
        $_SESSION['selectedtimeslot'] = $time_slot_name;

        $_SESSION["appno"] = $appointmentNo;
        $_SESSION["servicename"] = $service_name;
        $_SESSION["timeslotid"] = $time_slot_name;

        echo "<script>
                Swal.fire({
                    title: 'Success!',
                    text: 'Time slot allocated to the selected date is available for booking !.',
                    icon: 'success',
                    confirmButtonText: 'Confirm'
                }).then(() => {
                    window.location.href = 'http://localhost/SMS/web/appointments/processappointment.php'; // Redirect to success page
                });
        </script>";
    }
}
?>
<main id="main">
    <section>
        <div class="container" data-aos="fade-up">

            <div class="row justify-content-center">

                <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                <div class="form-group mt-3">
                        <label for="exampleInputName1">Selected Appointment Date</label>
                        <input type="text" id="exampleInputName1" name="bookeddate" value="<?= $_SESSION["bookeddate"] ?>" readonly>
                        <input type="hidden" id="exampleInputName1" name="bookeddate" value="<?= $_SESSION["bookeddate"] ?>">
                    </div>
                    <div class="form-group mt-3">
                        <?php
                        $db = dbConn();
                        $sql = "SELECT * FROM  tbl_services";
                        $result = $db->query($sql);
                        ?>
                        <label for="exampleInputName1">Select Service Name</label>
                        <select type="text" id="exampleInputName1" name="service_name">
                            <option value="">--</option>
                            <?php
                            while ($row = $result->fetch_assoc()) {
                                ?>
                                <option value="<?= $row['service_id'] ?>">
                                    <?= $row['service_name'] . " | Rs. " . number_format($row['service_price'], 2) ?>
                                    
                                </option>
                                <?php
                            }
                            ?>
                        </select>
                        <span class="text-danger"><?= @$message['service_name'] ?></span>
                    </div>
                    <div class="form-group mt-3">
                        <?php
                        $db = dbConn();
                        $dayId= $_SESSION["dayId"];
                        $IdenDay= $dayId;
                         $sql = "SELECT * FROM  tbl_time_slots WHERE time_slot_day_id = $IdenDay ";
                        $result = $db->query($sql);
                        ?>
                        <label for="exampleInputName1">Selected Time Slot</label>
                        <select type="text" id="exampleInputName1" name="time_slot_name">
                            <option value="">--</option>
                            <?php
                            while ($row = $result->fetch_assoc()) {
                                ?>
                                <option value="<?= $row['time_slot_id'] ?>">
                                    <?= $row['time_slot_name'] . " " . " [ ". $row['time_slot_id'] . " [ ". $row['time_slot_start_time'] . " - " . " " . $row['time_slot_end_time'] . " ] "?>
                                </option>
                                <?php
                            }
                            ?>
                        </select>
                        <span class="text-danger"><?= @$message['time_slot_name'] ?></span>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary me-2">Search Availability</button>
                    </div>
                </form>
            </div>
        </div>
        </div>
    </section>
</main>
<?php
include '../footer.php';
?>