<script type="text/javascript">
  $('#datatable_news').DataTable( {
      "processing": true,
      "serverSide": true,
      "pageLength": 15,
      "order": [[0, "asc"]],
      "ajax": "/assets/datatable.php?news",
      "bAutoWidth": false,
      "columns": [
        {"data": "username"},
        {"data": "title"},
        {"data": "timestamp"},
        {"data": "text"}
      ],
      "columnDefs": [
        {
          "targets": 3,
          "orderable": false,
          "render": function ( data, type, row, meta ) {
              return '<a class="btn-floating waves-effect waves-light modal-trigger center" href="#modal_readNews" onClick="updateModal(\'' + data + '\')"><i class="material-icons white-text">search</i></a>';
          }
        }
      ]
  } );

  function updateModal(content) {
    document.getElementById("article_content").innerHTML = content;
  }
</script>
