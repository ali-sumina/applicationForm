<?php

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

        //sql to insert img
        $sql = "INSERT into applicants (Resume) VALUES ('$resumeContent', NOW())";

        $insert = $db->query($sql);
        if ($insert){
            echo "Resume uploaded successfully";
        } else {
            echo "File upload failed, try again";
        }

        //incorrect formats
        } else {
            echo "Sorry only PDF and DOCX files are allowed";
            echo $filesize;
        }

?>