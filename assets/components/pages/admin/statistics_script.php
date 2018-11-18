<script type="text/javascript">
  //
  //  Total Sells
  //
  <?php
    $data = $database -> loadTotalSellStats();
  ?>
  new Chart(document.getElementById("chart_totalSells"), {
    type: 'doughnut',
    data: {
      labels: [
        <?php
          for ($i = 0; $i < sizeof($data); $i ++)
            echo ($i != 0 ? ',' : '') . '"' . $data[$i] -> displayName . '"';
        ?>
      ],
      datasets: [
        {
          label: "Käufe",
          backgroundColor: [
            <?php
              for ($i = 0; $i < sizeof($data); $i ++)
                echo ($i != 0 ? ',' : '') . '"#' . dechex(rand(0x000000, 0xFFFFFF)) . '"';
            ?>
          ],
          data: [
            <?php
              for ($i = 0; $i < sizeof($data); $i ++)
                echo ($i != 0 ? ',' : '') . $data[$i] -> count;
            ?>
          ]
        }
      ]
    }
  });

  //
  //  Monthly Sells
  //
  <?php
    $data = $database -> loadMonthlySellStats();
  ?>
  new Chart(document.getElementById("chart_monthlySells"), {
    type: 'doughnut',
    data: {
      labels: [
        <?php
          for ($i = 0; $i < sizeof($data); $i ++)
            echo ($i != 0 ? ',' : '') . '"' . $data[$i] -> displayName . '"';
        ?>
      ],
      datasets: [
        {
          label: "Käufe",
          backgroundColor: [
            <?php
              for ($i = 0; $i < sizeof($data); $i ++)
                echo ($i != 0 ? ',' : '') . '"#' . dechex(rand(0x000000, 0xFFFFFF)) . '"';
            ?>
          ],
          data: [
            <?php
              for ($i = 0; $i < sizeof($data); $i ++)
                echo ($i != 0 ? ',' : '') . $data[$i] -> count;
            ?>
          ]
        }
      ]
    }
  });

  //
  //  TransactionSpread
  //
  <?php
    $data = $database -> loadTransactionSpread();
  ?>
  new Chart(document.getElementById("chart_transactionSpread"), {
    type: 'doughnut',
    data: {
      labels: [
        <?php
          for ($i = 0; $i < sizeof($data); $i ++)
            echo ($i != 0 ? ',' : '') . '"' . $data[$i] -> provider . '"';
        ?>
      ],
      datasets: [
        {
          label: "Payment provider",
          backgroundColor: [
            <?php
              for ($i = 0; $i < sizeof($data); $i ++)
                echo ($i != 0 ? ',' : '') . '"#' . dechex(rand(0x000000, 0xFFFFFF)) . '"';
            ?>
          ],
          data: [
            <?php
              for ($i = 0; $i < sizeof($data); $i ++)
                echo ($i != 0 ? ',' : '') . $data[$i] -> transactions;
            ?>
          ]
        }
      ]
    }
  });

  //
  //  TransactionSpread
  //
  <?php
    $raw = $database -> loadWeeklyPaymentStats();
    $data = array();
    $week = date('W');
    $year = date('Y') - 1;

    for ($i = 0; $i <= 52; $i ++) {
      $week ++;

      if ($week == 53) {
        $week = 1;
        $year ++;
      }

      $labels[] = 'Woche ' . $week . ' ' . $year;
      $transactions[] = 0;
      $purchases[] = 0;
    }

    $type = '';
    $i = 0;
    echo "/* " . json_encode($raw) . "*/\n";
    foreach($raw as $temp) {
      if ($type != $temp -> type) {
        echo "//" . $temp -> type . "\n";
        $type = $temp -> type;
        $week = date('W');
        $year = date('Y') - 1;
        $i = 0;
      }

      while ($temp -> time != ($year . ' - ' . $week) && $i < 52) {
          $week ++;

          if ($week >= 53) {
            $week = 1;
            $year ++;
          }

          $i ++;
      }

      if (($year . ' - ' . $week) == $temp -> time) {
        if ($type == 'purchases')
          $purchases[$i] = floatval($temp -> amount);
        else if ($type == 'transactions')
          $transactions[$i] = floatval($temp -> amount);
      }
    }
  ?>
  new Chart(document.getElementById("chart_income"), {
    type: 'line',
    data: {
      labels:
        <?php
           echo json_encode($labels);
        ?>,
      datasets: [{
          data: <?php
             echo json_encode($transactions);
          ?>,
          label: "Einnahmen",
          borderColor: "#3e95cd",
          fill: false
        }, {
          data: <?php
             echo json_encode($purchases);
          ?>,
          label: "Verkäufe",
          borderColor: "#FF7F50",
          fill: false
        }
      ]
    }
  });
</script>
