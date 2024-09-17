<?php 


include_once('../../backend/config.php');
include_once('../../backend/db_connector.php');

//retrieve original form
$tid = 32;
$sql = "SELECT title, instructions FROM f23_Form_Templates WHERE TID = '$tid'";
$result = mysqli_query($db_conn, $sql);
$row = mysqli_fetch_array($result);

$instructions = $row['instructions'];
$title = $row['title'];


//retrieve form results

$form = 32;//TID of form, make sure only one submission per form when testing
$sql = "SELECT results FROM s24_form_submissions WHERE form = '$form'";
$submissionResult = mysqli_query($db_conn, $sql);
$row = mysqli_fetch_array($submissionResult);

$results = json_decode($row['results'], true);

//$user = $row['user'];


?>

<div id='formPreview' class='w3-card w3-white w3-round-large w3-padding-large w3-margin'></div>

<script>


	<?php echo "var formData = '$instructions';"; ?>
    <?php echo "var formTitle = '$title';"; ?>
	formData = JSON.parse(formData);
	

	preview = document.getElementById('formPreview');
	fields = formData.fields;
	//console.log(fields);

    
    //submission
    var resultData = '<?php echo json_encode($results); ?>';
    resultData = JSON.parse(resultData);
    console.log(resultData);

    preview.innerHTML += `<h1 class='w3-center'>${formTitle}</h1>`; 
    for (var i = 0; i < fields.length; i++) { //print form results
        preview.innerHTML +=
                        `     
                                <h4 class='w3-padding'>${fields[i].field_title}</h4>
                                <div class='w3-row'>
											<div class='w3-threequarter w3-padding'>
												${getResults(i)}
											</div>
										</div>
                                <hr>
                                         
                        `;
    }


	function getResults(i) {
		if (fields[i].field_type === 'text') {
            return resultData[i];

		}
		if (fields[i].field_type === 'checkbox') {
            var choices = resultData[i];
            var chosen = "";

			for (var j = 0; j < fields[i].field_choices.length; j++){
                if (choices[j] == 1) { 
                    chosen += fields[i].field_choices[j] + "<br>"; 
                }
            }
            return chosen;
		}
	    if (fields[i].field_type === 'mc') {
			/*var selectedMC = resultData[i];
            var selected = fields[i].field_choices[selectedMC];
            return selected;
            */
            return resultData[i];
        }
	}

	
</script>


