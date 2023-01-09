<?php
/*
SHIVAM JANDA
2022-12-07
WEBD 3201
*/
$title = "Calls Page";
include "./includes/header.php";

$first_name = "";
$last_name = "";
$email = "";
$number = "";
$error = "";
$date = "";
$time = "";
$disabled = "";
$page = 3;

// sets the global variable page_call to the current page number
$_SESSION['page_call'] = 1;
if (isset($_GET["page"]))
{
	$_SESSION['page_call'] = $_GET["page"];
}

// if the user is not logged in redirect to sign in page
if (!$_SESSION["isVerified"])
{
	redirect("sign-in.php");
}

if (isset($_SESSION["userArray"]))
{
	// a = admin
	if ($_SESSION["userArray"]["type"] == "a")
	{
		$disabled = "disabled";
	}
}

// if the add button is submitted
if (isset($_POST["submit"]))
{
	$date = $_POST["date"];
	$time = $_POST["time"];
	$first_name = trim($_POST["firstName"]);
	$last_name = trim($_POST["lastName"]);
	$email = trim($_POST["inputEmail"]);
	$number = trim($_POST["phoneNumber"]);
	
	// call the validation methods for first name and last name
	$error .= first_name_validation($first_name);
	$error .= last_name_validation($last_name);
	
	if (phone_validation($number) == true)
	{
		$error .= "Enter a valid phone number. ";
		$number = "";
	}
	
	// if no errors then
	if ($error == "")
	{
		// use the insert calls function to insert the new call to the database and set each vairable to its deafult value
		$id = $_SESSION["userArray"]["id"];
		insert_calls($id, $first_name, $last_name, $email, $number, $date, $time);
		$first_name = "";
		$last_name = "";
		$email = "";
		$number = "";
		$error = "Call record has been succesfully added. ";
	}
	// display message
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
				"type" => "phone",
				"name" => "phoneNumber",
				"value" => "$number",
				"label" => "Phone Number",
				"placeholder" => "Phone Number"
				)
			);
// create an array  (use for display table function)	
$table = array(
			"firstname" => "First Name",
			"lastname" => "Last Name",
			"emailaddress" => "Email", 
			"phonenumber" => "Phone Number", 
			"calldate" => "Call Date", 
			"calltime" => "Call Time");
?>
<h2><?php echo $error; ?> </h2>
<form class="form-signin" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <h1 class="h3 mb-3 font-weight-normal">Adding a Call</h1>
    <?php
		display_form($form);
	?>
	<label for="Date" class="sr-only">Date</label>
    <input type="date" name="date" class="form-control" value="$date" placeholder="" required>
	
	<label for="Time" class="sr-only">Time</label>
    <input type="time" name="time" class="form-control" value="$time" placeholder="" required>

    <button class="btn btn-lg btn-primary btn-block" name="submit" type="submit" <?php echo $disabled; ?>>ADD</button>
</form>
<?php
// call the display table function
display_table($table, "", "Calls", $page, $_SESSION["userArray"]["id"], $_SESSION["userArray"]["type"], "");
include "./includes/footer.php";
?>    













