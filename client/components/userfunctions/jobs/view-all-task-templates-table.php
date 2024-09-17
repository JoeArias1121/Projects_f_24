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

// toggle templateStatus_id of taskTemplate_T
if (isset($_GET['templateStatus_id']) && isset($_GET['taskTemplate_id'])) {
    $current_taskTemplate_id = trim($_GET["taskTemplate_id"]);
    $templateStatus_id = trim($_GET["templateStatus_id"]);

    $taskTemplate_sql = "UPDATE s24_StepTemplate_T SET templateStatus_id = ? WHERE taskTemplate_id = ?";

    if ($stmt = mysqli_prepare($db_conn, $taskTemplate_sql)) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "ii", $par1, $par2);

        $par1 = $templateStatus_id;
        $par2 = $current_taskTemplate_id;

        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
}

$industry_query = mysqli_query($db_conn, 'SELECT i.ind_code FROM f23_Industry_T AS i JOIN f23_Company_T AS c 
ON c.ind_code = i.ind_code JOIN f23_User_Table AS u ON c.comp_id = u.company_id WHERE u.UID ='.$_SESSION['user_id']);
$industryResults = mysqli_fetch_assoc($industry_query);
// view all task templates as an admin
if ($_SESSION['user_type'] == 1) {
    $result = mysqli_query($db_conn, 'SELECT * FROM s24_StepTemplate_T');
    if (!$db_conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    if (!$result) {
        // If the query execution failed, handle the error
        die("Error: " . mysqli_error($db_conn));
    }
} else {
    // view all task templates where the SESSION user is listed on a taskTemplateDetails row
    $result = mysqli_query($db_conn, 'SELECT * FROM s24_StepTemplate_T WHERE s24_StepTemplate_T.ind_code 
="'.$industryResults['ind_code'].'" OR s24_StepTemplate_T.ind_code="0"');
}


?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Template Table</title>
    <style>
        /* Add this style to center the content within table cells */
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            text-align: center; /* Center-align content within table cells */
            padding: 8px; /* Add padding for better readability */
            border: 1px solid #ddd; /* Add borders for table cells */
        }
        th {
            background-color: #f2f2f2; /* Add background color to table header cells */
        }
    </style>
</head>
<body>

    <div class="w3-card w3-round-large w3-text-white w3-purple" style="margin-right:17px">
        <h1 class="w3-margin-left">
            Step Templates
        </h1>
    </div>
    <section class="w3-card w3-white w3-round-large" style="margin-right:17px">
        <div class="">
            <table class="w3-table w3-bordered w3-striped">
                <thead>
                    <tr>
                    <?php if ($_SESSION['user_type'] == 1) {?>
                        <th class="w3-center">ID</th>
                        <?php }?>
                        <th class="w3-center">Industry</th>
                        <th class="w3-center">Type</th>
                        <th class="w3-center">Status</th>
                        <th class="w3-center">Title</th>
                        <th class="w3-center">Instructions</th>
                        <th class="w3-center">Form</th>
                        <?php if ($_SESSION['user_type'] == 1) {?>
                        <th class="w3-center">Edit</th>
                        <th class="w3-center">Users/Data</th>
                        <th class="w3-center">Delete</th>
                        <?php }?>
                        </tr>
                </thead>
                <tbody>
                    <!-- While Loop to Generate Rows of Templates -->
                    <?php while ($template = mysqli_fetch_object($result)) { ?>
                        <?php if ($template->templateStatus_id != 3){?>
                        <tr>
                            <!-- Keep the same -->
                            <?php if ($_SESSION['user_type'] == 1) {?>
                            <td style="text-align: center;"><?php echo $template->taskTemplate_id; ?></td>
                            <?php }?>
                            <td style="text-align: center;"><?php if ($template->ind_code == '0') echo 'None'; else echo $template->ind_code; ?></td>
                            
                            <!-- Change task_type to either normal and urgent -->
                            <td style="text-align: center; width:50px">
                                <?php if ($template->task_type == 1) : ?>
                                    <span class="w3-text-red"><b>Urgent</b></span>
                                <?php else : ?>
                                    <span>Normal</span>
                                <?php endif; ?>
                            </td>
                            <!-- Change task_type to approved, in-progress, rejected, or deleted -->
                            <td style="text-align: center;">
                                <?php if ($template->templateStatus_id == 1) : ?>
                                    <span class="w3-text-green"><b>Ready</b></span>
                                <?php elseif ($template->templateStatus_id == 2) : ?>
                                    <span class="w3-text-orange"><b>Not Ready</b></span>
                                <?php else : ?>
                                    <span class="">Deleted</span>
                                <?php endif; ?>
                            </td>
                            <!-- Keep the same -->
                            <td style="text-align: center; width:200px"><?php echo $template->task_title; ?></td>
                            <!-- Keep the same -->
                            <td style="text-align: center;"><?php echo $template->task_instructions; ?></td>
                            <!-- Keep the same -->
                            <td style="text-align: center;">
                                <?php
                                // Retrieve the form title based on form_id
                                $form_id = $template->form_id;
                                if ($form_id == null || $form_id == 0) {
                                    echo "No Form";
                                } else {
                                    $form_query = mysqli_query($db_conn, 'SELECT title FROM f23_Form_Templates WHERE TID = ' . $form_id);
                                    $form_result = mysqli_fetch_assoc($form_query);
                                    echo $form_result['title'];
                                }
                                ?>
                            </td>
                            <?php if ($_SESSION['user_type'] == 1) {?>
                            <td style="text-align: center;">
                                <a class="<?php if ($template->templateStatus_id == 3) {
                                                echo "w3-hide";
                                            } ?>" onclick="document.getElementById('id<?php echo $template->taskTemplate_id; ?>').style.display='block'"><button class="w3-button w3-green w3-round">Details</button></a>
                            </td>
                            <!-- Within the modal window content -->
                            <div id="id<?php echo $template->taskTemplate_id; ?>" class="w3-modal">
                                <div class="w3-modal-content w3-center w3-round-large w3-card-4" style="width:600px; margin-top:-60px;">
                                    <header class="w3-round w3-container w3-purple">
                                        <h6 class="w3-left">Title: <?php echo $template->task_title; ?></h6>
                                        <span onclick="document.getElementById('id<?php echo $template->taskTemplate_id; ?>').style.display='none'" class="w3-button w3-display-topright w3-round-large">&times;</span>
                                    </header>
                                    <iframe height="600" width="600" style="border:none;" src="./userfunctions/jobs/view-one-task-template.php?taskTemplate_id=<?php echo $template->taskTemplate_id; ?>"></iframe>

                                </div>
                            </div>

                            <td style="text-align: center;">
                                <a class="<?php if ($admin_form_disabled == "disabled") {
                                                echo "w3-hide";
                                            } ?>" onclick="document.getElementById('admin<?php echo $template->taskTemplate_id; ?>').style.display='block'"><button class="w3-button w3-blue w3-round">Assign</button></a>
                            </td>
                            <div id="admin<?php echo $template->taskTemplate_id; ?>" class="w3-modal">
                            <div class="w3-modal-content w3-center w3-round-large w3-card-4" style="width:600px; margin-top:-60px;">
                                    <header class="w3-round w3-container w3-purple">
                                        <h6 class="w3-left">Title: <?php echo $template->task_title; ?></h6>
                                        <span onclick="document.getElementById('admin<?php echo $template->taskTemplate_id; ?>').style.display='none'" class="w3-button w3-display-topright w3-round-large">&times;</span>
                                    </header>
                                        <iframe height="600" width="600" style="border:none;" src="./userfunctions/jobs/template-admin.php?taskTemplate_id=<?php echo $template->taskTemplate_id; ?>"></iframe>
                                    
                                </div>
                            </div>
                            <td style="text-align: center;">
                                <a class="<?php if ($template->templateStatus_id == 3) {
                                                echo "w3-hide";
                                            } ?>" href="./dashboard.php?content=tasktemplate&taskTemplate_id=<?php echo $template->taskTemplate_id; ?>&templateStatus_id=3"><button class="w3-button w3-red w3-round">Delete</button></a>
                            </td>
                            <?php }?>
                        </tr>
                        <?php }?>
                    <?php } ?>
                </tbody>

            </table>
        </div>
    </section>
</body>
</html>