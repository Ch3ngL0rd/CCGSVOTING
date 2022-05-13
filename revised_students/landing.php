<!-- 
    Add colours - Green , Red
    Add Voting functionality
 -->
<?php
include '../revised_utils.php';
include '../revised_userutils.php';
date_default_timezone_set('Australia/Perth');

// Set all variables
// Staff do not have year
if (isset($_GET["year"])) {
    $year = $_GET["year"];
} else {
    $year = '';
}
if (isset($_GET["ballot_id"])) {
    $ballot_id = $_GET["ballot_id"];
} else {
    $ballot_id = -1;
}
$house = $_GET["house"];
$user_id = $_GET["user_id"];
$user_info = array(
    "UserID" => $user_id,
    "Year" => $year,
    "House" => $house);

$current_date = date("Y-m-d h:i:s");
$open_time_ballots = [];
$availiable_ballots = [];
$closed_ballots = [];

// Get all ballots given students house + year
$data = student_get_all_ballot($house,$year);

$vote_state = -1;

if (isset($_GET["votes"]) && $ballot_id != -1) {
    if ($_GET["votes"] == '') {
        echo "No votes submitted<br>";
    } else {
        // First check if the vote is valid
        $vote_state = student_submit_votes($_GET["votes"],$ballot_id,$user_info);
    }
}

// Sort ballots given their time
foreach ($data as $ballot) {
    switch (check_ballot_time($ballot,$current_date)) {
        case -1:
            // We ignore since the user doesn't have to see ballots before open - can change
            break;
        case 0:
            $ballot["Time"] = True;
            break;
        case 1:
            $ballot["Time"] = False;
            break;
    }
    if (student_check_one_ballotvoted_userid($ballot["BallotID"],$user_id) == False) {
        $ballot["Voted"] = False;
    } else {
        $ballot["Voted"] = True;
    }

    $years = explode(",",$ballot["Year"]);
    $is_in_year = False;
    foreach ($years as $year) {
        if ($year == $user_info["Year"]) {
            $is_in_year = True;
        }
    }

    if ($is_in_year == True) {
        if ($ballot["Voted"] == False && $ballot["Time"] == True) {
            array_push($availiable_ballots,$ballot);
        } else {
            array_push($closed_ballots,$ballot);
        }
    }

}

// We have sorted ballots into available (open + unvoted) $availiable_ballots
// and unavailable (closed or already voted) $closed_ballots

?>

<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="../components/bootstrap.min.css">
        <link rel="stylesheet" href="./custom.css">

        <title>CCGS VOTE</title>
    </head>
    <body>
        <div class="container-fluid">
            <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom">
                <div href="/" class="d-flex align-items-center me-md-auto text-dark text-decoration-none">
                  <img src="../components/ccgs-logo.png" class="me-4" width="50" height="90"></img>
                  <span class="fs-3 fw-bold">Christ Church Grammar School Prefect Voting </span>
                </div>
            </header>
            <?php
            switch($vote_state) {
                case -1:
                    break;
                case 0:
                    // Successful vote
                    include "successfulvote.html";
                    break;
                case 1:
                    // User is voting for ballot already voted for
                    include "secondvote.html";
                    break;
                case 2:
                    include "unassignedvote.html";
                    break;
            }
            ?>

            <div class="card-deck d-flex justify-content-start flex-wrap">
                <?php
                foreach ($availiable_ballots as $ballot) {
                    student_create_ballot($ballot,$user_info);
                }
                ?>
            </div>
            
            <div class="card-deck d-flex justify-content-start flex-wrap">
                <?php
                foreach ($closed_ballots as $ballot) {
                    student_create_ballot($ballot,$user_info);
                }
                ?>
            </div>
        </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="../components/bootstrap.min.js"></script>
    </body>
</html>