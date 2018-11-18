<?php
  $product = $database -> getProductData($_REQUEST['product']);

  if (isset($_POST['agb']) && isset($_REQUEST['product'])) {
    if (!($database -> checkPurchase($user -> id, $product -> id))) {
      if ($user -> balance >= $product -> price) {
        $database -> addProduct($user -> id, $product);
      }
    }

    die ('<meta http-equiv="refresh" content="0; URL=/product/' . $_REQUEST['product'] . '/">');
  }

  if ($product == null)
    die ("404");
?>
<br>
<div class="container row">
  <div class="col s12 m12 l6">
    <p class="flow-text">
      <img class="responsive-img" src="/assets/images/products/<?php echo $product -> id; ?>.png" />
      <br>
    </p>
  </div>
  <div class="col s12 m12 l6">
    <p><?php echo str_replace("\n", "<br>", $product -> description); ?></p>
  </div>
</div>
<div class="grey lighten-2">
  <div class="container row">
    <div class="col s12 m12 l6">
      <br>
      <table>
        <tr><td>Preis:</td><td><?php echo $product -> price; ?> &euro;</td></tr>
        <tr><td>Version:</td><td><?php echo $product -> version; ?></td></tr>
        <tr><td>Aktualisiert am:</td><td><?php echo $product -> timestamp; ?></td></tr>
        <tr><td>Programmiert von:</td><td><?php echo $product -> author; ?></td></tr>
      </table>
      <br>

      <?php
        if ($user == null || !($database -> checkPurchase($user -> id, $product -> id))) {
      ?>
        <a class="waves-effect waves-light btn modal-trigger" href="#purchaseModal" style="width: 100%;">Kostenpflichtig kaufen</a>
      <?php
        } else {
      ?>
        <a class="waves-effect waves-light btn" id="download" href="/download/<?php echo $product -> id; ?>.zip" style="width: 100%;">Herunterladen</a>
      <?php
        }
      ?>
    </div>
    <div class="col s12 m12 l6">
      <br>
      <div class="video-container">
        <iframe width="853" height="480" src="https://www.youtube-nocookie.com/embed/<?php echo $product -> videoId; ?>?rel=0" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
      </div>
      <br>
    </div>
  </div>
</div>
<?php
  $related = $database -> relatedProductData($_GET['product']);
  if ($related) {
?>
<div class="container row">
  <h5>Wird oft mit folgendem gekauft</h5>
    <?php
      foreach ($related as $products) {
    ?>
    <div class="col s12 m12 l4">
      <a href="/product/<?php echo $products -> name; ?>/">
        <div class="card hoverable">
          <img class="responsive-img" src="/assets/images/products/<?php echo $products -> id; ?>.png">
          <div class="card-content black-text">
            <span class="card-title"><?php echo $products -> name; ?></span>
          </div>
        </div>
      </a>
    </div>
    <?php
      }
    ?>
</div>
<?php
  }
?>
<div id="purchaseModal" class="modal">
  <form method="post">
    <input type="hidden" name="product" value="<?php echo $product -> name; ?>">
    <div class="modal-content">
      <h4>Kaufen</h4>
      <?php
        if ($user != null) {
      ?>
        <p>Sie sind dabei, durch den Kauf von dem Proukt "<?php echo $product -> displayName; ?>" ihr Kundenkonto mit &euro; <?php echo $product -> price; ?> zu belasten<br></p>
        <p>
          <label>
            <input type="checkbox" name="agb" />
            <span>Ich habe die AGB gelesen und akzeptiere diese</span>
          </label>
        </p>
      <?php
        } else {
      ?>
        <p>Sie m&uuml;ssen ein Kundenkonto erstellen, um ein Produkt zu kaufen.</p>
      <?php
        }
      ?>
    </div>
    <div class="modal-footer">
      <?php
        if ($user != null) {
          if ($user -> balance < $product -> price) {
      ?>
          <a href="#!" class="modal-close waves-effect waves-green btn-flat tooltipped" data-tooltip="Dir fehlen <?php echo ($product -> price - $user -> balance); ?>&euro;">Guthaben aufladen</a>
        <?php
          } else {
        ?>
          <button href="#!" class="modal-close waves-effect waves-green btn-flat">Kostenpflichtig bestellen</button>
        <?php
          }
        ?>
          <a href="#!" class="modal-close waves-effect waves-red btn-flat">Abbrechen</a>
      <?php
        } else {
      ?>
        <a href="/register" class="waves-effect waves-green btn-flat">Kundenkonto erstellen</button>
        <a href="#!" class="modal-close waves-effect waves-red btn-flat">Abbrechen</a>
      <?php
        }
      ?>
    </div>
  </form>
</div>
