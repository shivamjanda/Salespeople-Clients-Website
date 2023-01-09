<?php
/*
SHIVAM JANDA
2022-12-07
WEBD 3201
*/

$title = "Password Change";
include "./includes/header.php";

$errorMessage = "";

// if the user is not signed in then redirect to sign in page
if (!$_SESSION["isVerified"])
{
	redirect("sign-in.php");
}

// if the user presses confirm
if (isset($_POST["submit"]))
{
	$password = $_POST["password"];
	$confirmPassword = $_POST["confirm"];
	// call the confirm password validation method
	$errorMessage .= confirm_password_validation($password, $confirmPassword);
	
	// if there are no errors then 
	if($errorMessage == "")
	{
		// if the passwords do not match then
		if ($password !== $confirmPassword)
		{
			// set error message accordingly
			$errorMessage = "Passwords do not match";
		}
		else
		{
			// call the update password function using the confirm password entered by the user and the accociated email address
			update_password($confirmPassword, $_SESSION["userArray"]["emailaddress"]);
			$errorMessage = "Password has been changed successfully.";
			redirect("dashboard.php"); // redirect to dashboard
		}
	}
	setMessage($errorMessage);
}
$errorMessage = flashMessage();	

// create an array of form boxes (use for display form function)
$form = array(
array("type" => "password", "name" => "password", "value" => "", "label" => "New Password", "placeholder" => "New Password"),
array("type" => "password", "name" => "confirm", "value" => "", "label" => "Re-type Password", "placeholder" => "Re-type Password"));

?>
<h3><?php echo $errorMessage; ?></h3>
<form class="form-signin" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <h1 class="h3 mb-3 font-weight-normal">Change Password</h1>
<?php
// call the display form function
display_form($form);
?>
	<button class="btn btn-lg btn-primary btn-block" name="submit" type="submit">Confirm</button>
</form>

<?php
include "./includes/footer.php";
?>    