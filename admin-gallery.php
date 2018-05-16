<?php include('includes/init.php');
$current_page_id = "admin";
$current_admin_page = "admin-gallery";

// redirect user to login.php if not logged in
if ($current_user == NULL) {
	header("Location: login.php");
	exit;
}

// handle file uploads, adapted from lab code
// Set maximum file size for uploaded files
const BOX_UPLOADS_PATH = "uploads/images/";

if (isset($_POST["submit_upload"])) {
  $upload_info = $_FILES["box_file"];
  $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
  if (empty($_POST['title'])) {
    record_message("[No title specified - image was not uploaded.]");
  } else {
    if ($upload_info['error'] == UPLOAD_ERR_OK) {
      $upload_name = basename($upload_info["name"]);
      $upload_ext = strtolower(pathinfo($upload_name, PATHINFO_EXTENSION) );

      $sql = "INSERT INTO images (title, file_ext) VALUES (:title, :file_ext);";
      $params = array(
        ':title' => $title,
        ':file_ext' => $upload_ext
      );
      $result = exec_sql_query($db, $sql, $params);

      if ($result) {
        $image_id = $db->lastInsertId("id");
        if (!move_uploaded_file($upload_info["tmp_name"], BOX_UPLOADS_PATH . "$image_id.$upload_ext")){
          record_message("[Failed to upload image.]");
        }

        if (!empty($_POST['category'])) {

					$category = filter_input(INPUT_POST, 'category', FILTER_SANITIZE_STRING);

					if (!empty($category)) { // make sure the category is not empty somehow
						// add image-cat relationship to database
						if (empty($records)) {
							$sql = "INSERT INTO images_cats (image_id, cat_id) VALUES (:image_id, :cat_id);";
							$params = array(':image_id' => $image_id, ':cat_id' => $category);
							$result = exec_sql_query($db, $sql, $params);
							if (is_null($result)) {
								record_message("[Failed to upload image.]");
							} else {
								record_message("[Image successfully uploaded.]");
							}
						}
					}
        }
      } else {
        record_message("[Failed to upload image.]");
      }
    } else {
      record_message("[Failed to upload image.]");
    }
  }
}

// delete image
if (isset($_POST['delete_image'])) { // TODO: delete image if received confirmation
  // remove image from database along with all image tag relationships
	$image_id = filter_input(INPUT_POST, 'image', FILTER_SANITIZE_STRING);

	$sql = "SELECT * FROM images WHERE id = :id;";
	$params = array(':id' => $image_id);
	$records = exec_sql_query($db, $sql, $params)->fetchAll();

	$image_ext = $records[0]['file_ext'];

  $sql = "DELETE FROM images WHERE id = :id";
  $params = array(':id' => $image_id);
  $result = exec_sql_query($db, $sql, $params);

  if (empty($result)) {
    record_message("[Error deleting image.]");
  } else {
    $sql = "DELETE FROM images_cats WHERE image_id = :image_id";
    $params = array(':image_id' => $image_id);
    $result = exec_sql_query($db, $sql, $params);

    if (empty($result)) {
      record_message("[Error deleting image.]");
    } else {
      // delete file
      unlink('uploads/images/' . $image_id . '.' . $image_ext);
			record_message("[Image successfully deleted.]");
    }
  }
}

// create category
if (isset($_POST['create_category'])) {
	// check if this category already exists, if not, add it to categories table
	$category = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);

	$sql = "SELECT * FROM categories WHERE name = :name;";
	$params = array(':name' => $category);
	$records = exec_sql_query($db, $sql, $params)->fetchAll();

	// check if any results returned
	if ($records) {
		$cat_id = $records[0]['id'];
	} else { // no results so add category to table
		$sql = "INSERT INTO categories (name) VALUES (:name);";
		$params = array(':name' => $category);
		$result = exec_sql_query($db, $sql, $params);
		if (is_null($result)) {
			record_message("[Failed to add category.]");
		} else {
			record_message("[Category successfully added.]");
		}
	}
}

// delete category (and all photos in that category)
if (isset($_POST['delete_category'])) {
	$failed = false;
	$category = filter_input(INPUT_POST, 'category', FILTER_SANITIZE_STRING);

	$sql = "SELECT * FROM images_cats WHERE cat_id = :cat_id;";
	$params = array(':cat_id' => $category);
	$records = exec_sql_query($db, $sql, $params)->fetchAll();

	$sql = "DELETE FROM images_cats WHERE cat_id = :cat_id";
	$params = array(':cat_id' => $category);
	$result = exec_sql_query($db, $sql, $params);

	$sql = "DELETE FROM categories WHERE id = :id";
	$params = array(':id' => $category);
	$result = exec_sql_query($db, $sql, $params);

	foreach ($records as $record) {
		$sql = "SELECT * FROM images WHERE id = :id;";
		$params = array(':id' => $record['image_id']);
		$image = exec_sql_query($db, $sql, $params)->fetchAll();

		$image_ext = $image[0]['file_ext'];

		$sql = "DELETE FROM images WHERE id = :id";
	  $params = array(':id' => $record['image_id']);
	  $result = exec_sql_query($db, $sql, $params);

	  if (empty($result)) {
	    record_message("[Error deleting category.]");
			$failed = true;
	  } else {
			unlink('uploads/images/' . $record['image_id'] . '.' . $image_ext);
	  }
	}
	if (!$failed) {
		record_message("[Category and associated images successfully deleted.]");
	}
}

?>

<!DOCTYPE html>
<html>

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

				<div id="admin-sidebar">
					<?php include("includes/admin-sidebar.php"); ?>
				</div>

				<div id="admin-content">

					<p class="message"><?php print_messages(); ?></p>

					<!-- Edit feed forms -->
					<h3>Add New Image to Gallery</h3>
					<form method="post" action="admin-gallery.php" enctype="multipart/form-data">
						<label>Enter a title <span class="required">(required)</span></label>
						<input name="title" type="text" required />
						<label>Assign a category <span class="required">(required)</span></label>
						<select name="category">
							<option disabled selected value> -- select a category -- </option>
							<?php
								// fetch all categories
								$sql = "SELECT * FROM categories;";
								$params = array();
								$categories = exec_sql_query($db, $sql, $params)->fetchAll();

								foreach ($categories as $category) {
									echo "<option value='" . $category['id'] . "'>" . $category['name'] . "</option>";
								}
							?>
						</select>
						<label>Upload file <span class="required">(required)</span></label>
						<input class="no-border" type="hidden" name="MAX_FILE_SIZE" value="<?php echo MAX_FILE_SIZE; ?>"/>
						<input class="no-border" type="file" name="box_file" required>
						<button name="submit_upload" type="submit">add image</button>
					</form>

					<h3>Delete Image</h3>
					<form method="post" action="admin-gallery.php">
						<label>Select an image by its title <span class="required">(required)</span></label>
						<select name="image">
							<option disabled selected value> -- select an image -- </option>
							<?php
								// fetch all images
								$sql = "SELECT * FROM images;";
								$params = array();
								$images = exec_sql_query($db, $sql, $params)->fetchAll();

								foreach ($images as $image) {
									echo "<option value='" . $image['id'] . "'>" . $image['title'] . "</option>";
								}
							?>
						</select>
						<button name="delete_image" type="submit">delete image</button>
					</form>

					<h3>Create New Category</h3>
					<p>Categories are <em>case-sensitive</em>! Avoid creating new categories unless necessary.</p>
					<form method="post" action="admin-gallery.php">
						<label>Enter a category name <span class="required">(required)</span></label>
						<input name="name" type="text" required />
						<button name="create_category" type="submit">create category</button>
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
									echo "<option value='" . $category['id'] . "'>" . $category['name'] . "</option>";
								}
							?>
						</select>
						<button name="delete_category" type="submit">delete category</button>
					</form>

					<div id="admin-logout"><?php include("includes/admin-logout.php"); ?></div>
				</div>
			</div>
		</div>

	</section>

	<?php include("includes/footer.php"); ?>
</body>
</html>
