<?php
    include_once('../../backend/config.php');
    include_once('../../backend/db_connector.php');
    //Loading the page title and action buttons.
    include_once('./userfunctions/forms/forms.php');
?>

<!-- Form Search -->
<div id="formSearch" class="w3-card w3-white w3-round-large w3-padding w3-margin">
<div class="w3-center">
    <button class="w3-button w3-right w3-blue w3-round-large" type="button" onclick="window.location.href='./dashboard.php?content=forms&contentType=create'">Start New Form</button>
    <h5 style="margin-left:150px">Forms Search</h5>
    <p>You may search by any title or responsible role in the table.</p>
    <input style="width:300px" class="w3-round-large" id="workflowInput" type="text" onkeyup="search('workflowTable', 'workflowInput')"></input>
    </div>
    <table id="workflowTable" class="pagination w3-margin-top w3-table-all w3-responsive w3-content" data-pagecount="6" style="max-width:fit-content;">
        <tr>
            <th>Form Title</th>
            <th>Responsible</th>
        </tr>

        <?php
            $sql = "SELECT * FROM f23_Form_Templates";

            $query = mysqli_query($db_conn, $sql);
            
            while ($row = mysqli_fetch_array($query)) {
                $TID = $row['TID'];
                $title = $row['title'];
                $instructions = $row['instructions'];
                $user_access_role = $row['user_access_role'];
        ?>
        <tr>
            
            <td><?php echo $title; ?></td>
            <td><?php if($user_access_role == 4) echo "Dean";
                            elseif($user_access_role == 1) echo "Administrator";
                            elseif($user_access_role == 8) echo "Student";
                            elseif($user_access_role == 6) echo "Secretary";
                            elseif($user_access_role == 5) echo "Chair"; ?></td>
            <td>
                <form method="post" action="./dashboard.php?content=forms&contentType=editSingle">
                    <input type="hidden" name="TID" value="<?php echo $TID;?>">
                    <button type="submit" name="viewForm" class="w3-button w3-blue w3-round-large">Edit</button>
                </form>
            </td>
        </tr>
        <?php } ?>
    </table>
</div>
