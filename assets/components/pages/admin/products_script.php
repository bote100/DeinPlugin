<script type="text/javascript">
  var instance = M.Autocomplete.getInstance(document.getElementById('new_category'));
  instance.updateData({
    <?php
      $categories = $database -> listCategories(true);

      for ($i = 0; $i < sizeof($categories); $i ++)
        echo  ($i != 0 ? ',' : '') . '"' . $categories[$i] -> name . '": null';
    ?>
  });

  $('#datatable_products').DataTable( {
      "processing": true,
      "serverSide": true,
      "pageLength": 15,
      "order": [[0, "asc"]],
      "ajax": "/assets/ajax.php?products",
      "bAutoWidth": false,
      "columns": [
        {"data": "displayName"},
        {"data": "category"},
        {"data": "price"},
        {"data": "show"},
        {"data": "name"}
      ],
      "columnDefs": [
        {
          "targets": 3,
          "render": function ( data, type, row, meta ) {
              return (data == 1 ? 'Ja' : 'Nein');
          }
        },
        {
          "targets": 4,
          "orderable": false,
          "render": function ( data, type, row, meta ) {
              return '<a class="btn-floating waves-effect waves-light modal-trigger center" href="#player_detail" onclick="updatePlayerModal(\'' + data + '\')"><i class="material-icons white-text">search</i></a>';
          }
        }
      ]
  } );
</script>
<script>
function uploadFile() {
	var file = document.getElementById("new_product").files[0];
	var image = document.getElementById("new_image").files[0];

	var formdata = new FormData();
	formdata.append("image", image);
	formdata.append("product", file);
	formdata.append("show", document.getElementById("new_show").checked);
  formdata.append("price", document.getElementById("new_price").value);
  formdata.append("videoid", document.getElementById("new_videoid").value);
  formdata.append("version", document.getElementById("new_version").value);
  formdata.append("category", document.getElementById("new_category").value);
  formdata.append("related[]", document.getElementById("new_related").value);
  formdata.append("description", document.getElementById("new_description").value);
  formdata.append("display_name", document.getElementById("new_display_name").value);
  formdata.append("internal_name", document.getElementById("new_internal_name").value);

	var ajax = new XMLHttpRequest();
	ajax.upload.addEventListener("progress", progressHandler, false);
	ajax.addEventListener("load", completeHandler, false);
	ajax.addEventListener("error", errorHandler, false);
	ajax.addEventListener("abort", abortHandler, false);
	ajax.open("POST", "/assets/upload.php");
	ajax.send(formdata);

  M.Modal.getInstance(document.getElementById("modal_addProduct")).close();
  M.Modal.getInstance(document.getElementById("modal_uploadProduct")).open();
}

function progressHandler(event) {
  var percent = Math.round(event.loaded / event.total * 100);
	document.getElementById("progressBar").style.width = percent + "%";
	document.getElementById("uploadProcess").innerHTML = percent + " Prozent hochgeladen<br>" + (Math.ceil(event.loaded / 10000) / 100)  + " / " +  (Math.ceil(event.total / 10000) / 100) + " MB";
}

function completeHandler(event) {
  document.getElementById("progressBar").style.width = "100%";
	document.getElementById("uploadProcess").innerHTML = "Upload complete <br>" + event.target.responseText;
}

function errorHandler(event) {
	document.getElementById("uploadProcess").innerHTML = "Upload Failed";
}

function abortHandler(event) {
	document.getElementById("uploadProcess").innerHTML = "Upload Aborted";
}
</script>
