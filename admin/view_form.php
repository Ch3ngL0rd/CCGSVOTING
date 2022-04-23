<form action="page.php" method="get">
    <div class="input-group mb-3">
        <input type="number" class="form-control" id="ballot_id" name="ballot_id" placeholder="Ballot ID">
        <div class="input-group-append">
            <button class="btn btn-primary" type="submit">Submit</button>
        </div>
        <input hidden=true name="pageID" value="view">
        <?php
        echo "<input hidden=true name='user_id' value=$user_id>";
        ?>
    </div>
</form>