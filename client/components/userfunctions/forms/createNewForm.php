<?php
include_once('../../backend/db_connector.php');
include_once('forms.php');

if(isset($_POST['formCreate'])) {	
	$form_data = mysqli_real_escape_string($db_conn, $_POST['formStructure']);
	$form_name = mysqli_real_escape_string($db_conn, $_POST['formName']); //replacing with title from user form
	

	$user_access_type = mysqli_real_escape_string($db_conn, $_POST['user_type']);

	 // find current largest uid 
	 $findTID = "SELECT MAX(TID) AS max_TID FROM f23_Form_Templates";
	 $TIDresult = mysqli_query($db_conn, $findTID);
	 $TIDresult = mysqli_fetch_assoc($TIDresult);
	 $TID = $TIDresult['max_TID'];
	 $TID = $TID + 1;

	/* commenting out while trying to get forms into table
	$sql = "SELECT URID FROM f23_User_Role_Table WHERE user_role_title = '$user_access_type'";
	$result = mysqli_query($db_conn, $sql);
	$row = mysqli_fetch_assoc($result);

	$user_access_type = $row['URID'];
	*/
	$user_access_type = 1;//delete when using the above code


	
	$sql = "INSERT INTO `f23_Form_Templates`(`TID`, `title`, `instructions`,  `user_access_role`) VALUES ('$TID', '$form_name', '$form_data', '$user_access_type')";
	$result = mysqli_query($db_conn, $sql);

	if ($result) {
            
        echo("<div class='w3-card w3-green w3-margin w3-padding'>Successfully Created a New Form.</div>");
    }       
	else {
            echo("<div class='w3-card w3-red w3-margin w3-padding'> Error Creating New Form.</div>");
			echo(mysqli_error($db_conn));
    }
}
	
?>

<script>

	// initialize the forms object
	
	var formData = {
		form_title: "",
		fields: []
	};
	
	var fieldId = 0;

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
							 	<div>
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

<h2 class='w3-margin'> Create Form</h2>
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
		<div id='submitArea' >
			<div class='w3-right-align w3-padding w3-margin-top w3-margin-bottom w3-margin-right'>
				<button type='submit' name='formCreate' class='w3-button w3-green w3-round-large'>Create form</button>
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

<!--
This modal will be used to edit the fields

<div id="editField" class="w3-modal">
    <div class="w3-modal-content">
      <div class="w3-container">
        <span onclick="document.getElementById('editField').style.display='none'" class="w3-button w3-display-topright">&times;</span>
        <p>Some text. Some text. Some text.</p>
        <p>Some text. Some text. Some text.</p>
      </div>
    </div>
</div>
-->

