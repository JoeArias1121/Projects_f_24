<?php
    if(!isset($_SESSION)) {
        session_start();
    }
    //User has not signed in.
    if(!isset($_SESSION['user_type'])) {
        echo "<div class='w3-panel w3-margin w3-red'><p>Session Expired, Please sign in again.</p></div>";
        exit();
    }

    //Data ID was not sent to the page.
    if(!isset($_POST['dataID'])) {
        echo "<div class='w3-panel w3-margin w3-red'><p>Error! No data recieved</p></div>";
        exit();
    }
    else {
        include_once('../../backend/util.php');
        include_once('../../backend/config.php');
        include_once('../../backend/db_connector.php');
	
    $name = mysqli_real_escape_string($db_conn, $_POST['file']);
	$dataID = mysqli_real_escape_string($db_conn, $_POST['dataID']);
	$dataStat = mysqli_real_escape_string($db_conn, $_POST['dataStatus']);
	$data = mysqli_real_escape_string($db_conn, $_POST['dataLocation']);
	$ownerID = mysqli_real_escape_string($db_conn, $_POST['fileOwner']);
	//$ownerName = $_SESSION['user_name'];
	$sql = "SELECT user_name FROM f23_User_Table WHERE UID = '$ownerID'";
	$query = mysqli_query($db_conn, $sql);
	$result = "";
	while ($row = mysqli_fetch_assoc($query)) {
	    $result = $row['user_name'];
	}
	//echo $result;
	$ownerName = $result;
	
	

        //Gather data passed to this page.
       // $userEmail = mysqli_real_escape_string($db_conn, $_POST['dataID']);

        //User chooses to delete file.
      
        if(isset($_POST['saveUserChanges'])) {
            //Gather all input form fields.
            $dataType = mysqli_real_escape_string($db_conn, $_POST['type']);
            
            if($dataType == "Any") {
                $dataType = "1";
            } else if($dataType == "Self") {
                $dataType = "2";
            } else if($dataType == "Other") {
                $dataType = "3";
            } else if($dataType == "Form") {
                $dataType = "4";
            } else if($dataType == "File") {
                $dataType = "5";
            } else if($dataType == "Database") {
                $dataType = "6";
            } else {
                $dataType = "7";
            }
            
           // $dataStatus = mysqli_real_escape_string($db_conn, $_POST['status']);
            //$owner = mysqli_real_escape_string($db_conn, $_POST['name']);     
            $dataAlive = mysqli_real_escape_string($db_conn, $_POST['alive']);
            $dataApprove = mysqli_real_escape_string($db_conn, $_POST['approve']);
            $dataUnlock = mysqli_real_escape_string($db_conn, $_POST['unlock']);
            $dataActive = mysqli_real_escape_string($db_conn, $_POST['active']);
            $dataStatus = $dataAlive.$dataApprove.$dataUnlock.$dataActive;
            /*$sql = "UPDATE f20_data_T 
                        SET `data_owner` = $owner,
                        `dataStatus_id` = $dataStatus,
                        `dataType_id` = '$dataType'
			JOIN f20_dataType_T 
                            ON f20_data_T.dataType_id = f20_dataType_T.dataType_id
                        JOIN f20_dataStatus_T
                            ON f20_data_T.dataStatus_id = f20_dataStatus_T.dataStatus_id
                        WHERE `data_owner` = '$owner'";*/
            
            $insertData = "UPDATE f23_data_T SET dataStatus = '$dataStatus', dataType = '$dataType' WHERE data_id = $dataID";
            if ($db_conn->query($sql) === TRUE) {
                echo("<div class='w3-panel w3-margin w3-green'><p>Successfully Updated " . $owner . "</p></div>");
            } 
            else {
                echo("<div class='w3-panel w3-margin w3-red'><p>Error updating data: " . $db_conn->error . "</p></div>");
            }
        }
        else {
            //Find all data related to the user.
            $sql = "SELECT * FROM f23_data_T WHERE data_id='$dataID'";
            $query = mysqli_query($db_conn, $sql);
            $row = mysqli_fetch_assoc($query);
        
        
        
?>

<style>
.button {
  background-color: #008CBA;
  border: none;
  color: white;
  padding: 15px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 15px;
  margin: 4px 2px;
  cursor: pointer;
  border-radius: 8px;
}

textWhite
{
	color: #FFFFFF;
}
</style>

<!-- Content Title -->
<header class="w3-container">
    <h5><i class="fa fa-search"></i>  View File</h5>
</header>

<!-- User Information -->
<div id="userForm" class="w3-card w3-white w3-round-large w3-padding w3-margin">

    <h5 class="w3-center w3-margin-bottom" style="margin-left:100px"><b>File: <?php echo $name ?></b></h5>
	    <!--  <form method="post" action="./dashboard.php?content=view&contentType=user">-->
	    <form action="./dashboard.php?content=removeFile" method="POST" style ="text-align:left" enctype="multipart/form-data"> 
             <input type="hidden" name="dataID" value="<?php echo $dataID;?>">
             <input type="hidden" name="dataLocation" value="<?php echo $data;?>"> 
             <input type="hidden" name="fileOwner" value="<?php echo $ownerID;?>">
             <input type="hidden" name="file" value="<?php echo $name;?>">
             <input type="hidden" name="dataStatus" value="<?php echo $dataStat;?>">
             
              
			 <button type="submit" class="button w3-red w3-hover-shadow w3-round-large" style="margin-left: 1000px;" name="rF"><textWhite><b>Delete</b></textWhite></button>
			
            </form>
	    <form action="./dashboard.php?content=updateFile" method="POST" style ="text-align:left" enctype="multipart/form-data">
		
        <label class="w3-margin-top" for="owner">Owner</label>
        <input class="w3-input w3-border w3-sand w3-round-large w3-margin-bottom" id="owner" name="owner" type="text" value="<?php echo $ownerName ?>" readonly>
		
		<label class="" for="modifier">Data ID</label>
        <input class="w3-input w3-border w3-sand w3-round-large w3-margin-bottom" id="dataID" name="dataID" type="text" value="<?php echo $dataID ?>" readonly>
		
		<?php 
		
		if($_SESSION['user_type'] == 1){
		    
		    
		  $dataLocation = "https://cs.newpaltz.edu/p/f23-04/files/" . $ownerID ."_files/". $data;
		  echo "<script> let fileLink = '$dataLocation'; </script>";
		    
		} else if ($thisUser = $_SESSION['user_id']) {
		    
		    $user_ID = $_SESSION['user_id'];
		    
		    $dataLocation = "https://cs.newpaltz.edu/p/f23-04/files/" . $user_ID ."_files/". $data;
		    
		    //echo $dataLocation;
		    echo "<script> let fileLink = '$dataLocation'; </script>";
		}
		
		
		/*$user_ID = $_SESSION['user_id'];
		
		$dataLocation = "https://cs.newpaltz.edu/p/f23-04/files/" . $user_ID ."_files/". $data; 
		
		//echo $dataLocation;
		echo "<script> let fileLink = '$dataLocation'; </script>";*/
		?>
		
		<button type="button" class="button w3-green w3-hover-shadow w3-round-large" onclick="redirectPage()"><textWhite><b>File View</b></button>
		
		<br><br>
        <label for="subject">Data Status</label>
        <br>
        
        <?php 
         $statArr = str_split($dataStat); 
         $alive = $statArr[0];
         $approved = $statArr[1];
         $unlocked = $statArr[2];
         $active = $statArr[3];
         
         if($alive == "1") {
             $alive = "Alive";
         }else {
             $alive = "Terminated";
         }
         
         if($approved == "1") {
             $approved = "Approved";
         }else {
             $approved = "Unapproved";
         }
         
         if($unlocked == "1") {
             $unlocked = "Unlocked";
         }else {
             $unlocked = "Locked";
         }
         
         if($active == "1") {
             $active = "Active";
         }else {
             $active = "Passive";
         }
        
         /*
          * testing code
         echo "<br>". $alive . "<br>";
         echo $approved . "<br>";
         echo $unlocked . "<br>";
         echo $active . "<br>";*/
         ?>
         
          <input class="w3-input w3-border w3-sand w3-round-large w3-margin-bottom" id="status" name="status" type="text" value="<?php 
          echo $alive . ", " . $approved . ", " . $unlocked . ", " . $active ?>" readonly>
          
          
          <br>
          
         <div id="editStatus" style="display: none;"> 
         
           <input type="hidden" id="alive" name="alive" value="0">
           <input type="checkbox" id="alive" name="alive" value="1">
           <label for="alive"> Set Alive (Unchecked will set 'Terminated')</label><br>

           <input type="hidden" id="approve" name="approve" value="0">
           <input type="checkbox" id="approve" name="approve" value="1">
           <label for="approve"> Set Approved (Unchecked will set 'Unapproved')</label><br>

           <input type="hidden" id="unlock" name="unlock" value="0"> 
           <input type="checkbox" id="unlock" name="unlock" value="1"> 
           <label for="unlock"> Set Unlocked (Unchecked will set 'Locked')</label><br>
                
           <input type="hidden" id="active" name="active" value="0">
           <input type="checkbox" id="active" name="active" value="1">
           <label for="activate"> Set Active (Unchecked will set 'Passive')</label><br>
           <br>
         </div>
         
         
         <br>
		
        <label for="type">Data Type</label>
        <div class="w3-row w3-section">
			<div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-tasks"></i></div>
			<div class="w3-dropdown-hover">
				<select class="w3-select w3-input w3-border w3-sand w3-round-large" id="type" name="type" readonly>
				<option value="<?php //echo $row['dataType_title']; ?>"><?php //echo $row['dataType_title']; ?></option>
				<?php
					$sql = "SELECT * FROM f23_DataType_T";
					$query = mysqli_query($db_conn, $sql);
					 while ($typerow = mysqli_fetch_assoc($query)) {
						echo("<option value='" . $typerow['dataType_title'] . "'>" . $typerow['dataType_title'] . "</option>");
					}
				?>
			</select>
		
			</div>
			<br><br><br>
			<input type="hidden" name="dataID" value="<?php echo $dataID;?>">
			<input type="hidden" name="dataName" value="<?php echo $name;?>">
			<div class="w3-right">
			    <a href="./dashboard.php?content=files" id='fileRedirect' class='button w3-blue w3-hover-shadow' style="margin-right: 5px;"><i class="fa fa-reply"></i><b> Back</b></a>
			</div>
			  <div class="w3-right" id="actionButtons">
        <button type="button" class="button w3-blue w3-hover-shadow w3-round-large" name="editUser" style="margin-right: 5px;" onclick="enableEdit()"><b>Edit</b></button>
       <!-- <button type="submit" class="button w3-red w3-hover-shadow w3-round-large" name="removeFile" onclick="removeEntry('<?php //echo $userEmail ?>')"><b>Remove</b></button>-->
        </div>
        <div id="editButtons" class="w3-right" style="display: none;">
        <button type="submit" class="button w3-green w3-hover-shadow w3-round-large" name="saveUserChanges"><textWhite><b>Save</b></textWhite></button>
        <button type="button" class="button w3-grey w3-hover-shadow w3-round-large" onclick="disableEdit()"><textWhite><b>Cancel</b></textWhite></button>
        </div>
		</div>
        <br>
		
    </form>
    
</div>




<!-- Modal Pop-up to warn of deletion -->
<!--  <div id="warningHolder" class="w3-modal w3-center">
<div class="container-md">
  <div class = "tabs">
    <div class = "panel-body">
      <div class = "tab-content">
        <div class="w3-container w3-black">
            <p>Warning!!</p>
            <p>You are about to remove this file.</p>
            <p>Are you sure you want to do this?
                <br>
                <form method="post" action="./dashboard.php?content=removeFile">
                    <input type="hidden" name="dataID" value="<?php //echo $dataID;?>">
                    <input type="hidden" name="ownerUID" value="<?php //echo  $ownerID;?>">
                    <input type="hidden" name="dataLocation" value="<?php //echo $data;?>">
                    <!--  <input id="removeData" name="userEmail" type="hidden">-->
                   <!--   <button class="button w3-white" type="button" onclick="document.getElementById('warningHolder').style.display='none'">No</button>
					<button class="button w3-red" type="submit" name="remove">Yes</button>
				</form>
            </p>
        </div>
    </div>
</div>
</div>
</div>
</div>--<

<!-- Remove from database Script -->
<script>
    function removeEntry(user)
    {
        //Display the warning modal.
        document.getElementById('warningHolder').style.display='block';
        //Replace hidden input data to prepare for if the user chooses to submit.
        document.getElementById('removeData').value = user;
    }
</script>

<!-- Enable/Disable table editing Script -->
<script>
    function enableEdit()
    {
        //Disable readonly on inputs.
       // var inputs = document.querySelectorAll(".w3-input");
        //for (var i = 0; i < inputs.length; i++) {
          //  inputs[i].readOnly=false;
        //}
        
        //Hide the edit and remove buttons.
        document.getElementById("actionButtons").style.display = "none";
       // document.getElementById("displayStatus").style.display = "none";
        //Show the save and cancel buttons.
        document.getElementById("editButtons").style.display = "inline-block";
        document.getElementById("editStatus").style.display = "inline-block";

    }
    function disableEdit()
    {
        //Re-enable readonly on all inputs.
        var inputs = document.querySelectorAll(".w3-input");
        for (var i = 0; i < inputs.length; i++) {
            inputs[i].readOnly=true;
        }
        //Hide the save and cancel buttons.
        document.getElementById("editButtons").style.display = "none";
        document.getElementById("editStatus").style.display = "none";
        //Show the edit and remove buttons.
        document.getElementById("actionButtons").style.display = "inline-block";
        //document.getElementById("displayStatus").style.display = "inline-block";
    }
    
    function redirectPage() {
    
    location.replace(fileLink);
}      
</script>

<?php }
    }
?>