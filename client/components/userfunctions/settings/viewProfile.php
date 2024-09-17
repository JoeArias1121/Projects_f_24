<?php include_once('./userfunctions/settings/settings.php') ?>

<div class="w3-card w3-white w3-round-large w3-padding w3-margin">
    <h5 class="w3-center w3-margin-bottom">My Account</h5>
    <form method="post">
        <label for="userName">Full Name:</label>
        <input class="w3-input w3-round-large w3-border w3-margin-bottom w3-sand" type="text" value="<?php echo $_SESSION['user_name']; ?>" readonly></input>
        <label for="userEmail">Email</label>
        <input class="w3-input w3-round-large w3-border w3-margin-bottom w3-sand" type="text" value="<?php echo $_SESSION['user_email']; ?>" readonly></input>
    </form>
</div>