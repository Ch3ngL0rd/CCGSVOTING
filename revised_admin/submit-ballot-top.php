<!doctype html>
<html lang="en">
  <head>
    <meta crset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Control Panel</title>
    <!-- Bootstrap core CSS -->
    <link href="../components/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="./custom.css">
  </head>
<body>    
	<div class="container-fluid" style="padding-left:0;padding-right:0">
		<header class="py-3 mb-4 border-bottom d-flex flex-column justify-content-center bg-light">
			<div class="d-flex align-items-center mx-auto" style="height:100px">
				<img src="../components/ccgs-logo.png" class="me-4" width="50" height="90"></img>
				<span class="fs-3 fw-bold">CCGS ADMIN PREFECT</span>
			</div>
			<ul class="d-flex align-items-center justify-content-around nav nav-pills">
				<li class="nav-item"><a href="landing.php?page=ballotcreate<?php echo "&user_id=$user_id";?>" class="nav-link active">Create Ballot</a></li>
				<li class="nav-item"><a href="landing.php?page=ballotmanageview<?php echo "&user_id=$user_id";?>" class="nav-link">Manage Ballot</a></li>
				<li class="nav-item"><a href="#" class="nav-link">View Student</a></li>
			</ul>
		</header>
		<img src='../components/assets/photos/BGM.jpg' style="position:absolute;top:0px;left:0px;width:100vw;height:100vh+150px;z-index:-1;">
		<div class="container border bg-light" style="height:70vh;">
			<p class="fs-1 my-3">Ballot Creation Form</p>