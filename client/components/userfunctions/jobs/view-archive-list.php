<?php
// Initialize the session
if (!isset($_SESSION)) {
    session_start();
}
include_once('../../backend/db_connector.php');


$admin_form_disabled = "disabled";

if ($_SESSION['user_type'] == 1 || $_SESSION['user_type'] == 2|| $_SESSION['user_type'] == 5) {
    $admin_form_disabled = "";
}


if (isset($_GET['change_status']) && isset($_GET['job_id'])) {
    $update_job = $_GET['job_id'];
    $update_status_id = $_GET['change_status'];

    $update_task_sql = 'UPDATE f23_Job_T SET job_status = ? WHERE job_id = ?';

    if ($stmt = mysqli_prepare($db_conn, $update_task_sql)) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "ii", $par1, $par2);

        $par1 = $update_status_id;
        $par2 = $update_job;

        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
}

// view all jobs as an admin
if ($_SESSION['user_type'] == 1 || $_SESSION['user_type'] == 2) {
    $archived = mysqli_query($db_conn, 'SELECT * FROM f23_Job_T WHERE job_status = 4');
} else {
    // view all jobs where the SESSION user is job_owner
    $archived = mysqli_query($db_conn, 'SELECT DISTINCT j.job_id,j.job_status,j.job_owner,
j.job_title,j.job_instructions,j.job_deadline,j.job_created FROM f23_Job_T AS j LEFT JOIN 
f23_JobDetails_T AS jd ON j.job_id = jd.job_id LEFT JOIN f23_StepDetails_T as td ON td.task_id = 
jd.task_id WHERE j.job_status = 4 AND (td.user_id = '.$_SESSION['user_id'].' OR j.job_owner = '.$_SESSION['user_id'].')');
}

?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Job Table</title>
</head>

<body>

   <div class="w3-container w3-white w3-round w3-border w3-margin-bottom w3-margin-right" style="font-size:small">
   <header class="w3-round w3-container w3-purple w3-text-white" style="margin-left:-17px; margin-right:-17px">
           <h6>Archived</h6>
        </header>
        <table class="w3-table w3-bordered w3-hoverable">
            <thead>
                <tr>
                <!--  <th>ID</th> -->
                <th>Title</th>
                <th>Instructions</th>
                <th>Created</th>
                <th>Deadline</th>
                <!--  <th>Update</th> -->
                <!--  <th class="<?php /*if ($admin_form_disabled == "disabled") {
                                        echo "w3-hide";
                                    }*/ ?>">Add Steps</th> -->
                <th>Restore</th>
                </tr>
            </thead>
            <tbody>
                <!-- While Loop to Generate Rows of Tasks -->
                <?php while ($job = mysqli_fetch_object($archived)) { ?>
                    <tr>
                        <!-- Keep the same -->
                        <!--  <td><?php //echo $job->job_id; ?></td> -->
                        <!-- Get title -->
                        <td><?php echo $job->job_title; ?></td>
                        <!-- Keep the same -->
                        <td><?php echo $job->job_instructions; ?></td>
                        <!-- Keep the same -->
                        <td><?php echo $job->job_deadline; ?></td>
                        <!-- Keep the same -->
                        <td><?php echo $job->job_created; ?></td>
                        <!-- Keep the same -->
                       <!--   <td>
                            <a class="<?php //if ($job->job_status == 1 || $job->job_status == 3) {
                                            // echo "w3-hide";
                                       // } ?>"><button onclick="document.getElementById('id<?php //echo $job->job_id; ?>').style.display='block'" class="w3-btn w3-round w3-green">Details</button></a>
                        </td>-->
                        <!--  <td class="<?php /*if ($admin_form_disabled == "disabled") {
                                        echo "w3-hide";
                                    }*/ ?>">
                            <a><button onclick="document.getElementById('ad<?php //echo $job->job_id; ?>').style.display='block'" class="w3-btn w3-round w3-blue">Add Steps</button></a>
                        </td>-->
                        <td>
                            <a class="<?php /*if ($job->job_status == 3) {
                                            echo "w3-hide";
                                        }*/ ?>" href="./dashboard.php?content=jobslist&job_id=<?php echo $job->job_id; ?>&change_status=2"><button class="w3-btn w3-round w3-blue">Restore</button></a>
                        </td>
                    </tr>
                    <div id="id<?php echo $job->job_id; ?>" class="w3-modal">
                        <div class="w3-modal-content w3-center w3-round-large w3-card-4" style="width:700px; margin-top:-100px;">
                            <header class="w3-round w3-container w3-blue">
                                <h6 class="w3-left"><?php echo $job->job_title; ?></h6>
                                <span onclick="document.getElementById('id<?php echo $job->job_id; ?>').style.display='none'" class="w3-button w3-display-topright w3-round">&times;</span>
                            </header>
                            <iframe height="700" width="700" style="border:none;" src="./userfunctions/jobs/view-one-job.php?job_id=<?php echo $job->job_id; ?>"></iframe>

                        </div>
                    </div>
                    <div id="ad<?php echo $job->job_id; ?>" class="w3-modal">
                        <div class="w3-modal-content w3-center w3-round-large w3-card-4" style="width:700px; margin-top:-100px;">
                            <header class="w3-round w3-container w3-blue">
                                <h6 class="w3-left"><?php echo $job->job_title; ?></h6>
                                <span onclick="document.getElementById('ad<?php echo $job->job_id; ?>').style.display='none'" class="w3-button w3-display-topright w3-round">&times;</span>
                            </header>
                            <iframe height="680" width="700" style="border:none;" src="./userfunctions/jobs/job-admin.php?job_id=<?php echo $job->job_id; ?>"></iframe>
                        </div>
                    </div>
    </div>
<?php } ?>
</tbody>
</table>
</div>

</body>




