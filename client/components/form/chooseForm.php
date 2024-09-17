<?php
include_once('../../../backend/config.php');
include_once('../../../backend/db_connector.php');

$wf_id= $_GET['q'];
$sql = "SELECT form_info, UID FROM s21_active_form_info WHERE WF_ID='$wf_id'";
$result = mysqli_query($db_conn, $sql);

$form_list_html = "
<header class='w3-container' style='padding-top:22px'>
   <h2>Form Selection:</h2>
   <h3>Select your form.</h3>

</header>

<div class='w3-row-padding w3-margin-bottom'> ";

while($row = mysqli_fetch_array($result)) {
	$uid = $row['UID'];
	$form_structure = json_decode($row['form_info'], True);
	$form_title = $form_structure['form_title'];
	
	$form_list_html.="<div class='w3-quarter' onClick=displayForm('$wf_id',". $uid .")>
                      <div class='w3-container w3-blue w3-padding-16 '>
                        <div class='w3-left'><i class='fa fa-users w3-xxxlarge'></i></div>
                        <div class='w3-clear'><h5>$form_title</h5></div>
                    </div>
                    </div>";
}

$form_list_html.="</div>";
echo($form_list_html);
?>