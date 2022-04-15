<?php
include "db_connection.php";
// Create a ballot
// Name: String, Information: String, Max Votes: String, Start Date: String, End Date : String, Has_Bio : String 
function create_ballot($ballot_id,$name,$information,$max_votes,$start_date,$end_date,$has_bio,$user_id) {
    return "INSERT INTO BallotInformation (BallotID,Name,Information,MaxVotes,StartDate,EndDate,HasBio,CreatorID)
    VALUES (".$ballot_id.",'".$name."','".$information."',".$max_votes.",CAST('".$start_date."' AS DATE),CAST('".$end_date."' AS DATE),".$has_bio.",".$user_id.")";
}

// Insert a candidate into a ballot
// No Photo included
function insert_candidate($student_id,$ballot_id,$name,$bio) {
    return "INSERT INTO Candidate (StudentID,BallotID,Name,Bio) 
    VALUES ($student_id,$ballot_id,'$name',$bio)";
}

// Fetch all ballots given the student_id
function fetch_ballot($connection,$student_id) {
    $query = "SELECT * 
            FROM Voter
            WHERE StudentID='$student_id'";
    if ($result = $connection->query($query)) {
        echo "successful!";
        echo "returned rows are: " .  $result->num_rows;
    }
}

function insert_voter($user_id,$ballot_id,$power) {
    return "INSERT INTO VOTER (StudentID, BallotID,Power,Vote)
    VALUES ($user_id,$ballot_id,$power,null)";
}

// Vote is an array of their votes in order
function update_vote($ballot_id, $student_id, $vote) {
    global $connection;
    $vote_str = implode(",",$vote);
    $query = "UPDATE VOTER SET Vote = '$vote_str'
        WHERE BallotID = $ballot_id AND StudentID = $student_id";
    if ($result = $connection->query($query) === TRUE) {
        echo "Successful Vote!" . "<br>";
    } else {
        echo "Error: " . $sql . "<br>" . $connection->error;
    }
}

// Gets highest ballot id
function get_highest_ballot() {
    return "SELECT MAX(BallotID) FROM BallotInformation";
}

function get_all_ballots($student_id) {
    global $connection;
    // fetches all ballots from 
    $query = "SELECT * FROM Voter WHERE StudentID=$student_id";
    if ($result = $connection->query($query)) {
        return $result->fetch_all();
    }
    return [];
}

// Given array of ballot_id, fetch information
function get_ballot_information($ballot_id_array) {
    global $connection;
    $str_id_representation = implode(',',$ballot_id_array);
    $query = "SELECT * FROM BallotInformation WHERE BallotID in ($str_id_representation)";
    if ($result = $connection->query($query)) {
        return $result->fetch_all();
    }
    return [];
}

// Given a singular ballot_id, fetch info
function get_ballot($ballot_id) {
    global $connection;
    $query = "SELECT * FROM BallotInformation WHERE BallotID = $ballot_id";
    if ($result = $connection->query($query)) {
        return $result->fetch_all();
    }
    return [];
}


function get_candidates($ballot_id) {
    global $connection;
    $query = "SELECT * FROM Candidate WHERE BallotID = $ballot_id";
    if ($result = $connection->query($query)) {
        return $result->fetch_all();
    }
    return [];
}

function change_candidate($candidate_id,$bio) {
    global $connection;
    $query = "UPDATE CANDIDATE SET Bio = '$bio' WHERE StudentID = $candidate_id";
    if ($result = $connection->query($query) === TRUE) {

    } else {
        echo "Error: " . $sql . "<br>" . $connection->error;
    }
}

// pass in row from voter_information
function has_voted($voter_information) {
    if (gettype($voter_information[3]) != "NULL") {
        return true;
    }
    return false;
}

// Talks to Synergetic to fetch a students name and photo from a student_id
function fetch_student($student_id) {
    return "Zac";
}

function fetch_ballot_manage($user_id) {
    global $connection;
    $query = "SELECT * FROM BallotInformation WHERE CreatorID = $user_id";
    if ($result = $connection->query($query)) {
        return $result->fetch_all();
    }
    return [];
}


// we need to have a function that returns a list of ids to 

// returns a dummy array of students
function dummy_students() {
    return array(1011927, 1091415, 1083135, 1065716, 1018470, 1093068, 1041490, 1033111, 1041545, 1077957);
}

function dummy_staff() {
    return array(18781, 13881, 11751, 15084, 13385, 15640, 18304, 13531, 12740, 13615);
}

// pass in array from create ballot
// we are fomratting a date into a actual date for mysql
function parse_create_ballot($array) {
    global $connection;
    $failed = false;
    // Checks for all forms filled out
    if ($array['name'] == '' || $array['information'] == '' || $array['max_votes'] == '' || $array['start_date'] == '' || 
    $array['end_date'] == '' || $array['has_bio'] == '' || $array['user_id'] == '' ||
    $array['students'] == "Select Students To Vote" || $array['staff'] == "Select Staff To Vote" ||
    $array['voting_power'] == '' || $array['candidates'] == '') {
        echo "Please fill out all forms.";
        return false;
    }

    // Individual checks to ensure that user entered into correctly
    $regex = "@[0-9]{4}\/[0-9]{2}\/[0-9]{2}@";
    if (preg_match($regex,$array['start_date']) == false || preg_match($regex,$array['end_date']) == false) {
        echo "Please format date correctly.";
        $failed = true;
    }

    if (strlen($array['name']) > 50) {
        echo "Name is too long. Please shorten.";
        $failed = true;
    }
    if (strlen($array['information']) > 150) {
        echo "Description is too long. Please shorten.";
        $failed = true;
    }
    
    if ($failed == true) {
        return false;
    }

    $candidate_list = explode(",",$array['candidates']);
    $candidate_names = array_map('fetch_student',$candidate_list);

    // Function to get students_ids from syngergetic given house name / ...
    $students = dummy_students();
    // Function to get staff from syngergetic given house name / ...
    $staff = dummy_staff();

    $query = get_highest_ballot();
    if ($result = $connection->query($query)) {
        $highest_ballot =  $result->fetch_all()[0][0];
    } else {
        echo "Error: " . $sql . "<br>" . $connection->error;
    }


    $query = create_ballot($highest_ballot+1,$array['name'],$array['information'],$array['max_votes'],$array['start_date'],$array['end_date'],$array['has_bio'],$array['user_id']);
    if ($connection->query($query) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $connection->error;
    }
    
    // Insert student & staff into voting table
    foreach ($students as $individual) {
        $query = insert_voter($individual,$highest_ballot+1,1);
        if ($connection->query($query) !== TRUE) {
            echo "Error: " . $sql . "<br>" . $connection->error;
        }
    }

    foreach ($staff as $individual) {
        $query = insert_voter($individual,$highest_ballot,$array['voting_power']);
        if ($connection->query($query) !== TRUE) {
            echo "Error: " . $sql . "<br>" . $connection->error;
        }
    }

    foreach(range(0,count($candidate_list)-1) as $index) {
        // $candidate_list , $candidate_names÷
        $query = insert_candidate($candidate_list[$index],$highest_ballot+1,$candidate_names[$index],"''");
        if ($connection->query($query) !== TRUE) {
            echo "Error: " . $sql . "<br>" . $connection->error;
        }
    }
}
?>