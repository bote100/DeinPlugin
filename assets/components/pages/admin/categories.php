<?php
  if (isset($_GET['delete'])) {
    $database -> removeCategory($_GET['delete']);

    die('<meta http-equiv="refresh" content="0; URL=/admin/shop/categories">');
  } else if (isset($_POST['add']) && isset($_POST['name'])) {
    $database -> addCategory($_POST['name'],
                            isset($_POST['description']) ? $_POST['description'] : "",
                            isset($_POST['show']));

    die('<meta http-equiv="refresh" content="0; URL=/admin/shop/categories">');
  } else if (isset($_POST['edit']) && isset($_POST['category'])) {
    $database -> editCategory($_POST['category'],
                            isset($_POST['description']) ? $_POST['description'] : "",
                            isset($_POST['show']));

    die('<meta http-equiv="refresh" content="0; URL=/admin/shop/categories">');
  }
?>
<br>
<div class="row">
  <div class="col s12">
    <a href="#modal_addCategory" class="btn waves-effect waves-light modal-trigger right">
      <i class="material-icons left">add</i> Neue Kategorie
    </a>
    <div class="clearfix"></div>
    <br>
  </div>
  <div class="col s12">
    <ul class="collapsible">
      <?php
        $categories = $database -> listCategories(true);
        foreach ($categories as $category) {
      ?>
      <li>
        <div class="collapsible-header no-select"><?php echo $category -> name; ?></div>
        <div class="collapsible-body">
          <span>
            <form method="post">
              <input type="hidden" name="edit" value="1">
              <input type="hidden" name="category" value="<?php echo $category -> name; ?>">
              <div class="row">
                <div class="input-field col s12">
                  <textarea id="description_<?php echo $category -> name; ?>" name="description" class="materialize-textarea"><?php echo trim($category -> description); ?></textarea>
                  <label for="description_<?php echo $category -> name; ?>">Beschreibung</label>
                </div>
                <div class="col s12">
                  <label>
                    <input type="checkbox" name="show" <?php echo ($category -> show ? 'checked="checked"' : '') ?> />
                    <span>Gelistet</span>
                  </label>
                </div>
                <div class="col s12 center">
                  <button class="btn">
                    <i class="material-icons left">save</i> Speichern
                  </button>
                  <a class="btn red" href="/admin/shop/categories?delete=<?php echo $category -> name; ?>">
                    <i class="material-icons left">delete</i> Löschen
                  </a>
                </div>
              </div>
            </form>
          </span>
        </div>
      </li>
      <?php
        }
      ?>
    </ul>
  </div>
</div>
<!--
  Modals

  Add Category
-->
<form method="post">
  <div id="modal_addCategory" class="modal modal-fixed-footer">
    <input type="hidden" name="add" value="1">
    <div class="modal-content">
      <h4>Kategorie hinzufügen</h4>
      <div class="row">
        <div class="input-field col s12">
          <input id="name" name="name" type="text">
          <label for="name">Name</label>
        </div>
        <div class="col s12">
          <label>
            <input type="checkbox" name="show" />
            <span>Gelistet</span>
          </label>
        </div>
        <div class="input-field col s12">
          <textarea id="description" name="description" class="materialize-textarea"></textarea>
          <label for="description">Bescheibung</label>
        </div>
      </div>
    </div>
    <div class="modal-footer">
      <button class="btn-flat waves-effect waves-green">Hinzufügen</button>
      <a href="#!" class="modal-close waves-effect waves-red btn-flat">Abbrechen</a>
    </div>
  </div>
</form>
