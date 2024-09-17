<?php
    //If this field is set then the user submitted the form to start the workflow.
    if(isset($_POST['supervisorSubmit'])) {
        //First we gather all the input field information.
        $WF_ID = mysqli_real_escape_string($db_conn, $_SESSION['WF_ID']);
        $user_id = $_SESSION['user_id'];
        $outcome1 = mysqli_real_escape_string($_POST['student_outcomes']);
    

        //This creates an entry for the student's information in the database attached with the workflow ID.
        $sql = "INSERT INTO s21_supervisor_form (WF_ID, student_outcomes ) 
            VALUES ('$WF_ID','$outcome1')";
        
        $update_status_sql = "UPDATE s21_active_workflow_status SET supervisor_status = 1 WHERE WF_ID='$WF_ID' ";
        $query = mysqli_query($db_conn, $new_form_sql);
        if ($query) {
            $query = mysqli_query($db_conn, $update_status_sql);

            if ($query) {
                echo("<div class='w3-card w3-green w3-margin w3-padding'>Supervisor Information Successfully Updated.</div>");
            } else  {
                echo("<div class='w3-card w3-red w3-margin w3-padding'> Supervisor Information Update Unsuccessful .</div>");              
            }
        } 
        else {
            echo("<div class='w3-card w3-red'>Error. Supervisor Information Update Unsuccessful .</div>");
        }
    }
    //If this field is set then the user came here from their list of active workflows.
    else if(isset($_POST['WF_ID'])) {
        $workflowID = $_POST['WF_ID'];
    } 
    else {
        $WF_ID = $_SESSION['WF_ID'];
        $sql = "SELECT * FROM s21_supervisor_form WHERE WF_ID = '$WF_ID'";
        $result = mysqli_query($db_conn, $sql);

        $row = mysqli_fetch_array($result);
        $state = 'required';

        if ($_SESSION['user_type'] != 9) {
        //$row = array_map(function($item) { return ""; }, $row);
        $state = "disabled";
        }
    }
?>

<!-- Instructor Form -->
<div id="userForm" class="w3-card-4 w3-padding w3-margin">
    <h4>Supervisor Form</h4>
    <form name="supervisorForm" method="post" action="./dashboard.php?content=create&contentType=app">
        <h5>Learning Outcomes</h5>
        <br>
        <label class="w3-input" for="outcome1">
            1.) What are the student learning outcomes?<br>
            2.) If applicable, include any reading material and/or assignments.
        </label>
        <input type="text" class="w3-input" name="outcome1" id="outcome1" <?php echo("$state placeholder = '{$row['student_outcomes']}'"); ?>></input>
        <br>
        <?php
            if(isset($_GET['content']) && $_GET['content'] = 'view') {
                echo("<button type='submit' name='supervisorSubmit' class='w3-button w3-blue'>Submit</button>");
            }
            else {
                echo("<button type='submit' name='supervisorSubmit' class='w3-button w3-blue'>Submit</button>");
            }
        ?>            
    </form>
</div>