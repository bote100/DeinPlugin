<div class="row">
  <div class="col s12 xl6">
    <div class="card hoverable small">
      <div class="card-content">
        <span class="card-title"><i class="material-icons">euro_symbol</i> Verkäufe</span>
        <canvas id="chart_totalSells" style="width: 100%; height: 100%;"></canvas>
      </div>
    </div>
  </div>
  <div class="col s12 xl6">
    <div class="card hoverable small">
      <div class="card-content">
        <span class="card-title"><i class="material-icons">access_time</i> Verkäufe (letzten Monat)</span>
        <canvas id="chart_monthlySells" style="width: 100%; height: 100%;"></canvas>
      </div>
    </div>
  </div>
  <div class="col s12 xl6">
    <div class="card hoverable small">
      <div class="card-content">
        <span class="card-title"><i class="material-icons">pie_chart</i> Einkommen</span>
        <table>
          <tr>
            <td>Verkäufe</td>
            <td class="right-align"><?php echo number_format($database -> loadTotalProductSales(), 2, ',', ' '); ?> &euro;</td>
          </tr>
          <tr>
            <td>Verkäufe (monat)</td>
            <td class="right-align"><?php echo number_format($database -> loadMonthlyProductSales(), 2, ',', ' '); ?> &euro;</td>
          </tr>
            <tr>
              <td>Umsatz</td>
              <td class="right-align"><?php echo number_format($database -> loadTotalSales(), 2, ',', ' '); ?> &euro;</td>
            </tr>
            <tr>
              <td>Umsatz (monat)</td>
              <td class="right-align"><?php echo number_format($database -> loadMonthlySales(), 2, ',', ' '); ?> &euro;</td>
            </tr>
        </table>
      </div>
    </div>
  </div>
  <div class="col s12 xl6">
    <div class="card hoverable small">
      <div class="card-content">
        <span class="card-title"><i class="material-icons">import_contacts</i> Payment provider</span>
        <canvas id="chart_transactionSpread" style="width: 100%; height: 100%;"></canvas>
      </div>
    </div>
  </div>
  <div class="col s12">
    <div class="card hoverable">
      <div class="card-content">
        <span class="card-title"><i class="material-icons">show_chart</i> Einnahmen / Verkäufe in <b>&euro;</b></span>
        <canvas id="chart_income" style="width: 100%; height: 100%;"></canvas>
      </div>
    </div>
  </div>
</div>
