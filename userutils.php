<!-- File contains functions for formatting that is not database related -->
<?php
function print_images($candidate_list) {
    foreach ($candidate_list as $candidate) {
        echo "<div class=image-holder>";
            echo "<img src='./portrait.png' class=image></img>";
            echo "<p class='fs-4 fw-bold'>$candidate[3] ($candidate[1])</p>";
            echo "<p class='fs-6'>$candidate[4]</p>";
        echo "</div>";
    }
}

function create_voting($max_votes,$user_id,$ballot_id) {
    echo "<form action='studentPage.php' method='get'>";
    foreach (range(1,$max_votes,1) as $number) {
        echo "<div class='form-group'>";
        echo "<label for='$number'>Preference $number</label>";
        echo "<input type='number' class='form-control' name='$number' id='$number'>";
        echo "</div>";
    }
    echo "<br>";
    echo "<input hidden=true name='user_id' value='{$user_id}'>";
    echo "<button type='submit' class='btn btn-primary'>Submit</button>";
    echo "<input hidden=true name='submit' value='true'>";
    echo "<input hidden=true name='max_votes' value=$max_votes>";
    echo "<input hidden=true name='ballot_id' value=$ballot_id>";
    echo "</form>";
}
?>