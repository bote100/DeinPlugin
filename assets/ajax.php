<?php
  session_start();
  header('Content-Type: application/json');

  require_once 'database.php';

  $database = new Database();

  if (isset($_SESSION['USER_ID']))
		$user = $database -> getUserdata($_SESSION['USER_ID']);

	if ($user == null || !$database -> checkPrivilege($user -> id, 'acp')) {
		echo json_encode(array("error" => 1, "message" => "Not Authenticated", "user" => $SESSION['USER_ID']));
	} else {
    if (isset($_GET['products'])) {
      if ($database -> checkPrivilege($user -> id, 'products'))
        echo json_encode($database -> productDataTable($_GET));
      else
        echo json_encode(array("error" => 2, "message" => "No Permission", "user" => $user -> id));
    } else if (isset($_GET['customer'])) {
      if ($database -> checkPrivilege($user -> id, 'customer'))
        echo json_encode($database -> customerDataTable($_GET));
      else
        echo json_encode(array("error" => 2, "message" => "No Permission", "user" => $user -> id));
    } else if (isset($_GET['customer-detail'])) {
      if ($database -> checkPrivilege($user -> id, 'customer')) {
        $customer = $database -> getUserdata($_GET['id']);
        echo json_encode(array(
          "username" => $customer -> username,
          "email" => $customer -> email,
          "balance" => $customer -> balance,
          "activation" => $customer -> activation,
          "privileges" =>$database -> getPrivilegies($customer -> id)
        ));
      } else
        echo json_encode(array("error" => 2, "message" => "No Permission", "user" => $user -> id));
    } else if (isset($_GET['tickets'])) {
      if ($database -> checkPrivilege($user -> id, 'tickets'))
        echo json_encode($database -> supportDataTable($_GET));
      else
        echo json_encode(array("error" => 2, "message" => "No Permission", "user" => $user -> id));
    } else if (isset($_GET['news'])) {
      if ($database -> checkPrivilege($user -> id, 'news'))
        echo json_encode($database -> newsDataTable($_GET));
      else
        echo json_encode(array("error" => 2, "message" => "No Permission", "user" => $user -> id));
    }
  }
$database -> close();
