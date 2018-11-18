<?php
  if (isset($_POST['title']) && isset($_POST['article'])) {

    $database -> addNews($user -> id, $_POST['title'], $_POST['article']);

    die('<meta http-equiv="refresh" content="0; URL=/admin/news">');
  }
?>

<div class="row">
  <div class="col s12">
    <div class="card hoverable">
      <div class="card-content">
        <span class="card-title left"><i class="material-icons">inbox</i> Neuigkeiten</span>
        <a href="#modal_newNews" class="btn waves-effect waves-light modal-trigger right">
          <i class="material-icons left">add</i> Neue Neuigkeit
        </a>
        <div class="clearfix"></div>
        <div class="material-table">
          <table id="datatable_news" class="highlight">
            <thead>
              <tr>
                <th style="width: 20%;">Author</th>
                <th style="width: 50%;">Titel</th>
                <th style="width: 20%;">Datum</th>
                <th style="width: 10%;"></th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th>Author</th>
                <th>Titel</th>
                <th>Datum</th>
                <th></th>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<form method="post">
  <div id="modal_newNews" class="modal modal-fixed-footer">
    <div class="modal-content">
      <h4>Artikel verfassen</h4>
      <div class="row">
        <div class="input-field col s12">
          <input id="title" name="title" type="text">
          <label for="title">Name</label>
        </div>
        <div class="input-field col s12">
          <textarea id="article" name="article" class="materialize-textarea"></textarea>
          <label for="article">Nachricht</label>
        </div>
      </div>
    </div>
    <div class="modal-footer">
      <button class="btn-flat waves-effect waves-green">Hinzufügen</button>
      <a href="#!" class="modal-close waves-effect waves-red btn-flat">Abbrechen</a>
    </div>
  </div>
</form>
<div id="modal_readNews" class="modal modal-fixed-footer">
  <div class="modal-content">
    <h4>Artikel lesen</h4>
    <p id="article_content"></p>
  </div>
  <div class="modal-footer">
    <a href="#!" class="modal-close waves-effect waves-red btn-flat">Schließen</a>
  </div>
</div>
