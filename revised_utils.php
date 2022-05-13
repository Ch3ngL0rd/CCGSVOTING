<!-- 
Naming convention - Database
Student / Admin
Get / Set / Update / Check
All / One
What Ballot / Candidate / Voter
by - ID

Naming Convention - User
Check
Admin / Voter / Ballot / 
by - ID / Time

 -->
<?php
include "db_connection.php";

// Returns all ballots for a student given
// their house and year group
function student_get_all_ballot($house,$year) {
    global $connection;

    // We can use LIKE with house since all are distinct
    // Cannot use LIKE for year since year '2' may appear in 12
    $query = "SELECT * FROM BallotInformation 
    WHERE House LIKE '%$house%' AND Year LIKE '%$year%'";
    $result = $connection->query($query);

    if ($result->num_rows > 0) {
        // output data of each row
        return $result->fetch_all(MYSQLI_ASSOC);
    } else {
        return array();
    }
}

// Checks if a user has voted for a specific ballot
// Returns False if user hasn't voted for ballot
function student_check_one_ballotvoted_userid($ballot_id,$user_id) {
    global $connection;

    $query = "SELECT COUNT(*) FROM Voter
    WHERE BallotID = $ballot_id AND UserID = $user_id";
    $result = $connection->query($query);
    return $result->fetch_row()[0] != 0;
}

// Sorts a ballot into 3 categories
// -1 - Before voting is open 
// 0 - Students can vote
// 1 - Voting is closed and student can only see
function check_ballot_time($ballot,$current_date) {
    $start_time = strtotime($ballot["StartDate"]);
    $end_time = strtotime($ballot["EndDate"]);
    $current_time = strtotime($current_date);
    if ($current_time < $start_time) {
        // Voting is closed
        return -1;
    }
    if ($current_time < $end_time) {
        // Open to voting
        return 0;
    }
    return 1;
}

// Get Ballot Info from a ballot id
function student_get_one_ballotinfo_ballotid($ballot_id) {
    global $connection;
    $query = "SELECT * FROM BallotInformation
    WHERE BallotID = $ballot_id";
    $result = $connection->query($query);
    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    } else {
        return array();
    } 
}

function student_get_all_candidate_ballotid($ballot_id) {
    global $connection;

    $query = "SELECT * FROM Candidate 
    WHERE BallotID = $ballot_id";
    $result = $connection->query($query);
    if ($result->num_rows > 0) {
        // output data of each row
        return $result->fetch_all(MYSQLI_ASSOC);
    } else {
        return array();
    }
}

function student_submit_one_vote($ballot_id,$candidate_id,$power,$user_info,$preference) {
    global $connection;
    $userid = $user_info["UserID"];
    $house = $user_info["House"];
    $year = $user_info["Year"];
    $query = "INSERT INTO Voter
    (UserID, BallotID, Vote, Power, House, Year, Preference)
    VALUES 
    ($userid, $ballot_id, $candidate_id, $power,'$house', $year, $preference)";
    $result = $connection->query($query);
    if ($result !== TRUE) {
        echo "Error: " . $sql . "<br>" . $connection->error;
    }
}


// We must check if the votes are valid
// Differentiate student & staff if there is a year (staff do not have year from azure)
// Returns 
// 0 - Vote Passed
// 1 - Vote Failed since already voted
// 2 - Vote Failed since user house is not assigned to ballot
// 3 - Vote failed since user year is not asssigned to ballot
// 4 - Check that within time?
function student_submit_votes($votes,$ballot_id,$user_info) {
    // Check if user is assigned to ballot
    $ballot_info = student_get_one_ballotinfo_ballotid($ballot_id);
    // We check that user house is in ballot information
    $houses = explode(",",$ballot_info["House"]);
    $is_in_house = False;
    foreach ($houses as $house) {
        if ($house == $user_info["House"]) {
            $is_in_house = True;
        }
    }
    if ($is_in_house == False) {
        return 2;
    }
    // if year is -1 we dont check (it is a staff)
    // else we check that year is in 
    $years = explode(",",$ballot_info["Year"]);
    $is_in_year = False;
    foreach ($years as $year) {
        if ($year == $user_info["Year"]) {
            $is_in_year = True;
        }
    }
    if ($is_in_year == False && $user_info["Year"] != -1) {
        return 3;
    }

    // Check if user has already voted for ballot
    if (student_check_one_ballotvoted_userid($ballot_id,$user_info["UserID"]) == True) {
        return 1;
    }

    $power = 1;
    // User is a staff
    if ($year == -1) {
        $power = $ballot_info["Power"];
    }

    $local_votes = explode(",",$votes);
    for ($preference = 0 ; $preference < count($local_votes); $preference++) {
        student_submit_one_vote(
            $ballot_id,
            $local_votes[$preference],
            $power,
            $user_info,
            $preference + 1);
    }


    return 0;
}



?>