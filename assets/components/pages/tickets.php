<br>
<?php
  if (isset($_POST['answer'])) {
    $database -> answerTicket($user -> id, $_GET['ticket'], $_POST['answer']);
    $database -> updateTicket($_GET['ticket'], isset($_POST['close']) ? - 1 : 2);

    die('<meta http-equiv="refresh" content="0; URL=/tickets/' . $_GET['ticket'] . '">');
  }

  $ticketData = $database -> getTicketInfo($_GET['ticket']);
  $messages = $database -> getTicketContents($_GET['ticket']);
?>
<div class="container row">
  <div class="col s12 xl4">
    <div class="card hoverable">
      <div class="card-content">
        <span class="card-title"><i class="material-icons prefix">mail</i> Informationen</span>
        <table>
          <tr>
            <td>Status: </td><td><?php echo formatStatus($ticketData -> status); ?></td>
          </tr>
          <tr>
            <td>Kunde: </td><td><?php echo $user -> username; ?></td>
          </tr>
          <tr>
            <td>Thema: </td><td><?php echo $ticketData -> subject; ?></td>
          </tr>
          <tr>
            <td>Bereich: </td><td><?php echo $ticketData -> area; ?></td>
          </tr>
          <tr>
            <td>Eingegangen am: </td><td><?php echo date('d.m.Y G:i', strtotime($ticketData -> timestamp)); ?></td>
          </tr>
        </table>
      </div>
    </div>
  </div>

  <div class="col s12 xl8">
    <?php
      foreach ($messages as $message) {
    ?>
    <div class="col s12">
      <div class="card hoverable">
        <div class="card-content">
          <span class="left">
            Nachricht von <?php echo $message -> username; ?>
          </span>
          <span class="right grey-text text-darken-2"><?php echo date('d.m.Y G:i', strtotime($message -> timestamp)); ?></span>
          <div class="clearfix">&nbsp;</div>
          <p><?php echo str_replace("\n", "<br>", $message -> content); ?></p>
        </div>
      </div>
    </div>
    <?php
      }

      if ($ticketData -> status != -1) {
    ?>
    <div class="col s12">
      <div class="card hoverable">
        <div class="card-content">
          <form action="" method="post">
            <div class="input-field col s12">
              <textarea id="answer" name="answer" class="materialize-textarea"></textarea>
              <label for="answer">Antwort</label>
            </div>
            <label>
              <input type="checkbox" name="close"/>
              <span>Schlie&szlig;en</span>
            </label>
            <br><br>
            <button class="btn btn-waves-light" style="width: 100%;">Antworten</button>
          </form>
        </div>
      </div>
    </div>
    <?php
      }
    ?>
  </div>
</div>
