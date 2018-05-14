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

	$name = $_POST['link-name'];
	$name = strtolower(trim(filter_var($name, FILTER_SANITIZE_STRING)));

	$url = $_POST['link-url'];
	$url = strtolower(trim(filter_var($url, FILTER_SANITIZE_STRING)));

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
}

// delete link form processing
if (isset($_POST['delete-link-button'])) {
  $link_delete = $_POST['link-names'];
	$link_delete = trim(filter_var($link_delete, FILTER_SANITIZE_STRING));

	$sql = "DELETE FROM links WHERE name = :link_delete";
  $params = array(':link_delete' => $link_delete);
  $records = exec_sql_query($db, $sql, $params)->fetchAll();

  array_push($messages, "[The link (". htmlspecialchars($link_delete) . ") has been deleted.]");
}

// upload ppt form processing
if (isset($_POST['add-ppt-button'])) {
	$upload_info = $_FILES["ppt-file"];

	$label = $_POST['ppt-label'];
	$label = strtolower(trim(filter_var($label, FILTER_SANITIZE_STRING)));

	if ($upload_info['error'] == UPLOAD_ERR_OK) {
		$target_file = basename($_FILES["ppt-file"]["name"]);
		$filetype = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
		if($filetype != "ppt" & $filetype != "pptx") {
			array_push($messages, "[Error uploading your file.]");
			array_push($messages, "[Wrong file type. Only PPT & PPTX files are allowed.]");
		} else {
			// check if file already exists because must be UNIQUE
			$sql = "SELECT * FROM ppts WHERE label = :label;";
			$params = array(":label"=>$label);
			$records = exec_sql_query($db, $sql, $params)->FetchAll();

			// if $records not empty, file already exists
			if ($records) {
				array_push($messages, "[File already exists.]");
			} else {
				var_dump("in else");
				// if $records empty, file does not exist, so upload it
				$sql = "INSERT INTO ppts (file, label) VALUES (:target_file, :label)";
				$params = array(':target_file' => $target_file, ':label' => $label);
				$records = exec_sql_query($db, $sql, $params);

				$fileid = $db->lastInsertId("id");
				$newfilename = "$fileid.$filetype";
				$destination = FILE_UPLOADS_PATH . $newfilename;
				$sql = "UPDATE ppts SET file = :newfilename WHERE label = :label";
				$params = array(':newfilename' => $newfilename, ':label' => $label);
				$records = exec_sql_query($db, $sql, $params);
				if (move_uploaded_file($upload_info["tmp_name"], $destination)) {
					array_push($messages, "[The new powerpoint '". htmlspecialchars($label) . "' has been added.]");
				} else {
					array_push($messages, "[Error uploading your powerpoint.]");
				}
			}
		}
	} else {
		array_push($messages, "[Error uploading your powerpoint.]");
		if ($upload_info['error'] == UPLOAD_ERR_FORM_SIZE) {
			array_push($messages, "[File size too large.]");
		}
	}
}

// delete powerpoint file form processing
if (isset($_POST['delete-ppt-button'])) {
  $ppt_delete = $_POST['ppt-names'];
	$ppt_delete = trim(filter_var($ppt_delete, FILTER_SANITIZE_STRING));
	var_dump($ppt_delete);
	$sqlfile = "SELECT file FROM ppts WHERE label = :ppt_delete";
  $paramsfile = array(':ppt_delete' => $ppt_delete);
  $file_delete = exec_sql_query($db, $sqlfile, $paramsfile)->fetchAll();
	var_dump($file_delete);
  $locationoffile = FILE_UPLOADS_PATH . $file_delete[0]['file'];
  $sql = "DELETE FROM ppts WHERE label = :ppt_delete";
  $params = array(':ppt_delete' => $ppt_delete);
  $records = exec_sql_query($db, $sql, $params);

  unlink($locationoffile);
  array_push($messages, "[The powerpoint (". ucwords(htmlspecialchars($ppt_delete)) . ") has been successfully deleted.]");
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
					<form method="post" action="admin-resources.php" id="add-feed" name="add-link">
						<label>Title <span class="required">(required)</span></label>
						<input type="text" name="link-name" placeholder="www.aslpro.com" required/>

						<label>URL <span class="required">(required)</span></label>
						<input type="text" name="link-url" placeholder="http://www.aslpro.com/" required/>

						<button name="add-link-button" type="submit">add new link</button>
						<p class="message"><?php if (isset($_POST['add-link-button'])) { print_messages(); }?></p>
					</form>

					<h3>Delete Existing Link</h3>
					<form method="post" action="admin-resources.php" id="delete-feed" name="delete-link">
						<select name="link-names">
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
						<p class="message"><?php if (isset($_POST['delete-link-button'])) { print_messages(); }?></p>
					</form>

					<h3>Upload New PowerPoint</h3>
					<form method="post" action="admin-resources.php" id="add-feed" name="add-ppt" enctype="multipart/form-data">
						<label>Label <span class="required">(required)</span></label>
						<input type="text" name="ppt-label" placeholder="Animal Vocab" required/>

						<label>Powerpoint File <span class="required">(required)</span></label>
						<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MAX_FILE_SIZE; ?>" required/>
		      	<input type="file" name="ppt-file"/>

						<button name="add-ppt-button" type="submit">upload new powerpoint</button>
						<p class="message"><?php if (isset($_POST['add-ppt-button'])) { print_messages(); }?></p>
					</form>

					<h3>Delete Existing PowerPoint</h3>
					<form method="post" action="admin-resources.php" id="delete-feed" name="delete-ppt">
						<select name="ppt-names">
							<option disabled selected value> -- select a powerpoint -- </option>
							<?php
								$sql = "SELECT label FROM ppts";
								$params = array();
								$fetch_all_ppts = exec_sql_query($db, $sql, $params)->fetchAll();

								foreach ($fetch_all_ppts as $ppt_label) {
									echo "<option value='" . htmlspecialchars($ppt_label['label']) . "'>" . ucwords(htmlspecialchars($ppt_label['label'])). "</option>";
								}
							?>
						</select>
						<button name="delete-ppt-button" type="submit">delete powerpoint</button>
						<p class="message"><?php if (isset($_POST['delete-ppt-button'])) { print_messages(); }?></p>
					</form>


				</div>
			</div>

		</div>


	</section>

	<?php include("includes/footer.php"); ?>
</body>
</html>
