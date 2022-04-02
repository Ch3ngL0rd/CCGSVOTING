<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar">
  <div class="position-sticky pt-3">
    <ul class="nav flex-column">
      <li class="nav-item">
        <?php
        echo "<a class='nav-link' href='page.php?pageID=create&user_id={$user_id}'>";
        ?>        
          Create Ballot
        </a>
      </li>
      <li class="nav-item">
        <?php
        echo "<a class='nav-link' href='page.php?pageID=manage&user_id={$user_id}'>";
        ?>    
          Manage Ballot
        </a>
      </li>
      <li class="nav-item">
        <?php
        echo "<a class='nav-link' href='page.php?pageID=view&user_id={$user_id}'>";
        ?>   
          View Ballot
        </a>
      </li>
    </ul>
  </div>
</nav>