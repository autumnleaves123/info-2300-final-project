<?php

include('includes/init.php');

$current_page_id = "admin";
$current_admin_page = "admin-board";

$HIDDEN_ERROR_CLASS = "hiddenError";

// redirect user to login.php if not logged in
if ($current_user == NULL) {
	header("Location: login.php");
}

const IMAGE_UPLOADS_PATH = "uploads/eboard/";

// add eboard form processing
if (isset($_POST['add'])) {
  $upload_info = $_FILES["image_file"];

  $name = $_POST['name'];
  $name = filter_var($name, FILTER_SANITIZE_STRING);
  $name = trim($name);

  $position = $_POST['position'];
  $position = filter_var($position, FILTER_SANITIZE_STRING);
  $position = trim($position);

	$major = $_POST['major'];
  $major = filter_var($major, FILTER_SANITIZE_STRING);
  $major = trim($major);

	$classyear = $_POST['classyear'];
  $classyear = filter_var($classyear, FILTER_SANITIZE_STRING);
  $classyear = trim($classyear);

	$bio = $_POST['bio'];
  $bio = filter_var($bio, FILTER_SANITIZE_STRING);
  $bio = trim($bio);

	if ($upload_info['error'] == UPLOAD_ERR_OK) {
		$target_file = basename($_FILES["image_file"]["name"]);
    $filetype = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    if($filetype != "jpg" && $filetype != "png" && $filetype != "jpeg" && $filetype != "gif" ) {
      array_push($messages, "[Error uploading your image.]");
      array_push($messages, "[Wrong file type. Only JPG, JPEG, PNG & GIF files are allowed.]");
    } else {
      $sql = "INSERT INTO eboard (name, position, major, classyear, bio, image) VALUES (:name, :position, :major, :classyear, :bio, :target_file)";
      $params = array(':target_file' => $target_file, ':name' => $name, ':position' => $position, ':major' => $major, ':classyear' => $classyear, ':bio' => $bio);
      $records = exec_sql_query($db, $sql, $params);

      $fileid = $db->lastInsertId("id");
      $newfilename = "$fileid.$filetype";
      $destination = IMAGE_UPLOADS_PATH . $newfilename;
			$sql = "UPDATE eboard SET image = :newfilename WHERE name = :name";
      $params = array(':newfilename' => $newfilename, ':name' => $name);
      $records = exec_sql_query($db, $sql, $params);
      if (move_uploaded_file($upload_info["tmp_name"], $destination)) {
          array_push($messages, "[The new member ". htmlspecialchars($name) . " has been added.]");
          $name = NULL;
					$position = NULL;
					$major = NULL;
					$classyear = NULL;
          $bio = NULL;
      } else {
          array_push($messages, "[Error uploading your image.]");
      }
    }
  } else {
    array_push($messages, "[Error uploading your image.]");
    if ($upload_info['error'] == UPLOAD_ERR_FORM_SIZE) {
      array_push($messages, "[Image size too large.]");
    }
  }
}

// delete eboard form processing
if (isset($_POST['delete'])) {
  $entrytodelete = $_POST['entrytodelete'];
	$entrytodelete = filter_var($entrytodelete, FILTER_SANITIZE_STRING);
  $entrytodelete = trim($entrytodelete);
	$sqlimage = "SELECT image FROM eboard WHERE name = :entrytodelete";
  $paramsimage = array(':entrytodelete' => $entrytodelete);
  $imageofentry = exec_sql_query($db, $sqlimage, $paramsimage)->fetchAll();
  $locationofimage = IMAGE_UPLOADS_PATH . $imageofentry;
  $sql = "DELETE FROM eboard WHERE name = :entrytodelete";
  $params = array(':entrytodelete' => $entrytodelete);
  $records = exec_sql_query($db, $sql, $params);

  unlink(IMAGE_UPLOADS_PATH . $locationofimage);
  array_push($messages, "[The entry for member ". htmlspecialchars($entrytodelete) . " has been deleted.]");
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
				<div id="admin-sidebar"><?php include("includes/admin-sidebar.php"); ?></div>

				<div id="admin-content">

						<h3>Add New E-board Entry</h3>
						<form method="post" action="admin-board.php" id="add_eboard" name="add_newboard" enctype="multipart/form-data">

							<label>Name <span class="required">(required)</span></label>
							<input name="name" type="text" value="<?php if (isset($name)) {echo htmlentities($name, ENT_QUOTES); } ?>" pattern="[A-z]{2,}" title="Name must consist of 2 or more letters." required/>

							<label>Position <span class="required">(required)</span></label>
							<input name="position" type="text" value="<?php if (isset($position)) {echo htmlentities($position, ENT_QUOTES); } ?>" pattern="[A-z]{2,}" title="Position must consist of 2 or more letters." required/>

							<label>Major <span class="required">(required)</span></label>
							<input name="major" type="text" value="<?php if (isset($major)) {echo htmlentities($major, ENT_QUOTES); } ?>" pattern="[A-z]{2,}" title="Major must consist of 2 or more letters." required/>

							<label>Class Year <span class="required">(required)</span></label>
							<input name="classyear" type="text" value="<?php if (isset($classyear)) {echo htmlentities($classyear, ENT_QUOTES); } ?>" pattern="[1-2]{1}[0-9]{3}" title="Class year must be a valid year." required/>

							<label>Bio <span class="required">(required)</span></label>
							<textarea rows="7" cols="40" name="bio" required><?php if (isset($bio)) {echo htmlentities($bio, ENT_QUOTES); } ?></textarea>

							<label>Upload Photo <span class="required">(required)</span></label>
							<input type="hidden" name="MAX_FILE_SIZE" value="1000000"/>
 							<input type="file" name="image_file" required>

							<button name="add" type="submit">add eboard entry</button>
							<p class="message"><?php if (isset($_POST['add'])) { print_messages(); }?></p>
						</form>


							<h3>Delete Existing Eboard Entry</h3>
							<form method="post" action="admin-board.php" id="delete_oldboard" name="delete_oldboard">

								<label>E-board Member Name</label>
								<?php
						      $sql = "SELECT * FROM eboard";
						      $params = array();
						      $eboard = exec_sql_query($db, $sql, $params);
						      if (isset($eboard) && !empty($eboard)) {
										echo "<select name='entrytodelete' required>\n";
										echo "<option value='' selected disabled>Choose Member</option>";
						        foreach($eboard as $member) {
						          echo "<option value='" . htmlspecialchars($member['name']) . "'>" . htmlspecialchars($member['name']) . "</option>";
						        }
										echo "</select>";
										echo '<button name="delete" type="submit">Submit</button>';
						      } else {
										echo "<p>No eboard members.</p>";
									}
						    ?>

								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

	</section>

	<?php include("includes/footer.php"); ?>
</body>
</html>
