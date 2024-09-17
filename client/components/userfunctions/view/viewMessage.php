<?php
    if(!isset($_SESSION)) {
        session_start();
    }
    //User has not signed in.
    if(!isset($_SESSION['user_type'])) {
        echo "<div class='w3-panel w3-margin w3-red'><p>Session Expired, Please sign in again.</p></div>";
        exit();
    }

    //Message ID was not sent to the page.
    if(!isset($_POST['message_ID'])) {
        echo "<div class='w3-panel w3-margin w3-red'><p>Error! No message recieved</p></div>";
        exit();
    }
    else {
        include_once('../../backend/util.php');
        include_once('../../backend/db_connector.php');
        include_once('../../backend/config.php');

        //Gather data passed to this page.
        $messageID = isset($_POST['message_ID']) ? mysqli_real_escape_string($db_conn, $_POST['message_ID']) : '';

        // Make sure $messageID is not empty
        if (empty($messageID)) {
            echo "<div class='w3-panel w3-margin w3-red'><p>Error! No message received</p></div>";
            exit();
        }
        // Fetch the status value here
    $status = mysqli_fetch_assoc(mysqli_query($db_conn, "SELECT message_status FROM f23_Message_T WHERE message_id = '$messageID'"));

        if ($_SERVER["REQUEST_METHOD"] == "POST"){

            //Change message status to "read" upon viewing for the first time
            $sql = "SELECT message_status FROM f23_Message_T WHERE message_id = ?";
            $stmt = $db_conn->prepare($sql);
            $stmt->bind_param("i", $messageID); 
            $stmt->execute();
            $stmt->bind_result($currentStatus);
            $stmt->fetch();
            $stmt->close();
        
            // If the current status is 'new', update it to 'read'
            if ($currentStatus == 1) {
                $sql = "UPDATE f23_Message_T SET message_status = 2 WHERE message_id = ?";
                $stmt = $db_conn->prepare($sql);
                $stmt->bind_param("i", $messageID); 
                $stmt->execute();
                $stmt->close();
            }

            //User chooses to delete message.
            if(isset($_POST['deletion'])) {
                $sql = "UPDATE f23_Message_T SET message_status = 3 WHERE message_ID = '$messageID'";
                if ($db_conn->query($sql) === TRUE) {
                    echo("<div class='w3-panel w3-margin w3-green'><p>Message Deleted </p></div>");
                } 
                else {
                    echo("<div class='w3-panel w3-margin w3-red'><p>Error Deleting Message: " . $db_conn->error . "</p></div>");
                }
            }

            //User chooses to archive message.
            if(isset($_POST['archive'])) {
                $sql = "UPDATE f23_Message_T SET message_status = 4 WHERE message_ID = '$messageID'";
                if ($db_conn->query($sql) === TRUE) {
                    echo("<div class='w3-panel w3-margin w3-green'><p>Message Archived </p></div>");
                } 
                else {
                    echo("<div class='w3-panel w3-margin w3-red'><p>Error Deleting Message: " . $db_conn->error . "</p></div>");
                }
            }

            //User chooses to return to inbox
            if(isset($_POST['back'])){
                $status = mysqli_fetch_assoc(mysqli_query($db_conn, "SELECT message_status FROM f23_Message_T WHERE message_id = '$messageID'"));
                $ID = mysqli_fetch_assoc(mysqli_query($db_conn, "SELECT message_sender FROM f23_Message_T WHERE message_id = '$messageID'"));
                //$userID = "SELECT UID FROM f23_User_Table WHERE UID = '$thisUser'";
                //if($ID = $userID){
                   // echo '<script>window.location.href = "/p/s24-03/v3/client/components/dashboard.php?content=sentmessages";</script>';
                   // exit();
                //}
                if ($status['message_status'] == 3) {
                    echo '<script>window.location.href = "/p/s24-03/v3/client/components/dashboard.php?content=deleted";</script>';
                    exit();
                }
                if ($status['message_status'] == 4) {
                    echo '<script>window.location.href = "/p/s24-03/v3/client/components/dashboard.php?content=archivedmessages";</script>';
                    exit();
                }
                    echo '<script>window.location.href = "/p/s24-03/v3/client/components/dashboard.php?content=messages";</script>';
                    exit();
            }
            else {
                //Find all data related to the message.
                $sql = "SELECT * FROM f23_Message_T WHERE message_id = '$messageID'";
                $query = mysqli_query($db_conn, $sql);
                $row = mysqli_fetch_assoc($query);
?>

<!-- Message Information -->
<div id="userForm" class="w3-padding w3-margin">
    <form method="post" action="">
    <div class="w3-left" id="backButton">
            <input type="hidden" name="message_ID" value="<?php echo $messageID; ?>">
            <button type="submit" id="back" class="w3-button w3-black" name="back" >Back</button>
        </div>
        <div class="w3-right" id="actionButtons">
            <input type="hidden" name="message_ID" value="<?php echo $messageID; ?>">
            <button type="submit" id="archive" class="w3-button w3-purple" name="archive" style="margin-right: 5px;">Archive</button>
            <button type="submit" id="deletion" class="w3-button w3-red" name="deletion" style="margin-right: 5px;">DELETE</button>
        </div>
    </form>
</div>

    <hr>
    <form method="post" action="./dashboard.php?content=view&contentType=message">
    <div class="w3-card-4">
    <?php
        $messageSenderId = $row['message_sender'];
        $messageTypeId = $row['message_type'];
		$messageStatusId = $row['message_status'];
        $messageSender = mysqli_fetch_assoc(mysqli_query($db_conn, "SELECT * FROM f23_User_Table WHERE UID = '$messageSenderId'"))['user_name'];
        $messageContent = $row['message_contents'];
        $messageID = $row['message_id'];
        $messageSubject = $row['message_subject'];
	?>
         <!-- this displays the message sender as the database queried sender -->
        <div class="w3-container w3-light-grey">
            <h3>From: <?php echo $messageSender; ?></h3>
        </div>
        <hr>
        <div class="w3-container w3-row"> <!-- container for avatar image and message contents -->
            <div class="w3-col" style="width: 250px;">
                <img src="../assets/w3avatar.png" alt="Avatar" class="w3-circle" style="width: 100%;">
            </div>
            <div class="w3-rest" style="padding-left: 20px;">
                <h3 style="font-weight: bold;"> Subject: <?php echo $messageSubject; ?></h3>
                <hr>
                <p class="w3-padding w3-xlarge"  id="messageContents"><?php echo $messageContent; ?></p>
            </div>
        </div>
        <button class="w3-button w3-block w3-dark-grey" type="button" onclick="toggleReply()">Reply</button>
    </div>
<hr>
<form method="post" action="./dashboard.php?content=view&contentType=message">
    <input type="hidden" name="message_ID" value="<?php echo $messageID; ?>"> <!-- Add this line -->
    <div>
        <textarea class="w3-input w3-border w3-round-large" type="text" placeholder="Type your reply..." name="reply"></textarea>
        <hr>
        <button class="w3-button w3-block w3-green" type="submit" name="submitReply">Submit Reply</button> <!-- Change type to submit -->
    </div>
</form>

            </form>

<?php
if (isset($_POST['submitReply'])) {
		$senderName = $_SESSION['user_name']; //session variable from login to get user id without it being an input field 
		$senderID = mysqli_fetch_assoc(mysqli_query($db_conn, "SELECT * FROM f23_User_Table WHERE user_name = '$senderName'"))['UID'];
	    $sender = mysqli_real_escape_string($db_conn, $senderID);
		$receiver = mysqli_real_escape_string($db_conn, $messageSenderId); // The former sender
        $type = '2';
        $status = '1';
		$subject = "RE: " . $messageSubject;
        $contents = mysqli_real_escape_string($db_conn, $_POST['reply']);
        $date = date("Y-m-d");
        
		// find current largest uid 
        $findMessage_id = "SELECT MAX(message_id) AS max_message_id FROM f23_Message_T";
        $MIDresult = mysqli_query($db_conn, $findMessage_id);
        $MIDresult = mysqli_fetch_assoc($MIDresult);
        $MID = $MIDresult['max_message_id'];
        $MID = $MID + 1;


        $insertMessage = "INSERT INTO f23_Message_T (message_id, message_type, message_status, task_id, message_sender, message_receiver, message_subject, message_contents, message_created) 
                            VALUES ('$MID', '$type', '$status', 1, '$sender', '$receiver', '$subject', '$contents', '$date')";
       if ($insertMessageQuery = mysqli_query($db_conn, $insertMessage)) {
        echo "<div class='w3-panel w3-margin w3-green'><p>Reply sent!</p></div>";
    } else {
        // Display a more specific error message including the MySQL error
        echo("<div class='w3-panel w3-margin w3-red'><p>Error - Message could not be sent. Please try again later. If the problem persists, please contact support. MySQL Error: " . mysqli_error($db_conn) . "</p></div>");
    }
    }
?>

<!-- Enable/Disable table editing Script -->
<script>

    function changeStatus(messageID){ //ajax call to change message status in db
        $("#archive").click(function(){
            $.ajax({
                url: '../../backend/ajaxFunctions/changeStatus.php',
                type: 'POST',
                data: {
                    id: messageID,
                    action: "change"
                },
                success:function(response){
                    $('#messageContents').replaceWith("<p> Message has been moved </p>");
                }
            })

        });
    }

    function angrilyDelete(messageID){ //function to officially delete a message officially
        $("#deletion").click(function(){
            $.ajax({
                url: '../../backend/ajaxFunctions/deleteMes.php',
                type: 'POST',
                data: {
                    id: messageID,
                    action: "delete"
                },
                success:function(data){
                    $('#messageContents').replaceWith("<p> Message has been deleted </p>");
                }
            })

        });
    }
</script>

<?php }
    }
    }
?>