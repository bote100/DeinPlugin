<div class="container row">
  <br>
  <ul class="collapsible">
    <?php
      $news = $database -> loadNews(64);

      foreach ($news as $article) {
        ?>
        <li>
          <div class="collapsible-header no-select">
            <i class="material-icons">
              <?php echo ($article -> type == "update" ? "folder_open" : "insert_comment"); ?>
            </i>
            <?php echo ($article -> type == "update" ? " Update: " : "") . $article -> product; ?>
            <span class="badge right"><?php echo date('d.m.Y G:i',strtotime($article -> timestamp)); ?></span>
          </div>
          <div class="collapsible-body"><span><?php echo str_replace("\n", "<br>", $article -> text); ?></span></div>
        </li>
        <?php
      }
    ?>
  </ul>
</div>
