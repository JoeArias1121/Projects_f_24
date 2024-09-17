<?php
// Initialize the session
if (!isset($_SESSION)) {
    session_start();
}
include_once('../../../../backend/db_connector.php');

// this variable is to see if the user is an admin
$admin_form_disabled = "";
$current_status_template_status = '';

if ($_SESSION['user_type'] == 001 || $_SESSION['user_type'] == 2) {
    $admin_form_disabled = "";
}

// Initialize $current_task_template_id
$current_task_template_id = null;

// get taskTemplate_id from $_GET from view-all-task-templates.php
if (!empty($_GET["taskTemplate_id"])) {
    $current_task_template_id = trim($_GET["taskTemplate_id"]);
} else {
    // Display an error message or redirect the user
    echo "Error: Task Template ID is missing.";
    exit; // Exit the script to prevent further execution
}

// HARD CODED A USER ID. THIS WILL BE A SESSION VARIABLE FROM UNIT A    
$user_type = $_SESSION['user_id'];

// toggle templateStatus_id of taskTemplate_T
if (isset($_GET['templateStatus_id']) && isset($_GET['taskTemplate_id'])) {
    $current_taskTemplate_id = trim($_GET["taskTemplate_id"]);
    $templateStatus_id = trim($_GET["templateStatus_id"]);
    $industryCode = $_GET["indCode"];

    $taskTemplate_sql = "UPDATE s24_StepTemplate_T SET templateStatus_id = ?, ind_code = ?  WHERE taskTemplate_id = ?";

    if ($stmt = mysqli_prepare($db_conn, $taskTemplate_sql)) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "isi", $par1, $par2, $par3);

        $par1 = $templateStatus_id;
        $par2 = $industryCode;
        $par3 = $current_taskTemplate_id;

        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
}

if (isset($_GET['indCode']) && isset($_GET['taskTemplate_id'])) {
    $current_taskTemplate_id = trim($_GET["taskTemplate_id"]);
    $industryCode = $_GET["indCode"];

    $taskTemplate_sql = "UPDATE s24_StepTemplate_T SET ind_code = ?  WHERE taskTemplate_id = ?";

    if ($stmt = mysqli_prepare($db_conn, $taskTemplate_sql)) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "si", $par2, $par3);

        $par2 = $industryCode;
        $par3 = $current_taskTemplate_id;

        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
    if ($industryCode == '0')
    $industryCode = "None";
    echo "Industry Set To ".$industryCode;
}

// view the one template
$taskTemplate_results = mysqli_query($db_conn, 'SELECT * FROM s24_StepTemplate_T WHERE taskTemplate_id = ' . $current_task_template_id);

// get the task data associated with this task and user
$taskDetails_results = mysqli_query($db_conn, 'SELECT DISTINCT dataType_id FROM f23_StepTemplateDetails_T WHERE taskTemplate_id = ' . $current_task_template_id . ' AND user_type = ' . $user_type);


// get the current templateStatus_id to display to the user
$templateStatus_results = mysqli_query($db_conn, 'SELECT templateStatus_id FROM f23_StepTemplate_T WHERE taskTemplate_id = ' . $current_task_template_id);

if ($templateStatus_results->num_rows > 0) {
    while ($row = $templateStatus_results->fetch_assoc()) {
        $current_status_template_status = $row['templateStatus_id'];
    }
}
// convert the templateSstatus_id into a legible text
if ($current_status_template_status == 1) {
    $current_status_template_status = "READY";
} else if ($current_status_template_status == 2) {
    $current_status_template_status = "NOT READY";
} else {
    $current_status_template_status = "ARCHIVED";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>View Task Template</title>
</head>
<style>
    body {
        font-family: "Raleway", sans-serif
    }
</style>

<body>
    <div class="w3-row">
    <h6 class="w3-center">Status: </strong><?php echo $current_status_template_status; ?></h6>
        <div class="m4 w3-col w3-container w3-center w3-padding-top-24">
            <h6 class="">Task Admin:</h6>
            <a href="./template-admin.php?taskTemplate_id=<?php echo $current_task_template_id; ?>"><button class="w3-button w3-green w3-round" <?php echo $admin_form_disabled; ?>>View & Change</button></a>
        </div>
        <?php while ($task = mysqli_fetch_object($taskTemplate_results)) { ?>
            <div class="m4 w3-col w3-container">
                <!-- <h6 class="">Task Template Title: <span class=""><?php echo $task->task_title; ?><span></h6> -->
                <hr>
                <h6 class="">Task Template Instructions:</h6>
                <p class="content">
                    <?php echo $task->task_instructions; ?>
                </p>
                <?php 
                //if there is a form attached to step, display form
                    if($task->form_id != "0"){
                        echo "<h6>Form:</h6>";
                        $formTID =$task->form_id;
                        echo "<iframe src='../forms/viewForm.php?TID=$formTID' width='100%' height='500px'></iframe>";
                    }

                ?>

                <!--    <h2 class="title is-6">Task Data (Unit CD PLACEHOLDER):</h2>
                    <?php while ($data = mysqli_fetch_object($taskDetails_results)) { ?>
                        <div class="columns">
                            <div class="column is-one-third">
                                <a><?php echo $data->dataType_id; ?></a>
                            </div>
                            <div class="column is-three-quarters is-offset-3">
                                <div class="buttons">
                                    <button class="button is-primary" style="float:right;">Upload</button>
                                    <button class="button is-primary" style="float:right;">Download</button>
                                </div>
                            </div>
                        </div>
                    <?php } ?>-->

                <hr>
                <form action="./view-one-task-template.php" method="GET">
                    <!-- Radio Buttons -->
                    <p><strong>Edit Status:</strong> </p>
                    <div class="">
                        <div class="">
                            <label class="radio">
                                <input class="w3-radio" type="radio" name="templateStatus_id" value="1">
                                Ready
                            </label>
                            <br>
                            <label class="radio">
                                <input class="w3-radio" type="radio" name="templateStatus_id" value="2">
                                Not Ready
                            </label>
                            <br>
                            <label class="radio">
                                <input class="w3-radio" type="radio" name="templateStatus_id" value="3">
                                Deleted
                            </label>
                            <br>
                        </div>
                    </div>
                    <br>
                    <label for="indCode">Industry:</label>
                    <select id="indCode" name="indCode" class="w3-input w3-border w3-round-large w3-sand">
                    <option value="<?php if($task->ind_code == 0) echo "0"; else echo $task->ind_code; ?>"><?php if($task->ind_code == 0) echo "None"; else echo $task->ind_code; ?></option>
                        <?php
                                    if ($task->ind_code != Null) 
                                    echo("<option value='0'>None</option>");
                        $sql = "SELECT * FROM f23_Industry_T ORDER BY ind_code ASC";
                        $indquery  = mysqli_query($db_conn, $sql);
                        $r = mysqli_num_rows($indquery);
                        if ($r > 0) {
                            while ($result = mysqli_fetch_assoc($indquery)) {
                                $indCode = $result['ind_code'];
                                echo ("<option value=".$indCode.">" .$indCode. "</option>");
                            }
                        }
                        ?>
                    </select>
                    <input type="hidden" name="taskTemplate_id" value="<?php echo $current_task_template_id; ?>">

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