<!doctype html>
<html lang="en">
  <head>
    <meta crset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Control Panel</title>
    <!-- Bootstrap core CSS -->
    <link href="../components/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link href="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.min.css" rel="stylesheet"/>

  </head>
<body>    
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	<script src="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.jquery.min.js"></script>
	<div class="container-fluid" style="padding-left:0;padding-right:0">
		<header class="py-3 mb-4 border-bottom d-flex flex-column justify-content-center bg-light">
			<div class="d-flex align-items-center mx-auto" style="height:100px">
				<img src="../components/ccgs-logo.png" class="me-4" width="50" height="90"></img>
				<span class="fs-3 fw-bold">CCGS ADMIN PREFECT</span>
			</div>
			<ul class="d-flex align-items-center justify-content-around nav nav-pills">
				<li class="nav-item"><a href="#" class="nav-link active">Create Ballot</a></li>
				<li class="nav-item"><a href="#" class="nav-link">Manage Ballot</a></li>
				<li class="nav-item"><a href="#" class="nav-link">View Student</a></li>
			</ul>
		</header>
		<div class="container border">
		<form>
			<div class="form-group">
				<label for="Name">Name</label>
				<input type="text" class="form-control" id="name" name="name" placeholder="CCGS PREFECT VOTE">
			</div>
			<br>
			<div class="form-group">
				<label for="Information">Information</label>
				<textarea class="form-control" id="name" name="name" placeholder="Information about the ballot" rows="3"></textarea>
			</div>
			<br>
			<div class="form-group row">
				<div class="col">
					<label for="startdate">Start Date</label>
					<br>
					<input type="date" id="startdate" name="start_date" value="2022-05-16">
				</div>
				<div class="col">
					<label for="starttime">Start Time</label>
					<br>
					<input type="time" id="starttime" name="start_time">
				</div>
				<div class="col">
					<label for="enddate">End Date</label>
					<br>
					<input type="date" id="enddate" name="end_date" value="2022-05-16">
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
						<input type="checkbox" class="form-check-input" id="randomised" name="randomsied">
					</div>
				</div>
				<div class="col">
					<div class="form-group">
							<label for="exampleFormControlFile1">Example file input</label>
							<br>
							<input type="file" class="form-control-file" id="exampleFormControlFile1">
						</div>
				</div>
			</div> 


			<br>
			<div class="row">
				<div class="col-6">
					<label class="form-check-label" for="student_year">Year Groups Allowed to Vote</label>
					<select data-placeholder="Begin typing a number to filter..." multiple class="chosen-select" name="student_year" id="student_year" style="width:100%">
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
					<select data-placeholder="Begin typing a house to filter..." multiple class="chosen-select" name="student_house" id="student_house" style="width:100%">
						<option value=""></option>
						<option>Craigie</option>
						<option>Hill</option>
						<option>Jupp</option>
						<option>Moyes</option>
						<option>Noake</option>
						<option>Queenslea</option>
						<option>Rosmey</option>
						<option>Wolsey</option>
					</select>
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-6">
					<label class="form-check-label" for="staff_house">Staff Houses Allowed to Vote</label>
					<select data-placeholder="Begin typing a house to filter..." multiple class="chosen-select" name="staff_house" id="staff_house" style="width:100%">
						<option value=""></option>
						<option>Craigie</option>
						<option>Hill</option>
						<option>Jupp</option>
						<option>Moyes</option>
						<option>Noake</option>
						<option>Queenslea</option>
						<option>Rosmey</option>
						<option>Wolsey</option>
					</select>
				</div>
				<div class="col-6">
					<label class="form-check-label" for="staff_department">Staff Departments Allowed to Vote</label>
					<select data-placeholder="Begin typing a department to filter..." multiple class="chosen-select" name="staff_department" id="staff_house" style="width:100%">
						<option value=""></option>
						<option>Residential Community (RES)</option>
						<option>Health Centre (HEA)</option>
					</select>
				</div>
			</div>
			<br>



		</form>
		</div>
    </div>
</body>
<script>$(".chosen-select").chosen()</script>
</html>