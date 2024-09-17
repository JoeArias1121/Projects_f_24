<?php
    if(!isset($_SESSION)) {
        session_start();
    }
    //User has not signed in.
    if(!isset($_SESSION['user_type'])) {
        echo "<div class='w3-panel w3-margin w3-red'><p>Session Expired, Please sign in again.</p></div>";
        exit();
    }
    //User is not an admin.
    if(!($_SESSION['user_type'] == $GLOBALS['admin_type'])){
        echo "<div class='w3-panel w3-margin w3-red'><p>Error! You do not have permission to access this information.</p></div>";
        exit();
    }
    //Department ID was not sent to the page.
    if(!isset($_POST['department'])) {
        echo "<div class='w3-panel w3-margin w3-red'><p>Error! No department recieved</p></div>";
        exit();
    }
    else {
        include_once('../../backend/util.php');
        include_once('../../backend/db_connector.php');
       // include_once('./userfunctions/search/search.php');

        //Gather data passed to this page.
        $department = mysqli_real_escape_string($db_conn, $_POST['department']);

        //User chooses to remove department.
        if(isset($_POST['remove'])) {
            $sql = "DELETE FROM f23_Industry_T WHERE ind_code = '$department'";
            if ($db_conn->query($sql) === TRUE) {
                echo("<div class='w3-panel w3-margin w3-green'><p>Successfully Removed " . $department . "</p></div>");
            } 
            else {
                echo("<div class='w3-panel w3-margin w3-red'><p>Error removing record: " . $db_conn->error . "</p></div>");
            }
        }
        else {
            //Find all data related to the department.
            $sql = "SELECT * FROM f23_Industry_T WHERE ind_code = '$department'";
            $query = mysqli_query($db_conn, $sql);
            $row = mysqli_fetch_assoc($query);
?>

<br>

<!-- Department Information -->
<div id="departmentForm" class="w3-card w3-white w3-padding w3-margin w3-round-large">
    <div class="w3-right" id="actionButtons">
        <button type="button" class="w3-button w3-blue w3-round-large" name="editDepartment" style="margin-right: 5px;" onclick="enableEdit()">Edit</button>
        <button type="button" class="w3-button w3-red w3-round-large" name="removeDepartment" onclick="removeEntry('<?php echo $department ?>')">Remove</button>
    </div>

    <h5>Industry:</h5>
    <form method="post" action="./dashboard.php?content=view&contentType=department">
        <label for="indName">Industry Name:</label>
        <input id="indName" name="indName" type="text" class="w3-input w3-border w3-round-large w3-sand" value="<?php echo $row['ind_name']; ?>" readonly>
        <br>
        <label for="indCode">Industry Code:</label>
        <input id="indCode" name="indCode" type="text" class="w3-input w3-border w3-round-large w3-sand" value="<?php echo $department; ?>" readonly>
        <br>
        <label for="deanEmail">Admin:</label>
        <select id="deanEmail" name="deanEmail" class="w3-input w3-border w3-round-large w3-sand" disabled>
            <option value="<?php echo $row['admin_email']; ?>"><?php echo $row['admin_email']; ?></option>
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
        <div id="editButtons" style="display: none;">
            <button type="submit" class="w3-button w3-blue w3-round-large" name="saveDepartmentChanges">Save</button>
            <button type="button" class="w3-button w3-red w3-round-large" onclick="disableEdit()">Cancel</button>
        </div>
    </form>
</div>

<!-- Courses -->
<div id="courseList" class="w3-card w3-white w3-padding w3-margin w3-round-large">
    <button class="w3-button w3-right w3-blue w3-round-large" type="button" onclick="window.location.href='./dashboard.php?content=adminTools&contentType=company'">Create Company</button>
    <div class="w3-center">
    <h5 style="margin-left:130px" style="margin-left:130px">Company List</h5>
    <p>You may search by Company or Industry</p>

    <input type="text" id="courseInput" onkeyup="search('courseTable', 'courseInput')" style="width:300px" class="w3-round-large w3-border"/>
    </div>
    
    <table id="courseTable" class="pagination w3-table-all w3-responsive w3-content w3-round-large" data-pagecount="8" style="max-width:fit-content;">
        <tr class="w3-sand">
            <th class="w3-center">ID</th>
            <th class="w3-center">Name</th>
            <th class="w3-center">Head</th>
            <th class="w3-center">Supervisor</th>
            <th class="w3-center">Actions</th>
        </tr>
        <?php
            //Find all courses related to the department.
            $sql = "SELECT * FROM f23_Company_T WHERE ind_code = '$department'";
            $query = mysqli_query($db_conn, $sql);
            while ($row = mysqli_fetch_assoc($query)) {
                $compID = $row['comp_id'];
                $courseNumber = $row['comp_name'];
                $head = $row['head_id'];
                $super = $row['super_id'];
                $headQuery = mysqli_query($db_conn, "SELECT * FROM f23_User_Table WHERE UID = '$head'");
                $superQuery = mysqli_query($db_conn,"SELECT * FROM f23_User_Table WHERE UID = '$super'");
                $headRow = mysqli_fetch_assoc($headQuery);
                $superRow = mysqli_fetch_assoc($superQuery);

        ?>
        <tr>
            <td><?php echo $compID;?></td>
            <td><?php echo $courseNumber;?></td>
            <td><?php echo $headRow['user_name'];?></td>
            <td><?php echo $superRow['user_name'];?></td>
            <td>
                <form method="post" action="./dashboard.php?content=view&contentType=course">
                    <input type="hidden" name="department" value="<?php echo $department;?>">
                    <input type="hidden" name="courseNumber" value="<?php echo $courseNumber;?>">
                    <button type="submit" name="viewCourse" class="w3-button w3-blue w3-round-large">View</button>
                </form>
            </td>
        </tr>
        <?php } ?>
    </table>
    
</div>

<!-- Instructors -->


<!-- Modal Pop-up to warn of deletion -->
<div id="warningHolder" class="w3-modal w3-center">
    <div class="w3-modal-content">
        <div class="w3-container w3-red">
            <p>Warning!!</p>
            <p>A 'Remove' can not be undone!</p>
            <p>Are you sure?
                <br>
                <form method="post" action="./dashboard.php?content=view&contentType=department">
                    <input id="removeData" name="department" type="hidden">
                    <button type="submit" name="remove">Yes</button>
                    <button type="button" onclick="document.getElementById('warningHolder').style.display='none'">No</button>
                </form>
            </p>
        </div>
    </div>
</div>

<!-- Remove from database Script -->
<script>
    function removeEntry(department)
    {
        //Display the warning modal.
        document.getElementById('warningHolder').style.display='block';
        //Replace hidden input data to prepare for if the user chooses to submit.
        document.getElementById('removeData').value = department;
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
            inputs[i].disabled=false;
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

        //Disable the select fields.
        document.getElementById("deanEmail").disabled = true;

        //Hide the save and cancel buttons.
        document.getElementById("editButtons").style.display = "none";
        //Show the edit and remove buttons.
        document.getElementById("actionButtons").style.display = "inline-block";
    }
</script>

<?php }
    }
?>