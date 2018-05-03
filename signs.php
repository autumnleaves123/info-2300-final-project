<?php include('includes/init.php');
$current_page_id = "learn";

// QUERY DATABASE FOR SIGNS
$sql = "SELECT * FROM signs";
$params = array();
$records = exec_sql_query($db, $sql, $params)->fetchAll();
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" type="text/css" href="styles/all.css" media="all" />

  <title>Learn ASL</title>
</head>

<body>
  <?php include("includes/header.php"); ?>
  <section class="content2">
		<h1>Learn ASL with Us</h1>

			<!-- Bethany to Autumn: So sorry! I couldn't seem to revert your signs page back to what it originally looked like after changing the css background! -->

			<div>
		      <?php
		        if (isset($records) and !empty($records)) {
		          gallery($records);
		        } else {
		          array_push($messages, "No images found.");
		        }
		      ?>
			 </div>

	</section>

  <?php include('includes/footer.php'); ?>

</body>
</html>
