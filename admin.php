<?php include('includes/init.php');
$current_page_id = "admin";
$current_admin_page = "admin";

const GALLERY_UPLOADS_PATH = "uploads/feed/";

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

// fetch all feeds titles
$sql = "SELECT title FROM feed";
$params = array();
$fetch_all_feed_titles = exec_sql_query($db, $sql, $params)->fetchAll();

// deleting feed posts
if (isset($_POST['delete-feed-button'])) {

	// check that feed exists

	// clear from database
	$sql = "DELETE FROM feed WHERE";
	$params = array();
	$delete_feed = exec_sql_query($db, $sql, $params);
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

					<h3>Add New Feed</h3>

					<form method="post" action="admin-feed.php" id="add-feed" name="add-feed">
						<label>Title (required)</label>
						<input type="text" placeholder="CUDAP Arch Sign" required/>

						<label>Text (required)</label>
						<textarea rows="5" cols="80" placeholder="Come to CUDAP's Arch Sign tomorrow from 9:00 to 9:30 at the Balch Arch! We'll be sharing your favorite pieces!"></textarea>

						<label>URL 1 (optional)</label>
						<input type="text" placeholder="https://bit.ly/2jJJ0ya" required/>

						<label>URL 2 (optional)</label>
						<input type="text" placeholder="https://bit.ly/2jJJ0ya" required/>

						<label>Attachment 1 (optional)</label>
						<input class="no-border" type="hidden" name="MAX_FILE_SIZE" value="<?php echo MAX_FILE_SIZE; ?>"/>
		      	<input class="no-border" type="file" name="attachment" required>

						<label>Attachment 2 (optional)</label>
						<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MAX_FILE_SIZE; ?>"/>
		      	<input class="no-border" type="file" name="attachment" required>

						<button name="submit" type="submit">add new feed</button>
					</form>

					<h3>Delete Existing Feed</h3>

					<form method="post" action="admin-feed.php" id="add-feed" name="add-feed">
						<label>Select existing feed title</label>
						<select name="feed-titles">
							<option disabled selected value> -- select a title -- </option>
							<?php
								foreach ($fetch_all_feed_titles as $feed_title) {
									echo "<option value='" . $feed_title['title'] . "'>" . $feed_title['title'] . "</option>";
								}
							?>
						</select>
						<button name="delete-feed-button" type="submit">delete feed</button>
					</form>


				</div>
				</div>
			</div>

		</div>


	</section>

	<?php include("includes/footer.php"); ?>
</body>
</html>
