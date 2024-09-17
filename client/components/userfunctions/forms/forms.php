<?php
    //Connect database.
    include_once('../../backend/db_connector.php');
    include_once('../../backend/util.php');
    
    //The sql statement will need to be changed under the new database architecture.
    $user_email = $_SESSION['user_email'];
    $user_type = $_SESSION['user_type'];

    $sql = "SELECT * FROM f20_application_util WHERE assigned_to = '$user_type'";
    $qsql  = mysqli_query($db_conn, $sql);
    $r = mysqli_num_rows($qsql);

    /* Query to determine the number of active applications for this user.
    $user_email = $_SESSION['user_email'];
    $sql  = "SELECT * FROM f20_application_info WHERE student_email = '$user_email'";
    $qsql  = mysqli_query($db_conn, $sql);
    $r = mysqli_num_rows($qsql); */
?>

<!-- Content Title -->
<!-- <header class="w3-container">
    <h5><i class="fa fa-wrench"></i>  Forms Dashboard</h5>
</header>

<!-- Action Panel -->
<!--  <div class="w3-row-padding w3-margin-bottom">
    <div class="w3-quarter" onclick="window.location.href='./dashboard.php?content=forms&contentType=view'">
    <div class="w3-container w3-card w3-hover-shadow w3-round-large w3-orange w3-text-white w3-padding-16 ">
        <div class="w3-left"><i class="fa fa-eye w3-xxxlarge"></i></div>
        <div class="w3-clear"><h5>View Forms</h5></div>
    </div>
    </div>
    <div class="w3-quarter" onclick="window.location.href='./dashboard.php?content=forms&contentType=create'">
    <div class="w3-container w3-card w3-hover-shadow w3-round-large w3-red w3-padding-16 ">
        <div class="w3-left"><i class="fa fa-plus w3-xxxlarge"></i></div>
        <div class="w3-clear"><h5>Form Builder</h5></div>
    </div>
    </div>
    <div class="w3-quarter" onclick="window.location.href='./dashboard.php?content=forms&contentType=edit'">
    <div class="w3-container w3-card w3-hover-shadow w3-round-large w3-blue w3-padding-16 ">
        <div class="w3-left"><i class="fa fa-gear w3-xxxlarge"></i></div>
        <div class="w3-clear"><h5>Edit Form</h5></div>
    </div>
    </div>
    
    
    <div class="w3-quarter" onclick="window.location.href='./dashboard.php?content=forms&contentType=delete'">
    <div class="w3-container w3-card w3-hover-shadow w3-round-large w3-green w3-padding-16 ">
        <div class="w3-left"><i class="fa fa-minus w3-xxxlarge"></i></div>
        <div class="w3-clear"><h5>Delete Form</h5></div>
    </div>
    </div>
</div>
-->
<!-- Feed could go here when implemented to fill the content of the page -->