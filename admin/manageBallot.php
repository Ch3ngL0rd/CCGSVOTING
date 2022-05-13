<?php
// echo $ballot_id . "<br>";
if (isset($_GET['submit'])) {
    // add to 
    $candidate_id = $_GET['candidate_id'];
    if (strlen($candidate_id) != 0) {
        $bio = $_GET['information'];
        change_candidate($candidate_id,$bio);
    }

}
$ballot_id = $_GET["ballot_id"];
$data = get_candidates($ballot_id);
?>

<div class="container">
  <div class="row justify-content-start">
      <div class="col-5">
          <table class="table table-striped table-hover">
              <caption>Candidates</caption>
              <thead>
                  <tr>
                      <th scope="col">ID</th>
                      <th scope="col">Name</th>
                      <th scope="col">Bio</th>
                  </tr>
              </thead>
              <tbody>
                  <?php
                    foreach ($data as $row) {
                        // href='page.php?pageID=view&user_id={$user_id}
                        echo "<tr>";
                            echo "<th>$row[1]</th>";
                            echo "<td>$row[3]</td>";
                            echo "<td>$row[4]</td>";
                        echo "</tr>";
                    }
                  ?>
              </tbody>
          </table>
      </div>
      <div class="col-7">
      <div class="container">
        <div class="row justify-content-start">
                <form action="page.php" method="get">
                    <div class="form-group">
                        <label for="candidate_id">Candidate ID</label>
                        <input type="number" class="form-control" id="candidate_id" name="candidate_id" placeholder="1032382">
                    </div>
                    <br>
                    <div class="form-group">
                        <label for="information">Bio</label>
                        <textarea class="form-control form-control-sm" id="information" rows="3" name="information"
                        placeholder="I  appreciate the oppotunity for leading the house. I love being a house prefect!"></textarea>
                    </div>
                    <br>
                    <input hidden=true name="pageID" value="manageBallot">
                    <?php
                        echo "<input hidden=true name='user_id' value='{$user_id}'>";
                        echo "<input hidden=true name='ballot_id' value='{$ballot_id}'>";
                    ?>
                    <input hidden=true name="submit" value="true">
                    <br>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
      </div>
  </div>
  <?php
  if (isset($_GET['submit'])) {
    echo "<h5>Sucessfully Submitted</h5>";
  }
  ?>
</div>