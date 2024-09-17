<?php
if (!isset($_SESSION)) {
    session_start();
}

include_once('../../../../backend/db_connector.php');

$confirm_user_msg = "";
$task_button = "";


// get the job templates for the form
$industry_query = mysqli_query($db_conn, 'SELECT i.ind_code FROM f23_Industry_T AS i JOIN f23_Company_T AS c ON c.ind_code = i.ind_code JOIN f23_User_Table AS u ON c.comp_id = u.company_id WHERE u.UID ='.$_SESSION['user_id']);
$industryResults = mysqli_fetch_assoc($industry_query);
if ($_SESSION['user_type'] == 1) 
$jobTemplate_results = mysqli_query($db_conn, 'SELECT * FROM f23_JobTemplate_T WHERE templateStatus_id = 1');
else
$jobTemplate_results = mysqli_query($db_conn, 'SELECT * FROM f23_JobTemplate_T WHERE (f23_JobTemplate_T.ind_code ="'.$industryResults['ind_code'].'" OR f23_JobTemplate_T.ind_code="0") AND templateStatus_id = 1');

//get params from form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $jobTemplate_id = trim($_POST["template-id"]);
    $user_title = trim($_POST["job-title"]);
    $user_info = trim($_POST["job-info"]);
    $job_deadline = trim($_POST["job-deadline"]);
    $job_created = date("Y-m-d H:i:s");

    //commented out for testing, causing error of unassigned value
    //$owner_assigned = $_POST["assign-user"];




    //get the row from jobTemplate_T that needs to be copied into job_T
    $jobTemplate_row = mysqli_query($db_conn, "SELECT * FROM f23_JobTemplate_T WHERE jobTemplate_id = '$jobTemplate_id' ");
    if ($jobTemplate_row->num_rows > 0) {
        while ($row = $jobTemplate_row->fetch_assoc()) {
            if (empty($user_title)) {
                $job_title = $row['job_title'];
            } else {
                $job_title = $user_title;
            }
            if (empty($user_title))
            $job_instructions = $row['job_instructions'];
            else
            $job_instructions = $user_info;
            $templateStatus_id = $row['templateStatus_id'];
        }
    }

    // insert a new row into job_T
    $job_instance_sql = "INSERT INTO f23_Job_T(job_status, job_owner, job_title, job_instructions, job_deadline, job_created, job_id) VALUES (?,?,?,?,?,?,?)";
    
    

    if ($stmt = mysqli_prepare($db_conn, $job_instance_sql)) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "isssssi", $param1, $param3, $param5, $param6, $param8, $param9, $param10);
        // Set parameters
        $param1 = 2; //in progress, 1 finished
        $param3 = $_SESSION["user_id"];
        // will come from unit A. Currently in the SESSION variable
        $param5 = $job_title;
        $param6 = $job_instructions;
        $param8 = $job_deadline;
        $param9 = $job_created;
        

        //find highest job id, increment by 1, assign to new job
        $findID = "SELECT MAX(job_id) AS job_id FROM f23_Job_T";
        $IDresult = mysqli_query($db_conn, $findID);
        $IDresult = mysqli_fetch_assoc($IDresult);
        $jobID = $IDresult['job_id'];
        $jobID = $jobID + 1;
        $param10 = $jobID;

        if (mysqli_stmt_execute($stmt)) {

            mysqli_stmt_store_result($stmt);
            $last_id = mysqli_insert_id($db_conn);
            
            // Assign owner different than the one creating
           
            

            $confirm_user_msg = '<div class="w3-padding-top-16 w3-center">Job Created.</div>';
            $task_button = 
            '<div class="w3-padding-top-16 w3-center">
                <a href="./create-task.php?job_id='.$last_id.'"><button class="w3-button w3-green w3-round">Add Task</button></a>
            </div>';
            
        } else {
            $confirm_user_msg = "Oops! Something went wrong.". mysqli_stmt_error($stmt);
        }
    }
    // header("Location: ./create-task.php");
}


?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Create a Job</title>
</head>
<style>
    body {
        font-family: "Raleway", sans-serif
    }
</style>

<body>

<h6 class="w3-margin-bottom">
    <?php 
    echo $confirm_user_msg; 
    echo $task_button
    ?>
</h6>


<?php 
if($confirm_user_msg == "") {?>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">

<!--Select Option-->

<label for="template-id">
    Select A Job Template
</label>

<br>

<div>
    <select name="template-id" id="template-id" class="w3-select w3-border w3-round-large">
        <?php while ($template = mysqli_fetch_object($jobTemplate_results)) { ?>
            <option value="<?php echo $template->jobTemplate_id; ?>"><?php echo $template->job_title; ?></option>
        <?php } ?>
    </select>
</div>
</div>
<br>
<label for="job-title">Title:</label>
<br>
<div>
    <div>
        <input class="w3-input w3-border w3-round-large" type="text" name="job-title" id="job-title" placeholder="Title">
    </div>
</div>
<br>
<label for="job-info">Instructions:</label>
<br>
<div>
    <div>
        <textarea class="w3-input w3-border w3-round-large" name="job-info" id="job-info" placeholder="Instructions"></textarea>
    </div>
</div>
<br>




            

<label for="job-deadline">Deadline for Job</label>
<br>
<div>
    <div class="">
        <input class="w3-input w3-border w3-round-large" type="datetime-local" name="job-deadline" id="job-deadline">
    </div>
</div>

<div class="assignOwner">
    <?php 
        if($_SESSION['user_type'] == 1){
            echo("
                <br/>
                <label for=\"assignUser\">Assign Owner (ID)</label>
                <input class=\"w3-input w3-border w3-round-small\" name=\"assign-user\" id=\"assign-user\" placeholder=\"Please enter only 1 user id\"></textarea>
                <br/>
            ");
        }
    ?>
</div>

<!-- Submit Button -->

<div class="w3-padding-top-24 w3-center">
    <button type="submit" class="w3-button w3-blue w3-round-large">Submit</button>
</div>


</form>
<?php }?>


<?php if($confirm_user_msg != "") {
    //header("Location: ./create-task.php?job_id='.$last_id.'")?>

<?php }?>


</body>

<script>

</script>
</html>