<?php
/*
SHIVAM JANDA
2022-12-07
WEBD 3201
*/

/*
Function to redirect to another URL
*/
function redirect($url){
	header("Location:".$url);
	ob_flush();
}

function setMessage($msg){
	$_SESSION['message'] = $msg;
}

function getMessage(){
	return $_SESSION['message'];
}

function isMessage(){
	return isset($_SESSION['message'])?true:false; // conditional operator
}

function removeMessage(){
	unset($_SESSION['message']);  
}

function flashMessage(){
	$message = "";
	if (isMessage())
		{
			$message = getMessage();
			removeMessage();
		}
		return $message;
}

function dump($arg)
{
	echo "<pre>";
	print_r($arg);
	echo "</pre>";
}

// function to display the forms 
function display_form($array)
{
	foreach($array as $arrays => $data)
	{
		echo "<label for=\"".$data["label"]."\" class=\"sr-only\">".$data["label"]."</label>";
		echo "<input type=\"".$data["type"]."\" name=\"".$data["name"]."\" class=\"form-control\" value=\"".$data["value"]."\" placeholder=\"".$data["placeholder"]."\" required>";
	}
}

// function to display the drop down for salesperson
function salesperson_drop_down()
{
	check_all_salespeople();
	echo "<option disabled selected>Select a Salesperson</option>";
		for ($i = 0; $i < count($_SESSION["everySalesPerson"]); $i++)
		{	// goes through every salesperson from id 'i' and displays the options of salespeople it looped through
			$idArray[$i] = $_SESSION["everySalesPerson"][$i]["id"]; 
			echo "<option>".$_SESSION["everySalesPerson"][$i]["id"]." ".$_SESSION["everySalesPerson"][$i]["firstname"]." ".$_SESSION["everySalesPerson"][$i]["lastname"]."</option>";
		}
		echo "</select>";
}

// first name validation
function first_name_validation($first_name)
{
	$errors = "";
	if ($first_name == "")
	{
		$errors .= "Enter a first name ";
		return $errors;
	}
	else if (is_numeric($first_name))
	{
		$errors = "Enter a first name thats not numeric";
		return $errors;
	}
	
}

// last name validation
function last_name_validation($last_name)
{
	$errors = "";
	if ($last_name == "")
	{
		$errors .= "Enter a last name ";
		return $errors;
	}
	else if (is_numeric($last_name))
	{
		$errors = "Enter a last name thats not numeric";
		return $errors;
	}
}


// phone validation
function phone_validation($number)
{
	if (!preg_match("/^[0-9]{10}$/", $number))
	{
		return true;
	}
}


// password validation
function password_validation($password)
{
	if (strpos($password, " ") !== false)
	{
		return true;
	}
}

// confirm password validation
function confirm_password_validation($password, $confirmPassword)
{
	$errorMessage = "";
	
	// if there are spaces in the typed password
	if (strpos($password, " ") !== false || strpos($confirmPassword, " ") !== false)
	{
		$errorMessage .= "Make sure your password does not include spaces. ";
		
	}
	
	// if the password / confirm password is less than 3 characters in length
	if (strlen($password) < 3 || strlen($confirmPassword) < 3)
	{
		$errorMessage .= "Make sure your password is at least 3 characters long. ";
	}
	
	return $errorMessage;
	
}

// Display table function 
function display_table($columns, $records, $tableTitle, $p, $id, $type, $img)
{
	
	echo "<div class=\"table-responsive\">";
	echo "<h2>".$tableTitle."</h2>";
	echo "<table id=\"dataTable\" class=\"table table-striped table-sm\">";
	echo "<thead>";
	echo "<tr>";
	// loop through each column of the header of the table
	foreach ($columns as $column => $heading)
	{
		echo "<th>".$heading."</th>";
	}
	echo "</tr>";
	echo "</thead>";
	echo "<tbody>";
	
	if (isset($_POST["update"]) && $type == "a")
	{
		$i = 0;
	
		foreach ($_POST["active"] as $active)
		{
			// loops through each record of users 
			foreach ($records as $record => $row)
			{	
				// if the user is updated as active then
				if ($active == $row["id"]."t")
				{
					// use the update_enable functon to set the enable property of that user to true
					update_enable("true", $row["emailaddress"]);
					$records[$i]["enable"] = "t";
				}
				// otherwise if it is false
				else if ($active == $row["id"]."f")
				{
					// use the update_enable functon to set the enable property of that user to false
					update_enable("false", $row["emailaddress"]);
					$records[$i]["enable"] = "f";
				}
				$i++;
			}
		}
	}
	
	// get the array of users that are limited to 10 per page from the limit_users function depending on what the passed in value '$p' (determines what table is being shown) is 
	$arr = limit_users($p);
	 
	 // loop through each row of the array
	 while($row = pg_fetch_assoc($arr)){
		 
		 // if the page is a salesperson table
        if ($p == 1)
		{
			// display the id, firstname, email and last name of that user in the array
			echo "<tr>";
			echo "<td>".$row["id"]."</td>";
			echo "<td>".$row["emailaddress"]."</td>";
			echo "<td>".$row["firstname"]."</td>";
			echo "<td>".$row["lastname"]."</td>";
			
			// if the enable property of the user is true and the user is an admin then 
			if ($row["enable"] == "t" && $type == "a")
			{
				// display the radio button that determines if the user is active 
				echo "<td>";
				echo "<form action=\"\" method=\"post\">";
				echo "<input type=\"radio\" id=\"active\" value=\"".$row["id"]."t\" name=\"active[$i]\" checked/>";
				echo "<label for=\"active\">&nbsp;Active</label><br/>";
				echo "<input type=\"radio\" id=\"inactive\" value=\"".$row["id"]."f\" name=\"active[$i]\"/>";
				echo "<label for=\"inactive\">&nbsp;Inactive</label><br/>";
				echo "<input type=\"submit\" name=\"update\" value=\"Update\"/>";
				echo "</form>";
				echo "</td>";
			}
			// if the enable property of the user is false and the user is an admin then 
			if ($row["enable"] == "f" && $type == "a")
			{
				// display the radio button that determines if the user is inactive
				echo "<td>";
				echo "<form action=\"\" method=\"post\">";
				echo "<input type=\"radio\" id=\"active\" value=\"".$row["id"]."t\" name=\"active[$i]\"/>";
				echo "<label for=\"active\">&nbsp;Active</label><br/>";
				echo "<input type=\"radio\" id=\"inactive\" value=\"".$row["id"]."f\" name=\"active[$i]\" checked/>";
				echo "<label for=\"inactive\">&nbsp;Inactive</label><br/>";
				echo "<input type=\"submit\" name=\"update\" value=\"Update\"/>";
				echo "</form>";
				echo "</td>";
			}
			echo "</tr>";
			$i++;
		}
		
		// if its page 2 (clients table)
		if ($p == 2)
		{
			if ($id == $row["clientid"])
			{
				echo "<tr>";
				echo "<td>".$row["firstname"]."</td>";
				echo "<td>".$row["lastname"]."</td>";
				echo "<td>".$row["emailaddress"]."</td>";
				echo "<td>".$row["phonenumber"]."</td>";
				echo "<td><img style=\"width:40px;height:40px;\" src=".$row["filepath"]." alt=".$img."></td>";
				echo "</tr>";
			}
			// if the user is an admin
			else if ($p == "a")
			{
				echo "<tr>";
				echo "<td>".$row["firstname"]."</td>";
				echo "<td>".$row["lastname"]."</td>";
				echo "<td>".$row["emailaddress"]."</td>";
				echo "<td>".$row["phonenumber"]."</td>";
				echo "<td><img style=\"width:40px;height:40px;\" src=".$row["filepath"]." alt=".$img."></td>";
				echo "</tr>";
			}
		}
		// if its page 3 (calls table)
		if ($p == 3)
		{
			// if the id is equal to the salesperson id of the 
			if ($id == $row["salespersonid"])
			{
				echo "<tr>";
				echo "<td>".$row["firstname"]."</td>";
				echo "<td>".$row["lastname"]."</td>";
				echo "<td>".$row["emailaddress"]."</td>";
				echo "<td>".$row["phonenumber"]."</td>";
				echo "<td>".$row["calldate"]."</td>";
				echo "<td>".$row["calltime"]."</td>";
				echo "</tr>";
			}
			// if the user is an admin
			else if ($type == "a")
			{
				echo "<tr>";
				echo "<td>".$row["firstname"]."</td>";
				echo "<td>".$row["lastname"]."</td>";
				echo "<td>".$row["emailaddress"]."</td>";
				echo "<td>".$row["phonenumber"]."</td>";
				echo "<td>".$row["calldate"]."</td>";
				echo "<td>".$row["calltime"]."</td>";
				echo "</tr>";	
			}
		}

    }
	
	echo "</table>";
	// function that gets the total users per page
	$total = total_user_records_per_page($p);
	
	// if its the salesperson table then 
	if ($p == 1)
	{
		// output the number of pages needed to display 10 at at time referencing the page number of that php page
		for($i = 1; $i <= $total/MAX_PAGES; $i++) 
		{  
			echo "<a style='color:black' href='salespeople.php?page=".$i."'>".$i."</a>&nbsp;&nbsp;"; 
		}    
	}
	// if its a clients table then
	else if ($p == 2)
	{
		// output the number of pages needed to display 10 at at time referencing the page number of that php page
		for($i = 1; $i <= $total/MAX_PAGES; $i++) 
		{  
			echo "<a style='color:black' href='clients.php?page=".$i."'>".$i."</a>&nbsp;&nbsp;"; 
		}    
	}
	// if its a calls table then
	else if ($p == 3)
	{
		// output the number of pages needed to display 10 at at time referencing the page number of that php page
		for($i = 1; $i <= $total/MAX_PAGES; $i++) 
		{  
			echo "<a style='color:black' href='calls.php?page=".$i."'>".$i."</a>&nbsp;&nbsp;"; 
		}
	}
	 
}
	
	

?>

