<?php
ini_set('display_errors',1); 
error_reporting(E_ALL);

if (!isset($_SESSION)) {
    session_start();
}

include_once('../../../../backend/db_connector.php');


$confirm_user_msg = "";

$industry_query = mysqli_query($db_conn, 
'SELECT i.ind_code 
 FROM f23_Industry_T AS i JOIN f23_Company_T AS c 
 ON c.ind_code = i.ind_code 
 JOIN f23_User_Table AS u 
 ON c.comp_id = u.company_id 
 WHERE u.UID ='.$_SESSION['user_id']);

$industryResults = mysqli_fetch_assoc($industry_query);

// get the task templates for the form
/*
if ($_SESSION['user_type'] == 1)  
$taskTemplate_results = 
                        mysqli_query($db_conn, 
                                    'SELECT * 
                                     FROM s24_StepTemplate_T
                                     WHERE templateStatus_id = 1');
else
*/
$taskTemplate_results = 
                        //mysqli_query($db_conn, 
                                    //'SELECT * FROM s24_StepTemplate_T
                                     //WHERE s24_StepTemplate_T.ind_code ="'.$industryResults['ind_code'].'" OR f23_StepTemplate_T.ind_code="0"');
                        //the above sql takes industry into account, commenting out for now
                        //as we have yet to fully implement industries

    mysqli_query($db_conn, 
    'SELECT * 
        FROM s24_StepTemplate_T
        WHERE templateStatus_id = 1');



$task_query = mysqli_query($db_conn, 'SELECT MAX(task_id) FROM f23_Step_T');
$task_results = mysqli_fetch_assoc($task_query);
$current_task_id = ((int) $task_results['MAX(task_id)']) + 1;

if ($_SESSION['user_type'] == 1) {
    $active = mysqli_query($db_conn, 'SELECT * FROM f23_Job_T WHERE job_status = 2');
    $userID = 1;
    }
else
$userID = $_SESSION['user_id'];
$active = mysqli_query($db_conn, "SELECT * FROM f23_Job_T WHERE job_owner = '$userID' AND job_status != 4");

$user_results = mysqli_query($db_conn, 'SELECT * FROM f23_User_Table');

//get params from form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $taskTemplate_id    = trim($_POST["template-id"]);
    $user_title         = trim($_POST["task-title"]);
    $user_info          = trim($_POST["task-info"]);
    $task_deadline      = trim($_POST["task-deadline"]);
    $task_created       = date("Y-m-d H:i:s");
    $task_form_title    = trim($_POST["form_add"]);

    if($taskTemplate_id ){ //if template is used

        //retrieve selected template information
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
            $param5 = $userID; //task owner
            $param6 = $user_title; //task title
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
                $confirm_user_msg = '<div class="w3-padding-top-16 w3-center">Task Created.</div>';
            } else {
                $confirm_user_msg = "Oops! Something went wrong". mysqli_stmt_error($stmt);
            }
        }
    }
    else{ //if not template not used
        //get the row from taskTemplate_T that needs to be copied into task_T
       /*
        $taskTemplate_row = mysqli_query($db_conn, 'SELECT * FROM f23_StepTemplate_T WHERE taskTemplate_id =' . $taskTemplate_id);
        if ($taskTemplate_row->num_rows > 0) {
            while ($row = $taskTemplate_row->fetch_assoc()) {
                $task_type = $row['task_type'];

                if (empty($user_title))
                    $task_title = $row['task_title'];
                else
                    $task_title = $user_title;

                if (empty($user_title))
                    $task_instructions = $row['task_instructions'];
                else
                    $task_instructions = $user_info;

                $templateStatus_id = $row['templateStatus_id'];
            }
        }
        */
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
            $param6 = $user_title; //task title
            $param7 = $user_info; //task instructions
            $param8 = $task_deadline; //task deadline
            $param9 = $task_created ; //task created
            $param10 = $task_form_title; //form
            
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
                $par2 = $current_task_id;
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





    /*
    // ________Working on this section _________
    if ($_SESSION['user_type'] == 1 || $_SESSION['user_type'] == 2|| $_SESSION['user_type'] == 5) { 
        $admin_task_title = trim($_POST["task-title"]);
        $admin_task_instructions = trim($_POST["task-info"]);
        $admin_task_deadline = trim($_POST["task-deadline"]);
        $admin_task_created = date("Y-m-d H:i:s");
        $admin_form_title = "default";

        if (isset($add_user_id)) {

            $add_user_no_data_sql = "INSERT INTO f23_Step_T(policy_id, task_type, task_status, task_owner, task_title, task_instructions, task_deadline, task_created, form_title) VALUES (0,1,?,?,?,?,?,?,?)";

            if ($stmt = mysqli_prepare($db_conn, $add_user_no_data_sql)) {
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "iisssss", $param3, $param4, $param5, $param6, $param7, $param8, $param9);

                // 2 starts for a task in progress
                $param3 = 2;

                // will come from unit A. Currently in the SESSION variable
                $param4 = $admin_add_user_id;
                $param5 = $admin_task_title;
                $param6 = $admin_task_instructions; 
                $param7 = $admin_task_deadline;
                $param8 = $admin_task_created;
                $param9 = $admin_form_title;

                if (mysqli_stmt_execute($stmt)) {
                    mysqli_stmt_store_result($stmt);
                    $confirm_user_msg = "Task Created.";
                } else {
                    $confirm_user_msg = "Oops! Something went wrong. mysqli_stmt_error($stmt);";
                }
            }

            // Note: In the detabase JobDetails_T is the table that links jobs to tasks
        }
        
    }
    // ________Working on this section _________
    */



    /*
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
            if ($stmt = mysqli_prepare($db_conn, $add_row_to_jobDetails)) {
              // Bind variables to the prepared statement as parameters
              mysqli_stmt_bind_param($stmt, "iii", $par1, $par2, $par3);
          
              $par1 = $current_job_id;
              $par2 = $current_task_id;
              $par3 = $new_order;
          
              mysqli_stmt_execute($stmt);
              mysqli_stmt_close($stmt);
            }
        }
    */
    // header("Refresh:1");
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
    
    
    <form id="stepForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">

        <!--Select Option-->
        <h2 class=""><?php echo $confirm_user_msg; ?></h2>
        <label for="template-id">Template</label>
        <br>
        <div>
            <div>
                <select name="template-id" id="template-id" class="w3-select w3-border w3-round-large">
                <option value="">None</option>
                    <?php while ($template = mysqli_fetch_object($taskTemplate_results)) { ?>
                        <option value="<?php echo $template->taskTemplate_id; ?>"><?php echo $template->task_title; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <br>

        <label id="taskTitle" for="task-title">Title:</label>
        <br>
        <div>
            <div>
                <input class="w3-input w3-border w3-round-large" type="text" name="task-title" id="task-title" placeholder="Title">
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
        <!--         <div class="w3-bar">
            
            <div class="w3-bar-item">
                <div>
                    <button id="add-user-btn" class="w3-button w3-green w3-round">+</button>
                </div>
            </div>
            
            <div class="w3-bar-item">
                <div>
                    <h6 class="content">Add User</h6>
                </div>
            </div>
        </div> -->
        <!-- <div class="notification w3-hide" id="add-user-form">
        <form action="./create-task.php" method="GET"> -->
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
        
        <?php if ($_SESSION['user_type'] == 1|| $_SESSION['user_type'] == 2|| $_SESSION['user_type'] == 5) { ?>
        <br>
        <label for="add_user_id">Assign to User</label>
        <br>
        <div class="control">
            <div class="select">
                <select name="add_user_id" id="add_user_id" class="w3-select w3-border w3-round-large">
                    <option value="<?php echo $_SESSION['user_id'] ?>">None</option>
                    <?php while ($user = mysqli_fetch_object($user_results)) { ?>
                        <option value="<?php echo $user->UID ?>"><?php echo $user->user_name; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <?php }?>
	<BR>
	<label id="form" for="form_add">Add Form:</label>
	<select class="w3-input w3-border w3-round-large" name="form_add" id="form_dropdown" placeholder="Choose Form to Add">
		<option value='0'>Select Form</option>
	<?php
	$sql1 = "SELECT * FROM f23_Form_Templates";
	$indquery1 = mysqli_query($db_conn, $sql1);
	$r1 = mysqli_num_rows($indquery1);
	if ($r1 > 0) {
                while ($result = mysqli_fetch_assoc($indquery1)) {
                    $um = $result['title'];
                    $formValue = $result['TID'];
                    echo ("<option value=" . $formValue . ">" . $um . "</option>");
                }
            }
            ?>
        </select>

        <br>

        <label id="taskInfo" for="task-info">Instructions:</label>

        <div>
            <div>
                <textarea class="w3-input w3-border w3-round-large" name="task-info" id="task-info" placeholder="Instructions"></textarea>
            </div>
        </div>
        <br>
        <!-- </form>
        </div> -->



        <!-- Hidden field to perserve task_id upon submit -->
        <!-- <input type="hidden" name="task_id" value="<?php echo $current_task_id; ?>"> -->

        <!-- Submit Button -->

        <div class="w3-padding-top-24 w3-center">
            <button type="submit" class="w3-button w3-blue w3-round-large">Submit</button>
        </div>


    </form>
</body>
<script>
            const template = document.getElementById("template-id"); 

            //form field
            const formField = document.getElementById("form"); //form field instructions 
            const formDropdown = document.getElementById("form_dropdown"); //form field
            //save original look
            const ogFormField = formField.style.display;
            const ogFormDropdown = formDropdown.style.display;

            //instruction field
            const instructionsTitle =  document.getElementById("taskInfo"); 
            const instructionsField = document.getElementById("task-info");
            //save original look
            const ogInstructionsTitle = instructionsTitle.style.display;
            const ogInstructionsField = instructionsField.style.display;

            template.addEventListener('change', function() {
            const templateSelected = template.value;
                if(templateSelected){ //if templated selected hide
                    formField.style.display = 'none';
                    formDropdown.style.display = 'none';
                    instructionsField.style.display = 'none';
                    instructionsTitle.style.display = 'none';
                }
                else{ //redisplay fields if template unselected 
                    formField.style.display = ogInstructionsField;
                    formDropdown.style.display = ogFormDropdown;
                    instructionsField.style.display = ogInstructionsTitle;
                    instructionsTitle.style.display = ogInstructionsField;
                }
            });
    </script>

</html> 