<?php
    if (isset($_POST['startInternshipWF'])) {
        //make default values None
        //put all in try catch block for exception handling
        //error handling (no such email was found)
        $studentEmail = mysqli_real_escape_string($db_conn, $_POST['studentEmail']);
        $dept_code = mysqli_real_escape_string($db_conn, $_POST['dept_code']);
        //$semester = mysqli_real_escape_string($db_conn, $_POST['semester']);
        //$year = mysqli_real_escape_string($db_conn, $_POST['year']);
        //$gradeMethod = mysqli_real_escape_string($db_conn, $_POST['gradeMethod']);
        $title = mysqli_real_escape_string($db_conn, $_POST['title']);
        $deadline = mysqli_real_escape_string($db_conn, $_POST['deadline']);
        $ATPID = mysqli_real_escape_string($db_conn,  $_POST['ATPID']);
        $priority = mysqli_real_escape_string($db_conn, $_POST['priority']);
        $deadline = mysqli_real_escape_string($db_conn, $_POST['deadline']);
        $wf_id = bin2hex(random_bytes(32));  //duplication is unlikely with this one. 1 in 20billion apparently
        
        $newappsql = "INSERT INTO s21_active_workflow_info(WF_ID, ATPID, title, dept_code, student_email, priority, deadline) 
            VALUES ('$wf_id','$ATPID', '$title', '$dept_code','$studentEmail', '$priority', '$deadline');";

        //get workflow steps info
        $sql = "SELECT * FROM s21_course_workflow_steps WHERE ATPID = '$ATPID'";
        $result = mysqli_query($db_conn, $sql);
        $row = mysqli_fetch_assoc($result);

        $instructions= $row['instructions'];
        $participants = explode("=>", $instructions);

        //get department participant emails
        $sql = "SELECT `chair_email`,`dean_email`,`secretary_email` FROM `f20_academic_dept_info` WHERE `dept_code` = '$dept_code' ";
        $result = mysqli_query($db_conn, $sql);
        $dept_emails = mysqli_fetch_assoc($result);

        //sql prep to insert into active_workflow_ids
        $columns  = "INSERT INTO s21_active_workflow_ids(WF_ID ";
        $values = " VALUES('{$wf_id}' ";
        
        //get participant ids
        $partial_sql = "SELECT `UID` FROM f20_user_table WHERE `user_email` = ";
        foreach($participants as $p) {
                $missing_sql = "";
                if ($p == 'Dean') {
                        $missing_sql =  "'{$dept_emails['dean_email']}'";
                        $columns.= ',DN_ID ';     
                }
                elseif ($p == 'Chair') {
                        $missing_sql = "'{$dept_emails['chair_email']}'";
                        $columns.= ',CHR_ID ';
                } elseif ($p == 'Secretary') {
                        $missing_sql = "'{$dept_emails['secretary_email']}'";
                        $columns.= ',SCRTY_ID ';
                } elseif ($p == 'Student') {
                        $missing_sql = "'{$studentEmail}'";
                        $columns.= ',STDNT_ID ';
                }

                $sql = $partial_sql.$missing_sql;
                $result = mysqli_query($db_conn, $sql);
                $row = mysqli_fetch_assoc($result);

                $values.= ",{$row['UID']} ";

        }

        $wf_ids_sql = $columns.")".$values.");";

        //are intitally set to not started
        $default_workflow_status_sql = "INSERT INTO s21_active_workflow_status(WF_ID) 
                                VALUES ('$wf_id');";
        //insert into db
        mysqli_query($db_conn, $default_workflow_status_sql);
        mysqli_query($db_conn, $newappsql);
        
        if (mysqli_errno($db_conn) == 0) {
            mysqli_query($db_conn, $wf_ids_sql);

            if (mysqli_errno($db_conn) == 0) {

                echo("<div class='w3-card w3-green w3-margin w3-padding'>Application Successfully Started.</div>");
            }
            else {
                echo("<div class='w3-card w3-red w3-margin w3-padding'>Error starting application application.</div>");
            }
        }
        else {
            echo("<div class='w3-card w3-red w3-margin w3-padding'>Error starting application.</div>");
        }

    }
?>

<div class="w3-card-4 w3-margin w3-padding" style="background-color: whitesmoke;">
    <h4>Secretary Form</h4>
        <form method="post">
                <label for="title">Title</label>
                <input id="title" name="title" type="text" class="w3-input" required>
                <br>
                <label for="priority">Priority</label>
                <select id="type" name="priority" class="w3-input">
        		<option selected="" disabled="" hidden=""> Select a priority. </option>
        		<option value="urgent" id="1">urgent</option>
        		<option value="normal" id="2">normal</option>
        		</select>
                <br>
		        <label for="deadline">Deadline</label>
                <input id="deadline" name="deadline" type="datetime-local" class="w3-input" required>
                <br>
                <label for="form_type">Course (Workflow Template) </label>
                
                <?php
                //Load templates
                include_once('../../../backend/config.php');
                include_once('../../../backend/db_connector.php');
                
                //get secretaries department
                $user_email = $_SESSION['user_email'];
                $sql = "SELECT `dept_code` FROM f20_academic_dept_info WHERE `secretary_email` = 
                '$user_email'";
                $result = mysqli_query($db_conn, $sql);
                $row = mysqli_fetch_assoc($result);
                $dept_code = $row['dept_code'];
                
                $sql = "SELECT `workflow_title`, `ATPID` FROM `s21_course_workflow_steps` WHERE `dept_code` = '$dept_code'";
                
                $result = $db_conn->query($sql);
                
                if ($result->num_rows > 0){
                        echo " <select class='w3-input' id='template' name='ATPID'><option selected disabled hidden>Select a Workflow Template</option>";
                        while($row = $result->fetch_assoc()){
                            echo($row['workflow_title']);
                            echo "<option value=".$row['ATPID']. ">" .$row['workflow_title']. "</option>";
                        }
                }
                echo "</select>";
                echo "<input type=hidden name=dept_code value=$dept_code>";

                ?>

                <br>
                <h5>Student Information</h5>
                <input type="hidden" name="workflowID" value="<?php echo $workflowID ?>">
                <label class="w3-input" for="studentFirstName">First name</label>
                <input type="text" class="w3-input" name="studentFirstName" id="studentFirstName" placeholder="Enter the Student's First Name." required>
                <label class="w3-input" for="studentLastName">Last name</label>
                <input type="text" class="w3-input" name="studentLastName" id="studentLastName" placeholder="Enter the Student's Last Name." required>
                <label class="w3-input" for="studentEmail">Email</label>
                <input type="email" class="w3-input" name="studentEmail" id="studentEmail" placeholder="Enter the Student's Email." required>
                <br>
                <button class="w3-button w3-blue" type="submit" name="startInternshipWF">Start</button>
        </form>
</div>
