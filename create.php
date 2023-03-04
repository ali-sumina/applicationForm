<?php

// require_once "config.php";

$firstName = $lastName = $email = $phone = $position = $message = $resume = "";
$firstName_err = $lastName_err = $email_err = $phone_err = $position_err = $message_err = $resume_err = "";

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

        //how to offer a dropdown with available cities?

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

    //UPLOAD FILE
    if(isset($_POST['resume']['name'])){

        //get file info
        $fileName = $_FILES['resume']['name'];
        $fileType = pathinfo($fileName, PATHINFO_EXTENSION);
    }
    
    //how to check the size of file?
    //filesize function
    
        //check formats
        $allowFormats = array('docx', 'pdf');
        $filesize = filesize($fileName.'.'.$fileType);
     
        if(in_array($fileType, $allowFormats) && $filesize <= 1000){
    
            $resume = $_FILES['resume']['tmp_name'];
            $resumeContent = addslashes(file_get_contents($resume));





    //check whether errors are empty to continue
    
    //resume_err -- like there's no file???
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
            mysqli_stmt_bind_param($stmt, "isssisss", $param_id, $param_firstName, $param_lastName, $param_email, $param_phone, $pparam_position, $param_message, $param_resume);


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
}



    //end of request method


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/styles.css">
    <title>Document</title>
</head>
<body>
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
    
<!-- FILE -->
        <label for="loadResume" class="form-label">Resume</label>
        <input type="file" name="resume" id="loadResume">
        <input type="submit" name="submit" value="Upload Resume">

    <input type="submit" class="btn btn-primary" value="Submit">
    <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>

    
</body>
</html>