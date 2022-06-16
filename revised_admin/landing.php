<?php
// Use this page as a 'bottleneck' - where we can check if is admin
include "../revised_utils.php";

$user_id = (isset($_GET['user_id'])) ? $_GET["user_id"] : -1;
if (!admin_check_id_admin($user_id)) {
    echo "not an admin!! :)";
    return;
}

if (!isset($_GET["page"])) {
    return;
}
$page = $_GET["page"];
if ($page == 'ballotcreate') {
    include 'create-ballot.php';
    return;
}

if ($page == 'ballotsubmit') {
    include 'submit-ballot-top.php';
    $student_year = (isset($_GET["student_year"])) ? $_GET["student_year"] : [];
    $student_house = (isset($_GET["student_house"])) ? $_GET["student_house"] : [];
    $staff_house = (isset($_GET["staff_house"])) ? $_GET["staff_house"] : [];
    $staff_department = (isset($_GET["staff_department"])) ? $_GET["staff_department"] : [];
    $bio = (isset($_GET['bio'])) ? true : false;
    $only_boarders = (isset($_GET['boarders'])) ? true : false;
    $randomised = (isset($_GET['randomised'])) ? true : false;
    $edit = ($_GET['edit_ballot_id']!='') ? $_GET['edit_ballot_id'] : -1;
    $ballot_form = array(
        "Name" => $_GET["name"],
        "Information" => $_GET["information"],
        "start_date" => $_GET["start_date"],
        "start_time" => $_GET["start_time"],
        "end_date" => $_GET["end_date"],
        "end_time" => $_GET["end_time"],
        "Power" => $_GET["power"],
        "MaxVotes" => $_GET["max_votes"],
        "Year" => $student_year,
        "House" => $student_house,
        "StaffHouse" => $staff_house,
        "staff_department" => $staff_department,
        "HasBio" => $bio,
        "OnlyBoarders" => $only_boarders,
        "Randomised" => $randomised,
        "BallotID" => $edit,
    );
    // Not -1 means we want to change a ballot
    if ($edit != -1) {
        $updates= admin_edit_one_ballot_check($ballot_form);
        admin_edit_one_ballot_update($updates);
        echo "<p class='fs-3'>Ballot (ID: ".$updates["BallotID"].") Successfully Updated</p>";
        unset($updates["BallotID"]);
        foreach ($updates as $key=>$value) {
            echo "<p class='fs-5'>$key: $value</p>";
        }
        include 'submit-ballot-bottom.html';
        return;
    }
    $errors = admin_check_one_ballot_valid($ballot_form);
    if (count($errors) != 0) {
        foreach ($errors as $error) {
            echo "<p class='fs-5'>$error</p>";
        }
        include 'submit-ballot-bottom.html';
        return;
    }

    // We know here that the vote is correct and we can insert it into the database
    if (admin_submit_one_ballot($ballot_form) == true) {
        echo "<p class='fs-3'>Ballot Successfully Submitted</p>";
    }
    include 'submit-ballot-bottom.html';
    return;
}

if ($page == 'ballotmanageview') {
    include 'manage-ballot-view.php';
    return;
}

if ($page == 'ballotmanage') {
    include 'manage-ballot.php';
    return;
}

echo "No page found...";
?>
