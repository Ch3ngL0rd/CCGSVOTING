<?php
include "db_connection.php";
// Create a ballot
// Name: String, Information: String, Max Votes: String, Start Date: String, End Date : String, Has_Bio : String 
function create_ballot($name,$information,$max_votes,$start_date,$end_date,$has_bio,$user_id) {
    return "INSERT INTO BallotInformation (Name,Information,MaxVotes,StartDate,EndDate,HasBio,CreatorID)
    VALUES ('".$name."','".$information."',".$max_votes.",CAST('".$start_date."' AS DATE),CAST('".$end_date."' AS DATE),".$has_bio.",".$user_id.")";
}

// Insert a candidate into a ballot
// No Photo included
function insert_candidate($student_id,$ballot_id,$name,$bio) {
    return "INSERT INTO Candidate (StudentID,BallotID,Name,Bio) 
    VALUES ($student_id,$ballot_id,$name,$bio)";
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

// Talks to Synergetic to fetch a students name and photo from a student_id
function fetch_student($student_id) {

}

// Checks that user can create a ballot
function is_staff($admin_id) {

}

// Check if user can view ballots
function can_view($admin_id) {
    
}

// pass in array from create ballot
// we are fomratting a date into a actual date for mysql
function parse_create($array) {
    global $connection;
    // if not echo & return
    $failed = false;
    if ($array['name'] == '' || $array['information'] == '' || $array['max_votes'] == '' || $array['start_date'] == '' || 
    $array['end_date'] == '' || $array['has_bio'] == '' || $array['user_id'] == '') {
        echo "Please fill out all forms.";
        return false;
    }
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

    $query = create_ballot($array['name'],$array['information'],$array['max_votes'],$array['start_date'],$array['end_date'],$array['has_bio'],$array['user_id']);
    if ($connection->query($query) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
}
?>