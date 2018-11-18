<?php
  $user = null;

  if (isset($_REQUEST['logout'])) {
    session_destroy();
    die ('<meta http-equiv="refresh" content="0; URL=/">');
  } else if ($user != null) {
    $database -> close();
    die ('<meta http-equiv="refresh" content="0; URL=/">');
  } else if (isset($_POST['username']) && isset($_POST['password'])) {
    echo $_POST['username'];
    $user = $database -> checkLogin($_POST['username'], $_POST['password']);

    if ($user != null) {
      $_SESSION['USER_ID'] = $user -> id;
      echo json_encode($user);

      die ('<meta http-equiv="refresh" content="0; URL=/">');
    } else
      $message = "Der Benutzername und/oder das Passwort waren falsch";
  }
?>
<br><br>
<div class="container row">
  <div class="col s12 m10 l8 offset-m1 offset-l2">

    <div class="card hoverable">
      <div class="card-content">
        <form method="post" action="/login">
          <h4 class="center">Login</h4>
          <?php
            if (isset($message)) {
          ?>
          <div class="card-panel red lighten-1">
            <?php echo $message; ?>
          </div>
          <br>
          <?php
            }
          ?>
          <div class="input-field">
            <label for="username">Benutzername</label>
            <input name="username" id="username" type="text">
          </div>
          <div class="input-field">
            <label for="password">Password</label>
            <input name="password" id="password" type="password">
          </div>
          <input class="btn" style="width: 100%" value="Einloggen" type="submit">
          <br>
          <br>
          <a class="right pointer" href="/register">Noch keinen Account?</a>
          <a class="left pointer" href="/register">Passwort vergessen?</a>
        </form>
      </div>
    </div>
  </div>
</div>
