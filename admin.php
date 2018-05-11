<?php include('includes/init.php');
$current_page_id = "admin";
$current_admin_page = "admin";

const GALLERY_UPLOADS_PATH = "uploads/feed/";

// redirect user to login.php if not logged in
if ($current_user == NULL) {
	header("Location: login.php");
}

/*
adding feed posts
retrieves all the parameters from the form and sanitizes them
adds the information into a database entry
if a user includes attachments, add those to uploads/feed folder
if any part fails, return message saying that the user is unable to add a new feed post
*/
if (isset($_POST['add-feed-button'])) {

	// grab all parameters and sanitize
	$title = filter_input(INPUT_POST, 'feed-title', FILTER_SANITIZE_STRING);
	$title = trim($title);

	$feed_text = filter_input(INPUT_POST, 'feed-text', FILTER_SANITIZE_STRING);
	$feed_text = trim($text);

	$url1 = filter_input(INPUT_POST, 'feed-url-1', FILTER_SANITIZE_STRING);
	$url1 = trim($url1);

	$url2 = filter_INPUT(INPUT_POST, 'feed-url-2', FILTER_SANITIZE_STRING);
	$url2 = trim($url2);

	// capture datetime
	$date_today = date("F j, Y");

	// file processing
	$file_1 = $_FILES["feed-file-1"];
	$file_2 = $_FILES["feed-file-2"];

	if ($file_1['error'] == UPLOAD_ERR_OK) {
		// no upload errors
		$file_1_name = basename($file_1["name"]);
		$file_1_ext = strtolower(pathinfo($file_1_name, PATHINFO_EXTENSION));
	} else {
		record_message("Failed to upload file.");
		return;
	}

	if ($file_2['error'] == UPLOAD_ERR_OK) {
		// no upload errors
		$file_2_name = basename($file_2["name"]);
		$file_2_ext = strtolower(pathinfo($file_2_name, PATHINFO_EXTENSION));
	} else {
		record_message("Failed to upload file.");
		return;
	}

	// insert data into database
	$sql = "INSERT INTO feed (title, entry_date, content, file_name, file_ext, file_name_2, file_ext_2, url1, url2) VALUES (:title, :date_today, :feed_text)";
	$params = array(
		':title' => $title,
		':date_today' => $date_today,
		':feed_text' => $feed_text
	);
	$add_feed = exec_sql_query($db, $sql, $params);

	// move file to uploads/feed folder


	record_message("Successfully added post!");

} else {
	record_message("Failed to add new post.");
}


/*
deleting feed posts
check that the feed selected exists
delete post from the database
*/
if (isset($_POST['delete-feed-button'])) {

	$title_to_delete = filter_input(INPUT_POST, 'feed-titles', FILTER_SANITIZE_STRING);

	// get feed id and check that it exists
	$sql = "SELECT id FROM feed WHERE title = :title_to_delete";
	$params = array(':title_to_delete' => $title_to_delete);
	$fetch_feed_id = exec_sql_query($db, $sql, $params)->fetchAll();

	if ($fetch_feed_id) {
		// feed exists, clear from database
		$feed_id = $fetch_feed_id[0]['id'];
		$sql = "DELETE FROM feed WHERE id = :feed_id";
		$params = array(':feed_id' => $feed_id);
		$delete_feed = exec_sql_query($db, $sql, $params);

		// check to see if there are attachments linked to this post in feed_attachments and feed_to_feed_attachments


		record_message("Successfully deleted feed.");

	} else {
		// feed doesn't exist
		record_message("Please select an existing feed from the dropdown menu.");
	}

} else {
	record_message("Failed to delete post.");
}

?>

<!DOCTYPE html>
<html lang="en">

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
				<div id="admin-sidebar"><?php include("includes/admin-sidebar.php"); ?></div>

				<div id="admin-content">

					<h3>Add New Post</h3>
					<form method="post" action="admin.php" id="add-feed" name="add-feed">
						<label>Title (required)</label>
						<input type="text" name="feed-title" placeholder="CUDAP Arch Sign" required/>

						<label>Text (required)</label>
						<textarea name="feed-text" rows="5" cols="80" placeholder="Come to CUDAP's Arch Sign tomorrow from 9:00 to 9:30 at the Balch Arch! We'll be sharing your favorite pieces!"></textarea>

						<label>URL 1 (optional)</label>
						<input type="text" name="feed-url-1" placeholder="https://bit.ly/2jJJ0ya"/>

						<label>URL 2 (optional)</label>
						<input type="text" name="feed-url-2" placeholder="https://bit.ly/2jJJ0ya"/>

						<label>Attachment 1 (optional)</label>
						<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MAX_FILE_SIZE; ?>"/>
		      	<input class="no-border" type="file" name="feed-file-1"/>

						<label>Attachment 2 (optional)</label>
						<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MAX_FILE_SIZE; ?>"/>
		      	<input class="no-border" type="file" name="feed-file-2"/>

						<button name="add-feed-button" type="submit">add new feed</button>
						<p class="message"><?php if (isset($_POST['add-feed-button'])) { print_messages(); }?></p>
					</form>

					<h3>Delete Existing Post</h3>
					<form method="post" action="admin.php" id="delete-feed" name="delete-feed">
						<label>Select existing feed title</label>
						<select name="feed-titles">
							<option disabled selected value> -- select a title -- </option>
							<?php
								// fetch all feeds titles
								$sql = "SELECT entry_date, title FROM feed";
								$params = array();
								$fetch_all_feed_titles = exec_sql_query($db, $sql, $params)->fetchAll();

								foreach ($fetch_all_feed_titles as $feed_title) {
									echo "<option value='" . $feed_title['title'] . "'>" . $feed_title['entry_date'] . " - " . $feed_title['title'] . "</option>";
								}
							?>
						</select>
						<button name="delete-feed-button" type="submit">delete feed</button>
						<p class="message"><?php if (isset($_POST['delete-feed-button'])) { print_messages(); } ?></p>
					</form>

				</div>
			</div>
		</div>
	</section>

	<?php include("includes/footer.php"); ?>
</body>
</html>
