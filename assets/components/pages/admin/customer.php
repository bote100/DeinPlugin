<?php
  if (isset($_POST['user']) && isset($_POST['balance']) && isset($_POST['email'])) {
    if (isset($_POST['privileges']))
      $database -> setPrivilegies($_POST['user'], $_POST['privileges']);
    else
      $database -> setPrivilegies($_POST['user'], array());

    $toEdit = $database -> getUserdata($_POST['user']);

    $diff = floatval($_POST['balance']) - ($toEdit -> balance);
    $database -> addTransaction('ACP', $diff, generateRandomString(24), $_POST['user'], 1);
    $database -> updateUser($_POST['user'], $_POST['balance'], $_POST['email']);

    die ('<meta http-equiv="refresh" content="0; URL=/admin/customer">');
  }
?>
<div class="row">
  <div class="col s12">
    <div class="card hoverable">
      <div class="card-content">
        <span class="card-title"><i class="material-icons">group</i> Kunden</span>
        <div class="material-table">
          <table id="datatable_customer" class="highlight">
            <thead>
              <tr>
                <th style="width: 30%;">Benutzername</th>
                <th style="width: 30%;">Email-Adresse</th>
                <th style="width: 15%;">Guthaben</th>
                <th style="width: 15%;">Aktiviert</th>
                <th style="width: 10%;"></th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th>Benutzername</th>
                <th>Email-Addresse</th>
                <th>Guthaben</th>
                <th>Aktiviert</th>
                <th></th>
              </tr>
            </tfoot>
          </table>
        </div>
        <!-- 0176 57717992 -->
      </div>
    </div>
  </div>
</div>
<form method="post">
  <input type="hidden" name="user" id="edit_id" value="0">
  <div id="modal_userDetail" class="modal modal-fixed-footer">
    <div class="modal-content">
      <h4>Kunden bearbeiten</h4>
      <div class="row">
        <div class="input-field col s12">
          <input id="edit_user" name="username" type="text" value="???" disabled>
          <label for="edit_user">Benutzername</label>
        </div>
        <div class="input-field col s12">
          <input id="edit_email" name="email" type="email" value="???@##.**">
          <label for="edit_email">EMail Adresse</label>
        </div>
        <div class="input-field col s12">
          <input id="edit_balance" name="balance" type="text" value="???.##">
          <label for="edit_balance">Guthaben</label>
        </div>
        <div class="input-field col s12">
          <select name="privileges[]" id="edit_privileges" multiple>
            <option value="" disabled selected>Keine Rechte</option>
            <option value="acp">ACP sehen</option>
            <option value="products">Produkte verwalten</option>
            <option value="categories">Kategorien verwalten</option>
            <option value="statistics">Statistiken betrachten</option>
            <option value="customer">Kundenkontos bearbeiten</option>
            <option value="tickets">Support</option>
            <option value="news">Artikel verfassen</option>
          </select>
          <label>Berechtigungen</label>
        </div>
        <p>
          <label>
            <input type="checkbox" id="edit_active" name="active" disabled />
            <span>Aktiviert</span>
          </label>
        </p>
      </div>
    </div>
    <div class="modal-footer">
      <button class="btn-flat waves-effect waves-green">Speichern</button>
      <a href="#!" class="btn-flat modal-close waves-effect waves-red">Schließen</a>
    </div>
  </div>
</form>
