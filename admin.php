<?php include('includes/init.php');
$current_page_id = "admin";

// LOGOUT
if (isset($_POST['logout-button'])) {
  log_out();
  header("Location: index.php");
}
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" type="text/css" href="styles/all.css" media="all" />

  <title>Admin</title>
</head>

<body>
  <?php include("includes/header.php"); ?>

	<section class = "content">

    <form id="login-form" action="admin.php" method="POST">
      <button id="login-form-button" type="submit" name="logout-button">Log Out</button>
    </form>
		<!-- TODO: Use flexboxes to create this page
		Left flex - admin panel
		Right flex - content will appear based on link clicked on the left (use jQuery onclick) -->

	</section>

	<?php include("includes/footer.php"); ?>
</body>
</html>
