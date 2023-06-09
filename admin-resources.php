<?php include('includes/init.php');
$current_page_id = "admin";
$current_admin_page = "admin-resources";

// redirect user to login.php if not logged in
if ($current_user == NULL) {
	header("Location: login.php");
}

const FILE_UPLOADS_PATH = "uploads/resourcesppt/";

// add link form processing
if (isset($_POST['add-link-button'])) {

	$db->beginTransaction();

	$name = $_POST['link-name'];
	$name = strtolower(trim(filter_var($name, FILTER_SANITIZE_STRING)));

	$url = $_POST['link-url'];
	$url = trim(filter_var($url, FILTER_SANITIZE_STRING));

	$sql = "SELECT * FROM links WHERE url = :url;";
	$params = array(":url"=>$url);
	$url_records = exec_sql_query($db, $sql, $params)->FetchAll();

	$sql = "SELECT * FROM links WHERE name = :name;";
	$params = array(":name"=>$name);
	$link_records = exec_sql_query($db, $sql, $params)->FetchAll();

	// check to see if link name or link url exists already because UNIQUE
	if ($url_records) {
		array_push($messages, "[URL already exists.]");
	} elseif ($link_records) {
		array_push($messages, "[Link name already exists.]");
	} elseif (filter_var($url, FILTER_VALIDATE_URL) === FALSE) {
    array_push($messages, '[Not a valid URL.]');
	} else {
		// if $records empty, file does not exist, so upload it
		$sql = "INSERT INTO links (name, url) VALUES (:name, :url)";
		$params = array(':name' => $name, ':url' => $url);
		$records = exec_sql_query($db, $sql, $params);

		if ($records) {
			array_push($messages, "[Link successfully added.]");
		} else {
			array_push($messages, "[Link failed to add.]");
		}
	}
	$db->commit();
}

// delete link form processing
if (isset($_POST['delete-link-button'])) {

	$db->beginTransaction();

  $link_delete = $_POST['link-names'];
	$link_delete = trim(filter_var($link_delete, FILTER_SANITIZE_STRING));

	$sql = "DELETE FROM links WHERE name = :link_delete";
  $params = array(':link_delete' => $link_delete);
  $records = exec_sql_query($db, $sql, $params)->fetchAll();

  array_push($messages, "[The link '". htmlspecialchars($link_delete) . "' has been deleted.]");
	$db->commit();
}

// upload ppt form processing
if (isset($_POST['add-ppt-button'])) {

	$db->beginTransaction();

	$label = $_POST['ppt-label'];
	$label = htmlspecialchars(strtolower(trim(filter_var($label, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES))));

	$link = $_POST['ppt-link'];
	$link = trim(filter_var($link, FILTER_SANITIZE_STRING));


	$sql = "SELECT * FROM ppts WHERE label = :label;";
	$params = array(":label"=>$label);
	$label_records = exec_sql_query($db, $sql, $params)->FetchAll();

	$sql = "SELECT * FROM ppts WHERE link = :link;";
	$params = array(":link"=>$link);
	$link_records = exec_sql_query($db, $sql, $params)->FetchAll();

	// check to see if link name or link url exists already because UNIQUE
	if ($label_records) {
		array_push($messages, "[Resource already exists.]");
	} elseif ($link_records) {
		array_push($messages, "[Resource link already used.]");
	} elseif (strpos($link, "google.com") !== FALSE && filter_var($link, FILTER_VALIDATE_URL) === FALSE) {
    array_push($messages, '[Not a valid Google Drive link.]');
	} else {
		// if $records empty, file does not exist, so upload it
		$sql = "INSERT INTO ppts (link, label) VALUES (:link, :label)";
		$params = array(':link' => $link, ':label' => $label);
		$records = exec_sql_query($db, $sql, $params);

		if ($records) {
			array_push($messages, "[Resource upload successful.]");
		} else {
			array_push($messages, "[Upload failed.]");
		}
	}
	$db->commit();
}

// delete powerpoint file form processing
if (isset($_POST['delete-ppt-button'])) {

	$db->beginTransaction();

	$link_delete = $_POST['ppt-names'];
	$link_delete = trim(filter_var($link_delete, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES));

	$sql = "DELETE FROM ppts WHERE label = :link_delete";
  $params = array(':link_delete' => $link_delete);
  $records = exec_sql_query($db, $sql, $params)->fetchAll();

  array_push($messages, "[The resource '". ucwords(htmlspecialchars($link_delete)) . "' has been deleted.]");

	$db->commit();
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="stylesheet" type="text/css" href="styles/all.css" media="all" />
	<link rel="stylesheet" type="text/css" href="styles/tablet.css"/>
	<link rel="stylesheet" type="text/css" href="styles/mobile.css"/>

  <title>Admin</title>
</head>

<body>
  <?php include("includes/header.php"); ?>

	<section class="content">
		<h1>Admin Portal</h1>

		<div class="white-background">

			<div id="admin-wrapper">

				<div id="admin-sidebar">
					<?php include("includes/admin-sidebar.php"); ?>
				</div>

				<div id="admin-content">

					<p class="message"><?php print_messages(); ?></p>
					<!-- Edit feed forms -->
					<h3>Add New Link</h3>
					<form method="post" action="admin-resources.php" id="add-link" name="add-link">
						<label>Title <span class="required">(required)</span></label>
						<input type="text" name="link-name" placeholder="www.aslpro.com" required/>

						<label>URL <span class="required">(required)</span></label>
						<input type="text" name="link-url" placeholder="http://www.aslpro.com/" required/>

						<button name="add-link-button" type="submit">add new link</button>
					</form>

					<h3>Delete Existing Link</h3>
					<form method="post" action="admin-resources.php" id="delete-link" name="delete-link">
						<select name="link-names" required>
							<option disabled selected value> -- select a link -- </option>
							<?php
								// fetch all feeds titles
								$sql = "SELECT name FROM links";
								$params = array();
								$fetch_all_links = exec_sql_query($db, $sql, $params)->fetchAll();

								foreach ($fetch_all_links as $link_name) {
									echo "<option value='" . htmlspecialchars($link_name['name']) . "'>" . htmlspecialchars($link_name['name']) . "</option>";
								}
							?>
						</select>
						<button name="delete-link-button" type="submit">delete link</button>
					</form>

					<h3>Upload New Teaching Resource</h3>
					<form method="post" action="admin-resources.php" id="add-resource" name="add-ppt" enctype="multipart/form-data">
						<label>Label <span class="required">(required)</span></label>
						<input type="text" name="ppt-label" placeholder="Animal Vocab" required/>

						<label>Google Drive Link <span class="required">(required)</span></label>
						<input type="text" name="ppt-link" placeholder="https://drive.google.com/" required/>

						<button name="add-ppt-button" type="submit">upload new resource</button>
					</form>

					<h3>Delete Existing Teaching Resource</h3>
					<form method="post" action="admin-resources.php" id="delete-resource" name="delete-ppt">
						<select name="ppt-names" required>
							<option disabled selected value> -- select a resource -- </option>
							<?php
								$sql = "SELECT label FROM ppts";
								$params = array();
								$fetch_all_ppts = exec_sql_query($db, $sql, $params)->fetchAll();

								foreach ($fetch_all_ppts as $ppt_label) {
									echo "<option value=\"" . htmlspecialchars($ppt_label['label']) . "\">" . ucwords(htmlspecialchars($ppt_label['label'])). "</option>";
								}
							?>
						</select>
						<button name="delete-ppt-button" type="submit">delete resource</button>
					</form>

					<div id="admin-logout"><?php include("includes/admin-logout.php"); ?></div>
				</div>
			</div>
		</div>


	</section>

	<?php include("includes/footer.php"); ?>
</body>
</html>
