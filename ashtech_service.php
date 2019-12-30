<?php


date_default_timezone_set('Asia/Kolkata');
$date = date('d_m_Y_h_i_s_a', time());
$target_dir = "ashtechUploads/";
$target_file = $target_dir . $date."_".basename($_FILES["file"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));


$data=$_REQUEST['data'];
print_r($data);

$data=stripslashes($data);
//echo $data;die;
$decodedText = html_entity_decode($data);
$decodedText=stripslashes($decodedText);
// print_r (json_decode($decodedText));die;
$data=json_decode($decodedText,true);


$conn = new mysqli("localhost","ubidb",'ubipass','shashank_ashtech_testing');





$conn->query("insert into testing values('".$data["firstColumn"]."','".$data["secondColumn"]."','".$data["thirdColumn"]."')");







// Check if image file is a actual image or fake image
/*
if(isset($_POST["submit"])) {
    /*
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}
*/
// Check if file already exists
if (file_exists($target_file)) {
    /*
    echo "Sorry, file already exists.";
    $uploadOk = 0;
    */
}
// Check file size
/*
if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
*/
// Allow certain file formats
/*
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
*/
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {

        if (($handle = fopen($target_file, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $num = count($data);
                echo "<p> $num fields in line $row: <br /></p>\n";
                $row++;
                $conn->query("insert into testing values('".$data[0]."','".$data[1]."','".$data[2]."')");

            }
            fclose($handle);
        }


        echo "The file ". basename( $_FILES["file"]["name"]). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}


//$data=jason_decode($_POST['data']);

//if(isset($_REQUEST["file"]))
//echo "File Found!" ;




?>