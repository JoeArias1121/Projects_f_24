<?php
// Initialize the session
if (!isset($_SESSION)) {
    session_start();
}
include_once('../../../../backend/db_connector.php');

// get taskTemplate_id from $_GET from view-one-task.php
if (!empty($_GET["taskTemplate_id"])) {
    $current_taskTemplate_id = trim($_GET["taskTemplate_id"]);
}

// NEW ADD data item. For the first data item, update column. Second data item, duplicate and update rows

if ((isset($_GET['add_dataType_id']) && isset($_GET['taskTemplate_id']))) {
    $current_taskTemplate_id = $_GET["taskTemplate_id"];
    $dataType_id = $_GET['add_dataType_id'];

    // see if this is the first data item. if it is, then updating the column is the only thing needed
    $check_first_data = mysqli_query($db_conn, 'SELECT DISTINCT COUNT(dataType_id) as count FROM f23_StepTemplateDetails_T WHERE NOT dataType_id = 0' . ' AND taskTemplate_id = ' . $current_taskTemplate_id);
    $data_count = $check_first_data->fetch_assoc();

    if ($data_count['count'] != 0) {
        // this means that there is a data item already for this task. In this case, we duplicate the rows and change the data column


        $duplicate_rows_add_new_data_sql = 'INSERT INTO f23_StepTemplateDetails_T (taskTemplate_id, user_type, dataType_id) SELECT DISTINCT ?, user_type, ? FROM f23_StepTemplateDetails_T WHERE taskTemplate_id = ?';
        if ($stmt = mysqli_prepare($db_conn, $duplicate_rows_add_new_data_sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "iii", $par1, $par3, $par4);

            $par1 = $current_taskTemplate_id;
            $par3 = $dataType_id;
            $par4 = $current_taskTemplate_id;

            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }
    } else {
        // there are no data items yet, so this is the first one. No need to duplicate, just update data column
        $update_rows_with_data_sql = 'UPDATE f23_StepTemplateDetails_T SET dataType_id = ? WHERE taskTemplate_id = ?';
        if ($stmt = mysqli_prepare($db_conn, $update_rows_with_data_sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ii", $par1, $par2);

            $par1 = $dataType_id;
            $par2 = $current_taskTemplate_id;

            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }
    }
}

// NEW REMOVE data item and REMOVE the rows associated with that data item
if ((isset($_GET['delete_dataType_id']) && isset($_GET['taskTemplate_id']))) {
    $current_taskTemplate_id = $_GET["taskTemplate_id"];
    $dataType_id = $_GET['delete_dataType_id'];


    $delete_rows_with_data_sql = 'DELETE FROM f23_StepTemplateDetails_T WHERE dataType_id = ? AND taskTemplate_id = ?';
    if ($stmt = mysqli_prepare($db_conn, $delete_rows_with_data_sql)) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "ii", $par1, $par2);

        $par1 = $dataType_id;
        $par2 = $current_taskTemplate_id;

        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
}

// Remove a row from taskTemplateDetails
if (isset($_GET['delete_user'])) {
    $delete_this_user = $_GET['delete_user'];
    $delete_this_data = $_GET['dataType_id'];

    $remove_row_from_taskTemplateDetails = 'DELETE FROM f23_StepTemplateDetails_T WHERE taskTemplate_id = ? AND userRole_id = ? AND dataType_id = ?';
    if ($stmt = mysqli_prepare($db_conn, $remove_row_from_taskTemplateDetails)) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "iii", $par1, $par2, $par3);

        $par1 = $current_taskTemplate_id;
        $par2 = $delete_this_user;
        $par3 = $delete_this_data;

        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
}

// Add user to taskTemplateDetails_T
if (isset($_GET['taskTemplate_id']) && isset($_GET['add_user_type'])) {
    $current_taskTemplate_id = $_GET['taskTemplate_id'];
    $add_user_type = $_GET['add_user_type'];


    // Check to see if there are any data items first
    $add_user_data_row = mysqli_query($db_conn, 'SELECT DISTINCT COUNT(dataType_id) as count FROM f23_StepTemplateDetails_T WHERE NOT dataType_id = 0 AND taskTemplate_id = ' . $current_taskTemplate_id);
    $data_count = $add_user_data_row->fetch_assoc();


    if ($data_count['count'] != 0) {
        // There is already a data item associated with this task template. Use subquery to insert multiple rows
        $add_user_with_data_sql = 'INSERT INTO f23_StepTemplateDetails_T (taskTemplate_id, userRole_id, dataType_id) SELECT DISTINCT ?, ?, dataType_id FROM f23_StepTemplateDetails_T WHERE taskTemplate_id = ?';
        if ($stmt = mysqli_prepare($db_conn, $add_user_with_data_sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "iii", $par1, $par2, $par3);

            $par1 = $current_taskTemplate_id;
            $par2 = $add_user_type;
            // the status should be hard-coded to be in-progress upon creation
            //$par3 = 0;
            $par3 = $current_taskTemplate_id;

            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }
        echo "Data item";
    } else {
        // There are no data items associated with this task template. Insert a 0 instead
        $add_user_no_data_sql = 'INSERT INTO f23_StepTemplateDetails_T(taskTemplate_id, userRole_id, dataType_id) VALUES (?,?,?)';
        if ($stmt = mysqli_prepare($db_conn, $add_user_no_data_sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "iii", $par1, $par2, $par3);

            $par1 = $current_taskTemplate_id;
            $par2 = $add_user_type;
            $par3 = 0;


            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }
        else
        echo "No Insert";
        
    }
}

// view all taskDetails for this task template
$taskTemplateDetails_results = mysqli_query($db_conn, 'SELECT * FROM f23_StepTemplateDetails_T WHERE taskTemplate_id = ' . $current_taskTemplate_id);

// view distinct data items for this task template
$taskTemplateDetails_data_results = mysqli_query($db_conn, 'SELECT DISTINCT dataType_id FROM f23_StepTemplateDetails_T WHERE taskTemplate_id = ' . $current_taskTemplate_id);


// task template results
$userRole_T_results = mysqli_query($db_conn, 'SELECT * FROM f23_User_Role_Table');
$userRole_IDs = mysqli_query($db_conn, 'SELECT f23_User_Role_Table.URID FROM f23_User_Role_Table LEFT JOIN f23_StepTemplateDetails_T ON f23_User_Role_Table.URID = f23_StepTemplateDetails_T.userRole_id');


?>


<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Step Template Admin Panel</title>
</head>
<style>
    body {
        font-family: "Raleway", sans-serif;
        font-size: small
    }
</style>

<body>
<div class="w3-center w3-padding-top-24">
            <a href="./view-one-task-template.php?taskTemplate_id=<?php echo $current_taskTemplate_id; ?>">
                <button class="w3-button w3-blue w3-round-large">Return to Step Template</button>
            </a>
        </div>
        <br>
    <div class="w3-container w3-round-large">
        <table class="w3-table-all">
            <tr>
                <th>User Types</th>
                <th>Remove</th>
            </tr>

            <?php while ($taskTemplateDetails = mysqli_fetch_object($taskTemplateDetails_results)) { ?>
                <tr>
                    <td><span class="content w3-hide"><?php echo $taskTemplateDetails->userRole_id; ?></span>
                        <?php if ($taskTemplateDetails->userRole_id == 1) : ?>
                            <span><strong> Admin</span></strong>
                        <?php elseif ($taskTemplateDetails->userRole_id == 2) : ?>
                            <span><strong> Supervisor</span></strong>
                        <?php elseif ($taskTemplateDetails->userRole_id == 3) : ?>
                            <span><strong> Employee</span></strong>
                        <?php elseif ($taskTemplateDetails->userRole_id == 4) : ?>
                            <span><strong> Customer</span></strong>
                        <?php elseif ($taskTemplateDetails->userRole_id == 5) : ?>
                            <span><strong> Company Head</span></strong>
                        <?php else : ?>
                            <span><strong> Any</span></strong>
                        <?php endif; ?>
                    </td>
                    <td> <a href="./template-admin.php?taskTemplate_id=<?php echo $current_taskTemplate_id; ?>&delete_user=<?php echo $taskTemplateDetails->userRole_id; ?>&dataType_id=<?php echo $taskTemplateDetails->dataType_id; ?>">
                            <button class="w3-button w3-round-large w3-red">-</button>
                        </a></td>
                </tr>
            <?php } ?>
        </table>

        <!-- Add new row w3-bar -->
        <div class="w3-bar">
            <!-- Add Button -->
            <div class="w3-bar-item">
                <div>
                    <button class="w3-button w3-round-large w3-green" id="add-user-btn">+</button>
                    </a>
                </div>
            </div>
            <!-- Text -->
            <div class="w3-bar-item">
                <div>
                    <p class="content">Add A User Type</p>
                </div>
            </div>
            <!-- Empty w3-bar Item for spacing -->
            <div class="w3-bar-item">
                <div></div>
            </div>
        </div>
        <!-- Hidden Form to Add a Row -->
        <div class="notification w3-hide" id="add-user-form">
            <form action="./template-admin.php" method="GET">

                <!--Select Option-->
                <label for="add_user_type">Select A User Type</label>
                <br>
                <div class="">
                    <div class="select">
                        <select name="add_user_type" id="add_user_type" class="w3-select w3-border w3-round-large">
                            <?php while ($UserRoles = mysqli_fetch_object($userRole_T_results)) { ?>

                                <option value="<?php echo $UserRoles->URID; ?>">
                                    <?php echo $UserRoles->user_role_title; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <br>

                <!-- Hidden field to perserve taskTemplate_id upon submit -->
                <input type="hidden" name="taskTemplate_id" value="<?php echo $current_taskTemplate_id; ?>">

                <!-- Submit Button-->
                <div class="">
                    <div class="">
                        <button type="submit" class="w3-button w3-round-large w3-blue">Submit</button>
                    </div>
                </div>

            </form>
        </div>
        <!-- DATA ITEM SECTION -->
        <hr>
        <table class="w3-table-all w3-round-large">
            <tr>
                <th>Data Items</th>
                <th>Remove</th>
            </tr>

            <?php while($taskTemplateDetails = mysqli_fetch_object($taskTemplateDetails_data_results) )  { ?>
                <tr>

                    <td><span class="content w3-hide"><?php echo $taskTemplateDetails->dataType_id; ?></span>
                        <?php if ($taskTemplateDetails->dataType_id == 1) : ?>
                            <span><strong> Any</span></strong>
                        <?php elseif ($taskTemplateDetails->dataType_id == 2) : ?>
                            <span><strong> Self</span></strong>
                        <?php elseif ($taskTemplateDetails->dataType_id == 3) : ?>
                            <span><strong> Other</span></strong>
                        <?php elseif ($taskTemplateDetails->dataType_id == 4) : ?>
                            <span><strong> Form</span></strong>
                        <?php elseif ($taskTemplateDetails->dataType_id == 5) : ?>
                            <span><strong> File</span></strong>
                        <?php elseif ($taskTemplateDetails->dataType_id == 6) : ?>
                            <span><strong> Database</span></strong>
                        <?php elseif ($taskTemplateDetails->dataType_id == 7) : ?>
                            <span><strong> MessageSender</span></strong>
                        <?php elseif ($taskTemplateDetails->dataType_id == 8) : ?>
                            <span><strong> Step</span></strong>
                        <?php else : ?>
                            <span><strong> Please Assign a Data Type</span></strong>
                        <?php endif; ?>
                    </td>
                    <td> <a href="./template-admin.php?taskTemplate_id=<?php echo $current_taskTemplate_id ?>&delete_dataType_id=<?php echo $taskTemplateDetails->dataType_id; ?>">
                            <button class="w3-button w3-round-large w3-red">-</button>
                        </a></td>
                </tr>
            <?php } ?>
        </table>


        <!-- Add new row w3-bar -->
        <div class="w3-bar">
            <!-- Add Button -->
            <div class="w3-bar-item">
                <div>
                    <button class="w3-button w3-round-large w3-green" id="add-data-btn">+</button>
                </div>
            </div>
            <!-- Text -->
            <div class="w3-bar-item">
                <div>
                    <p class="content">Add A Data Item</p>
                </div>
            </div>
            <!-- Empty w3-bar Item for spacing -->
            <div class="w3-bar-item">
                <div></div>
            </div>
        </div>
        <div class="notification w3-hide" id="add-data-form">
            <form action="./template-admin.php" method="GET">
                <label for="add_dataType_id">Select A Data Type</label>
                <br>
                <div class="control">
                    <div class="select">
                        <select name="add_dataType_id" id="add_dataType_id" class="w3-select w3-border w3-round-large">
                            <!-- <option value="001">Any</option>
                                        <option value="002">Self</option>
                                        <option value="003">Other</option> -->
                            <option value="004">Form</option>
                            <option value="005">File</option>
                            <!--<option value="006">Database</option>
                                        <option value="007">MessageSender</option>
                                        <option value="008">Task</option>
                                        <option value="009">Job</option>-->
                        </select>
                    </div>
                </div>
                <br>

                <!-- Hidden field to perserve task_id upon submit -->
                <input type="hidden" name="taskTemplate_id" value="<?php echo $current_taskTemplate_id; ?>">

                <!-- Submit Button -->
                <div class="">
                    <div class="">
                        <button type="submit" class="w3-button w3-round-large w3-blue">Submit</button>
                    </div>
                </div>

            </form>
        </div>
        <hr>
       
    </div>
    <br>
</body>
<script>
    // first form - add user row
    addRowBtn = document.getElementById("add-user-btn");
    addRowForm = document.getElementById("add-user-form");
    addRowBtn.addEventListener("click", function() {
        addRowForm.classList.toggle("w3-hide");
    });
    // second form - add data item
    addDataBtn = document.getElementById("add-data-btn");
    addDataForm = document.getElementById("add-data-form");
    addDataBtn.addEventListener("click", function() {
        addDataForm.classList.toggle("w3-hide");
    });
</script>

</html>