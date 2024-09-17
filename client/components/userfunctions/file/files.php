<?php
if(!isset($_SESSION)) {
    session_start();
}
//User has not signed in.
if(!isset($_SESSION['user_type'])) {
    header('Location: ./views/login.php');
}

include_once('../../backend/config.php');
include_once('../../backend/db_connector.php');


/*
 if (isset($_POST['submitFile']))
 {
 //$ownerName = $_SESSION['UID'];
 
 $ownerID = $_SESSION['user_id'];
 $fileDBName ="";
 
 if (isset($_FILES['file']['name']) =="" )
 {
 $fileDBName = isset($_POST["pdf_file"]["name"]);
 } else{
 
 $fileDBName = isset($_POST["file"]["name"]);
 }
 
 
 $filename = $_POST['fname'];
 //$owner = mysqli_real_escape_string($db_conn, $ownerID);
 //$dataType = mysqli_real_escape_string($db_conn, $_POST['data_type_id']);
 $dataAlive = $_POST['alive'];
 $dataApprove = $_POST['approve'];
 $dataUnlock = $_POST['unlock'];
 $dataActive = $_POST['active'];
 $dataStatus = $dataAlive.$dataApprove.$dataUnlock.$dataActive;
 //$data = mysqli_real_escape_string($db_conn, $_POST['file']);
 // $dataCreated = date("Y-m-d");
 $dateCreated = date("m/d/Y");
 //$dataUpdated = date("Y-m-d");
 $dateUpdated = date("m/d/Y");
 
 /* $insertData1 = "INSERT INTO f20_data_T (dataStatus_id, data_alive, data_approve, data_unlock, data_active, data, dataType_id, data_modifier, data_changed, data_owner, data_created)
 VALUES (1111,'$data_alive','$approve','$unlock','$active','$data','$dataType', 1, '$dataUpdated', '$ownerName', '$dataCreated')"*/

/*  $insertData = "INSERT INTO f23_data_table (owner_id, dataName, data, dateStatus, dataCreated, dateUpdated)
 VALUES ('$ownerID', '$filename', '$fileDBName', '$dataStatus', '$dateCreated', '$dateUpdated')";
 
 $insertDataQuery = mysqli_query($db_conn, $insertData);
 
 }*/

/*if(isset($_POST['remove'])) {
    
    include_once('../../backend/db_connector.php');
    $data_id = mysqli_real_escape_string($db_conn, $_POST['data_id']);
    
    $sql = "DELETE FROM f23_data_T WHERE data_id = '$data_id'";
    if ($db_conn->query($sql) === TRUE) {
        echo("<div class='w3-panel w3-margin w3-green'><p>Successfully Removed this File</p></div>");
    }
    else {
        echo("<div class='w3-panel w3-margin w3-red'><p>Error removing file: " . $db_conn->error . "</p></div>");
    }
}*/


?>

<html>
<head>

	<meta name="viewport" content="width=device-width, initial-scale=1">

</head> 

<body>
  
<style>
* {box-sizing: border-box}

/* Style the tab */
.tab {
  float: left;
  border: 1px solid #ccc;
  background-color: #f1f1f1;
  width: 30%;
  height: 300px;
}

/* Style the buttons that are used to open the tab content */
.tab button {
  display: block;
  background-color: inherit;
  color: black;
  padding: 22px 16px;
  width: 100%;
  border: none;
  outline: none;
  text-align: left;
  cursor: pointer;
  transition: 0.3s;
}

/* Change background color of buttons on hover */
.tab button:hover {
  background-color: #ddd;
}

/* Create an active/current "tab button" class */
.tab button.active {
  background-color: #ccc;
}

/* Style the tab content */
.tabcontent {
  float: left;
  padding: 0px 12px;
  border: 1px solid #ccc;
  width: 70%;
  border-left: none;
  height: 300px;
}

.button {
  background-color: #008CBA;
  border: none;
  color: white;
  padding: 15px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 14px;
  margin: 4px 2px;
  cursor: pointer;
  border-radius: 8px;
}

.button2 {
  background-color: #008CBA;
  border: none;
  color: white;
  padding: 15px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 18px;
  margin: 4px 2px;
  cursor: pointer;
  width: 30%;
  height: 75px;
  border-radius: 8px;
}

.button3 {
  background-color: #008CBA;
  border: none;
  color: white;
  padding: 15px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  cursor: pointer;
  border-radius: 8px;
}


.button4 {
  background-color: #008CBA;
  border: none;
  padding: 10px 25px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 20px;
  margin: 4px 2px;
  cursor: pointer;
  border-radius: 8px;
}

.button5 {
  background-color: #008CBA;
  border: none;
  color: white;
  padding: 15px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  cursor: pointer;
  border-radius: 8px;
  display: none;
}

.button6 {
  background-color: #008CBA;
  border: none;
  color: white;
  padding: 15px 15px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 14px;
  margin: 4px 2px;
  cursor: pointer;
  border-radius: 8px;
  display: inline-block;
}
.button7 {
  background-color: #008CBA;
  border: none;
  color: white;
  padding: 15px 19px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 14px;
  margin: 4px 2px;
  cursor: pointer;
  border-radius: 8px;
  display: inline-block;
}

#outer
{
	width:100%;
	text-align: center;
}
.inner
{
	display: inline-blick;
}

textWhite
{
	color: #FFFFFF;
}

.roundEdge
{
	border-radius: 8px;
}

.twoSoftCorners
{
	border-radius: 0px 0px 8px 8px;
}

.padding
{
	padding-left: 6.6%;
	padding-right: 5%;
	padding-bottom: 3%;
	padding-top: 2%;
}

.padding2
{
	padding-left: 10%;
	padding-right: 3.5%;
	padding-bottom: 3%;
	padding-top: 2%;
}

</style>

<!------------------------------------------------------------------------------

    ADMIN VERSION
	
-------------------------------------------------------------------------------->


<?php 
	if($_SESSION['user_type'] == 1){
?>

<div class="w3-container" id="addData" tabindex="-1" role="dialog" aria-labelledby="addData" aria-hidden="true">
  <!--  <div id="outer" class="w3-quarter">  
	<div class="inner">
		<div><i class="fa-solid fa-circle-arrow-up"></i></div>
		<button type="button" id="dataView" class="button2 w3-indigo w3-large w3-hover-shadow" onclick="enableView()">View Data</button>
		<button onclick="document.getElementById('id01').style.display='block'" id="addData" class="button2 w3-indigo w3-large w3-hover-shadow">Add Data</button>
		<button type="button" id="dataDelete" class="button2 w3-indigo w3-large w3-hover-shadow" onclick="enableDelete()">Delete Data</button>
	</div>
  </div>-->
  <div id="id01" class="w3-modal">
    <div class="w3-modal-content w3-card-4 roundEdge w3-animate-top" style="max-width:600px">

      <div class="w3-center"><br>
		<span onclick="document.getElementById('id01').style.display='none'; window.location.reload();" class="button4 w3-xlarge w3-hover-red w3-display-topright" title="Close Modal">&times;</span>
      </div>
	  		<header class="w3-container w3-padding-16 w3-light-grey">
				<h4><b>Add Data</b></h4>
			</header>
	  <div class="w3-margin">
			<form action="./dashboard.php?content=upload" method="POST" style ="text-align:left" enctype="multipart/form-data">

				<!--<form action="c1-setData-dataT.php" method="POST" style ="text-align:left" enctype="multipart/form-data">-->
                <!-- <label>Data ID</label>
                <input type="text" name="data_id"> -->
            <p></p>
                <p><label>Data Status:</label></p>
                <!-- <input type="text" name="data_status_id"> -->
                
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
            <p></p>
                <div class="form-input py-2">
						<div class="form-group">
							<input type="text" class="form-control"
								placeholder="Enter file Name" name="fname">
				</div>	
				<br>
				<div <i class="fa fa-folder-open"></i></div>
                <label>Data: </label>
				<button type="button" id="fileView" class="w3-button w3-indigo roundEdge" onclick="enableFileUpload()">Files</button>
				<button type="button" id="imageView" class="w3-button w3-indigo roundEdge" onclick="enableImageUpload()">PNG/JPG/GIF</button>
                <!--<input type="file" name="data_location" id="data_location"> --> 
			<p></p>				
				 <div id="pdfUpload" style="display: none">
					<div class="form-group">
							<input type="file" name="files" id="files""/>
						</div>
				</div>
			<p></p>
				  <div id="imageUpload" style="display: none">
					  <!-- code that shows preview of an image-->
					<input type="file" name="file" id="file" onchange="preview()"><br>
					<div id="imageFrame" style="display: none">
						<img id="frame" src="" width="575px" height="300px"/>
					</div>
				</div>
            <p></p>
                <label class="mr-sm-2" for="inlineFormCustomSelect">Data Type:</label>
                <!-- <input type="text" name="data_type_id">   -->
                <div class="w3-dropdown-hover">
	 	 <select class="w3-select w3-border w3-sand w3-round-large" list="data_type_id" name="data_type_id">   
               	   <option value="" disabled selected>Choose:</option>
               	   <option value="1">Any</option>
               	   <option value="2">Self</option>
               	   <option value="3">Other</option>
               	   <option value="4">Form</option>
               	   <option value="5">File</option>
                   <option value="6">Database</option>
                   <option value="7">MessageSender</option>
                </select>
	       </div>            
            <p></p>
                <!-- <label>Data Modifier:</label> -->
                <input type="hidden" name="data_modifier" value=$ownerName >               
            <p></p>
                <!-- <label>Data Changed:</label>
                <input type="text" name="data_changed">               
            <p></p> -->
                <!-- <label>Data Owner:</label> -->
                <input type="hidden" name="data_owner" value=$ownerName >               
            <p></p>
                <!-- <label>Data Created:</label>
                <input type="text" name="data_created">               
            <p></p> -->

            <p></p>
	  </div>
	  <div class="w3-container w3-border-top w3-padding-16 w3-light-grey twoSoftCorners">
				<button onclick="document.getElementById('id01').style.display='none'" type="button" class="button w3-grey w3-hover-shadow w3-left"><textWhite><b>Close</b></textWhite></button>
				<button type="submit" name="submitFile" class="button w3-blue w3-hover-shadow w3-right" ><b>Submit</b></button>
			</form>
      </div>
    </div>
  </div>
</div>



<!-- User Search and Table with "view" button-->
		
<div id="userSearchViewButton" class="w3-card w3-white w3-round-large padding w3-margin text-align:left">  
	<div class="w3-center">
		<p>You may search by ID, owner, type, or status</p>
		<input style="width:400px" class="w3-round-large" type="text" id="userInput" onkeyup="search('fileTable', 'userInput')"></input>
	</div>
    <h5><b>Files :</b></h5>
    <table id="fileTable" class="pagination w3-table-all w3-responsive w3-round-large" data-pagecount="8" style="max-width:fit-content;">
        <tr>
			<th class="w3-center">ID</th>
			<th class="w3-center">Owner ID</th>
			<th class="w3-center">Data Name</th>
		    <th class="w3-center">Data</th>
            <th class="w3-center">Data Status</th>
            <th class="w3-center">Data Type
            <th class="w3-center">Data Created</th>
            <th class="w3-center">Data Updated</th>
            <th class="w3-center">Action</th>
        </tr>
        <?php
           // $sql = "SELECT * FROM f20_data_T JOIN f20_dataType_T ON f20_data_T.dataType_id = f20_dataType_T.dataType_id JOIN f20_dataStatus_T ON f20_data_T.dataStatus_id = f20_dataStatus_T.dataStatus_id";
           $sql = "SELECT * FROM f23_data_T";
            $query = mysqli_query($db_conn, $sql);
            while ($row = mysqli_fetch_assoc($query)) {
				$data_ID = $row['data_id'];
				$data_Owner = $row['owner_id'];
				//$ownerName = mysqli_fetch_assoc(mysqli_query($db_conn, "SELECT * FROM f20_user_table WHERE UID = '$dataOwner'"))['user_name'];
				//$dataType = $row['dataType_title'];
				$data_Name = $row['dataName'];
				$data = $row['dataLocation'];
			   // $dataStatus = $row['dataStatus_title'];
                //$data = $row['data'];
                $data_Status = $row['dataStatus'];
                $data_Type = $row['dataType'];
                $dataCreated = $row['dateCreated'];
                $dataUpdated = $row['dateUpdated'];
        ?>
        <tr>
	    <td><?php echo $data_ID; ?></td>
	   <!-- <td><?php //echo $ownerName; ?></td>-->
	   <!--  <td><?php //echo $dataType; ?></td>-->
	    <td><?php echo $data_Owner; ?></td>
	    <td><?php echo $data_Name; ?></td>
	    <td><?php echo $data; ?></td>
	    <td><?php echo $data_Status; ?></td>
	    <td><?php echo $data_Type; ?></td>
          <!--    <td><a href="<?php //echo $dataLocation; ?>"><?php //echo $data; ?></a></td>-->
        <td><?php echo $dataCreated; ?></td>
        <td><?php echo $dataUpdated; ?></td>
        <td>
                <form method="post" action="./dashboard.php?content=view&contentType=file">
                    <!-- The hidden input field must be used to pass the account the user has selected
                        to the next page. -->
                    <input type="hidden" name="dataID" value="<?php echo $data_ID;?>">
                     <input type="hidden" name="fileOwner" value="<?php echo $data_Owner;?>">
                    <input type="hidden" name="dataStatus" value="<?php echo $data_Status;?>">
                    <input type="hidden" name="dataLocation" value="<?php echo $data;?>">
                    <input type="hidden" name="file" value="<?php echo $data_Name;?>">
                    <button type="submit" id="viewFileID" name="viewFile" class="button3 w3-blue w3-hover-shadow w3-round-large">View</button>
					
				</form>
            </td>
        </tr>
        <?php } ?>
    </table>
</div>

<!-- User Search and Table with "delete" button-->

<div id="userSearchDeleteButton" class="w3-card w3-white w3-round-large padding w3-margin text-align:left" style="display: none">  
	<div class="w3-center">
		<p>You may search by ID, owner, type, or status</p>
		<input style="width:300px" class="w3-round-large" type="text" id="userInput" onkeyup="search('fileTable', 'userInput')"></input>
	</div>
    <h5><b>Files :</b></h5>
    <table id="fileTable" class="pagination w3-table-all w3-responsive w3-round-large" data-pagecount="8" style="max-width:fit-content;">
         <tr>
			<th class="w3-center">ID</th>
			<th class="w3-center">Owner ID</th>
			<th class="w3-center">Data Name</th>
		    <th class="w3-center">Data</th>
            <th class="w3-center">Data Status</th>
            <th class="w3-center">Data Type
            <th class="w3-center">Data Created</th>
            <th class="w3-center">Data Updated</th>
            <th class="w3-center">Action</th>
        </tr>
        <?php
        $sql = "SELECT * FROM f23_data_T";
        $query = mysqli_query($db_conn, $sql);
        while ($row = mysqli_fetch_assoc($query)) {
            $data_ID = $row['data_id'];
            $data_Owner = $row['owner_id'];
            //$ownerName = mysqli_fetch_assoc(mysqli_query($db_conn, "SELECT * FROM f20_user_table WHERE UID = '$dataOwner'"))['user_name'];
            //$dataType = $row['dataType_title'];
            $data_Name = $row['dataName'];
            $data = $row['dataLocation'];
            // $dataStatus = $row['dataStatus_title'];
            //$data = $row['data'];
            $data_Status = $row['dataStatus'];
            $data_Type = $row['dataType'];
            $dataCreated = $row['dateCreated'];
            $dataUpdated = $row['dateUpdated'];
            ?>
        <tr>
	    <td><?php echo $data_ID; ?></td>
	   <!-- <td><?php //echo $ownerName; ?></td>-->
	   <!--  <td><?php //echo $dataType; ?></td>-->
	    <td><?php echo $data_Owner; ?></td>
	    <td><?php echo $data_Name; ?></td>
	    <td><?php echo $data; ?></td>
	    <td><?php echo $data_Status; ?></td>
	    <td><?php echo $data_Type; ?></td>
          <!--    <td><a href="<?php //echo $dataLocation; ?>"><?php //echo $data; ?></a></td>-->
        <td><?php echo $dataCreated; ?></td>
        <td><?php echo $dataUpdated; ?></td>
        <td>
                <form method="post" action="./dashboard.php?content=removeFile">
                    <!-- The hidden input field must be used to pass the account the user has selected-->
                     <input type="hidden" name="dataID" value="<?php echo $data_ID;?>">
                    <input type="hidden" name="fileOwner" value="<?php echo $data_Owner;?>">
                    <input type="hidden" name="dataStatus" value="<?php echo $data_Status;?>">
                    <input type="hidden" name="dataLocation" value="<?php echo $data;?>">
                    <input type="hidden" name="file" value="<?php echo $data_Name;?>">
					<button type="submit" class="button6 w3-red w3-hover-shadow inner" id="deleteFile" name="remove">Remove</button>
					<!--  <button type="button" class="button7 w3-grey w3-hover-shadow inner" id="cancelDelete" name="cancel" onclick="enableView()"><textWhite>Cancel</textWhite></button>  -->
				 </form>
            </td>
        </tr>
        <?php } ?>
    </table>
</div>

<!-- Modal Pop-up to warn of deletion -->

<div id="warningHolder" class="w3-modal w3-center">
<div class="container-md">
  <div class = "tabs">
    <div class = "panel-body">
      <div class = "tab-content">
        <div class="w3-container w3-black">
            <p>Warning!!</p>
            <p>You are about to remove this file.</p>
            <p>Are you sure you want to do this?
                <br>
                <form method="post" action="./dashboard.php?content=view&contentType=removeFile">
                    <!--  <input id="removeData" name="userEmail" type="hidden">-->
                  
                      <button class="button w3-white" type="button" onclick="document.getElementById('warningHolder').style.display='none'">No</button>
					<button class="button w3-red" type="submit" name="remove">Yes</button>
				</form>
            </p>
        </div>
    </div>
</div>
</div>
</div>
</div>



<!------------------------------------------------------------------------------

    GENERAL VERSION
	
-------------------------------------------------------------------------------->

<?php } else { $thisUser = $_SESSION['user_id']; ?>
	
<!--Buttons at the top of the files page-->

<div class="w3-container" id="addData" tabindex="-1" role="dialog" aria-labelledby="addData" aria-hidden="true">
  <!--  <div id="outer" class="w3-quarter">  
	<div class="inner">
		<div><i class="fa-solid fa-circle-arrow-up"></i></div>
		<button type="button" id="dataView" class="button2 w3-indigo w3-large w3-hover-shadow" onclick="enableView()">View Data</button>
		<button onclick="document.getElementById('id01').style.display='block'" id="addData" class="button2 w3-indigo w3-large w3-hover-shadow">Add Data</button>
		<button type="button" id="dataDelete" class="button2 w3-indigo w3-large w3-hover-shadow" onclick="enableDelete()">Delete Data</button>
	</div>
  </div>-->
  <div id="id01" class="w3-modal">
    <div class="w3-modal-content w3-card-4 roundEdge w3-animate-top" style="max-width:600px">

      <div class="w3-center"><br>
		<span onclick="document.getElementById('id01').style.display='none'; window.location.reload();" class="button4 w3-xlarge w3-hover-red w3-display-topright" title="Close Modal">&times;</span>
      </div>
	  		<header class="w3-container w3-padding-16 w3-light-grey">
				<h4><b>Add Data</b></h4>
			</header>
	  <div class="w3-margin">
			<form action="./dashboard.php?content=upload" method="POST" style ="text-align:left" enctype="multipart/form-data">

				<!--<form action="c1-setData-dataT.php" method="POST" style ="text-align:left" enctype="multipart/form-data">-->
                <!-- <label>Data ID</label>
                <input type="text" name="data_id"> -->
            <p></p>
                <p><label>Data Status:</label></p>
                <!-- <input type="text" name="data_status_id"> -->
                
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
            <p></p>
                <div class="form-input py-2">
						<div class="form-group">
							<input type="text" class="form-control"
								placeholder="Enter file Name" name="fname">
				</div>	
				<br>
				<div <i class="fa fa-folder-open"></i></div>
                <label>Data: </label>
				<button type="button" id="fileView" class="w3-button w3-indigo roundEdge" onclick="enableFileUpload()">Files</button>
				<button type="button" id="imageView" class="w3-button w3-indigo roundEdge" onclick="enableImageUpload()">PNG/JPG/GIF</button>
                <!--<input type="file" name="data_location" id="data_location"> --> 
			<p></p>				
				 <div id="pdfUpload" style="display: none">
					<div class="form-group">
							<input type="file" name="files" id="files""/>
						</div>
				</div>
			<p></p>
				  <div id="imageUpload" style="display: none">
					  <!-- code that shows preview of an image-->
					<input type="file" name="file" id="file" onchange="preview()"><br>
					<div id="imageFrame" style="display: none">
						<img id="frame" src="" width="575px" height="300px"/>
					</div>
				</div>
            <p></p>
                <label class="mr-sm-2" for="inlineFormCustomSelect">Data Type:</label>
                <!-- <input type="text" name="data_type_id">   -->
                <div class="w3-dropdown-hover">
	 	 <select class="w3-select w3-border w3-sand w3-round-large" list="data_type_id" name="data_type_id">   
               	   <option value="" disabled selected>Choose:</option>
               	   <option value="1">Any</option>
               	   <option value="2">Self</option>
               	   <option value="3">Other</option>
               	   <option value="4">Form</option>
               	   <option value="5">File</option>
                   <option value="6">Database</option>
                   <option value="7">MessageSender</option>
                </select>
	       </div>            
            <p></p>
                <!-- <label>Data Modifier:</label> -->
                <input type="hidden" name="data_modifier" value=$ownerName >               
            <p></p>
                <!-- <label>Data Changed:</label>
                <input type="text" name="data_changed">               
            <p></p> -->
                <!-- <label>Data Owner:</label> -->
                <input type="hidden" name="data_owner" value=$ownerName >               
            <p></p>
                <!-- <label>Data Created:</label>
                <input type="text" name="data_created">               
            <p></p> -->

            <p></p>
	  </div>
	  <div class="w3-container w3-border-top w3-padding-16 w3-light-grey twoSoftCorners">
				<button onclick="document.getElementById('id01').style.display='none'" type="button" class="button w3-grey w3-hover-shadow w3-left"><textWhite><b>Close</b></textWhite></button>
				<button type="submit" name="submitFile" class="button w3-blue w3-hover-shadow w3-right" ><b>Submit</b></button>
			</form>
      </div>
    </div>
  </div>
</div>



        
<!-- User Search and Table with "view" button-->

<div id="userSearchViewButton" class="w3-card w3-white w3-round-large padding w3-margin text-align:left">  
	<div class="w3-center">
		<p>You may search by ID, owner, type, or status</p>
		<input style="width:400px" class="w3-round-large" type="text" id="userInput" onkeyup="search('fileTable', 'userInput')"></input>
	</div>
    <h5><b>Files :</b></h5>
    <table id="fileTable" class="pagination w3-table-all w3-responsive w3-round-large" data-pagecount="8" style="max-width:fit-content;">
        <tr>
			<th class="w3-center">ID</th>
			<!-- <th class="w3-center">Owner ID</th>-->
			<th class="w3-center">Data Name</th>
		<th class="w3-center">Data</th>
            <th class="w3-center">Data Status</th>
            <th class="w3-center">Data Type
            <th class="w3-center">Data Created</th>
            <th class="w3-center">Data Updated</th>
            <th class="w3-center">Action</th>
        </tr>
        <?php
           // $sql = "SELECT * FROM f20_data_T JOIN f20_dataType_T ON f20_data_T.dataType_id = f20_dataType_T.dataType_id JOIN f20_dataStatus_T ON f20_data_T.dataStatus_id = f20_dataStatus_T.dataStatus_id";
           $sql = "SELECT * FROM f23_data_T WHERE owner_id = '$thisUser'";
            $query = mysqli_query($db_conn, $sql);
            while ($row = mysqli_fetch_assoc($query)) {
				$data_ID = $row['data_id'];
				$data_Owner = $row['owner_id'];
				//$ownerName = mysqli_fetch_assoc(mysqli_query($db_conn, "SELECT * FROM f20_user_table WHERE UID = '$dataOwner'"))['user_name'];
				//$dataType = $row['dataType_title'];
				$data_Name = $row['dataName'];
				$data = $row['dataLocation'];
			   // $dataStatus = $row['dataStatus_title'];
                //$data = $row['data'];
                $data_Status = $row['dataStatus'];
                $data_Type = $row['dataType'];
                $dataCreated = $row['dateCreated'];
                $dataUpdated = $row['dateUpdated'];
        ?>
        <tr>
	    <td><?php echo $data_ID; ?></td>
	   <!-- <td><?php //echo $ownerName; ?></td>-->
	   <!--  <td><?php //echo $dataType; ?></td>-->
	    <!--  <td><?php //echo $data_Owner; ?></td>-->
	    <td><?php echo $data_Name; ?></td>
	    <td><?php echo $data; ?></td>
	    <td><?php echo $data_Status; ?></td>
	    <td><?php echo $data_Type; ?></td>
          <!--    <td><a href="<?php //echo $dataLocation; ?>"><?php //echo $data; ?></a></td>-->
        <td><?php echo $dataCreated; ?></td>
        <td><?php echo $dataUpdated; ?></td>
        <td>
                <form method="post" action="./dashboard.php?content=view&contentType=file">
                    <!-- The hidden input field must be used to pass the account the user has selected
                        to the next page. -->
                    <input type="hidden" name="dataID" value="<?php echo $data_ID;?>">
                    <input type="hidden" name="fileOwner" value="<?php echo $data_Owner;?>">
                    <input type="hidden" name="dataStatus" value="<?php echo $data_Status;?>">
                    <input type="hidden" name="dataLocation" value="<?php echo $data;?>">
                    <input type="hidden" name="file" value="<?php echo $data_Name;?>">
                    <button type="submit" id="viewFileID" name="viewFile" class="button3 w3-blue w3-hover-shadow w3-round-large">View</button>
					
				</form>
            </td>
        </tr>
        <?php } ?>
    </table>
</div>


<!-- User Search and Table with "delete" button-->

<div id="userSearchDeleteButton" class="w3-card w3-white w3-round-large padding2 w3-margin text-align:left" style="display: none">  
	<div class="w3-center">
		<p>You may search by ID, owner, type, or status</p>
		<input style="width:300px" class="w3-round-large" type="text" id="userInput" onkeyup="search('fileTable', 'userInput')"></input>
	</div>
    <h5><b>Files :</b></h5>
    <table id="fileTable" class="pagination w3-table-all w3-responsive w3-round-large" data-pagecount="8" style="max-width:fit-content;">
        <tr>
			<th class="w3-center">ID</th>
            <th class="w3-center">Data</th>
            <th class="w3-center">Data Created</th>
            <th class="w3-center">Data Updated</th>
            <th class="w3-center">Action</th>
        </tr>
        <?php
        $sql = "SELECT * FROM f23_data_T WHERE owner_id = '$thisUser'";
        $query = mysqli_query($db_conn, $sql);
        while ($row = mysqli_fetch_assoc($query)) {
            $data_ID = $row['data_id'];
            $data_Owner = $row['owner_id'];
            //$ownerName = mysqli_fetch_assoc(mysqli_query($db_conn, "SELECT * FROM f20_user_table WHERE UID = '$dataOwner'"))['user_name'];
            //$dataType = $row['dataType_title'];
            $data_Name = $row['dataName'];
            $data = $row['dataLocation'];
            // $dataStatus = $row['dataStatus_title'];
            //$data = $row['data'];
            $data_Status = $row['dataStatus'];
            $data_Type = $row['dataType'];
            $dataCreated = $row['dateCreated'];
            $dataUpdated = $row['dateUpdated'];
            ?>
        <tr>
	    <td><?php echo $data_ID; ?></td>
	   <!-- <td><?php //echo $ownerName; ?></td>-->
	   <!--  <td><?php //echo $dataType; ?></td>-->
	    <td><?php echo $data_Owner; ?></td>
	    <td><?php echo $data_Name; ?></td>
	    <td><?php echo $data; ?></td>
	    <td><?php echo $data_Status; ?></td>
	    <td><?php echo $data_Type; ?></td>
          <!--    <td><a href="<?php //echo $dataLocation; ?>"><?php //echo $data; ?></a></td>-->
        <td><?php echo $dataCreated; ?></td>
        <td><?php echo $dataUpdated; ?></td>
        <td>
                <form method="post" action="./dashboard.php?content=removeFile">
                    <!-- The hidden input field must be used to pass the account the user has selected-->
                     <input type="hidden" name="dataID" value="<?php echo $data_ID;?>">
                    <input type="hidden" name="fileOwner" value="<?php echo $data_Owner;?>">
                    <input type="hidden" name="dataStatus" value="<?php echo $data_Status;?>">
                    <input type="hidden" name="dataLocation" value="<?php echo $data;?>">
                    <input type="hidden" name="file" value="<?php echo $data_Name;?>">
					<button type="submit" class="button6 w3-red w3-hover-shadow inner" id="deleteFile" name="remove">Remove</button>
					<!--  <button type="button" class="button7 w3-grey w3-hover-shadow inner" id="cancelDelete" name="cancel" onclick="enableView()"><textWhite>Cancel</textWhite></button>  -->
				 </form>
            </td>
        </tr>
        <?php } ?>
    </table>
</div>


<?php } ?>



<!------------------------------------------------------------------------------

    SCRIPTS
	
-------------------------------------------------------------------------------->

<script>
	//script for showing pdf preview
	
	var pdfjsLib = window['pdfjs-dist/build/pdf'];
	// The workerSrc property shall be specified.
	pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://mozilla.github.io/pdf.js/build/pdf.worker.js';


	$("#file").on("change", function(e){
		var file = e.target.files[0]
		if(file.type == "application/pdf"){
			var fileReader = new FileReader();  
			fileReader.onload = function() {
				var pdfData = new Uint8Array(this.result);
				var loadingTask = pdfjsLib.getDocument({data: pdfData});
				loadingTask.promise.then(function(pdf) {
					console.log('PDF loaded');
			  
					var pageNumber = 1;
					pdf.getPage(pageNumber).then(function(page) {
						console.log('Page loaded');
			
						var scale = .90;
						var viewport = page.getViewport({scale: scale});

						var canvas = $("#pdfViewer")[0];
						var context = canvas.getContext('2d');
						canvas.height = viewport.height;
						canvas.width = viewport.width;

						var renderContext = {
						canvasContext: context,
						viewport: viewport
						};
						var renderTask = page.render(renderContext);
						renderTask.promise.then(function () {
							console.log('Page rendered');
						});
					});
				}, function (reason) {
					console.error(reason);
				});
			};
			fileReader.readAsArrayBuffer(file);
		}
	});
</script>

<script>
	// script for showing image preview
	function preview()
	{
		//Re-enable readonly on all inputs.
        var inputs = document.querySelectorAll(".w3-input");
        for (var i = 0; i < inputs.length; i++) {
            inputs[i].readOnly=true;
        }
        //Show the image frame
        document.getElementById("imageFrame").style.display = "block";
		
		
		frame.src = URL.createObjectURL(event.target.files[0]);
	}
</script>

<script>
	//Remove from database script
    function removeEntry(user)
    {
        //Display the warning modal.
        document.getElementById('warningHolder').style.display='block';
        //Replace hidden input data to prepare for if the user chooses to submit.
        document.getElementById('removeData').value = user;
    }
</script>

<script>
    function enableDelete()
    {
        //Disable readonly on inputs.
        var inputs = document.querySelectorAll(".w3-input");
        for (var i = 0; i < inputs.length; i++) {
            inputs[i].readOnly=false;
        }
        //Hide the view button on table
        document.getElementById("userSearchViewButton").style.display = "none";
        //Show the delete button on table
        document.getElementById("userSearchDeleteButton").style.display = "block";
    }
    function enableView()
    {
        //Re-enable readonly on all inputs.
        var inputs = document.querySelectorAll(".w3-input");
        for (var i = 0; i < inputs.length; i++) {
            inputs[i].readOnly=true;
        }
        //Hide the delete button on table
        document.getElementById("userSearchDeleteButton").style.display = "none";
        //Show the view button on table
        document.getElementById("userSearchViewButton").style.display = "block";
    }
	
	
	function enableFileUpload()
    {
        //Disable readonly on inputs.
        var inputs = document.querySelectorAll(".w3-input");
        for (var i = 0; i < inputs.length; i++) {
            inputs[i].readOnly=false;
        }
        //Hide the upload button for image preview
        document.getElementById("imageUpload").style.display = "none";
        //Show the upload button for pdf preview
        document.getElementById("pdfUpload").style.display = "block";
        
    }
    
    function enableImageUpload()
    {
        //Re-enable readonly on all inputs.
        var inputs = document.querySelectorAll(".w3-input");
        for (var i = 0; i < inputs.length; i++) {
            inputs[i].readOnly=true;
        }
        //Hide the upload button for pdf preview
        document.getElementById("pdfUpload").style.display = "none";
        //Show the upload button for image preview
        document.getElementById("imageUpload").style.display = "block";
    }
	
</script>

<script>
	var modal = document.getElementById('id01');

	// When the user clicks anywhere outside of the modal, close it
	window.onclick = function(event) {
		if (event.target == modal) {
			modal.style.display = "none";
			document.body.style.overflow = "auto";
			document.body.style.height = "auto";
		}
	}
	
	var modal = document.getElementById('id02');

	// When the user clicks anywhere outside of the modal, close it
	window.onclick = function(event) {
		if (event.target == modal) {
			modal.style.display = "none";
			document.body.style.overflow = "auto";
			document.body.style.height = "auto";
		}
	}
</script>

<!-- Remove from database Script -->
<script>
    function removeEntry(dataID)
    {
        //Display the warning modal.
        document.getElementById('warningHolder').style.display='block';
        //Replace hidden input data to prepare for if the user chooses to submit.
        document.getElementById('removeData').value = dataID;
    }
</script>
</html>