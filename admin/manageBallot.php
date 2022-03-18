<h2>Manage</h2>
<p>What's required for this page? User needs to be able to:<br>
  Select students that can vote<br>
  Select staff and assign their voting power<br>
  Select candidates and upload their ID's
</p>
<form action="page.php" method="get">
<div class="form-group">
    <label for="ballot_id">Ballot ID - TEMP (until single sign on and user verification is complete)</label>
    <input type="number" class="form-control" id="ballot_id" name="ballot_id" placeholder="Ballot ID to edit">
  </div>
  <br>
    <!-- Dummy student selection until integration with Synergetic -->
  <div class="form-group">
    <label for="students">House Selected</label>
    <select class="form-select" id="students" name="students" aria-label="Default select example">
      <option selected>Select Students To Vote</option>
      <option value="Moyes">Moyes</option>
      <option value="Cragie">Craigie</option>
      <option value="Noake">Noake</option>
      <option value="Hill">Hill</option>
      <option value="Queenslea">Queenslea</option>
      <option value="Jupp">Jupp</option>
      <option value="Romsey">Romsey</option>
      <option value="Wolsey">Wolsey</option>
    </select>
  </div>
  <br>
  <!-- Dummy staff selection until integration with Synergetic -->
  <div class="form-group">
    <label for="staff">Staff Selected</label>
    <select class="form-select" id="staff" name="staff" aria-label="Default select example">
      <option selected>Select Staff To Vote</option>
      <option value="Moyes">Moyes</option>
      <option value="Cragie">Craigie</option>
      <option value="Noake">Noake</option>
      <option value="Hill">Hill</option>
      <option value="Queenslea">Queenslea</option>
      <option value="Jupp">Jupp</option>
      <option value="Romsey">Romsey</option>
      <option value="Wolsey">Wolsey</option>
    </select>
  </div>
  <br>

  <div class="form-group">
    <label for="voting_power">Voting Power</label>
    <input type="number" class="form-control" id="voting_power" name="voting_power" placeholder="Voting Power for Staff">
  </div>
  <br>

  <div class="form-group">
    <label for="candidates">Candidates</label>
    <textarea class="form-control form-control-sm" id="candidates" rows="3" name="candidates"
    placeholder="Enter candidates seperated by commas (TEMP - can be changed if required - lmk)"></textarea>
  </div>

  <!-- Constants - not sure better way to include -->
  <input hidden=true name="pageID" value="manage">
  <input hidden=true name="submit" value="true">
  <br>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>

