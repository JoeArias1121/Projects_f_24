<?php 

if(!isset($_SESSION)) {
    session_start();
}
//User has not signed in.
if(!isset($_SESSION['user_type'])) {
    echo "<div class='w3-panel w3-margin w3-red'><p>Session Expired, Please sign in again.</p></div>";
    exit();
}
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
    
    
    if($_SESSION['user_type'] == 1){
        
        
        $dataLocation = "https://cs.newpaltz.edu/p/f23-04/files/" . $ownerID ."_files/". $data;
        echo "<script> let fileLink = '$dataLocation'; </script>";
        
    } else if ($thisUser = $_SESSION['user_id']) {
        
        $user_ID = $_SESSION['user_id'];
        
        $dataLocation = "https://cs.newpaltz.edu/p/f23-04/files/" . $user_ID ."_files/". $data;
        
        //echo $dataLocation;
        echo "<script> let fileLink = '$dataLocation'; </script>";
    }

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

<header class="w3-container">
    <h5><i class="fa fa-trash-o"></i>Delete File</h5>
</header>

<div id="userForm" class="w3-card w3-white w3-round-large w3-padding w3-margin"> 
        <h5 class="w3-center w3-margin-bottom" style="margin-left:100px"><b>File: <?php echo $name ?></b></h5>
            <form action="./dashboard.php?content=deleteFile" method="POST" style ="text-align:left" enctype="multipart/form-data"> 
            
            <label class="w3-margin-top" for="owner">Owner</label>
            <input class="w3-input w3-border w3-sand w3-round-large w3-margin-bottom" id="owner" name="owner" type="text" value="<?php echo $ownerName ?>" readonly>
		
		    <label class="" for="modifier">Data ID</label>
            <input class="w3-input w3-border w3-sand w3-round-large w3-margin-bottom" id="dataID" name="dataID" type="text" value="<?php echo $dataID ?>" readonly>
            
            <button type="button" class="button w3-green w3-hover-shadow w3-round-large" onclick="redirectPage()"><textWhite><b>File View</b></button>
             <br><br><br>
             <label class="w3-red" style="font-size:4vw" for="del">DO YOU WISH TO DELETE THIS FILE?</label>
            <br><br><br>
            
             <input type="hidden" name="dataID" value="<?php echo $dataID;?>">
             <input type="hidden" name="dataLocation" value="<?php echo $data;?>"> 
             <input type="hidden" name="ownerID" value="<?php echo $ownerID;?>">
             <a href="./dashboard.php?content=files" id='fileRedirect' class='button w3-blue w3-hover-shadow' style="margin-left: 850px;"><i class="fa fa-reply"></i><b> Cancel</b></a>
			 <button type="submit" class="button w3-red w3-hover-shadow w3-round-large" name="deleteF"><textWhite><b>Delete</b></textWhite></button>
			
            </form>
           
            

</div>

<script>

 function redirectPage() {
    
    location.replace(fileLink);
}      

</script>