<?php
// $user_id = $_GET["user_id"]; - from page.php
$data = fetch_ballot_manage($user_id);
?>
<table class="table table-striped table-hover">
    <caption>Ballots</caption>
    <thead>
        <tr>
            <th scope="col">Ballot ID</th>
            <th scope="col">Name</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($data as $row) {
            // href='page.php?pageID=view&user_id={$user_id}
            echo "<tr onclick=\"document.location.href='page.php?pageID=manageBallot&type=candidate&user_id=$user_id&ballot_id=$row[0]'\">";
                echo "<th>$row[0]</th>";
                echo "<td>$row[1]</td>";
            echo "</tr>";
        }
        ?>
    </tbody>
</table>