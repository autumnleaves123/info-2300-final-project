<?php
include('includes/init.php');

$current_page_id = "about";

// Fetch eboard array

?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" type="text/css" href="styles/all.css" media="all" />

  <title>Meet the Board</title>
</head>

<body>
  <?php include("includes/header.php"); ?>

	<section class="content2">
		<h1>Executive Board</h1>
		<!-- TODO: create a div class for each person
		Each div contains photo, name, title etc.
		Pull info from database array above (php code) -->
    <div id="eboardFlex">
    <?php

      $sql = "SELECT * FROM eboard";
      $params = array();
      $eboard = exec_sql_query($db, $sql, $params);
      if (isset($eboard) && !empty($eboard)) {
        foreach($eboard as $member) {
          echo "<div class = 'memberimage'>";
          echo "<div><img alt='" . htmlspecialchars($member["image"]) . "' src='uploads/eboard/" . htmlspecialchars($member["image"]) . "'/>";
          echo "<h2>" . htmlspecialchars($member["position"]) . "</h2><hr/><div class = 'boardtext'><p><strong>Name: </strong>" . htmlspecialchars($member['name']) . "</p><p><strong>Major: </strong>" . htmlspecialchars($member['major']) . "</p><p><strong>Class Year: </strong>" . htmlspecialchars($member['classyear']) . "</p><p><strong>Bio: </strong> " . htmlspecialchars($member['bio']) . "</p></div></div></div>";
        }
      }
    ?>
    </div>
	</section>

  <?php include('includes/footer.php'); ?>
</body>

</html>
