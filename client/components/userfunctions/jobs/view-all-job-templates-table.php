<?php
// Initialize the session
if (!isset($_SESSION)) {
    session_start();
}

include_once('../../backend/db_connector.php');



// this variable is to see if the user is an admin or manager
$admin_form_disabled = "disabled";

if ($_SESSION['user_type'] == 1 || $_SESSION['user_type'] == 2 || $_SESSION['user_type'] == 5) {
    $admin_form_disabled = "";
}

// toggle templateStatus_id of jobTemplate_T
if (isset($_GET['templateStatus_id']) && isset($_GET['jobTemplate_id'])) {
    $current_jobTemplate_id = trim($_GET["jobTemplate_id"]);
    $templateStatus_id = trim($_GET["templateStatus_id"]);

    $jobTemplate_sql = "UPDATE f23_JobTemplate_T SET templateStatus_id = ? WHERE jobTemplate_id = ?";

    if ($stmt = mysqli_prepare($db_conn, $jobTemplate_sql)) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "ii", $par1, $par2);

        $par1 = $templateStatus_id;
        $par2 = $current_jobTemplate_id;

        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
}

$industry_query = mysqli_query($db_conn, 'SELECT i.ind_code FROM f23_Industry_T AS i JOIN f23_Company_T AS c ON c.ind_code = i.ind_code JOIN f23_User_Table AS u ON c.comp_id = u.company_id WHERE u.UID ='.$_SESSION['user_id']);
$industryResults = mysqli_fetch_assoc($industry_query);
// view all job templates as admin
if ($_SESSION['user_type'] == 1) 
    $job_template_results = mysqli_query($db_conn, 'SELECT * FROM f23_JobTemplate_T');
else
$job_template_results = mysqli_query($db_conn, 'SELECT * FROM f23_JobTemplate_T WHERE f23_JobTemplate_T.ind_code ="'.$industryResults['ind_code'].'" OR f23_JobTemplate_T.ind_code="0"');


?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Job Template Table</title>
</head>

<body>
    
    <div class="w3-card w3-round-large w3-text-white w3-purple" style="margin-right:17px">
        <h1 class="w3-margin-left">
            Job Templates
        </h1>
    </div>
    <div class="w3-card w3-white w3-round-large" style="margin-right:17px">
        <div class="">

            <!-- table is created on the condition that the user is an admin 1 or manager 2 -->
            <?php if ($_SESSION['user_type'] == 1 || $_SESSION['user_type'] == 2 || $_SESSION['user_type'] == 5) { ?>
                <table class="w3-table w3-striped w3-bordered">
                    <thead>
                        <tr>
                        <?php if ($_SESSION['user_type'] == 1) {?>
                            <th class="w3-center">ID</th>
                            <?php }?>
                            <th class="w3-center">Industry</th>
                            <th class="w3-center">Status</th>
                            <th class="w3-center">Title</th>
                            <th class="w3-center">Instructions</th>
                            <?php if ($_SESSION['user_type'] == 1) {?>
                            <th class="w3-center">Edit</th>
                            <th style="width:150px" class="w3-center">Step Templates</th>
                            <th class="w3-center">Update</th>
                            <th class="w3-center">Delete</th>
                            <?php }?>
                        </tr>
                    </thead>
                    <tbody>
                    <?php } else {
                } ?>

                    <!-- if table was created above, the table is then populated -->
                    <?php if ($_SESSION['user_type'] == 1 || $_SESSION['user_type'] == 2 || $_SESSION['user_type'] == 5) {
                        while ($template = mysqli_fetch_object($job_template_results)) {
                    ?>
                        <?php if ($template->templateStatus_id != 3){?>
                            <tr>
                                <!-- id -->
                                <?php if ($_SESSION['user_type'] == 1) {?>
                                <td><?php echo $template->jobTemplate_id; ?></td>
                                <?php }?>
                                <td><?php if ($template->ind_code == '0') echo 'None'; else echo $template->ind_code; ?></td>
                                <!-- title -->
                                <td>
                                    <?php if ($template->templateStatus_id == 1) : ?>
                                        <span class="w3-text-green"><b>Ready</b></span>
                                    <?php elseif ($template->templateStatus_id == 2) : ?>
                                        <span class="w3-text-orange"><b>Not Ready</b></span>
                                    <?php else : ?>
                                        <span">Deleted</span>
                                    <?php endif; ?>
                                </td>
                                <td class="w3-center" style="width:150px"><?php echo $template->job_title; ?></td>
                                <!-- instructions -->
                                <td><?php echo $template->job_instructions; ?></td>
                                <!-- change status to ready, not ready, or deleted -->
                                <?php if ($_SESSION['user_type'] == 1) {?>
                                <td>
                                    <button class="w3-button w3-green w3-round" onclick="document.getElementById('id<?php echo $template->jobTemplate_id; ?>').style.display='block'">Details</button>
                                    <div id="id<?php echo $template->jobTemplate_id; ?>" class="w3-modal">
                                        <div class="w3-modal-content w3-center w3-round-large w3-card-4" style="width:600px; margin-top:-75px;">
                                            <header class="w3-round w3-container w3-purple">
                                                <h6 class="w3-left">Title: <?php echo $template->job_title; ?></h6>
                                                <span onclick="document.getElementById('id<?php echo $template->jobTemplate_id; ?>').style.display='none'" class="w3-button w3-display-topright w3-round-large">&times;</span>
                                            </header>
                                            <iframe height="630" width="600" style="border:none;" src="./userfunctions/jobs/view-one-job-template.php?jobTemplate_id=<?php echo $template->jobTemplate_id; ?>"></iframe>
                                        </div>

                                    </div>
                                </td>
                                <td class="w3-center">
                                    <button class="w3-button w3-blue w3-round<?php if ($admin_form_disabled == "disabled") {
                                                                                    echo "w3-hide";
                                                                                } ?>" onclick="document.getElementById('ad<?php echo $template->jobTemplate_id; ?>').style.display='block'">Attach</button>
                                    <div id="ad<?php echo $template->jobTemplate_id; ?>" class="w3-modal">
                                        <div class="w3-modal-content w3-center w3-round-large w3-card-4" style="width:600px; margin-top:-75px;">
                                            <header class="w3-round w3-container w3-purple">
                                                <h6 class="w3-left">Title: <?php echo $template->job_title; ?></h6>
                                                <span onclick="document.getElementById('ad<?php echo $template->jobTemplate_id; ?>').style.display='none'" class="w3-button w3-display-topright w3-round-large">&times;</span>
                                            </header>
                                            <iframe height="630" width="600" style="border:none;" src="./userfunctions/jobs/job-template-admin.php?jobTemplate_id=<?php echo $template->jobTemplate_id; ?>"></iframe>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="w3-row">
                                        <div class="">
                                        <a href="./dashboard.php?content=jobtemplate&jobTemplate_id=<?php echo $template->jobTemplate_id; ?>&templateStatus_id=1"><button style="width:90px; height:40px;" class="w3-small w3-button w3-green w3-round">Ready</button></a>
                                        </div>
                                        <div class="">
                                        <a href="./dashboard.php?content=jobtemplate&jobTemplate_id=<?php echo $template->jobTemplate_id; ?>&templateStatus_id=2"><button style="width:90px;height:40px;" class="w3-small w3-button w3-orange w3-text-white w3-round">Not Ready</button></a>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <a href="./dashboard.php?content=jobtemplate&jobTemplate_id=<?php echo $template->jobTemplate_id; ?>&templateStatus_id=3"><button class="w3-button w3-red w3-round">Delete</button></a>
                                </td>
                                <?php }?>
                            </tr>
                            <?php }?> 
                    <?php }
                    } else {
                        //if the user is not an admin or manager, the while loop does not run and this message is displayed
                        $user = $_SESSION['user_type'];
                        echo "User with ID #" . $user . ": You do not have permission to view this page. Please contact an Admin or Manager.";
                    }
                    ?>
                    </tbody>

                </table>
        </div>

    </div>
</body>

</html>