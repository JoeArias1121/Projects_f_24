<?php

include_once('../../backend/config.php');
include_once('../../backend/db_connector.php');
//Loading the page title and action buttons.
//include_once('./userfunctions/search/search.php');
$industry_query = mysqli_query($db_conn, 'SELECT i.ind_code FROM f23_Industry_T AS i JOIN f23_Company_T AS c ON c.ind_code = i.ind_code JOIN f23_User_Table AS u ON c.comp_id = u.company_id WHERE u.UID ='.$_SESSION['user_id']);
$industryResults = mysqli_fetch_assoc($industry_query);
if ($_SESSION['user_type'] == 1) 
$job_template_results = mysqli_query($db_conn, 'SELECT * FROM f23_JobTemplate_T');
else
$job_template_results = mysqli_query($db_conn, 'SELECT * FROM f23_JobTemplate_T WHERE f23_JobTemplate_T.ind_code ="'.$industryResults['ind_code'].'" OR f23_JobTemplate_T.ind_code="0"');
?>

<!-- Workflow Template Search -->
<div id="workflowTemplateSearch" class="w3-card w3-white w3-round-large w3-padding w3-margin">
    <div class="w3-center">
    <?php if ($_SESSION['user_type'] == 1) { ?>
        <button class="w3-button w3-right w3-green w3-round-large" type="button" onclick="document.getElementById('new07').style.display='block'">New Template</button><?php } ?>
        <button <?php if ($_SESSION['user_type'] == 1) echo 'style="margin-left:132px"'?> class="w3-button w3-blue w3-round-large" type="button" onclick="window.location='./dashboard.php?content=search&contentType=tasktemplates'">Step Templates</button>
        <h5>Job Template Search</h5>
        <p>You may search by any field in the table.</p>
        <input style="width:300px" class="w3-round-large" id="workflowInput" type="text" onkeyup="search('workflowTable', 'workflowInput')"></input>
    </div>
    <table id="workflowTable" class="pagination w3-table-all w3-round-large w3-responsive w3-content">
        <thead>
            <tr class="w3-sand">
                <?php ?>
                <th class="w3-center">ID</th>
                <th class="w3-center">Status</th>
                <th class="w3-center">Industry</th>
                <th class="w3-center">Title</th>
                <th class="w3-center">Instructions</th>
                <?php if ($_SESSION['user_type'] == 1) { ?>
                <th style="width:150px" class="w3-center">Step Templates</th><?php }?>
            </tr>
        </thead>
        <tbody>
            


            <!-- if table was created above, the table is then populated -->
            <?php
            while ($template = mysqli_fetch_object($job_template_results)) {
            ?>
                <?php if ($template->templateStatus_id != 3) { ?>
                    <tr>
                        <!-- id -->
                        <td><?php echo $template->jobTemplate_id; ?></td>
                        <!-- title -->
                        <td>
                            <?php if ($template->templateStatus_id == 1) : ?>
                                <span class="w3-text-green"><b>Ready</b></span>
                            <?php elseif ($template->templateStatus_id == 2) : ?>
                                <span class="w3-text-orange"><b>Not Ready</b></span>
                            <?php else : ?>
                                <span">Deleted</span>
                                <?php endif; ?>
                        </td>
                        <td class="w3-center" style="width:150px"><?php $industry = $template->ind_code; if($industry == '0') echo "None"; else echo $industry ;  ?></td>
                        <td class="w3-center" style="width:150px"><?php echo $template->job_title; ?></td>
                        <!-- instructions -->
                        <td><?php echo $template->job_instructions; ?></td>
                        <!-- change status to ready, not ready, or deleted -->
                        <?php if ($_SESSION['user_type'] == 1) { ?>
                            <td class="w3-center">
                                <button class="w3-button w3-blue w3-round-large" onclick="document.getElementById('ad<?php echo $template->jobTemplate_id; ?>').style.display='block'">Attach</button>
                                <div id="ad<?php echo $template->jobTemplate_id; ?>" class="w3-modal">
                                    <div class="w3-modal-content w3-center w3-round-large w3-card-4" style="width:600px; margin-top:-65px;">
                                        <header class="w3-round w3-container w3-purple">
                                            <h6 class="w3-left">Title: <?php echo $template->job_title; ?></h6>
                                            <span onclick="document.getElementById('ad<?php echo $template->jobTemplate_id; ?>').style.display='none'" class="w3-button w3-display-topright">&times;</span>
                                        </header>
                                        <iframe height="650" width="600" style="border:none;" src="./userfunctions/jobs/job-template-admin.php?jobTemplate_id=<?php echo $template->jobTemplate_id; ?>"></iframe>
                                    </div>
                                </div>
                            </td>
                        <?php } ?>
                    </tr>
            <?php }
            } ?>
        </tbody>
    </table>
</div>
<div id="new07" class="w3-modal">
    <div class="w3-modal-content w3-center w3-round-large w3-card-4" style="width:350px; margin-top:-85px;">
      <header class="w3-round w3-container w3-green">
        <h6 class="w3-left">Create a Job Template</h6>
        <span onclick="document.getElementById('new07').style.display='none'" class="w3-button w3-round w3-display-topright">&times;</span>
      </header>
      <iframe class="w3-margin-top" height="650" style="border:none;" src="./userfunctions/jobs/create-job-template.php"></iframe>
    </div>
  </div>