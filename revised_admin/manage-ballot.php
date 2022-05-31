<?php
// There are alot of things going on in this page
// We have 

$ballot_id = (isset($_GET["ballot_id"])) ? $_GET["ballot_id"] : -1;
$user_id = (isset($_GET['user_id'])) ? $_GET['user_id'] : '-1';

// Upload image
if(isset($_POST["submit"])) {
	$photo_upload_result = admin_upload_photo();
} else {
	$photo_upload_result = [];
}

// Update first
if (isset($_GET["type"])) {
	// Don't have any data attached
	$type = $_GET["type"];
	if ($type == 'export_candidate') {
		admin_export_voters($ballot_id);
		return;
	}

	$data = $_GET['data'];
	if ($type == 'upload') {
		$students = explode("\n", $data);
		foreach ($students as $student) {
			$split_student = explode(",",$student,2);
			$student_id = $split_student[0];
			$caption = (count($split_student) == 2) ? $split_student[1] : '';
			admin_update_one_candidate_caption($ballot_id,$student_id,$caption);
		}
		$message = "Inserted new candidates + captions";
	} else if ($type == 'remove') {
		$students = explode(",", $data);
		foreach ($students as $student) {
			admin_remove_candidate($ballot_id,$student);
		}
		$message = "Deleted candidates";
	} else if ($type == 'change-image') {
		// Data is the directory of our new image
		// echo "$data<br>";
		admin_change_banner($ballot_id,$data);
	}
}
// Then fetch
$ballot = student_get_one_ballotinfo_ballotid($ballot_id);
$candidates = student_get_all_candidate_ballotid($ballot_id);

// Fetch images
$dirname = "../components/uploaded/";
$images = array_merge(array_merge(glob($dirname."*.png"),glob($dirname."*.jpg")),glob($dirname."*.jpeg"));
?>

<!doctype html>
<html lang="en">
  <head>
    <meta crset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Control Panel</title>
    <!-- Bootstrap core CSS -->
    <link href="../components/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script src="../components/bootstrap/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="./custom.css">

  </head>
<body>    
	<div class="container-fluid" style="padding-left:0;padding-right:0">
		<header class="py-3 border-bottom d-flex flex-column justify-content-center bg-light">
			<div class="d-flex align-items-center mx-auto" style="height:100px">
				<img src="../components/ccgs-logo.png" class="me-4" width="50" height="90"></img>
				<span class="fs-3 fw-bold">CCGS ADMIN PREFECT</span>
			</div>
			<ul class="d-flex align-items-center justify-content-around nav nav-pills">
				<li class="nav-item"><a href="landing.php?page=ballotcreate<?php echo "&user_id=$user_id";?>" class="nav-link">Create Ballot</a></li>
				<li class="nav-item"><a href="landing.php?page=ballotmanageview<?php echo "&user_id=$user_id";?>" class="nav-link active">Manage Ballot</a></li>
				<li class="nav-item"><a href="#" class="nav-link">View Student</a></li>
			</ul>
		</header>
		<?php
		if (isset($message)) {
			echo '<div class="alert alert-success alert-dismissible fade show text-center my-3" style="width:25vw;margin:auto" role="alert">';
			echo '<strong>Database Sucessfully Updated! :)</strong><br>';
			echo "<strong>$message</strong>";
			echo '<button type="button" class="btn-close" data-dismiss="alert"></button>';
			echo '</div>';
		}
		?>
		<img src='../components/assets/photos/BGM.jpg' style="position:absolute;top:0px;left:0px;width:100vw;height:100vh+150px;z-index:-1;">
		<div class="container border bg-light py-3 my-3" style="min-height:300px">

		<div class="text-center">
		<?php
			echo "<img class='img-thumbnail mx-3 my-3 adminbanner' src='".htmlspecialchars($ballot["Photo"])."'>";
		?>
		</div>

		<div class="row align-items-start text-break">
			<div class="col-4">
				<?php
				echo "<p class='fs-1'>" . $ballot["Name"] . "</p>";
				echo "<p class='fs-4'>" . $ballot["Information"] . "</p>";
				?>
			</div>
			<div class="col-4">
				<?php
				echo "<p class='fs-4'>Staff Houses: " . $ballot["StaffHouse"] . "</p>";
				echo "<p class='fs-4'>Student Houses: " . $ballot["House"] . "</p>";
				echo "<p class='fs-4'>Year Groups: " . $ballot["Year"] . "</p>";
				?>
			</div>
			<div class="col-2">
				<?php
				echo "<p class='fs-6'>Ballot ID: " . $ballot["BallotID"] . "</p>";
				echo "<p class='fs-6'>Max Votes: " . $ballot["MaxVotes"] . "</p>";
				echo "<p class='fs-6'>Power: " . $ballot["Power"] . "</p>";
				echo "<p class='fs-6'>Randomised User: " . (($ballot["Randomised"] == 0) ? "True" : "False") . "</p>";
				?>        
			</div>
			<div class="col-2">
				<?php
				echo "<p class='fs-6'>Start Date: " . substr($ballot["StartDate"],0,10) . "</p>";
				echo "<p class='fs-6'>Start Date: " . substr($ballot["EndDate"],0,10)  . "</p>";
				echo "<p class='fs-6'>Captions: " . ($ballot["HasBio"] ? 'Enabled' : 'Not Enabled') . "</p>";
				?>
			</div>
		</div>

		<div class="row align-items-start">
			<div class='col' id='candidates_table'>
				<table class="table table-striped table-hover">
					<caption>Candidates</caption>
					<thead>
						<tr>
							<th scope="col">ID</th>
							<th scope="col">Name</th>
							<th scope="col">Caption</th>
						</tr>
					</thead>
					<tbody>
						<?php
						foreach ($candidates as $candidate) {
							// href='page.php?pageID=view&user_id={$user_id}
							echo "<tr>";
								echo "<td>".$candidate['StudentID']."</td>";
								echo "<td>".$candidate['Name']."</td>";
								echo "<td>".$candidate['Bio']."</td>";
							echo "</tr>";
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
		<div class="row align-items-start">
		<div class="col">
				<form action="landing.php" method="get" id='edit_candidate_form' class='mt-3'>
					<label for="edit_candidate_input">Add Candidates</label>
					<textarea class="form-control" name="data" form="edit_candidate_form" 
					placeholder="PLEASE REMIND ME TO TALK ABOUT THIS! - SUBMITTING CANDIDATE FORM
					1022481,I am going to be the best candidate!
					1035372,No, I am the best candidate
					1003422,Can't wait for you to vote for me!
					1023722,Have not seen this candidate yet :)" rows="6"></textarea>

					<button type="submit" class="btn btn-primary my-3">Submit</button>
					<input hidden=true name='page' value="ballotmanage">
					<input hidden=true name='type' value="upload">
					<input hidden=true name='user_id' value="<?php echo $user_id;?>">
					<input hidden=true name='ballot_id' value="<?php echo $ballot_id;?>">
				</form>
			</div>

			<div class="col">
				<form action="landing.php" method="get" id='remove_candidate_form' class='mt-3'>
					<label for="remove_candidate_input">Remove Candidates</label>
					<textarea class="form-control" name="data" form="remove_candidate_form" placeholder="1022481,1035372,1003422,1023722..." rows="6"></textarea>
					<button type="submit" class="btn btn-primary my-3">Submit</button>

					<input hidden=true name='page' value="ballotmanage">
					<input hidden=true name='type' value="remove">
					<input hidden=true name='user_id' value="<?php echo $user_id;?>">
					<input hidden=true name='ballot_id' value="<?php echo $ballot_id;?>">
				</form>
			</div>
		</div>
		<div class="row align-items-start">
			<div class="col">
				<form action="landing.php" method="get">
					<button type="submit" class="btn btn-primary">Export to CSV</button>
					<input hidden=true name='page' value="ballotmanage">
					<input hidden=true name='type' value="export_candidate">
					<input hidden=true name='user_id' value="<?php echo $user_id;?>">
					<input hidden=true name='ballot_id' value="<?php echo $ballot_id;?>">
				</form>
			</div>
			<div class="col">
				<a class="btn btn-primary" data-toggle="collapse" href="#photos" role="button">Show Available Images</a>
			</div>
			<div class="col">
				<!-- Funky due to POST & GET -->
				<form action="
				<?php echo "landing.php?page=ballotmanage&user_id=$user_id&ballot_id=$ballot_id";?> 
				" method="post" enctype="multipart/form-data">
					<input type="file" name="fileToUpload" id="fileToUpload">
					<br><br>
					<input class="btn btn-secondary" type="submit" value="Upload Image" name="submit">
				</form>
				<?php
				foreach ($photo_upload_result as $result) {
					echo "<p class='fs-5'>$result</p><br>";
				}
				?>
			</div>
		</div>
		<br>
		<div class="form-group row">
			<div class="collapse" id="photos">
				<p class='fs-3'>Banners appear on student page as shown below (same ratio)</p>
				<p class='fs-4'>Click to change banner</p>
				<div class="d-flex align-content-start flex-wrap">
				<form action="landing.php" method="get">
					<input hidden=true name='page' value="ballotmanage">
					<input hidden=true name='type' value="change-image">
					<input hidden=true name='user_id' value="<?php echo $user_id;?>">
					<input hidden=true name='ballot_id' value="<?php echo $ballot_id;?>">
					<?php
					foreach($images as $image) {
						echo "<input class='img-thumbnail mx-3 my-3 adminballotimage' type='image' name='data' value='".htmlspecialchars($image)."' src='".htmlspecialchars($image)."' />";
					}
					?>
					</form>
				</div>
			</div>
		</div>

		</div>
    </div>
</body>
</html>

