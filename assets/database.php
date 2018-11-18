<?php
require_once 'config.php';

function generateRandomString($length = 8) {
    return substr(
            str_shuffle(
              str_repeat(
                $x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',
                ceil($length/strlen($x))
              )
            ), 1, $length);
}

function formatStatus($status) {
  switch ($status) {
    case 3:
      $content = "Warten auf Benutzer";
      break;
    case 2:
      $content = "Warten auf Antwort";
      break;
    case 1:
      $content = "Eingegangen";
      break;
    case -1:
      $content = "Geschlossen";
      break;
    default:
      $content = $status;
      break;
  }

  return $content;
}

class Database {

  private $connection = "";

  function openConnection() {
    global $config;
    global $connection;

    $connection = new mysqli($config['db_host'],
                             $config['db_user'],
                             $config['db_pass'],
                             $config['db_db']);

    if ($connection -> connect_errno) {
      die($connection -> connect_error . '');
    }

    $connection -> set_charset("utf8");
  }

  function close()
  {
    global $connection;

    if ($connection == "")
      return;

    $connection -> close();
    $connection = "";
  }

  function checkConnection()
  {
    global $connection;

    if ($connection == "")
      $this -> openConnection();
  }

  private function escapeString($toCheck) {
    global $connection;
    $this -> checkConnection();

    return $connection -> real_escape_string($toCheck);
  }

  private function executeUpdate($query) {
    global $connection;
    $this -> checkConnection();

    return $connection -> query($query);
  }

  private function loadOne($query) {
    global $connection;
    $this -> checkConnection();

    $result = $connection -> query($query);

    if (!is_bool($result)) {
      if (!($data = $result -> fetch_object()))
        $data = null;

      $result -> free();
    }

    return $data;
  }

  private function loadAll($query) {
    global $connection;
    $this -> checkConnection();
    $result = $connection -> query($query);

    if ($result -> num_rows > 0) {
      while ($content = $result -> fetch_object())
        $data[] = $content;
    } else {
      $data = null;
    }

    if (!is_bool($result))
      $result -> free();

    return $data;
  }

  function countResults($query) {
    return $this -> loadOne("SELECT
                                COUNT(*) AS `count`
                             FROM ($query) AS `temp`;") -> count;
  }

//=============================================================================

  function getNewestProduct() {
    return $this -> loadOne("SELECT `id`, `name`
                             FROM `products`
                             WHERE `show` = 1 AND `featured` = 1
                             ORDER BY `since` DESC LIMIT 1;");
  }

  function getHypedProduct() {
    $product = $this -> loadOne("SELECT
                                    `products`.`id`
                                    `products`.`name`,
                                    COUNT(DISTINCT `user`) AS `boughts`
                                 FROM `purchases`
                                 JOIN `products`
                                    ON `purchases`.`product` = `products`.`id`
                                 WHERE
                                    `purchases`.`timestamp` > SUBDATE(NOW(), INTERVAL 30 DAY) AND
                                    `products`.`show` = 1 AND
                                    `products`.`featured` = 1
                                 GROUP BY `product`
                                 ORDER BY `boughts` DESC
                                 LIMIT 1;");

    if ($product != null)
      $product = $this -> loadOne("SELECT
                                      `products`.`id`,
                                      `products`.`name`,
                                      COUNT(DISTINCT `user`) AS `boughts`
                                   FROM `purchases`
                                   JOIN `products`
                                      ON `purchases`.`product` = `products`.`id`
                                   WHERE
                                      `products`.`show` = 1 AND
                                      `products`.`featured` = 1
                                   GROUP BY `product`
                                   ORDER BY `boughts` DESC
                                   LIMIT 1;");

    return $product;
  }

  function getLastUpdatedProduct() {
    return $this -> loadOne("SELECT
                                `products`.`id`,
                                `products`.`name`
                             FROM `updates`
                             JOIN `products`
                                ON `updates`.`product` = `products`.`id`
                             WHERE
                                `show` = 1 AND
                                `featured` = 1
                             ORDER BY `updates`.`timestamp` DESC
                             LIMIT 1;");
  }

  function addCategory($name, $description, $show) {
    $description = $this -> escapeString($description);
    $name = $this -> escapeString($name);
    $show = ( $show ? 1 : 0 );

    $this -> executeUpdate("INSERT INTO `categories`
                              (`name`, `description`, `show`)
                            VALUES
                              ('$name', '$description', '$show');");
  }

  function editCategory($name, $description, $show) {
    $description = $this -> escapeString($description);
    $name = $this -> escapeString($name);
    $show = ( $show ? 1 : 0 );

    $this -> executeUpdate("UPDATE `categories`
                            SET
                                `description` = '$description',
                                `show` = '$show'
                            WHERE
                                `name` = '$name';");
  }

  function removeCategory($name) {
    $name = $this -> escapeString($name);

    $this -> executeUpdate("DELETE FROM `categories`
                            WHERE `name` = '$name';");
  }

  function listCategories($ignore) {
    return $this -> loadAll("SELECT * FROM `categories`" . ($ignore ? "" : " WHERE `show` = 1;"));
  }

  function getCategoryInfo($category) {
    $category = $this -> escapeString($category);

    return $this -> loadOne("SELECT *
                             FROM `categories`
                             WHERE `name` = '$category';");
  }

  function listProducts($category, $ignore = false) {
    $category = $this -> escapeString($category);

    return $this -> loadAll("SELECT
                                `id`,
                                `price`,
                                `name`,
                                `author`,
                                `description`
                             FROM `products`
                             WHERE
                                `category` = '$category'"
                                . ($ignore ? "" : "AND `show` = 1") . "
                            ORDER BY `featured`;");
  }

  function addNewProduct($id, $name, $type, $author, $price, $show, $description, $category, $videoId) {
    $show = ($show ? 1 : 0);
    $price = floatval($price);
    $author = intval($author);
    $name = $this -> escapeString($name);
    $videoId = $this -> escapeString($videoId);
    $id = $this -> escapeString($id);
    $category = $this -> escapeString($category);
    $description = $this -> escapeString($description);

    $this -> executeUpdate("INSERT INTO `products` (
                              `id`,
                              `name`,
                              `type`,
                              `author`,
                              `price`,
                              `featured`,
                              `show`,
                              `description`,
                              `category`,
                              `videoId`,
                              `since`)
                            VALUES (
                              '$id',
                              '$name',
                              '$type',
                              '$author',
                              '$price',
                              FALSE,
                              '$show',
                              '$description',
                              '$category',
                              '$videoId',
                              CURRENT_TIMESTAMP);");
  }

  function createUpdateLog($product, $version, $text) {
    $text = $this -> escapeString($text);
    $version = $this -> escapeString($version);
    $product = $this -> escapeString($product);

    $this -> executeUpdate("INSERT INTO `updates`(
                              `product`,
                              `version`,
                              `text`,
                              `timestamp`)
                            VALUES (
                              '$product',
                              '$version',
                              '$text',
                              CURRENT_TIMESTAMP)");
  }

  function getProductData($product) {
    $product = $this -> escapeString($product);

    return $this -> loadOne("SELECT
                                  `products`.`id`,
                                  `products`.`name`,
                                  `products`.`type`,
                                  `products`.`price`,
                                  `products`.`description`,
                                  `products`.`videoId`,
                                  `products`.`since`,
                                  `products`.`featured`,
                                  `updates`.`timestamp`,
                                  `updates`.`version`,
                                  `user`.`username` AS `author`,
                                  `user`.`id` AS `authorId`
                             FROM `products`
                             JOIN `updates`
                                ON `updates`.`product` = `products`.`id`
                             JOIN `user`
                                ON `user`.`id` = `products`.`author`
                             WHERE `products`.`id` = '$product'
                             ORDER BY `updates`.`timestamp` DESC
                             LIMIT 1 ;");
  }

  function relatedProductData($product)
  {
    $product = $this -> escapeString($product);

    return $this -> loadAll("SELECT
                                `products`.`id`,
                                `products`.`name`
                             FROM `related`
                             JOIN `products`
                                ON `products`.`id` = `related`.`related`
                             WHERE
                                `products`.`id` = '$product'
                                AND `products`.`show` = 1;");
  }

  //---------------------------------------------------------------------------

  function registerUser($username, $password, $mail, $activation) {
    $mail = $this -> escapeString($mail);
    $username = $this -> escapeString($username);
    $activation = $this -> escapeString($activation);
    $password = password_hash($password, PASSWORD_BCRYPT);

    $this -> executeUpdate("INSERT INTO `user`
                              (`id`, `username`, `balance`, `password`, `email`, `activation`)
                            VALUES
                              (NULL, '$username', 0, '$password', '$mail', '$activation');");
  }

  function getUserdata($user) {
    $userid = is_numeric($user) ? intval($user) : -1;
    $user = $this -> escapeString($user);

    return $this -> loadOne("SELECT *
                             FROM `user`
                             WHERE
                                `username` LIKE '$user' OR
                                `id` = $userid
                             LIMIT 1;");
  }

  function updateUser($userid, $balance, $email) {
    $userid = intval($userid);
    $balance = floatval($balance);
    $email = $this -> escapeString($email);

    $this -> executeUpdate("UPDATE `user`
                            SET
                                `balance` = '$balance',
                                `email` = '$email'
                            WHERE
                                `id` = $userid;");
  }

  function checkUsername($username) {
    return null == $this -> getUserdata($user);
  }

  function addBalance($provider, $transactionId) {
    $provider = $this -> escapeString($provider);
    $transactionId = $this -> escapeString($transactionId);

    $data = $this -> loadOne("SELECT `user`, `amount`
                              FROM `transactions`
                              WHERE
                                  `provider` = '$provider' AND
                                  `transactionId` = '$transactionId';");

    $this -> executeUpdate("UPDATE `user`
                            SET `balance` = `balance` + " . $data -> amount . "
                            WHERE `id` = " . $data -> user . ";");
  }

  function checkLogin($username, $password) {
    $user = $this -> getUserdata($username);

    if (!$user)
      $user = null;
    else if (!password_verify($password, $user -> password))
      $user = null;

    return $user;
  }

  function setPrivilegies($userid, $privileges) {
    $userid = intval($userid);

    $this -> executeUpdate("DELETE FROM `privileges` WHERE `user` = $userid;");

    foreach ($privileges as $privilege) {
      $privilege = $this -> escapeString($privilege);
      $this -> executeUpdate("INSERT INTO `privileges`
                                (`user`, `privilege`)
                              VALUES
                                ($userid, '$privilege')");
    }
  }

  function getPrivilegies($userid) {
    $userid = intval($userid);
    $temp =  $this -> loadAll("SELECT `privilege`
                             FROM `privileges`
                             WHERE
                                `user` = $userid;");
    foreach ($temp as $privilege)
      $privileges[] = $privilege -> privilege;

    return $privileges;
  }

  function checkPrivilege($userid, $privilege) {
    $userid = intval($userid);
    $privilege = $this -> escapeString($privilege);

    return $this -> loadOne("SELECT *
                             FROM `privileges`
                             WHERE
                                `user` = $userid AND
                                `privilege` = '$privilege'
                             LIMIT 1;");
  }

  function checkPurchase($userid, $product) {
    $userid = intval($userid);
    $product = $this -> escapeString($product);

    return $this -> loadOne("SELECT `timestamp`
                             FROM `purchases`
                             WHERE
                                `user` = $userid AND
                                `product` = '$product'
                             LIMIT 1;");
  }

  function addProduct($userid, $product, $option = 0) {
    $userid = intval($userid);
    $option = intval($option);
    $price = $product -> price;
    $product = $this -> escapeString($product -> name);

    $this -> executeUpdate("UPDATE `user`
                            SET
                              `balance` = `balance` - $price
                            WHERE
                              `id` = $userid;");
    $this -> executeUpdate("INSERT INTO `purchases` (`user`, `product`, `option`, `price`, `timestamp`)
                            VALUES ($userid, '$product', $option, $price, CURRENT_TIMESTAMP);");
  }

  function getBoughtProducts($userid) {
    global $connection;
    $this -> checkConnection();
    $userid = intval($userid);

    return $this -> loadAll("SELECT
                                `products`.`id`,
                                `products`.`name`
                             FROM `purchases`
                             JOIN `products`
                                ON `purchases`.`product` = `products`.`name`
                             WHERE `user` = $userid
                             ORDER BY `purchases`.`timestamp` DESC;");
  }

  function listSupportAreas() {
    return $this -> loadAll("SELECT * FROM `support_areas`;");
  }

  function createTicket($ticketId, $userId, $area, $subject, $status = 0) {
    $ticketId = $this -> escapeString($ticketId);
    $subject = $this -> escapeString($subject);
    $area = $this -> escapeString($area);
    $userId = intval($userId);
    $status = intval($status);

    $subject = strlen($subject) > 64 ? substr($subject, 0, 64) : $subject;
    $this -> executeUpdate("INSERT INTO `support_tickets`
                                (`id`, `user`, `area`, `subject`, `timestamp`, `status`)
                            VALUES
                                ('$ticketId', '$userId', '$area', '$subject', CURRENT_TIMESTAMP, '1');");
  }

  function updateTicket($ticketId, $status) {
    $ticketId = $this -> escapeString($ticketId);
    $status = intval($status);

    $this -> executeUpdate("UPDATE `support_tickets`
                            SET
                              `status` = '$status'
                            WHERE
                              `id` = '$ticketId';");
  }

  function answerTicket($userId, $ticketId, $content) {
    $userId = intval($userId);
    $content = $this -> escapeString($content);
    $ticketId = $this -> escapeString($ticketId);

    $this -> executeUpdate("INSERT INTO `support_contents`
                                (`ticket`, `user`, `content`, `timestamp`)
                            VALUES
                                ('$ticketId', '$userId', '$content', CURRENT_TIMESTAMP);");
  }

  function listSupportTemplates()
  {
    return $this -> loadAll("SELECT * FROM `support_templates`;");
  }

  function listSupportTickets($userid) {
    $userid = intval($userid);

    return $this -> loadAll("SELECT
                                `support_tickets`.`id`,
                                `support_tickets`.`subject`,
                                `support_tickets`.`status`,
                                `support_areas`.`display` AS `area`
                            FROM `support_tickets`
                            JOIN `support_areas`
                                ON `support_tickets`.`area` = `support_areas`.`area`
                            WHERE `user` = $userid
                            ORDER BY `status` DESC
                            LIMIT 10;");

  }

  function getTicketInfo($ticketId) {
    $ticketId = $this -> escapeString($ticketId);

    return $this -> loadOne("SELECT
                                `support_tickets`.`id`,
                                `support_tickets`.`subject`,
                                `support_tickets`.`timestamp`,
                                `support_tickets`.`status`,
                                `support_areas`.`display` AS `area`
                             FROM `support_tickets`
                             JOIN `support_areas`
                                ON `support_tickets`.`area` = `support_areas`.`area`
                             WHERE `id` = '$ticketId';");
  }

  function getTicketContents($ticketId) {
    $ticketId = $this -> escapeString($ticketId);

    return $this -> loadAll("SELECT
                            	 `user`.`username`,
                            	 `support_contents`.`content`,
                               `support_contents`.`timestamp`
                             FROM `support_contents`
                             JOIN `user`
                            	 ON `support_contents`.`user` = `user`.`id`
                             WHERE
                            	 `support_contents`.`ticket` = '$ticketId'
                             ORDER BY `support_contents`.`timestamp` ASC");
  }

  //---------------------------------------------------------------------------

  function addTransaction($provider, $amount, $transactionId, $userId, $status = 0) {
    $status = intval($status);
    $userId = intval($userId);
    $amount = floatval($amount);
    $provider = $this -> escapeString($provider);
    $transactionId = $this -> escapeString($transactionId);

    $this -> executeUpdate("INSERT INTO `transactions` (
                                `provider`,
                                `amount`,
                                `transactionId`,
                                `user`,
                                `status`,
                                `timestamp`)
                            VALUES (
                                '$provider',
                                '$amount',
                                '$transactionId',
                                '$userId',
                                $status,
                                CURRENT_TIMESTAMP);");
  }

  function editTransactionStatus($provider, $transactionId, $status) {
    $userId = intval($userId);
    $status = intval($status);
    $amount = floatval($amount);
    $provider = $this -> escapeString($provider);

    $this -> executeUpdate("UPDATE `transactions`
                            SET
                                `status` = $status,
                                `timestamp` = CURRENT_TIMESTAMP
                            WHERE
                                `transactionId` LIKE '$transactionId' AND
                                `provider` = '$provider';");
  }

  //---------------------------------------------------------------------------

  function addNews($userId, $title, $content) {
    $userId = intval($userId);
    $title = $this -> escapeString($title);
    $content = $this -> escapeString($content);

    $this -> executeUpdate("INSERT INTO `news`
                                (`author`, `title`, `text`, `timestamp`)
                            VALUES
                                ('$userId', '$title', '$content', CURRENT_TIMESTAMP)");
  }

  function loadNews($amount) {
    $amount = intval($amount);

    return $this -> loadAll("SELECT
                                `title`,
                                `text`,
                                `timestamp`, 'news' AS `type`
                             FROM `news`
                           UNION
                             SELECT
                                CONCAT('Update: ', `products`.`name`) as `title`,
                                `updates`.`text`,
                                `updates`.`timestamp`,
                                'update' AS `type`
                             FROM `updates`
                             JOIN `products`
                              ON `products`.`id` = `updates`.`product`
                             WHERE `products`.`show` = '1'
                           ORDER BY `timestamp` DESC
                           LIMIT $amount;");
  }

  //---------------------------------------------------------------------------

  function loadWeeklyPaymentStats() {
    return $this -> loadAll("SELECT
                                ROUND(SUM(`amount`), 2) AS `amount`,
                                CONCAT(YEAR(`timestamp`), ' - ', WEEK(`timestamp`)) AS `time`,
                                'transactions' AS `type`
                             FROM `transactions`
                             WHERE
                                `status` = 1 AND
                                `timestamp` > SUBDATE(NOW(), INTERVAL 1 YEAR)
                             GROUP BY `time`
                          UNION
                             SELECT
                                ROUND(SUM(`price`), 2) AS `amount`,
                                CONCAT(YEAR(`timestamp`), ' - ', WEEK(`timestamp`)) AS `time`,
                                'purchases' AS `type`
                             FROM `purchases`
                             WHERE
                                `timestamp` > SUBDATE(NOW(), INTERVAL 1 YEAR)
                             GROUP BY `time`
                          ORDER BY
                          	`type` ASC,
                          	`time` ASC");
  }

  function loadWeeklyPurchases() {
    return $this -> loadAll("SELECT
                            	 ROUND(SUM(`amount`), 2) AS `amount`,
                               CONCAT(YEAR(`timestamp`), ' - ', WEEK(`timestamp`)) AS `time`
                            FROM `transactions`
                            WHERE
                            	`status` = 1 AND
                              `timestamp` > SUBDATE(NOW(), INTERVAL 1 YEAR)
                            GROUP BY
                            	`time`
                            ORDER BY
                            	`time` ASC
                            LIMIT 52;");
  }

  function loadWeeklyStats() {
    $raw = $this -> loadRawWeeklyStats();

    foreach ($raw as $temp) {
      if ($temp -> week != $currentWeek) {
        if (!isset($currentWeek)) {
            $currentWeek = $temp -> week;
        } else {

        }
      }
    }
  }

  function loadTotalSellStats() {
    return $this -> loadAll("SELECT
                                `products`.`name`,
                                `products`.`displayName`,
                                COUNT(*) AS `count`
                             FROM `purchases`
                             JOIN `products`
                                ON `purchases`.`product` = `products`.`name`
                             GROUP BY `products`.`name`
                             ORDER BY `count` DESC;");
  }

  function loadMonthlySellStats() {
    return $this -> loadAll("SELECT
                                `products`.`name`,
                                `products`.`displayName`,
                                COUNT(*) AS `count`
                             FROM `purchases`
                             JOIN `products`
                                ON `purchases`.`product` = `products`.`name`
                             WHERE
                                `purchases`.`timestamp` > SUBDATE(NOW(), INTERVAL 1 MONTH)
                             GROUP BY `products`.`name`
                             ORDER BY `count` DESC;");
  }

  function loadMonthlyProductSales() {
    return $this -> loadOne("SELECT
                                ROUND(SUM(`price`), 2) AS `sales`
                             FROM `purchases`
                             WHERE
                                `timestamp` > SUBDATE(NOW(), INTERVAL 1 MONTH);") -> sales;
  }

  function loadTotalProductSales() {
    return $this -> loadOne("SELECT
                                ROUND(SUM(`price`), 2) AS `sales`
                             FROM `purchases`;") -> sales;
  }

  function loadMonthlySales() {
    return $this -> loadOne("SELECT
                                ROUND(SUM(`amount`), 2) AS `sales`
                             FROM `transactions`
                             WHERE
                                `timestamp` > SUBDATE(NOW(), INTERVAL 1 MONTH) AND
                                `status` = 1;") -> sales;
  }

  function loadTotalSales() {
    return $this -> loadOne("SELECT
                                ROUND(SUM(`amount`), 2) AS `sales`
                             FROM `transactions`
                             WHERE `status` = 1;") -> sales;
  }

  function loadTransactionSpread() {
    return $this -> loadAll("SELECT
                                `provider`,
                                COUNT(*) AS `transactions`
                             FROM `transactions`
                             WHERE `status` = 1
                             GROUP BY
                                `provider`;");
  }

  // ---------------------------------------------------------------------------

  public function productDataTable($request) {
    return $this -> dataTable($request,
                            array("name", "category","price", "displayName", "show"),
                            "products",
                            "");
  }

  public function customerDataTable($request) {
    return $this -> dataTable($request,
                            array("username", "email", "balance", "activation", "id"),
                            "user",
                            "");
  }
  //`author`, `title`, `text`, `timestamp`
  public function newsDataTable($request) {
    return $this -> dataTable($request,
                            array("user`.`username", "news`.`title", "news`.`timestamp", "news`.`text"),
                            "news",
                            "JOIN `user` ON `news`.`author` = `user`.`id`");
  }

  public function supportDataTable($request) {
    return $this -> dataTable($request,
                            array(
                                "user`.`username",
                                "support_areas`.`display",
                                "support_tickets`.`subject",
                                "support_tickets`.`status",
                                "support_tickets`.`timestamp",
                                "support_tickets`.`id"),
                            "support_tickets",
                            "JOIN `user` ON `support_tickets`.`user` = `user`.`id` " .
                            "JOIN `support_areas`	ON `support_tickets`.`area` = `support_areas`.`area`");
  }

  public function dataTable($request, $columns, $table, $joinInstructions) {
         $limit = '';
         if (isset($request['start']) && $request['length'] != -1)
           $limit = 'LIMIT ' . intval($request['start'])
              . ', ' . intval($request['length']);

         $where = "";
         if (isset($_GET['search']) && $_GET['search']['value'] != '') {
              $where = " WHERE ";
              $searchValue = $this -> escapeString($_GET['search']['value']);

              for($i = 0; $i < sizeof($columns); $i++)
                $where .= ($i != 0 ? "OR " : "") . " `"
                          . $columns[$i] . "` LIKE  '%$searchValue%' ";
       }

       $order = '';
       $column = '';
       if (isset($_GET['order'])
          && count($_GET['order'])
          && sizeof($columns) >= $_GET['order'][0]['column'])
         $order = "ORDER BY `" . $columns[$_GET['order'][0]['column']] . "` "
          . ($_GET['order'][0]['dir'] == 'asc' ? 'ASC' : 'DESC');

       $sql = 'SELECT ';

       for($i = 0; $i < sizeof($columns); $i++)
         $sql .= ($i != 0 ? "," : "") . " `"
                   . $columns[$i] . "`";

       $sql .= "FROM `$table` $joinInstructions $where";
       $data = $this -> loadAll($sql . ' ' . $order . ' ' . $limit . ';');

       return array (
               'draw' =>
                  isset ($request['draw']) ? intval($request['draw']) : 0,
               'recordsTotal' =>
                  intval($this -> countResults("SELECT * FROM `$table`")),
               'recordsFiltered' =>
                  intval($this -> countResults($sql)),
               'data' =>
                  $data,
               'sql' =>
                  "$sql $order $limit;"
             );
  }
}
