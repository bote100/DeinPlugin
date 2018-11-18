<?php

  if ($user == null) {
    $database -> close();
    die ('<meta http-equiv="refresh" content="0; URL=/login">');
  }

  if (isset($_POST['area']) && isset($_POST['subject']) && isset($_POST['content'])) {
    $ticketId = generateRandomString(8);

    $database -> createTicket($ticketId, $user -> id, $_POST['area'], $_POST['subject']);
    $database -> answerTicket($user -> id, $ticketId, $_POST['content']);

    die('<meta http-equiv="refresh" content="0; URL=/tickets/' . $ticketId . '">');
  }

 $products = $database -> getBoughtProducts($user -> id);
?>
<br>
<div class="container row">
  <div class="col s12 m12 l6">
    <table>
      <tr>
        <td>Benutzername:</td>
        <td>
          <?php echo $user -> username; ?>
        </td>
      </tr>
      <tr>
        <td>E-Mail:</td>
        <td><?php echo $user -> email; ?></td>
      </tr>
      <tr>
        <td>Guthaben:</td>
        <td><?php echo $user -> balance; ?> &euro;
        </td>
      </tr>
      <tr>
        <td>Produkte gekauft:</td>
        <td><?php echo sizeof($products); ?></td>
      </tr>
    </table>
  </div>
  <div class="col s12 m12 l5 offset-l1">
    <h5>Guthaben aufladen</h5>
    <br>
    <a class="waves-effect waves-light modal-trigger" href="#modal_addBalance">
      <img src="/assets/images/logo_paypal.svg" width="245" class="tooltipped" data-tooltip="Guthaben via PayPal aufladen">&nbsp;
      <img src="/assets/images/logo_paygol.png" width="245" class="tooltipped" data-tooltip="Guthaben via PayGol aufladen">
    </a>
  </div>
</div>
<div class="row grey lighten-2 z-depth-1">
  <div class="container row">
    <br>
    <h5>Support</h5>
    <div class="col s12">
      <a class="waves-effect waves-light btn modal-trigger right" href="#modal_newTicket"><i class="material-icons left">add</i>Neues Ticket</a>

      <table class="highlight">
        <thead>
          <tr>
            <th style="width: 40%;">Betreff</th>
            <th style="width: 25%;">Bereich</th>
            <th style="width: 20%;">Status</th>
            <th style="width: 10%;"></th>
          </tr>
        </thead>
        <tbody>
          <?php
            $tickets = $database -> listSupportTickets($user -> id);

            foreach ($tickets as $ticket) {
              ?>
              <tr>
                <td><?php echo $ticket -> subject; ?></td>
                <td><?php echo $ticket -> area; ?></td>
                <td>
                  <?php echo formatStatus($ticket -> status); ?>
                </td>
                <td class="center">
                  <a class="btn-floating waves-effect waves-light modal-trigger"
                     href="/tickets/<?php echo $ticket -> id; ?>">
                     <i class="material-icons white-text">search</i>
                 </a>
               </td>
              </tr>
              <?php
            }

            if (sizeof($tickets) == 0){
              echo '<tr>
                <td>Keine Supporttickets</td>
                <td></td>
                <td></td>
                <td></td>
              </tr>';
            }
          ?>
        </tbody>
      </table>
      <br>
    </div>
    <br><br>
  </div>
</div>
<div class="container row">
  <h5>Gekaufte Produkte</h5>
  <?php
    foreach ($products as $product) {
  ?>
    <div class="col s12 m12 l4">
      <a href="/product/<?php echo $product -> name; ?>/">
        <div class="card hoverable">
          <img class="responsive-img" src="/assets/images/products/<?php echo $product -> name; ?>.png">
          <div class="card-content black-text">
            <span class="card-title"><?php echo $product -> displayName; ?></span>
          </div>
        </div>
      </a>
    </div>
  <?php
    }

    if (sizeof($products) == 0) {
  ?>
    <center>Sie haben kein Plugin von uns in ihrem Besitz</center>
  <?php
    }
  ?>
</div>

<!-- Support Modal -->
<form method="post">
  <div id="modal_newTicket" class="modal modal-fixed-footer">
    <div class="modal-content">
      <h4>Neues Ticket</h4>
      <div class="row">
        <div class="input-field col s12">
          <select name="area">
            <option disabled selected>Wähle den Bereich deiner Frage</option>
            <?php
              $areas = $database -> listSupportAreas();

              foreach ($areas as $area)
                echo '<option value="' . $area -> area . '">' . $area -> display . '</option>';
            ?>
          </select>
          <label>Bereich</label>
        </div>
        <div class="input-field col s12">
          <input id="subject" name="subject" type="text" maxlength="64">
          <label for="subject">Betreff</label>
        </div>
        <div class="input-field col s12">
          <textarea id="content" name="content" class="materialize-textarea"></textarea>
          <label for="content">Inhalt</label>
        </div>
      </div>
    </div>
    <div class="modal-footer">
      <button href="#!" class="waves-effect waves-green btn-flat">Ticket erstellen</button>
      <a href="#!" class="modal-close waves-effect waves-red btn-flat">Abbrechen</a>
    </div>
  </div>
</form>
<form method="get" action="/assets/payments.php">
  <div id="modal_addBalance" class="modal modal-fixed-footer">
    <div class="modal-content">
      <h4>Guthaben aufladen</h4>
      <div class="row">
        <div class="input-field col s12">
          <input name="price" type="text" value="10.00">
          <label>Betragin &euro;</label>
        </div>
        <div class="input-field col s12">
          <select name="method">
            <option value="" disabled selected>Wähle eine Zahlungsmethode</option>
            <option value="PayPal">PayPal</option>
            <option value="PayGol">PayGol (PaysafeCard, etc.)</option>
          </select>
          <label>Berechtigungen</label>
        </div>
    </div>
  </div>
  <div class="modal-footer">
    <button class="btn-flat waves-effect waves-green">Aufladen</button>
    <a href="#!" class="btn-flat modal-close waves-effect waves-red">Abbrechen</a>
  </div>
</form>
