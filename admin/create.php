<form action="page.php" method="get">
    <div class="form-group">
      <label for="name">Name</label>
      <input type="text" class="form-control" id="name" name="name" placeholder="Moyes 2023 House Prefect Vote">
    </div>
    <br>
    <div class="form-group">
      <label for="information">Description</label>
      <textarea class="form-control form-control-sm" id="information" rows="3" name="information"
      placeholder="This vote will determine the house prefects for Moyes going into the 2023"></textarea>
    </div>
    <br>
    <div class="form-group">
      <label for="max_votes">Maximum votes</label>
      <input type="number" class="form-control" id="max_votes" name="max_votes" placeholder="Maximum number of votes per voter">
    </div>
    <br>
    <div class="form-group">
      <label for="start_date">Start Date</label>
      <input type="date" class="form-control" id="start_date" name="start_date" placeholder="YYYY/MM/DD">
    </div>
    <br>
    <div class="form-group">
      <label for="end_date">End Date</label>
      <input type="date" class="form-control" id="end_date" name="end_date"placeholder="YYYY/MM/DD">
    </div>
    <br>
    <!-- <div class="form-group">
      <label for="user_id">User ID</label>
      <input type="number" class="form-control" id="user_id" name="user_id" placeholder="USER ID - Delete once single sign on enabled">
    </div>
    <br> -->

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
    
    <div class="form-check">
      <input type='hidden' value='false' name='has_bio'>
      <input type="checkbox" value='true' class="form-check-input" id="has_bio" name="has_bio">
      <label class="form-check-label" for="has_bio">Enable Candidate Biography</label>
    </div>

    

    <!-- Constants - not sure better way to include -->
    <input hidden=true name="pageID" value="create">
    <input hidden=true name="submit" value="true">
    <?php
    echo "<input hidden=true name='user_id' value='{$user_id}'>";
    ?>
    <br>
    <button type="submit" class="btn btn-primary">Submit</button>
  </form>