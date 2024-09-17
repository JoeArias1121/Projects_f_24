<?php
//Connect database.
include_once('../../backend/db_connector.php');
include_once('../../backend/util.php');
include_once('../../backend/config.php');
?>


<!-- Action Panel -->
<?php include_once('./userfunctions/jobs/view-all-jobs.php'); ?>

<?php if (($_SESSION['user_type'] == $GLOBALS['admin_type']) || ($_SESSION['user_type'] == $GLOBALS['super_type'])) {
?>
    <div class="w3-auto w3-row-padding w3-margin-bottom">
        <div class="w3-third" onclick="window.location.href='./dashboard.php?content=newjob'">
            <div class=" w3-container w3-card w3-hover-shadow w3-round-large w3-green w3-round-large w3-padding-16">
                <div class="w3-left"><i class="fa fa-bell w3-xxxlarge"></i></div>
                <div class="w3-clear">
                    <h5>New Job</h5>
                </div>
            </div>
        </div>
        <div class="w3-third" onclick="window.location.href='./dashboard.php?content=newtemplate'">
            <div class="w3-container w3-card w3-hover-shadow w3-round-large w3-round-large w3-orange w3-text-white w3-padding-16">
                <div class="w3-left"><i class="fa fa-bell w3-xxxlarge"></i></div>
                <div class="w3-clear">
                    <h5>Create Template</h5>
                </div>
            </div>
        </div>
        <div class="w3-third" onclick="window.location.href='./dashboard.php?content=tabletemplate'">
            <div class="w3-container w3-card w3-hover-shadow w3-round-large  w3-round-large w3-red w3-padding-16">
                <div class="w3-left"><i class="fa fa-share-alt w3-xxxlarge"></i></div>
                <div class="w3-clear">
                    <h5>View Templates</h5>
                </div>
            </div>
        </div>
    </div>
<?php
} else {
?>
    <div class="w3-row-padding w3-margin-bottom">
        <div class="w3-half" onclick="window.location.href='./dashboard.php?content=newjob'">
            <div class=" w3-container w3-card w3-hover-shadow w3-round-large w3-green w3-round-large w3-padding-16">
                <div class="w3-left"><i class="fa fa-bell w3-xxxlarge"></i></div>
                <div class="w3-clear">
                    <h5>New Job</h5>
                </div>
            </div>
        </div>
        <div class="w3-half" onclick="window.location.href='./dashboard.php?content=tabletemplate'">
            <div class=" w3-container w3-card w3-hover-shadow w3-round-large w3-round-large w3-orange w3-text-white w3-padding-16">
                <div class="w3-left"><i class="fa fa-share-alt w3-xxxlarge"></i></div>
                <div class="w3-clear">
                    <h5>View Templates</h5>
                </div>
            </div>
        </div>
    </div>
<?php
}
?>
<!-- Feed could go here when implemented to fill the content of the page -->