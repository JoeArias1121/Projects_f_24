<?php

//If this field is set then the user submitted the form to start the workflow.
if(isset($_POST['studentSubmit'])) {
    //First we gather all the input field information.
    $WF_ID = mysqli_real_escape_string($db_conn, $_SESSION['WF_ID']);
    $user_id = $_SESSION['user_id'];
    $approval = mysqli_real_escape_string($_POST['dean_approval']);
    $comments = mysqli_real_escape_string($_POST['comments']);


    //This updates the application utility table in the database.
    $new_form_sql = "INSERT INTO s21_dean_form (WF_ID, dean_approval, comments) 
        VALUES ('$WF_ID','$approval', '$comments')";
    $update_status_sql = "UPDATE s21_active_workflow_status SET dean_status = 1 WHERE WF_ID='$WF_ID' ";
    $query = mysqli_query($db_conn, $new_form_sql);
    if ($query) {
        $query = mysqli_query($db_conn, $update_status_sql);

        if ($query) {
            echo("<div class='w3-card w3-green w3-margin w3-padding'>Dean Information Successfully Updated.</div>");

        } else  {

            echo("<div class='w3-card w3-red w3-margin w3-padding'> Dean Information Update Unsuccessful .</div>");              
        }
    } 
    else {
        echo("<div class='w3-card w3-red'>Error. Chair Information Update Unsuccessful .</div>");
    }

}
//If this field is set then the user came here from their list of active workflows.
else if(isset($_POST['wfID'])) {
    $workflowID = $_POST['wfID'];
}

else {
    $WF_ID = $_SESSION['WF_ID'];
    $sql = "SELECT * FROM s21_dean_form WHERE WF_ID = '$WF_ID'";
    $result = mysqli_query($db_conn, $sql);

    $row = mysqli_fetch_array($result);
    $state = 'required';

    if ($_SESSION['user_type'] != 4) {
    //$row = array_map(function($item) { return ""; }, $row);
    $state = "disabled";
    }
    echo $WF_ID;
}

?>

<!-- Dean Form --> 
<div class="w3-card-4 w3-margin w3-padding" style="background-color: whitesmoke;">
    <h4>Dean Form</h4>
    <form method="post" action="./dashboard.php?content=startInternApp">
    <div id="deanApprovalDecision">
        <h5> Approve or Decline Student Application </h5>
        <label class="w3-input" for="deanApproval"> Choose: </label>
        <input type="text" class="w3-input" name="deanApproval" id="deanApproval" <?php echo("$state placeholder = '{$row['dean_approval']}'"); ?>> </input>
        
        <label class="w3-input" for="deanComments">Comments:</label>
        <input type="text" class="w3-input" name="deanComments" id="deanComments" <?php echo("$state placeholder = '{$row['comments']}'"); ?>> </input>
        <br>
        <?php
            if(isset($_GET['content']) && $_GET['content'] = 'view') {
                echo("<button type='submit' name='studentSubmit' class='w3-button w3-blue'>Submit</button>");
            }
            else {
                echo("<button type='submit' name='studentSubmit' class='w3-button w3-blue'>Submit</button>");
            }
        ?>            
    </div>  
</form>
</div>