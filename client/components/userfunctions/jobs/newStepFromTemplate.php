<?php

/* 
This file is not used as creating a step via a template has been merged into 
create-task.php. Im keeping it here for now for reference but future groups
can delete
*/





if (!isset($_SESSION)) {
    session_start();
}
include_once('../../../../backend/db_connector.php');
$userID = $_SESSION['user_id'];
$confirm_user_msg = "";

$taskTemplate_results = mysqli_query($db_conn, 'SELECT * FROM s24_StepTemplate_T');
$active = mysqli_query($db_conn, "SELECT * FROM f23_Job_T WHERE job_owner = '$userID' AND job_status != 4");

//get params from form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $taskTemplate_id    = trim($_POST["template-id"]);
    $task_deadline      = trim($_POST["task-deadline"]);
    $task_created       = date("Y-m-d H:i:s");

    //retreive selected template information
    $templateQuery = mysqli_query($db_conn, "SELECT * FROM s24_StepTemplate_T WHERE taskTemplate_id = '$taskTemplate_id'");
    $template = mysqli_fetch_object($templateQuery);

    $stepTitle = $template->task_title;
    $task_instructions = $template->task_instructions;
    $formID = $template->form_id;



    // insert a new row into Task_T 
    $task_instance_sql = "INSERT INTO f23_Step_T(task_id, policy_id, task_type, task_status, task_owner, task_title, task_instructions, task_deadline, task_created, form_title) VALUES (?,?,?,?,?,?,?,?,?,?)";
    if ($stmt = mysqli_prepare($db_conn, $task_instance_sql)) {
        // Bind variables to the prepared statement as parameters
        
        mysqli_stmt_bind_param($stmt, "iiiiisssss", $param1, $param2, $param3, $param4, $param5, $param6, $param7, $param8, $param9, $param10);


        $findID = "SELECT MAX(task_id) AS task_id FROM f23_Step_T";
        $IDresult = mysqli_query($db_conn, $findID);
        $IDresult = mysqli_fetch_assoc($IDresult);
        $stepID = $IDresult['task_id'];
        $stepID = $stepID + 1;
        $param1 = $stepID;

        $param2 = 1; //policy id
        $param3 = 2; //task_type
        $param4 = 2; //task status
        $param5 = $_SESSION["user_id"]; //task owner
        $param6 = $stepTitle; //task title
        $param7 = $task_instructions; //task instructions
        $param8 = $task_deadline; //task deadline
        $param9 = $task_created ; //task created
        $param10 =$formID; //form
        
        //if attached to job insert into f23_job_details   
        $current_job_id = trim($_POST['add_job']);
        if (isset($current_job_id)){
            $lo_query = mysqli_query($db_conn,'SELECT MAX(job_taskOrder) FROM f23_JobDetails_T WHERE job_id ='.$current_job_id);
            if ($lo_query){
            $orderResult = mysqli_fetch_row($lo_query);
            $number = (int)$orderResult[0];
            }
            else{
            $number=0;
            }
            $new_order = $number +1;
          
            $add_row_to_jobDetails = 'INSERT INTO f23_JobDetails_T VALUES (?, ?, ?)';
            if ($stmt2 = mysqli_prepare($db_conn, $add_row_to_jobDetails)) {
              // Bind variables to the prepared statement as parameters
              mysqli_stmt_bind_param($stmt2, "iii", $par1, $par2, $par3);
          
              $par1 = $current_job_id;
              $par2 = $stepID;
              $par3 = $new_order;
          
              mysqli_stmt_execute($stmt2);
              mysqli_stmt_close($stmt2);
            }
        }

        
        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_store_result($stmt);
            $confirm_user_msg = '<div class="w3-padding-top-16 w3-center">Task Created.</div>';
        } else {
            $confirm_user_msg = "Oops! Something went wrong". mysqli_stmt_error($stmt);
        }
    }
}   






   

?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Create a Step Template</title>
</head>
<style>
    body {
        font-family: "Raleway", sans-serif
    }
</style>


<body>

    
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <h2 class=""><?php echo $confirm_user_msg; ?></h2>
        <!--Select Option-->
        <label for="template-id">Select A Step Template</label>
        <br>
        <div>
            <div>
                <select name="template-id" id="template-id" class="w3-select w3-border w3-round-large">
                    <?php while ($template = mysqli_fetch_object($taskTemplate_results)) { ?>
                        <option value="<?php echo $template->taskTemplate_id; ?>"><?php echo $template->task_title; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <br>


        <label for="task-deadline">Step Deadline:</label>
        <br>
        <div>
            <div>
                <input class="w3-input w3-border w3-round-large" type="datetime-local" name="task-deadline" id="task-deadline">
            </div>
        </div>

        <?php 
            if(!isset($_GET['job_id'])) {   
            ?>
            <br>
            <label for="add_job">Attach to Job</label>
            <br>
            <div class="control">
                <div class="select">
                    <select name="add_job" id="add_job" class="w3-select w3-border w3-round-large">
                        <option value="">None</option>
                        <?php while ($job = mysqli_fetch_object($active)) { ?>
                            <option value="<?php echo $job->job_id ?>"><?php echo $job->job_title; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <?php 
                }
                else{
                    echo'<input type="hidden" name="add_job" id="add_job" value='.$_GET['job_id'].'">';
                }
        
        ?>
        

        <!-- Hidden field to perserve task_id upon submit -->
        <!-- <input type="hidden" name="task_id" value="<?php echo $current_task_id; ?>"> -->

        <!-- Submit Button -->

        <div class="w3-padding-top-24 w3-center">
            <button type="submit" class="w3-button w3-blue w3-round-large">Submit</button>
        </div>


    </form>
</body>
<script>
    // addRowBtn = document.getElementById("add-user-btn");
    // addRowForm = document.getElementById("add-user-form");
    // addRowBtn.addEventListener("click", function() {
    //     addRowForm.classList.toggle("w3-show");
    // });
</script>

</html>