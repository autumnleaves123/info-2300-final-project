<?php include('includes/init.php');
$current_page_id = "admin";
$current_admin_page = "admin-resources";

// redirect user to login.php if not logged in
if ($current_user == NULL) {
	header("Location: login.php");
}

// LOGOUT
if (isset($_POST['logout-button'])) {
  log_out();
	// TODO: create a logged out page?
  header("Location: login.php");
}


?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" type="text/css" href="styles/all.css" media="all" />
	<script src="scripts/jquery-3.2.1.min.js"></script>

  <title>Admin</title>
</head>

<body>
  <?php include("includes/header.php"); ?>

	<section class="content2">
		<h1>Admin Portal</h1>

		<div class="white-background">

			<div id="admin-wrapper">

				<div id="admin-sidebar">
					<?php include("includes/admin-sidebar.php"); ?>
				</div>

				<div id="admin-content">

					<!-- Edit feed forms -->
					<h3>Add New Link</h3>
					<form>
						<button name="submit" type="submit">add new link</button>
					</form>

					<h3>Delete Existing Link</h3>
					<form>
						<button name="submit" type="submit">delete link</button>
					</form>

					<h3>Upload New PowerPoint</h3>
					<form>
						<button name="submit" type="submit">delete new powerpoint</button>
					</form>

					<h3>Delete Existing PowerPoint</h3>
					<form>
						<button name="submit" type="submit">delete powerpoint</button>
					</form>


				</div>
			</div>

		</div>


	</section>

	<?php include("includes/footer.php"); ?>
</body>
</html>
