<?php
require_once "config.php";
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

        .btn{
            margin-right: 15px !important;
        }
        
    </style>
</head>
<body>
    <div class="container">
    <h2>Applicants</h2>
    <a href="create.php" class="btn btn-primary">New Applicant</a>
<table class="table table-striped">
  <thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">First Name</th>
      <th scope="col">Last Name</th>
      <th scope="col">Email</th>
      <th scope="col">Phone Number</th>
      <th scope="col">Position</th>
      <th scope="col">Message</th>
      <th scope="col">Resume</th>
    </tr>
  </thead>

  <?php 
  //we show what we have in db
  $sql = "SELECT * FROM applicants";
  
  //execute query
  if ($result = mysqli_query($conn, $sql)){
      echo "<tbody>";
    while ($row = mysqli_fetch_array($result)){
          $id = $row['id'];
          $firstName = $row['FirstName'];
          $lastName = $row['LastName'];
          $email = $row['Email'];
          $phone = $row['Phone'];
          $position = $row['Position'];
          $message = $row['Details'];
          $resume = $row['Resume'];
          echo "<tr>";
          echo "<th scope='row'>". $id ."</th>";
          echo "<td>". $firstName ."</td>";
          echo "<td>". $lastName ."</td>";
          echo "<td>". $email ."</td>";
          echo "<td>". $phone ."</td>";
          echo "<td>". $position ."</td>";
          echo "<td>". $message ."</td>";

          //how to show a link to the file?
          echo "<td>". $resume ."</td>";
          
          echo "<td>";
          echo '<a href="read.php?id=' . $id . '" class="mr-3 btn btn-primary" title="View Record" data-toggle="tooltip">View Record</a>';
          echo '<a href="update.php?id=' . $id . '" class="mr-3 btn btn-warning" title="Update Record" data-toggle="tooltip">Update Record</a>';
          echo '<a href="delete.php?id=' . $id . '" class="btn btn-danger" title="Delete Record" data-toggle="tooltip">Delete Record</a>';
          echo "</td>";
        echo "</tr>";
    }
    echo "</tbody>";
  }
  
  
  
  
  ?>

    
</table>
</div>
</body>
</html>