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
<html lang="en">

<head>
	<?php include('includes/head.php'); ?>
  <title>Resources</title>
</head>

<body>
  <?php include("includes/header.php"); ?>
  <section class="content">
		<h1>Resources</h1>

		<div class="white-background resource-div">
      <div class="resource-flex-left resource-padding">
        <p>See the links below to learn ASL:</p><br>
          <?php if (isset($links) && !empty($links)) {
            foreach ($links as $link) {
            ?>
            <div class="indent"><a href="<?php echo htmlspecialchars($link['url']); ?>" target="_blank"><?php echo htmlspecialchars($link['name']); ?></a></div>
          <?php }
        } ?>
      </div>

      <div class="resource-flex-right resource-padding">
  	    <p>Click on the links below to view our learning ASL Powerpoints and Docs:</p>
          <?php if (isset($ppts) && !empty($ppts)) {
            foreach ($ppts as $ppt) {
            ?>
            <div class="indent"><a href="<?php echo htmlspecialchars($ppt['link']); ?>" target="_blank"><?php echo ucwords(htmlspecialchars($ppt['label'])); ?></a></div>
          <?php }
        } ?>
      </div>
		</div>
  </section>
  <?php include('includes/footer.php'); ?>

</body>
</html>
