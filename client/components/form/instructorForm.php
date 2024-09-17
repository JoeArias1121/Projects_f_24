<?php
    //If this field is set then the user submitted the form to start the workflow.
    if(isset($_POST['studentSubmit'])) {
        //First we gather all the input field information.
        $WF_ID = mysqli_real_escape_string($db_conn, $_SESSION['WF_ID']);
        $user_id = $_SESSION['user_id'];
        $gradeMethod = mysqli_real_escape_string($_POST['grade_method']);
        $outcomes1 = mysqli_real_escape_string($_POST['outcomes_1']);
        $outcomes2 = mysqli_real_escape_string($_POST['outcomes_2']);

        //This creates an entry for the student's information in the database attached with the workflow ID.
        $new_form_sql = "INSERT INTO s21_instructor_form (WF_ID, grade_method, outcomes_1, outcomes_2) 
            VALUES ('$WF_ID','$gradeMethod', '$outcomes1', '$outcomes2')";
        $update_status_sql = "UPDATE s21_active_workflow_status SET faculty_status = 1 WHERE WF_ID='$WF_ID' ";
        $query = mysqli_query($db_conn, $new_form_sql);
        if ($query) {
            $query = mysqli_query($db_conn, $update_status_sql);

            if ($query) {
                echo("<div class='w3-card w3-green w3-margin w3-padding'>Instructor Information Successfully Updated.</div>");

            } else  {

                echo("<div class='w3-card w3-red w3-margin w3-padding'> Instructor Information Update Unsuccessful .</div>");              
            }
        } 
        else {
            echo("<div class='w3-card w3-red'>Error. Faculty Information Update Unsuccessful .</div>");
        }
        
        

    }
    //If this field is set then the user came here from their list of active workflows.
    else if(isset($_POST['wfID'])) {
        $workflowID = $_POST['wfID'];
    }
    else {
        $WF_ID = $_SESSION['WF_ID'];
        $sql = "SELECT * FROM s21_instructor_form WHERE WF_ID = '$WF_ID'";
        $result = mysqli_query($db_conn, $sql);

        $row = mysqli_fetch_array($result);
        $state = 'required';

        if ($_SESSION['user_type'] != 7) {
        //$row = array_map(function($item) { return ""; }, $row);
        $state = "disabled";
        }
    }
?>

<!-- Instructor Form -->
<div id=userForm class="w3-card-4 w3-padding w3-margin">
    <h4>Instructor Form</h4>
    
    <form name="instructorForm" method="post" action="./dashboard.php?content=create&contentType=app">
        <br>
        <label class="w3-input" for="gradeMethod">Grade Method</label>
        <input name="gradeMethod" class="w3-input" <?php echo("$state placeholder = '{$row['grade_method']}'"); ?> > </input>
        <br>
        <h5>Learning Outcomes</h5>
        <br>
        <label class="w3-input" for="outcomes1">
                1.) What are the student learning outcomes?<br>
                2.) If applicable, include any reading material and/or assignments.
            </label>
            <input type="text" class="w3-input" name="outcomes1" id="outcomes1" <?php echo("$state placeholder = '{$row['outcomes_1']}'");  ?>> </input>
            <br>
            <label class="w3-input" for="outcomes2">
                2.) Explanation of course grading policies and method of determining final grade.
            </label>
            <input type="text" class="w3-input" name="outcomes2" id="outcomes1" <?php echo("$state placeholder = '{$row['outcomes_2']}'");  ?> ></input>
            <br>
        <br>
        <?php
            if(isset($_GET['content']) && $_GET['content'] = 'view') {
                echo("<button type='submit' name='studentSubmit' class='w3-button w3-blue'>Submit</button>");
            }
            else {
                echo("<button type='submit' name='studentSubmit' class='w3-button w3-blue'>Submit</button>");
            }
        ?>            
    </form>
</div>