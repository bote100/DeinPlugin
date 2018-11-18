<ul id="sidenav" class="sidenav no-select">
  <li>
    <ul class="collapsible collapsible-accordion no-padding">
      <li class="<?php echo ($page == "home" ? "active" : ""); ?>">
        <a class="collapsible-header" href="/">
          <i class="material-icons">home</i>
          Startseite
        </a>
        <div class="collapsible-body"></div>
      </li>
    </ul>

    <li>
      <ul class="collapsible collapsible-accordion no-padding">
        <li class="<?php echo ($page == "category" ? "active" : ""); ?>">
          <a class="collapsible-header">
            <i class="material-icons">category</i>
            Kategorien
          </a>
          <div class="collapsible-body">
            <ul>
              <?php
                foreach ($categories as $category)
                  echo '<li><a href="/category/' . $category -> name . '/">' . $category -> name . '</a></li>';
              ?>
            </ul>
          </div>
        </li>
      </ul>
    </li>

  <?php
    if (isset($_SESSION['USER_ID'])) {
  ?>
    <li class="hide-on-large-only">
      <ul class="collapsible collapsible-accordion no-padding">
        <li class="<?php echo ($page == "profile" ? "active" : ""); ?>">
          <a href="/profile" class="collapsible-header">
            <i class="material-icons">account_circle</i>
            Profil
          </a>
          <div class="collapsible-body"></div>
        </li>
      </ul>
    </li>
  <?php
    if ($database -> checkPrivilege($user -> id, 'acp')) {
      ?>
      <li class="hide-on-large-only">
        <ul class="collapsible collapsible-accordion no-padding">
          <li>
            <a href="/admin" class="collapsible-header">
              <i class="material-icons">settings</i>
              Shop verwalten
            </a>
            <div class="collapsible-body"></div>
          </li>
        </ul>
      </li>
  <?php
    }
  ?>
    <li class="hide-on-large-only">
      <ul class="collapsible collapsible-accordion no-padding">
        <li>
          <a href="/logout" class="collapsible-header">
            <i class="material-icons">exit_to_app</i>
            Logout
          </a>
          <div class="collapsible-body"></div>
        </li>
      </ul>
    </li>
<?php
  } else {
?>
    <li class="hide-on-large-only">
      <ul class="collapsible collapsible-accordion no-padding">
        <li>
          <a href="/login" class="collapsible-header">
            <i class="material-icons">sign_in</i>
            Login
          </a>
          <div class="collapsible-body"></div>
        </li>
      </ul>
    </li>
  <?php
    }
  ?>
</ul>
