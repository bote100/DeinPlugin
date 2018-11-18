<br>
<div class="container row">
  <div class="col s12 m4 l4">
    <h4 class="center"><i class="material-icons prefix no-select">new_releases</i> Neu</h4>
    <?php
      $product = $database -> getNewestProduct();
    ?>
    <a href="/product/<?php echo $product -> id; ?>/">
      <div class="card hoverable">
        <img class="responsive-img" src="/assets/images/products/<?php echo $product -> id; ?>.png">
        <div class="card-content black-text">
          <span class="card-title"><?php echo $product -> name; ?></span>
        </div>
      </div>
    </a>
  </div>
  <div class="col s12 m4 l4">
    <h4 class="center"><i class="material-icons prefix no-select">thumb_up</i> Beliebt</h4>
    <?php
      $product = $database -> getHypedProduct();
    ?>
    <a href="/product/<?php echo $product -> id; ?>/">
      <div class="card hoverable">
        <img class="responsive-img" src="/assets/images/products/<?php echo $product -> id; ?>.png">
        <div class="card-content black-text">
          <span class="card-title"><?php echo $product -> name; ?></span>
        </div>
      </div>
    </a>
  </div>
  <div class="col s12 m4 l4">
    <h4 class="center"><i class="material-icons prefix no-select">edit</i> Update</h4>

    <?php
      $product = $database -> getLastUpdatedProduct();
    ?>
    <a href="/product/<?php echo $product -> id; ?>/">
      <div class="card hoverable">
        <img class="responsive-img" src="/assets/images/products/<?php echo $product -> id; ?>.png">
        <div class="card-content black-text">
          <span class="card-title"><?php echo $product -> name; ?></span>
        </div>
      </div>
    </a>
  </div>
</div>

<div class="grey lighten-2">
  <div class="container row">
    <div class="col s12 m4 l4">
      <h4 class="center"><i class="material-icons no-select">group</i></h4>
      <p>Wir blicken zufrieden auf einen gro&szlig;en Kundenkreis, der auf die Qualit&auml;t unserer Produkte vertraut. Dabei ist uns die Kundenbindung besonders wichtig, wir gehen gerne auf W&uuml;nsche von unseren Kunden ein.</p>
    </div>
    <div class="col s12 m4 l4">
      <h4 class="center"><i class="material-icons no-select">fitness_center</i></h4>
      <p>Unser Shop existiert nicht erst seit gestern, daher k&ouml;nnen wir auf unsere vielseitigen Erfahrung im Verkauf von Plugins zur&uuml;ckgreifen und euch das beste f&uuml;r eurer Geld zur verf&uuml;gung stellen.</p>
    </div>
    <div class="col s12 m4 l4">
      <h4 class="center"><i class="material-icons no-select">weekend</i></h4>
      <p>Bei uns steht die Benutzerfreundlichkeit ganz oben, wir wollen auch den neueinsteigenden Entwicklern das einfache anpassen unserer Plugins erm&ouml;glichen. Wir achten auf einen &uuml;bersichtlichen Aufbau des Sourcecodes.<br><br></p>
    </div>
  </div>
</div>

<div class="container row">
  <h4><i class="material-icons prefix no-select">inbox</i> Neuigkeiten</h4>
  <br>
  <ul class="collapsible">
    <?php
      $news = $database -> loadNews(6);

      foreach ($news as $article) {
        ?>
        <li>
          <div class="collapsible-header no-select">
            <i class="material-icons">
              <?php echo ($article -> type == "update" ? "folder_open" : "insert_comment"); ?>
            </i>
            <?php echo $article -> title; ?>
            <span class="badge right"><?php echo date('d.m.Y G:i', strtotime($article -> timestamp)); ?></span>
          </div>
          <div class="collapsible-body"><span><?php echo str_replace("\n", "<br>", $article -> text); ?></span></div>
        </li>
        <?php
      }
    ?>
  </ul>
</div>
