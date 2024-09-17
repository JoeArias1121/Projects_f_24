<!--

-->

<?php
    include_once('../../backend/config.php');
    include_once('../../backend/db_connector.php');
    //Loading the page title and action buttons.
   // include_once('./userfunctions/search/search.php')
?>

<!-- Department Search -->
<div id="departmentSearch" class="w3-card w3-white w3-round-large w3-padding w3-margin">
    <button class="w3-button w3-right w3-green w3-round-large" type="button" onclick="window.location.href='./dashboard.php?content=create&contentType=department'">Create Industry</button>
    <div class="w3-center">
    <h5 style="margin-left:140px">Industry Search</h5>
    <p>You may search by Industry Name or Abbreviation</p>
    <input id="departmentInput" type="text" onkeyup="search('departmentTable', 'departmentInput')"style="width:300px" class="w3-border w3-round-large"></input>
</div>
    <table id="departmentTable" class="pagination w3-table-all w3-responsive w3-content w3-round-large" data-pagecount="8" style="max-width:fit-content;">
        <tr class="w3-sand">
            <th class="w3-center">Industry</th>
            <th>Name</th>
            <th>Admin Email</th>
            <th>Templates</th>
            <th>Actions</th>
        </tr>
        <?php
            $sql = "SELECT * FROM f23_Industry_T";
            $query = mysqli_query($db_conn, $sql);
            while ($row = mysqli_fetch_assoc($query)) {
                $code = $row['ind_code'];
                $name = $row["ind_name"];
                $admin = $row['admin_email'];

                $select = "SELECT * FROM f23_JobTemplate_T WHERE ind_code ='".$row['ind_code']."'";
                $qry = mysqli_query($db_conn, $select);
                while ($template = mysqli_fetch_assoc($qry)) {
                    $templateID = $template['jobTemplate_id'];
                }
        ?>
        <tr>
            <td class="w3-center"><?php echo $code; ?></td>
            <td><?php echo $name; ?></td>
            <td><?php echo $admin; ?></td>
            <td><?php echo 'ID: '.$templateID.'<br>'; ?></td>
            <td>
                <form method="post" action="./dashboard.php?content=view&contentType=department">
                    <input type="hidden" name="department" value="<?php echo $code;?>">
                    <button type="submit" name="viewDepartment" class="w3-button w3-blue w3-round-large">View</button>
                </form>
            </td>
        </tr>
        <?php } ?>
    </table>
</div>