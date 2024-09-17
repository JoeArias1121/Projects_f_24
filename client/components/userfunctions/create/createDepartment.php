<!-- 
    This file is for the creation of departments work may be needed:
    1. Organization
    2. May need database work.
-->

<?php
    include_once('./userfunctions/miscFunc/adminTools.php');
    include_once('../../backend/db_connector.php');
    if (isset($_POST['departmentCreate'])) {
        include_once('../../backend/config.php');
        //Loading the page title and action buttons.

        $indName = mysqli_real_escape_string($db_conn, $_POST['indName']);
        $indCode = mysqli_real_escape_string($db_conn, $_POST['indCode']);
        $deanEmail = mysqli_real_escape_string($db_conn, $_POST['deanEmail']);

        $insertindSQL = "INSERT INTO f23_Industry_T (ind_code, ind_name, admin_email) VALUES ('$indCode', '$indName', '$deanEmail')";
        $insertindQuery = mysqli_query($db_conn, $insertindSQL);

        //Database insert success
        if (mysqli_errno($db_conn) == 0) {
            echo("<div class='w3-panel w3-margin w3-green'><p>Industry Successfully Created.</p></div>");
            $defaultWorkflow = array(0 => 'Student', 1 => 'Instructor', 2 => 'Employer', 3 => 'Chair', 4 => 'Dean', 5 => 'Records&Registration');
            $defaultWorkflow = serialize($defaultWorkflow);
            $insertWorkflowSQL = "INSERT INTO f23_Workflow_Order(ind_code, workflow) VALUES ('$indCode','$defaultWorkflow')";
            $insertWorkflowQuery = mysqli_query($db_conn, $insertWorkflowSQL);
        } 
        //Database detected duplicate entry
        else if (mysqli_errno($db_conn) > 1062) {  
            echo("<div class='w3-panel w3-margin w3-red'><p>Failed to Create industry - Duplicate Found.</p></div>");
        } else {
		echo($db_conn -> error);
	}
    }
?>

<!-- Create Department -->
<div id="departmentForm" class="w3-card w3-round-large w3-white w3-padding w3-margin">
    <h5 class="w3-center">Create Industry</h5>
    <form method="POST" action="./dashboard.php?content=create&contentType=department">
        <label for="indName">Industry Name</label>
        <input id="indName" name="indName" type="text" class="w3-input w3-border w3-round-large w3-sand">
        <br>
        <label for="indCode">Industry Code</label>
        <input id="indCode" name="indCode" maxlength='4' type="text" class="w3-input w3-border w3-round-large w3-sand">
        <br>
        <label for="deanEmail">Admin Email</label>
        <select id="deanEmail" name="deanEmail" class="w3-input w3-border w3-round-large w3-sand" required>
            <option value="">Please select a valid user.</option>
            <?php
                $sql = "SELECT * FROM f23_User_Table WHERE URID = 1";
                $indquery  = mysqli_query($db_conn, $sql);
                while ($result = mysqli_fetch_array($indquery)) {
                    $deanEmail = $result['user_email'];
                    echo("<option value=" . $deanEmail . ">" . $deanEmail . "</option>");
                }
            ?>
        </select>
        <br>
        
        <!-- The following is hidden for our final Presentation [Not Implemented] 
        <p><Strong>Permissions</Strong></p>
            <p>Instructors:<br>
                <input name="perm1" id="perm1_0" type="checkbox" class="w3-check">
                <label for="perm1_0" class="custom-control-label">modify course info</label>
                <input name="perm1" id="perm1_1" type="checkbox" class="w3-check">
                <label for="perm1_1" class="custom-control-label">modify project info</label>
                <input name="perm1" id="perm1_2" type="checkbox" class="w3-check">
                <label for="perm1_2" class="custom-control-label">modify employer info</label></p>
            <p>Employers:<br>
                <input name="perm2" id="perm2_0" type="checkbox" class="w3-check">
                <label for="perm2_0" class="custom-control-label">modify project info</label>
                <input name="perm2" id="perm2_1" type="checkbox" class="w3-check">
                <label for="perm2_1" class="custom-control-label">modify learning objectives</label></p>
            <p>industry Chairs:<br>
                <input name="perm3" id="perm3_0" type="checkbox" class="w3-check">
                <label for="perm3_0" class="custom-control-label">modify course info</label>
                <input name="perm3" id="perm3_1" type="checkbox" class="w3-check">
                <label for="perm3_1" class="custom-control-label">modify project info</label>
                <input name="perm3" id="perm3_2" type="checkbox" class="w3-check">
                <label for="perm3_2" class="custom-control-label">modify employer info</label>
                <input name="perm3" id="perm3_3" type="checkbox" class="w3-check">
                <label for="perm3_3" class="custom-control-label">modify learning objectives</label></p>
        
        <p><Strong>Email Settings</Strong></p>
            <p>Students:<br>
                <input name="em1" id="em1_0" type="checkbox" class="w3-check">
                <label for="em1_0" class="custom-control-label">receive email updates</label>
                <input name="em1" id="em1_1" type="checkbox" class="w3-check">
                <label for="em1_1" class="custom-control-label">receive reminder emails</label></p>
            <p>Instructors:<br>
                <input name="em2" id="em2_0" type="checkbox" class="w3-check">
                <label for="em2_0" class="custom-control-label">receive email updates</label>
                <input name="em2" id="em2_1" type="checkbox" class="w3-check">
                <label for="em2_1" class="custom-control-label">receive rejection emails</label>
                <input name="em2" id="em2_2" type="checkbox" class="w3-check">
                <label for="em2_2" class="custom-control-label">receive reminder emails</label></p>
            <p>Department Chairs:<br>
                <input name="em3" id="em3_0" type="checkbox" class="w3-check">
                <label for="em3_0" class="custom-control-label">receive email updates</label>
                <input name="em3" id="em3_1" type="checkbox" class="w3-check">
                <label for="em3_1" class="custom-control-label">receive rejection emails</label>
                <input name="em3" id="em3_2" type="checkbox" class="w3-check">
                <label for="em3_2" class="custom-control-label">receive reminder emails</label></p>
            <p>Deans:<br>
                <input name="em4" id="em4_0" type="checkbox" class="w3-check">
                <label for="em4_0" class="custom-control-label">recieve email updates</label>
                <input name="em4" id="em4_1" type="checkbox" class="w3-check">
                <label for="em4_1" class="custom-control-label">receive rejection emails</label>
                <input name="em4" id="em4_2" type="checkbox" class="w3-check">
                <label for="em4_2" class="custom-control-label">receive reminder emails</label></p>
        -->
        <br>
        <div class="w3-center">
        <button name="departmentCreate" type="submit" class="w3-button w3-green w3-round-large">Add Industry</button>
            </div>
    </form>
</div>
