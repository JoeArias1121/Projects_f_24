<?php


    include_once('../db_connector.php');
    include_once('../config.php');

    $action = isset($_POST['action']);
    
    switch($action){
        case "delete":
            delete();
            break;
        default:
        echo "no function picked";

    }

    function delete() //delete function for message
    {
        echo 'in the right function';
        $server = 'localhost';
        $user = 'p_s24_03';
        $pass = '41brdm';
        $db = 'p_s24_03_db';//creating these new connections each function could have been avoided with a database connection object, this was easiest way with the timeline to get ajax done

        $db_conn2 = new mysqli($server, $user, $pass, $db);


        if ($db_conn2->connect_error) {
            die("Connection failed: " . $db_conn2->connect_error);
        } 

        $id = $_POST["id"];
        echo $id;

        $sql = "DELETE from f23_Message_T WHERE message_id = '$id'";

        if(mysqli_query($db_conn2, $sql) == TRUE)
        {
            echo "data deleted";
            exit;
        }
        else{
            echo 0;
            exit;
        }
    }


?>