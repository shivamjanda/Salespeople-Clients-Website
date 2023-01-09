<?php
/*
SHIVAM JANDA
2022-12-07
WEBD 3201
*/
$title = "Clients Page";
include "./includes/header.php";

$first_name = "";
$last_name = "";
$email = "";
$number = "";
$aID = "";
$error = "";
$page = 2;

// sets the global variable page_client to the current page number
$_SESSION['page_client'] = 1;
if (isset($_GET["page"]))
{
	$_SESSION['page_client'] = $_GET["page"];
}
// if the user is not verified aka not logged in then redirect them to the sign in page
if (!$_SESSION["isVerified"])
{
	redirect("sign-in.php");
}

// if the add button is submitted
if (isset($_POST["submit"]))
{
	$first_name = trim($_POST["firstName"]);
	$last_name = trim($_POST["lastName"]);
	$email = trim($_POST["inputEmail"]);
	$number = trim($_POST["phoneNumber"]);
	
	// call the first name / last name functions
	$error .= first_name_validation($first_name);
	$error .= last_name_validation($last_name);


	// function to check if the phone number has all the requirments to be a phone number
	if (phone_validation($number) == true)
	{
		$error .= "Enter a valid phone number. ";
		$number = "";
	}
	
	
	
	$fileName = $_FILES['fileName']['name'];
	$tempName = $_FILES['fileName']['tmp_name'];
	$fileSize = $_FILES['fileName']['size'];
	$ext = pathinfo($fileName, PATHINFO_EXTENSION);
	
	if (isset($fileName))
	{
		// if the filename is not empty
	  if(!empty($fileName))
		{
			// if the file size is greater than 5 mb
			if ($fileSize > 5 *1024 * 1024)
			{
				//  error message
				$error.= "File is too large";
			}
			// if the uploaded file extension is not in the array of extenstions then
			elseif (!in_array($ext,['png', 'jpeg', 'svg', 'jpg', 'PNG']))
			{
				// ouput error message
				$error.= "invalid file type";
			}
			
			else 
				// otherwise move the upload to the new location in the logos folder
				$destination = "./logos/";
				if(move_uploaded_file($tempName,$destination.$fileName))
				{
					$img = $fileName;
				}	
		}
	}

	
	// if there are no errors then  
	if ($error == "")
	{
		if ($_SESSION["userArray"]["type"] == "s")
		{
			$aID = $_SESSION["userArray"]["id"];
		}
		
		// a = admin
		if ($_SESSION["userArray"]["type"] == "a")
		{
			$aID = $_POST["aID"];
			$aID = strtok($aID,' '); 
		}
		// insert new client into client database
		insert_clients($aID, $first_name, $last_name, $email, $number, $img);
		
		// set variables to deafult value
		$first_name = "";
		$last_name = "";
		$email = "";
		$number = "";
		$img = "";
		$error = "Client has been sucessfully added.";
	}
	
	
	
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
			"filepath" => "Logo");
?>
<h2><?php echo $error; ?> </h2>
<form class="form-signin" method="post" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <h1 class="h3 mb-3 font-weight-normal">Adding a Client</h1>
    <?php
	// call the display form function
		display_form($form);
		// if user is an admin 
		if ($_SESSION["userArray"]["type"] == "a")
		{	
			echo "<select name=\"aID\" id=\"aID\" class=\"form-control form-control-lg\">";
			// call the salesperson_drop_down function that displays the list of sales person
			salesperson_drop_down();
		}
	?>
	<input type="file" name="fileName"><br><br>
	
    <button class="btn btn-lg btn-primary btn-block" name="submit" type="submit">ADD</button>
</form>




<?php

// call the display table function
display_table($table, "", "Clients", $page, $_SESSION["userArray"]["id"], $_SESSION["userArray"]["type"], $img); 

include "./includes/footer.php";
?>    