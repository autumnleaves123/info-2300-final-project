<?php include('includes/init.php');
$current_page_id = "learn";

$sql = "SELECT * FROM links";
$params = array();
$links = exec_sql_query($db, $sql, $params);

$sql = "SELECT * FROM ppts";
$params = array();
$ppts = exec_sql_query($db, $sql, $params);

?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" type="text/css" href="styles/all.css" media="all" />

  <title>Resources</title>
</head>

<body>
  <?php include("includes/header.php"); ?>
  <section class="content2">
		<h1>Resources</h1>

		<div class="white-background resource-div">
      <div class="flex-left resource-padding">
        <p>See the links below to learn ASL:<br></br>
          <?php if (isset($links) && !empty($links)) {
            foreach ($links as $link) {
            ?>
            <div class="indent"><a href=<?php echo htmlspecialchars($link['url']); ?> target="_blank"><?php echo htmlspecialchars($link['name']); ?></a></div>
          <?php }
        } ?>
  	    </p>
      </div>
      <div class="flex-right resource-padding">
  	    <p>Click on the links below to view our learning ASL Powerpoints and Docs:
          <?php if (isset($ppts) && !empty($ppts)) {
            foreach ($ppts as $ppt) {
            ?>
            <div class="indent"><a href=<?php echo htmlspecialchars($ppt['link']); ?>><?php echo ucwords(htmlspecialchars($ppt['label'])); ?></a><br/></div>
          <?php }
        } ?>
  	    </p>
      </div>
		</div>
  </section>

  <?php include('includes/footer.php'); ?>

</body>
</html>
