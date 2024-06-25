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
    if (empty($message)) {
        $db = dbConn();
        $bookDate = $_SESSION["bookeddate"];
        $sql = "INSERT INTO tbl_appointments(service_name, booking_date, time_slot_id) 
                        VALUES ('$service_name','$bookDate','$time_slot_name')";
        $db->query($sql);

        echo "<script>
                Swal.fire({
                    title: 'Added!',
                    text: 'Added Successfully !.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.location.href = 'http://localhost/SMS/web/index.php'; // Redirect to success page
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
                        <input type="text" id="exampleInputName1" name="bokkeddate" value="<?= $_SESSION["bookeddate"] ?>" readonly>
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
                                    <?= $row['time_slot_name'] ?>
                                </option>
                                <?php
                            }
                            ?>
                        </select>
                        <span class="text-danger"><?= @$message['time_slot_name'] ?></span>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary me-2">Submit</button>
                    </div>
                </form>
            </div>
        </div>
        </div>
    </section><!-- End Contact Us Section -->
</main>
<?php
include '../footer.php';
?>