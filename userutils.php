<!-- File contains functions for formatting that is not database related -->
<?php
function print_images($candidate_list) {
    foreach ($candidate_list as $candidate) {
        echo "<div class=image-holder>";
            echo "<img src='./portrait.png' class=image></img>";
            echo "<p class='fs-4 fw-bold'>$candidate[3]</p>";
            echo "<p class='fs-6 fst-italic'>$candidate[4]</p>";
        echo "</div>";
    }
}
?>