<?php
include 'header.php';
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link href="<?= SYSTEM_PATHS ?>assets/css/min.css" rel="stylesheet">
    <script src="<?= SYSTEM_PATHS ?>assets/js/sweetalert2.all.js"></script>
    <title>Password Reset</title>
    <style>
    body {
      background-color: #333; /* Dark background color */
      color: #fff; /* Default text color */
    }
    
    .navbar {
      background-color: #222; /* Darker background for the navbar */
      padding: 10px;
    }

    .navbar ul {
      list-style-type: none;
      padding: 0;
      margin: 0;
      display: flex;
    }

    .navbar ul li {
      margin-right: 20px;
    }

    .navbar ul li a {
      color: #fff; /* Change this to your desired color */
      text-decoration: none;
    }

    .navbar ul li a.active {
      color: #ff0000; /* Change this to your desired color for active links */
    }

    .navbar ul li a.getstarted {
      color: #00ff00; /* Change this to your desired color for getstarted links */
    }

    .navbar ul li a:hover {
      color: #ffff00; /* Change this to your desired hover color */
    }
  </style>

    <style>
        *{
            padding: 0px;
            margin: 0px;
            box-sizing: border-box;
        }
        body{
            background: whiteS
        }
        .row{
            background-color: white;
            border-radius: 30px;
            box-shadow: 12px 12px 22px grey;
        }
        img{
            border-top-left-radius: 30px;
            border-bottom-left-radius: 30px;
        }
        .btn1{
            border: none;
            outline: none;
            height: 50px;
            width: 100%;
            background-color: black;
            color: white;
            border-radius: 4px;
            font-weight: bold;
        }
        .btn1:hover{
            background-color: white;
            border: 1px solid;
            color: black;
        }
        .img{
            object-fit: contain;
        }
    </style>
  </head>
  <body>
  <?php
            if ($_SERVER['REQUEST_METHOD'] == "POST") {
                extract($_POST);
                $customer_email = cleanInput($customer_email);

                $messages = array();

                if (empty($customer_email)) {
                    $messages['customer_email'] = "The Email should be enter!";
                }

                if (!empty($customer_email)) {
                    $sql = "SELECT * FROM tbl_customers WHERE customer_email='$customer_email'";
                    $db = dbConn();
                    $results = $db->query($sql);
                    if ($results->num_rows == 0) {
                        $messages['customer_email'] = "This email is not in the database";
                    }
                }

                if(empty($messages)) {
                    $db= dbConn();
                    // $Password= sha1($Password);
                    $sql="SELECT * FROM tbl_customers customer_email='$customer_email'";
                    $result=$db->query($sql);
                    
                        $row=$result->fetch_assoc();
                        $_SESSION['ResetUserId']=$row['customer_id']; 
                        $ResetUserId=$row['UserId'];
                        //left side form value name eka ------ right side database column name eka
                        $_SESSION['ResetTitle']=$row['Title'];
                        $_SESSION['ResetFirstName']=$row['FirstName'];
                        $_SESSION['ResetLastName']=$row['LastName'];
                        $_SESSION['ResetUserRole']=$row['UserRole'];
                        $_SESSION['ResetUserEmail']=$row['email'];
                      
                         $resettoken=uniqid();
                    
                        $ResetEmail=$row['email'];
                    //Create a variable & assign value to it
                        $to=$ResetEmail;
                    //Create varibales in Left Side assign database column name to right side
                        $UserFirstName=$row['FirstName'];
                        $UserLastName=$row['LastName'];
                         $sql1="UPDATE tbl_users SET reset_token='$resettoken' WHERE UserId='$ResetUserId'";
                    //tbl_users table eke user id ekata relevant token eka update wenawa
                        $result1=$db->query($sql1);
                    //array ekakata results assign wena eka
                        $toname=$UserFirstName . $UserLastName;
                    //to name kiyana ekata userfirstname ekai userlastname ekai assign karana eka
                        $subject="Verification Code for Reset Your Password";
                    //email subjecte eka
                        $body=$resettoken;
                    //email body ekata token eka send karana eka
                        $altbody="If you can see this, you will have a secure connection";
                        $alt = "Customer  Registration";
                    //alternatives if the above not happened
                        send_email($to, $toname, $subject,$body,$alt);
                    //email eka send wena eka 

                         "success";
                        // print_r($_SESSION);
                        header("Location:resetpassword.php");                                                               
                    //submit eka press unama ilaga wenna one de
                }
            }
            ?>
    <section class="form ">
        <div class="container pt-5">
           
        <div class="row no-gutters">
            <div class="col-lg-5">
                <!-- <img src="" class="img" alt=""> -->
            </div>
            <div class="col-lg-7 px-5">
                <h1 class="font-weight-bold py-3 pt-5" style="color: black;">Reset Your Password</h1>
                
                <form  method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                    <div class="form-row">
                       <div class="col-lg-7">
                        <input type="text" placeholder="Enter Your Email Address" name="UserEmail" id="useremail" class="form-control my-3 p-4">
                        <div class="text-danger"> 
                    <?php echo @$messages['error_email']; ?>
                    </div>
                       </div>
                        </div>
                    <div class="form-row">
                       <div class="col-lg-7">
                        <button type="submit" class="btn1 mt-3 mb-5" ><a href="resetpassword.php">Submit</button>
                       </div>
                    </div>
                </form>
            </div>
        </div>
        </div>
    </section>
    
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  </body>
</html>

