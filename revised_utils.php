<?php

// Naming convention - Database
// Student / Admin
// Get / Set / Update / Check
// All / One
// What Ballot / Candidate / Voter
// by - ID

// Naming Convention - User
// Check
// Admin / Voter / Ballot / 
// by - ID / Time

include "db_connection.php";

// Returns all ballots for a student given
// their house and year group
function student_get_all_ballot($house,$year) {
    global $connection;

    // We can use LIKE with house since all are distinct
    // Cannot use LIKE for year since year '2' may appear in 12
    // If student
    $query = "SELECT * FROM BallotInformation 
    WHERE House LIKE '%$house%' AND Year LIKE '%$year%'";
    // If teacher / staff - no year
    if ($year == -1) {
        $query = "SELECT * FROM BallotInformation 
        WHERE StaffHouse LIKE '%$house%'";
    }
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

// Returns errors - if empty then valid
function admin_check_one_ballot_valid($ballot_form) {
    $errors = array();
    if ($ballot_form["Name"] == '') {
        array_push($errors,"Name field is required.");
    }
    if ($ballot_form["Information"] == '') {
        array_push($errors,"Information field is required.");
    }
    // Check that End date comes after Start Date
    // Do math to find time
    if ($ballot_form['start_time'] != '') {
        $local_start_time = explode(":",$ballot_form['start_time']);
        $local_start_time_value = $local_start_time[0] * 60 + $local_start_time[1];
    } else {
        array_push($errors,"Start time not defined");
    }
    if ($ballot_form['end_time'] != '') {
        $local_end_time = explode(":",$ballot_form['end_time']);
        $local_end_time_value = $local_end_time[0] * 60 + $local_end_time[1];
    } else {
        array_push($errors,"End time not defined");
    }
    if ($ballot_form['start_date'] != '') {
        $start_value = strtotime($ballot_form['start_date']) + $local_start_time_value * 60;
    } else {
        array_push($errors,"Start date not defined");
    }
    if ($ballot_form['end_date'] != '') {
        $end_value = strtotime($ballot_form['end_date']) + $local_end_time_value * 60;
    } else {
        array_push($errors,"End date not defined");
    }
    if (isset($start_value) && isset($end_value)) {
        if ($end_value-$start_value <= 0) {
            array_push($errors,"Ballot open is after ballot close.");
        }
    }

    if ($ballot_form["MaxVotes"] == '') {
        array_push($errors,"Max votes field is required.");
    }
    if ($ballot_form["Power"] == '') {
        array_push($errors,"Staff power field is required.");
    }
    if (count($ballot_form["Year"]) == 0
    && count($ballot_form["House"]) == 0
    && count($ballot_form["StaffHouse"]) == 0
    && count($ballot_form["staff_department"]) == 0){
        array_push($errors,"No voters selected.");
    }

    return $errors;
}

// Returns the keys it wants to update
function admin_edit_one_ballot_check($ballot_form) {
    $valid = [];
    foreach ($ballot_form as $key=>$value) {
        if ($value == '' || $value == []) {

        } else {
            $valid[$key] = $value;
        }
    }
    if (isset($valid["start_date"]) && isset($valid["start_time"])) {
        $start_date = date('Y-m-d H:i:s', strtotime($ballot_form["start_date"].' '.$ballot_form['start_time']));
        $valid["StartDate"] = $start_date;
        unset($valid["start_date"]);
        unset($valid["start_time"]);
    }
    if (isset($valid["end_date"]) && isset($valid["end_time"])) {
        $end_date = date('Y-m-d H:i:s', strtotime($ballot_form["end_date"].' '.$ballot_form['end_time']));
        $valid["EndDate"] = $end_date;
        unset($valid["end_date"]);
        unset($valid["end_time"]);
    }
    return $valid;
}

// Updates a ballot with a valid update array
function admin_edit_one_ballot_update($updates) {
    global $connection;
    $query = "UPDATE BallotInformation SET ";
    $ballot_id = $updates['BallotID'];
    unset($updates["BallotID"]);
    foreach ($updates as $key=>$value) {
        $value = mysqli_real_escape_string($connection,$value);
        $query = $query . "$key = '$value', ";
    }
    $query = substr($query,0,-2);
    $query = $query . " WHERE BallotID = $ballot_id";
    $result = $connection->query($query);
    if ($result !== TRUE) {
        echo "Error: " . $sql . "<br>" . $connection->error;
        return false;
    } else {
        return true;
    }
}

// Submits a ballot into our database assuming it's correct
function admin_submit_one_ballot($ballot_form) {
    global $connection;
    // Combine date + time
    $start_date = date('Y-m-d H:i:s', strtotime($ballot_form["start_date"].' '.$ballot_form['start_time']));
    $end_date = date('Y-m-d H:i:s', strtotime($ballot_form["end_date"].' '.$ballot_form['end_time']));

    $query = sprintf(
        "INSERT INTO BallotInformation 
        (Name,Information,MaxVotes,Power,Randomised,StartDate,EndDate,HasBio,StaffHouse,House,Year)
        VALUES
        ('%s','%s',%d,%d,%d,'%s','%s',%d,'%s','%s','%s')",
    mysqli_real_escape_string($connection,$ballot_form["Name"]),
    mysqli_real_escape_string($connection,$ballot_form["Information"]),
    $ballot_form["MaxVotes"],$ballot_form["Power"],$ballot_form["Randomised"],
    $start_date,$end_date,
    $ballot_form["HasBio"],
    implode(',',$ballot_form["StaffHouse"]),implode(',',$ballot_form["House"]),
    implode(',',$ballot_form["Year"]));

    $result = $connection->query($query);
    if ($result !== TRUE) {
        echo "Error: " . $sql . "<br>" . $connection->error;
        return false;
    } else {
        return true;
    }
}

// Gets all ballots for admin
function admin_get_all_ballot() {
    global $connection;
    $query = "SELECT * FROM BallotInformation ORDER BY BallotID DESC";
    $result = $connection->query($query);
    if ($result->num_rows > 0) {
        // output data of each row
        return $result->fetch_all(MYSQLI_ASSOC);
    } else {
        return array();
    }
}

// Checks if the user is an admin
function admin_check_id_admin($user_id) {
    global $connection;
    $query = "SELECT COUNT(*) FROM Admin WHERE AdminID = $user_id";
    $result = $connection->query($query);
    return $result->fetch_row()[0] != 0;
}

// MUST QUERY FOR NAME
function admin_update_one_candidate_caption($ballot_id,$student_id,$caption) {
    global $connection;
    $query = sprintf(
        "INSERT INTO CANDIDATE (StudentID,BallotID,Name,Bio) VALUES (%s,%s,'TestName','%s')
        ON DUPLICATE KEY UPDATE Bio = '%s'",
    $student_id,$ballot_id,
    mysqli_real_escape_string($connection,$caption),
    mysqli_real_escape_string($connection,$caption));

    $result = $connection->query($query);
    if ($result !== TRUE) {
        echo "Error: " . $sql . "<br>" . $connection->error;
        return false;
    } else {
        return true;
    }
}

function admin_remove_candidate($ballot_id,$student_id) {
    global $connection;
    $query = sprintf(
        "DELETE FROM CANDIDATE 
        WHERE BallotID = %s
        AND StudentID = %s",
    $ballot_id,$student_id);

    $result = $connection->query($query);
    if ($result !== TRUE) {
        echo "Error: " . $sql . "<br>" . $connection->error;
        return false;
    } else {
        return true;
    }
}

// Exports votes to an xls document
function admin_export_voters($ballot_id) {
    date_default_timezone_set('Australia/Perth');
    $fileName = "Ballot[$ballot_id]".date("d-m-Y|h:i:s").".csv";
    //Set header information to export data in excel format
    header('Content-Disposition: attachment; filename='.$fileName);
    $voter_data = admin_get_voters($ballot_id);
    // print_r($voter_data);
    $out = fopen('php://output', 'w');
    fputcsv($out, ["ID", "User ID", "Ballot ID", "Vote", "Power", "Time Voted", "House", "Year", "Preference"]);
    foreach ($voter_data as $voter) {
        fputcsv($out, $voter);
    }
    fclose($out);
}

// Gets voters per ballot_id
function admin_get_voters($ballot_id) {
    global $connection;
    $query = "SELECT * FROM Voter 
    WHERE BallotID = $ballot_id";
    $result = $connection->query($query);

    if ($result->num_rows > 0) {
        return $result->fetch_all(MYSQLI_ASSOC);
    } else {
        return array();
    }
}

// Call upon isset($_POST["submit"]) = true
function admin_upload_photo() {
    $target_dir = "../components/uploaded/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    $result = [];
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if (file_exists($target_file)) {
        array_push($result,"File with name [".$_FILES["fileToUpload"]["name"]."] already exists.");
    }
    if ($_FILES["fileToUpload"]["size"] > 1000000) {
        array_push($result,"File is too large.");
    }
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
        array_push($result,"Only files of type JPG, JPEG & PNG are allowed.");
    }

    if (count($result) != 0) {

    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            array_push($result,"The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.");
        } else {
            array_push($result,"Sorry, there was an error uploading your file.");
        }
    }
    return $result;
}

// Changes ballot_id with new photo path
function admin_change_banner($ballot_id,$photo_path) {
    global $connection;
    $query = sprintf("UPDATE BallotInformation 
    SET Photo = '%s' 
    WHERE BallotID = $ballot_id",
    mysqli_real_escape_string($connection,$photo_path));
    $result = $connection->query($query);
    if ($result !== TRUE) {
        echo "Error: " . $sql . "<br>" . $connection->error;
        return false;
    } else {
        return true;
    }
}

?>