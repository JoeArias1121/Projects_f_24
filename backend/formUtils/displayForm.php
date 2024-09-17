<?php
include_once('../config.php');
include_once('../db_connector.php');

$uid = $_GET['u'];
$wf_id = $_GET['q'];

$sql = "SELECT form_info FROM s21_active_form_info WHERE uid= '$uid' AND WF_ID='$wf_id'";
$result = mysqli_query($db_conn, $sql);
$row = mysqli_fetch_assoc($result);

$form_structure = json_decode($row['form_info'], True);
$html_form = "<div class='w3-card-4 w3-padding w3-margin'>";

$form_title = $form_structure['form_title'];

$html_form.= "<h3>$form_title</h3>";
$html_form.= "<form method='POST' action='./dashboard.php?content=workflows&contentType=active'>";
$html_form.= "<input name='form_title' value='$form_title' hidden/>";
$html_form.= "<input name='wf_id' value='$wf_id' hidden/>";

foreach ($form_structure as $key => $value) {
	if($key != 'form_title') {
		$state = 'disabled';
		$sql = "SELECT user_access_role FROM s21_form_templates WHERE title = '$form_title'";
		$result = mysqli_query($db_conn, $sql);
		$row = mysqli_fetch_assoc($result);

		if ($row['user_access_role'] == $_SESSION['user_type']) {
			$state = '';
		}

		$html_form.="<label class='w3-margin'>  $key </label>";
		$html_form.="<input type=text class='w3-input w3-margin' name='$key' $state value='$value'>";
	}
}

if ($row['user_access_role'] == $_SESSION['user_type']) {
	$html_form.= "<button class='w3-button w3-blue w3-margin' type='submit' name='formData' value='1' >Submit</button>";
	$html_form.= "<button class='w3-button w3-blue w3-padding w3-border' type='submit' name='formData' value='2'>Save</button>";
}

$html_form.= "</form>";

$html_form.="</div>";

echo($html_form);
?>