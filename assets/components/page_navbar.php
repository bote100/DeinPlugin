<nav class="nav-extended" style="background-image: url(/assets/images/page-background.jpg);background-repeat: no-repeat; background-attachment: fixed;background-position:center;">
  <a data-target="sidenav" class="sidenav-trigger no-select"><i class="material-icons">menu</i></a>
  <div class="nav-wrapper">
    <?php
      if ($page != 'home') {
    ?>
      <a href="/" class="brand-logo no-select">
        <span class="hide-on-med-and-down">&nbsp;</span>
        <img src="/assets/images/shop-logo.png" style="height: 32px;">
      </a>
    <?php
      }
    ?>

    <ul id="nav-mobile" class="right hide-on-med-and-down">
      <li class="<?php echo ($page == "home" ? "active" : ""); ?>">
        <a href="/">Startseite</a>
      </li>
      <li class="<?php echo ($page == "category" ? "active" : ""); ?>">
        <a class="dropdown-trigger" data-target="dropdownCategories">
          <i class="material-icons right">arrow_drop_down</i>
          Kategorien
        </a>
      </li>

      <?php
        if ($user != null)
        {
      ?>
        <li><a href="/profile">Profil</a></li>
        <li><a href="/logout">Logout</a></li>
      <?php
          if ($database -> checkPrivilege($user -> id, 'acp')) {
            ?>
              <li><a href="/admin"><i class="material-icons">settings</i></a></li>
            <?php
          }
        } else {
      ?>
        <li><a href="/login">Login</a></li>
      <?php
        }
      ?>
    </ul>

    <ul id="dropdownCategories" class="dropdown-content">
      <?php
        $categories = $database -> listCategories(false);
        foreach ($categories as $category)
          echo '<li><a href="/category/' . $category -> name . '/">' . $category -> name . '</a></li>';
      ?>
    </ul>
  </div>

  <div class="nav-header center">
    <?php
      switch ($page) {
        case 'home':
          echo '<img src="/assets/images/shop-logo.png" class="no-select" style="height: 250px;">';
          break;
        case 'category':
          echo '<h1>' . $_GET['category'] . '</h1>
                <div class="tagline">Produkte</div>';
          break;
        case 'product':
          $product = $database -> getProductData($_GET['product']);
          echo '<h1>' . ($product == null ? $_GET['product'] : $product -> name) . '</h1>
                <div class="tagline">Produkte</div>';
          break;
        case 'login':
          echo '<h1>Login</h1>
                <div class="tagline">Benutzerprofil</div>';
          break;
        case 'register':
          echo '<h1>Registrieren</h1>
                <div class="tagline">Benutzerprofil</div>';
          break;
        case 'terms':
          echo '<h1>Rechtliches</h1>
                <div class="tagline">#WeDon\'tCareAboutGender</div>';
          break;
        case 'profile':
          echo '<h1>Profil</h1>
                <div class="tagline">Accountinformationen</div>';
          break;
        case 'faq':
          echo '<h1>FAQ</h1>
                <div class="tagline">Häufig gestellte Fragen</div>';
          break;
        case 'tickets':
          echo '<h1>Ticket</h1>
                <div class="tagline">Ticketsupport</div>';
          break;
        default:
          echo '<h1>PAGE</h1>
                <div class="tagline">' . $page . '</div>';
          break;
      }
    ?>
      <!--
        <h1>Fehler</h1>
        <div class="tagline">
          {% case page[1] %}
            {% when '400' %}
              Fehlerhafte Anfrage
            {% when '403' %}
              Unzureichende Berechtigung
            {% when '404' %}
              Unbekannte Seite
            {% when '900' %}
              Unzureichendes Guthaben
            {% when '901' %}
              Kauf unm&ouml;glich
            {% else %}
            -
          {% endcase %}
        </div>
      -->
    <br>

    <?php
      if ($page == "terms") {
    ?>
      <ul class="tabs tabs-transparent center">
        <li class="tab"><a href="#imprit">Impressum</a></li>
        <li class="tab"><a href="#data">Datenschutzerkl&auml;rung</a></li>
      </ul>
    <?php
      }
    ?>
  </div>
</nav>
