<!-- 
    Progress Bar
    Javascript - Click candidate and have them add
    Change into cards

 -->

<?php
include '../revised_utils.php';
include '../revised_userutils.php';
$house = $_GET["house"];
$year = $_GET["year"];
$user_id = $_GET["user_id"];
$user_info = array(
    "UserID" => $user_id,
    "Year" => $year,
    "House" => $house);
$ballot_id = $_GET["ballot_id"];

// get list of candidates
$candidate_info = student_get_all_candidate_ballotid($ballot_id);
$ballot_info = student_get_one_ballotinfo_ballotid($ballot_id);

// print_r($candidate_info); echo "<br>";
// print_r($ballot_info); echo "<br>";

if ($ballot_info['Randomised'] == 1) {
    shuffle($candidate_info);
}

?>

<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="../components/bootstrap.min.css">
        <link rel="stylesheet" href="custom.css">
        <title>CCGS VOTE</title>
    </head>
    <body>
        <!-- <div class="sticky-top">
            <div class="alert alert-primary text-center student-alert" style="display:" id='alert'>
                You may only vote for <?php echo $ballot_info["MaxVotes"];?> candidates. Reset votes to vote for the candidate.
            </div>
        </div> -->
        <div class="container-fluid">
            <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom">
                <div href="/" class="d-flex align-items-center me-md-auto text-dark text-decoration-none">
                  <img src="../components/ccgs-logo.png" class="me-4" width="50" height="90"></img>
                  <span class="fs-3 fw-bold">Christ Church Grammar School Prefect Voting </span>
                </div>
            </header>

            <h1 class="display-1 text-center">
                <?php
                echo $ballot_info["Name"];
                ?>
            </h1>
            <p class="h2 text-center">
                <?php
                echo $ballot_info["Information"];
                ?>
            </p>

            <div class="row align-items-start">
                <div class="col-9">
                    <div class="input-group rounded">
                        <input type="search" class="form-control rounded" placeholder="Search" aria-label="Search" oninput="search(this.value)"/>
                    </div>
                    <div class="card-deck d-flex justify-content-around flex-wrap">
                        <?php
                        $index = 0;
                        foreach ($candidate_info as $candidate) {
                            student_create_candidate($candidate,$index);
                            $index += 1;
                        }
                        ?>
                    </div>
                </div>

                <div class="col-3 sticky-top">
                    <br>
                    <table class="table" id="voterTable">
                    <thead>
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    </table>
                    <div class="d-flex justify-content-around" style="position:relative;top:30px">
                        <button type="button" class="btn btn-light student-button" data-toggle="modal" data-target="#confirm-vote" onclick="updateconfirmation()">Submit</button>
                        <button type="button" class="btn btn-light student-button" onclick="reset_votes()">Reset</button>
                    </div>
                </div>
            </div>
            
            <div class="modal fade" id="confirm-vote">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Vote Confirmation</h5>
                        </div>
                        <div class="modal-body">
                            <p>Confirm your Preferences</p>
                            <ol id="preferences">

                            </ol>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Go Back</button>
                            <form action="landing.php" method="get">
                                <input hidden=true name="votes" id='votes'>
                                <?php
                                // Pass values back to form
                                echo "<input hidden=true name='house' value=$house>";
                                echo "<input hidden=true name='year' value=$year>";
                                echo "<input hidden=true name='user_id' value=$user_id>";
                                echo "<input hidden=true name='ballot_id' value=$ballot_id>";
                                ?>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        <script>
            var votes = [];
            var max_votes = <?php echo $ballot_info["MaxVotes"];?>;
            var num_candidates = <?php echo count($candidate_info);?>;
            var table = document.getElementById("voterTable").getElementsByTagName('tbody')[0];

            for (let i = 1; i <= max_votes; i++) {
                let row = table.insertRow(-1);
                let preference = table.rows.length;
                let cell1 = row.insertCell(0);
                let cell2 = row.insertCell(1);
                cell1.outerHTML = `<th>${preference}</th>`;
                cell2.outerHTML = `<td id='preference${i}'></td>`;
            }

            function add_vote(name,id,index) {
                // Alert
                if (votes.length >= max_votes) {
                    return;
                }

                // Cannot revote for same candidate
                for (let i = 0; i < votes.length; i++) {
                    if (votes[i].id == id) {
                        return;
                    }
                }

                votes.push({'id':id,'name':name});
                let cell = document.getElementById(`preference${votes.length}`)
                cell.innerHTML = name;
                let candidate_tick = document.getElementById(`candidatetick${index}`);
                let candidate_card = document.getElementById(`candidatecard${index}`);
                candidate_tick.style.visibility = 'visible';
                // candidate_card.style.pointer_events = 'none';   
                candidate_card.style.pointerEvents = 'none';
            }

            function reset_votes() {
                for (let i = 1; i <= max_votes; i++) {
                    let cell = document.getElementById(`preference${i}`)
                    cell.innerHTML = '';
                }
                for (let i = 0; i < num_candidates; i++) {
                    let candidate_tick = document.getElementById(`candidatetick${i}`);
                    let candidate_card = document.getElementById(`candidatecard${i}`);
                    candidate_tick.style.visibility = 'hidden';
                    // candidate_card.style.pointer_events = 'none';   
                    candidate_card.style.pointerEvents = 'all';
                }
                votes = [];
            }

            function search(value) {
                console.log(value);
                if (value == '') {
                    for (let i = 0; i < num_candidates; i++) {
                        let candidate_card = document.getElementById(`candidatecard${i}`);
                        candidate_card.style.display = 'initial';
                    }
                    return;
                }
                for (let i = 0; i < num_candidates; i++) {
                    let candidate_card = document.getElementById(`candidatecard${i}`);
                    let targetDiv = document.getElementById(`candidatecard${i}`).getElementsByClassName("card-title")[0];
                    let names = targetDiv.innerHTML.split(" ").map(name => name.toLowerCase());
                    let inputs = value.split(" ").filter(input => input != '').map(input => input.toLowerCase());

                    let contains = false;
                    names.forEach(name => {
                        inputs.forEach(input => {
                            if (name.includes(input) && name[0] === input[0]) {
                            contains = true;
                        }
                        })
                    })
                    if (contains) {
                        candidate_card.style.display = 'initial';
                    } else {
                        candidate_card.style.display = 'none';
                    }
                }
            }

            function updateconfirmation() {
                // Update the list
                let ol = document.getElementById("preferences");
                ol.innerHTML = '';
                for (let i = 0; i < votes.length; i++) {
                    let li = document.createElement("li");
                    li.appendChild(document.createTextNode(votes[i]['name']));
                    ol.appendChild(li);
                }
                // Show that they are not voting for the max if they only have 1/4 selected
                for (let i = votes.length; i < max_votes; i++) {
                    let li = document.createElement("li");
                    ol.appendChild(li);
                }
                // Update our form to pass variables back
                let votes_input = document.getElementById("votes");
                // Just pass back the ids
                votes_input.value = votes.map(x => x['id']).toString();
                console.log('votes are');
                console.log(votes.map(x => x['id']).toString());
            }
        </script>

        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="../components/bootstrap.min.js"></script>
    </body>
</html>