<?php
// Initialize the session
if (!isset($_SESSION)) {
  session_start();
}
require '../../../../backend/db_connector.php';

// get task_id from $_GET from view-one-task.php
if (!empty($_GET["job_id"])) {
  $current_job_id = trim($_GET["job_id"]);
}
$lo_query = mysqli_query($db_conn,'SELECT MAX(job_taskOrder) FROM f23_JobDetails_T WHERE job_id ='.$current_job_id);
if ($lo_query){
$orderResult = mysqli_fetch_row($lo_query);
$number = (int)$orderResult[0];
}
else{
$number=0;
}

if (isset($_GET['job_id']) && isset($_GET['task_id2']) && isset($_GET['taskOrderNum'])) {
  $delete_this_jobstask = $_GET['job_id'];
  $delete_this_task = $_GET['task_id2'];
  $deleted_task_order = $_GET['taskOrderNum'];

  $remove_row_from_jobDetails = 'DELETE FROM f23_JobDetails_T WHERE job_id = ? AND task_id = ?';
  if ($stmt = mysqli_prepare($db_conn, $remove_row_from_jobDetails)) {
    // Bind variables to the prepared statement as parameters
    mysqli_stmt_bind_param($stmt, "ii", $par1, $par2);

    $par1 = $delete_this_jobstask;
    $par2 = $delete_this_task;

    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    if ($number>0)
    $number--;
    else 
    $number = (int)$orderResult[0] +1;
  }

  $update_tasks = mysqli_query($db_conn, 'SELECT *  FROM f23_JobDetails_T WHERE job_id =' . $delete_this_jobstask . ' ORDER BY 3');
  $count = 1;
  while ($taskU = mysqli_fetch_object($update_tasks)) {
    $update_row = 'UPDATE f23_JobDetails_T SET job_taskOrder = ? WHERE job_id = ? AND task_id = ?';
    if ($stmt = mysqli_prepare($db_conn, $update_row)) {
      // Bind variables to the prepared statement as parameters
      mysqli_stmt_bind_param($stmt, "iii", $par1, $par2, $par3);
      //Update Order
      if ($count < $deleted_task_order) {
        $par1 = $taskU->job_taskOrder;
      } else {
        if ($taskU->job_taskOrder > 0)
        $par1 = $taskU->job_taskOrder - 1;
        
      }
      $par2 = $taskU->job_id;
      $par3 = $taskU->task_id;
      $count++;

      mysqli_stmt_execute($stmt);
      mysqli_stmt_close($stmt);
    }
  }

}
// Add into table
if (isset($_GET['job_id']) && isset($_GET['task_id']) && isset($_GET['order_num'])) {

  $add_this_jobstask = $_GET['job_id'];
  $add_this_task = $_GET['task_id'];
  $new_order = $_GET['order_num'] +1;
  $number++;

  $add_row_to_jobDetails = 'INSERT INTO f23_JobDetails_T VALUES (?, ?, ?)';
  if ($stmt = mysqli_prepare($db_conn, $add_row_to_jobDetails)) {
    // Bind variables to the prepared statement as parameters
    mysqli_stmt_bind_param($stmt, "iii", $par1, $par2, $par3);

    $par1 = $add_this_jobstask;
    $par2 = $add_this_task;
    $par3 = $new_order;

    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
  }
  
}

// view all taskDetails for this task
$task_results = mysqli_query($db_conn, 'SELECT f23_JobDetails_T.task_id AS task_id, f23_Step_T.task_title AS task_title, f23_JobDetails_T.job_taskOrder AS job_taskOrder FROM f23_JobDetails_T INNER JOIN f23_Step_T ON f23_JobDetails_T.task_id = f23_Step_T.task_id WHERE job_id = ' . $current_job_id . ' ORDER BY job_taskOrder');

//view tasks that are not assigned to a job atm
$task_unassign = mysqli_query($db_conn, 'SELECT f23_Step_T.task_id AS task_id, f23_Step_T.task_title AS task_title, f23_Step_T.task_instructions AS task_instructions FROM f23_Step_T LEFT JOIN f23_JobDetails_T ON f23_JobDetails_T.task_id = f23_Step_T.task_id WHERE f23_JobDetails_T.job_id IS NULL ORDER BY task_id;');

?>



<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <title>Job Admin</title>
</head>
<style>
  body {
    font-family: "Raleway", sans-serif;
    font-size: small
  }
</style>

<body>
  <div class="w3-center w3-padding-top-24">
    <a class="" href="./view-one-job.php?job_id=<?php echo $current_job_id; ?>"><button class="w3-button w3-blue w3-round">Return To Job Overview</button></a>
    
    <div class="w3-bar-item w3-button w3-hover-shadow w3-round-xlarge w3-green" 
         onclick="document.getElementById('id05').style.display='block'">
        <b>New Step</b>
    </div> 

    <div>
      <br>
      <h6>Steps Assigned to Job
        <?php echo $current_job_id ?>
      </h6>
    </div>

    <!-- Table -->

    <table class="w3-table-all">
      <tr>
        <th>Step ID</th>
        <th>Step Title</th>
        <th>Step Order</th>
        <th>Remove</th>
      </tr>
      <?php while ($taskDetails = mysqli_fetch_object($task_results)) { ?>
        <tr>
          <td><?php echo $taskDetails->task_id; ?></td>
          <td><?php echo $taskDetails->task_title; ?></td>
          <td><?php echo $taskDetails->job_taskOrder; ?></td>
          <td><a href="./job-admin.php?job_id=<?php echo $current_job_id; ?>&task_id2=<?php echo $taskDetails->task_id; ?>&taskOrderNum=<?php echo $taskDetails->job_taskOrder; ?>">
              <button class="w3-button w3-red w3-round-large">-</button>
            </a></td>
        </tr>
      <?php } ?>
    </table>



    <hr>
    <div>
      <h6> Add Steps to Job
        <?php echo $current_job_id ?>
      </h6>
    </div>

    <table class="w3-table-all">
      <tr>
        <th>Step ID</th>
        <th>Step Title</th>
        <th>Add To Job</th>
      </tr>
      <?php while ($tasks_unassigned = mysqli_fetch_object($task_unassign)) { ?>
        <tr>
          <td><?php echo $tasks_unassigned->task_id; ?></td>
          <td><?php echo $tasks_unassigned->task_title; ?></td>
          <td><a href="./job-admin.php?job_id=<?php echo $current_job_id; ?>&task_id=<?php echo $tasks_unassigned->task_id; ?>&order_num=<?php echo $number ?>">
              <button class="w3-button w3-blue w3-round-large">+</button>
            </a></td>
        </tr>
      <?php } ?>
    </table>
  </div>
</body>


<div id="id05" class="w3-modal">
    <div class="w3-modal-content w3-center w3-round-large w3-card-4" style="width:400px;margin-top:-65px;">
      <header class="w3-round w3-container w3-green">
        <h6 class="w3-left">Create a Step</h6>
        <a href="./dashboard.php?content=jobsteps" class="w3-button w3-round w3-display-topright">&times;</a>
      </header>
      <iframe class="w3-margin-top" height="625" style="border:none;" src="./create-task.php"></iframe>
    </div>
</div>


</html>
