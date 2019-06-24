<!-- The navbar fragment also contains functions and HTML elements used for toast notifications -->
<?php include("fragments/".$_SESSION['user_type']."-notifications.php"); ?>
<div class="sticky-top">
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" <?php echo ($_SESSION['user_type'] == 'client') ? 'href="home_clients.php"' : 'href="home_providers.php"'; ?>>
      <img src="res/logo.png" width="30" height="30" class="d-inline-block align-top" alt="">
      Project
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarText">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item">
          <a class="nav-link" <?php echo ($_SESSION['user_type'] == 'client') ? 'href="home_clients.php"' : 'href="home_providers.php"'; ?>><i class="fas fa-home"></i> Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" <?php echo ($_SESSION['user_type'] == 'client') ? 'href="profile_clients.php"' : 'href="profile_providers.php"'; ?>><i class="fas fa-user"></i> Profile</a>
        </li>
        <?php
        if ($_SESSION['user_type'] == 'client') {
          echo '
          <li class="nav-item">
            <a class="nav-link" href="orders_clients.php"><i class="fas fa-book"></i> Orders</a>
          </li>
          ';
        }
        ?>
      </ul>
      <ul class="navbar-nav navbar-right">
        <li class="nav-item">
          <div class="navbar-text">Welcome, <?php echo $_SESSION['user_name']; echo ($_SESSION['user_type'] == 'client') ? '. Bon appétit!' : '.';?></div>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </li>
      </ul>
    </div>
  </nav>
  <div aria-live="polite" aria-atomic="true" style="position: relative;">
    <div class="pr-3 pt-3" id="notificationArea" style="position: absolute; top: 0; right: 0;">
    </div>
  </div>
</div>
<script type="text/javascript">
function createToast(title, subtitle, description) {
  var toast = $(`<div class="toast" role="alert" aria-live="assertive" aria-atomic="false" data-autohide="false" style="min-width: 230px; max-width: 450px">
    <div class="toast-header">
      <strong class="mr-auto pr-2">` + title + `</strong>
      <small class="pl-2">` + subtitle + `</small>
      <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="toast-body">
      ` + description + `
    </div>
  </div>`)
  $("#notificationArea").append(toast)
  toast.toast('show')
}
</script>
