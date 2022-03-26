<?php
include '../utils.php';
include '../userutils.php';
$ballot_id = $_GET["ballot_id"];
// get list of candidates
$candidate_info = get_candidates($ballot_id);
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
            <header class="d-flex flex-wrap justify-content-center">
                <div class="d-flex align-items-center me-md-auto text-dark">
                  <span class="fs-4 fw-normal">Christ Church Grammar School Prefect Voting </span>
                </div>
            </header>
        </div>
        <br>
        <div class="container">
            <div class="row align-items-start">
                <div class="col-8">
                    <div class="student-images">
                        <?php
                        print_images($candidate_info);
                        ?>
                    </div>
                </div>
                <div class="col-4">
                    Voting
                </div>
            </div>
        </div>
    </body>
</html>