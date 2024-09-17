<!-- 
    This file is for the creation of courses work may be needed:
    1. Add fields for assigning instructors?
    2. May need database work.
-->


<?php 
    include_once('../../backend/config.php');
    include_once('../../backend/db_connector.php');
    //Loading the page title and action buttons.
    include_once('./userfunctions/miscFunc/adminTools.php');
    
    if (isset($_POST['courseCreate'])) {
        $indCode = mysqli_real_escape_string($db_conn, $_POST['indCode']);
        $name = mysqli_real_escape_string($db_conn, $_POST['compName']);
        $compHead = mysqli_real_escape_string($db_conn, $_POST['compHead']);
        $super = mysqli_real_escape_string($db_conn, $_POST['super']);

        $insertcompany = "INSERT INTO f23_Company_T (comp_name, ind_code, head_id, super_id) VALUES ('$name','$indCode', '$compHead', '$super' )";
        //$insertcompanyquery = mysqli_query($db_conn, $insertcompany);
        $insertUserQuery = mysqli_query($db_conn, $insertcompany);
       // echo($indCode);
        
        //Database insert success
        if (mysqli_errno($db_conn) == 0) {
            echo("<div class='w3-panel w3-margin w3-green'><p>Company Successfully Created.</p></div>");
        } 
        //Database detected duplicate entry
        else if (mysqli_errno($db_conn) == 1062) {  
            echo("<div class='w3-panel w3-margin w3-red'><p>Failed to Create Company - Duplicate Found.</p></div>");
        }
    }
?>

<!-- Create Course -->
<div id="courseForm" class="w3-card w3-white w3-round-large w3-padding w3-margin">
    <h5 class="w3-center">Create Company</h5>
    
    <form method="post" action="./dashboard.php?content=create&contentType=course">
    <label for="compName">Company Name:</label>
        <input id="compName" name="compName" type="text" class="w3-input w3-border w3-round-large w3-sand" required />
        <br>
        <label for="indCode">Industry:</label>
        <select id="indCode" name="indCode" class="w3-input w3-border w3-round-large w3-sand" required>
            <?php
                $sql = "SELECT * FROM f23_Industry_T ORDER BY ind_code ASC";
                $indquery  = mysqli_query($db_conn, $sql);
                $r = mysqli_num_rows($indquery);
                if ($r > 0) {
                    while ($result = mysqli_fetch_assoc($indquery)) {
                        $indCode = $result['ind_code'];
                        echo("<option value=" . $indCode . ">" . $indCode . "</option>");
                    }
                }
            ?>
        </select>
        <br>
        <label for="compHead">Owner/Head:</label>
        <select id="compHead" name="compHead" class="w3-input w3-border w3-round-large w3-sand">
        <option value="">None</option>
            <?php
                $sql = "SELECT * FROM f23_User_Table WHERE URID = 5";
                $headquery  = mysqli_query($db_conn, $sql);
                $row = mysqli_num_rows($headquery);
                if ($row > 0) {
                    while ($result = mysqli_fetch_assoc($headquery)) {
                        $headname = $result['user_name'];
                        $headID = $result['UID'];
                        echo("<option value=" . $headID . ">" . $headname . "</option>");
                    }
                }
            ?>
        </select>
        <br>
        <label for="super">Supervisor:</label>
        <select id="super" name="super" class="w3-input w3-border w3-round-large w3-sand">
            <?php
                $sql = "SELECT * FROM f23_User_Table WHERE URID = 2";
                $superquery  = mysqli_query($db_conn, $sql);
                $row = mysqli_num_rows($superquery);
                if ($row > 0) {
                    while ($result = mysqli_fetch_assoc($superquery)) {
                        $supername = $result['user_name'];
                        $superID = $result['UID'];
                        echo("<option value=" . $superID . ">" . $supername . "</option>");
                    }
                }
            ?>
        </select>
        <br>
        <div class="w3-center">
        <button type="submit" class="w3-button w3-green w3-round-large" name="courseCreate">Add Company</button>
        </div>
    </form>
</div>