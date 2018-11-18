<?php
  if (!isset($_GET['path']))
    $_GET['path'] = '';
?>
<ul id="sidenav" class="sidenav sidenav-fixed no-select">
  <li>
    <div class="user-view no-padding">
      <div class="background">
        <img src="/assets/images/user-background.jpg">
      </div>
      <div class="row valign-wrapper">
        <div class="col s4 m4 l4">
          <img class="circle" src="/assets/images/shop-logo.png">
        </div>
        <div class="col s8 m8 l8 white-text">
            <?php echo $user -> username; ?>
        </div>
      </div>
    </div>
  </li>
  <?php
    if ($database -> checkPrivilege($user -> id, 'products')
      || $database -> checkPrivilege($user -> id, 'categories')
      || $database -> checkPrivilege($user -> id, 'statistics')) {
  ?>
  <li>
    <ul class="collapsible collapsible-accordion no-padding">
      <li class="<?php echo ($_GET['path'] == "shop" ? "active" : ""); ?>">
        <a class="collapsible-header"><i class="material-icons">shopping_cart</i>Shop</a>
        <div class="collapsible-body">
          <ul>
            <?php
              if ($database -> checkPrivilege($user -> id, 'products')) {
            ?>
              <li class="<?php echo ($_GET['page'] == "products" ? "active" : ""); ?>">
                <a href="/admin/shop/products">Produkte</a>
              </li>
            <?php
              }

              if ($database -> checkPrivilege($user -> id, 'categories')) {
            ?>
              <li class="<?php echo ($_GET['page'] == "categories" ? "active" : ""); ?>">
                <a href="/admin/shop/categories">Kategorien</a>
              </li>
            <?php
              }

              if ($database -> checkPrivilege($user -> id, 'statistics')) {
            ?>
              <li class="<?php echo ($_GET['page'] == "statistics" ? "active" : ""); ?>">
                <a href="/admin/shop/statistics">Statistiken</a>
              </li>
            <?php
              }
            ?>
          </ul>
        </div>
      </li>
    </ul>
  </li>
  <?php
    }

    if ($database -> checkPrivilege($user -> id, 'customer')
      || $database -> checkPrivilege($user -> id, 'tickets')) {
  ?>
  <li>
    <ul class="collapsible collapsible-accordion no-padding">
      <li class="<?php echo (($_GET['page'] == "tickets" || $_GET['page'] == "customer") ? "active" : ""); ?>">
        <a class="collapsible-header"><i class="material-icons">group</i> Kunden</a>
        <div class="collapsible-body">
          <ul>
            <?php
              if ($database -> checkPrivilege($user -> id, 'customer')) {
            ?>
              <li class="<?php echo ($_GET['page'] == "customer" ? "active" : ""); ?>">
                <a href="/admin/customer">Benutzerkonten</a>
              </li>
            <?php
              }

              if ($database -> checkPrivilege($user -> id, 'tickets')) {
            ?>
              <li class="<?php echo ($_GET['page'] == "tickets" ? "active" : ""); ?>">
                <a href="/admin/tickets">Tickets</a>
              </li>
            <?php
              }
            ?>
          </ul>
        </div>
      </li>
    </ul>
  </li>
  <?php
    }

    if ($database -> checkPrivilege($user -> id, 'news')) {
  ?>
  <li>
    <ul class="collapsible collapsible-accordion no-padding">
      <li class="<?php echo ($page == "news" ? "active" : ""); ?>">
        <a href="/admin/news" class="collapsible-header">
          <i class="material-icons">inbox</i> News
        </a>
        <div class="collapsible-body"></div>
      </li>
    </ul>
  </li>
  <?php
    }
  ?>

  <li class="divider hide-on-large-only"></li>
  <li class="hide-on-large-only">
    <ul class="collapsible collapsible-accordion no-padding">
      <li>
        <a href="/" class="collapsible-header">
          <i class="material-icons">home</i>
          Startseite
        </a>
        <div class="collapsible-body"></div>
      </li>
    </ul>
  </li>
  <li class="hide-on-large-only">
    <ul class="collapsible collapsible-accordion no-padding">
      <li>
        <a class="collapsible-header">
          <i class="material-icons">exit_to_app</i>
          Logout
        </a>
        <div class="collapsible-body"></div>
      </li>
    </ul>
  </li>
</ul>
