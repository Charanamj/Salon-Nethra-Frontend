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
        echo $sql = "INSERT INTO tbl_appointments( 
                        service_name, booking_date) 
                        VALUES ('$service_name','$bookeddate')";
        $db->query($sql);
    }
}

?>
<main id="main">
    <section>
        <div class="container" data-aos="fade-up">

            <div class="row justify-content-center">

                <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
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
                        $sql = "SELECT * FROM  tbl_appointments";
                        $result = $db->query($sql);
                        ?>
                        <label for="exampleInputName1">Selected Time Slot</label>
                        <input readonly type="text" value="<?= @$_SESSION["bookeddate"] ?>">
                        <input type="hidden" name="bookeddate" value="<?= @$_SESSION["bookeddate"] ?>">
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