<?php
// Initialize the session
if (!isset($_SESSION)) {
    session_start();
}
include_once('../../backend/db_connector.php');

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

// view all tasks as an admin
    // view all tasks where the SESSION user is task_owner
    $done = mysqli_query($db_conn, 'SELECT * FROM f23_Step_T AS t  WHERE t.task_status = 1 AND t.task_owner =' . $_SESSION['user_id']);
    $reject = mysqli_query($db_conn, 'SELECT * FROM f23_Step_T AS t  WHERE t.task_status = 3 AND t.task_owner =' . $_SESSION['user_id']);
    $active = mysqli_query($db_conn, 'SELECT * FROM f23_Step_T AS t  WHERE ( t.task_status = 2 OR t.task_status = 5 ) AND t.task_owner =' . $_SESSION['user_id']);
    if ($_SESSION['user_type'] == 2) {
        $assign = mysqli_query($db_conn, 'SELECT * FROM f23_Step_T AS t  WHERE t.task_status = 2 AND t.task_owner =' . $_SESSION['user_id']);
    }

?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>View All Tasks</title>
    <style>
        a.disabled {
            pointer-events: none;
        }
    </style>
</head>

<body>
<div class=" w3-text-white w3-orange" style="margin-top:-10px; margin-left:-20px">
        <h3 class="w3-center">
            Assign Tasks
        </h3>
    </div>
    <div class="w3-auto w3-row-padding">
        <div class="w3-third">
            <h5>In-Progress</h5>

            <?php if ($active) while ($task = mysqli_fetch_object($active)) { ?>


                <div class="w3-card w3-round-large w3-margin-bottom">
                    <header class="w3-round w3-container <?php if ($task->task_status == 2) echo 'w3-blue'; else echo 'w3-dark-gray' ?>" >
                        <h6><?php if ($task->task_type == 1){?><b class="w3-text-red" style="margin-right:5px"> <i class="fa fa-exclamation" aria-hidden="true"></i></b><?php }?>
                            <span class=""><?php echo $task->task_title ; ?><?php if ($task->task_type == 1){?><b class="w3-text-red" style="margin-left:5px"> <i class="fa fa-exclamation" aria-hidden="true"></i></b><?php }?></span>
                        </h6>
                    </header>
                    <div class="w3-container w3-padding">
                        <p><?php echo $task->task_instructions; ?></p>
                        <b>Deadline: <time><?php echo $task->task_deadline; ?></time></b>
                    </div>
                    <footer class="">
                        <div class="w3-bar">
                            <button class="w3-button w3-round w3-bar-item w3-padding <?php if ($task->task_status == 3) {
                                                                                            echo "";
                                                                                        } ?>" onclick="document.getElementById('id<?php echo $task->task_id; ?>').style.display='block'">
                                See Details
                            </button>
                            <a href="./dashboard.php?content=tasks&task_id=<?php echo $task->task_id; ?>&change_status=4"><button class="w3-button w3-round ">Archive</button></a>
                        </div>
                    </footer>
                    <div id="id<?php echo $task->task_id; ?>" class="w3-modal">
                        <div class="w3-modal-content w3-center w3-round-large w3-card-4" style="width:600px; margin-top:-85px;">
                            <header class="w3-round w3-container <?php if ($task->task_status == 2) echo 'w3-blue'; else echo 'w3-dark-gray' ?>">
                                <h6 class="w3-left"><?php echo $task->task_title; ?></h6>
                                <span onclick="document.getElementById('id<?php echo $task->task_id; ?>').style.display='none'" class="w3-button w3-display-topright w3-round">&times;</span>
                            </header>
                            <iframe height="675" width="600" style="border:none;" src="./userfunctions/jobs/view-one-task.php?task_id=<?php echo $task->task_id; ?>"></iframe>

                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
        <div class="w3-third">
            <h5>Rejected</h5>
            <?php if ($reject) while ($task = mysqli_fetch_object($reject)) { ?>
                <div class="w3-card w3-round-large w3-margin-bottom">
                    <header class="w3-round w3-container w3-deep-purple w3-text-white">
                        <h6>
                            <span class="is-uppercase"><?php echo $task->task_title; ?></span>
                        </h6>
                    </header>
                    <div class="w3-container w3-padding">
                        <p><?php echo $task->task_instructions; ?></p>
                        <b>Deadline: <time><?php echo $task->task_deadline; ?></time></b>
                    </div>
                    <footer class="">
                        <div class="w3-bar">
                            <button class="w3-button w3-round  w3-bar-item w3-padding <?php if ($task->task_status == 3) {
                                                                                            echo "";
                                                                                        } ?>" onclick="document.getElementById('id<?php echo $task->task_id; ?>').style.display='block'">
                                See Details
                            </button>
                            <a href="./dashboard.php?content=tasks&task_id=<?php echo $task->task_id; ?>&change_status=4"><button class="w3-button w3-round ">Archive</button></a>
                        </div>
                    </footer>
                    <div id="id<?php echo $task->task_id; ?>" class="w3-modal">
                        <div class="w3-modal-content w3-center w3-round-large w3-card-4" style="width:600px; margin-top:-75px;">
                            <header class="w3-round w3-container w3-deep-purple w3-text-white">
                                <h6 class="w3-left"><?php echo $task->task_title; ?></h6>
                                <span onclick="document.getElementById('id<?php echo $task->task_id; ?>').style.display='none'" class="w3-button w3-display-topright w3-round">&times;</span>
                            </header>
                            <iframe height="675" width="600" style="border:none;" src="./userfunctions/jobs/view-one-task.php?task_id=<?php echo $task->task_id; ?>"></iframe>

                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
        <div class="w3-third">
            <h5>Approved</h5>
            <?php if ($done) while ($task = mysqli_fetch_object($done)) { ?>

                <div class="w3-card w3-round-large w3-margin-bottom">
                    <header class="w3-round w3-container w3-green">
                        <h6>
                            <span class="is-uppercase"><?php echo $task->task_title; ?></span>
                        </h6>
                    </header>
                    <div class="w3-container w3-padding">
                        <p><?php echo $task->task_instructions; ?></p>
                        <b>Deadline: <time><?php echo $task->task_deadline; ?></time></b>
                    </div>
                    <footer class="">
                        <div class="w3-bar">
                            <button class="w3-button w3-round  w3-bar-item w3-padding <?php if ($task->task_status == 3) {
                                                                                            echo "w3-hide";
                                                                                        } ?>" onclick="document.getElementById('id<?php echo $task->task_id; ?>').style.display='block'">
                                See Details
                            </button>
                            <a href="./dashboard.php?content=tasks&task_id=<?php echo $task->task_id; ?>&change_status=4"><button class="w3-button w3-round ">Archive</button></a>
                        </div>

                    </footer>
                    <div id="id<?php echo $task->task_id; ?>" class="w3-modal">
                        <div class="w3-modal-content w3-center w3-round-large w3-card-4" style="width:600px; margin-top:-75px;">
                            <header class="w3-round w3-container w3-green">
                                <h6 class="w3-left"><?php echo $task->task_title; ?></h6>
                                <span onclick="document.getElementById('id<?php echo $task->task_id; ?>').style.display='none'" class="w3-button w3-display-topright w3-round">&times;</span>
                            </header>
                            <iframe height="675" width="600" style="border:none;" src="./userfunctions/jobs/view-one-task.php?task_id=<?php echo $task->task_id; ?>"></iframe>

                        </div>
                    </div>
                </div>
            <?php } ?>

        </div>


    </div>

    <br><br>
</body>

</html>