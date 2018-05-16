<?php include('includes/init.php');
$current_page_id = "admin";
$current_admin_page = "admin";

const GALLERY_UPLOADS_PATH = "uploads/feed/";

// redirect user to login.php if not logged in
if ($current_user == NULL) {
	header("Location: login.php");
	exit;
}

/*
adding feed posts
retrieves all the parameters from the form and sanitizes them
adds the information into a database entry
if a user includes attachments, add those to uploads/feed folder
if any part fails, return message saying that the user is unable to add a new feed post
*/
if (isset($_POST['add-feed-button'])) {

	$db->beginTransaction();

	// grab all parameters and sanitize
	$title = filter_input(INPUT_POST, 'feed-title', FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$title = trim($title);

	$feed_text = filter_input(INPUT_POST, 'feed-text', FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$feed_text = trim($feed_text);

	$url1 = filter_input(INPUT_POST, 'feed-url-1', FILTER_SANITIZE_STRING);
	$url1 = trim($url1);

	$url2 = filter_INPUT(INPUT_POST, 'feed-url-2', FILTER_SANITIZE_STRING);
	$url2 = trim($url2);

	$tag = filter_INPUT(INPUT_POST, 'tag', FILTER_SANITIZE_STRING);
	$tag = trim($tag);

	// capture datetime
	$date_today = date("F j, Y");

	// file processing
	$file_1 = $_FILES["feed-file-1"]; $file_2 = $_FILES["feed-file-2"];

	$file_1_name = ""; $file_1_ext = ""; $file_2_name = ""; $file_2_ext = "";

	$file_1_ready = true;
	$file_2_ready = true;

	if ($file_1['error'] == UPLOAD_ERR_OK) {
		// no upload errors
		$file_1_name = basename($file_1["name"]);
		$file_1_ext = strtolower(pathinfo($file_1_name, PATHINFO_EXTENSION));

	} else if ($file_1['error'] == UPLOAD_ERR_NO_FILE) {
		// no file uploaded, skip

	} else if ($file_1['error'] == UPLOAD_ERR_FORM_SIZE) {
		// file too large
		$file_1_ready = false;
		record_message("[Attachment 1 is too large. Maximum size = 2MB.]");

	} else {
		$file_1_ready = false;
		record_message("[Failed to upload attachment 1.]");
	}

	if ($file_2['error'] == UPLOAD_ERR_OK) {
		// no upload errors
		$file_2_name = basename($file_2["name"]);
		$file_2_ext = strtolower(pathinfo($file_2_name, PATHINFO_EXTENSION));

	} else if ($file_2['error'] == UPLOAD_ERR_NO_FILE) {
		// no file uploaded, skip

	} else if ($file_2['error'] == UPLOAD_ERR_FORM_SIZE) {
		// file too large
		record_message("[Attachment 2 is too large. Maximum size = 2MB.]");
		$file_2_ready = false;

	} else {
		record_message("[Failed to upload attachment 2.]");
		$file_2_ready = false;
	}

	// if post inputs are fine and files have been uploaded
	if ($file_1_ready && $file_2_ready) {
		// then insert everything into database
		$sql = "INSERT INTO feed (title, entry_date, content, url_1, url_2) VALUES (:title, :date_today, :feed_text, :url1, :url2)";
		$params = array(
			':title' => $title,
			':date_today' => $date_today,
			':feed_text' => $feed_text,
			':url1' => $url1,
			':url2' => $url2);
		$add_feed = exec_sql_query($db, $sql, $params);
		$feed_id = $db->lastInsertId("id");

		// insert file 1
		if ($file_1_name != "") {
			$sql = "INSERT INTO feed_attachments (file_name, file_ext) VALUES (:file_name, :file_ext)";
			$params = array(':file_name' => $file_1_name, ':file_ext' => $file_1_ext);
			$add_feed_attachments = exec_sql_query($db, $sql, $params);
			$feed_attachments_id = $db->lastInsertId("id");

			$sql = "INSERT INTO feed_to_feed_attachments (feed_id, feed_attachment_id) VALUES (:feed_id, :feed_attachments_id)";
			$params = array(':feed_id' => $feed_id, ':feed_attachments_id' => $feed_attachments_id);
			$add_feed_to_feed_attachments = exec_sql_query($db, $sql, $params);

			// move files to uploads folder
			move_uploaded_file($file_1["tmp_name"], GALLERY_UPLOADS_PATH . "$feed_attachments_id.$file_1_ext");
		}

		// insert file 2
		if ($file_2_name != "") {
			$sql = "INSERT INTO feed_attachments (file_name, file_ext) VALUES (:file_name, :file_ext)";
			$params = array(':file_name' => $file_2_name, ':file_ext' => $file_2_ext);
			$add_feed_attachments_2 = exec_sql_query($db, $sql, $params);
			$feed_attachments_2_id = $db->lastInsertId("id");

			$sql = "INSERT INTO feed_to_feed_attachments (feed_id, feed_attachment_id) VALUES (:feed_id, :feed_attachments_id)";
			$params = array(':feed_id' => $feed_id, ':feed_attachments_id' => $feed_attachments_2_id);
			$add_feed_to_feed_attachments_2 = exec_sql_query($db, $sql, $params);

			move_uploaded_file($file_2["tmp_name"], GALLERY_UPLOADS_PATH . "$feed_attachments_2_id.$file_2_ext");
		}

		// insert tags if tag was selected
		// first get tag id
		if ($tag != "") {
			$sql = "SELECT id FROM feed_tags WHERE name = :tag";
			$params = array(':tag' => $tag);
			$tag_id = exec_sql_query($db, $sql, $params)->fetchAll();

			$tag_id = $tag_id[0]['id'];

			// insert into database
			$sql = "INSERT INTO feed_to_tags (feed_id, tag_id) VALUES (:feed_id, :tag_id)";
			$params = array(':feed_id' => $feed_id, ':tag_id' => $tag_id);
			$insert_tag = exec_sql_query($db, $sql, $params);
		}

		record_message("[Successfully added post!]");

	} else {
		// file_count < 0
		record_message("[Failed to add post.]");
	}
	$db->commit();
}


/*
deleting feed posts
check that the feed selected exists
delete post from the database
*/
if (isset($_POST['delete-feed-button'])) {

	$db->beginTransaction();

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

		// delete relevant tags
		$sql = "DELETE FROM feed_to_tags WHERE feed_id = :feed_id";
		$params = array(':feed_id' => $feed_id);
		$delete_tag = exec_sql_query($db, $sql, $params);

		// check to see if there are attachments linked to this post in feed_attachments and feed_to_feed_attachments
		$sql = "SELECT feed_attachment_id FROM feed_to_feed_attachments WHERE feed_id = :feed_id";
		$params = array(':feed_id' => $feed_id);
		$fetch_attachment_id = exec_sql_query($db, $sql, $params)->fetchAll();

		foreach ($fetch_attachment_id as $attachment) {
			$attachment_id = $attachment[0];

			// fetch file extension
			$sql = "SELECT file_ext FROM feed_attachments WHERE id = :id";
			$params = array(':id' => $attachment_id);
			$fetch_attachment_ext = exec_sql_query($db, $sql, $params)->fetchAll();

			$attachment_ext = $fetch_attachment_ext[0]['file_ext'];

			$sql = "DELETE FROM feed_attachments WHERE id = :id";
			$params = array(':id' => $attachment_id);
			$delete_from_feed_attachments = exec_sql_query($db, $sql, $params);

			// remove file from uploads folder
			unlink(GALLERY_UPLOADS_PATH . $attachment_id . '.' . $attachment_ext);
		}

		$sql = "DELETE FROM feed_to_feed_attachments WHERE feed_id = :feed_id";
		$params = array(':feed_id' => $feed_id);
		$delete_from_feed_to_feed_attachments = exec_sql_query($db, $sql, $params);

		record_message("[Successfully deleted post.]");

	} else {
		// feed doesn't exist
		record_message("[Please select an existing feed from the dropdown menu.]");
	}

	$db->commit();

}

/*
create new tag
*/
if (isset($_POST['create-tag-button'])) {

	$db->beginTransaction();

	$new_tag = filter_input(INPUT_POST, 'new-tag', FILTER_SANITIZE_STRING);

	// make sure that tag has # in front of it
	$hashtag = strpos($new_tag, "#");
	if ($hashtag == true) {
		$new_tag = "#" . $new_tag;
	}
	$new_tag = trim($new_tag);
	$new_tag = strtolower($new_tag);

	// assume valid new tag
	// search database to check that tag does not already exist
	$sql = "SELECT * FROM feed_tags WHERE name = :new_tag";
	$params = array(':new_tag'=> $new_tag);
	$check_tag = exec_sql_query($db, $sql, $params)->fetchAll();

	if ($check_tag == NULL) {

		$sql = "INSERT INTO feed_tags (name) VALUES (:new_tag)";
		$params = array(':new_tag' => $new_tag);
		$update_tbl = exec_sql_query($db, $sql, $params);

		record_message("[Successfully added $new_tag.]");

	} else {
		// tag already exists
		record_message("[$new_tag is an existing tag.]");
	}

	$db->commit();

}


/*
delete existing tag
*/
if (isset($_POST['delete-tag-button'])) {

	$db->beginTransaction();

	$tag = filter_input(INPUT_POST, 'tag-to-delete', FILTER_SANITIZE_STRING);

	// check that it exists in database
	$sql = "SELECT id FROM feed_tags WHERE name = :tag";
	$params = array(':tag' => $tag);
	$check_tag = exec_sql_query($db, $sql, $params)->fetchAll();

	if ($check_tag == NULL) {
		// tag doesn't exist
		record_message("[Please select an existing tag to delete.]");

	} else {
		// tag can be deleted

		$tag_id = $check_tag[0]['id'];

		// check if there are posts associated with this tag, delete those entries
		$sql = "DELETE FROM feed_to_tags WHERE tag_id = :tag_id";
		$params = array(':tag_id' => $tag_id);
		$delete_tag = exec_sql_query($db, $sql, $params);

		// delete tag from feed_tags table
		$sql = "DELETE FROM feed_tags WHERE id = :tag_id";
		$params = array(':tag_id' => $tag_id);
		$delete_tag = exec_sql_query($db, $sql, $params);

		record_message("[Successfully deleted $tag.]");
	}

	$db->commit();

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<?php include('includes/head.php'); ?>

  <title>Admin</title>
</head>

<body>
  <?php include("includes/header.php"); ?>

	<section class="content">
		<h1>Admin Portal</h1>

		<div class="white-background">
			<div id="admin-wrapper">
				<div id="admin-sidebar"><?php include("includes/admin-sidebar.php"); ?></div>

				<div id="admin-content">

					<p class="message"><?php print_messages(); ?></p>

					<h3>Add New Post</h3>
					<form method="post" action="admin.php" id="add-feed" name="add-feed" enctype="multipart/form-data">
						<label>Title <span class="required">(required)</span></label>
						<input type="text" name="feed-title" placeholder="CUDAP Arch Sign" required/>

						<label>Text <span class="required">(required)</span></label>
						<textarea name="feed-text" rows="5" cols="80" placeholder="Come to CUDAP's Arch Sign tomorrow from 9:00 to 9:30 at the Balch Arch! We'll be sharing your favorite pieces!"></textarea>

						<label>URL 1</label>
						<input type="text" name="feed-url-1" pattern="[http{s}:\/\/].{1,}" title="Enter valid URL beginning with http:// or https://." placeholder="https://bit.ly/2jJJ0ya"/>

						<label>URL 2</label>
						<input type="text" name="feed-url-2" pattern="[http{s}:\/\/].{1,}" title="Enter valid URL beginning with http:// or https://." placeholder="https://bit.ly/2jJJ0ya"/>

						<label>Attachment 1</label>
						<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MAX_FILE_SIZE; ?>"/>
		      	<input type="file" name="feed-file-1"/>

						<label>Attachment 2</label>
						<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MAX_FILE_SIZE; ?>"/>
		      	<input type="file" name="feed-file-2"/>

						<label>Assign a tag</label>
		      	<select name="tag">
							<option disabled selected value> -- select a tag -- </option>
							<?php
								$sql = "SELECT * FROM feed_tags";
								$params = array();
								$fetch_tags = exec_sql_query($db, $sql, $params)->fetchAll();

								foreach ($fetch_tags as $tag) {
									echo "<option value='" . $tag['name'] . "'>" . $tag['name'] . "</option>";
								}
							?>
						</select>

						<button name="add-feed-button" type="submit">add new feed</button>
					</form>

					<h3>Delete Existing Post</h3>
					<form method="post" action="admin.php" id="delete-feed" name="delete-feed">
						<label>Select existing feed title</label>
						<select name="feed-titles" required>
							<option disabled selected value> -- select a title -- </option>
							<?php
								// fetch all feeds titles
								$sql = "SELECT entry_date, title FROM feed";
								$params = array();
								$fetch_all_feed_titles = exec_sql_query($db, $sql, $params)->fetchAll();

								foreach ($fetch_all_feed_titles as $feed_title) {
									echo "<option value=\"" . $feed_title['title'] . "\">" . $feed_title['entry_date'] . " - " . $feed_title['title'] . "</option>";
								}
							?>
						</select>
						<button name="delete-feed-button" type="submit">delete feed</button>
					</form>


					<h3>Create New Tag</h3>
					<form method="post" action="admin.php" id="new-tag" name="new-tag">
						<label>Tag Name <span class="required">(required, start with #)</span></label>
						<input type="text" name="new-tag" placeholder="#cudap" pattern=[#][a-zA-Z]{1,30} maxlength="30" title="Limit your tag to 30 characters and use only # and lowercase letters" required/>
						<button name="create-tag-button" type="submit">create tag</button>
					</form>

					<h3>Delete Existing Tag</h3>
					<form method="post" action="admin.php" id="delete-tag" name="delete-tag">
						<label>Select existing tag</label>
						<select name="tag-to-delete">
							<option disabled selected value> -- select tag -- </option>
							<?php
								$sql = "SELECT * FROM feed_tags";
								$params = array();
								$fetch_tags = exec_sql_query($db, $sql, $params)->fetchAll();

								foreach ($fetch_tags as $tag) {
									echo "<option value=\"" . $tag['name'] . "\">" . $tag['name'] . "</option>";
								}
							?>
						</select>
						<button name="delete-tag-button" type="submit">delete tag</button>
					</form>

					<div id="admin-logout"><?php include("includes/admin-logout.php"); ?></div>
				</div>
			</div>


		</div>
	</section>

	<?php include("includes/footer.php"); ?>
</body>
</html>
