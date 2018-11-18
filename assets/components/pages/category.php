<?php
  $category = $database -> getCategoryInfo($_GET['category']);
  $products = $database -> listProducts($_GET['category']);

  if (trim($category -> description) != "") {
?>
<div class="grey lighten-2">
  <br>

  <div class="container row">
    <p>
      <?php
        echo str_replace("\n", "<br>", $category -> description);
       ?>
    </p>
    <br>
  </div>
</div>
<?php
} else {
  echo '<br>';
}
?>
<div class="container row">
  <?php
    foreach ($products as $product) {
  ?>
    <a href="/product/<?php echo $product -> name; ?>">
      <div class="col s12 m6 l4">
          <div class="card hoverable">
            <div class="card-image">
              <img src="/assets/images/products/<?php echo $product -> id; ?>.png">
            </div>
            <div class="card-content">
              <p class="truncate black-text"><?php echo $product -> description; ?></p>
              <p class="back-text left black-text"><?php echo $product -> version; ?></p>
              <p class="back-text right">Nur <?php echo $product -> price; ?>&euro;</p>
            </div>
          </div>
      </div>
    </a>
  <?php
    }
  ?>
</div>
