<?php include 'header.php' ?>
<link href="assets/css/style.css" rel="stylesheet" type="text/css"/>

<div class="container">
    <div class="main-body">
    
          <!-- Breadcrumb -->
          <nav aria-label="breadcrumb" class="main-breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item"><a href="javascript:void(0)">User</a></li>
              <li class="breadcrumb-item active" aria-current="page">User Profile</li>
            </ol>
          </nav>
          <!-- /Breadcrumb -->
    
          <div class="row gutters-sm">
            <div class="col-md-4 mb-3">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex flex-column align-items-center text-center">
                    <img src="web/assets/img/customers/<?=$_SESSION["cLogImg"]?>" alt="Admin" class="rounded-circle" width="150">
                    <div class="mt-3">
                      <h4><?php echo $_SESSION["cLogFirstname"] . " " . $_SESSION["cLogLastname"] ?></h4>
                    </div>
                  </div>
                </div>
              </div>             
            </div>
            <div class="col-md-8">
              <div class="card mb-3">
                <div class="card-body">
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Full Name</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                       <?php echo $_SESSION["cLogFirstname"] . " " . $_SESSION["cLogLastname"] ?>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Email</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      <?php echo $_SESSION["cLogEmail"]?>
                    </div>
                  </div>
                  <hr>
                 
              
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Mobile</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      <?php echo $_SESSION["cLogTelNo"]?>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Address</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      <?php echo $_SESSION["cLogAddressline1"] . ", " . $_SESSION["cLogAddressline2"]?>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-12">
                         <form method='post' action="editprofile.php">
                             <?php $UserID=$_SESSION["cLogId"] ?>
                                <input type="hidden" name="UserID" value="<?=$UserID?>">
                                <button type="submit" name="action" value="edit">Edit</button>
                            </form>
<!--                      <a class="btn btn-info " href="editprofile.php">Edit Your Profile</a>-->
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <h1>Appointment History</h1>
            <div class="col-md-12">
            <table class="table table-striped">
                        <thead>
                            <tr>
                                <th> Appointment No </th>
                                <th> Service Category Name </th>
                                <th> Service Name </th>
                                <th> Booked Date </th>
                                <th> Time Slot Name </th>
                                <th> Start Time </th>
                                <th> End Time </th>
                                
                                <th> <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                                <select type="text" class="form-control" id="exampleInputName1"
                                                name="filter_status" value="<?= @$filter_status ?>">
                                                <option value="">- -</option>
                                                <option value="1" <?php
                                                if (@$filter_status == "1") {
                                                    echo "selected";
                                                }
                                                ?>style="color: green;">Pending</option>
                                                <option value="2" <?php
                                                if (@$filter_status == "2") {
                                                    echo "selected";
                                                }
                                                ?>>Advance Payment</option>
                                                <option value="3" <?php
                                                if (@$filter_status == "3") {
                                                    echo "selected";
                                                }
                                                ?>>Processing</option>
                                                <option value="4" <?php
                                                if (@$filter_status == "4") {
                                                    echo "selected";
                                                }
                                                ?>>Completed Payment</option>
                                                <option value="5" <?php
                                                if (@$filter_status == "5") {
                                                    echo "selected";
                                                }
                                                ?>>Cancelled/Customer</option>
                                                <option value="6" <?php
                                                if (@$filter_status == "6") {
                                                    echo "selected";
                                                }
                                                ?>>Cancelled/Salon</option>
                                                
                                            </select>   
                            
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            extract($_POST);
                            if ($_SERVER['REQUEST_METHOD'] == "POST" && @$action == 'filter'){
                                extract($_POST);
                                $db = dbConn();
                                $sql = "SELECT * FROM tbl_appointments WHERE appointment_status = '$filter_status' AND customer_id = $UserID";
                            $result = $db->query($sql);
                            }else{
                                $db = dbConn();
                                $sql = "SELECT * FROM tbl_appointments WHERE customer_id = $UserID";
                                $result = $db->query($sql);
                            }
                            ?>
                            <?php
                            if ($result->num_rows > 0) {
                                $i = 1;
                                while ($row = $result->fetch_assoc()) {
                                    ?>
                                    <tr>
                                        <td><?= $row['appointment_no'] ?> </td>
                                        <?php
                                        $db = dbConn();
                                        $servicecategoryname = $row['service_category'];
                                        $sql1 = "SELECT * FROM  tbl_services_category WHERE service_category_id='$servicecategoryname'";
                                        $result1 = $db->query($sql1);
                                        $row1 = $result1->fetch_assoc()
                                            ?>
                                        <td><?= $row1['service_category_name'] ?> </td>
                                        <?php
                                        $db = dbConn();
                                        $servicename = $row['service_name'];
                                        $sql2 = "SELECT * FROM  tbl_services WHERE service_id='$servicename'";
                                        $result2 = $db->query($sql2);
                                        $row2 = $result2->fetch_assoc()
                                            ?>
                                        <td><?= $row2['service_name'] ?> </td>
                                        <td><?= $row['booking_date'] ?></td>
                                        <?php
                                        $db = dbConn();
                                        $timeslotname = $row['time_slot_id'];
                                        $sql3 = "SELECT * FROM  tbl_time_slots WHERE time_slot_id='$timeslotname'";
                                        $result3 = $db->query($sql3);
                                        $row3 = $result3->fetch_assoc()
                                            ?>
                                        <td><?= $row3['time_slot_name'] ?></td>
                                        <td><?= $row3['time_slot_start_time'] ?></td>
                                        <td><?= $row3['time_slot_end_time'] ?></td>
                                        <td></td>
                                    </tr>
                                    <?php
                                }
                            }
                            ?>
                        </tbody>
                    </table>
            </div>