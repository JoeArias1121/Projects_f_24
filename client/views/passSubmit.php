<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>theHive - Password Recovery</title>

  <!-- w3.css framework used for the styling of our application-->
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <!-- font used in the template -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
  <!--font awesome js -->
  <script defer src="../js/solid.js"></script>
  <script defer src="../js/fontawesome.js"></script>
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
    <div class="w3-container w3-col" style="width:20%"><a href="../../index.php" style="text-decoration:none"><h2 style="margin-left:20px"><strong>theHive</strong></h2></a>
    </div>
    <div class="w3-container w3-col" style="width:60%"></div>
    <div class="w3-container w3-col" style="width:20%; margin-top:20px"><span style="padding-right: 10px"><strong>No account yet?</strong></span><button class="w3-btn w3-ripple w3-round-large" onclick="window.location.href='signup.php'" style="background-color:#ea710f; color:white; margin-bottom: 5px">Sign Up</button>
    </div>
</div>
  <div class="">
  <form method="POST" class="w3-card-4 w3-padding w3-display-middle w3-white w3-round-xlarge" style="width: 100%; max-width:450px;">
      <div class="w3-center">
      <h1><strong>theHive</strong></h1>
        <?php 

              if(isset($_POST["reset-password-submit"])){
                $selector = $_GET["selector"];
                $validator = $_GET["validator"];
                $password = $_POST["newPass"];
                $passwordRepeat = $_POST["passRepeat"];
        
                if(empty($password) || empty($passwordRepeat)){ //if passwords are empty send back to index
                    header("Location: ../../index.php");
                    exit();
                }else if($password != $passwordRepeat){
                    header("Location: ../../index.php? newpwd=pwdnotthesame");
                    exit();
                }

                require '../../backend/db_connector.php';

                $sql = "SELECT * FROM f23_PWDReset WHERE pwdResetSelector= '$selector'";
                $query = mysqli_query($db_conn, $sql);
                $row = mysqli_fetch_assoc($query);

                if(empty($row)){
                    echo "you need to resubmit the request"; // if theres no row with the token selector than it will not work
                    exit();
                }
                //convert token into binary
                $tokenBin = hex2bin($validator);
                $tokenCheck = password_verify($tokenBin, $row["pwdResetToken"]);//true or false statment to check

                    if($tokenCheck == false){ //if tokens do not match throw an error and exit
                      echo "You need to re-submit your reset request";
                      exit();
                    }else{

                      $tokenEmail = $row['pwdResetEmail'];//get user email to cross reference user table
                      $sql2 = "SELECT * FROM f23_User_Table WHERE user_email = '$tokenEmail'"; //cross referencing user table
                      $query2 = mysqli_query($db_conn, $sql2);
                      $row2 = mysqli_fetch_assoc($query2);
                      $userEmail = $row2['user_email'];
                      if(empty($row2)) //if theres no match in the user table then throw this error
                      {
                        echo "emails do not match";
                        exit();
                      }else{ //since token and selector are checked and user is matched in user table the reset can occur
                        $sql3 = "UPDATE f23_User_Table SET user_password ='$password' WHERE user_email = '$tokenEmail'"; 
                        $query3 = mysqli_query($db_conn, $sql3);
                        echo "completed";
                      }

                    }
              }

        ?>
        <h3>Enter Your New Password</h3>
      </div>


      <div class="w3-padding">
      <label class="w3-left" style="font-weight:500;" for="inputNewPass">New Password</label><br>
        <div class="input" style="padding-bottom:12px"><svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M400 224h-24v-72C376 68.2 307.8 0 224 0S72 68.2 72 152v72H48c-26.5 0-48 21.5-48 48v192c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48V272c0-26.5-21.5-48-48-48zm-104 0H152v-72c0-39.7 32.3-72 72-72s72 32.3 72 72v72z"/></svg><input type="password" class="input-field w3-input w3-border w3-round-large w3-animate-input" id="inputUsername" name="newPass" placeholder="Enter New Password" required autofocus>
        </div>
      </div>

      <div class="w3-padding">
      <label class="w3-left" style="font-weight:500;" for="repeatPass">Re-Enter Password</label><br>
        <div class="input" style="padding-bottom:12px"><svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M400 224h-24v-72C376 68.2 307.8 0 224 0S72 68.2 72 152v72H48c-26.5 0-48 21.5-48 48v192c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48V272c0-26.5-21.5-48-48-48zm-104 0H152v-72c0-39.7 32.3-72 72-72s72 32.3 72 72v72z"/></svg><input type="password" class="input-field w3-input w3-border w3-round-large w3-animate-input" id="inputUsername" name="passRepeat" placeholder="Repeat Password" required autofocus>
              <input type="hidden" name="selector" value="<?php  echo $selector ?>;">
              <input type="hidden" name="validator" value="<?php  echo $validator;?>">            
        </div>
      </div>

      <div class="w3-center">
        <br>
        
        <button class="w3-btn w3-round w3-ripple w3-block" style="background-color:#2166c5; color: white" action="../../backend/pass-recoveryinc.php" name="reset-password-submit" type="submit"><b>Reset Password</b></button><br>
        <button type="button" class="w3-btn w3-round w3-ripple w3-block" style="background-color:#00b044; color: white" onClick="window.location.href='login.php';">Back to Login</button>
      </div>
    </form>
  </div>
</body>
</html>`