<?php
	session_start();

	require_once "assets/database.php";

  $database = new Database();
	$page = isset($_GET['page']) ? $_GET['page'] : "home";

	if (isset($_SESSION['USER_ID'])) {
		$user = $database -> getUserdata($_SESSION['USER_ID']);

		if (!$user) {
			session_destroy();
		}
	}
?>
<!DOCTYPE html>
<html lang="de">
	<?php
		include("assets/components/header.php");
	?>
  <body>
    <?php
			include("assets/components/page_navbar.php");

			include("assets/components/page_sidenav.php");
	 	?>

    <main>
      <div class="container" id="preloader">
        <div class="row center-align">
          <br><br>
          <div class="preloader-wrapper big active">
            <div class="spinner-layer spinner-blue-only">
              <div class="circle-clipper left">
                <div class="circle"></div>
              </div>
              <div class="gap-patch">
                <div class="circle"></div>
              </div>
              <div class="circle-clipper right">
                <div class="circle"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="hide" id="content">
		    <?php
					include("assets/components/pages/$page.php");
			 	?>
				
      </div>
    </main>

    <?php
			include("assets/components/page_footer.php");
	 	?>
  </body>
</html>
<?php
	$database -> close();
?>
