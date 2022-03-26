<?php
include '../utils.php';
include '../userutils.php';
$data = get_all_ballots($_GET["user_id"]);
$voted = [];
$unvoted = [];
foreach ($data as $row) {
    if (has_voted($row) == true) {
        array_push($voted,$row);
    } else {
        array_push($unvoted,$row);
    }
}
$voted_id_information = array_map(fn($value): int => $value[2],$voted);
$voted_ballot_information = get_ballot_information($voted_id_information);
$unvoted_id_information = array_map(fn($value): int => $value[2],$unvoted);
$unvoted_ballot_information = get_ballot_information($unvoted_id_information);
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
        <script>
            function enter_ballot(ballot_id,user_id) {
                console.log(ballot_id,user_id);
                alert("entering ballot "+ballot_id+" with ID "+user_id);
            }
        </script>
    </head>
    <body>
        <div class="container">
            <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom">
                <div href="/" class="d-flex align-items-center me-md-auto text-dark text-decoration-none">
                  <img src="../components/ccgs-logo.png" class="me-4" width="50" height="90"></img>
                  <span class="fs-3 fw-bold">Christ Church Grammar School Prefect Voting </span>
                </div>
            </header>

            <div class="row justify-content-around">
                <div class="col-6">
                    <table class="table table-striped table-hover">
                        <caption>Uncompleted Ballots</caption>
                        <thead>
                            <tr>
                                <th scope="col">Ballot ID</th>
                                <th scope="col">Name</th>
                                <th scope="col">Ending Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // In here we will echo out html that displays what ballots the user is in
                                foreach ($unvoted_ballot_information as $row) {
                                    echo "<tr onclick=\"document.location.href='studentVoting.php?user_id=" . $_GET["user_id"] . "&ballot_id=$row[0]'\">";
                                        echo "<th>$row[0]</th>";
                                        echo "<td>$row[1]</td>";
                                        echo "<td>" . substr($row[5],0,10) . "</td>"; //Slice to pretty print
                                    echo "</tr>";
                                }
                            ?>
                        </tbody>
                    </table>
                </div>

                <div class="col-4">
                    <table class="table table-striped">
                        <caption>Completed Ballots</caption>
                        <thead>
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col">End Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // In here we will echo out html that displays what ballots the user is in
                                foreach ($voted_ballot_information as $row) {
                                    echo "<tr>";
                                        echo "<td>$row[1]</td>";
                                        echo "<td>" . substr($row[5],0,10) . "</td>"; //Slice to pretty print
                                    echo "</tr>";
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </body>
</html>