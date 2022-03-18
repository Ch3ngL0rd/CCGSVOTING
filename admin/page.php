<?php
include '../utils.php';
?>
<!doctype html>
<html lang="en">
  <head>
    <meta crset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Control Panel</title>

    <!-- Bootstrap core CSS -->
    <link href="../components/bootstrap.min.css" rel="stylesheet">
  </head>
<body>
    
  <?php
  include 'header.html';
  ?>

  <div class="container-fluid">
    <div class="row">
      <?php
      include 'sidebar.html';
      ?>

      <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h1 class="h2">Control Panel</h1>
        </div>
        <?php
          // http://localhost:8080/admin/page.php?name=zac&information=123&max_votes=123&start_date=29%2F11%2F2002&end_date=29%2F11%2F2002&pageID=create&submit=true
          if ($_GET["pageID"] == "create") {
            if (isset($_GET["submit"])) {
              parse_create($_GET);
            } else {
              include 'create.html';
            }
          } else if ($_GET["pageID"] == "manage") {
            include 'manage.php';
          } else if ($_GET["pageID"] == "view") {
            echo "<h2>View</h2>";
          }
        ?>
      </main>
    </div>
  </div>

</body>
</html>
