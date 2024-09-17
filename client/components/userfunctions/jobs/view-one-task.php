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

// get task_id from $_GET from view-all-task.php
if (!empty($_GET["task_id"])) {
    $current_task_id = trim($_GET["task_id"]);
}

// toggle taskPart_status of taskDetails_T
if (isset($_GET['taskPart_status']) && isset($_GET['task_id'])) {

    $task_sql = "UPDATE f23_Step_T SET task_status = ? WHERE task_id = ?";
    if ($stmt = mysqli_prepare($db_conn, $task_sql)) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "ii", $par1, $par2);
        
        $par1 = trim($_GET["taskPart_status"]);
        $par2 = trim($_GET["task_id"]);
        
        
        mysqli_stmt_execute($stmt);
        if(mysqli_stmt_errno($stmt) !== 0) {
            // There was an error
            echo "Error: " . mysqli_stmt_error($stmt);
        }
        mysqli_stmt_close($stmt);
    }

    /*
    $current_task_id = trim($_GET["task_id"]);
    $taskPart_status = trim($_GET["taskPart_status"]);


    //$taskPart_sql = "UPDATE f23_StepDetails_T SET taskPart_status = ? WHERE task_id = ? AND user_id = ?";
    $taskPart_sql = "UPDATE f23_Step_T SET task_status = ? WHERE task_id = ? AND user_id = ?";



    if ($stmt = mysqli_prepare($db_conn, $taskPart_sql)) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "iii", $par1, $par2, $par3);

        $par1 = $taskPart_status;
        $par2 = $current_task_id;
        $par3 = $_SESSION['user_id'];

        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
    */

    // update the tasks status based on the task details

    // if there is a task detail that was rejected (value of 2) than the task should have status rejected (value of 3)
    // if SUM = COUNT than task is approved 
    // if SUM != Count than task is still in-progress
    /*
    $check_reject_status = mysqli_query($db_conn, 's as count FROM f23_StepDetails_T WHERE taskPart_status = 2 AND task_id = ' . $current_task_id);
    $data_count = $check_reject_status->fetch_assoc();
    if ($data_count['count'] > 0) {
        $status_id = 3;
    } else {
        $tasksCompleted_result = mysqli_query($db_conn, "SELECT SUM(taskPart_status) as tasks_completed, COUNT(*) as number_of_total_tasks FROM f23_StepDetails_T WHERE task_id = " . $current_task_id);
        if ($tasksCompleted_result->num_rows > 0) {
            while ($row = $tasksCompleted_result->fetch_assoc()) {
                $tasksCompleted_number = $row['tasks_completed'];
                $total_number_of_tasks = $row['number_of_total_tasks'];
                if ($tasksCompleted_number != $total_number_of_tasks) {
                    // the task is still in progress then
                    $status_id = 2;
                } else {
                    // the task is completed and approved
                    $status_id = 1;
                }
            }
        }
    }
    /*
    if(isset($_GET['taskPart_status'])){
        

        $status_sql = "UPDATE f23_Step_T SET task_status = ? WHERE task_id = ?";

        if ($stmt = mysqli_prepare($db_conn, $status_sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ii", $par1, $par2);

            $par1 = $status_id;
            $par2 = $current_task_id;

            mysqli_stmt_execute($stmt);
            if(mysqli_stmt_errno($stmt) !== 0) {
                // There was an error
                echo "Error: " . mysqli_stmt_error($stmt);
            }
            mysqli_stmt_close($stmt);
        }
    }
}

    if(isset($_POST['submit'])){
        $owner_assigned = $_POST["assign-owner"];
        
        $stmnt = "UPDATE f23_Step_T SET task_status = $task_bar WHERE task_id = $current_job_id;";
        $statement = mysqli_prepare($db_conn, $stmnt);
        mysqli_stmt_execute($statement);
        mysqli_stmt_close($statement);
    }
*/
}

// view the one task
$task_results = mysqli_query($db_conn, 'SELECT * FROM f23_Step_T WHERE task_id = ' . $current_task_id);


// get the task data associated with this task and user
$taskDetails_results = mysqli_query($db_conn, 'SELECT DISTINCT data_id FROM f23_StepDetails_T WHERE task_id = ' . $current_task_id . ' AND user_id = ' . $_SESSION['user_id']);


// get the current taskPart_status id to display to the user
// $taskPart_results = mysqli_query($db_conn, 'SELECT taskPart_status FROM taskDetails_T WHERE task_id = ' . $current_task_id . ' AND user_id = ' . $_SESSION['user_id']);

// if ($taskPart_results->num_rows > 0) {
//     while($row = $taskPart_results->fetch_assoc()) {
//         $current_statusPart_status = $row['taskPart_status'];
//     }
// }
// // convert the taskPart_status id into a legible text
// if($current_statusPart_status == 0) {
//     $current_statusPart_status = "In-Progress";
// } else {
//     $current_statusPart_status = "Completed";
// }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>View Step</title>
</head>
<style>
    body {
        font-family: "Raleway", sans-serif;
        font-size: small
    }
</style>

<body>
    <div class="w3-row">

        <?php while ($task = mysqli_fetch_object($task_results)) { ?>
            <div class=" w3-container">
                <h6 class="">
                    <span class="w3-display-topmiddle">Status: <span>
                            <?php if ($task->task_status == 1) : ?>
                                <span style="text-transform: uppercase;"> Approved</span>
                            <?php elseif ($task->task_status == 2) : ?>
                                <span style="text-transform: uppercase;"> In-Progress</span>
                            <?php elseif ($task->task_status == 3) : ?>
                                <span style="text-transform: uppercase;"> Rejected</span>
                            <?php elseif ($task->task_status == 4) : ?>
                                <span style="text-transform: uppercase;"> Archived</span>
                            <?php else : ?>
                                <span style="text-transform: uppercase;"> Not Started</span>
                            <?php endif; ?>
                </h6>

                <h6 class="w3-padding-top-32">Step Instructions:</h6>
                <p class="content">
                    <?php echo $task->task_instructions; ?>
                </p>
                <hr>
                
                <!--
                <figure class="image">
                    <iframe style="margin-left: -52px" src="./task-data.php?task_id=<?php echo $current_task_id; ?>" class="" width="590"></iframe>
                </figure>
                <hr>
                -->                  
                
                <?php 
                //if there is a form attached to step, display form
                    if($task->form_title != "0"){
                        echo "<h6>Form:</h6>";
                        $formTID =$task->form_title;
                        echo "<iframe src='../forms/viewForm.php?TID=$formTID' width='100%' height='500px'></iframe>";
                    }

                ?>


                <h4 class="w3-center">Step Actions:</h4>
                <div class="w3-container w3-center w3-padding-top-16 <?php if ($admin_form_disabled == "disabled") echo 'w3-hide' ?>">
                    <a href="./task-admin.php?task_id=<?php echo $current_task_id; ?>"><button class="w3-button w3-large w3-green w3-round" <?php echo $admin_form_disabled; ?>>Users & Data</button></a>
                    
                </div>




                <form action="./view-one-task.php" method="GET">
                    <!-- Radio Buttons -->
                    <h6>Edit Status: </h6>
                    <div class="">
                        <div class="">
                            <label class="radio">
                                <input class="w3-radio" type="radio" name="taskPart_status" value="2">
                                Active
                            </label>
                            <br>
                            <label class="radio">
                                <input class="w3-radio" type="radio" name="taskPart_status" value="1">
                                Paused
                            </label>
                            <br>
                            <label class="radio">
                                <input class="w3-radio" type="radio" name="taskPart_status" value="3">
                                Finished
                            </label>
                            <br>
                        </div>
                    </div>
                    <input type="hidden" name="task_id" value="<?php echo $current_task_id; ?>">
                    <br>
                    <!-- Submit Button -->
                    <div class="">
                        <div class="">
                            <button type="submit" class="w3-button w3-blue w3-round">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        <?php } ?>
        
    </div>

</body>

</html>