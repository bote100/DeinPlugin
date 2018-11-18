<script type="text/javascript">
  $('#datatable_tickets').DataTable( {
      "processing": true,
      "serverSide": true,
      "pageLength": 15,
      "order": [[3, "desc"]],
      "ajax": "/assets/datatable.php?tickets",
      "bAutoWidth": false,
      "columns": [
        {"data": "username"},
        {"data": "display"},
        {"data": "subject"},
        {"data": "status"},
        {"data": "timestamp"},
        {"data": "id"}
      ],
      "columnDefs": [
        {
          "targets": 3,
          "render": function ( data, type, row, meta ) {
              switch (data) {
                case '-1':
                  return "Geschlossen";
                case '1':
                  return "Eingegangen";
                case '2':
                  return "Beantworten";
                case '3':
                  return "Benutzerantwort";
                default:
                  return data;
              }

              return data;
          }
        },
        {
          "targets": 5,
          "orderable": false,
          "render": function ( data, type, row, meta ) {
              return '<a class="btn-floating waves-effect waves-light modal-trigger center" href="/admin/ticket/' + data + '"><i class="material-icons white-text">mode_edit</i></a>';
          }
        }
      ]
  } );
</script>
