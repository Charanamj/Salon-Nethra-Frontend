<?php 
include '../header.php';
?>
<?php
extract($_POST);
if ($_SERVER ['REQUEST_METHOD'] == "POST") {

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

        if ($currentdate > $bookingdate) {
            $messages['bookingdate'] = "Cannot Select Date";
        }

        if (!empty($bookingdate)) {
            $sql = "SELECT * FROM tbl_appointments WHERE booking_date='$bookingdate'";
            $db = dbConn();
            $results = $db->query($sql);
            if ($results->num_rows > 0) {
                $messages['bookingdate'] = "This date cannot cannot enter in the database";    
            }else{
                $_SESSION["bookeddate"]= $bookingdate;
                echo "<script>
                Swal.fire({
                    title: 'Added!',
                    text: 'Added Successfully !.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.location.href = 'http://localhost/SMS/web/appointments/selectedappointment.php'; // Redirect to success page
                });
        </script>";
            }
        }
    }
}
?>

<div class="container">
    <section class="justify-content-center">
        <div class="row">
            <div class="col-md-7 " style="box-shadow: 5px 5px 5px 5px #888888;"> 
                <form  class="col-md-9 justify-content-center" method="POST"  action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">            
                    <h1 class="title text-center">Book An Appointment</h1>
                    <div class="form-outline ">
                        <div class="form-outline mb-2">
                            <label class="form-label" for="form1Example13">Booking Date</label>
                            <input type="date" class="form-control form-control-sm" id="city"  name="bookingdate"  min='<?= date("Y-m-d")?>' max='<?php echo date("Y-m-d", strtotime("+14 days")); ?>' value="<?= @$bookingdate; ?>">
                            <div class="text-danger"> <?= @$messages['bookingdate']; ?></div>
                        </div>
                    </div>          
                    <button type="submit" action="action" value="pass" class="btn btn-primary btn-lg btn-block">Create a Booking</button>
                    <div class="divider d-flex align-items-center my-4">
                        <p class="text-center fw-bold mx-3 mb-0 text-muted"></p>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>



