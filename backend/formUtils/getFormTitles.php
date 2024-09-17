<?php 
    include_once('../config.php');
    include_once('../db_connector.php');

    $sql="SELECT title FROM `s21_form_templates`";
    $result = mysqli_query($db_conn,$sql);
    $titles = "";

    while ($row = mysqli_fetch_array($result)) {
    	$titles.= $row['title'].= '=>';
    }
    
    echo($titles);
?>