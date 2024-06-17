<?php
function dbConn() {
    $server = "localhost";
    $username = "root";
    $password = "";
    $db = "saloon";

    $conn = new mysqli($server, $username, $password, $db);

    if ($conn->connect_error) {
        die("Database Error : " . $conn->connect_error);
    } else {
        return $conn;
    }
}
?>

<div class="col-1 grid-margin stretch-card"></div>
<div class="col-8 grid-margin stretch-card" style="box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Booking Details</h4>
            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <div class="form-group">
            <?php
                    $db = dbConn();
                    $sql = "SELECT * FROM  tbl_services";
                    $result = $db->query($sql);
                    ?>
                    <label for="exampleInputName1">Select Service Name</label>
                    <select type="text" class="form-control" id="exampleInputName1" name="service_name">
                        <option value="">--</option>
                        <?php
                        while ($row = $result->fetch_assoc()) {
                            ?>
                            <option value="<?= $row['service_name']?>"></option>
                            <?php
                        }
                        ?>
                    </select>
                    <span class="text-danger"><?= @$messages['service_name'] ?></span>
            </div>
          </form>
        </div>
    </div>
</div>
