<?php


    include_once('db_connector.php');
    include_once('config.php');

    $action = isset($_POST['action']);
    
    switch($action){
        case "change":
            change();
            break;
        case "delete":
            delete();
            break;
        default:
        echo "no function picked";

    }



    function change() //change function 
    {
        echo 'am I here?';
        $server = 'localhost';
        $user = 'p_s24_03';
        $pass = '41brdm';
        $db = 'p_s24_03_db';

        $db_conn2 = new mysqli($server, $user, $pass, $db);
        // Check connection
        if ($db_conn2->connect_error) {
            die("Connection failed: " . $db_conn2->connect_error);
        } 
        $id = $_POST["id"];
        $sql = "UPDATE message_t SET message_status = '3' WHERE message_id = '$id'";
        if(mysqli_query($db_conn2, $sql) == TRUE)
        {
            echo 1;
            exit;
        }
        else{
            echo 0;
        }

    }

    function delete() //delete function for message
    {
        echo 'in the right function';
        $server = 'localhost';
        $user = 'p_s24_03';
        $pass = '41brdm';
        $db = 'p_s24_03_db'; //creating these new connections each function could have been avoided with a database connection object, this was easiest way with the timeline to get ajax done

        $db_conn2 = new mysqli($server, $user, $pass, $db);


        if ($db_conn2->connect_error) {
            die("Connection failed: " . $db_conn2->connect_error);
        } 

        $id = $_POST["id"];
        echo $id;

        $sql = "DELETE from message_t WHERE message_id = '$id'";

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