<?php

$user_ID = $_SESSION['user_id'];
include_once('../../backend/config.php');
include_once('../../backend/db_connector.php');

$target_dir = "../../../files/".$user_ID."_files/";
if (!is_dir($target_dir));
if (!file_exists($target_dir)) {
    mkdir($target_dir, 0770, true);
}



if (isset($_FILES['file']['name']) )
{
    $target_file = $target_dir . basename($_FILES["file"]["name"]);
    $uploadOk = 1;
    $filepdf = 1;
    $fileImg = 1;
    
    $fileTypeExten = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    
    if (file_exists($target_file)) {
        //  echo " Sorry, file already exists.";
        //echo $target_file;
        // echo $_SESSION['user_id'];
        $uploadOk = 0;
    }
    
    // Check file size
    if ($_FILES["file"]["size"] > 5000000) {
        //  echo //" Sorry, your file is too large.";
        $uploadOk = 0;
    }
    
    // Allow certain file formats
    if($fileTypeExten != "pdf" && $fileTypeExten != "png" && $fileTypeExten != "jpg" && $fileTypeExten != "gif" && $fileTypeExten != "doc"
        && $fileTypeExten !="docx" && $fileTypeExten !="rtf" && $fileTypeExten !="xls" && $fileTypeExten !="xlsx" && $fileTypeExten !="ppt"
        && $fileTypeExten !="pptx" && $fileTypeExten !="txt") {
            // echo " Sorry, only PDF, JPG, PNG & GIF files are allowed.";
            $uploadOk = 0;
            $filepdf = 0;
        }
        
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            //echo " Sorry, your file was not uploaded.";
            // if everything is ok, try to upload file
        } else {
            
            // move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);
            if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
                // echo " The file ". htmlspecialchars( basename( $_FILES["file"]["name"])). " has been uploaded.";
            } else {
                //echo " Sorry, there was an error uploading your file.";
            }
            
            
        }
}

if (isset($_FILES['files']['name']))
{
    $target_file = $target_dir . basename($_FILES["files"]["name"]);
    $uploadOk = 1;
    $fileTypeExten = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    
    // Check if file already exists
    if (file_exists($target_file)) {
        // echo " Sorry, file already exists.";
        //echo $target_file;
        $uploadOk = 0;
    }
    
    // Check file size
    if ($_FILES["files"]["size"] > 5000000) {
        //echo " Sorry, your file is too large.";
        $uploadOk = 0;
    }
    
    // Allow certain file formats
    if($fileTypeExten != "pdf" && $fileTypeExten != "png" && $fileTypeExten != "jpg" && $fileTypeExten != "gif" && $fileTypeExten != "doc"
        && $fileTypeExten !="docx" && $fileTypeExten !="rtf" && $fileTypeExten !="xls" && $fileTypeExten !="xlsx" && $fileTypeExten !="ppt"
        && $fileTypeExten !="pptx" && $fileTypeExten !="txt") {
            //echo " Sorry, only PDF, JPG, PNG & GIF files are allowed.";
            $uploadOk = 0;
            $fileImg = 0;
        }
        
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            //echo " Sorry, your file was not uploaded.";
            // if everything is ok, try to upload file
        } else {
            // move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);
            if (move_uploaded_file($_FILES["files"]["tmp_name"], $target_file)) {
                //echo " The file ". htmlspecialchars( basename( $_FILES["pdf_file"]["name"])). " has been uploaded.";
            } else {
                //echo " Sorry, there was an error uploading your file.";
            }
        }
}


//$ownerName = $_SESSION['UID'];
$ownerID = $_SESSION['user_id'];
$fileDBName ="";


$fileDBName1 = basename($_FILES["files"]["name"]);
$fileDBName2 = basename($_FILES["file"]["name"]);

if ($fileDBName1 == "") {
    
    $fileDBName = $fileDBName2;
} else {
    
    $fileDBName = $fileDBName1;
}

$filename = $_POST['fname'];
$dataAlive = $_POST['alive'];
$dataApprove = $_POST['approve'];
$dataUnlock = $_POST['unlock'];
$dataActive = $_POST['active'];
$dataStatus = $dataAlive.$dataApprove.$dataUnlock.$dataActive;
$dataType = $_POST['data_type_id'];
$dateCreated = date("h:ia  m/d/Y");
$dateUpdated = date("h:ia  m/d/Y");


if($filepdf == 1 || $fileImg == 1) {
    
    $insertData = "INSERT INTO f23_data_T (owner_id, dataName, dataLocation, dataStatus, dataType, dateCreated, dateUpdated) VALUES('$ownerID','$filename','$fileDBName','$dataStatus', '$dataType', '$dateCreated', '$dateUpdated')";
    mysqli_query($db_conn, $insertData);
    echo "<div class='w3-panel w3-margin w3-green'><p>Successfully Upload " . $fileDBName . "!</p></div>";
} else if ($filepdf == 0 && $fileImg == 0){
    echo "<div class='w3-panel w3-margin w3-red'><p>Error: " . $fileDBName . " is not an acceptable file type. Only files with the following extention are permitted:</p></div>";
    echo "<div class='w3-panel w3-margin w3-red'><p>PDF, Doc, PPT, XLS, TXT, PNG, JPG, or GIF</p></div>";
} else {
    echo "<div class='w3-panel w3-margin w3-red'><p>File could not be uploaded due to an error!</p></div>";
}

?>


<style>
.button {
  background-color: #008CBA;
  border: none;
  color: white;
  padding: 15px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 15px;
  margin: 4px 2px;
  cursor: pointer;
  border-radius: 8px;
}

</style>

<p></p>
<div class="w3-right">
	<a href="./dashboard.php?content=files" id='fileRedirect' class='button w3-blue w3-hover-shadow' style="margin-right: 5px;"><i class="fa fa-reply"></i><b> Return</b></a>
</div>