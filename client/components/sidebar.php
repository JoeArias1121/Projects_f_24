<?php include_once('../../backend/config.php'); ?>
<script src="../../js/sidebartoggle.js"></script>
<style>
  #grad2 {
    height: 4px;
    background-color: #18191d;
    /* For browsers that do not support gradients */
    background-image: linear-gradient(to right, #2953e4, #00b143);
  }
</style>
<div id="mySidebar">
  <nav class="w3-sidebar w3-collapse w3-white w3-border" style="z-index:3;width:250px;"><br>
    <!-- Sidebar Header -->
    <button class="w3-bar-item w3-button w3-round-xlarge w3-display-topright" onclick="sb_close()"><i class="fa fa-align-right" aria-hidden="true"></i>
    </button>
    <div class="w3-container w3-margin-bottom w3-display-topleft">
      <a href="../../index.php" style="text-decoration:none">
        <h2 style="font-weight:bolder"><strong>FlowWork</strong></h2>
      </a>
    </div>
    <br>
    <hr>

    <!-- Sidebar Content
        Dr Pham wants all to have: 
        Home, Search, Messages, Files, Settings, Signout
        Admin = All tabs
        Secretary = Workflows (Create/View)
        All other users = View (My) Workflow
        -->

     
    <div class="w3-bar-block"> <!-- home homeBar fa fa-home fa-fw -->
    
    
    
     <!--   <a href="./dashboard.php?content=home" id="workFlowsBar" class="w3-bar-item w3-button w3-padding"><i class="fa fa-share-alt fa-fw"></i>  Jobs</a> -->
      <a href='./dashboard.php?content=jobslist' id='workflowsBar' class='w3-bar-item w3-button w3-padding w3-large'><i class='fa fa-share-alt fa-fw'></i>  Jobs</a>

      <!-- <a href='./dashboard.php?content=search' id='searchBar' class='w3-bar-item w3-button w3-padding'><i class='fa fa-search fa-fw'></i>  Search</a> -->
      <?php

      //Displaying the create option for all users except employer
      // if(!($_SESSION['user_type'] == $GLOBALS['employer_type'])) {
      //     echo("<a href='./dashboard.php?content=create' id='createBar' class='w3-bar-item w3-button w3-padding'><i class='fa fa-plus fa-fw'></i>  Create</a>");
      // }
      
      
       // echo ("<a href='./dashboard.php?content=search' id='searchBar' class='w3-bar-item w3-button w3-padding'><i class='fa fa-search fa-fw'></i>  Search</a>");
      

      //Displaying admin only tools
      if ($_SESSION['user_type'] == $GLOBALS['admin_type']) {
        echo ("<a href='./dashboard.php?content=adminTools&contentType=company' id='adminToolsBar' class='w3-bar-item w3-button w3-padding w3-large'><i class='fa fa-diamond fa-fw'></i>  Admin Tools</a>");
      }
      

      //Displaying the workflows option for users involved in only their own Workflows.
/*       if (!($_SESSION['user_type'] == $GLOBALS['super_type'] || $_SESSION['user_type'] == $GLOBALS['admin_type'])) {
        echo ("<a href='./dashboard.php?content=jobs' id='workflowsBar' class='w3-bar-item w3-button w3-padding'><i class='fa fa-share-alt fa-fw'></i>  Jobs</a>");
      }
      //Create Workflow
      if (($_SESSION['user_type'] == $GLOBALS['super_type'])) {
        echo ("<a href='./dashboard.php?content=jobs' id='workflowsBar' class='w3-bar-item w3-button w3-padding'><i class='fa fa-share-alt fa-fw'></i>  Create Jobs</a>");
      }
      //Displaying the workflows options for users involved in administrating workflows.
       if (($_SESSION['user_type'] == $GLOBALS['admin_type'])) {
          echo ("<a href='./dashboard.php?content=courses' id='courseBar' class='w3-bar-item w3-button w3-padding'><i class='fa fa-clone'></i> Job Templates</a>");
        } 
      //Displaying the workflow option for user involved in administrating workflows.
      if (($_SESSION['user_type'] == $GLOBALS['admin_type'])) {
        echo ("<a href='./dashboard.php?content=jobs' id='workflowsBar' class='w3-bar-item w3-button w3-padding'><i class='fa fa-share-alt fa-fw'></i>  Jobs</a>");
      } */

      //April 14 showing creation of new types of customization Forms, Courses

      /* if (($_SESSION['user_type'] != $GLOBALS['admin_type'])) {
          echo ("<a href='./dashboard.php?content=alerts' id='workspaceBar' class='w3-bar-item w3-button w3-padding'><i class='fa fa-clone'></i>  Workspaces</a>");
        } */
      ?>
      <!--  <a href='./dashboard.php?content=jobs' id='workflowsBar' class='w3-bar-item w3-button w3-padding'><i class='fa fa-share-alt fa-fw'></i>  Jobs</a> -->
      <!-- <a href='./dashboard.php?content=tasks' id='tasksBar' class='w3-bar-item w3-button w3-padding'><i class="fa fa-share"></i>  Steps</a> -->
      <?php 
        if (($_SESSION['user_type'] == $GLOBALS['admin_type']) || ($_SESSION['user_type'] == $GLOBALS['owner_type'])) {
          echo ("<a href='./dashboard.php?content=forms&contentType=view' id='formsBar' class='w3-bar-item w3-button w3-padding w3-large'><i class='fa fa-wrench fa-fw'></i>  Forms</a>");
        }
      ?>
      <a href='./dashboard.php?content=messages' id='messagesBar' class='w3-bar-item w3-button w3-padding w3-large'><i class="fa fa-comments"></i>  Messages</a>
      <a href='./dashboard.php?content=files' id='filesBar' class='w3-bar-item w3-button w3-padding w3-large'><i class='fa fa-folder-open-o'></i>  Files</a>
      <?php 
      
      echo ("<a href='./dashboard.php?content=search&contentType=jobs' id='searchBar' class='w3-bar-item w3-button w3-padding w3-large'><i class='fa fa-search fa-fw'></i>  Search</a>");
      ?>

      <a href='./dashboard.php?content=settings' id='settingsBar' class='w3-bar-item w3-button w3-padding w3-large'><i class='fa fa-cog fa-fw'></i>  Settings</a>
      <a href='../../backend/logout.php' id='logOutBar' class='w3-bar-item w3-button w3-padding w3-large'><i class='fa fa-sign-out fa-fw'></i>Log Out</a>
    </div>
    <br>
    <div class="w3-container">
    
      <div class="w3-display-bottomleft w3-xlarge" style="margin-left:20px ;margin-bottom:100px;">
       
        <span>Welcome, <br><strong><?php echo $_SESSION['user_name']; ?></strong></span>
       
        </div>
    
      <br>
     
    </div>
    

  </nav>
</div>


<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<script>
  //Highlighting the active sidebar option.
  var tempURL = window.location.href;
  tempURL = tempURL.split("=");

  if (tempURL[1] == "home") {
    document.getElementById('homeBar').className += " w3-green";
  } else if (tempURL[1] == "files") {
    document.getElementById('filesBar').className += " w3-green";
  } else if (tempURL[1] == "adminTools" || tempURL[1] == "adminTools&contentType") {
    document.getElementById('adminToolsBar').className += " w3-green";
  } else if (tempURL[1] == "users" || tempURL[1] == "users&contentType") {
    document.getElementById('usersBar').className += " w3-green";

  } else if (tempURL[1] == "courses" || tempURL[1] == "courses&contentType") {
    document.getElementById('courseBar').className += " w3-green";
  } else if (tempURL[1] == "forms" || tempURL[1] == "forms&contentType") {
    document.getElementById('formsBar').className += " w3-green";
  } else if (tempURL[1] == "workflows" || tempURL[1] == "jobs") {
    document.getElementById('workflowsBar').className += " w3-green";
  } else if (tempURL[1] == "tasks" || tempURL[1] == "tasks") {
    document.getElementById('tasksBar').className += " w3-green";
  } else if (tempURL[1] == "history") {
    document.getElementById('historyBar').className += " w3-green";
  } else if (tempURL[1] == "settings" || tempURL[1] == "settings&contentType") {
    document.getElementById('settingsBar').className += " w3-green";
  } else if (tempURL[1] == "search" || tempURL[1] == "view&contentType" || tempURL[1] == "search&contentType") {
    document.getElementById('searchBar').className += " w3-green";
  } else if (tempURL[1] == "create" || tempURL[1] == "create&contentType") {
    document.getElementById('createBar').className += " w3-green";
  } else if (tempURL[1] == "messages") {
    document.getElementById('messagesBar').className += " w3-green";
  } else if (tempURL[1] == "search") {
    document.getElementById('usersBar').className += " w3-green";
  } else if (tempURL[1] == "alerts") {
    document.getElementById('workspaceBar').className += " w3-green";
  }

  /*     // Get the Sidebar
      var mySidebar = document.getElementById("mySidebar");

      // Get the DIV with overlay effect
      var overlayBg = document.getElementById("myOverlay");

      // Toggle between showing and hiding the sidebar, and add overlay effect
      function w3_open() {
        if (mySidebar.style.display === 'block') {
            mySidebar.style.display = 'none';
            overlayBg.style.display = "none";
        } else {
            mySidebar.style.display = 'block';
            overlayBg.style.display = "block";
        }
      }

      // Close the sidebar with the close button
      function w3_close() {
        mySidebar.style.display = "none";
        overlayBg.style.display = "none";
      } */
</script>