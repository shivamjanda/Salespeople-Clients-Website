<?php
/*
SHIVAM JANDA
2022-12-07
WEBD 3201
*/
function db_connect(){
	return pg_connect("host=".DB_HOST." port=".DB_PORT." dbname=".DATABASE." user=".DB_ADMIN." password=".DB_PASSWORD);
}

$user_select = pg_prepare(db_connect(), "user_select", "SELECT * FROM users WHERE EmailAddress = $1");
$select_all = pg_prepare(db_connect(), "select_all", "SELECT * FROM users");
$select_all_salespeople = pg_prepare(db_connect(), "select_all_salespeople", "SELECT * FROM users WHERE type = 's'");
$select_all_clients = pg_prepare(db_connect(), "select_all_clients", "SELECT * FROM clients");
$select_all_calls = pg_prepare(db_connect(), "select_all_calls", "SELECT * FROM calls");
$user_update = pg_prepare(db_connect(), "user_update", "UPDATE users SET LastAccess = NOW()::timestamp(0) WHERE EmailAddress = $1 ");

// finds the user that is logged in 
function user_select($email){
	$result = pg_execute(db_connect(), "user_select", array($email));
	if(pg_num_rows($result) > 0)
	{
		$user = pg_fetch_assoc($result);
		$_SESSION["userArray"] = $user;
		return $_SESSION["userArray"];
	}
	else return false;
}

//  determines the total users per page by fetching the total user and dividing the total records (users) by the limit we want
function total_user_records_per_page($page)
{
	// if its a salesperson table then
	if ($page == 1)
	{
	 $limit = MAX_PAGES;  
	 $salespeople = pg_query(db_connect(), "SELECT * FROM users WHERE type = 's'");
	 $recordss = pg_fetch_row($salespeople);	
	 $total_records = $recordss[0];
	 $total = ceil($total_records / $limit);
	 return $total;
	}
	// if its a client table then
	else if ($page == 2)
	{
	 $limit = MAX_PAGES;  
	 $clients = pg_query(db_connect(), "SELECT * FROM clients");
	 $recordss = pg_fetch_row($clients);	
	 $total_records = $recordss[0];
	 $total = ceil($total_records / $limit);
	 return $total;
	}
	// if its a calls table then
	else if ($page == 3)
	{
	 $limit = MAX_PAGES;  
	 $calls = pg_query(db_connect(), "SELECT * FROM calls");
	 $recordss = pg_fetch_row($calls);	
	 $total_records = $recordss[0];
	 $total = ceil($total_records / $limit);
	 return $total;
		
	}
	
}

// queries the data result from the database with a limit and offset depending on the table that is present
function limit_users($page)
{
	// if its a salesperson table then
	if ($page == 1)
	{
		$limit = MAX_PAGES;  
		$select_all_salespeople = pg_prepare(db_connect(), "select_all_salespeople", "SELECT * FROM users WHERE type = 's'");
		$result = pg_execute(db_connect(), $select_all_salespeople, array());	
	 
		$initial_page = ($_SESSION['page_salesperson']-1) * $limit;   
		$select_all_salespeople_limit = pg_query(db_connect(), "SELECT * FROM users WHERE type = 's' limit $limit offset $initial_page");
		return $select_all_salespeople_limit;
	
	}
	// if its a client table then
	else if ($page == 2)
	{
		$limit = MAX_PAGES;  
		$select_all_clients = pg_prepare(db_connect(), "select_all_clients", "SELECT * FROM clients");
		$result = pg_execute(db_connect(), $select_all_salespeople, array());
	 
		$initial_page = ($_SESSION['page_client']-1) * $limit;   
		$select_all_clients_limit = pg_query(db_connect(), "SELECT * FROM clients limit $limit offset $initial_page");
		return $select_all_clients_limit;
	}
	// if its a calls table then
	else if ($page == 3)
	{
		$limit = MAX_PAGES;  
		$select_all_calls = pg_prepare(db_connect(), "select_all_calls", "SELECT * FROM calls");
		$result = pg_execute(db_connect(), $select_all_salespeople, array());
	 
		$initial_page = ($_SESSION['page_call']-1) * $limit;   
		$select_all_calls_limit = pg_query(db_connect(), "SELECT * FROM calls limit $limit offset $initial_page");
		return $select_all_calls_limit;
	}
}
// authenciates the user by verifying the email and password and displays the last acessed of the account
function user_authenticate($email, $password)
{
	$result = pg_execute(db_connect(), "user_select", array($email));
	$userArray = pg_fetch_assoc($result);
	
	if (password_verify($password, $userArray["password"]))
	{
	
		$_SESSION["lastLogin"] = $userArray["lastaccess"];
		$update = pg_execute(db_connect(), "user_update", array($email));
		$log = fopen("DATE_log.txt", "a");
		$insertTxt = "Sign in success at ".date("Ymd").". User ".$userArray["emailaddress"]." sign in.\n\n";
		fwrite($log, $insertTxt);
		fclose($log);
		return $userArray;
	}
	else return false;
}

// function that fill give you an array of salespeople with their id, firstname and last name
function check_all_salespeople()
{
		$result = pg_query(db_connect(), "SELECT Id, FirstName, LastName FROM users WHERE type = 's' ORDER BY Id ASC");
		$records = pg_num_rows($result);
		$emailArray = pg_fetch_all($result);
		$_SESSION["everySalesPerson"] = $emailArray;
}

// function to check all the emails in the database for users
function check_all_user_emails()
{
	$result = pg_query(db_connect(), "SELECT * FROM users");
	$records = pg_num_rows($result);
	for($i = 0; $i < $records; $i++)
	{
		$emailArray[$i] = pg_fetch_result($result, $i,"emailaddress");
		$_SESSION["allEmails"] = $emailArray;
	}
}

// function to check all the clients email in the database for clients
function check_all_client_emails()
{
	$result = pg_query(db_connect(), "SELECT * FROM clients");
	$rows = pg_num_rows($result);
	for ($i = 0; $i< $rows; $i++)
	{
		$clientEmailArray[$i] = pg_fetch_result($result, $i,"emailaddress");
		$_SESSION["allEmails"] = $clientEmailArray;
	}
	
}

// function to check all the clients phone number in the database for clients
function check_all_cleints_phone_number()
{
	$result = pg_query(db_connect(), "SELECT * FROM clients");
	$rows = pg_num_rows($result);
	
	for ($i =0; $i< $rows; $i++)
	{
		$phoneArray[$i] = pg_fetch_result($result, $i,"number");
		$_SESSION["allPhoneNumbers"] = $phoneArray;
	}
}

// function that gets all the salespeople in the database
function salesperson_select_all($page)
{
	$statement = "select_all_salespeople";
	$result = pg_execute(db_connect(), $statement, array());
	$records = pg_num_rows($result);
	$arr = pg_fetch_all($result);
	return $arr;
}

// function to repopulate base with updated password
function update_password($newPassword, $email)
{
	$user_update_password = pg_prepare(db_connect(), "user_update_password", "UPDATE users SET password = crypt('$newPassword', gen_salt('bf')) WHERE EmailAddress = $1");
	$execute = pg_execute(db_connect(), "user_update_password", array($email));
}

function update_enable($newEnable, $email)
{
	$user_update_enable = pg_prepare(db_connect(), "user_update_enable", "UPDATE users SET enable = '$newEnable' WHERE EmailAddress = $1");
	$execute = pg_execute(db_connect(), "user_update_enable", array($email));
}

// function to insert sales person to databases
function insert_salespeople($email, $password, $first_name, $last_name)
{
	$insert = pg_query(db_connect(), "INSERT INTO users (EmailAddress, Password, FirstName, LastName, LastAccess, EnrolDate, Enable, type)
											VALUES ('$email', crypt('$password', gen_salt('bf')), '$first_name', '$last_name', NOW()::timestamp(0), NOW()::timestamp(0), true, 's')");
}

// function to insert client to database
function insert_clients($aID, $first_name, $last_name, $email, $number, $img)
{
	$imgg = './logos/'.$img;
	$insert = pg_query(db_connect(), "INSERT INTO clients (ClientID, FirstName, LastName, EmailAddress, PhoneNumber, FilePath)
											VALUES ('$aID', '$first_name', '$last_name', '$email', '$number', '$imgg')");
}

// function to insert calls to database
function insert_calls($id, $first_name, $last_name, $email, $number, $date, $time)
{
	$insert = pg_query(db_connect(), "INSERT INTO calls (SalespersonID, FirstName, LastName, EmailAddress, PhoneNumber, CallDate, CallTime)
											VALUES ('$id', '$first_name', '$last_name', '$email', '$number', '$date', '$time')");
}


?>