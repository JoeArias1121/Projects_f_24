<!--
    This file displays all results from the user table in the database 
    into an html table. All users except employers/supervisors, and students
    could have use for this table in looking up other faculty to put on a
    custom workflow, or finding students who would like to start a workflow.
-->

<?php
    include_once('../../backend/config.php');
    include_once('../../backend/db_connector.php');
    //Loading the page title and action buttons.
    //include_once('./userfunctions/search/search.php')
?>

<!-- User Search -->
<div id="userSearch" class="w3-card w3-white w3-round-large w3-padding w3-margin">

 <?php if ($_SESSION['user_type'] == $GLOBALS['admin_type']) { ?>
<button class="w3-button w3-right w3-green w3-round-large" type="button" onclick="window.location.href='./dashboard.php?content=create&contentType=user'">Create User</button>
<?php }?>
 <div class="w3-center">
<h5 style="margin-left:100px">User Search</h5>
    <p>You may search by ID or Email</p>
    <input type="text" id="userInput" onkeyup="search('userTable', 'userInput')" style="width:300px" class="w3-border w3-round-large"/>
    </div>
    <table id="userTable" class="w3-round-large pagination w3-table-all w3-responsive w3-content" data-pagecount="8" style="max-width:fit-content;">
        <tr class="w3-sand">
            <th class="">Name</th>
            <th class="">Email</th>
            <th class="w3-center">Account Type</th>
            <th class="w3-center">Account Status</th>
            <?php if ($_SESSION['user_type'] == $GLOBALS['admin_type']) {?>
            <th class="w3-center">Action</th>
            <?php }?>
        </tr>
        <?php
            $sql = "SELECT * FROM f23_User_Table
                JOIN f23_User_Role_Table 
                    ON f23_User_Table.URID = f23_User_Role_Table.URID
                JOIN f23_User_Status_Table
                    ON f23_User_Table.USID = f23_User_Status_Table.USID";
            $query = mysqli_query($db_conn, $sql);
            while ($row = mysqli_fetch_assoc($query)) {
                $UID = $row['UID'];
                $userName = $row['user_name'];
                $userEmail = $row['user_email'];
                $userType = $row['user_role_title'];
                $userStatus = $row['user_status'];
        ?>
        <tr>
            <td><?php echo $userName; ?></td>
            <td><?php echo $userEmail; ?></td>
            <td class="w3-center"><?php echo $userType; ?></td>
            <td class="w3-center"><?php echo $userStatus; ?></td>
            <td>
                <form method="post" action="./dashboard.php?content=view&contentType=user">
                    <!-- The hidden input field must be used to pass the account the user has selected
                        to the next page. -->
                    <input type="hidden" name="UID" value="<?php echo $UID;?>">
                    <?php if ($_SESSION['user_type'] == $GLOBALS['admin_type']) {?> 
                    <button type="submit" name="viewUser" class="w3-button w3-blue w3-round-large">View</button>
                    <?php }?>
                </form>
            </td>
        </tr>
        <?php } ?>
    </table>
    </div>
</div>