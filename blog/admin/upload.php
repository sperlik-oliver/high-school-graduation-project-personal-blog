<?php
require_once "../config.php";

/* Getting file name */
$filename = $_FILES['file']['name'];

/* Location */
//"../static/images/"
//$location = "upload/".$filename;
$location = "../static/images/".$filename;
$uploadOk = 1;
$imageFileType = pathinfo($location,PATHINFO_EXTENSION);

/* Valid extensions */
$valid_extensions = array("jpg","jpeg","png");

/* Check file extension */
if(!in_array(strtolower($imageFileType), $valid_extensions)) {
   $uploadOk = 0;
}

if($uploadOk == 0){
   echo 0;
}else{
   /* Upload file */
   if(move_uploaded_file($_FILES['file']['tmp_name'],$location)){
     echo $location;

 $sql = mysqli_query($conn, "INSERT INTO pictures (picture_name, picture_path) VALUES ('".$filename."','".$location."')");
   // if ($conn->query($sql) === TRUE) {
   //    echo "New record created successfully";
 //   } else {
  //       echo "Error: " . $sql . "<br>" . $conn->error;
 //   }

     $conn->close();



   }else{
     echo 0;
   }




}
