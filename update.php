<?php
require_once "config.php";

// $city = $country = $year = "";
$firstName_err = $lastName_err = $email_err = $phone_err = $position_err = $message_err = $resume_err = "";
$id = $_GET['id'];

// if(isset($id) && !empty($id)){
    //if id exists

    if($_SERVER['REQUEST_METHOD'] == "POST"){
        //trimming vars
        $input_firstName = trim($_POST['firstname']);
        $input_lastName = trim($_POST['lastname']);
        $input_email = trim($_POST['email']);
        $input_phone = trim($_POST['phone']);
        $input_position = trim($_POST['position']);
        // $input_message = trim($_POST['message']);
    
        //&& empty($input_lastName) && empty($input_position) && empty($input_message)
    
        //FIRST NAME
        if(empty($input_firstName)){
            $firstName_err = "Please enter the first name";
        } elseif ((!filter_var($input_firstName, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z\s]+$/"))))){
    
            $firstName_err = "Please enter a valid first name";
        } //define that input value equals what we will insert into db
        else {
            $firstName = $input_firstName;
            // $input_city = $city;
        }
    
        //LAST NAME
        if(empty($input_lastName)){
            $lastName_err = "Please enter the last name";
        } elseif ((!filter_var($input_lastName, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z\s]+$/"))))){
            $lastName_err = "Please enter a valid last name";
        }
        else {
            $lastName = $input_lastName;
        }
    
        //EMAIL
        if(empty($input_email)){
            $email_err = "Please enter your email";
        } elseif ((!filter_var($input_email, FILTER_VALIDATE_EMAIL))) {
                $email_err = "Please enter a valid email";
        } else {
            $email = $input_email;
            // $input_city = $city;    }
        }
    
        //PHONE
        if(empty($input_phone)){
            $phone_err = "Please enter your phone number";
        } elseif ((filter_var($phone, FILTER_SANITIZE_NUMBER_INT))) {
                $phone_err = "Please enter a valid phone number";
        } else {
            $phone = $input_phone;
    
        }
    
        //POSITION
        if(empty($input_position)){
            $position_err = "Please enter the position";
        } elseif ((!filter_var($input_position, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z\s]+$/"))))){
            $position_err = "Please enter a valid position";
        }
        else {
            $position = $input_position;
        }

        



    //check whether errors are empty to continue

    //resume_err -- like there's no file??? -- check empty

    if (empty($firstName_err) && empty($lastName_err) && empty($email_err) && empty($phone_err) && empty($position_err)){
        //set the statement -- prepare it for next vars
        $sql = "UPDATE applicants SET FirstName = ?, LastName = ?, Email = ?, Phone = ?, Position = ?, Details = ?, Resume = ? WHERE id = ?";

        //set parameters
        $param_id = $id;
        $param_firstName = $firstName;
        $param_lastName = $lastName;
        $param_email = $email;
        $param_phone = $phone;
        $param_position = $position;
        $param_message = $message;
        $param_resume = $resume;

        //check the connection with db and bind parameters with statement
        if ($stmt = mysqli_prepare($conn, $sql)){

            //datatype for file (longblob)?
            mysqli_stmt_bind_param($stmt, "isssissss", $param_id, $param_firstName, $param_lastName, $param_email, $param_phone, $pparam_position, $param_message, $param_resume);


            //execute the statement
            if(mysqli_stmt_execute($stmt)){
                //redirect to main page
                header("location: success.php");
                //finish the program
                exit();
            } else {
                echo "Something went wrong";
            }
        }
        //close statement
        mysqli_stmt_close($stmt);
    }
    //close connection
    mysqli_close($conn);
}
 else {
    if(isset($id) && !empty(trim(($id)))){
        $sql = "SELECT * FROM applicants WHERE id = ?";

        if($stmt = mysqli_prepare($conn, $sql)) {
  
            // echo "fnkwem dlew";

            // echo $param_id;
    
            mysqli_stmt_bind_param($stmt, "i", $param_id);
              
            $param_id = $id;
    
            //execute. if success, fetch the data
    
            if(mysqli_stmt_execute($stmt)) {
                //assign the result from statement
                $result = mysqli_stmt_get_result($stmt);
    
                //we check whether the requested ID is unique
                if(mysqli_num_rows($result) == 1){
                    //acc to the ID we fetch another data (as associative array) we have (city. country. year)
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    
                    //break down the data from array into vars
                                
                    $firstName = $row['FirstName'];
                    $lastName = $row['LastName'];
                    $email = $row['Email'];
                    $phone = $row['Phone'];
                    $position = $row['Position'];
                    $message = $row['Details'];
                    $resume = $row['Resume'];

                    echo $city;
    
                } else{
                    echo "Something went wrong";
    
                    //why do we exit here?
    
                    exit();
                }
    
                mysqli_stmt_close($stmt);
                mysqli_close($conn);
            }
        } else{
            echo "Something went wrong";
    
                    exit();
                }
    
                mysqli_stmt_close($stmt);
                mysqli_close($conn);
        }
    }



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <title>Document</title>
    <style>
        body{
            margin-top: 70px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Set your destination</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
    <!-- first name. last name, email, phone, position applied for, details (message), resume(upload file) -->

    <!-- first name -->
    <div class="mb-3">
    <label for="exampleFormControlInput1" class="form-label">First Name</label>
    <input name="firstname" type="firstname" class="form-control <?php (!empty($firstName_err)) ? 'is-invalid' : " " ?>" id="exampleFormControlInput1" placeholder="Type your first name" value="<?php echo $firstName ?>">
    <span class="invalid-feedback"><?php echo $firstName_err; ?></span>
    </div>

    <!-- last name -->
    <div class="mb-3">
    <label for="exampleFormControlInput1" class="form-label">Last Name</label>
    <input name="lastname" type="lastname" class="form-control <?php (!empty($lastName_err)) ? 'is-invalid' : " " ?>" id="exampleFormControlInput1" placeholder="Type your last name" value="<?php echo $lastName ?>">
    <span class="invalid-feedback"><?php echo $lastName_err; ?></span>
    </div>

    <!-- email -->
    <div class="mb-3">
    <label for="exampleFormControlInput1" class="form-label">Email</label>
    <input name="email" type="email" class="form-control <?php (!empty($email_err)) ? 'is-invalid' : " " ?>" id="exampleFormControlInput1" placeholder="Type your email" value="<?php echo $email ?>">
    <span class="invalid-feedback"><?php echo $email_err; ?></span>
    </div>

    <!-- phone number -->
    <div class="mb-3">
    <label for="exampleFormControlInput1" class="form-label">Phone Number</label>
    <input name="phone" type="phone" class="form-control <?php (!empty($phone_err)) ? 'is-invalid' : " " ?>" id="exampleFormControlInput1" placeholder="Type your phone number" value="<?php echo $phone ?>">
    <span class="invalid-feedback"><?php echo $phone_err; ?></span>
    </div>

    <!-- position -->
    <div class="mb-3">
    <label for="exampleFormControlInput1" class="form-label">Position</label>
    <input name="position" type="position" class="form-control <?php (!empty($position_err)) ? 'is-invalid' : " " ?>" id="exampleFormControlInput1" placeholder="Type the country" value="<?php echo $position ?>">
    <span class="invalid-feedback"><?php echo $position_err; ?></span>
    </div>

    <!-- message -->
    <div class="mb-3">
    <label for="exampleFormControlInput1" class="form-label">Message</label>
    <textarea name="message" type='message' class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="Type your message" value='<?php echo $message ?>'></textarea>
    </div>

    <!-- RESUME FILE -- how to display here in order to update afterwards? -->
    <div class="mb-3">
    <label for="exampleFormControlInput1" class="form-label">Message</label>
    <div class="file"><iframe src='data:application/pdf;base64," <?php base64_encode($resume); ?> "' width='500px' height='600px'></iframe></div>
    </div>


    <!-- show id, either submit the form with data or cancel and get back to the home page -->
    <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" />
    <input type="submit" class="btn btn-primary" value="Submit">
    <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>

    

    </form>


</div>
    
</body>
</html>