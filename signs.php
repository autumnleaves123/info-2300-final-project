<?php include('includes/init.php');
$current_page_id = "learn";

// QUERY DATABASE FOR SIGNS
// We took all of these images ourselves
$sql = "SELECT * FROM signs";
$params = array();
$records = exec_sql_query($db, $sql, $params)->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="stylesheet" type="text/css" href="styles/all.css" media="all" />
		<link rel="stylesheet" type="text/css" href="styles/tablet.css"/>
		<link rel="stylesheet" type="text/css" href="styles/mobile.css"/>

		<script src="scripts/signs.js"></script>
	  <title>Learn ASL</title>
	</head>

	<body>
	  <?php include("includes/header.php"); ?>
	  <div id='learn-div'>
	    <section class="content">
	      <h1>Learn ASL with Us</h1>
				<p id="signs-top-text">Click on a sign to toggle its animation.</p>
	      <div id='main-div'>
	        <?php if (isset($records) and !empty($records)) {
	          gallery($records);
	        } else {
	          array_push($messages, "No images found.");
	        } ?>
	      </div>
				<p id="signs-bottom-text">To find more ASL learning websites and ASL powerpoints, visit our <a class="link" href='resources.php'>Resources</a> page!</p>
	    </section>
	  </div>
	  <?php include('includes/footer.php'); ?>
	</body>
</html>
