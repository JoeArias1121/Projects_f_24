<?php
    include_once('../config.php');
    include_once('../db_connector.php');
	
	$ATPID = $_GET['q'];
	$sql = "SELECT form_assignments FROM s21_course_workflow_steps WHERE ATPID = '$ATPID'";
	$result = mysqli_query($db_conn, $sql);
	while ($row = mysqli_fetch_array($result)) {
		
		$form_assignments = json_decode($row['form_assignments']);
		$html_inputs = "";
		foreach ($form_assignments as $key => $value) {
			$html_inputs.="
				<label>". $key . " email</label>
				<br>
				<input name='" . $key . "' type=text class='w3-input' required >
            	<br>";
		}

		$html_inputs.="<input type='hidden' name='form_assignments' value='".$row['form_assignments']."'><br>";
		echo($html_inputs);
	}

 ?>