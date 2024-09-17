<?php 
// Initialize the session
if (!isset($_SESSION)) {
    session_start();
}
include_once('../../backend/db_connector.php');

// Change task status by changing its status
if (isset($_GET['change_status']) && isset($_GET['job_id'])) {
    $update_job = $_GET['job_id'];
    $status_status_id = $_GET['change_status'];
    
    $update_job_sql = 'UPDATE f23_Job_T SET job_status = ? WHERE job_id = ?';
    
    if ($stmt = mysqli_prepare($db_conn, $update_job_sql)) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "ii", $par1, $par2);
        
        $par1 = $status_status_id;
        $par2 = $update_job;
        
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
}

if ($_SESSION['user_type'] == 1) {
    $archived = mysqli_query($db_conn, 'SELECT * FROM f23_Job_T WHERE job_status = 4');
} else {
    // view all jobs where the SESSION user is job_owner
    $archived = mysqli_query($db_conn, 'SELECT DISTINCT j.job_id,j.job_status,j.job_owner,j.job_title,
j.job_instructions,j.job_deadline,j.job_created FROM f23_Job_T AS j LEFT JOIN f23_JobDetails_T AS jd ON 
j.job_id = jd.job_id LEFT JOIN f23_StepDetails_T as td ON td.task_id = jd.task_id WHERE j.job_status = 4 
AND (td.user_id = '.$_SESSION['user_id'].' OR j.job_owner = '.$_SESSION['user_id'].')');
}

?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>View All Jobs</title>
    <style>
        a.disabled {
            pointer-events: none;
        }
    </style>
</head>


<body>

   <div class="w3-auto w3-row-padding">
      
      <div class="w3-stretch">
            <?php while ($job = mysqli_fetch_object($archived)) { ?>


                <div class="w3-card w3-round-large w3-margin-bottom w3-hover-shadow">
                    <header class="w3-round w3-container w3-purple">
                        <h6>
                            <span class="is-uppercase">Job: <?php echo $job->job_title; ?></span>
                        </h6>
                    </header>
                    <div class="w3-container w3-padding">
                        <p><?php echo $job->job_instructions; ?></p>
                        <b>Deadline: <time><?php echo $job->job_deadline; ?></time></b>
                    </div>
                    <footer class="">
                        <div class="w3-bar">
                            <button class="w3-button w3-round w3-bar-item w3-padding <?php if ($job->job_status == 4) {
                                                                                            echo "w3-hide";
                                                                                        } ?>" href="./dashboard.php?content=onejob?job_id=<?php echo $job->job_id; ?>" onclick="document.getElementById('id<?php echo $job->job_id; ?>').style.display='block'">
                                See Details
                            </button>
                            <a href="./dashboard.php?content=jobs&job_id=<?php echo $job->job_id; ?>&change_status=2"><button class="w3-button w3-round ">Restore</button></a>
                        </div>
                    </footer>
                    <div id="id<?php echo $job->job_id; ?>" class="w3-modal">
                        <div class="w3-modal-content w3-round-large w3-card-4" style="width:700px; margin-top:-100px;">
                            <header class="w3-round w3-container w3-blue">
                                <h6 class="w3-left"><?php echo $job->job_title; ?></h6>
                                <span onclick="document.getElementById('id<?php echo $job->job_id; ?>').style.display='none'" class="w3-button w3-display-topright">&times;</span>
                            </header>
                            <iframe height="700" width="100%" style="border:none;" src="./userfunctions/jobs/view-one-job.php?job_id=<?php echo $job->job_id; ?>"></iframe>
                        </div>
                    </div>

                </div>
            <?php } ?>
        </div>
      
   </div>

</body>

