<script type="text/javascript" src="/assets/js/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="/assets/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="/assets/js/materialize.min.js"></script>
<script type="text/javascript" src="/assets/js/chart.js"></script>
<script type="text/javascript">
  M.AutoInit();
  // Preloader
  $(document).ready(function() {
    $('#content').toggleClass('hide');
    $('#preloader').toggleClass('hide');
  });
</script>
<?php
if (file_exists("../assets/components/pages/admin/" . $page . "_script.php"))
  include("../assets/components/pages/admin/" . $page . "_script.php");
 ?>
