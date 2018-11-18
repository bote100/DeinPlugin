<?php
  if (isset($_SESSION['USER_ID'])) {
    $database -> close();
    die ('<meta http-equiv="refresh" content="0; URL=/">');
  } else if (isset($_POST['username'])
        && isset($_POST['password'])
        && isset($_POST['passwordRepeat'])
        && isset($_POST['mail'])) {

    if (isset($_POST['agb'])) {
      if ($_POST['password'] == $_POST['passwordRepeat']) {
        if (filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)) {
          if ($database -> checkUsername($_POST['username'])) {
            $activation = generateRandomString(8);
            $database -> registerUser($_POST['username'], $_POST['password'], $_POST['mail'], $activation);
            //TODO sendMail
            die("<script>alert('Registriert');</script>");
          } else
            $message = "Der Benutzername ist leider schon vergeben";
        } else
          $message = "Ungültige Email-Adresse";
      } else
        $message = "Die Eingegebenen Passwörter stimmen nicht überein";
    } else
      $message = "Sie müssen die AGB akzeptieren, um ein Benutzerkonto zu erstellen";
  }
?>
<br><br>
<div class="container row">
  <div class="col s12 m10 l8 offset-m1 offset-l2">
    <div class="card hoverable">
      <div class="card-content">
        <form method="post" action="register">
          <h4 class="center">Registrieren</h4>
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
            <label for="password">Passwort</label>
            <input name="password" id="password" type="password">
          </div>
          <div class="input-field">
            <label for="password">Passwort wiederholen</label>
            <input name="passwordRepeat" id="password" type="password">
          </div>
          <div class="input-field">
            <label for="mail">Mail</label>
            <input name="mail" id="mail" type="email">
          </div>
          <p>
            <label>
              <input type="checkbox" name="agb" />
              <span>Ich habe die AGB gelesen und akzeptiere diese</span>
            </label>
            <br><br>
          </p>

          <input class="btn" style="width: 100%" value="Login" type="submit">
          <br>
          <a class="right pointer" href="/login">Du hast schon einen Account?</a>
          <!--<a class="activator right pointer">Wie bekomme ich den Code?</a>-->
        </form>
      </div>
    </div>
  </div>
</div>
