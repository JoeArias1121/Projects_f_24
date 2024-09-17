<?php
    //Loads the action bar so the user can navigate between pages.
    include_once('./userfunctions/forms/forms.php');


    if(!isset($_SESSION)) {
        session_start();
    }
    //User has not signed in.
    if(!isset($_SESSION['user_type'])) {
        echo "<div class='w3-panel w3-margin w3-red'><p>Session Expired, Please sign in again.</p></div>";
        exit();
    }
    //User is not an admin/sec.
    if(!($_SESSION['user_type'] == $GLOBALS['admin_type']) && !($_SESSION['user_type'] == $GLOBALS['secretary_type'])){
        echo "<div class='w3-panel w3-margin w3-red'><p>Error! You do not have permission to access this information.</p></div>";
        exit();
    }

	// if (isset($_POST['TID'])) {
	// 	include_once('../../backend/config.php');
	// 	include_once('../../backend/db_connector.php');
	
	// 	$TID = $_POST['TID'];
	// 	$sql = "SELECT title, instructions, user_access_role FROM f22_form_templates WHERE TID = '$TID'";
	// 	$result = mysqli_query($db_conn, $sql);
	// 	$row = mysqli_fetch_array($result);
	
	// 	$instructions = $row['instructions'];
	// 	$title = $row['title'];
	// 	$role = $row['user_access_role'];
	// }

    if(!isset($_POST['TID'])) {
        echo "<div class='w3-panel w3-margin w3-red'><p>Error! No Form ID recieved</p></div>";
        exit();
    }
    else {
        include_once('../../backend/util.php');
        include_once('../../backend/db_connector.php');

        //Gather data passed to this page.
        $TID = mysqli_real_escape_string($db_conn, $_POST['TID']);

        //Find all data related to the workflow.
        $sql = "SELECT * FROM f23_Form_Templates WHERE TID = $TID";
        $query = mysqli_query($db_conn, $sql);
        $row = mysqli_fetch_array($query);
	
		$sql = "SELECT title, instructions, user_access_role FROM f23_Form_Templates WHERE TID = '$TID'";
		$result = mysqli_query($db_conn, $sql);
		$row = mysqli_fetch_array($result);
	
		$instructions = $row['instructions'];
		$title = $row['title'];
		$role = $row['user_access_role'];
    }

	include_once('../../backend/util.php');
    include_once('../../backend/db_connector.php');
if(isset($_POST['formCreate'])) {	
	//$TID = mysqli_real_escape_string($db_conn, $_POST['TID']);
	$form_structure = $_POST['formStructure'];
	$form_name = mysqli_real_escape_string($db_conn, $_POST['formName']);
	//$user_access_type = mysqli_real_escape_string($db_conn, $_POST['user_type']); // this saved a string but 
																				  // but access role in table is int
																				  
	
	$user_access_type = $_SESSION['user_type'];
	
	//$sql = "SELECT URID FROM f20_user_role_table WHERE user_role_title = '$user_access_type'";
	//$result = mysqli_query($db_conn, $sql);
	//$row = mysqli_fetch_assoc($result);

	//$user_access_type = $row['URID'];

	//$sql = "UPDATE `f22_form_templates` SET title = '$form_name', instructions = '$form_structure', user_access_role = '$user_access_type' WHERE TID = '$TID'";
	$jsonString = json_encode($form_structure);
	$sql = "UPDATE `f23_Form_Templates` SET title = '$form_name', instructions = '$form_structure', user_access_role = '$user_access_type' WHERE TID = '$TID'";
	$result = mysqli_query($db_conn, $sql);

	


	if ($result) {
            
        echo("<div class='w3-card w3-round-large w3-green w3-margin w3-padding'>Successfully Edited Form.</div>");
    }       
	else {
            echo("<div class='w3-card w3-red w3-round-large w3-margin w3-padding'> Error Editing Form.</div>");
			echo(mysqli_error($db_conn));
    }
}
	
?>

<h2 class='w3-margin'> Edit Form</h2>
<div id=userForm class='w3-card w3-white w3-round-large w3-padding-large w3-margin'>
	<form onSubmit= 'AddFormTitle(event)'/>
		<h4>Form Title</h4>
    	<input id=addTitle  name= addTitle  type= text placeholder="Enter Form Title" class= 'w3-input w3-round-large w3-sand w3-border' required/>		
    	<br>
    	<button type='submit' name=addTitle class='w3-button w3-blue w3-round-large' onclick='AddFormTitle(event)'>Add Form Title</button>
	</form>
	<hr>
	<form id='addFieldForm' onSubmit= 'AddField(event)'/>
		<h5>Field Title</h5>
		<input id=addField  name= addField  type= text placeholder="Enter Field Title" class='w3-input w3-round-large w3-sand w3-border' required/>
		<h5>Select Field Type</h5>
    	<select id="selectFieldType" class="w3-input w3-round-large w3-sand w3-border" onchange="checkFieldType(event)">
			<option value="text">Text</option>
			<option value="mc">Multiple Choice</option>
			<option value="checkbox">Checkbox</option>
		</select>
		<h5> Number of Choices</h5>
		<select id="numberOfChoices" class="w3-input w3-round-large w3-sand w3-border" onchange="createChoiceInput(event)" disabled>
			<option value="1">1</option>
			<option value="2">2</option>
			<option value="3">3</option>
			<option value="4">4</option>
		</select>
		<div id="choiceInput"></div>
    	<br>
    	<button type='submit' name=addField class='w3-button w3-blue w3-round-large'>Add This Field</button>
	</form>
	<hr>
	<form id=submit method=post>
		<input id='formStructure' type="hidden" name="formStructure"/>
		<input id='formName' type="hidden" name="formName"/>
		<input id='user' type="hidden" name="user"/>
		<input id='TID' type="hidden" name="TID"/>
		<br>
		<h5>User Access Level</h5>
        <select id="user_type" name="user_type" class="w3-input w3-round-large w3-sand w3-border">
            <?php
                $sql = "SELECT DISTINCT user_role_title FROM `f20_user_role_table`";
                $result  = mysqli_query($db_conn, $sql);
                while ($row = mysqli_fetch_array($result)) {
                    $user_type = $row['user_role_title'];
                    echo("<option value=" . $user_type . ">" . $user_type . "</option>");
                }
            ?>
        </select>
		<div id='submitArea' style='display:none;'>
			<div class='w3-right-align w3-padding w3-margin-top w3-margin-bottom w3-margin-right'>
				<button type='submit' name='formCreate' class='w3-button w3-green w3-round-large'>Update Form</button>
			</div>
		</div>
	</form>
</div>

<div id="formPreview">
	<div class = 'w3-blue'>
		<h3 id='formTitle' class='w3-margin-left'></h3>
	</div>
	<br>
</div>

<script>

// set the forms object from existing one
var formData = <?php echo($instructions); ?>;
console.log(formData);
var formID = <?php echo($TID); ?>;
console.log(formID);

var fieldId = Math.max(...formData.fields.map(field => field.field_id)) + 1;
console.log(fieldId);
renderInitialForm();

function AddW3Classes() {
	if (document.getElementById('formPreview').classList.length == 0) {
		document.getElementById('formPreview').classList.add('w3-card-4');
		document.getElementById('formPreview').classList.add('w3-padding');
		document.getElementById('formPreview').classList.add('w3-margin');
	}
}

function AddField(event) {
	event.preventDefault();
	// fieldNames.push(document.getElementById('addField').value);
	// document.getElementById('addField').value = '';
	
	AddW3Classes();
	// UpdateHiddenInput();
	const preview = document.getElementById('formPreview');

	if (!document.getElementById('templateHeader')) {
			document.getElementById('userForm').outerHTML += "<h2 id=templateHeader class=w3-padding > Form Preview </h2>";
	}
	
	// let newField = fieldNames[fieldNames.length - 1];
	// let fieldNumber = fieldNames.length

	// push checkbox/mc choices to choices[]. render field and loop thru array to show all choices.
	// if input type is text, skip pushing to choices[]

	const inputType = document.getElementById('selectFieldType').value;
	const fieldTitle = document.getElementById('addField').value;

	if (inputType === 'text') {
		preview.innerHTML += `
							 <div}>
								<label class="w3-padding">${fieldTitle}</label>
								<div class="w3-row">
									<div class="w3-threequarter w3-padding">
										<input type="text" class="w3-input w3-padding" />
									</div>
									<div>
										<button key=${fieldId} class="w3-button w3-round-large w3-red rbtn" onclick='RemoveField(event)'>
											Delete
										</button>
									</div>
								</div>
							</div>
						 `;
		formData.fields.push({
			field_title: fieldTitle,
			field_type: "text",
			field_id: fieldId
		}); 	
		fieldId++;
	} else if (inputType === 'checkbox') {
		var choices = [...document.getElementsByClassName('choice')];
		console.log(choices);
		preview.innerHTML += `
							 <div>
								<label class="w3-padding">${fieldTitle}</label>
								<div class="w3-row">
									<div class="w3-threequarter w3-padding">
										${choices.map((choice) => {
											return ( 
												`
													<input type="checkbox" class="w3-check" />
													<label>${choice.value}</label> <br>
												`
											)
										}).join(' ')}
									</div>
									<div>
										<button key=${fieldId} class="w3-button w3-round-large w3-red rbtn" onclick='RemoveField(event)'>
											Delete
										</button>
									</div>
								</div>
							</div>
						 `;
		formData.fields.push({
			field_title: fieldTitle,
			field_type: "checkbox",
			field_choices: choices.map(choice => choice.value),
			field_id: fieldId
		});
		fieldId++;
	} else if (inputType === 'mc') {
		var choices = [...document.getElementsByClassName('choice')];
		console.log(choices);
		preview.innerHTML += `
							 <div>
								<label class="w3-padding">${fieldTitle}</label>
								<div class="w3-row">
									<div class="w3-threequarter w3-padding">
										${choices.map((choice) => {
											return ( 
												`
													<input type="radio" class="w3-radio" />
													<label>${choice.value}</label> <br>
												`
											)
										}).join(' ')}
									</div>
									<div>
										<button key=${fieldId} class="w3-button w3-round-large w3-red rbtn" onclick='RemoveField(event)'>
											Delete
										</button>
									</div>
								</div>
							</div>
						 `;
		formData.fields.push({
			field_title: fieldTitle,
			field_type: "mc",
			field_choices: choices.map(choice => choice.value),
			field_id: fieldId
		});
		fieldId++;
	}
	console.log(formData);
	submitVisibility();
}

function AddFormTitle(event) {
	event.preventDefault();
	title = document.getElementById('addTitle').value;
	document.getElementById('addTitle').value = '';
	document.getElementById('formTitle').innerHTML = title;
	document.getElementById('formName').value = title;

	AddW3Classes();

	if (!document.getElementById('templateHeader')) {
		document.getElementById('userForm').outerHTML += "<h2 id=templateHeader class=w3-padding > Form Preview </h2>";
	}
	formData.form_title = title;
	submitVisibility();
}

function RemoveField(event) {
	event.preventDefault();
	preview = document.getElementById('formPreview');

	let index = event.target.getAttribute('key');
	console.log(index);
	let targetButton = event.target.parentElement.parentElement.parentElement;
	targetButton.remove();
	var i = formData.fields.length;
	while (i--) {
		if (index == formData.fields[i].field_id) {
			formData.fields.splice(i, 1);
		}
	}
	console.log(formData.fields);

	if (!preview.firstChild) preview.innerHTML = '';
	submitVisibility();
}

function submitVisibility() {
	submitArea = document.getElementById('submitArea');
	if (formData.fields.length >= 1) submitArea.style.display = 'block';
	else submitArea.style.display = 'none';
	var parsedForm = JSON.stringify(formData);
	document.getElementById('formStructure').value = parsedForm;
	document.getElementById('formName').value = formData.form_title;
	console.log(parsedForm);
	console.log(document.getElementById('formName').value);
}

function renderInitialForm() {

AddW3Classes();

preview = document.getElementById('formPreview');
fields = formData.fields;
initialTitle = formData.form_title;
document.getElementById('formTitle').innerHTML = initialTitle;
document.getElementById('userForm').outerHTML += "<h2 id=templateHeader class=w3-padding > Form Preview </h2>";
document.getElementById('TID').value = formID;
console.log(document.getElementById('TID').value);

preview.innerHTML +=
					`
						${fields.map((field) => {
							return (
								`	
									<div>
									<div>
										<label key='${field.field_id} class='w3-padding'>${field.field_title}</label>
										<div class='w3-row'>
											<div class='w3-threequarter w3-padding'>
													${checkField(field)}
											</div>
											<div>
												<button key=${field.field_id} class="w3-button w3-round-large w3-red rbtn" onclick='RemoveField(event)'>
													Delete
												</button
											</div>
										</div>
									</div>
									</div>
								`
							)
						}).join(' ')}
					`
submitVisibility();

}

function checkField(field) {
	if (field.field_type === 'text') {
		return (`<input type="text" class="w3-input w3-padding" />`);
	}
	if (field.field_type === 'checkbox') {
		return (
			field.field_choices.map(choice => {
				return (
					`
						<input type='checkbox' class='w3-check' />
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
						<input type='radio' name='${field.field_id}' class='w3-radio' />
						<label>${choice}</label> <br>
					`
				)
			})
		).join(' ');
	}
}
	
	// UpdateHiddenInput();

function EditField(event, fieldName) {
	// event.preventDefault();
	// document.getElementById('field'+fieldName)
}

// function UpdateHiddenInput(formName) {
// 	values = fieldNames.slice(0, fieldNames.length);
// 	obj = {}
	

// 	for (let i = 0; i < values.length; i++) {
// 		obj[values[i]] = "";
// 	}
	
// 	obj['form_title'] = document.getElementById('formName').value;
// 	parsed_vals = JSON.stringify(obj);

// 	document.getElementById("formStructure").value = parsed_vals;
// 	console.log(parsed_vals);
// }

function checkFieldType(event) {
	event.preventDefault();

	const selectFieldType = document.getElementById('selectFieldType');
	const numberOfChoices = document.getElementById('numberOfChoices');
	const choiceInput = document.getElementById('choiceInput');

	switch (selectFieldType.value) {
		case 'text': 
			numberOfChoices.disabled = true;
			choiceInput.innerHTML = '';
			break;
		case 'checkbox': 
			numberOfChoices.disabled = false;
			createChoiceInput(event);
			break;
		case 'mc':
			numberOfChoices.disabled = false;
			createChoiceInput(event);
			break;
		default: console.log('error');
	}
}

function createChoiceInput(event) {
	event.preventDefault();

	numberOfChoices = document.getElementById('numberOfChoices');
	choiceInput = document.getElementById('choiceInput');

	choiceInput.innerHTML = '';

	switch (numberOfChoices.value) {
		case '1':
			choiceInput.innerHTML = `
										<input class='w3-input choice' required />
									`;
			break;
		case '2':
			choiceInput.innerHTML = `
										<input class='w3-input choice' required />
										<input class='w3-input choice' required />	
									`
			break;
		case '3':
			choiceInput.innerHTML = `
										<input class='w3-input choice' required />
										<input class='w3-input choice' required />
										<input class='w3-input choice' required />
									`
			break;
		case '4':
			choiceInput.innerHTML = `
										<input class='w3-input choice' required />
										<input class='w3-input choice' required />
										<input class='w3-input choice' required />
										<input class='w3-input choice' required />
									`
			break;
		default: console.log('error');
	}

}

</script>
