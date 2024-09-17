<?php 
    //Including the action panel for navigation of the settings page.
    include_once('./userfunctions/settings/settings.php');

    //If the user has submitted the form to change the password.
    if(isset($_POST['changePassword'])) {
        //Gathering input from the forms.
        $userEmail = $_SESSION['user_email'];
        $currentPassword = $_POST['currentPassword'];
        $newPassword = $_POST['newPassword'];
        

        //Make the connection to the database and send the update sql.
        include_once('../../backend/db_connector.php');
        //Determine if the current password the user entered is correct.
        $sql = "SELECT * FROM f23_User_Table WHERE user_email = '$userEmail' AND user_password = '$currentPassword'";
        $result = mysqli_query($db_conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $count = mysqli_num_rows($result);
        if ($count == 1) {
            $sql = "UPDATE f23_User_Table SET user_password = $newPassword WHERE user_email = '$userEmail' AND user_password = '$currentPassword'";
            if($db_conn -> query($sql) === TRUE) {
                echo("<div class='w3-card w3-margin w3-padding w3-green'>Password successfully changed.</div>");
            }
            else {
                echo("<div class='w3-card w3-margin w3-padding w3-red'>Error changing password. " . $db_conn->error . "</div>");
            }
            $db_conn->close();
        }
        else {
            echo("<div class='w3-card w3-margin w3-padding w3-red'>Current Password does not match entered Password, please try again.</div>");
        }
    }
?>

<!-- Change Password Form -->
<div class="w3-card w3-white w3-round-large w3-padding w3-margin">
    <h5 class="w3-center w3-margin-bottom">Change Password</h5>
    <form method="post">
        <label for="currentPassword">Current Password:</label>
        <input class="w3-input w3-round-large w3-border w3-margin-bottom w3-sand" name="currentPassword" type="password" required>
        <label for="newPassword">New Password:</label>
        <input class="w3-input w3-round-large w3-border w3-margin-bottom w3-sand" name="newPassword" id="newPassword" type="password" required>
        <label for="confirmPassword">Confirm New Password:</label>
        <input class="w3-input w3-round-large w3-border w3-margin-bottom w3-sand" name="confirmPassword" id="confirmPassword" type="password" onkeyup="comparePasswords();" required>
        <div class="w3-card w3-margin w3-padding w3-red" id="errorMessage" style="display: none;">
        </div>
        <br>
        <div class="w3-center">
        <button class="w3-button w3-blue w3-round-large" type="submit" name="changePassword" id="changePassword" disabled>Change</button>
        </div>
    </form>
</div>

<script>
    function comparePasswords() {
        var newPassword = document.getElementById('newPassword').value;
        var confirmPassword = document.getElementById('confirmPassword').value;
        
        if(newPassword != confirmPassword) {
            document.getElementById('errorMessage').style.display = "block";
            document.getElementById('errorMessage').innerText = "Passwords do not match.";
            document.getElementById('changePassword').disabled = true;

        }
        else {
            document.getElementById('errorMessage').style.display = "none";
            document.getElementById('changePassword').disabled = false;
        }
    }
</script>