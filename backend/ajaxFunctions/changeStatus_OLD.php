<?php


    include_once('../db_connector.php');
    include_once('../config.php');

    $action = isset($_POST['change']);
    
    switch($action){
        case "change":
            change();
            break;
        default:
        echo "no function picked";

    }


    function change() //change function 
    {
        $server = 'localhost';
        $user = 'p_f23_04';
        $pass = '14suvo';
        $db = 'p_f23_04_db';

        $db_conn2 = new mysqli($server, $user, $pass, $db);
        // Check connection
        if ($db_conn2->connect_error) {
            die("Connection failed: " . $db_conn2->connect_error);
        } 
        $id = $_POST["id"];
        $sql = "UPDATE f23_Message_T SET message_status = '3' WHERE message_id = '$id'";
        if(mysqli_query($db_conn2, $sql) == TRUE)
        {
            echo 1;
            exit;
        }
        else{
            echo 0;
        }

    }



?>