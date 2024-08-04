<?php
include '../header.php';
?>
<?php
extract($_POST);
if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $bookingdate = dataClean($bookingdate);


    $messages = array();
    if (empty($bookingdate)) {
        $messages['bookingdate'] = "Date should be select";
    }

    if (!empty($bookingdate)) {
        $bookdate = date('y-m-d');
        $bookdate = strtotime($bookingdate);
        $currentdate = date('y-m-d');
        $currentdate = strtotime($currentdate);
        $dayId = date('w', strtotime($bookingdate));
        $_SESSION["dayId"] = $dayId;
        if ($currentdate > $bookingdate) {
            $messages['bookingdate'] = "Cannot Select Date";
        }

        if (!empty($bookingdate)) {
            $sql = "SELECT * FROM tbl_appointments WHERE booking_date='$bookingdate'";
            $db = dbConn();
            $results = $db->query($sql);
            if ($results->num_rows >= 27) {
                $messages['bookingdate'] = "This date cannot enter in the database";
            } else {
                $_SESSION["bookeddate"] = $bookingdate;
                echo "<script>
                Swal.fire({
                    title: 'success!',
                    text: 'You have selected a date for your booking !.',
                    icon: 'success',
                    confirmButtonText: 'NEXT'
                }).then(() => {
                    window.location.href = 'http://localhost/SMS/web/appointments/selectedappointment.php'; // Redirect to success page
                });
        </script>";
            }
        }
    }
}
?>

<div class="container-fluid appointment-container">
    <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-xs-12 img-div">
                    <img class="img-fluid" src="../assets/img/high-fashion-look-glamor-closeup-portrait-beautiful-sexy-stylish-blond-caucasian-young-woman-model-with-bright-makeup.jpg">
                </div>
                <div class="col-lg-6 col-md-6 col-xs-12 form-xs">
                        <form  class="form-center-streched" action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">     
                        <h1 class="title text-center">Book An Appointment</h1>
                        <div class="form-outline ">
                            <div class="form-outline mb-2">
                                <label class="form-label" for="form1Example13">Booking Date</label>
                                <input type="date" class="form-control form-control-sm date-input" id="date" name="bookingdate"
                                    min='<?= date("Y-m-d") ?>' max='<?php echo date("Y-m-d", strtotime("+14 days")); ?>'
                                    value="<?= @$bookingdate; ?>">
                                <div class="text-danger"> <?= @$messages['bookingdate']; ?></div>
                            </div>
                        </div>
                        <button type="submit" action="action" value="pass"
                            class="btn btn-primary btn-lg btn-block">Create a Booking</button>
                        <div class="divider d-flex align-items-center my-4">
                            <p class="text-center fw-bold mx-3 mb-0 text-muted"></p>
                        </div>
                    </form>
                </div>
            </div>
    </div>
</div>