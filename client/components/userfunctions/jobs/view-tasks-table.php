<?php
// Initialize the session
if (!isset($_SESSION)) {
    session_start();
}
include_once('../../backend/db_connector.php');
$userID = $_SESSION['user_id'];
// this variable is to see if the user is an admin or manager
$admin_form_disabled = "disabled";

if ($_SESSION['user_type'] == 1 || $_SESSION['user_type'] == 2|| $_SESSION['user_type'] == 5) {
    $admin_form_disabled = "";
}

// Change task status by changing its status
if (isset($_GET['change_status']) && isset($_GET['task_id'])) {
    $update_task = $_GET['task_id'];
    $status_status_id = $_GET['change_status'];

    $update_task_sql = 'UPDATE f23_Step_T SET task_status = ? WHERE task_id = ?';

    if ($stmt = mysqli_prepare($db_conn, $update_task_sql)) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "ii", $par1, $par2);

        $par1 = $status_status_id;
        $par2 = $update_task;

        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
}
if (isset($_GET['task_status'])) {
    $current_task_status = $_GET["task_status"];
}
else
$current_task_status = 2;

// view all tasks as an admin
if ($_SESSION['user_type'] == 1 || $_SESSION['user_type'] == 2) {
    $done = mysqli_query($db_conn, 'SELECT * FROM f23_Step_T WHERE task_status = 1');
    $reject = mysqli_query($db_conn, 'SELECT * FROM f23_Step_T WHERE task_status = 3');
    $active = mysqli_query($db_conn, 'SELECT * FROM f23_Step_T WHERE task_status ='.$current_task_status);
} else {
    /*
    // view all tasks where the SESSION user is task_owner
    $done = mysqli_query($db_conn, 'SELECT * FROM f23_Step_T AS t INNER JOIN f23_StepDetails_T AS td ON t.task_id = td.task_id WHERE t.task_status = 1 AND td.user_id = ' . $_SESSION['user_id']);
    $reject = mysqli_query($db_conn, 'SELECT * FROM f23_Step_T AS t INNER JOIN f23_StepDetails_T AS td ON t.task_id = td.task_id WHERE t.task_status = 3 AND td.user_id =' . $_SESSION['user_id']);
    $active = mysqli_query($db_conn, 'SELECT * FROM f23_Step_T AS t INNER JOIN f23_StepDetails_T AS td ON t.task_id = td.task_id WHERE t.task_status = '.$current_task_status.' AND td.user_id =' . $_SESSION['user_id']);
    */

    $done = mysqli_query($db_conn, "SELECT * FROM f23_Step_T WHERE task_status = 3 AND task_owner = '$userID'");
    $paused = mysqli_query($db_conn, "SELECT * FROM f23_Step_T WHERE task_status = 1 AND task_owner = '$userID'");
    $active = mysqli_query($db_conn, "SELECT * FROM f23_Step_T WHERE (task_status = 2 OR task_status = 5) AND task_owner = '$userID'");
}


?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Task Table</title>
</head>

<body>

    <div class="w3-container w3-white w3-round w3-border w3-margin-bottom w3-margin-right" style="font-size:small">
    <header class="w3-round w3-container w3-blue" style="margin-left:-17px; margin-right:-17px">
            <h6> Active</h6>
        </header>
        <table class="w3-table w3-bordered w3-hoverable">
            <thead>
                <tr>
                   <!--   <th>ID</th> -->
                    <th>Status</th>
                    <th>Title</th>
                    <th>Instructions</th>
                    <th>Created</th>
                    <th>Deadline</th>
                    <th>Update</th>
                    <th class="<?php if ($admin_form_disabled == "disabled") {
                                        echo "w3-hide";
                                    } ?>">Data/Users</th>
                    <th>Archive</th>
                </tr>
            </thead>
            <tbody>
                <!-- While Loop to Generate Rows of Tasks -->
                <?php while ($task = mysqli_fetch_object($active)) { ?>

                    <tr>
                        <!-- Keep the same -->
                       <!--   <td><?php //echo $task->task_id; ?></td> -->

                        <td style="width:100px">
                            <?php if ($task->task_status == 1) : ?>
                                <span class="has-text-success">Done</span>
                            <?php elseif ($task->task_status == 2) : ?>
                                <span>In-Progress</span>
                            <?php elseif ($task->task_status == 3) : ?>
                                <span class="has-text-danger">Archived</span>
                                <?php elseif ($task->task_status == 5) : ?>
                                <span class="has-text-danger">Not Started</span>
                            <?php endif; ?>
                        </td>
                        <!-- Get title -->
                        <td style="width:150px"><?php echo $task->task_title; ?></td>
                        <!-- Keep the same -->
                        <td><?php echo $task->task_instructions; ?></td>
                        <!-- Keep the same -->
                        <td><?php echo $task->task_deadline; ?></td>
                        <!-- Keep the same -->
                        <td><?php echo $task->task_created; ?></td>
                        <!-- Keep the same -->
                        <td>
                            <a class="<?php if ($task->task_status == 1 || $task->task_status == 3) {
                                            echo "w3-hide";
                                        } ?>"><button onclick="document.getElementById('id<?php echo $task->task_id; ?>').style.display='block'" class="w3-btn w3-green w3-round">Details</button></a>
                        </td>
                        <td class="<?php if ($admin_form_disabled == "disabled") {
                                        echo "w3-hide";
                                    } ?>">
                            <a><button onclick="document.getElementById('ad<?php echo $task->task_id; ?>').style.display='block'" class="w3-btn w3-blue w3-round">Assign</button></a>
                        </td>
                        <td>
                            <a class="<?php if ($task->task_status == 3) {
                                            echo "w3-hide";
                                        } ?>" href="./dashboard.php?content=jobsteplist&task_id=<?php echo $task->task_id; ?>&change_status=4"><button class="w3-btn w3-red w3-round">Archive</button></a>
                        </td>
                    </tr>
                    <div id="id<?php echo $task->task_id; ?>" class="w3-modal">
                    <div class="w3-modal-content w3-center w3-round-large w3-card-4" style="width:600px; margin-top:-75px;">
                            <header class="w3-round w3-container w3-blue w3-text-white">
                                <h6 class="w3-left"><?php echo $task->task_title; ?></h6>
                                <span onclick="document.getElementById('id<?php echo $task->task_id; ?>').style.display='none'" class="w3-button w3-display-topright w3-round">&times;</span>
                            </header>
                            <iframe height="675" width="600" style="border:none;" src="./userfunctions/jobs/view-one-task.php?task_id=<?php echo $task->task_id; ?>"></iframe>
                        </div>
                    </div>
                    <div id="ad<?php echo $task->task_id; ?>" class="w3-modal">
                    <div class="w3-modal-content w3-center w3-round-large w3-card-4" style="width:600px; margin-top:-75px;">
                            <header class="w3-round w3-container w3-blue w3-text-white">
                                <h6 class="w3-left"><?php echo $task->task_title; ?></h6>
                                <span onclick="document.getElementById('ad<?php echo $task->task_id; ?>').style.display='none'" class="w3-button w3-display-topright w3-round">&times;</span>
                            </header>
                                <iframe height="675" width="600" style="border:none;" src="./userfunctions/jobs/task-admin.php?task_id=<?php echo $task->task_id; ?>"></iframe>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <div class="w3-container w3-white w3-round w3-border w3-margin-bottom w3-margin-right" style="font-size:small">
        <header class="w3-round w3-container w3-deep-purple" style="margin-left:-17px; margin-right:-17px">
            <h6> Paused</h6>
        </header>
        <table class="w3-table w3-bordered w3-hoverable">
            <thead>
                <tr>
               <!--  <th>ID</th> -->
                    <th>Status</th>
                    <th>Title</th>
                    <th>Instructions</th>
                    <th>Created</th>
                    <th>Deadline</th>
                    <th>Update</th>
                    <th class="<?php if ($admin_form_disabled == "disabled") {
                                        echo "w3-hide";
                                    } ?>">Data/Users</th>
                    <th>Archive</th>
                </tr>
            </thead>
            <tbody>
                <!-- While Loop to Generate Rows of Tasks -->
                <?php while ($task = mysqli_fetch_object($paused)) { ?>
                    <tr>
                        <!-- Keep the same -->
                        <!-- <td><?php //echo $task->task_id; ?></td> -->

                        <td style="width:100px">
                            <?php if ($task->task_status == 1) : ?>
                                <span class="has-text-success">Done</span>
                            <?php elseif ($task->task_status == 2) : ?>
                                <span>In-Progress</span>
                            <?php elseif ($task->task_status == 3) : ?>
                                <span class="">Rejected</span>
                            <?php endif; ?>
                        </td>
                        <!-- Get title -->
                        <td style="width:150px"><?php echo $task->task_title; ?></td>
                        <!-- Keep the same -->
                        <td><?php echo $task->task_instructions; ?></td>
                        <!-- Keep the same -->
                        <td><?php echo $task->task_deadline; ?></td>
                        <!-- Keep the same -->
                        <td><?php echo $task->task_created; ?></td>
                        <!-- Keep the same -->
                        <td>
                            <a class=""><button onclick="document.getElementById('id<?php echo $task->task_id; ?>').style.display='block'" class="w3-btn w3-green w3-round">Details</button></a>
                        </td>
                        <td class="<?php if ($admin_form_disabled == "disabled") {
                                        echo "w3-hide";
                                    } ?>">
                            <a><button onclick="document.getElementById('admin<?php echo $task->task_id; ?>').style.display='block'" class="w3-btn w3-blue w3-round">Assign</button></a>
                        </td>
                        <td>
                            <a class="<?php if ($task->task_status == 4) {
                                            echo "w3-hide";
                                        } ?>" href="./dashboard.php?content=jobsteplist&task_id=<?php echo $task->task_id; ?>&change_status=4"><button class="w3-btn w3-red w3-round">Archive</button></a>
                        </td>
                    </tr>
                    <div id="id<?php echo $task->task_id; ?>" class="w3-modal">
                        <div class="w3-modal-content w3-center w3-round-large w3-card-4" style="width:600px; margin-top:-75px;">
                            <header class="w3-round w3-container w3-deep-purple">
                                <h6 class="w3-left"><?php echo $task->task_title; ?></h6>
                                <span onclick="document.getElementById('id<?php echo $task->task_id; ?>').style.display='none'" class="w3-button w3-display-topright w3-round">&times;</span>
                            </header>
                            <iframe height="675" width="600" style="border:none;" src="./userfunctions/jobs/view-one-task.php?task_id=<?php echo $task->task_id; ?>"></iframe>
                        </div>
                    </div>
                    <div id="admin<?php echo $task->task_id; ?>" class="w3-modal">
                    <div class="w3-modal-content w3-center w3-round-large w3-card-4" style="width:600px; margin-top:-75px;">
                            <header class="w3-round w3-container w3-deep-purple w3-text-white">
                                <h6 class="w3-left"><?php echo $task->task_title; ?></h6>
                                <span onclick="document.getElementById('admin<?php echo $task->task_id; ?>').style.display='none'" class="w3-button w3-display-topright w3-round">&times;</span>
                            </header>
                                <iframe height="675" width="600" style="border:none;" src="./userfunctions/jobs/task-admin.php?task_id=<?php echo $task->task_id; ?>"></iframe>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <div class="w3-container w3-white w3-round w3-border w3-margin-bottom w3-margin-right" style="font-size:small">
        <header class="w3-round w3-container w3-green" style="margin-left:-17px; margin-right:-17px">
            <h6> Finished</h6>
        </header>
        <table class="w3-table w3-bordered w3-hoverable">
            <thead>
                <tr>
                <!--  <th>ID</th>-->
                    <th style="width:fit-content">Status</th>
                    <th>Title</th>
                    <th>Instructions</th>
                    <th>Created</th>
                    <th>Deadline</th>
                    <th>Update</th>
                    <th class="<?php if ($admin_form_disabled == "disabled") {
                                        echo "w3-hide";
                                    } ?>">Data/Users</th>
                    <th>Archive</th>
                </tr>
            </thead>
            <tbody>
                <!-- While Loop to Generate Rows of Tasks -->
                <?php while ($task = mysqli_fetch_object($done)) { ?>
                    <tr>
                        <!-- Keep the same -->
                        <!--  <td><?php //echo $task->task_id; ?></td> -->

                        <td style="width:100px">
                            <?php if ($task->task_status == 1) : ?>
                                <span class="has-text-success">Approved</span>
                            <?php elseif ($task->task_status == 2) : ?>
                                <span>In-Progress</span>
                            <?php elseif ($task->task_status == 3) : ?>
                                <span class="has-text-danger">Archived</span>
                            <?php endif; ?>
                        </td>
                        <!-- Get title -->
                        <td style="width:150px"><?php echo $task->task_title; ?></td>
                        <!-- Keep the same -->
                        <td><?php echo $task->task_instructions; ?></td>
                        <!-- Keep the same -->
                        <td><?php echo $task->task_deadline; ?></td>
                        <!-- Keep the same -->
                        <td><?php echo $task->task_created; ?></td>
                        <!-- Keep the same -->
                        <td>
                            <a class="<?php if ($task->task_status == 1 || $task->task_status == 3) {
                                            echo "";
                                        } ?>"><button class="w3-btn w3-green w3-round" onclick="document.getElementById('id<?php echo $task->task_id; ?>').style.display='block'">Details</button></a>
                        </td>
                        <td class="<?php if ($admin_form_disabled == "disabled") {
                                        echo "w3-hide";
                                    } ?>">
                            <a><button onclick="document.getElementById('ad<?php echo $task->task_id; ?>').style.display='block'" class="w3-btn w3-blue w3-round">Assign</button></a>
                        </td>
                        <td>
                            <a class="<?php if ($task->task_status == 3) {
                                            echo "w3-hide";
                                        } ?>" href="./dashboard.php?content=jobsteplist&task_id=<?php echo $task->task_id; ?>&change_status=4"><button class="w3-btn w3-red w3-round">Archive</button></a>
                        </td>
                    </tr>
                    <div id="id<?php echo $task->task_id; ?>" class="w3-modal">
                    <div class="w3-modal-content w3-center w3-round-large w3-card-4" style="width:600px; margin-top:-75px;">
                            <header class="w3-round w3-container w3-green">
                                <h6 class="w3-left"><?php echo $task->task_title; ?></h6>
                                <span onclick="document.getElementById('id<?php echo $task->task_id; ?>').style.display='none'" class="w3-button w3-display-topright w3-round">&times;</span>
                            </header>
                            <iframe height="675" width="600" style="border:none;" src="./userfunctions/jobs/view-one-task.php?task_id=<?php echo $task->task_id; ?>"></iframe>
                        </div>
                    </div>
                    <div id="ad<?php echo $task->task_id; ?>" class="w3-modal">
                    <div class="w3-modal-content w3-center w3-round-large w3-card-4" style="width:600px; margin-top:-75px;">
                            <header class="w3-round w3-container w3-blue">
                                <h6 class="w3-left"><?php echo $task->task_title; ?></h6>
                                <span onclick="document.getElementById('ad<?php echo $task->task_id; ?>').style.display='none'" class="w3-button w3-display-topright w3-round">&times;</span>
                            </header>
                                <iframe height="676" width="600" style="border:none;" src="./userfunctions/jobs/task-admin.php?task_id=<?php echo $task->task_id; ?>"></iframe>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </tbody>
        </table>
    </div>

   


</body>

</html>