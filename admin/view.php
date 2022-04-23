<!-- 
    This page has to let ONLY admins view all the results from the ballots
    First iteration:
        Check if user is admin
        Select ballot by BallotID by a box (no search)
        Ballot information - Name,Information,Max votes, start end date, has bio
    
    Ballot stats we calculate 
        Rank the candidates by amount of votes - could be a problem if we are requesting 2000 students..?

    Export to excel:
        All information - All votes, Candidates
    

    Things to include in later iterations:
    Candidates - view candidates + ballot
    Search ballot by name / see all ballots
 -->

<?php
// Get data to pass back - user id, ballot_id, pageID
// $user_id = $_GET["user_id"]; - from page.php

// if not admin - Access denied - contact ICT for permissions

if (is_admin($user_id) == false) {
    echo "<h1>View Access Denied - Contact ICT for Permission</h1>";
    return; // exit the script 
    // (can't use exit since view.php is included in page.php (exit() would stop page as well))
}
include "view_form.php";
$ballot_information = [];
if (isset($_GET['ballot_id']) == false) {
    return;
} 
$ballot_id = $_GET['ballot_id'];
$ballot_information = get_ballot($ballot_id);
if (count($ballot_information) == 0) {
    echo "<h1>Ballot ID $ballot_id does not exist.</h1>";
    return;
}

// Get Ballot information since we know it exists
$candidates = get_candidates($ballot_id);
$votes = fetch_votes($ballot_id);
$compiled_votes = calculate_votes($votes);
$temp_candidates = [];

// Foreach candidate pushing array doubles array - create new list
foreach ($candidates as $candidate) {
    $temp_candidate = $candidate;
    if (array_key_exists($candidate[1],$compiled_votes) == true) {
        array_push($temp_candidate,$compiled_votes[$candidate[1]]);
    } else {
        array_push($temp_candidate,0);
    }

    array_push($temp_candidates,$temp_candidate);
}

$candidates = $temp_candidates;

// not sure of a better way to include data than a one-rowed table
// prefer two tables than a horizontal scrolling table

?>

<div class="row align-items-start">
    <div class="col-6">
        <?php
        echo "<h2>" . $ballot_information[0][1] . "</h2>";
        echo "<br>";
        echo "<p>" . $ballot_information[0][2] . "</p>";
        ?>
    </div>
    <div class="col-3">
        <?php
        echo "<p>Ballot ID: " . $ballot_information[0][0] . "</p>";
        echo "<p>Max Votes: " . $ballot_information[0][3] . "</p>";
        echo "<p>Ballot Owner: " . $ballot_information[0][7] . "</p>";
        ?>        
    </div>
    <div class="col-3">
        <?php
        echo "<p>Start Date: " . substr($ballot_information[0][4],0,10) . "</p>";
        echo "<p>Start Date: " . substr($ballot_information[0][5],0,10) . "</p>";
        echo "<p>Captions: " . ($ballot_information[0][6] ? 'Enabled' : 'Not Enabled') . "</p>";
        ?>        
    </div>
</div>

<table class="table table-striped table-hover">
    <caption>Candidates</caption>
    <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Name</th>
            <th scope="col">Bio</th>
            <th scope="col">Votes</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($candidates as $candidate) {
            // href='page.php?pageID=view&user_id={$user_id}
            echo "<tr>";
                echo "<th>$candidate[1]</th>";
                echo "<td>$candidate[3]</td>";
                echo "<td>$candidate[4]</td>";
                echo "<td>$candidate[6]</td>";
            echo "</tr>";
        }
        ?>
    </tbody>
</table>