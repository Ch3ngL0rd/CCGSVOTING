<?php
// Outputs html from ballot object from SQL
// Name, Description, Image, Time Closing
function student_create_ballot($ballot,$user_info) {
    echo '<div class="card ballot-card text-center rounded">';
        echo "<div class='d-flex justify-content-center'>";
        echo "<img class='card-img-top ballot-image' src='".htmlspecialchars($ballot["Photo"])."'>";
        echo "</div>";
        echo '<div class="card-body">';
            echo "<h3 class='card-title'>" . $ballot["Name"] . "</h3>";
            // echo "<br>";
            echo "<p class='card-text fst-italic'>" . $ballot["Information"] . "<p>";
            if ($ballot["Time"] == True && $ballot["Voted"] == False) {
                echo '<a href="voting.php?ballot_id=' . $ballot["BallotID"] . '&house=' . $user_info["House"] . '&year=' . $user_info["Year"] . '&user_id=' . $user_info["UserID"]. '" class="stretched-link"></a>';
            }
        echo '</div>';
        echo "<div class='card-footer text-muted'>";
        if ($ballot["Time"] == True && $ballot["Voted"] == False) {
            echo "<a class='text-primary'>Awaiting Vote...</a>";           
        } else if ($ballot["Voted"] == False) {
            echo "Ballot Closed - <a class='text-danger'>No Vote Submitted</a>";
        } else {
            echo "Ballot Closed - <a class='text-success'>Vote Submitted</a>";
        }
        echo "</div>";
    echo '</div>';
}

// Outputs html from candidate object
function student_create_candidate($candidate,$index) {
    echo "<div onclick='add_vote(\"".$candidate["Name"]."\",".$candidate["StudentID"].",$index)' class='card candidate-card text-center rounded' id='candidatecard$index'>";
        echo "<img src='./portrait.png' draggable='false' class='card-img-top mx-auto student-image'></img>";
        echo "<img src='./green_tick.png' draggable='false' class='student-tick' id='candidatetick$index'></img>";
        echo '<div class="card-body">';
            echo "<h3 class='card-title'>" . $candidate["Name"] . "</h3>";
        echo '</div>';
        echo "<div class='card-footer fst-italic'>" . $candidate["Bio"] . "</div>";
    echo '</div>';    
}
?>