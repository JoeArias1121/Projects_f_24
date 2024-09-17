<?php
// Initialize the session
if (!isset($_SESSION)) {
    session_start();
}
include_once('../../../../backend/db_connector.php');
include_once('../../../../backend/contentRouter.php'); 

// get task_id from $_GET from view-one-task.php
if( !empty($_GET["task_id"]) ) {
    $current_task_id = trim( $_GET["task_id"] );
}


// if (isset($_POST['add-data-btn2'])) {
// 		$insert = document.getElementbyId('dropdown1');
// 			echo '<table id="table2" class="w3-table-all w3-round-large">';

//                     echo '<tr>';
//                     echo '<td>'. $insert .'</td>';
//                     echo '</tr>';
// 		echo '</table>';
// }

// ADD data item. For the first data item, update column. Second data item, duplicate and update rows
if(isset($_GET['add_data_id']) && isset($_GET['task_id'])) {
    $current_task_id = $_GET["task_id"];
    $data_id = $_GET['add_data_id'];

    // see if this is the first data item. if it is, then updating the column is the only thing needed
    $check_first_data = mysqli_query($db_conn, 'SELECT DISTINCT COUNT(data_id) as count FROM f23_StepDetails_T WHERE NOT data_id = 0 AND task_id = ' . $current_task_id);
    $data_count = $check_first_data->fetch_assoc();

    if ($data_count['count'] != 0) {
        // this means that there is a data item already for this task. In this case, we duplicate the rows and change the data column

        // $test_sql = 'INSERT INTO taskDetails_T (task_id, user_id, data_id, taskPart_status) SELECT DISTINCT ' . $current_task_id . ', ' . $_SESSION['UID'] . ', ' .  $data_id . ', 0 FROM taskDetails_T WHERE task_id = ' . $current_task_id;
        // mysqli_query($db_conn, $test_sql);

        $duplicate_rows_add_new_data_sql = 'INSERT INTO f23_StepDetails_T (task_id, user_id, data_id, taskPart_status) SELECT DISTINCT ?, user_id, ?, 0, ? FROM f23_StepDetails_T WHERE task_id = ?';
        if($stmt = mysqli_prepare($db_conn, $duplicate_rows_add_new_data_sql) ) {
           // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "iiii", $par1, $par3, $par4); 

            $par1 = $current_task_id;
            $par3 = $data_id;
            $par4 = $current_task_id;

            mysqli_stmt_execute($stmt);        
            mysqli_stmt_close($stmt);
        }
    } else {
        // there are no data items yet, so this is the first one. No need to duplicate, just update data column
        $update_rows_with_data_sql = 'UPDATE f23_StepDetails_T SET data_id = ? WHERE task_id = ?';
        if($stmt = mysqli_prepare($db_conn, $update_rows_with_data_sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ii", $par1, $par2 );
            
            $par1 = $data_id;
            $par2 = $current_task_id; 

            mysqli_stmt_execute($stmt);        
            mysqli_stmt_close($stmt);
        }
    }

}

// REMOVE data item and REMOVE the rows associated with that data item
if((isset($_GET['delete_data_id']) && isset($_GET['task_id']))) {
    $current_task_id = $_GET["task_id"];
    $data_id = $_GET['delete_data_id'];

    $delete_rows_with_data_sql = 'DELETE FROM f23_StepDetails_T WHERE data_id = ? AND task_id = ?';
    if($stmt = mysqli_prepare($db_conn, $delete_rows_with_data_sql)) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "ii", $par1, $par2);
        
        $par1 = $data_id;
        $par2 = $current_task_id; 

        mysqli_stmt_execute($stmt);        
        mysqli_stmt_close($stmt);
    }
}

// Remove a row from taskDetails
if(isset($_GET['delete_user'])) {
    $delete_this_user = $_GET['delete_user'];
    $delete_this_data = $_GET['data_id'];

    $remove_row_from_taskDetails = 'DELETE FROM f23_StepDetails_T WHERE task_id = ? AND user_id = ? AND data_id = ?';
    if($stmt = mysqli_prepare($db_conn, $remove_row_from_taskDetails)) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "iii", $par1, $par2, $par3);
        
        $par1 = $current_task_id;
        $par2 = $delete_this_user;
        $par3 = $delete_this_data; 

        mysqli_stmt_execute($stmt);        
        mysqli_stmt_close($stmt);
    }
}

// Add user to taskDetails_T (TWO CASES - one without data the other with data)
if(isset($_GET['task_id']) && isset($_GET['add_user_id'])) {
    $current_task_id = $_GET['task_id'];
    $add_user_id = $_GET['add_user_id'];

    // Check to see if there are any data items first
    $add_user_data_row = mysqli_query($db_conn, 'SELECT DISTINCT COUNT(data_id) as count FROM f23_StepDetails_T WHERE NOT data_id = 0 AND task_id = ' . $current_task_id);
    $data_count = $add_user_data_row->fetch_assoc();

    if ($data_count['count'] != 0) {
        // There is already a data item associated with this task. Use subquery to insert multiple rows
        $add_user_with_data_sql = 'INSERT INTO f23_StepDetails_T (task_id, user_id, data_id, taskPart_status) SELECT DISTINCT ?, ?, data_id, ? FROM f23_StepDetails_T WHERE task_id = ?';
        if($stmt = mysqli_prepare($db_conn, $add_user_with_data_sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "iiii", $par1, $par2, $par3, $par4);
            
            $par1 = $current_task_id;
            $par2 = $add_user_id; 
            // the status should be hard-coded to be in-progress upon creation
            $par3 = $add_user_data_row['data_id'];
            $par4 = 0;
    
            mysqli_stmt_execute($stmt);        
            mysqli_stmt_close($stmt);
        }
    } else {
        // There are no data items associated with this task. Insert a 0 instead
        $add_user_no_data_sql = 'INSERT INTO f23_StepDetails_T(task_id, user_id, data_id, taskPart_status) VALUES (?,?,?,?)';
        if($stmt = mysqli_prepare($db_conn, $add_user_no_data_sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "iiii", $par1, $par2, $par3, $par4);
            
            $par1 = $current_task_id;
            $par2 = $add_user_id; 
            $par3 = 0;
            $par4 = 0;

            mysqli_stmt_execute($stmt);        
            mysqli_stmt_close($stmt);
        }
    }

}


// view all taskDetails for this task
$taskDetails_results = mysqli_query($db_conn, 'SELECT * FROM f23_StepDetails_T WHERE task_id = ' . $current_task_id);

// view distinct data items for this task
$taskDetails_data_results = mysqli_query($db_conn, 'SELECT DISTINCT data_id FROM f23_StepDetails_T WHERE task_id = ' . $current_task_id);

// view data items from data_T for this task
$data_results = mysqli_query($db_conn, 'SELECT * FROM f23_data_T WHERE dataType_id = 1 OR dataType_id = 2');

//$form_results = mysqli_query($db_conn, 'SELECT * FROM s21_form_templates');
// view users to assign to tasks
$user_results = mysqli_query($db_conn, 'SELECT * FROM f23_User_Table');
$users = mysqli_query($db_conn, 'SELECT f23_User_Table.user_name, f23_User_Table.UID FROM f23_User_Table INNER JOIN f23_StepDetails_T ON f23_User_Table.UID = f23_StepDetails_T.user_id AND task_id = ' . $current_task_id);

?>

//<script>
	function addtoTable() {
	//<?php
	//$sql = "INSERT INTO `f22_table_display`(`FormName`) VALUES ('tester1')";
	//$result = mysqli_query($db_conn, $sql);

	//if ($result) {
            
      //  echo("<div class='w3-card w3-green w3-margin w3-padding'>Successfully Created a New Form.</div>");
    //}       
	//else {
         //   echo("<div class='w3-card w3-red w3-margin w3-padding'> Error Creating New Form.</div>");
   // }
	//?>
	//}

//</script>



<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Step Admin</title>
</head>
<style>
    body {
        font-family: "Raleway", sans-serif;
        font-size: small
    }
</style>

<body>

    <section>

        <div class="w3-center w3-padding-top-24">
            <a href="./view-one-task.php?task_id=<?php echo $current_task_id; ?>">
                <button class="w3-button w3-blue w3-round-large">Return to Step Overview</button>
            </a>
        </div>
        <br>
    </section>
    <hr>
    <div class="w3-container w3-round-large">
        <!-- The first w3-bar is for the headings -->

        <table class="w3-table-all w3-round-large">
            <tr>
                <th style="width:80px">User ID</th>
                <th style="width:120px">User Name</th>
                <th style="width:120px">Work Status</th>
                <th style="width:80px">Data ID</th>
                <th style="width:80px">Remove</th>
            </tr>

            <?php while ($taskDetails = mysqli_fetch_object($taskDetails_results)) { ?>
                <tr>
                    <?php $usersName = mysqli_fetch_object($users) ?>
                    <td><?php echo $usersName->UID; ?></td>
                    <td><?php echo $usersName->user_name; ?></td>
                    <td><?php if ($taskDetails->taskPart_status == 0) : ?>
                            <span>In-Progress</span>
                        <?php elseif ($taskDetails->taskPart_status == 1) : ?>
                            <span>Completed</span>
                        <?php else : ?>
                            <span>Rejected</span>
                        <?php endif; ?>
                    </td>
                    <td><?php echo $taskDetails->data_id; ?></td>
                    <td> <a href="./task-admin.php?task_id=<?php echo $current_task_id; ?>&delete_user=<?php echo $taskDetails->user_id; ?>&data_id=<?php echo $taskDetails->data_id; ?>">
                            <button class="w3-button w3-red w3-round-large">-</button>
                        </a></td>
                </tr>
            <?php } ?>
        </table>

        <hr>
        <!-- Add new row w3-bar -->
        <div class="w3-bar">
            <!-- Add Button -->
            <div class="w3-bar-item">
                <div>
                    <button id="add-user-btn" class="w3-button w3-green w3-round-large">+</button>
                </div>
            </div>
            <!-- Text -->
            <div class="w3-bar-item">
                <div>
                    <h6 class="content">Add New User</h6>
                </div>
            </div>
            <!-- Empty w3-bar Item for spacing -->
            <div class="w3-bar-item">
                <div></div>
            </div>
        </div>

        <!-- Hidden Form to Add a Row -->
        <div class="notification w3-hide" id="add-user-form">
            <form action="./task-admin.php" method="GET">

                <!--Select Option-->
                <label for="add_user_id">Select A User</label>
                <br>
                <div class="control">
                    <div class="select">
                        <select name="add_user_id" id="add_user_id" class="w3-select w3-border w3-round-large">
                            <?php while ($user = mysqli_fetch_object($user_results)) { ?>
                                <option value="<?php echo $user->UID?>"><?php echo $user->user_name; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <br>

                <!-- Hidden field to perserve task_id upon submit -->
                <input type="hidden" name="task_id" value="<?php echo $current_task_id; ?>">

                <!-- Submit Button -->
                <div class="">
                    <div class="">
                        <button type="submit" class="w3-button w3-blue w3-round-large">Submit</button>
                    </div>
                </div>

            </form>
        </div>
        <!-- DATA ITEM SECTION -->
        <hr>

        <table id="workflowTable" class="pagination w3-margin-top w3-table-all w3-responsive w3-content" data-pagecount="6" style="max-width:fit-content;">
        <tr>
            <th>Form Title</th>
            <th>Responsible</th>
            <th></th>
        </tr>

        <?php
            $sql = "SELECT * FROM f23_Form_Templates";

            $query = mysqli_query($db_conn, $sql);
            
            while ($row = mysqli_fetch_array($query)) {
                $TID = $row['TID'];
                $title = $row['title'];
                $instructions = $row['instructions'];
                $user_access_role = $row['user_access_role'];
                $created = $row['created'];
                $changed = $row['changed'];
        ?>
        <tr>
            
            <td><?php echo $title; ?></td>
          
            <td><?php if($user_access_role == 4) echo "Dean";
                            elseif($user_access_role == 1) echo "Administrator";
                            elseif($user_access_role == 8) echo "Student";
                            elseif($user_access_role == 6) echo "Secretary";
                            elseif($user_access_role == 5) echo "Chair"; ?></td>
            <td><?php echo $created; ?></td>
            <td><?php echo $changed; ?></td>
            <td>
                <form method="post" action="../../dashboard.php?content=forms&contentType=viewForm" target="_blank">
                    <input type="hidden" name="TID" value="<?php echo $TID;?>">
                    <button type="submit" name="viewForm" class="w3-button w3-blue w3-round-large">View</button>
                </form>
            </td>
        </tr>
        <?php } ?>
    </table>

        <hr>
        <!-- Add new row w3-bar -->
        <div class="w3-bar">
            <!-- Add Button -->
            <div class="w3-bar-item">
               </div>
            <!-- Text -->
            <div class="w3-bar-item">
                <div>
                </div>
            </div>
            <!-- Empty w3-bar Item for spacing -->
            <div class="w3-bar-item">
                <div></div>
            </div>
        </div>

        <div class="notification w3-hide" id="add-data-form">
            <form action="./task-admin.php" method="GET">

                <!--Select Option-->
                <!-- <label for="add_form_id">Select A Form</label>
                <br>
                <div class="">
                    <div class="select">
                        <select name="add_form_id" id="add_form_id" class="w3-select w3-border w3-round-large">
                            <?php while ($form = mysqli_fetch_object($form_results)) { ?>
                                <option value="<?php echo $form->TID ?>">
                                    <?php echo $form->title ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <br> -->
                <label for="add_data_id">Select A File</label>
                <br>
                <div class="">
                    <div class="select">
                        <select name="add_data_id" id="add_data_id" class="w3-select w3-round-large w3-border">
                            <?php while ($data = mysqli_fetch_object($data_results)) { ?>
                                <option value="<?php echo $data->data_id ?>">
                                    <?php
                                    echo $data->data;
                                    ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <!-- Hidden field to perserve task_id upon submit -->
                <input type="hidden" name="task_id" value="<?php echo $current_task_id; ?>">
<br>
                <!-- Submit Button -->
                <div class="">
                    <div class="">
                        <button type="submit" class="w3-button w3-blue w3-round-large">Submit</button>
                    </div>
                </div>
                
                <br>

            </form>
        </div>
        <hr>

    </div>

</body>
<script>
    // first form - add user row
    addRowBtn = document.getElementById("add-user-btn");
    addRowForm = document.getElementById("add-user-form");
    addRowBtn.addEventListener("click", function() {
        addRowForm.classList.toggle("w3-show");
    });
    // second form - add data item
    addDataBtn = document.getElementById("add-data-btn");
    addDataForm = document.getElementById("add-data-form");
    addDataBtn.addEventListener("click", function() {
        addDataForm.classList.toggle("w3-show");
    });}
</script>

</html>