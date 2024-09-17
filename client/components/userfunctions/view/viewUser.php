<?php
    if(!isset($_SESSION)) {
        session_start();
    }
    //User has not signed in.
    if(!isset($_SESSION['user_type'])) {
        echo "<div class='w3-panel w3-margin w3-red'><p>Session Expired, Please sign in again.</p></div>";
        exit();
    }
    //User is not an admin or secretary.
    if(!($_SESSION['user_type'] == $GLOBALS['admin_type'])){
        echo "<div class='w3-panel w3-margin w3-red'><p>Error! You do not have permission to access this information.</p></div>";
        exit();
    }
    //User Email was not sent to the page.
    if(!isset($_POST['UID'])) {
        echo "<div class='w3-panel w3-margin w3-red'><p>Error! No user recieved</p></div>";
        exit();
    }
    else {
        include_once('../../backend/util.php');
        include_once('../../backend/db_connector.php');
        include_once('./userfunctions/miscFunc/users.php');

        //Gather data passed to this page.
        $UID = mysqli_real_escape_string($db_conn, $_POST['UID']);

        //User chooses to remove user.
        if(isset($_POST['remove'])) {
            $sql = "UPDATE f23_User_Table SET USID = 3 WHERE `UID` = '$UID'";
            if ($db_conn->query($sql) === TRUE) {
                echo("<div class='w3-panel w3-round-large w3-margin w3-green'><p>Successfully Terminated User.</p></div>");
            } 
            else {
                echo("<div class='w3-panel w3-round-large w3-margin w3-red'><p>Error terminating user: " . $db_conn->error . "</p></div>");
            }
        }
        else if(isset($_POST['saveUserChanges'])) {
            //Gather all input form fields.
            $dataType = mysqli_real_escape_string($db_conn, $_POST['type']);
            
            if($dataType == "Any") {
                $dataType = "1";
            } else if($dataType == "Self") {
                $dataType = "2";
            } else if($dataType == "Other") {
                $dataType = "3";
            } else if($dataType == "Form") {
                $dataType = "4";
            } else if($dataType == "File") {
                $dataType = "5";
            } else if($dataType == "Database") {
                $dataType = "6";
            } else {
                $dataType = "7";
            }
            
            // $dataStatus = mysqli_real_escape_string($db_conn, $_POST['status']);
            //$owner = mysqli_real_escape_string($db_conn, $_POST['name']);
            $dataAlive = mysqli_real_escape_string($db_conn, $_POST['alive']);
            $dataApprove = mysqli_real_escape_string($db_conn, $_POST['approve']);
            $dataUnlock = mysqli_real_escape_string($db_conn, $_POST['unlock']);
            $dataActive = mysqli_real_escape_string($db_conn, $_POST['active']);
            $dataStatus = $dataAlive.$dataApprove.$dataUnlock.$dataActive;
            /*$sql = "UPDATE f20_data_T
             SET `data_owner` = $owner,
             `dataStatus_id` = $dataStatus,
             `dataType_id` = '$dataType'
             JOIN f20_dataType_T
             ON f20_data_T.dataType_id = f20_dataType_T.dataType_id
             JOIN f20_dataStatus_T
             ON f20_data_T.dataStatus_id = f20_dataStatus_T.dataStatus_id
             WHERE `data_owner` = '$owner'";*/
            
            $insertData = "UPDATE f23_data_T SET dataStatus = '$dataStatus', dataType = '$dataType' WHERE data_id = $dataID";
            if ($db_conn->query($sql) === TRUE) {
                echo("<div class='w3-panel w3-margin w3-green'><p>Successfully Updated " . $owner . "</p></div>");
            }
            else {
                echo("<div class='w3-panel w3-margin w3-red'><p>Error updating data: " . $db_conn->error . "</p></div>");
            }
        
        }
        else {
            //Find all data related to the user.
            $sql = "SELECT * FROM f23_User_Table LEFT JOIN f23_Company_T ON f23_User_Table.company_id = f23_Company_T.comp_id
                        JOIN f23_User_Role_Table 
                            ON f23_User_Table.URID = f23_User_Role_Table.URID
                        JOIN f23_User_Status_Table
                            ON f23_User_Table.USID = f23_User_Status_Table.USID
                        WHERE `UID` = '$UID'";
            $query = mysqli_query($db_conn, $sql);
            $row = mysqli_fetch_assoc($query);
?>

<!-- User Information -->
<div id="userForm" class="w3-card-4 w3-round-large w3-white w3-padding w3-margin">
    <div class="w3-right" id="actionButtons">
        <button type="button" class="w3-button w3-round-large w3-blue" name="editUser" style="margin-right: 5px;" onclick="enableEdit()">Edit</button>
        <button type="button" class="w3-button  w3-round-large w3-red" name="removeUser" onclick="removeEntry('<?php echo $row['UID'] ?>')">Remove</button>
    </div>

    <h5 class="w3-center" style="margin-left:140px">User:</h5>
    <form method="post" action="./dashboard.php?content=view&contentType=user">
        <input name="UID" id="UID" type="hidden" value="<?php echo $row['UID']; ?>">
        <label for="name">Name</label>
        <input class="w3-input w3-border w3-round-large w3-sand" id="name" name="name" type="text" value="<?php echo $row['user_name']; ?>" readonly>
        <br>
        <label for="userEmail">Email</label>
        <input class="w3-input w3-border w3-round-large w3-sand" id="userEmail" name="userEmail" type="email" value="<?php echo $row['user_email']; ?>" readonly>
        <br>
        <label for="password">Password:</label>
        <input class="w3-input w3-border w3-round-large w3-sand" id="password" name="password" type="text" value="<?php echo $row['user_password']; ?>" readonly>
        <br>
        <label for="status">User Status</label>
        <select class="w3-input w3-border w3-round-large w3-sand" id="status" name="status">
            <option value="<?php echo $row['USID']; ?>"><?php echo $row['user_status']; ?></option>
            <?php
                $sql = "SELECT * FROM f23_User_Status_Table";
                $query = mysqli_query($db_conn, $sql);
                while ($statusrow = mysqli_fetch_assoc($query)) {
                    echo("<option value='" . $statusrow['USID'] . "'>" . $statusrow['user_status'] . "</option>");
                }
            ?>
        </select>
        <br>
        <label for="type">User Type</label>
        <select class="w3-input w3-border w3-round-large w3-sand" id="type" name="type" readonly>
            <option value="<?php echo $row['URID']; ?>"><?php echo $row['user_role_title']; ?></option>
            <?php
                $sql = "SELECT * FROM f23_User_Role_Table";
                $query = mysqli_query($db_conn, $sql);
                while ($rolerow = mysqli_fetch_assoc($query)) {
                    echo("<option value='" . $rolerow['URID'] . "'>" . $rolerow['user_role_title'] . "</option>");
                }
            ?>
        </select>
        <br>
        <label for="company">Company</label>
        <select id="company" name="company" class="w3-input w3-border w3-round-large w3-sand" readonly>
            <option value="<?php $compID = $row['comp_id']; if($compID == 0 || $compID == Null) echo Null; else echo $compID;  ?>"><?php $compName = $row['comp_name']; if($compName == NULL) echo "None"; else echo $compName; ?></option>
            <?php
            if ($compName != Null) 
            echo("<option value='Null'>None</option>");
                $sql = "SELECT * FROM f23_Company_T";
                $query = mysqli_query($db_conn, $sql);
                while ($comprow = mysqli_fetch_assoc($query)) {
                    echo("<option value='" . $comprow['comp_id'] . "'>" . $comprow['comp_name'] . "</option>");
                }
            ?>
        </select>
        <br>
        <div id="editButtons" style="display: none;">
            <button type="submit" class="w3-button w3-round-large w3-blue" name="saveUserChanges">Save</button>
            <button type="button" class="w3-button w3-round-large w3-red" onclick="disableEdit()">Cancel</button>
        </div>
    </form>
</div>

<!-- Workflows for user- didnt get to implement using jobs/tasks-->
<!-- <div id="userForm" class="w3-card-4 w3-padding w3-margin">
    <h5>Workflows:</h5>
    <form method="post" action="./dashboard?content=view&contentType=user"> -->
<!--     <?php
       /* $user_email = $_SESSION['user_email'];
        $sql = "SELECT * FROM f20_application_info WHERE student_email = '$user'";
        $query = mysqli_query($db_conn, $sql);

        if ($query) {
            while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
                echo('<div class="w3-row w3-card-4 w3-margin">'
                        .'<div class="w3-quarter w3-border" style="height: 90px; padding-left: 10px;">'
                        . '<p>Type: '
                        . $row['project_name']
                        . '<br>Semester: '
                        . $row['semester'] . ' '
                        . $row['year'])
                        . '<br>Status: '
                        . 'Denied'
                        . '</p></div>';

                include('./userfunctions/workflowProgress.php');

                echo('<div class="w3-quarter w3-center w3-padding-24 w3-border" style="height: 90px;">'
                        . '<form action="./dashboard.php?content=viewWorkflow" method="post" >'
                        . '<input type="hidden" name="wfID" value="'
                        . $row['fw_id']
                        . '"></input>'
                        . '<button class="w3-button w3-blue" type="submit">View</button>'
                        . '</div></div>');
            }
        }
        else {
            echo('<div class="w3-row w3-card-4 w3-margin w3-center w3-red">'
                    . '<p>No Workflows Found!</p></div>');
        }*/
    ?> -->
    <!-- </form>
</div> -->

<!-- Modal Pop-up to warn of deletion -->
<div id="warningHolder" class="w3-modal w3-center">
    <div class="w3-modal-content">
        <div class="w3-container w3-orange w3-round-large">
            <p>Warning!!</p>
            <p>'Removing' a user will terminate their account.</p>
            <p>Are you sure this is what you want to do?
                <br>
                <form method="post" action="./dashboard.php?content=view&contentType=user">
                    <input id="removeData" name="UID" type="hidden">
                    <button class="w3-button w3-red w3-round-large" type="submit" name="remove">Yes</button>
                    <button class="w3-button w3-black w3-round-large" type="button" onclick="document.getElementById('warningHolder').style.display='none'">No</button>
                </form>
            </p>
        </div>
    </div>
</div>

<!-- Remove from database Script -->
<script>
    function removeEntry(user)
    {
        //Display the warning modal.
        document.getElementById('warningHolder').style.display='block';
        //Replace hidden input data to prepare for if the user chooses to submit.
        document.getElementById('removeData').value = user;
    }
</script>

<!-- Enable/Disable table editing Script -->
<script>
    function enableEdit()
    {
        //Disable readonly on inputs.
        var inputs = document.querySelectorAll(".w3-input");
        for (var i = 0; i < inputs.length; i++) {
            inputs[i].readOnly=false;
        }
        //Hide the edit and remove buttons.
        document.getElementById("actionButtons").style.display = "none";
        //Show the save and cancel buttons.
        document.getElementById("editButtons").style.display = "inline-block";
    }
    function disableEdit()
    {
        //Re-enable readonly on all inputs.
        var inputs = document.querySelectorAll(".w3-input");
        for (var i = 0; i < inputs.length; i++) {
            inputs[i].readOnly=true;
        }
        //Hide the save and cancel buttons.
        document.getElementById("editButtons").style.display = "none";
        //Show the edit and remove buttons.
        document.getElementById("actionButtons").style.display = "inline-block";
    }
</script>

<?php }
    }
?>