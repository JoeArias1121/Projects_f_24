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
  html,
  body,
  h1,
  h2,
  h3,
  h4,
  h5 {
    font-family: "Raleway", sans-serif
  }

  body {
    background-image: url("../assets/bg2.png");
    background-size: cover;
    background-attachment: fixed;
    background-position: center top;
  }

  .forgot {
    position: absolute;
    margin-left: 250px;
    margin-top: 10px;

  }

  .input {
    width: 100%;
    margin-bottom: 10px;
  }

  .icon {
    text-align: left;
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
    <div class="w3-container w3-col" style="width:20%"><a href="../../index.php" style="text-decoration:none">
        <h2 style="margin-left:20px"><strong>theHive</strong></h2>
      </a>
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
        if (isset($_POST['send'])) {
          include_once('../../backend/db_connector.php');
          include_once('../../backend/util.php');
          include_once('../../backend/emailPlugin.php');
          include_once('../../backend/config.php');


          //tokens for later just fixing the organization of this file
          $selector = bin2hex(random_bytes(8));
          $token = random_bytes(32);
          $validator = bin2hex($token);
          $Esubject = "Password reset request";
          //creating link to send to user email
          $url = "https://cs.newpaltz.edu/p/s22-03/v5/client/views/passSubmit.php?selector=" . $selector . "&validator=" . $validator;

          //time limit for token going to be 15 minutes
          $expires = date("U") + 900;

          $useremail = $_POST["email"]; //saves user email
          $sql = "SELECT * FROM f23_User_Table WHERE user_email = '?'";
          $stmt = mysqli_stmt_init($db_conn);
          if (!mysqli_stmt_prepare($stmt, $sql)) {
            echo "There was an error";
            exit();
          } else {

            $sql = "INSERT INTO f23_PWDReset (pwdResetEmail, pwdResetSelector, pwdResetToken, pwdResetExpires) VALUES (?,?,?,?);";
            $stmt = mysqli_stmt_init($db_conn);
            if (!mysqli_stmt_prepare($stmt, $sql)) {
              echo "There was an error";
              exit();
            } else {
              $hashedToken = password_hash($token, PASSWORD_DEFAULT);
              mysqli_stmt_bind_param($stmt, "ssss", $useremail, $selector, $hashedToken, $expires);
              mysqli_stmt_execute($stmt);
            }

            echo ("<div class='w3-panel w3-margin w3-green'><p>Password reset submitted</p></div>");
            $message = "<html>

<p>You've submitted a parrword reset request</p>

<p>Please login to change your password: &nbsp; $url</p>

<hr>

<br>
<br>
Please do not reply to this email as it is sent from an unattended mailbox.

</html>";
            sendMail($useremail, "Nexus Workflow Account", $message);

            exit(header("refresh:5;url=./login.php"));
          }
        }
        ?>
        <h3>Please enter your email address</h3>
      </div>

      <div class="w3-padding">
        <label class="w3-left" style="font-weight:500;" for="inputUsername">Email:</label><br>
        <div class="input" style="padding-bottom:12px"><svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
            <path d="M512 464c0 26.51-21.49 48-48 48H48c-26.51 0-48-21.49-48-48V200.724a48 48 0 0 1 18.387-37.776c24.913-19.529 45.501-35.365 164.2-121.511C199.412 29.17 232.797-.347 256 .003c23.198-.354 56.596 29.172 73.413 41.433 118.687 86.137 139.303 101.995 164.2 121.512A48 48 0 0 1 512 200.724V464zm-65.666-196.605c-2.563-3.728-7.7-4.595-11.339-1.907-22.845 16.873-55.462 40.705-105.582 77.079-16.825 12.266-50.21 41.781-73.413 41.43-23.211.344-56.559-29.143-73.413-41.43-50.114-36.37-82.734-60.204-105.582-77.079-3.639-2.688-8.776-1.821-11.339 1.907l-9.072 13.196a7.998 7.998 0 0 0 1.839 10.967c22.887 16.899 55.454 40.69 105.303 76.868 20.274 14.781 56.524 47.813 92.264 47.573 35.724.242 71.961-32.771 92.263-47.573 49.85-36.179 82.418-59.97 105.303-76.868a7.998 7.998 0 0 0 1.839-10.967l-9.071-13.196z" />
          </svg><input type="email" class="input-field w3-input w3-border w3-round-large w3-animate-input" id="inputUsername" name="email" placeholder="Enter your email" required autofocus>
        </div>
      </div>

      <div class="w3-center">
        <br>

        <button class="w3-btn w3-round w3-ripple w3-block" style="background-color:#2166c5; color: white" name="send" type="submit"><b>Reset Password</b></button><br>
        <button type="button" class="w3-btn w3-round w3-ripple w3-block" style="background-color:#00b044; color: white" onClick="window.location.href='login.php';">Back to Login</button>
      </div>
    </form>
  </div>
</body>

</html>`