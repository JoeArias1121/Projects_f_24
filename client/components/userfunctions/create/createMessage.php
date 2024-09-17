<!--
    Consolidate "Create Message" into "View Message"
-->
<?php
    //Loading the page title and action buttons.
	if($_SESSION['user_type'] == 1){
    include_once('./userfunctions/chooseMessages.php');
	}
    include_once('../../backend/config.php');
    include_once('../../backend/db_connector.php');
    //include_once('../../backend/PHPMailer-master/sendMailwithPhp.php');

    include('../../backend/emailPlugin.php');
		

    if (isset($_POST['messageCreate'])) {
        $senderName = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : '';
        $senderID = mysqli_fetch_assoc(mysqli_query($db_conn, "SELECT UID FROM f23_User_Table WHERE user_name = '$senderName'"))['UID'];
        $receiverName = isset($_POST['receiver']) ? $_POST['receiver'] : '';
        $receiverID = mysqli_fetch_assoc(mysqli_query($db_conn, "SELECT UID FROM f23_User_Table WHERE user_name = '$receiverName'"))['UID'];
        $type = isset($_POST['type']) ? $_POST['type'] : 2;
        $status = isset($_POST['status']) ? $_POST['status'] : 1;
        $subject = $_POST['subject'];
        $contents = $_POST['contents'];
        $date = date("Y-m-d");
    
		//sends email to receiver is message type is urgent
		//if($type == 1){
		//$to = mysqli_fetch_assoc(mysqli_query($db_conn, "SELECT * FROM f20_user_table WHERE user_login_name = '$receiverName'"))['user_email'];
        	//$sub = document.getElementById('subject');
		//$msg = document.getElementById('contents');
		//$msg = wordwarp($msg,70);
		//sendMail("cooked4@newpaltz.edu","TEst","test");
         //test email function
          //sendMail("cooked4@hawkmail.newpaltz.edu","TEST EMAIL","<html><h1>This is a test <br></h1><p>hello world</p></html>");
	    //send_mail_by_PHPMailer();
        
		// find current largest uid 
        $findMessage_id = "SELECT MAX(message_id) AS max_message_id FROM f23_Message_T";
        $MIDresult = mysqli_query($db_conn, $findMessage_id);
        $MIDresult = mysqli_fetch_assoc($MIDresult);
        $MID = $MIDresult['max_message_id'];
        $MID = $MID + 1;


        $insertMessage = "INSERT INTO f23_Message_T (message_id, message_type, message_status, task_id, message_sender, message_receiver, message_subject, message_contents, message_created) 
                        VALUES ('$MID', '$type', '$status', 1, '$senderID', '$receiverID', '$subject', '$contents', '$date')";
    
    if(mysqli_query($db_conn, $insertMessage)) {
        echo("<div class='w3-panel w3-margin w3-green'><p>Message sent.</p></div>");
    } else {
        echo("<div class='w3-panel w3-margin w3-red'><p>Error - Message could not be sent.</p></div>");
    }
}

        
/*
        //Database insert success
        if (mysqli_errno($db_conn) == 0) {
	sendMail("cooked4@hawkmail.newpaltz.edu","TEST EMAIL","<html><h1>This is a test <br></h1><p>hello world</p></html>");
            echo("<div class='w3-panel w3-margin w3-green'><p>Message sent.</p></div>");
        } 
		else { echo("<div class='w3-panel w3-margin w3-red'><p>Error - Message could not be sent.</p></div>");}
        //Database detected duplicate entry
        //else if (mysqli_errno($db_conn) == 1062) {  
         //   echo("<div class='w3-panel w3-margin w3-red'><p>Failed to Create User - Duplicate Found.</p></div>");
        //}
    }*/


?>



<?php
if($_SESSION['user_type'] == 1){
	?>
<!-- Admin Create Message -->
<div id="userForm" class="w3-card w3-white w3-round-large w3-padding w3-margin">
    <h5>Compose Message</h5>
    <form method="post" action="./dashboard.php?content=create&contentType=message">
    <div class="w3-row w3-section">
        <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-user"></i></div>
            <div class="w3-rest">
            <select class="w3-input w3-border w3-round-large w3-sand" name="receiver" id="receiver" placeholder="Recipient">
		<option value='0'>Select Recipient</option>
        <?php
                    $sql1 = "SELECT user_name FROM f23_User_Table";
                    $result1 = mysqli_query($db_conn, $sql1);
                    if (mysqli_num_rows($result1) > 0) {
                        while ($row = mysqli_fetch_assoc($result1)) {
                            $userName = $row['user_name'];
                            echo "<option value='$userName'>$userName</option>";
                        }
                    }
                    ?>
        </select>
        </div>
    </div>
       	<br>
        <label for="type">Type</label>
        <div class="w3-row w3-section ">
            <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-sitemap"></i></div>
            <div class="w3-dropdown-hover">
                <select class="w3-select w3-input w3-border w3-round-large w3-sand" name="type">
                    <option value="" disabled selected>Message Type</option>
                    <option value="1">Urgent</option>
                    <option value="2">Normal</option>
                    <option value="3">Requires Response</option>
                </select>
            </div>
        </div>
	<br>

		<label for="subject">Message Status</label>
        <div class="w3-row w3-section">
            <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-bell"></i></div>
                <div class="w3-dropdown-hover">
                <select class="w3-select w3-input w3-border w3-round-large w3-sand" name="status">
                    <option value="" disabled selected>Message Status</option>
                    <option value="1">new</option>
                    <option value="2">read</option>
                    <option value="3">deleted</option>
                </select>
            </div>
        </div>


		<label for="subject">Message Subject</label>
        <div class="w3-row w3-section">
            <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-folder-open"></i></div>
                <div class="w3-rest">
                <input class="w3-input w3-border w3-round-large w3-sand" name="subject" type="text" placeholder="Message">
            </div>
        </div>


        <br>
        <label for="contents">Message Contents</label>
        <div class="w3-row w3-section">
            <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-pencil"></i></div>
                <div class="w3-rest">
                <textarea class="w3-input w3-border w3-round-large w3-sand" name="contents" type="text" placeholder="Message"></textarea>
            </div>
        </div>
        <br>
        <button type="submit" class="w3-button w3-blue w3-round-large" name="messageCreate">Send</button>
    </form>
</div>





<?php } else {?>
<!-- User Create Message -->
<div id="userForm" class="w3-card w3-white w3-round-large w3-padding w3-margin">
    <h5>Compose Message</h5>
    <form method="post" action="./dashboard.php?content=create&contentType=message">
    <div class="w3-row w3-section">
        <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-user"></i></div>
            <div class="w3-rest">
            <select class="w3-input w3-border w3-round-large w3-sand" name="receiver" id="receiver" placeholder="Recipient">
		<option value='0'>Select Recipient</option>
	<?php
    $sql1 = "SELECT user_name FROM f23_User_Table";
    $result1 = mysqli_query($db_conn, $sql1);
    if (mysqli_num_rows($result1) > 0) {
        while ($row = mysqli_fetch_assoc($result1)) {
            $userName = $row['user_name'];
            echo "<option value='$userName'>$userName</option>";
        }
    }
    ?>
        </select>
        </div>
    </div>
       	<br>
        <label for="type">Type</label>
        <div class="w3-row w3-section ">
            <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-sitemap"></i></div>
            <div class="w3-dropdown-hover">
                <select class="w3-select w3-input w3-border w3-round-large w3-sand" name="type">
                    <option value="" disabled selected>Message Type</option>
                    <option value="1">Urgent</option>
                    <option value="2">Normal</option>
                    <option value="3">Requires Response</option>
                </select>
            </div>
        </div>
	<br>

		<label for="subject">Message Subject</label>
        <div class="w3-row w3-section">
            <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-folder-open"></i></div>
                <div class="w3-rest">
                <input class="w3-input w3-border w3-round-large w3-sand" name="subject" type="text" placeholder="Message">
            </div>
        </div>


        <br>
        <label for="contents">Message Contents</label>
        <div class="w3-row w3-section">
            <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-pencil"></i></div>
                <div class="w3-rest">
                <textarea class="w3-input w3-border w3-round-large w3-sand" name="contents" type="text" placeholder="Message"></textarea>
            </div>
        </div>
        <br>
        <button type="submit" class="w3-button w3-blue w3-round-large" name="messageCreate">Send</button>
    </form>
</div>
<?php }?>