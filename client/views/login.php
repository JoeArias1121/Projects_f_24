<?php
  //Starting a session.
  if(!isset($_SESSION)) {
    session_start();
  }
  //If the user is already signed in we redirect to the dashboard.
  if(isset($_SESSION['user_type'])){
    header("Location: ../components/dashboard.php?content=home");
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>FlowWork - Log In</title>

  <!-- w3.css framework used for the styling of our application-->
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <!-- font used in the template -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
  <!--font awesome js -->
  <script defer src="../js/solid.js"></script>
  <script defer src="../js/fontawesome.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<style>

    html,body,h1,h2,h3,h4,h5 {font-family: "Raleway", sans-serif}

    body {
      background-image: url("../assets/bg2.png");
      background-size: cover;
      background-attachment: fixed;
      background-position: center top;
    }

        .forgot{
            position: absolute;
            margin-left:250px;
            margin-top: 10px;
            
        }
          
        .input {
            width: 100%;
            margin-bottom: 10px;
        }
          
        .icon {
            text-align:left;
            width: 1em;
            height: 1em;
            position: absolute;
            margin-top: 13px;
            margin-left: 10px;
            opacity: 0.5;
        }
          
        .input-field {
            width: 100%;
            padding: 10px;
            text-indent: 30px;
        }
</style>

<body class="w3-container">
<div class="w3-row" style="margin-top:20px">
    <div class="w3-container w3-col" style="width:20%"><a href="../../index.php" style="text-decoration:none"><h2 style="margin-left:20px;"><strong>FlowWork</strong></h2></a>
    </div>
    <div class="w3-container w3-col" style="width:60%"></div>
    <div class="w3-container w3-col" style="width:20%; margin-top:20px"><span style="padding-right: 10px"><strong>No account yet?</strong></span><button class="w3-btn w3-ripple w3-round-large" onclick="window.location.href='signup.php'" style="background-color:#ea710f; color:white; margin-bottom: 5px">Sign Up</button>
    </div>
</div>
  <div class="">
    <form method="POST" class="w3-card-4 w3-padding w3-display-middle w3-white w3-round-xlarge" style="width: 100%; max-width:450px;">
      <div class="w3-center">
      <h1><strong>FlowWork</strong></h1>
        <?php
          //Validate user sign in if form was submitted.
          if(isset($_POST['submit'])) {
            include_once('../../backend/db_connector.php');
            include_once('../../backend/util.php');

            //Get the input from the sign in form.
            $username = mysqli_real_escape_string($db_conn, $_POST['username']);
            $password = mysqli_real_escape_string($db_conn, $_POST['password']);
            //Check if any results match in the database.
            $sql = "SELECT * FROM `f23_User_Table` WHERE user_email = '$username' AND user_password = '$password'";
            $result = mysqli_query($db_conn, $sql);
            $row = mysqli_fetch_assoc($result);
            $count = mysqli_num_rows($result);

            //If there was a result with a matching username and password.
           if ($count == 1) {
              //Check if the account is active or terminated, if the status of the account is 3 then it's terminated.
              if($row['USID'] == 3) {
                echo '<div class="w3-panel w3-round w3-red">
                <p>Log In Failed:<br> This account was terminated, please contact a supervisor if this was a mistake.!</p>
                </div>';
              }
              else {
                $_SESSION['user_id'] = $row['UID'];
				        $_SESSION['user_login_name'] = $row['user_login_name'];
                $_SESSION['user_type'] = $row['URID'];
                $_SESSION['user_email'] = $row['user_email'];
                $_SESSION['user_name'] = $row['user_name'];
                $_SESSION['timestamp'] = time();
                $_SESSION['token'] = bin2hex(random_bytes(32));
                $login_date = date("Y-m-d");
                
                //login logs added
                $insert_log = "INSERT INTO f23_Login_Logs (UID, login_date, is_successful) VALUES ('user_id', '$login_date', '1')"; //preparing sql statement 
				        $db_conn->query($insert_log); //executing sql statement to insert into login_log table


 
                //If the user is found and the password is correct
                //  then print a success message and redirect
                echo '<div class="w3-panel w3-round w3-green">
                <p><i class="fa fa-spinner w3-spin" style="font-size:40px"></i></p>
                        <p><b>Welcome Back!</b><br> Redirecting..</p>
                      </div>';
                exit(header("refresh:1;url=../components/dashboard.php?content=jobslist")); //orignally content=home
              }
                
            } 
            else {
              //The username was not found or password didn't match
              //  then print an error message.
              echo '<div class="w3-panel w3-round w3-red">
                      <p>Log In Failed:<br> Invalid Username or Password!</p>
                    </div>';
            }
          }
        ?>
        <h3>Let's get started</h3>
      </div>
      

      <div class="w3-padding">
        <label class="w3-left" style="font-weight:500;" for="inputUsername">Email:</label><br>
        <div class="input" style="padding-bottom:12px"><svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M512 464c0 26.51-21.49 48-48 48H48c-26.51 0-48-21.49-48-48V200.724a48 48 0 0 1 18.387-37.776c24.913-19.529 45.501-35.365 164.2-121.511C199.412 29.17 232.797-.347 256 .003c23.198-.354 56.596 29.172 73.413 41.433 118.687 86.137 139.303 101.995 164.2 121.512A48 48 0 0 1 512 200.724V464zm-65.666-196.605c-2.563-3.728-7.7-4.595-11.339-1.907-22.845 16.873-55.462 40.705-105.582 77.079-16.825 12.266-50.21 41.781-73.413 41.43-23.211.344-56.559-29.143-73.413-41.43-50.114-36.37-82.734-60.204-105.582-77.079-3.639-2.688-8.776-1.821-11.339 1.907l-9.072 13.196a7.998 7.998 0 0 0 1.839 10.967c22.887 16.899 55.454 40.69 105.303 76.868 20.274 14.781 56.524 47.813 92.264 47.573 35.724.242 71.961-32.771 92.263-47.573 49.85-36.179 82.418-59.97 105.303-76.868a7.998 7.998 0 0 0 1.839-10.967l-9.071-13.196z"/></svg><input type="username" class="input-field w3-input w3-border w3-round-large w3-animate-input" id="inputUsername" name="username" placeholder="Enter your email" required autofocus>
        </div>
        <label class="w3-left" style="font-weight:500;" for="inputPassword">Password:</label><br>
        <div class="input"><svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M400 224h-24v-72C376 68.2 307.8 0 224 0S72 68.2 72 152v72H48c-26.5 0-48 21.5-48 48v192c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48V272c0-26.5-21.5-48-48-48zm-104 0H152v-72c0-39.7 32.3-72 72-72s72 32.3 72 72v72z"/></svg><span class="forgot"><a style="text-decoration:none; color: #0f8f7e" href="passRecovery.php">Forgot password?</a></span> <input type="password" class="input-field w3-input w3-border w3-round-large w3-animate-input" id="inputPassword" name="password" placeholder="Enter password" required>
        
        </div>
      </div>

      <div class = "w3-center w3-padding">
        <button class="w3-btn w3-round w3-ripple w3-block" style="background-color:#00b044; color: white" name="submit" type="submit"><b>Log In</b></button>
        <br>
      </div>
    </form>
  </div>
  
</body>
</html>