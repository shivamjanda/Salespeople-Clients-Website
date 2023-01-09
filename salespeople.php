<?php
/*
SHIVAM JANDA
2022-12-07
WEBD 3201
*/
$title = "Salespeople Page";
include "./includes/header.php";

$first_name = "";
$last_name = "";
$email = "";
$password = "";
$error = "";
$page = 1;

// sets the global variable page_salesperson to the current page number
$_SESSION['page_salesperson'] = 1;
if (isset($_GET["page"]))
{
	$_SESSION['page_salesperson'] = $_GET["page"];
}

// if the user is not logged in then redirect to sign in page
if (!$_SESSION["isVerified"])
{
	redirect("sign-in.php");
}

if (isset($_SESSION["userArray"]))
{
	// if the signin user is a salesperson
	if ($_SESSION["userArray"]["type"] == "s")
	{
		$_SESSION["unauthorized"] = true;
		redirect("sign-in.php");
	}
}

// if the add button is submited
if (isset($_POST["submit"]))
{
	$first_name = trim($_POST["firstName"]);
	$last_name = trim($_POST["lastName"]);
	$email = trim($_POST["inputEmail"]);
	$password = $_POST["password"];
	
	// call the first / last name validation functions
	$error .= first_name_validation($first_name);
	$error .= last_name_validation($last_name);

	// if the password validation function is equal to true  then set error message accordingly
	if (password_validation($password) == true)
	{
		$error .= "Dont include spaces for your password. ";
		$password = "";
	}
	
	// if there are no errors
	if ($error == "")
	{
		// call the insert sales people function that inserts the new sales person into the database
		insert_salespeople($email, $password, $first_name, $last_name, $date, $time);
		
		// set variables to empty
		$first_name = "";
		$last_name = "";
		$email = "";
		$error = "Sales person added sucessfully";
	}

	$password = "";
	setMessage($error);
	
}
$error = flashMessage();

// create an array of form boxes (use for display form function)
$form = array(
			array(
				"type" => "text",
				"name" => "firstName",
				"value" => "$first_name",
				"label" => "First Name",
			    "placeholder" => "First Name"
				),
			array(
				"type" => "text",
				"name" => "lastName",
				"value" => "$last_name",
				"label" => "Last Name",
				"placeholder" => "Last Name"

				),
			array(
				"type" => "email",
				"name" => "inputEmail",
				"value" => "$email",
				"label" => "Email",
				"placeholder" => "Email"
				),
			array(
				"type" => "password",
				"name" => "password",
				"value" => "$password",
				"label" => "password",
				"placeholder" => "Password"
				)
			);				

// create an array  (use for display table function)				
$table = array(
			"id" => "ID", 
			"email" => "Email", 
			"firstname" => "First Name", 
			"lastname" => "Last Name",
			"enable" => "Is Active?");
			

?>

<h2><?php echo $error; ?> </h2>
<form class="form-signin" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <h1 class="h3 mb-3 font-weight-normal">Adding a sales person</h1>
    <?php
	// call the display form function
		display_form($form);			
	?>
    <button class="btn btn-lg btn-primary btn-block" name="submit" type="submit">ADD</button>
</form>
<?php
// if the user is a admin 
if ($_SESSION["userArray"]["type"] == "a")
{
// call the display table function
display_table($table, salesperson_select_all($page), "Salespeople", $page, "", $_SESSION["userArray"]["type"], "");
}

// if the user is a salesperson 
if ($_SESSION["userArray"]["type"] == "s")
{
	// call the display table function
	display_table($table, salesperson_select_all($page), "Salespeople", $page, "", $_SESSION["userArray"]["type"], "");

}


include "./includes/footer.php";
?>    