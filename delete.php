<?php
require_once "config.php";

//post -- id comes from 
$id = $_POST['id'];


 if(isset($id) && !empty($id)){
    $sql = "DELETE FROM applicants WHERE id = ?";


    if($stmt = mysqli_prepare($conn, $sql)){

        mysqli_stmt_bind_param($stmt, 'i', $param_id);
        $param_id = trim($id);
        // echo $id, $param_id;

        if (mysqli_stmt_execute($stmt)){
            header('location:success.php');
            exit();
        } else {
            echo "Something went wrong";
        }
    }
 }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <style></style>
</head>
<body>
    <div class="container">

    <h2 class="mt-5">Delete Record</h2>

    <form action="<?php echo htmlspecialchars(basename($_SERVER['PHP_SELF'])); ?>" method="post">
    <div class="alert alert-danger">
        <input type="hidden" name="id" value="<?php echo trim($_GET['id']); ?>" />
        <p>Are you Sure you want to Delete this employee Record?
        </p>
        <input type="submit" value="Yes" class="btn btn-danger">
        <a href="index.php" class="btn btn-secondary">No </a>

    </div>

</form>

    </div>
</body>
</html>