<?php 
//$user_ID = $_SESSION['user_id'];
include_once('../../backend/config.php');
include_once('../../backend/db_connector.php');


$dataType = mysqli_real_escape_string($db_conn, $_POST['type']);
$dataID = mysqli_real_escape_string($db_conn, $_POST['dataID']);
$dataName = mysqli_real_escape_string($db_conn, $_POST['dataName']);


if($dataType == "Any") {
    $dataType = "1";
} else if($dataType == "Self") {
    $dataType = "2";
} else if($dataType == "Other") {
    $dataType = "3";
} else if($dataType == "Form") {
    $dataType = "4";
} else if($dataType == "File") {
    $dataType = "5";
} else if($dataType == "Database") {
    $dataType = "6";
} else {
    $dataType = "7";
}

$dataAlive = mysqli_real_escape_string($db_conn, $_POST['alive']);
$dataApprove = mysqli_real_escape_string($db_conn, $_POST['approve']);
$dataUnlock = mysqli_real_escape_string($db_conn, $_POST['unlock']);
$dataActive = mysqli_real_escape_string($db_conn, $_POST['active']);
$dataStatus = $dataAlive.$dataApprove.$dataUnlock.$dataActive;
$dateUpdated = date("h:ia  m/d/Y");


$insertData = "UPDATE f23_data_T SET dataStatus = '$dataStatus', dataType = '$dataType', dateUpdated = '$dateUpdated' WHERE data_id = $dataID";
if ($db_conn->query($insertData) === TRUE) {
    echo("<div class='w3-panel w3-margin w3-green'><p>Successfully Updated " . $dataName . "!</p></div>");
}
else {
    echo("<div class='w3-panel w3-margin w3-red'><p>Error updating data: " . $db_conn->error . "</p></div>");
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