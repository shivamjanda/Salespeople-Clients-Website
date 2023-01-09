<?php
/*
SHIVAM JANDA
2022-12-07
WEBD 3201
*/
$title = "Login Page";
include "./includes/header.php";


// if the user is not verified and the user enteres submit
if (isset($_POST["submit"]) && $_SESSION["isVerified"] == false)
{	
	$inputEmail = $_POST["inputEmail"];
	$inputPassword = $_POST["inputPassword"];
}

// if the user presses sign in 
if (isset($_POST["submit"]))
{	
	
	// if the user authenticate function returns true
	if (user_authenticate($inputEmail, $inputPassword) != false)
	{
		// call the user select function by taking in the email
		user_select($inputEmail);
		
		if ($_SESSION["userArray"]["enable"] == "t") //if the user account is active then
		{
			$_SESSION["isVerified"] = true;
			$_SESSION["successMsg"] = true;
			$inputEmail = "";
			$inputPassword = "";
			redirect("dashboard.php"); // redirect to dashboard
		}
		else 
		setMessage("Your account is inactive!"); // otherwise the account is inactive
	}
	
	else
	setMessage("Password or email is incorrect!"); // otherwise set/flash error message
}

$message = flashMessage();


?>   
<h2><?php echo $message; ?> </h2>
<form class="form-signin" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
    <label for="inputEmail" class="sr-only">Email address</label>
    <input type="email" name="inputEmail" class="form-control" value="" placeholder="Email address" required autofocus>
    <label for="inputPassword" class="sr-only">Password</label>
    <input type="password" name="inputPassword" class="form-control" value="" placeholder="Password" required>
    <button class="btn btn-lg btn-primary btn-block" name="submit" type="submit">Sign in</button>
</form>

<?php
include "./includes/footer.php";
?>    