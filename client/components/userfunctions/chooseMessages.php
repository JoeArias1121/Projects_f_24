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
?>



<!-- Admin Messages (admin can see all messages)-->
<!--  <div id="messages" class="w3-bar w3-light-grey">
    <!-- <a href="#" class="w3-bar-item w3-button w3-large" onclick="window.location.href='../components/dashboard.php?content=home'">Home</a>-->
   <!--   <a href="#" class="w3-bar-item w3-button w3-large" onclick="window.location.href='./dashboard.php?content=allmessages'">Inbox</a>
    <a href="#" class="w3-bar-item w3-button w3-large" onclick="window.location.href='./dashboard.php?content=deleted'">Deleted Messages</a>
    <a href="#" class="w3-bar-item w3-button w3-large" onclick="window.location.href='./dashboard.php?content=sentmessages'">Sent Messages</a>
    <button class="w3-button w3-right w3-blue w3-margin-right w3-round-large" type="button" onclick="window.location.href='./dashboard.php?content=create&contentType=message'">Compose Message</button>

</div>-->

	<?php //} 
	
	//else { $thisUser = $_SESSION['user_id']; ?>
	
<!-- User Messages (non admins can only see their own messages)-->
<!--  <div id="messages" class="w3-bar w3-light-grey">
    <!--  <a href="#" class="w3-bar-item w3-button w3-large" onclick="window.location.href='../components/dashboard.php?content=home'">Home</a>-->
    <!--   <a href="#" class="w3-bar-item w3-button w3-large" onclick="window.location.href='./dashboard.php?content=allmessages'">Inbox</a>
    <a href="#" class="w3-bar-item w3-button w3-large" onclick="window.location.href='./dashboard.php?content=deleted'">Deleted Messages</a>
    <a href="#" class="w3-bar-item w3-button w3-large" onclick="window.location.href='./dashboard.php?content=sentmessages'">Sent Messages</a>
    <button class="w3-button w3-right w3-blue w3-margin-right w3-round-large" style="margin-top:10px;" type="button" onclick="window.location.href='./dashboard.php?content=create&contentType=message'">Compose Message</button>

</div>-->

  


<?php } ?>