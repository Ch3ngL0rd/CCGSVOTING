<?php
$data = fetch_ballot_manage($user_id);
?>
<h2>Manage</h2>
<p>What's required for this page? Admin needs to be able to:<br>
  Select students that can vote<br>
  Select staff and assign their voting power<br>
  Select candidates and upload their ID's
</p>
<div class="container">
  <div class="row justify-content-around">
      <div class="col-12">
          <table class="table table-striped table-hover">
              <caption>Uncompleted Ballots</caption>
              <thead>
                  <tr>
                      <th scope="col">Ballot ID</th>
                      <th scope="col">Name</th>
                  </tr>
              </thead>
              <tbody>
                  <?php
                    foreach ($data as $row) {
                        echo "<tr onclick=\"document.location.href='manageBallot.php?user_id=$user_id&ballot_id=$row[0]'\">";
                            echo "<th>$row[0]</th>";
                            echo "<td>$row[1]</td>";
                        echo "</tr>";
                    }
                  ?>
              </tbody>
          </table>
      </div>
  </div>
</div>