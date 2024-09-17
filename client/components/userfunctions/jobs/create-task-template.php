<?php
if (!isset($_SESSION)) {
    session_start();
}
include_once('../../../../backend/db_connector.php');


$task_title = $task_type = $task_instructions = $templateStatus_id = "";
$task_title_err = $task_type_err = $task_instructions_err = $templateStatus_id_err = "";

// task template results

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate entries
    if (empty(trim($_POST["task_title"]))) {
        $task_title_err = "Please enter a title.";
    } else if (empty(trim($_POST["task_type"]))) {
        $task_type_err = "Please enter a task type.";
    } else if (empty(trim($_POST["task_instructions"]))) {
        $task_instructions_err = "Please enter task template instructions.";
    } else if (empty(trim($_POST["templateStatus_id"]))) {
        $templateStatus_id_err = "Please enter task template status id.";
    } else {
        // Prepare a insert into statement
        $sql = "INSERT INTO s24_StepTemplate_T (taskTemplate_id, task_type, task_title, task_instructions, templateStatus_id, ind_code,
                form_id) VALUES (?, ?, ?, ?, ?, ?, ?)";

        if ($stmt = mysqli_prepare($db_conn, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "iissisi", $par1, $par2, $par3, $par4, $par5, $par6, $par7);
            // Set parameters
          
          
            $findID = "SELECT MAX(taskTemplate_id) AS template_id FROM s24_StepTemplate_T";
            $IDresult = mysqli_query($db_conn, $findID);
            $IDresult = mysqli_fetch_assoc($IDresult);
            $templateID = $IDresult['template_id'];
            $templateID = $templateID + 1;
            $par1 = $templateID;
          
            //$par1 = trim($_POST["taskTemplate_id"]);
            $par2 = trim($_POST["task_type"]);
            $par3 = trim($_POST["task_title"]);
            $par4 = trim($_POST["task_instructions"]);
            $par5 = trim($_POST["templateStatus_id"]);
            $par6 = trim($_POST["indCode"]);
            $par7= trim($_POST["form_add"]);


            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                /* store result */
                mysqli_stmt_store_result($stmt);
                echo "Template Created";
            } else {
                echo ("Oops! Something went wrong. Please try again later. ");
            }
            // Close statement
            mysqli_stmt_close($stmt);

        }
    }
    // Close connection
   // header("Refresh:1");
    mysqli_close($db_conn);
}

?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Create a Task Template</title>
</head>
<style>
body {
    font-family: "Raleway", sans-serif;
    font-size:small
    }
</style>
<body>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <div class="<?php echo (!empty($task_title_err)) ? 'w3-red' : ''; ?>">
            <label for="task_title">Title</label>
            <input type="text" class="w3-input w3-border w3-round-large" name="task_title" value="<?php echo $task_title; ?>">
            <span class="w3-red"><?php echo $task_title_err; ?></span>
        </div>
        <br>
        <label for="indCode">Industry:</label>
        <select id="indCode" name="indCode" class="w3-input w3-border w3-round-large">
        <option value='0'>None</option>
            <?php
            $sql = "SELECT * FROM f23_Industry_T ORDER BY ind_code ASC";
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
        <div class=" <?php echo (!empty($task_type_err)) ? 'has-error' : ''; ?>">
            <legend>Task Type</legend>
            <input class="w3-radio w3-red" type="radio" name="task_type" value="1">
            <label for="task_type">Urgent</label>
            <br>
            <input class="w3-radio w3-orange" type="radio" name="task_type" value="2">
            <label for="task_type">Normal</label>
            <span class="w3-red"><?php echo $task_type_err; ?></span>

        </div>
        <br>
        <div class=" <?php echo (!empty($templateStatus_id_err)) ? 'w3-orange' : ''; ?>">
            <legend>Task Status</legend>
            <input class="w3-radio" type="radio" name="templateStatus_id" value="1">
            <label for="task_type">Ready</label>
            <br>
            <input class="w3-radio" type="radio" name="templateStatus_id" value="2">
            <label for="task_type">Not Ready</label>
            <br>
            <input class="w3-radio" type="radio" name="templateStatus_id" value="3">
            <label for="task_type">Inactive</label>
            <br>
            <span class="w3-orange"><?php echo $templateStatus_id_err; ?></span>

        </div>
        <br>

        <label for="form_add">Add Form:</label>
        <select class="w3-input w3-border w3-round-large" name="form_add" id="form_add" placeholder="Choose Form to Add">
            <option value='0'>Select Form</option>
        <?php
        $sql1 = "SELECT * FROM f23_Form_Templates";
        $indquery1 = mysqli_query($db_conn, $sql1);
        $r1 = mysqli_num_rows($indquery1);
        if ($r1 > 0) {
                while ($result = mysqli_fetch_assoc($indquery1)) {
                    $um = $result['title'];
                    $formValue = $result['TID'];
                    echo ("<option value=" . $formValue . ">" . $um . "</option>");
                }
            }
            ?>
        </select>



        <br>
        <div class="w3-center <?php echo (!empty($task_instructions_err)) ? 'w3-orange' : ''; ?>">
            <label for="task_instructions">Task Instructions:</label>
            <br>
            <textarea name="task_instructions" class="textarea w3-border w3-round-large" value="<?php echo $task_instructions; ?>" cols="30" rows="10"></textarea>
            <span class="w3-orange"><?php echo $task_instructions_err; ?></span>
        </div>
        <br>
        <div class="w3-center">
            <input class="w3-button w3-blue w3-round-large" type="submit" value="Create Task Template">
        </div>
        </form>

</body>

</html>