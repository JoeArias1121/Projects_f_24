<?php
    include_once('../../backend/config.php');
    include_once('../../backend/db_connector.php');
    //Loading the page title and action buttons.
    //include_once('./userfunctions/search/search.php');
?>

<!-- Workflow Search -->
<div id="workflowSearch" class="w3-card w3-white w3-round-large w3-padding w3-margin">
      <button class="w3-button w3-right w3-green w3-round-large" type="button" onclick="document.getElementById('id09').style.display='block'">Create Step</button>
    <div id="id09" class="w3-modal">
    <div class="w3-modal-content w3-center w3-round-large w3-card-4" style="width:400px;margin-top:-65px;">
      <header class="w3-round w3-container w3-green">
        <h6 class="w3-left">Create a Task</h6>
        <a href="./dashboard.php?content=search&contentType=tasks" class="w3-button w3-round w3-display-topright">&times;</a>
      </header>
      <iframe class="w3-margin-top" height="625" style="border:none;" src="./userfunctions/jobs/create-task.php"></iframe>
    </div>
  </div>
    <div class="w3-center">
    <!--  <button  style="margin-left:100px" class="w3-button w3-blue w3-round-large" type="button" onclick="window.location='./dashboard.php?content=search&contentType=jobs'">Job Search</button>-->
    <h5>Search Steps</h5>
    <p>You may search by any field in the table.</p>
    <input style="width:300px" class="w3-round-large" id="workflowInput" type="text" onkeyup="search('workflowTable', 'workflowInput')">
    </div>
    <table id="workflowTable" class="pagination w3-table-all w3-responsive w3-content w3-round-large" data-pagecount="8" style="max-width:fit-content;">
        <tr class="w3-sand">
            <?php if ($_SESSION['user_type'] == 1){ ?>
            <th>ID</th><?php }?>
            <th>Title</th>
            <th>Status</th>
            <th>Owner</th>
            <th>Instructions</th>
            <th>Created</th>
            <th>Deadline</th>
            <th>Actions</th>
        </tr>

        <?php
        if ($_SESSION['user_type'] == 1) 
            $query = mysqli_query($db_conn, 'SELECT * FROM f23_Step_T');
         else 
            // view all tasks where the SESSION user is task_owner
            $query = mysqli_query($db_conn, 'SELECT * FROM f23_Step_T AS t INNER JOIN f23_StepDetails_T AS td ON t.task_id = td.task_id WHERE td.user_id =' . $_SESSION['user_id'].' OR t.task_owner =' . $_SESSION['user_id']);
            
            while ($row = mysqli_fetch_array($query)) {
                $taskID = $row['task_id'];
                $title = $row['task_title'];
                $status = $row['task_status'];
                $owner = $row['task_owner'];
                $instructions = $row['task_instructions'];
                $created = $row['task_created'];
                $deadline = $row['task_deadline'];
                $ownerQry = mysqli_query($db_conn, 'SELECT user_name FROM f23_User_Table WHERE UID ='.$owner);
                $ownerRow = mysqli_fetch_array($ownerQry);
        ?>
        <tr>
        <?php if ($_SESSION['user_type'] == 1){ ?><td><?php echo $taskID; ?></td><?php }?>
            <td><?php echo $title; ?></td>
            <td><?php echo $status; ?></td>
            <td><?php echo $ownerRow['user_name']; ?></td>
            <td><?php echo $instructions; ?></td>
            <td><?php echo $created; ?></td>
            <td><?php echo $deadline; ?></td>
            <td>
                
                    <input type="hidden" name="workflowID" value="<?php echo $taskID;?>">
                    <button type="submit" name="viewWorkflow" class="w3-button w3-blue w3-round-large" href="./dashboard.php?content=onetask?task_id=<?php echo $taskID; ?>" onclick="document.getElementById('id<?php echo $taskID; ?>').style.display='block'">View</button>
                
            </td>
            <div id="id<?php echo $taskID; ?>" class="w3-modal">
                        <div class="w3-modal-content w3-round-large w3-card-4" style="width:700px; margin-top:-100px;">
                            <header class="w3-round w3-container w3-blue">
                                <h6 class="w3-left"><?php echo $title; ?></h6>
                                <span onclick="document.getElementById('id<?php echo $taskID; ?>').style.display='none'" class="w3-button w3-display-topright">&times;</span>
                            </header>
                            <iframe height="700" width="700" style="border:none;" src="./userfunctions/jobs/view-one-task.php?task_id=<?php echo $taskID; ?>"></iframe>
                        </div>
                    </div>
        </tr>
        <?php } ?>
    </table>
</div>