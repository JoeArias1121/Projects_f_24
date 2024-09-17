<?php
//Loading the page title and action buttons.
include_once('./userfunctions/miscFunc/users.php');
include_once('../../backend/config.php');
include_once('../../backend/db_connector.php');
include_once('../../backend/emailPlugin.php');


    if (isset($_POST['userCreate'])) {
        $userName = mysqli_real_escape_string($db_conn, $_POST['name']);
        $userEmail = mysqli_real_escape_string($db_conn, $_POST['email']);
        $userType = mysqli_real_escape_string($db_conn, $_POST['type']);
        $userPass = mysqli_real_escape_string($db_conn, $_POST['pswd']); 
        $userLoginName = mysqli_real_escape_string($db_conn, $_POST['username']);
        $company = mysqli_real_escape_string($db_conn, $_POST['company']);

        $insertUser = "INSERT INTO f23_User_Table (URID, USID, user_email, user_login_name, user_password, user_name, company) 
                            VALUES ($userType, 1,'$userEmail', '$userLoginName', '$userPass', '$userName', '$company')";
        $insertUserQuery = mysqli_query($db_conn, $insertUser);

    //Database insert success
    if (mysqli_errno($db_conn) == 0) {
        echo("<div class='w3-panel w3-margin w3-green'><p>User Successfully Created.</p></div>");
        $message = "<html>

        <p>We're glad you're joining us. You have successfully created a Nexus Workflow System Account.</p>
    
        <p>Your login credentials:</p>
        <p>Email: ".$userEmail."<br>
            Password: ".$userPass."</p>
    
        <p>Please login to change your password: https://cs.newpaltz.edu/p/s22-03/v4/client/views/login.php</p>
    
        <hr>
    
        <br>
        <br>
        Please do not reply to this email as it is sent from an unattended mailbox.
    
    </html>";
        sendMail($userEmail, "Nexus Workflow Account", $message);

    } 
    //Database detected duplicate entry
    else if (mysqli_errno($db_conn) == 1062) {  
        echo("<div class='w3-panel w3-margin w3-red'><p>Failed to Create User - Duplicate Found.</p></div>");
    }
}
?>

<!-- Create User -->
<div id="userForm" class="w3-card w3-white w3-padding w3-margin w3-round-large">
    <h5 class="w3-center">Create User</h5>
    <form method="post" action="./dashboard.php?content=create&contentType=user">
        <label for="name">Full Name</label>
        <input id="name" name="name" type="text" class="w3-input w3-border w3-round-large w3-sand" required>
        <br>
        <label for="email">Email Address</label>
        <input id="email" name="email" type="email" class="w3-input w3-border w3-round-large w3-sand" required>
        <br>
        <label for="pswd">Username</label>
        <input id="username" name="username" type="text" class="w3-input w3-border w3-round-large w3-sand" required>
        <br>
        <label for="pswd">Password</label>
        <input id="pswd" name="pswd" type="password" class="w3-input w3-border w3-round-large w3-sand" required>
        <br>
        <label for="type">User Type</label>
        <select id="type" name="type" class="w3-input w3-border w3-round-large w3-sand" required>
            <option value="">Select a User Type.</option>
            <?php
                $sql = "SELECT * FROM f23_User_Role_Table";
                $query = mysqli_query($db_conn, $sql);
                while ($row = mysqli_fetch_assoc($query)) {
                    echo("<option value='" . $row['URID'] . "'>" . $row['user_role_title'] . "</option>");
                }
            ?>
        </select>
        <br>
        <label for="company">Company</label>
        <select id="company" name="company" class="w3-input w3-border w3-round-large w3-sand" required>
            <option value="NULL">None</option>
            <?php
                $sql = "SELECT * FROM f23_Company_T";
                $query = mysqli_query($db_conn, $sql);
                while ($row = mysqli_fetch_assoc($query)) {
                    echo("<option value='" . $row['comp_id'] . "'>" . $row['comp_name'] . "</option>");
                }
            ?>
        </select>
        <br>
        <div class="w3-center">
        <button type="submit" class="w3-button w3-green w3-round-large" name="userCreate">Add User</button>
            </div>
    </form>
</div>