<?php
include '../utils.php';
include '../userutils.php';
$ballot_id = $_GET["ballot_id"];
$user_id = $_GET['user_id'];
// get list of candidates
$candidate_info = get_candidates($ballot_id);
$ballot_info = get_ballot($ballot_id);
$name = $ballot_info[0][1];
$description = $ballot_info[0][2];
$max_votes = $ballot_info[0][3];
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
        <div class="container">
            <header class="d-flex flex-wrap justify-content-center py-3 mb-2 border-bottom">
                <div href="/" class="d-flex align-items-center me-md-auto text-dark text-decoration-none">
                  <img src="../components/ccgs-logo.png" class="me-4" width="50" height="90"></img>
                  <span class="fs-3 fw-bold">Christ Church Grammar School Prefect Voting </span>
                </div>
            </header>
        </div>
        <p class="fs-3 text-decoration-underline text-center">
        <?php
        echo $name;
        ?>
        </p>
        <p class="fs-6 fst-italic text-center">
        <?php
        echo $description;
        ?>
        </p>
        <br>
        <div class="container">
            <div class="row align-items-start">
                <div class="col-9">
                    <div class="student-images">
                        <?php
                        print_images($candidate_info);
                        ?>
                    </div>
                </div>
                <div class="col-3 sticky-top">
                    <br>
                    <?php
                    create_voting($max_votes,$user_id,$ballot_id);
                    ?>
                </div>
            </div>
        </div>
    </body>
</html>