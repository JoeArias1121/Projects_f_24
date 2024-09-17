<?php
// Initialize the session
if (!isset($_SESSION)) {
    session_start();
}
include_once('../../backend/config.php');
include_once('../../backend/db_connector.php');

$current_job_status = 2;

if (isset($_GET['job_status'])) {
    $current_job_status = $_GET["job_status"];
}
$admin_form_disabled = "disabled";
if ($_SESSION['user_type'] == 1 || $_SESSION['user_type'] == 2|| $_SESSION['user_type'] == 5) {
    $admin_form_disabled = "";
}
if ($_SESSION['user_type'] == 1 || $_SESSION['user_type'] == 2|| $_SESSION['user_type'] == 5) {
    $results = mysqli_query($db_conn, 'SELECT * FROM f23_Job_T WHERE job_status =' .$current_job_status);
} else {
    // view all jobs where the SESSION user is job_owner
    $results = mysqli_query($db_conn, 'SELECT DISTINCT j.job_id,j.job_status,j.job_owner,j.job_title,j.job_instructions,j.job_deadline,j.job_created 
FROM f23_Job_T AS j INNER JOIN f23_JobDetails_T AS jd ON j.job_id = jd.job_id INNER JOIN f23_StepDetails_T as td ON td.task_id = jd.task_id WHERE td.user_id = ' . 
        $_SESSION['user_id'] . ' AND j.job_status = '.$current_job_status);

}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/jobs.css">
    <link href='http://fonts.googleapis.com/css?family=Raleway:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <title>Job Table</title>
</head>
<body>
    <div class="w3-container w3-bar w3-round-large w3-margin-right">
        <a href="./dashboard.php?content=jobgraph&job_status=<?php echo 2; ?>"><button class="w3-bar-item w3-button tablink w3-blue w3-round" style="width:50% "><strong>Active</strong></button></a>
        <a href="./dashboard.php?content=jobgraph&job_status=<?php echo 1; ?>"><button class="w3-bar-item w3-button tablink w3-green w3-round" style="width:44%"><strong>Finished</strong></button></a>
        <button class="w3-button w3-round-xlarge w3-bar-item" onclick="document.getElementById('key').style.display='block'"><i style="font-size:18pt" class="fa fa-question-circle" aria-hidden="true"></i></button>
    </div>
    <div id="key" class="w3-modal">
                        <div class="w3-modal-content w3-round-large w3-card-4" style="width:500px; margin-top:-30px; margin-left:910px">
                            <header class="w3-round w3-container w3-light-grey">
                                <h6 class="w3-left">Status Key</h6>
                                <span onclick="document.getElementById('key').style.display='none'" class="w3-button w3-display-topright w3-round-large">&times;</span>
                            </header>
                            <h6 class="w3-dark-grey w3-round-large w3-padding w3-center">Not Started</h6>
                            <h6 class="w3-blue w3-round-large w3-padding w3-center">In-Progress</h6>
                            <h6 class="w3-green w3-round-large w3-padding w3-center">Approved</h6>
                            <h6 class="w3-deep-purple w3-round-large w3-padding w3-center">Rejected</h6>
                        </div>
                    </div>

    <div id="done" class="status">
        <!-- While Loop to Generate Rows of Tasks -->
        <?php if (mysqli_num_rows($results) > 0) {
        ?>
            <?php 
            $rowNum = 1;
            while ($job = mysqli_fetch_object($results)) {

                $query = mysqli_query($db_conn, 'SELECT f23_JobDetails_T.job_id, f23_JobDetails_T.task_id, f23_JobDetails_T.job_taskOrder, 
f23_Step_T.task_status, f23_Step_T.task_title, f23_User_Table.UID,f23_User_Table.user_name,f23_StepDetails_T.taskPart_status FROM f23_JobDetails_T 
INNER JOIN f23_Step_T ON f23_JobDetails_T.task_id = f23_Step_T.task_id INNER JOIN f23_StepDetails_T ON f23_StepDetails_T.task_id = f23_Step_T.task_id 
INNER JOIN f23_User_Table ON f23_StepDetails_T.user_id = f23_User_Table.UID WHERE f23_JobDetails_T.job_id =' .$job->job_id. ' ORDER BY f23_JobDetails_T.job_taskOrder');
                $count = mysqli_query($db_conn, 'SELECT COUNT(DISTINCT task_id) FROM f23_JobDetails_T WHERE job_id ='.$job->job_id);
                $tasks= mysqli_fetch_array($count);
                 GLOBAL $taskNum;
                 $taskNum = 1;
            ?>
                <div class="w3-row w3-margin w3-card w3-round-large w3-padding w3-margin-right <?php if ($job->job_status == 4) {
                                                                        echo "w3-hide";
                                                                    } ?>">
                    <div class="w3-quarter" style="height: 120px; padding-left: 10px; padding-top:18px">
                        <span>Title:
                            <strong><?php echo $job->job_title; ?> <span class="<?php if ($job->job_status == 3) echo "w3-hide";?>"> (ID: <?php echo $job->job_id; ?>)</span></strong><br></span>
                        <span>Status:
                            <strong><?php if ($job->job_status == 1) : ?>
                                    <span class="">Done</span>
                                <?php elseif ($job->job_status == 2) : ?>
                                    <span>In Progress</span>
                                <?php elseif ($job->job_status == 3) : ?>
                                    <span class="">New</span>
                                <?php endif; ?></strong><br>
                        </span>
                        <span>Deadline:
                            <strong><?php echo $job->job_deadline; ?></strong><br></ <td>
                    </div>

                    <div class="w3-half w3-padding w3-border-right w3-border-left" style="height: 120px;">
                        <?php
                        $tasks = array();
                        while ($result = mysqli_fetch_assoc($query)) {
                            $tasks[$taskNum]= $result;
                            $job_id = $job->job_id;
                           
                            
                            if ($tasks[$taskNum]['job_id']== $job_id ){
                                if ($result['task_status'] == 2) {
                                    $atr = 'w3-blue';
                                    $status = 'In-Progress';
                                } elseif ($result['task_status'] == 1) {
                                    $atr = 'w3-green';
                                    $status = 'Complete';
                                } elseif ($result['task_status'] == 3) {
                                    $atr = 'w3-deep-purple';
                                    $status = 'Rejected';
                                } elseif ($result['task_status'] == 5) {
                                    $atr = 'w3-dark-gray';
                                    $status = 'Not Started';
                                }
                                if($taskNum == 1) {
                        ?>
                        
                                <div class="circleList" id="circleList rowNum<?php echo $rowNum; ?>">
                                <div class='circle w3-card <?php echo ($atr); ?>' id='participant'><span class="embossed"><?php echo $tasks[$taskNum]['job_taskOrder']; ?></span></div>
                                </div>
                                <div class="labelList w3-small w3-center" id="labelList rowNum<?php echo $rowNum; ?>" style=" margin-top: 10px">
                                <div id='labelContainer' class='userType'><strong><?php echo ($tasks[$taskNum]['user_name']); ?></strong></div>
                                </div>
                                <?php }else{ ?>
                                <script>
                                    document.getElementById('circleList rowNum<?php echo $rowNum; ?>').innerHTML += "<div class='line'></div><div class='circle w3-card <?php echo ($atr); ?>' id='participant'><span class='embossed'><?php echo $tasks[$taskNum]['job_taskOrder']; ?></span></div>";
                                    document.getElementById('labelList rowNum<?php echo $rowNum; ?>').innerHTML += "<div class='spacer'></div><div id='labelContainer' class='userType'><strong><?php echo ($tasks[$taskNum]['user_name']); ?></strong></div>";
                                </script>
                        <?php   }
                            }
                          $taskNum++;
                        }
                        
                        ?>


                    </div>
                    <div class="w3-quarter w3-center" style="height: 120px; padding-left:10px;padding-top:38px">
                        <a class=""><button onclick="document.getElementById('id<?php echo $job->job_id; ?>').style.display='block'" class="w3-button w3-round w3-green">See Details</button></a>
                    </div>

                    <div id="id<?php echo $job->job_id; ?>" class="w3-modal">
                        <div class="w3-modal-content w3-center w3-round-large w3-card-4" style="width:700px; margin-top:-100px;">
                            <header class="w3-round w3-container w3-blue">
                                <h6 class="w3-left"><?php echo $job->job_title; ?></h6>
                                <span onclick="document.getElementById('id<?php echo $job->job_id; ?>').style.display='none'" class="w3-button w3-display-topright w3-round">&times;</span>
                            </header>
                            <iframe height="700" width="700" style="border:none;" src="./userfunctions/jobs/view-one-job.php?job_id=<?php echo $job->job_id; ?>"></iframe>

                        </div>
                    </div>
                </div>
                        
            <?php ++$rowNum;} ?>
        <?php } else {
            echo ('<div class="w3-row w3-card-4 w3-margin w3-padding">'
                . '<p>No Jobs Found!</p></div>');
        } ?>
    </div>
</body>
</html>