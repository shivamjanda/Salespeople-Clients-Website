<!doctype html>
<html lang="en">
  <head>
 
 <?php 
/*
SHIVAM JANDA
2022-12-07
WEBD 3201
*/
		session_start();
		ob_start();
		require("./includes/constants.php");
		require("./includes/db.php");
		require("./includes/functions.php");
		
		$inputEmail = "";
		$inputPassword = "";
		$signInOrOut = " In";
		$url = "sign-in.php";
		$index = "index.php";
		$dashboard = "";
		$company = "The Company";
		$clientT ="";
		$salespeopleT ="";
		$callsT ="";
		$changePasswordT = "";
		$resetT = "";
		
		// if the user is signed in 
		if (isset($_SESSION["isVerified"])){
			if ($_SESSION["isVerified"]){
				$signInOrOut = " Out";
				$url = "logout.php";
				$index = "index.php";
				$company = "Hi, ".$_SESSION["userArray"]["firstname"];
				
				// show the dashboard tab and able to navigate
				$dashboard = "<li class=\"nav-item\">
                <a class=\"nav-link active\" href=\"dashboard.php\">
                    <span data-feather=\"home\"></span>
                    Dashboard <span class=\"sr-only\">(current)</span>
                </a>
                </li>";
				
				// show the change password tab and able to navigate
				$changePasswordT = "<li class=\"nav-item\">
					 <a class=\"nav-link\" href=\"change-password.php\">
						 <span data-feather=\"file\"></span>
						 Change Password
					 </a>
					 </li>";
				
				// show the reset tab and able to navigate
				$resetT = "<li class=\"nav-item\">
					 <a class=\"nav-link\" href=\"reset.php\">
						 <span data-feather=\"file\"></span>
						 Reset
					 </a>
					 </li>";
					
				// if the user is a sales person or an admin 
				if ($_SESSION["userArray"]["type"] == "a" || $_SESSION["userArray"]["type"] == "s")
				{
					// show the clients tab and able to navigate
					$clientT = "<li class=\"nav-item\">
						<a class=\"nav-link\" href=\"clients.php\">
							<span data-feather=\"file\"></span>
							Clients
						</a>
						</li>";
				}
				
				// if the user is a sales person
				if ($_SESSION["userArray"]["type"] == "s")
				{
					// show the calls tab and able to navigate
					$callsT = "<li class=\"nav-item\">
					<a class=\"nav-link\" href=\"calls.php\">
						<span data-feather=\"file\"></span>
						Calls
					</a>
					</li>";
				}
				
				// if the user is an admin
				if ($_SESSION["userArray"]["type"] == "a")
				{
					// show the salespeople tab and able to navigate
					$salespeopleT = "<li class=\"nav-item\">
							<a class=\"nav-link\" href=\"salespeople.php\">
								<span data-feather=\"file\"></span>
								Salespeople
							</a>
							</li>";
				}
						
				}			
		}
		else
		{
			// otherwise the user is not signed in 
			$_SESSION["isVerified"] = false;
		}
							
	
?>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/docs/4.0/assets/img/favicons/favicon.ico">

    <title><?php echo $title; ?></title>
	
	<!-- Java script for datatable -->
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
	<script src="http://cdn.datatables.net/1.10.2/js/jquery.dataTables.min.js"></script>
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
	<script src="http://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css"></script>
	<!--<script src="http//cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>-->
    <!-- Bootstrap core CSS -->
    <link href="./css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="http://cdn.datatables.net/1.10.2/css/jquery.dataTables.min.css">

    <!-- Custom styles for this template -->
    <link href="./css/styles.css" rel="stylesheet">
	
	
	
  </head>
  <body>
    <nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0">
        <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#"><?php echo $company;?></a>
        <ul class="navbar-nav px-3">
        <li class="nav-item text-nowrap">
            <a class="nav-link" href="<?php echo $url; ?>">Sign<?php echo $signInOrOut;?></a>
        </li>
        </ul>
    </nav>
    <div class="container-fluid">
      <div class="row">
        
        <nav class="col-md-2 d-none d-md-block bg-light sidebar">
            <div class="sidebar-sticky">
            <ul class="nav flex-column">
			<li class="nav-item">
                <a class="nav-link" href="index.php">
                    <span data-feather="file"></span>
                    Home
                </a>
                </li>
				<?php
				// display the tabs
				echo $dashboard;
				echo $clientT; 
				echo $callsT;
				echo $salespeopleT;
				echo $changePasswordT;
				echo $resetT;
				?>
            </ul>
            </div>
        </nav>

        <main class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
          <div class="d-block">