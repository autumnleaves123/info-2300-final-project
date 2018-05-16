<?php
include('includes/init.php');
$current_page_id = "about";
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" type="text/css" href="styles/all.css" media="all" />
	<link rel="stylesheet" type="text/css" href="styles/tablet.css"/>
	<link rel="stylesheet" type="text/css" href="styles/mobile.css"/>

  <title>Meet the Board</title>
</head>

<body>
  <?php include("includes/header.php"); ?>

  <section class="content">
    <h1>Executive Board</h1>

    <div class="white-background" id="board-wrapper">
      <?php

			// fetch president, then vice president (doesn't currently exist), then secretary, then rest of eboard
      $sql = "SELECT * FROM eboard WHERE position LIKE '%president%'";
      $params = array();
      $president = exec_sql_query($db, $sql, $params)->fetchAll();

			$sql = "SELECT * FROM eboard WHERE position LIKE '%vice%president%'";
      $params = array();
      $vicepresident = exec_sql_query($db, $sql, $params)->fetchAll();

			$sql = "SELECT * FROM eboard WHERE position LIKE '%secretary%'";
      $params = array();
      $secretary = exec_sql_query($db, $sql, $params)->fetchAll();

			$sql = "SELECT * FROM eboard WHERE position NOT LIKE '%president%' AND position NOT LIKE '%vice%president%' AND position NOT LIKE '%secretary%'";
      $params = array();
      $remaining = exec_sql_query($db, $sql, $params)->fetchAll();

			$eboard = array_merge($president, $vicepresident, $secretary, $remaining);

      $toggle = TRUE;

      if (isset($eboard) && !empty($eboard)) {
        foreach($eboard as $member) {
          $text_html = "<h2>" . strtoupper(htmlspecialchars($member["position"])) .
                        "</h2><hr/><div class = 'boardtext'><p><strong>Name: </strong>" .
                        htmlspecialchars($member['name']) .
                        "</p><p><strong>Major: </strong>" .
                        htmlspecialchars($member['major']) .
                        "</p><p><strong>Class Year: </strong>" .
                        htmlspecialchars($member['classyear']) .
                        "</p><p><strong>Bio: </strong> " .
                        htmlspecialchars($member['bio']) .
                        "</p></div>";
          $image_html = "<img alt='" . htmlspecialchars($member["image"]) . "' src='uploads/eboard/" . htmlspecialchars($member["image"]) . "'/>"; ?>
					<!-- We took all the eboard images ourselves, except the one for the alumni advisor. That particular image was provided by CUDAP, and we did some photoshop editing on it -->

          <div class='eboardFlex'>
            <div class='eboard-left'> <?php
            if ($toggle==TRUE){
              echo $text_html;
            } else {
              echo $image_html;
            } ?>
          	</div>

	          <div class='eboard-right'> <?php
	          if ($toggle==TRUE){
	            echo $image_html;
	            $toggle = FALSE;
	          } else {
	            echo $text_html;
	            $toggle = TRUE;
	          } ?>
	          </div>
					</div>

					<!-- only display this for responsive version -->
					<div id='responsive-print'>
						<div class='eboard-left'><?php echo $image_html;?></div>
						<div class='eboard-right'><?php echo $text_html;?></div>
					</div>
        	
        <?php }
      } ?>
    </div>
  </section>

  <?php include('includes/footer.php'); ?>
</body>

</html>
