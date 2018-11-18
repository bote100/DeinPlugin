<script type="text/javascript">
  $('#datatable_customer').DataTable( {
      "processing": true,
      "serverSide": true,
      "pageLength": 15,
      "order": [[0, "asc"]],
      "ajax": "/assets/ajax.php?customer",
      "bAutoWidth": false,
      "columns": [
        {"data": "username"},
        {"data": "email"},
        {"data": "balance"},
        {"data": "activation"},
        {"data": "id"}
      ],
      "columnDefs": [
        {
          "targets": 2,
          "render": function ( data, type, row, meta ) {
              return data + ' &euro;';
          }
        },
        {
          "targets": 4,
          "orderable": false,
          "render": function ( data, type, row, meta ) {
              return '<a class="btn-floating waves-effect waves-light modal-trigger center" href="#modal_userDetail" onclick="updateCustomerModal(\'' + data + '\')"><i class="material-icons white-text">search</i></a>';
          }
        }
      ]
  } );

  function updateCustomerModal(userId) {
    $.ajax({
      type: 'GET',
      url: '/assets/ajax.php',
      data: 'customer-detail&id=' + userId,
      success: function(message) {
          console.log(message);

          $('#edit_id').val(userId);
          $('#edit_user').val(message.username);
          $('#edit_email').val(message.email);
          $('#edit_balance').val(message.balance);
          $('#edit_active').prop("checked", message.activation == '');
          $('#edit_privileges').val(message.privileges);

          M.updateTextFields();
      }
    });
  }
</script>
