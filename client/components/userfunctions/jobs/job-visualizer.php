<?php
include_once('../../../../backend/db_connector.php');
include_once('../../../../backend/config.php');


if (!empty($_GET["job_id"])) {
    $current_job_id = trim($_GET["job_id"]);
}


/*
$query = mysqli_query($db_conn, 'SELECT f23_JobDetails_T.task_id, f23_JobDetails_T.job_taskOrder, f23_Step_T.task_status, 
f23_Step_T.task_title, f23_User_Table.UID,f23_User_Table.user_name,f23_StepDetails_T.taskPart_status FROM f23_Job_T 
INNER JOIN f23_JobDetails_T ON f23_Job_T.job_id = f23_JobDetails_T.job_id INNER JOIN f23_Step_T ON f23_JobDetails_T.task_id = 
f23_Step_T.task_id INNER JOIN f23_StepDetails_T ON f23_StepDetails_T.task_id = f23_Step_T.task_id INNER JOIN f23_User_Table 
ON f23_StepDetails_T.user_id = f23_User_Table.UID WHERE f23_Job_T.job_id = ' . $current_job_id . ' ORDER BY f23_JobDetails_T.job_taskOrder');
*/

$sql = "SELECT * FROM f23_JobDetails_T WHERE job_id = '$current_job_id' ";
$result = mysqli_query($db_conn, $sql);
//$row = mysqli_fetch_assoc($result);

?>
<div class="w3-center">
    <h6>Steps: </h6>
    <div class="w3-container w3-content" style="width: 200px">
    <?php 
        while($row_task = mysqli_fetch_assoc($result)){

            //retrieve task id / get full task
            $task_id = $row_task['task_id'];
            $sql2 = "SELECT * FROM f23_Step_T WHERE task_id = '$task_id' ";
            $result2 = mysqli_query($db_conn, $sql2);
            $row = mysqli_fetch_assoc($result2);
                
            if($row['task_status'] != 4){
                if ($row['task_status'] == 2) {
                    $atr = 'w3-blue';
                    $status = 'In-Progress';
                } elseif ($row['task_status'] == 1) {
                    $atr = 'w3-green';
                    $status = 'Complete';
                } elseif ($row['task_status'] == 3) {
                    $atr = 'w3-deep-purple';
                    $status = 'Rejected';
                }
                /*  //not implemented yet
                elseif ($row['task_status'] == 5) {
                    $atr = 'w3-dark-gray';
                    $status = 'Not Started';
                }
                */
            
        ?>
            <a href="./view-one-task.php?task_id=<?php echo $row['task_id']; ?>" style="text-decoration: none;">
                <div class="w3-center w3-card w3-round-large w3-margin-bottom w3-padding w3-hover-shadow <?php echo ($atr); ?>" style="height: 180px; width: 180px;">
                    <div class="w3-white w3-round-large w3-cell w3-cell-middle w3-center" style="height: 150px; width: 150px; padding-top:10px;">
                        <p>Title:<?php echo ($row['task_title']); ?></b>
                        <p>Status: <?php echo ($status); ?>
                    </div>
                </div>
            </a>
        <?php 
            }
        }
        ?>
    </div>

</div>


<script>
    /* function showFormUsers(str) {
       fetch("../../backend/formUtils/displayWFforms.php?q="+str, {
            method:'POST',
             headers: {
            'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
            },
        })
        .then(response => response.text())
        .then(forms => {
            document.getElementById('wf-container').innerHTML = forms;
       
       });
       }*/
</script>

<script>
    /* function displayForm(str, x) {
       fetch("../../backend/formUtils/displayForm.php?q="+str+"&u="+x, {
            method:'POST',
             headers: {
            'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
            },
        })
        .then(response => response.text())
        .then(forms => {
            document.getElementById('form').innerHTML = forms;
       });
       } */
</script>

<script>
    /* function saveFormData() {
       fetch("../../backend/formUtils/saveFormData.php?", {
            method:'POST',
             headers: {
            'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
            },
        })
        .then(response => response.text())
        .then(message => {
            document.getElementById('form').innerHTML = message;
       });
       }    */
</script>