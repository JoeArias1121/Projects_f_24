<!-- Content Title -->
<header class="w3-container">
    <?php 
        if($_SESSION['user_type'] == $GLOBALS['admin_type']) {
           // echo("<h5> <i class='fa fa-plus'></i>  Admin User Tools </h5>");
        }
        else{
            echo("<div class='w3-card w3-red w3-margin w3-padding'>You do not have access to this feature</div>");
            exit();
        }
    ?>
</header>

<!-- Action Panel -->
<!-- <div class="w3-row-padding w3-margin-bottom">


    <div class="w3-quarter" onclick="window.location.href='./dashboard.php?content=search&contentType=user'">
    <div class="w3-container w3-card w3-hover-shadow w3-round-large w3-blue w3-padding-16 ">
        <div class="w3-left"><i class="fa fa-search w3-xxxlarge"></i></div>
        <div class="w3-clear"><h5>Search Users</h5></div>
    </div>
    </div>


    <!-- User Creation only available to Admin -->
    <?php //if($_SESSION['user_type'] == $GLOBALS['admin_type']) { ?>
    <!--  <div class="w3-quarter" onclick="window.location.href='./dashboard.php?content=users&contentType=create'">
    <div class="w3-container w3-card w3-hover-shadow w3-round-large w3-green w3-padding-16  ">
        <div class="w3-left"><i class="fa fa-plus w3-xxxlarge"></i></div>
        <div class="w3-clear"><h5>Create New User</h5></div>
    </div>
    </div>
    <?php //} ?>

</div>-->