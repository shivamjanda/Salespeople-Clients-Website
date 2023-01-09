<?php
/*
SHIVAM JANDA
2022-12-07
WEBD 3201
*/
$title = "Reset pasword email";
include "./includes/header.php";
$displayMessage= "";

if (!$_SESSION["isVerified"])
{
	redirect("sign-in.php");
}

if (isset($_POST["confirm"]))
{
	$email = $_POST["inputEmail"];
	setMessage("Email has been sent to " .$email);
	// if email exists in the database
	if (user_select($email) != false)
	{
		/*
		 Code below does not work on winscp. Works on local host and changed directory in php.ini file
		*/
		//$to      = '$email';
		//$subject = 'Password Reset';
		//$message = 'No need to worry, you can reset your email password by clicking the link: https://opentech.durhamcollege.org/webd3201/jandas/lab4/change-password.php'
		//.$_SESSION["userArray"]["id"].".\nIf you didn't request a password reset, feel free to delete this email and carry on.\nAll the best,\n\nShiv's Website Management Team\n\n\n";
	   // $headers/ = 'From: ShivsWebsiteManagementTeam@gmail.com' . "\r\n";
		//mail($to, $subject, $message, $headers);
		
		// logs email sent to user to Email_log.txt file
		$log = fopen("EMAIL_log.txt", "a");
		$insertTxt = "Password Reset\n\nHi "
		.$_SESSION["userArray"]["firstname"].
		",\n\nNo need to worry, you can reset your email password by clicking the link: https://opentech.durhamcollege.org/webd3201/jandas/lab4/change-password.php"
		.$_SESSION["userArray"]["id"].
		".\nIf you didn't request a password reset, feel free to delete this email and carry on.
		\nAll the best,\n\nShiv's Website Management Team\n\n\n";
		
		fwrite($log, $insertTxt);
		fclose($log);
		
		unset($_SESSION["userArray"]);
	}
	else 
		// if email does not exist then display error message
	setMessage("No email found in our database");
	$displayMessage = flashMessage();
}


?>
<h3><?php echo $displayMessage; ?></h3>
<form class="form-signin" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <h1 class="h3 mb-3 font-weight-normal">Enter Your Email</h1>
    <label for="inputEmail" class="sr-only">Email Address</label>
    <input type="email" name="inputEmail" class="form-control" value="" placeholder="Email Address" required autofocus>
    <button class="btn btn-lg btn-primary btn-block" name="confirm" type="submit">Confirm</button>
</form>
<?php
include "./includes/footer.php";
?>    