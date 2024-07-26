<?php
include 'header.php';
?>
<?php
extract($_POST);
if ($_SERVER['REQUEST_METHOD'] == "POST" && @$action == 'addresponse') {
    extract($_POST);
    $customer_name= dataClean($customer_name);
    $customer_email = dataClean($customer_email);
    $customer_message = dataClean($customer_message);

    $messages = array();

    if (empty($customer_name)) {
        $messages['customer_name'] = "Customer name should not be empty..!";
    }
    if (empty($customer_email)) {
        $messages['customer_email'] = "Customer email should not be empty..!";
    }
    if (empty($customer_message)) {
        $messages['customer_message'] = "Customer message should not be empty..!";
    }

    if (empty($messages)) {
        $db = dbConn();
        $status = 1;
        $AddDate = date('y-m-d');
        $sql = "INSERT INTO `tbl_inquries`(inquiry_status, customer_name, customer_email, 
        customer_message, inquiry_add_date) VALUES ('$status', '$customer_name',
        '$customer_email','$customer_message','$AddDate')";
        $result = $db->query($sql);
        echo "<script>
        Swal.fire({
            title: 'Submitted!',
            text: 'Your message has been recorded !.',
            icon: 'success',
            confirmButtonText: 'OK'
        }).then(() => {
            window.location.href = 'http://localhost/SMS/web/index.php'; // Redirect to Home page
        });
</script>";
    }
}
?>
    <section id="why-us" class="why-us">
      <div class="container" data-aos="fade-up">

        <div class="section-header">
          <h2>Contact Us</h2>
        </div>

        <div class="row g-0" data-aos="fade-up" data-aos-delay="200"></div>
        <section class="col-12 grid-margin stretch-card">
  <div class="card">
    <div class="card-body">
      <h4 class="card-title" style="color: blue">Reaching us through your messages</h4>
      <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <div class="form-group">
                    <label for="exampleInputName1">Customer Name</label>
                    <input type="text" class="form-control" id="exampleInputName1" name="customer_name"
                        value="<?= @$customer_name ?>" placeholder="Enter your name">
                    <span class="text-danger"><?= @$messages['customer_name'] ?></span>
            </div>
            <div class="form-group">
                    <label for="exampleInputName1">Customer Email</label>
                    <input type="email" class="form-control" id="exampleInputName1" name="customer_email"
                        value="<?= @$customer_email ?>" placeholder="Enter your email">
                    <span class="text-danger"><?= @$messages['customer_email'] ?></span>
            </div>
            <div class="form-group">
                    <label for="exampleInputName1">Customer Message</label>
                    <input type="message" class="form-control" id="exampleInputName1" name="customer_message"
                        value="<?= @$customer_message ?>" placeholder="Enter your message">
                    <span class="text-danger"><?= @$messages['customer_message'] ?></span>
            </div>
            <button type="submit" name="action" value="addresponse" class="btn btn-gradient-primary me-2">Submit</button>
      </form>
</div>
</div>
</section>      
<?php
include 'footer.php';
?> 