<!-- Content Title -->
<header class="w3-container">
    <?php 
    
        if($_SESSION['user_type'] == $GLOBALS['admin_type']) {
           
        }
        
        else{
            echo("<div class='w3-card w3-red w3-margin w3-padding'>You do not have access to this feature</div>");
            exit();
        }
    ?>
</header>

<!-- Action Panel -->
<!--  
<div class="w3-row-padding w3-margin-bottom">

    <!-- Department Creation only available to Admin -->
   <!--   <?php //if($_SESSION['user_type'] == $GLOBALS['admin_type']) { ?>
        <div class="w3-quarter" onclick="window.location.href='./dashboard.php?content=adminTools&contentType=company'">
    <div class="w3-container w3-card w3-hover-shadow w3-round-large w3-blue w3-padding-16 w3-text-white">
        <div class="w3-left"><i class="fa fa-building w3-xxxlarge"></i></div>
        <div class="w3-clear"><h5>Create Company</h5></div>
    </div>
    </div>
    <div class="w3-quarter" onclick="window.location.href='./dashboard.php?content=adminTools&contentType=industry'">
    <div class="w3-container w3-card w3-hover-shadow w3-round-large w3-green w3-padding-16 w3-text-white">
        <div class="w3-left"><i class="fa fa-building w3-xxxlarge"></i></div>
        <div class="w3-clear"><h5>Create Industry</h5></div>
    </div>
    </div>
    <?php //} ?>
    
    <div class="w3-quarter" onclick="window.location.href='./dashboard.php?content=users&contentType=create'">
    <div class="w3-container w3-card w3-hover-shadow w3-round-large w3-orange w3-padding-16 w3-text-white">
        <div class="w3-left"><i class="fa fa-users w3-xxxlarge"></i></div>
        <div class="w3-clear"><h5>Create New User</h5></div>
    </div>
    </div>
</div>
-->