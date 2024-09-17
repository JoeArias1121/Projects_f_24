<?php
    if(!isset($_SESSION)) {
        session_start();
    }
    //User has not signed in.
    if(!isset($_SESSION['user_type'])) {
        header('Location: ./views/login.php');
    }
?>

<?php
    
    include_once('../../backend/config.php');
    include_once('../../backend/db_connector.php');
	if($_SESSION['user_type'] == 1){
		$thisUser = $_SESSION['user_id'];
    //include_once('./backend/contentRouter.php');
?>



<!-- Admin Messages (admin can see all messages)-->
<div id="messages" class="w3-card w3-white w3-round-large w3-padding w3-margin">
    
    <h5>Messages</h5>
    <p>You may search by receiver, sender, subject, or message contents</p>
    <input style="width:300px" class="w3-round-large" type="text" id="userInput" onkeyup="search('messageTable', 'userInput')"></input>
    <table id="messageTable" class="pagination w3-table-all w3-responsive w3-table w3-striped w3-bordered w3-round-large" data-pagecount="8" style="max-width:fit-content;">
        <tr>
            <th class="w3-center"></th>
            <th class="w3-center">Sender</th>
            <th class="w3-center">Receiver</th>
            <th class="w3-center">Message Type</th>
            <th class="w3-center">Message Status</th>
			<th class="w3-center">Message Subject</th>
			<th class="w3-center">Message Contents</th>
            <th class="w3-center">Message Date </th>
            <th class="w3-center">Action</th>
        </tr>
        <?php
            $sql = "SELECT * FROM f23_Message_T WHERE (message_receiver = '1' AND (message_status = '4')) ORDER BY message_created DESC";
            $query = mysqli_query($db_conn, $sql);
            if (!$query) {
                die('Error: ' . mysqli_error($db_conn));
            }

            while ($row = mysqli_fetch_assoc($query)) {
                $messageId = $row['message_id'];

                // Fetch sender and receiver names
                $messageSenderId = $row['message_sender'];
                $messageSender = mysqli_fetch_assoc(mysqli_query($db_conn, "SELECT * FROM f23_User_Table WHERE UID = '$messageSenderId'"))['user_name'];

                $messageReceiverId = $row['message_receiver'];
                $messageReceiver = mysqli_fetch_assoc(mysqli_query($db_conn, "SELECT * FROM f23_User_Table WHERE UID = '$messageReceiverId'"))['user_name'];

                 // Fetch other data
                $messageTypeId = $row['message_type'];
                $messageStatusId = $row['message_status'];
                $messageStatus = mysqli_fetch_assoc(mysqli_query($db_conn, "SELECT * FROM f23_MessageStatus_T WHERE messageStatus_id = '$messageStatusId'"))['messageStatus_title'];
                $messageType = mysqli_fetch_assoc(mysqli_query($db_conn, "SELECT * FROM f23_MessageType_T WHERE messageType_id = '$messageTypeId'"))['messageType_title'];

                $messageSubject = $row['message_subject'];
                $messageContents = $row['message_contents'];
                $messageDate = $row['message_created'];
            
        ?>
        <tr>
        <td><img src="../assets/w3avatar.png" alt="Person" style="height: 50px;"></td>
            <td><?php echo $messageSender; ?></td>
            <td><?php echo $messageReceiver; ?></td>
            <td><?php echo $messageType; ?></td>
            <td><?php echo $messageStatus; ?></td>
			<td><?php echo $messageSubject; ?></td>
			<<td>
                <?php   if(strlen($messageContents) < 50){
                            echo ($messageContents);
                        }
                        else{
                            echo substr($messageContents, 0, 50) . " ...";
                        } ?>
            </td>
            <td><?php echo $messageDate; ?></td>
            <td>
                <form method="post" action="./dashboard.php?content=view&contentType=message">
                    <!-- The hidden input field must be used to pass the message the user has selected
                        to the next page. -->
                    <input type="hidden" name="message_ID" value="<?php echo $messageId;?>">
                    <button type="submit" name="viewMessage" class="w3-button w3-blue w3-round-large">View</button>
                </form>
            </td>
        </tr>
        <?php } ?>
    </table>
</div>
	<?php } else { $thisUser = $_SESSION['user_id']; ?>
	
<!-- User Messages (non admins can only see their own messages)-->
<div id="messages" class="w3-card w3-round-large w3-white w3-padding w3-margin">
   
    <h5>Messages</h5>
    <p>You may search by receiver, sender, or message contents</p>
    <input style="width:300px" class="w3-round-large" type="text" id="userInput" onkeyup="search('messageTable', 'userInput')"></input>
    <p></p>
    <table id="messageTable" class="pagination w3-table-all w3-responsive w3-table w3-striped w3-bordered" data-pagecount="8" style="max-width:fit-content;">
        <tr>
            <th></th>
            <th class="w3-center">Sender</th>
            <th class="w3-center">Message Type</th>
            <th class="w3-center">Message Status</th>
			<th class="w3-center">Message Subject</th>
			<th class="w3-center">Message Contents</th>
            <th class="w3-center">Message Date</th>
        </tr>
        <?php
            $sql = "SELECT * FROM f23_Message_T WHERE (message_receiver = '$thisUser' AND (message_status = '4')) ORDER BY message_created DESC";
            $query = mysqli_query($db_conn, $sql);
            if (!$query) {
                die('Error: ' . mysqli_error($db_conn));
            }

            while ($row = mysqli_fetch_assoc($query)) {
                $messageId = $row['message_id'];

                // Fetch sender and receiver names
                $messageSenderId = $row['message_sender'];
                $messageSender = mysqli_fetch_assoc(mysqli_query($db_conn, "SELECT * FROM f23_User_Table WHERE UID = '$messageSenderId'"))['user_name'];

                $messageReceiverId = $row['message_receiver'];
                $messageReceiver = mysqli_fetch_assoc(mysqli_query($db_conn, "SELECT * FROM f23_User_Table WHERE UID = '$messageReceiverId'"))['user_name'];

                 // Fetch other data
                $messageTypeId = $row['message_type'];
                $messageStatusId = $row['message_status'];
                $messageStatus = mysqli_fetch_assoc(mysqli_query($db_conn, "SELECT * FROM f23_MessageStatus_T WHERE messageStatus_id = '$messageStatusId'"))['messageStatus_title'];
                $messageType = mysqli_fetch_assoc(mysqli_query($db_conn, "SELECT * FROM f23_MessageType_T WHERE messageType_id = '$messageTypeId'"))['messageType_title'];

                $messageSubject = $row['message_subject'];
                $messageContents = $row['message_contents'];
                $messageDate = $row['message_created'];

        ?>
        <tr>
            <td><img src="../assets/w3avatar.png" alt="Person" style="height: 50px;"></td>
            <td><?php echo $messageSender; ?></td>
            <td><?php echo $messageType; ?></td>
            <td><?php echo $messageStatus; ?></td>
			<td><?php echo $messageSubject; ?></td>
			<td>
                <?php   if(strlen($messageContents) < 50){
                            echo ($messageContents);
                        }
                        else{
                            echo substr($messageContents, 0, 50) . " ...";
                        } ?>
            </td>
            <td><?php echo $messageDate; ?></td>
            <td>
                <form method="post" action="./dashboard.php?content=view&contentType=message">
                    <!-- The hidden input field must be used to pass the message the user has selected
                        to the next page. -->
                    <input type="hidden" name="message_ID" value="<?php echo $messageId;?>">
                    <button type="submit" name="viewMessage" class="w3-button w3-blue w3-round-large">View</button>
                </form>
            </td>
        </tr>
        <?php } ?>
    </table>
</div>
<?php } ?>