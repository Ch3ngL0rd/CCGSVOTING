<!doctype html>
<html lang="en">
  <head>
    <meta crset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Control Panel</title>
    <!-- Bootstrap core CSS -->
    <link href="../components/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="./custom.css">
	<link href="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.min.css" rel="stylesheet"/>

  </head>
<body>    
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	<script src="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.jquery.min.js"></script>
	<script src="../components/bootstrap/js/bootstrap.min.js"></script>
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
		<br>
		<div class="container border bg-light">
		<p class="fs-1 my-3">Ballot Creation Form</p>
		<form action="landing.php" method="get" id='ballot'>
			<div class="form-group">
				<label for="Name">Name</label>
				<input type="text" class="form-control" id="name" name="name" placeholder="CCGS PREFECT VOTE">
			</div>
			<br>
			<div class="form-group">
				<label for="information">Information</label>
				<textarea class="form-control" id="information" name="information" placeholder="Information about the ballot" rows="3"></textarea>
			</div>

			<br>
			<div class="row">
				<div class="col-6">
					<label class="form-check-label" for="student_year">Year Groups Allowed to Vote</label>
					<select data-placeholder="Begin typing a number to filter..." multiple class="chosen-select" name="student_year[]" id="student_year" style="width:100%" form="ballot">
						<option value=""></option>
						<option>7</option>
						<option>8</option>
						<option>9</option>
						<option>10</option>
						<option>11</option>
						<option>12</option>
					</select>
				</div>
				<div class="col-6">
					<label class="form-check-label" for="student_house">House's Allowed to Vote</label>
					<select data-placeholder="Begin typing a house to filter..." multiple class="chosen-select" name="student_house[]" id="student_house" style="width:100%" form="ballot">
						<option value=""></option>
						<option value="C">Craigie</option>
						<option value="H">Hill</option>
						<option value="J">Jupp</option>
						<option value="M">Moyes</option>
						<option value="N">Noake</option>
						<option value="Q">Queenslea</option>
						<option value="R">Rosmey</option>
						<option value="W">Wolsey</option>
					</select>
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-6">
					<label class="form-check-label" for="staff_house">Staff Houses Allowed to Vote</label>
					<select data-placeholder="Begin typing a house to filter..." multiple class="chosen-select" name="staff_house[]" id="staff_house" style="width:100%" form="ballot">
						<option value=""></option>
						<option value="C">Craigie</option>
						<option value="H">Hill</option>
						<option value="J">Jupp</option>
						<option value="M">Moyes</option>
						<option value="N">Noake</option>
						<option value="Q">Queenslea</option>
						<option value="R">Rosmey</option>
						<option value="W">Wolsey</option>
					</select>
				</div>
				<div class="col-6">
					<label class="form-check-label" for="staff_department">Staff Departments Allowed to Vote</label>
					<select data-placeholder="Begin typing a department to filter..." multiple class="chosen-select" name="staff_department" id="staff_house" style="width:100%" form="ballot">
						<option value=""></option>
						<option>Residential Community (RES)</option>
						<option>Health Centre (HEA)</option>
					</select>
				</div>
			</div>
			<br>
			<div class="form-group row">
				<div class="col">
					<label for="startdate">Start Date</label>
					<br>
					<input type="date" id="startdate" name="start_date" >
				</div>
				<div class="col">
					<label for="starttime">Start Time</label>
					<br>
					<input type="time" id="starttime" name="start_time">
				</div>
				<div class="col">
					<label for="enddate">End Date</label>
					<br>
					<input type="date" id="enddate" name="end_date">
				</div>
				<div class="col">
					<label for="endtime">End Time</label>
					<br>
					<input type="time" id="endtime" name="end_time">
				</div>
			</div>
			<br>
			<div class="form-group row">
				<div class="col">
					<label for="power">Relative Staff Power</label>
					<input class="form-control" type="number" id="power" name="power">
				</div>
				<div class="col">
					<label for="max_votes">Maximum Amount of Votes</label>
					<input class="form-control" type="number" id="max_votes" name="max_votes">
				</div>
			</div>
			<br>
			<div class="form-group row">
				<div class="col">
					<div class="form-check">
						<label class="form-check-label" for="bio">Enable Candidate Caption</label>
						<input type="checkbox" class="form-check-input" id="bio" name="bio">
					</div>
					<div class="form-check">
						<label class="form-check-label" for="randomised">Randomised Voting Screen</label>
						<input type="checkbox" class="form-check-input" id="randomised" name="randomised">
					</div>
				</div>
				<div class="col">
					<div class="form-group">
						<label for="edit_ballot_id">Ballot ID - Change Created Ballot</label>
						<input type="number" class="form-control" id="edit_ballot_id" name="edit_ballot_id" placeholder="Input Ballot ID to change Ballot">
					</div>
					<br>
				</div>
			</div> 



		
		
			<button type="submit" class="btn btn-primary my-3">Submit</button>
			<input hidden=true name='page' value="ballotsubmit">
			<input hidden=true name='user_id' value="<?php echo $user_id;?>">
		</form>
		</div>
    </div>
</body>
<script>$(".chosen-select").chosen()</script>
</html>