<?php
// Initialize the session
session_start();
include_once('../../../../backend/db_connector.php');

// get jobTemplate_id from $_GET from view-all-job-templates.php
if (!empty($_GET["jobTemplate_id"])) {
    $current_jobTemplate_id = trim($_GET["jobTemplate_id"]);
}

// toggle templateStatus_id of jobTemplate_T
if (isset($_GET['newTemplateStatus_id']) && isset($_GET['jobTemplate_id'])) {

    $current_jobTemplate_id = trim($_GET["jobTemplate_id"]);
    $newTemplateStatus_id = trim($_GET["newTemplateStatus_id"]);
    $industryCode = $_GET["indCode"];

    $status_sql = "UPDATE f23_JobTemplate_T SET templateStatus_id = ?, ind_code = ? WHERE jobTemplate_id = ?";

    if ($stmt = mysqli_prepare($db_conn, $status_sql)) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "isi", $par1, $par2, $par3);

        $par1 = $newTemplateStatus_id;
        $par2 = $industryCode;
        $par3 = $current_jobTemplate_id;

        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
    
}
if (isset($_GET['indCode']) && isset($_GET['jobTemplate_id'])) {
    $current_jobTemplate_id = trim($_GET["jobTemplate_id"]);
    $industryCode = $_GET["indCode"];

    $jobTemplate_sql = "UPDATE f23_JobTemplate_T SET ind_code = ?  WHERE jobTemplate_id = ?";

    if ($stmt = mysqli_prepare($db_conn, $jobTemplate_sql)) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "si", $par2, $par3);

        $par2 = $industryCode;
        $par3 = $current_jobTemplate_id;

        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
    if ($industryCode == '0')
    $industryCode = "None";
    echo "Industry Set To ".$industryCode;
}

$jobTemplate_results = mysqli_query($db_conn, 'SELECT * FROM f23_JobTemplate_T WHERE jobTemplate_id = ' . $current_jobTemplate_id);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>View Job Template</title>
</head>
<style>
    body {
        font-family: "Raleway", sans-serif
    }
</style>

<body>
    <div class="w3-row">
        <div class="m4 w3-col w3-container w3-center w3-padding-top-24">
            <h2 class="">Job Template Admin:</h2>
            <a href="./job-template-admin.php?jobTemplate_id=<?php echo $current_jobTemplate_id ?>"><button class="w3-button w3-green w3-round">View & Change</button></a>
        </div>
        <?php while ($job_temp = mysqli_fetch_object($jobTemplate_results)) { ?>

            <div class="m4 w3-col w3-container">
                <!-- <h6 class="">
                    Job Template Title:
                    <span class=" w3-display-topmiddle">
                        <?php echo $job_temp->job_title; ?>
                    </span>
                </h6> -->
                <hr>
                <h6 class="">Job Template Instructions:</h6>
                <p class="content">
                    <?php echo $job_temp->job_instructions; ?>
                </p>
                <hr>
                <h6 class="w3-center">Status:

                    <?php
                    $status = $job_temp->templateStatus_id;
                    if ($status == 1) {
                        echo "Ready/Activate";
                    } else if ($status == 2) {
                        echo "Not Ready/Deactivate";
                    } else {
                        echo "Delete/Hide";
                    }
                    ?>
                </h6>

                <br>
                <form action="./view-one-job-template.php" method="GET">

                    <!-- Radio Buttons -->
                    <h6>Edit Status: </h6>
                    <div class="">
                        <div class="">
                            <label class="radio">
                                <input class="w3-radio" type="radio" name="newTemplateStatus_id" value="1">
                                Ready/Activate
                            </label>
                            <br>
                            <label class="radio">
                                <input class="w3-radio" type="radio" name="newTemplateStatus_id" value="2">
                                Not Ready/Deactivate
                            </label>
                            <br>
                            <label class="radio">
                                <input class="w3-radio" type="radio" name="newTemplateStatus_id" value="3">
                                Delete/Hide
                            </label>

                        </div>
                    </div>
                    <br>
                    <label for="indCode">Industry:</label>
                    <select id="indCode" name="indCode" class="w3-input w3-border w3-round-large w3-sand">
                    <option value="<?php if($job_temp->ind_code == 0) echo "0"; else echo $job_temp->ind_code; ?>"><?php if($job_temp->ind_code == 0) echo "None"; else echo $job_temp->ind_code; ?></option>
                        <?php
                                    if ($job_temp->ind_code != Null) 
                                    echo("<option value='0'>None</option>");
                        $sql = "SELECT * FROM f23_Industry_T ORDER BY ind_code ASC";
                        $indquery  = mysqli_query($db_conn, $sql);
                        $r = mysqli_num_rows($indquery);
                        if ($r > 0) {
                            while ($result = mysqli_fetch_assoc($indquery)) {
                                $indCode = $result['ind_code'];
                                echo ("<option value=".$indCode.">" .$indCode. "</option>");
                            }
                        }
                        ?>
                    </select>
                    <input type="hidden" name="jobTemplate_id" value="<?php echo $current_jobTemplate_id; ?>">
                    <br>
                    <!-- Submit Button -->
                    <div class="">
                        <div class="">
                            <button type="submit" class="w3-button w3-blue w3-round">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        <?php } ?>
    </div>
</body>

</html>
