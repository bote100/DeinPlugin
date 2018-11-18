<div class="row">
  <div class="col s12">
    <div class="card hoverable">
      <div class="card-content">
        <span class="card-title left"><i class="material-icons">storage</i> Produkte</span>
        <a href="#modal_addProduct" class="btn waves-effect waves-light modal-trigger right">
          <i class="material-icons left">add</i> Neues Produkt
        </a>
        <div class="clearfix"></div>
        <div class="material-table">
          <table id="datatable_products" class="highlight">
            <thead>
              <tr>
                <th style="width: 30%;">Name</th>
                <th style="width: 30%;">Kategorie</th>
                <th style="width: 15%;">Preis</th>
                <th style="width: 15%;">Anzeigen</th>
                <th style="width: 10%;"></th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<!--
  Modals

  Add Product
-->
  <div id="modal_addProduct" class="modal modal-fixed-footer">
    <div class="modal-content">
      <h4>Produkt hinzufügen</h4>
      <div class="row">
        <div class="input-field col s12 l6">
          <input id="new_internal_name" name="internal_name" type="text">
          <label for="new_internal_name">Interner Name</label>
        </div>
        <div class="input-field col s12 l6">
          <input id="new_display_name" name="display_name" type="text">
          <label for="new_display_name">Angezeigter Name</label>
        </div>
        <div class="input-field col s12 l8">
          <input id="new_category" name="category" class="autocomplete" type="text">
          <label for="new_category">Kategorie</label>
        </div>
        <div class="input-field col s12 l4">
          <i class="material-icons prefix">euro_symbol</i>
          <input id="new_price" name="price" type="text">
          <label for="new_price">Preis</label>
        </div>
        <div class="input-field col s12 l6">
          <input id="new_version" name="version" type="text">
          <label for="new_version">Version</label>
        </div>
        <div class="input-field col s12 l6">
          <input id="new_videoid" name="videoid" type="text">
          <label for="new_videoid">VideoID</label>
        </div>
        <div class="input-field col s12">
          <select id="new_related" multiple>
            <option disabled selected>Wähle ein Produkt</option>
            <?php
              $categories = $database -> listCategories(true);

              foreach ($categories as $category) {
                $products = $database -> listProducts($category -> name, true);
                echo '<optgroup label="' . $category -> name . '">';

                foreach ($products as $product)
                  echo '<option value="' . $product -> name
                        . '." data-icon="/assets/images/products/'
                        . $product -> name . '.png">'
                        . $product -> displayName
                        . '</option>';

                echo '</optgroup>';
              }
            ?>
          </select>
          <label>Zugehörige Produkte</label>
        </div>
        <div class="file-field input-field col s12 xl6">
          <div class="btn">
            <span>Bild</span>
            <input type="file" id="new_image" name="image" accept=".png">
          </div>
          <div class="file-path-wrapper">
            <input class="file-path" type="text">
          </div>
        </div>
        <div class="file-field input-field col s12 xl6">
          <div class="btn">
            <span>Produkt</span>
            <input type="file" id="new_product" name="product" accept=".zip">
          </div>
          <div class="file-path-wrapper">
            <input class="file-path" type="text">
          </div>
        </div>
        <div class="col s12">
          <label>
            <input type="checkbox" name="show" id="new_show" />
            <span>Gelistet</span>
          </label>
        </div>
        <div class="input-field col s12">
          <textarea id="new_description" name="description" class="materialize-textarea"></textarea>
          <label for="new_description">Bescheibung</label>
        </div>
      </div>
    </div>
    <div class="modal-footer">
      <button class="btn-flat waves-effect waves-green" onclick="uploadFile()">Hinzufügen</button>
      <a href="#!" class="modal-close waves-effect waves-red btn-flat">Abbrechen</a>
    </div>
  </div>
<div id="modal_uploadProduct" class="modal modal-fixed-footer">
  <div class="modal-content">
    <h4>Produkt hochladen</h4>
    <div class="row">
      <label>Upload</label>
      <div class="progress">
        <div class="determinate" style="width: 50%" id="progressBar"></div>
      </div>
      <blockquote id="uploadProcess">
        ...
      </blockquote>
    </div>
  </div>
  <div class="modal-footer">
    <a href="#!" class="modal-close waves-effect waves-red btn-flat">Schließen</a>
  </div>
</div>
