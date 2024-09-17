<style>
  #grad1 {
    height: 3px;
    background-color: #F0E42C;
    background-image: linear-gradient(to right, #F0E42C, #000000);
    /* For browsers that do not support gradients */
  }

  #grad2 {
    height: 3px;
    background-color: #F0E42C;
    background-image: linear-gradient(to right, #F0E42C, #000000);
    /* For browsers that do not support gradients */
  }
</style>





<!-- --------------- Header properties ------------------- -->
<!-- Sets the color of the top bar in the website "header" -->
<div class="w3-bar w3-padding" style="background-color: black;">

  <!-- This is the "burguer" or sidebar button to hide or display the sidebar -->
<button id="openNav" class="w3-bar-item w3-button w3-round-xlarge w3-text-white w3-hover-" onclick="sb_open();" style="display:none">
  <i class="fa fa-align-left" aria-hidden="true"></i>
</button>







<!-- --------------- Header "VIEWS" Buttons ------------------- -->
<?php 
      // FIRST IF STATEMENT
      // If the "content" query in the browser address shows:
      // "jobs" or "home" or "jobslist" or "jobtemplate" or "jobgraph then it displays 3 buttons on the top bar.
      // In other words any time you are using the "JOBS" function these "VIEW" options/buttons are available. 
      if ($_GET['content'] == "jobs" || $_GET['content'] == "home" || 
          $_GET['content'] == "jobslist" || $_GET['content'] == "jobtemplate" || 
          $_GET['content'] == "jobgraph") {
            
            echo (
              // Three buttons are: 
              // (List View) 
              // (Board View) 
              // (Graph View)
             '<a href="./dashboard.php?content=jobslist" style="margin-left:18%" class="w3-bar-item w3-button w3-round-xlarge w3-text-white"><b>List View</b></a>
              <a href="./dashboard.php?content=jobs" style="" class="w3-bar-item w3-button w3-round-xlarge w3-text-white"><b>Board View</b></a>
              '
            );
       }
       

      // SECOND IF STATEMENT
      // If the "content" query in the browser address shows:
      // "jobsteps" or "jobsteplist" or "tasktemplate" or "assigntasks" then it displays 2 buttons on the top bar.
      // In other words any time you are using the "STEPS" function these "VIEW" options/buttons are available. 
       if ($_GET['content'] == "jobsteps" || $_GET['content'] == "jobsteplist" ||
           $_GET['content'] == "tasktemplate" || $_GET['content'] == "assigntasks") {
            
            echo (
              // Two buttons are:
              // (List View)
              // (Board View)
              '<a href="./dashboard.php?content=jobsteplist" style="margin-left:18%" class="w3-bar-item w3-button w3-round-xlarge w3-text-white"><b>List View</b></a>
               <a href="./dashboard.php?content=jobsteps" style="" class="w3-bar-item w3-button w3-round-xlarge w3-text-white"><b>Board View</b></a>'
              );
        }
  
         
        // THIRD IF STATEMENT
        // If the "content" query in the browser address shows:
        // "archivedjobs" or "archivedjobslist" then it displays 2 buttons on the top bar.
        // In other words any time you are using the "ARCHIVE" function these "VIEW" options/buttons are available. 
        if ($_GET['content'] == "archivedjobs" || $_GET['content'] == "archivedjobslist") {
          echo (
              // Two buttons are:
              // (List View)
              // (Board View)
            '<a href="./dashboard.php?content=archivedjobslist" style="margin-left:18%" class="w3-bar-item w3-button w3-round-xlarge w3-text-white"><b>List View</b></a>
             <a href="./dashboard.php?content=archivedjobs" style="" class="w3-bar-item w3-button w3-round-xlarge w3-text-white"><b>Board View</b></a>'
          );
  }
?> 
<!------------- Header "VIEWS" Buttons PHP Statement ends here ------------------>









<!-- --------------- Header "ACTION" Buttons ------------------- -->
<?php

// FIRST IF STATEMENT
// If the "content" query in the browser address shows:
// "jobs" or "home" or "jobslist" or "jobtemplate" or "jobgraph then it displays 3 buttons on the top bar.
// In other words any time you are using the "JOBS" function these "ACTIONS" options/buttons are available. 
if (( $_GET['content'] == "jobs" || $_GET['content'] == "home" || 
      $_GET['content'] == "jobslist" || $_GET['content'] == "jobgraph"
)) 
{
?> 
    <!-- Any time you are using or viewing the "JOBS" functionality -->
    <!-- The following 3 buttons will be available from "JOBS" -->
    <div class="w3-bar-item w3-button w3-hover-shadow w3-round-xlarge w3-green" 
    onclick="document.getElementById('id04').style.display='block'">
          <b>New Job</b>
    </div>

    <div class="w3-bar-item w3-button w3-hover-shadow w3-round-xlarge w3-purple"
    onclick="window.location.href='./dashboard.php?content=archivedjobslist'">
          <b>Archived Jobs</b>
    </div>
    
    <div class="w3-bar-item w3-button w3-hover-shadow w3-round-xlarge w3-blue" 
    onclick="window.location.href='./dashboard.php?content=jobsteplist'">
          <b>Steps</b>
    </div>
    
        <!-- NESTED IF -->
        <!-- Depending of the "user_type" it will hide or show "TEMPLATES" -->
        <!-- In the database the "user_type" is the "URID" -->
        <?php 
            if ($_SESSION['user_type'] == 1|| $_SESSION['user_type'] == 2 || $_SESSION['user_type'] == 5) { ?>
              <div class="w3-bar-item w3-button w3-hover-shadow w3-round-xlarge w3-blue" 
              onclick="window.location.href='./dashboard.php?content=jobtemplate'">
                <b>Job Templates</b>
              </div>
        <?php }?>

<?php } ?>
<!-- --------------- Header "ACTION" Buttons PHP Statement ends here ------------------- -->







  <!-- MODAL WINDOW HEADER (JOBS)-->
  <!-- Whenever a "NEW JOB" is selected this window is beign called. -->
  <!-- Notice the div id is "id04" this is what is called in line "115" of this doc -->
  <div id="id04" class="w3-modal">
    <div class="w3-modal-content w3-center w3-round-large w3-card-4" style="width:400px;margin-top:-65px;">
      <header class="w3-round w3-container w3-green">
        
        <!-- This is just the header "title" of the modal -->
        <h6 class="w3-left">Create a Job</h6>

        <!-- This is just the "X" to quit or hide the modal window -->
        <a href="./dashboard.php?content=jobs" class="w3-button w3-round w3-display-topright">&times;</a>
      
      </header>

      <!-- The rest of the modal window is rendered from a different file "create-job.php" -->
      <iframe class="w3-margin-top" height="550" style="border:none;" src="./userfunctions/jobs/create-job.php"></iframe>
    </div>
  </div>
  


<!-- Code below this point is used for navigation to go back or forward across the functionalities  -->



<!-- IF STATEMENT -->
<!-- Whenever you are using the "ARCHIVED" option -->
<!-- These buttons will just allow you to go back, or navigate to other functions "Steps" "Jobs" -->
<?php 
if(($_GET['content'] == "archivedjobs" || $_GET['content'] == "archivedjobslist")) {?>

    <div class="w3-bar-item w3-button w3-hover-shadow w3-round-xlarge w3-blue"
         onclick="window.location.href='./dashboard.php?content=jobs'">
      <b>Jobs</b>
    </div>
    
    <div class="w3-bar-item w3-button w3-hover-shadow w3-round-xlarge w3-blue"
         onclick="window.location.href='./dashboard.php?content=jobsteplist'">
      <b>Steps</b>
    </div>
    
<?php }?>


<?php 

    if ($_GET['content'] == "files" || $_GET['content'] == 'testingF') {?>
    
    <div class="w3-bar-item w3-button w3-hover-shadow w3-round-xlarge w3-blue" style="margin-left:18%"
         onclick="enableView()">
      <b>View Data</b>
    </div>
    <div class="w3-bar-item w3-button w3-hover-shadow w3-round-xlarge w3-green" 
         onclick="document.getElementById('id01').style.display='block'" id="addData">
      <b>Add Data</b>
    </div>
    
    <div class="w3-bar-item w3-button w3-hover-shadow w3-round-xlarge w3-red" 
         onclick="enableDelete()">
      <b>Delete Data</b>
    </div>
    
   <?php  } ?>




<!-- IF STATEMENT -->
<!-- Whenever you are using the "STEPS" option -->
<!-- These buttons will just allow you to go back, or navigate to other functions "New Step", "Jobs", "Templates" -->
<?php 
if (($_GET['content'] == "jobsteps" || $_GET['content'] == "jobsteplist" || $_GET['content'] == "assigntasks")) {?>

    <!-- If user is type 2, it'll let you assing steps to others -->
    <!-- "user_type" is defined in the database as "URID" under "User role table" -->
    <?php if ($_SESSION['user_type'] == 2) { ?>
      <a href="./dashboard.php?content=assigntasks" class="w3-bar-item w3-button w3-round-xlarge w3-orange w3-text-white">
        <b>Assign Steps</b>
      </a>
    <?php }?>


    <div class="w3-bar-item w3-button w3-hover-shadow w3-round-xlarge w3-green" 
         onclick="document.getElementById('id05').style.display='block'">
        <b>New Step</b>
    </div> 



    <div class="w3-bar-item w3-button w3-hover-shadow w3-round-xlarge w3-blue" 
         onclick="window.location.href='./dashboard.php?content=jobs'">
      <b>Jobs</b>
    </div>

    <!-- If "user_type" is 1,2 or 5 "TEMPLATES" button will be available-->
    <?php 
    if ($_SESSION['user_type'] == 1|| $_SESSION['user_type'] == 2 || $_SESSION['user_type'] == 3 || $_SESSION['user_type'] == 5) {?>
      

      <div class="w3-bar-item w3-button w3-hover-shadow w3-round-xlarge w3-blue" 
         onclick="window.location.href='./dashboard.php?content=tasktemplate'">
        <b>Step Templates</b>
      </div>

    <?php }?>

<?php } ?>

<?php 

if($_GET['content'] == "search") { ?>

      <div class="w3-bar-item w3-button w3-hover-shadow w3-round-xlarge w3-blue" style="margin-left:18%"
         onclick="window.location.href='./dashboard.php?content=search&contentType=jobs'">
        <b>Jobs</b>
      </div>
      
      <div class="w3-bar-item w3-button w3-hover-shadow w3-round-xlarge w3-blue" 
         onclick="window.location='./dashboard.php?content=search&contentType=steps'">
        <b>Steps</b>
      </div>
      
      <?php if($_SESSION['user_type'] == $GLOBALS['admin_type']) { ?>
      
      
      <div class="w3-bar-item w3-button w3-hover-shadow w3-round-xlarge w3-green" 
         onclick="window.location.href='./dashboard.php?content=search&contentType=industry'">
        <b>Industry</b>
      </div>
      <?php }?>
      
      <div class="w3-bar-item w3-button w3-hover-shadow w3-round-xlarge w3-orange w3-text-white" 
         onclick="window.location.href='./dashboard.php?content=search&contentType=templates'">
        <b>Templates</b>
      </div>
      
      <div class="w3-bar-item w3-button w3-hover-shadow w3-round-xlarge w3-red" 
         onclick="window.location.href='./dashboard.php?content=search&contentType=user'">
        <b>Users</b>
      </div>

<?php     }?>

<?php 

if($_SESSION['user_type'] == $GLOBALS['admin_type']) {

    if($_GET['content'] == "adminTools" || $_GET['content'] == "create" && $_GET['contentType'] == "course"){?>
    
        <div class="w3-bar-item w3-button w3-hover-shadow w3-round-xlarge w3-blue" style="margin-left:18%"
         onclick="window.location.href='./dashboard.php?content=adminTools&contentType=company'">
        <b>Create Company</b>
      </div>
      
       <div class="w3-bar-item w3-button w3-hover-shadow w3-round-xlarge w3-green" 
         onclick="window.location.href='./dashboard.php?content=adminTools&contentType=industry'">
        <b>Create Industry</b>
      </div>
      
       <div class="w3-bar-item w3-button w3-hover-shadow w3-round-xlarge w3-orange w3-text-white" 
         onclick="window.location.href='./dashboard.php?content=adminTools&contentType=user'">
        <b>Create User</b>
      </div>


<?php }

}?>


<?php 
if($_GET['content'] == "forms") {?>

      <div class="w3-bar-item w3-button w3-hover-shadow w3-round-xlarge w3-orange w3-text-white" style="margin-left:18%"
         onclick="window.location.href='./dashboard.php?content=forms&contentType=view'">
        <b>View Forms</b>
      </div>
      
      <div class="w3-bar-item w3-button w3-hover-shadow w3-round-xlarge w3-red w3-text-white" 
         onclick="window.location.href='./dashboard.php?content=forms&contentType=create'">
        <b>Form Builder</b>
      </div>
      
      <div class="w3-bar-item w3-button w3-hover-shadow w3-round-xlarge w3-blue w3-text-white" 
         onclick="window.location.href='./dashboard.php?content=forms&contentType=edit'">
        <b>Edit Form</b>
      </div>
      
      <div class="w3-bar-item w3-button w3-hover-shadow w3-round-xlarge w3-green w3-text-white" 
         onclick="window.location.href='./dashboard.php?content=forms&contentType=delete'">
        <b>Delete Form</b>
      </div>

      <div class="w3-bar-item w3-button w3-hover-shadow w3-round-xlarge w3-green w3-text-white" 
         onclick="window.location.href='./dashboard.php?content=forms&contentType=testing'">
        <b>testing</b>
      </div>


<?php }?>


<?php if(($_GET['content'] == "messages") || ($_GET['content'] == "allmessages") || 
    ($_GET['content'] == "deleted") || ($_GET['content'] == "sentmessages") || ($_GET['content'] == "archivedmessages") ||
    (($_GET['content'] == "create") && $_GET['contentType'] == "message")){ 

        if($_SESSION['user_type'] == 1) { 
            $thisUser = $_SESSION['user_id'];
    ?> 
            <div class="w3-bar-item w3-button w3-hover-shadow w3-round-xlarge w3-amber w3-text-white" style="margin-left:18%"
             onclick="window.location.href='./dashboard.php?content=allmessages'">
            <b>Inbox</b>
            </div>
            
            <div class="w3-bar-item w3-button w3-hover-shadow w3-round-xlarge w3-red w3-text-white"
             onclick="window.location.href='./dashboard.php?content=deleted'">
            <b>Deleted Messages</b>
            </div>
            
            <div class="w3-bar-item w3-button w3-hover-shadow w3-round-xlarge w3-blue w3-text-white" 
             onclick="window.location.href='./dashboard.php?content=sentmessages'">
            <b>Sent Messages</b>
            </div>
            
            <div class="w3-bar-item w3-button w3-hover-shadow w3-round-xlarge w3-purple w3-text-white" 
             onclick="window.location.href='./dashboard.php?content=archivedmessages'">
            <b>Archived Messages</b>
            </div>

            <div class="w3-bar-item w3-button w3-hover-shadow w3-round-xlarge w3-green w3-text-white" 
             onclick="window.location.href='./dashboard.php?content=create&contentType=message'">
            <b>Create Message</b>
            </div>
    
    <?php }
    
    
    else { $thisUser = $_SESSION['user_id'];?>
            <div class="w3-bar-item w3-button w3-hover-shadow w3-round-xlarge w3-amber w3-text-white" style="margin-left:18%"
             onclick="window.location.href='./dashboard.php?content=allmessages'">
            <b>Inbox</b>
            </div>
            
            <div class="w3-bar-item w3-button w3-hover-shadow w3-round-xlarge w3-red w3-text-white"
             onclick="window.location.href='./dashboard.php?content=deleted'">
            <b>Deleted Messages</b>
            </div>
            
            <div class="w3-bar-item w3-button w3-hover-shadow w3-round-xlarge w3-blue w3-text-white" 
             onclick="window.location.href='./dashboard.php?content=sentmessages'">
            <b>Sent Messages</b>
            </div>
            
            <div class="w3-bar-item w3-button w3-hover-shadow w3-round-xlarge w3-purple w3-text-white" 
             onclick="window.location.href='./dashboard.php?content=archivedmessages'">
            <b>Archived Messages</b>
            </div>

            <div class="w3-bar-item w3-button w3-hover-shadow w3-round-xlarge w3-green w3-text-white" 
             onclick="window.location.href='./dashboard.php?content=create&contentType=message'">
            <b>Create Message</b>
            </div>



<?php  } 

}?>





<!-- MODAL WINDOW HEADER (STEPS)-->
<!-- Whenever a "NEW STEP" is selected this window is beign called. -->
<!-- Notice the div id is "id05" this is what is called in line "185" of this doc -->
<div id="id05" class="w3-modal">
    <div class="w3-modal-content w3-center w3-round-large w3-card-4" style="width:400px;margin-top:-65px;">
      <header class="w3-round w3-container w3-green">
        <h6 class="w3-left">Create a Step</h6>
        <a href="./dashboard.php?content=jobsteps" class="w3-button w3-round w3-display-topright">&times;</a>
      </header>
      <iframe class="w3-margin-top" height="625" style="border:none;" src="./userfunctions/jobs/create-task.php"></iframe>
    </div>
</div>

<!-- called when creating new step from template-->
<div id="id08" class="w3-modal">
    <div class="w3-modal-content w3-center w3-round-large w3-card-4" style="width:400px;margin-top:-65px;">
      <header class="w3-round w3-container w3-green">
        <h6 class="w3-left">Create Step From Template</h6>
        <a href="./dashboard.php?content=jobsteps" class="w3-button w3-round w3-display-topright">&times;</a>
      </header>
      <iframe class="w3-margin-top" height="625" style="border:none;" src="./userfunctions/jobs/newStepFromTemplate.php"></iframe>
    </div>
</div>




  <?php //if ($_GET['content'] == "tasktemplate" && ($_SESSION['user_type'] == 1)) {
    if($_GET['content'] == "tasktemplate"){ // giving all users template access may be reverted
  ?>
    <div class="w3-bar-item w3-button w3-hover-shadow w3-round-xlarge w3-green" onclick="document.getElementById('id06').style.display='block'">
      <b>New Template</b>
    </div>
  <?php } ?>
  <div id="id06" class="w3-modal">
    <div class="w3-modal-content w3-center w3-round-large w3-card-4" style="width:350px; margin-top:-100px;">
      <header class="w3-round w3-container w3-green">
        <h6 class="w3-left">Create A Step Template</h6>
        <span onclick="document.getElementById('id06').style.display='none'" class="w3-button w3-round w3-display-topright">&times;</span>
      </header>
      <iframe class="w3-margin-top" height="668" style="border:none;" src="./userfunctions/jobs/create-task-template.php"></iframe>
    </div>
  </div>

  <?php if (($_GET['content'] == "jobtemplate") && ($_SESSION['user_type'] == 1)) {
  ?>
    <div class="w3-bar-item w3-button w3-hover-shadow w3-round-xlarge w3-green" onclick="document.getElementById('id07').style.display='block'">
      <b>New Template</b>
    </div>
  <?php } ?>
  <div id="id07" class="w3-modal">
    <div class="w3-modal-content w3-center w3-round-large w3-card-4" style="width:350px; margin-top:-65px;">
      <header class="w3-round w3-container w3-green">
        <h6 class="w3-left">Create a Job Template</h6>
        <span onclick="document.getElementById('id07').style.display='none'" class="w3-button w3-round w3-display-topright">&times;</span>
      </header>
      <iframe class="w3-margin-top" height="625" style="border:none;" src="./userfunctions/jobs/create-job-template.php"></iframe>
    </div>
  </div>
  <a href='./dashboard.php?content=calendar'><span class="w3-bar-item w3-button w3-round-xlarge w3-right w3-text-white" style="padding-left: 0"><b>Calendar</b></span></a>
  <!-- <input type="hidden" class=" w3-right" id="datepicker" name="datepicker"> -->



  <button onclick="showCal()" class="w3-bar-item w3-button w3-round-xlarge w3-text-white w3-right"><i class="fa fa-calendar"></i></button>
  <div class="w3-dropdown-click w3-right">
    <div class="w3-dropdown-content w3-card w3-round-large" style="right:0; top: 62px; z-index: 200" id="Cal">
      <iframe height="430" width="600" style="border:none;" scrolling="no" src="./calendar.php"></iframe>
    </div>
  </div>
  <a href="./dashboard.php?content=allmessages" id='messagesBar' class='w3-bar-item w3-button w3-round-xlarge w3-text-white w3-padding w3-right'><i class="fa fa-bell"></i></a>
</div>
<div id="grad2"></div>



<script>
  function showCal() {
    var x = document.getElementById("Cal");
    if (x.className.indexOf("w3-show") == -1) {
      x.className += " w3-show";
    } else {
      x.className = x.className.replace(" w3-show", "");
    }
  }

</script>