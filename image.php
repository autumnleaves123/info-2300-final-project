<?php include('includes/init.php');
$current_page_id = "learn";

// check to see if there is an image GET requested

if ((isset($_GET["id"]) or !empty($_GET["id"])) && sign_exists($_GET["id"])) {
  $sign_id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);
} else {
  header("Location: signs.php");
  exit;
}

// QUERY DATABASE
$sql = "SELECT * FROM signs WHERE signs.id = :sign_id";
$params = array(":sign_id"=>$sign_id);
$sign_records = exec_sql_query($db, $sql, $params)->fetchAll();
?>

<!DOCTYPE html>
<html>

  <head>
		<meta charset="UTF-8" />
	  <meta name="viewport" content="width=device-width, initial-scale=1" />
	  <link rel="stylesheet" type="text/css" href="styles/all.css" media="all" />
		<link rel="stylesheet" type="text/css" href="styles/tablet.css"/>
		<link rel="stylesheet" type="text/css" href="styles/mobile.css"/>

    <title>Image View</title>
  </head>

  <body>
    <?php include("includes/header.php"); ?>

    <section class = "content single-view">
      <?php
      if (isset($sign_records) and !empty($sign_records)) {
        single_view($sign_records);
      } else {
        array_push($messages, "Not a valid image view.");
      }
      ?>
    </section>

    <?php include("includes/footer.php"); ?>
  </body>
</html>
