<?php include('includes/init.php');
$current_page_id = "admin";
$current_admin_page = "admin-gallery";

// redirect user to login.php if not logged in
if ($current_user == NULL) {
	header("Location: login.php");
	exit;
}

/*
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
*/


?>

<!DOCTYPE html>
<html>

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

					<!-- Edit feed forms -->
					<h3>Add New Image to Gallery</h3>
					<form method="post" action="admin-gallery.php" enctype="multipart/form-data">
						<label>Enter a title <span class="required">(required)</span></label>
						<input name="title" type="text" value="<?php if (isset($name)) {echo htmlentities($name, ENT_QUOTES); } ?>" pattern="[A-z]{2,}" title="Title must consist of 2 or more letters." required/>
						<label>Assign a category <span class="required">(required)</span></label>
						<select name="category">
							<option disabled selected value> -- select a category -- </option>
							<?php
								// fetch all categories
								$sql = "SELECT * FROM categories;";
								$params = array();
								$categories = exec_sql_query($db, $sql, $params)->fetchAll();

								foreach ($categories as $category) {
									echo "<option value='" . $category['name'] . "'>" . $category['name'] . "</option>";
								}
							?>
						</select>
						<label>Upload file <span class="required">(required)</span></label>
						<input class="no-border" type="hidden" name="MAX_FILE_SIZE" value="<?php echo MAX_FILE_SIZE; ?>"/>
						<input class="no-border" type="file" name="attachment" required>
						<button name="submit" type="submit">add image</button>
					</form>

					<h3>Delete Image</h3>
					<form method="post" action="admin-gallery.php">
						<label>Select an image <span class="required">(required)</span></label>
						<select name="category">
							<option disabled selected value> -- select an image -- </option>
							<?php
								// fetch all categories
								$sql = "SELECT * FROM images;";
								$params = array();
								$images = exec_sql_query($db, $sql, $params)->fetchAll();

								foreach ($images as $image) {
									echo "<option value='" . $image['title'] . "'>" . $image['title'] . "</option>";
								}
							?>
						</select>
						<button name="submit" type="submit">delete image</button>
					</form>

					<h3>Create New Category</h3>
					<form method="post" action="admin-gallery.php">
						<label>Enter a category name <span class="required">(required)</span></label>
						<input name="name" type="text" value="<?php if (isset($name)) {echo htmlentities($name, ENT_QUOTES); } ?>" pattern="[A-z]{2,}" title="Category name must consist of 2 or more letters." required/>
						<button name="submit" type="submit">create category</button>
					</form>

					<h3>Delete Existing Category</h3>
					<p><strong>Warning:</strong> Deleting a category will delete all associated images!</p>
					<form method="post" action="admin-gallery.php">
						<label>Select a category <span class="required">(required)</span></label>
						<select name="category">
							<option disabled selected value> -- select a category -- </option>
							<?php
								// fetch all categories
								$sql = "SELECT * FROM categories;";
								$params = array();
								$categories = exec_sql_query($db, $sql, $params)->fetchAll();

								foreach ($categories as $category) {
									echo "<option value='" . $category['name'] . "'>" . $category['name'] . "</option>";
								}
							?>
						</select>
						<button name="submit" type="submit">delete category</button>
					</form>

				</div>
			</div>

		</div>


	</section>

	<?php include("includes/footer.php"); ?>
</body>
</html>
