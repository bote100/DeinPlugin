<?php
session_start();

require_once 'database.php';

$database = new Database();

if (isset($_SESSION['USER_ID']))
  $user = $database -> getUserdata($_SESSION['USER_ID']);

if ($user == null || !$database -> checkPrivilege($user -> id, 'customer'))
  die('Keine Berechtigung');

require_once 'database.php';

if (isset($_POST['internal_name']) &&
      isset($_POST['display_name']) &&
      isset($_POST['description']) &&
      isset($_POST['category']) &&
      isset($_POST['version']) &&
      isset($_POST['videoid']) &&
      isset($_POST['related']) &&
      isset($_POST['price']) &&
      isset($_POST['show'])) {

    $database = new Database();

    if (null != $database -> getProductData($_POST['internal_name']))
      die("Das Produkt existiert bereits!");

    if (null == $database -> getCategoryInfo($_POST['category'])) {
      $database -> addCategory($_POST['category'], "", false);
      echo 'Erstelle Kategorie ' . $_POST['category'] . '<br>';
    }

    $database -> addNewProduct($_POST['internal_name'],
                               $_POST['price'],
                               $_POST['show'],
                               $_POST['display_name'],
                               $_POST['description'],
                               $_POST['category'],
                               $_POST['videoid']);
    $database -> createUpdateLog($_POST['internal_name'], $_POST['version'], $_POST['description']);

    move_uploaded_file($_FILES['image']['tmp_name'],
                      'images/products/' . $_POST["internal_name"] . '.png');
    echo 'Handle: images/products/' . $_POST["internal_name"] . '.png<br>';
    echo 'Resize image<br>';

    imagepng(
      imagescale(
        imagecreatefrompng('images/products/' . $_POST["internal_name"] . '.png'),
        848,
        480,
        IMG_BICUBIC),
      'images/products/' . $_POST["internal_name"] . '.png'
    );

    move_uploaded_file($_FILES['product']['tmp_name'],
                      'downloads/' . $_POST["internal_name"] . '_' . $_POST['version'] . '.zip');
    echo 'Handle: downloads/' . $_POST["internal_name"] . '_' . $_POST['version'] . '.zip<br>';

    $database -> close();
} else {
  echo 'Unvollständige Anfrage<br><br>' .
        'internal_name: ' . (isset($_POST['internal_name']) ? 1 : 0) . "<br>\n" .
        'display_name: ' . (isset($_POST['display_name']) ? 1 : 0) . "<br>\n" .
        'description: ' . (isset($_POST['description']) ? 1 : 0) . "<br>\n" .
        'category: ' . (isset($_POST['category']) ? 1 : 0) . "<br>\n" .
        'version: ' . (isset($_POST['version']) ? 1 : 0) . "<br>\n" .
        'videoid: ' . (isset($_POST['videoid']) ? 1 : 0) . "<br>\n" .
        'related: ' . (isset($_POST['related']) ? 1 : 0) . "<br>\n" .
        'price: ' . (isset($_POST['price']) ? 1 : 0) . "<br>\n" .
        'show: ' . (isset($_POST['show']) ? 1 : 0) . "<br>\n";
}
?>
