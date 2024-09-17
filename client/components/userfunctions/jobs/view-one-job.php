<?php
// Initialize the session
if (!isset($_SESSION)) {
    session_start();
}
include_once('../../../../backend/db_connector.php');

// this variable is to see if the user is an admin
$admin_form_disabled = "disabled";

if ($_SESSION['user_type'] == 1 || $_SESSION['user_type'] == 2|| $_SESSION['user_type'] == 5) {
    $admin_form_disabled = "";
}

// get job_id from $_GET from view-all-jobs.php
if (!empty($_GET["job_id"])) {
    $current_job_id = trim($_GET["job_id"]);
}


if (isset($_GET['job_status']) && isset($_GET['job_id'])) {
    $current_job_id = trim($_GET["job_id"]);
    $job_status = trim($_GET["job_status"]);
    
    $job_sql = "UPDATE f23_Job_T SET job_status = ? WHERE job_id = ? AND job_owner = ?";
    
    if ($stmt = mysqli_prepare($db_conn, $job_sql)) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "iii", $par1, $par2, $par3);
        
        $par1 = $job_status;
        $par2 = $current_job_id;
        $par3 = $_SESSION['user_id'];
        
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
    
    // update the tasks status based on the task details
    
    // if there is a task detail that was rejected (value of 2) than the task should have status rejected (value of 3)
    // if SUM = COUNT than task is approved
    // if SUM != Count than task is still in-progress
    $check_job_status = mysqli_query($db_conn, 'SELECT f23_Job_T.job_id, f23_JobDetails_T.task_id, f23_JobDetails_T.job_taskOrder, f23_Step_T.task_status FROM f23_Job_T INNER JOIN f23_JobDetails_T ON f23_Job_T.job_id = f23_JobDetails_T.job_id INNER JOIN f23_Step_T ON f23_JobDetails_T.task_id = f23_Step_T.task_id WHERE f23_Step_T.task_status = 2 AND f23_Job_T.job_id = ' . $current_job_id);
                                              //SELECT job_T.job_id, jobDetails_T.task_id, jobDetails_T.job_taskOrder, task_T.task_status FROM job_T INNER JOIN jobDetails_T ON job_T.job_id = jobDetails_T.job_id INNER JOIN task_T ON jobDetails_T.task_id = task_T.task_id WHERE task_T.task_status = 2 AND job_T.job_id = ' . $current_job_id);
    if ($check_job_status->num_rows < 1) {
        $status_id = 1;
    } /*else{
    $status_id = 2;
    }*/
    if ($job_status == 2) {
        $status_id =2;
    }
    
    if ($job_status == 3)
        $status_id = 3;
        
        $status_sql = "UPDATE f23_Job_T SET job_status = ? WHERE job_id = ?";
        
        if ($stmt = mysqli_prepare($db_conn, $status_sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ii", $par1, $par2);
            
            $par1 = $status_id;
            $par2 = $current_job_id;
            
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }
}

// view the one job
$job_results = mysqli_query($db_conn, 'SELECT * FROM f23_Job_T WHERE job_id = ' . $current_job_id);
$owner_assigned = mysqli_query($db_conn, 'SELECT user_name FROM f23_User_Table JOIN f23_Job_T ON f23_Job_T.job_owner = f23_User_Table.UID AND f23_Job_T.job_id =' . $current_job_id);

if(isset($_POST['submit'])){
    $owner_assigned = $_POST["assign-owner"];
    
    $stmnt = "UPDATE f23_Job_T SET job_owner = $owner_assigned WHERE job_id = $current_job_id;";
    $statement = mysqli_prepare($db_conn, $stmnt);
    mysqli_stmt_execute($statement);
    mysqli_stmt_close($statement);
}

?>
ß
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>View Job</title>
</head>
<style>
    body {
        font-family: "Raleway", sans-serif;
        font-size: small
    }
</style>

<body>

    <div class="w3-row">
        <br><br>
        <hr>
        <div class="w3-half">
            <?php include_once('./job-visualizer.php'); ?>
        </div>
        <?php while ($job = mysqli_fetch_object($job_results)) { ?>
            <div class="w3-half w3-container">
                <h4 class="w3-display-topmiddle">
                    <span class="">Status:<span>

                            <?php if ($job->job_status == 1) : ?>
                                <span style="text-transform: uppercase;"> Finished</span>
                            <?php elseif ($job->job_status == 2) : ?>
                                <span style="text-transform: uppercase;"> In-Progress</span>
                            <?php elseif ($job->job_status == 3) : ?>
                                <span style="text-transform: uppercase;"> Paused</span>
                            <?php elseif ($job->job_status == 4) : ?>
                                <span style="text-transform: uppercase;"> Archived</span>
                            <?php endif; ?>
                </h4>

                <h6 class="">Job Instructions:</h6>
                <p class="content">
                    <?php echo $job->job_instructions; ?>
                </p>

                <hr>
                <h4 class="w3-center">Job Actions:</h4>
                <div class="w3-padding-16 w3-center <?php if ($admin_form_disabled == "disabled") { echo "w3-hide";} ?>">
                    <a class="" href="./job-admin.php?job_id=<?php echo $current_job_id; ?>"><button class="w3-button w3-large w3-green w3-round" <?php echo $admin_form_disabled; ?>>Assign Steps</button></a>
                </div>
                
                <form action="./view-one-job.php" method="GET">
                    <!-- Radio Buttons -->

                    <h6>Change Job Status: </h6>
                    <div class="">
                        <div class="">

                            <input class="w3-radio" type="radio" name="job_status" value="1">
                            <label class="radio">Finished</label>
                            <br>
                            <input class="w3-radio" type="radio" name="job_status" value="2">
                            <label class="radio">Active</label>
                            <br>
                            <input class="w3-radio" type="radio" name="job_status" value="3">
                            <label class="radio">Pause</label>
                            <br>
                            <!-- 
                                <label class="radio">
                                    <input type="radio" name="job_status" value="3">
                                    Deleted
                                </label> -->

                        </div>
                    </div>

                    <input type="hidden" name="job_id" value="<?php echo $current_job_id; ?>">


                    <!-- Submit Button -->


                    <button type="submit" class="w3-button w3-blue w3-round w3-margin-top">Submit</button>

                    <?php if($_SESSION['user_type'] == 1){?>
                        
                        <div class="usersAssigned">
                            </br>
                            <h5 for="Job Owner">Job Owner:</h5>

                            <?php while ($owner = mysqli_fetch_object($owner_assigned)) { ?>
                                <label for="user_assigned">
                                    
                                    <ul>
                                        <li> <?php echo $owner->user_name;?> </li>
                                    </ul>

                                </label>
                            <?php } ?>

                            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                                <label for="assignUser">Assign Different Owner (ID)</label>
                                <input class="w3-input w3-border w3-round-small" name="assign-owner" id="assign-owner" placeholder="Please enter only 1 user id"></textarea>
                                <input type="hidden" name="job_id" value="<?php echo $current_job_id; ?>">
                                <button type="submit" name="submit" class="w3-button w3-blue w3-round w3-margin-top">Submit</button>
                            </form>

                        </div>

                    <?php } ?>

                </form>
                <hr>
            </div>
        <?php } ?>


    </div>
</body>

</html>

<script>

</script>