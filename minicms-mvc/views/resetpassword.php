<h1><?php echo $pageTitle; ?></h1>

<?php include "messages.php"; ?>

<p>Set your new password below :</p>
<form action="" method="POST">
    <label>Password : <input type="password" name="reset_password" required></label> <br>
    <label>Confirm password : <input type="password" name="reset_password_confirm" required></label> <br>
    <input type="submit" value="Reset password">
</form>