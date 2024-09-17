<?php
if (!isset($_SESSION)) {
    session_start();
}

include_once('../../../../backend/db_connector.php');


$job_title = $job_instructions = $templateStatus_id = "";
$job_title_err = $job_instructions_err = $templateStatus_id_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate entries
    if (empty(trim($_POST["job_title"]))) {
        $job_title_err = "Please enter a title.";
    } else if (empty(trim($_POST["job_instructions"]))) {
        $job_instructions_err = "Please enter job template instructions.";
    } else if (empty(trim($_POST["templateStatus_id"]))) {
        $templateStatus_id_err = "Please enter job template status id.";
    } else {
        // Prepare a insert into statement
        $sql = "INSERT INTO f23_JobTemplate_T (job_title, job_instructions, templateStatus_id, ind_code) VALUES (?, ?, ?, ?)";

        if ($stmt = mysqli_prepare($db_conn, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssis", $par1, $par2, $par3, $par4);
            // Set parameters
            $par1 = trim($_POST["job_title"]);
            $par2 = trim($_POST["job_instructions"]);
            $par3 = trim($_POST["templateStatus_id"]);
            $par3 = $_POST["indCode"];

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                /* store result */
                mysqli_stmt_store_result($stmt);
                echo "Template Created";
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
            header("Refresh:1");
            // Close statement
            mysqli_stmt_close($stmt);
            
        }
    }
    // Close connection
    mysqli_close($db_conn);
    header("Refresh:1");
}

?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Create a Job Template</title>
</head>
<style>
    body {
        font-family: "Raleway", sans-serif
    }
</style>

<body>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <div <?php echo (!empty($job_title_err)) ? 'has-error' : ''; ?>>
            <label for="job_title">Job Title</label>
            <input type="text" class="w3-input w3-border w3-round-large" name="job_title" value="<?php echo $job_title; ?>">
            <span class="has-text-danger"><?php echo $job_title_err; ?></span>
        </div>

        <p>
        <div class=" <?php echo (!empty($templateStatus_id_err)) ? 'w3-red' : ''; ?>">
            <legend>Job Status</legend>
            <input class="w3-radio" type="radio" name="templateStatus_id" value="1">
            <label for="job_type">Ready</label>
            <br>
            <input class="w3-radio" type="radio" name="templateStatus_id" value="2">
            <label for="job_type">Not Ready</label>
            <br>
            <input class="w3-radio" type="radio" name="templateStatus_id" value="3">
            <label for="job_type">Inactive</label>
            <br>
            <span class="w3-red"><?php echo $templateStatus_id_err; ?></span>

        </div>
        <br>
        <label for="indCode">Industry:</label>
        <select id="indCode" name="indCode" class="w3-input w3-border w3-round-large">
        <option value='0'>None</option>
            <?php
            $sql = "SELECT * FROM industry_T ORDER BY ind_code ASC";
            $indquery  = mysqli_query($db_conn, $sql);
            $r = mysqli_num_rows($indquery);
            if ($r > 0) {
                while ($result = mysqli_fetch_assoc($indquery)) {
                    $indCode = $result['ind_code'];
                    echo ("<option value=" . $indCode . ">" . $indCode . "</option>");
                }
            }
            ?>
        </select>
        <br>
        <div <?php echo (!empty($job_instructions_err)) ? 'has-error' : ''; ?>>
            <label for="job_instructions">Job Instructions:</label>
            <br>
            <textarea name="job_instructions" class="textarea w3-border w3-input w3-round-large" value="<?php echo $job_instructions; ?>" cols="30" rows="10"></textarea>
            <span class=""><?php echo $job_instructions_err; ?></span>
        </div>
        <p>
        <div class="w3-center">
            <input class="w3-button w3-blue w3-round" type="submit" value="Create Job Template">
        </div>
    </form>


</body>

</html>