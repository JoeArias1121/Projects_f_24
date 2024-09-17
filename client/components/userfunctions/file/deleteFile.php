<?php 

if(!isset($_SESSION)) {
    session_start();
}
//User has not signed in.
if(!isset($_SESSION['user_type'])) {
    echo "<div class='w3-panel w3-margin w3-red'><p>Session Expired, Please sign in again.</p></div>";
    exit();
}
include_once('../../backend/util.php');
include_once('../../backend/config.php');
include_once('../../backend/db_connector.php');

$dataID = mysqli_real_escape_string($db_conn, $_POST['dataID']);
$dataLocation = mysqli_real_escape_string($db_conn, $_POST['dataLocation']);
$ownerID = mysqli_real_escape_string($db_conn, $_POST['ownerID']);

$dataDirectory = "/var/www/p/f23-04/html/files/" . $ownerID ."_files/". $dataLocation;

$dataDelete = "DELETE FROM f23_data_T WHERE data_id = '$dataID'";


if (!unlink($dataDirectory)) {
    echo ("<div class='w3-panel w3-margin w3-green'><p>". $dataLocation . " cannot be deleted due to an error!</p></div>");
} else {
    echo ("<div class='w3-panel w3-margin w3-green'><p>". $dataLocation . "has been deleted!</p></div>");
} 

if ($db_conn->query($dataDelete) === TRUE) {
   // echo("<div class='w3-panel w3-margin w3-green'><p>Successfully Updated " . $dataLocation . "!</p></div>");
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