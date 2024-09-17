<?php
    //If this field is set then the user submitted the form to start the workflow.
    if(isset($_POST['studentSubmit'])) {
        //First we gather all the input field information.
        $WF_ID = mysqli_real_escape_string($db_conn, $_SESSION['WF_ID']);
        $user_id = $_SESSION['user_id'];

        //$firstname = mysqli_real_escape_string($_POST['studentFirstName']);
        //$lastname = mysqli_real_escape_string($_POST['studentLastName']);
        //$middlename = mysqli_real_escape_string($_POST['studentMiddleName']);
        //$phonenum = mysqli_real_escape_string($_POST['studentPhone']);
        //$address = mysqli_real_escape_string($_POST['studentAddress']);
        /*$aptnum = mysqli_real_escape_string($_POST['studentAptNum']);
        $city = mysqli_real_escape_string($_POST['studentCity']);
        $state = mysqli_real_escape_string($_POST['studentState']);
        $zip = mysqli_real_escape_string($_POST['studentZip']);
        $credits = mysqli_real_escape_string($_POST['studentCredits']);
        $workflowType = mysqli_real_escape_string($_POST['appType']);
        $workflowCredits = mysqli_real_escape_string($_POST['appCredits']);
        $workflowHours = mysqli_real_escape_string($_POST['appHours']);
        $outcome1 = mysqli_real_escape_string($_POST['outcomes1']);
        $outcome2 = mysqli_real_escape_string($_POST['outcomes2']);
        $outcome3 = mysqli_real_escape_string($_POST['outcomes3']);
        $department = mysqli_real_escape_string($db_conn, $_POST['department']);
        $course = mysqli_real_escape_string($db_conn, $_POST['course']);*/
        $title = mysqli_real_escape_string($db_conn, $_POST['title']);
        $org = mysqli_real_escape_string($db_conn, $_POST['org']);
        $orgStreet = mysqli_real_escape_string($db_conn, $_POST['orgStreet']);
        $orgAptNum = mysqli_real_escape_string($db_conn, $_POST['orgAptNum']);
        $orgCity = mysqli_real_escape_string($db_conn, $_POST['orgCity']);
        $orgState = mysqli_real_escape_string($db_conn, $_POST['orgState']);
        $orgZipCode = mysqli_real_escape_string($db_conn, $_POST['orgZipCode']);                                      
        $supervisorName = mysqli_real_escape_string($db_conn, $_POST['supervisorName']);        
        $supervisorNum = mysqli_real_escape_string($db_conn, $_POST['supervisorNum']);
        $supervisorEmail = mysqli_real_escape_string($db_conn, $_POST['supervisorEmail']);
        $outcomes1 = mysqli_real_escape_string($db_conn, $_POST['outcomes1']);
        $outcomes2 = mysqli_real_escape_string($db_conn, $_POST['outcomes2']);
        $outcomes3 = mysqli_real_escape_string($db_conn, $_POST['outcomes3']);

        //This creates an entry for the student's information in the database attached with the workflow ID.
        /*$sql = "INSERT INTO f20_student_info (fw_id, student_first_name, student_last_name, student_middle_initial, 
            student_phone, student_address, student_apt_num, student_city, student_state, student_zip) 
            VALUES ('$workflowID','$firstname', '$lastname','$middlename','$phonenum','$address', '$aptnum', '$city', '$state','$zip', '$credits')";
        $query = mysqli_query($db_conn, $sql);
        if ($query) {
            echo("<div class='w3-card w3-green'>Student Information Successfully Updated.</div>");
        } 
        else {
            echo("<div class='w3-card w3-red'>Error. Student Information Update Unsuccessful .</div>");
        }
        
        //This updates the missing fields from the workflow in the database.
        $sql = "UPDATE f20_application_info SET project_name = '$workflowType', academic_credits = '$workflowCredits', 
            hours_per_wk = '$workflowHours' WHERE fw_id = '$workflowID'";
        $query = mysqli_query($db_conn, $sql);
        if (mysqli_errno($db_conn) == 0) {
            echo("<div class='w3-card w3-green'>Student Information Successfully Updated.</div>");
        } 
        else {
            echo("<div class='w3-card w3-red'>Student Information Successfully Updated.</div>");
        }

        //This updates the application utility table in the database.
        $sql = "UPDATE f20_application_util SET rejected = '0', progress = '1', assigned_to = 'instructor@email.com' 
            WHERE fw_id = '$workflowID'";
        $query = mysqli_query($db_conn, $sql);
        if (mysqli_errno($db_conn) == 0) {
            echo("<div class='w3-card w3-green'>Student Information Successfully Updated.</div>");
        } 
        else {
            echo("<div class='w3-card w3-red'>Student Information Successfully Updated.</div>");
        }
        */
        //This creates an entry in the company info table of the database.
        $new_form_sql = "INSERT INTO f20_company_info (WF_ID, company_name, supervisor_email, supervisor_phone, supervisor_Name, company_address, company_address2, company_city, company_state, company_zip) 
            VALUES ('$WF_ID','$org', '$supervisorEmail', '$supervisorNum', '$supervisorName', '$orgStreet', '$orgAptNum', '$orgCity','$orgState', '$orgZipCode')";
        
        $update_status_sql = "UPDATE s21_active_workflow_status SET student_status = 1 WHERE WF_ID='$WF_ID' ";

        $query = mysqli_query($db_conn, $new_form_sql);
        
        if ($query) {
            
            $query = mysqli_query($db_conn, $update_status_sql);

            if ($query) {
                echo("<div class='w3-card w3-green w3-margin w3-padding'>Business/Organization Information Successfully Updated.</div>");
            
            } else  {
                
                echo("<div class='w3-card w3-red w3-margin w3-padding'> Business/Student Information Update Unsuccessful .</div>");              
            }
        } 
        else {
            echo("<div class='w3-card w3-red w3-margin w3-padding'> Business/Student Information Update Unsuccessful .</div>");
        }
    }
    //If this field is set then the user came here from their list of active workflows.
    else if(isset($_POST['wfID'])) {
        $workflowID = $_POST['wfID'];
    } 
    else {
        $WF_ID = $_SESSION['WF_ID'];
        $sql = "SELECT * FROM f20_company_info WHERE WF_ID = '$WF_ID'";
        $result = mysqli_query($db_conn, $sql);

        $row = mysqli_fetch_array($result);
        $state = 'required';

        if ($_SESSION['user_type'] != 8) {
        //$row = array_map(function($item) { return ""; }, $row);
        $state = "disabled";
        }

    }
?>

<!-- Student Form -->
<div id=userForm class='w3-card-4 w3-padding w3-margin'>

    <h4>Student Form</h4>
    <form name="studentForm" method="post">
    <h5 for= title >Project Title</h5>
    <input id= title  name= title  type= text  class= 'w3-input'  disabled   required>
    <h5 for= organization >Name of Organization</h5>
    <input id= organization  name= organization  type= text  class= 'w3-input' <?php echo("$state placeholder = {$row['company_name']}");  ?> >
    <br>
    <label for= orgStreet >Street</label>
    <input id= orgStreet  name= orgStreet  type= text  class= 'w3-input'  <?php echo("$state placeholder = {$row['company_name']} ");  ?>>
    <br>
    <label for= orgAptNum >Apt#</label>
    <input id= orgAptNum  name= orgAptNum  type= text  class= 'w3-input'  <?php echo("$state placeholder = {$row['company_name']} ");  ?>>
    <br>
    <label for= orgCity >City</label>
    <input id= orgCity  name= orgCity  type= text  class= 'w3-input'  <?php echo("$state placeholder = {$row['company_name']} ");  ?>>
    <br>
    <label for= orgState >State</label>
    <input id= employerState name= employerState type=text class= 'w3-input'<?php echo("$state placeholder = {$row['company_name']} ");  ?>>
    </input>
    <br>
    <label for= orgZipCode >Zip Code</label>
    <input id= orgZipCode  name= orgZipCode  type= text  class= 'w3-input'  <?php echo("$state placeholder = {$row['company_name']} ");  ?>>
    <br>
    <label for= supervisorName >Supervisor</label>
    <input id= supervisorName  name= supervisorName  type= text  class= 'w3-input'  <?php echo("$state placeholder = {$row['company_name']} ");  ?>>
    <br>
    <label for= supervisorNum >Supervisor's Phone Number</label>
    <input id= supervisorNum  name= supervisorNum  type= text  class= 'w3-input'  <?php echo("$state placeholder = {$row['company_name']} ");  ?>>
    <br>
    <label for= supervisorEmail >Supervisor's Email</label>
    <input id= supervisorEmail  name= supervisorEmail  type= text  class= 'w3-input' <?php echo("$state placeholder = {$row['company_name']} ");  ?>>
    <br>
    <h5>Learning Outcomes</h5>
    <label class= 'w3-input'  for= outcomes1 >
            1a) What are your responsibilities on site?<br>
            b) What special project will you be working on?<br>
            c) What do you expect to learn?
        </label>
        <input type= text  class= 'w3-input'  name= outcomes1  id= outcomes1  disabled></input>
        <br>
        <label class= 'w3-input'  for= outcomes2 >
            1.) How is the proposal related to your major areas of interest?<br>
            Describe the course work you have completed which provides appropriate background to the project.
        </label>
        <input type= text  class= 'w3-input'  name= outcomes2  id= outcomes2  disabled></input>
        <br>
        <label class= 'w3-input'  for= outcomes3 >
            1.) What is the proposed method of study?<br>
            Where appropriate, cite readings and practical experience.
        </label>
        <input type= text  class= 'w3-input'  name= outcomes3  id= outcomes3  disabled></input>
        <br>
 <?php
                if(isset($_GET['content']) && $_GET['content'] = 'view') {
                    echo("<button type='submit' name='studentSubmit' class='w3-button w3-blue'>Submit</button>");
                }
                else {
                    echo("<button type='submit' name='studentSubmit' class='w3-button w3-blue'disabled>Submit</button>");
                }
            ?>            
        </div>
    </form>
</div>