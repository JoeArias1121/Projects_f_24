<?php 

if(isset($_GET['TID'])){
	include_once('../../../../backend/config.php');
	include_once('../../../../backend/db_connector.php');
	
	$tid = $_GET['TID'];
	$sql = "SELECT title, instructions FROM f23_Form_Templates WHERE TID = '$tid'";
	$result = mysqli_query($db_conn, $sql);
	$row = mysqli_fetch_array($result);

	$instructions = $row['instructions'];
	$title = $row['title'];

	echo '<script>';
	echo 'console.log($instructions);';
	echo '</script>';
	
}
elseif (isset($_POST['TID'])) {
    include_once('../../backend/config.php');
	include_once('../../backend/db_connector.php');

	$tid = $_POST['TID'];
	$sql = "SELECT title, instructions FROM f23_Form_Templates WHERE TID = '$tid'";
	$result = mysqli_query($db_conn, $sql);
	$row = mysqli_fetch_array($result);

	$instructions = $row['instructions'];
	$title = $row['title'];
	
}

//save submitted form to in database
if(isset($_POST['formData'])) {
    $formData = json_decode($_POST['formData'], true); 
    
	$dbString = array();

    // Process text fields
    foreach ($formData['fields'] as $field) {
        if ($field['field_type'] === 'text') {
            $textValue = $_POST[$field['field_id']];
			$dbString[$field['field_id']] = $textValue;

        }
        if ($field['field_type'] === 'checkbox') {
			$checkboxValues = [];
			foreach ($field['field_choices'] as $choice) {
				if (isset($_POST[$field['field_id']][$choice])) {
					$checkboxValues[] = 1; // selected checkboxes
				} else {
					$checkboxValues[] = 0; // unselected checkboxes
				}
			}
			//$checkboxValuesJSON = json_encode($checkboxValues); 
    		$dbString[$field['field_id']] = $checkboxValues;
		}
        if ($field['field_type'] === 'mc') {

			foreach ($field['field_choices'] as $choice) {
				//check which option was selected
				if (isset($_POST[$field['field_id']])){
					$selected = $_POST[$field['field_id']];
				}
				
			}
			// Store the selected option in the database string
			$dbString[$field['field_id']] = $selected; 
		
		}

		
    }
	$jsonString = json_encode($dbString);
	//echo "JSON String: <pre>"; //for testing json string
	//print_r($jsonString);
	//echo "</pre>";
	
	$user = $_SESSION["user_id"];
	$sql = "INSERT INTO `s24_form_submissions`(`user`, `form`, `results`) VALUES ('$user', '$tid', '$jsonString')";
	$result = mysqli_query($db_conn, $sql);
}
?>

<div id='formPreview' class='w3-card w3-white w3-round-large w3-padding-large w3-margin'></div>

<script>


	<?php echo "var formData = '$instructions';"; ?>
	formData = JSON.parse(formData);
	console.log(formData);

	preview = document.getElementById('formPreview');
	fields = formData.fields;
	console.log(fields);

	preview.innerHTML +=
					`
						<form id="formInputs" method="post">
						<input type="hidden" name="formData" value='${JSON.stringify(formData)}'>


							<h1 class='w3-center'>${formData.form_title}</h1>
							<hr>
							${fields.map((field) => {
								return (
									`
										<h4 key='${field.field_id} class='w3-padding'>${field.field_title}</h4>
										<div class='w3-row'>
											<div class='w3-threequarter w3-padding'>
												${checkField(field)}
											</div>
										</div>
									`
								)
							}).join(' ')}
							<br>
							<div class='w3-right-align w3-padding w3-margin-top w3-margin-bottom w3-margin-right'>
								<button type="submit" class='w3-button w3-green w3-round-large'>Submit form</button>
							</div>
						</form>
					`;
	
	function checkField(field) {
		if (field.field_type === 'text') {
			return (`<input type="text" name="${field.field_id}" class="w3-input w3-padding" />`);

		}
		if (field.field_type === 'checkbox') {
			return (
				field.field_choices.map(choice => {
					return (
						`
							<input type='checkbox' name="${field.field_id}[${choice}]"" class='w3-check' />
							<label>${choice}</label> <br>
						`
					)
				})
			).join(' ');
		}
		if (field.field_type === 'mc') {
			return (
				field.field_choices.map(choice => {
					return (
						`
							<input type='radio' value='${choice}' name='${field.field_id}' class='w3-radio' />
							<label>${choice}</label> <br>
						`
					)
				})
			).join(' ');
		}
	}

	
</script>


