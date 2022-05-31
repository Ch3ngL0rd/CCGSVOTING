<?php
$ballots = admin_get_all_ballot();
?>

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
				<li class="nav-item"><a href="landing.php?page=ballotcreate<?php echo "&user_id=$user_id";?>" class="nav-link">Create Ballot</a></li>
				<li class="nav-item"><a href="landing.php?page=ballotmanageview<?php echo "&user_id=$user_id";?>" class="nav-link active">Manage Ballot</a></li>
				<li class="nav-item"><a href="#" class="nav-link">View Student</a></li>
			</ul>
		</header>
		<img src='../components/assets/photos/BGM.jpg' style="position:absolute;top:0px;left:0px;width:100vw;height:100vh;z-index:-1;">
		<br>
		<div class="container border bg-light">
		    <p class="fs-1 my-3">Ballot Management</p>
            <!-- 1. Select Ballot, Searchbar, table, -->
            <div class="input-group rounded">
                <input type="search" class="form-control rounded" placeholder="Search" aria-label="Search" oninput="search(this.value)"/>
            </div>
            <div style='display:block;overflow: auto;height:60vh'>
            <table class="table" id="ballotTable">
                <thead>
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Information</th>
                    </tr>
                </thead>
                <tbody style="overflow-y:scroll">
                    <?php
                    // For each ballot
                    foreach ($ballots as $ballot) {
                        $ballot_id = $ballot['BallotID'];
                        echo "<tr onclick=\"document.location.href='landing.php?page=ballotmanage&user_id=$user_id&ballot_id=$ballot_id'\" style='cursor:pointer' class='bg-light ballottr'>";
                        echo "<td>$ballot_id</td>";
                        echo "<td>".$ballot["Name"]."</td>";
                        echo "<td>".$ballot["Information"]."</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
            </div>
		</div>
    </div>
    <script>
        function search(input) {
            var tr = document.getElementById("ballotTable").getElementsByTagName('tr');
            var tr = Array.from(tr).slice(1);
            let filter = input.toUpperCase();
            for (i = 0; i < tr.length; i++) {
                let hidden = true;
                let name = tr[i].getElementsByTagName("td")[1];
                if (name) {
                    txtValue = name.textContent || name.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        hidden = false;
                    }
                }
                if (hidden == false) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    </script>
</body>
</html>