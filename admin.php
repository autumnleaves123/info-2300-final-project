<?php include('includes/init.php');
$current_page_id = "admin";

// redirect user to login.php if not logged in
if ($current_user == NULL) {
	header("Location: login.php");
}

// LOGOUT
if (isset($_POST['logout-button'])) {
  log_out();
	// TODO: create a logged out page?
  header("Location: index.php");
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
					<ul>
						<li id="grey-out">Update</li>
						<a href="#"><li>Feed</li></a>
						<a href="#"><li>Eboard</li></a>
						<a href="#"><li>Gallery</li></a>
						<a href="#"><li>Signs</li></a>
						<a href="#"><li>Resources</li></a>
					</ul>

					<form id="logout-form" action="admin.php" method="POST">
			      <button id="logout-form-button" type="submit" name="logout-button">Log Out</button>
			    </form>
				</div>

				<div id="admin-content">

					<!-- Edit feed forms -->

					<!-- Edit eboard forms -->

					<!-- Edit gallery forms -->

					<!-- Edit signs forms -->

					<!-- Edit resources forms -->


				</div>
			</div>

		</div>


	</section>

	<?php include("includes/footer.php"); ?>
</body>
</html>
