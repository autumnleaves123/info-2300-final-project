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
  header("Location: login.php");
}

const IMAGE_UPLOADS_PATH = "uploads/eboard/";

if (isset($_POST['add-newboard'])) {
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
      if (move_uploaded_file($upload_info["tmp_name"], $destination)) {
          array_push($messages, "[The image ". htmlspecialchars($target_file) . " has been uploaded.]");
          $description = NULL;
          $source = NULL;
      } else {
          array_push($messages, "[Error uploading your image.]");
      }
    }
  } else {
    array_push($messages, "[Error uploading your image.]");
    if ($upload_info['error'] == UPLOAD_ERR_FORM_SIZE) {
      if($filetype != "jpg" && $filetype != "png" && $filetype != "jpeg" && $filetype != "gif" ) {
        array_push($messages, "[Wrong file type. Only JPG, JPEG, PNG & GIF files are allowed.]");
      } else {
        array_push($messages, "[Image size too large.]");
      }
    }

  }
}

if (isset($_POST['delete-oldboard'])) {
  $entrytodelete = $_POST['entrytodelete'];
	$entrytodelete = filter_var($entrytodelete, FILTER_SANITIZE_STRING);
  $entrytodelete = trim($entrytodelete);
	var_dump($entrytodelete);
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

				<div id="admin-sidebar">
					<?php include("includes/admin-controller.php"); ?>
				</div>

				<div id="admin-content">

					<!-- Edit feed forms -->
					<div id="admin-feed">
						<h2>Manage E-board entries</h2>
						<div class="indentcontent">
							<div class="border">
								<h5>Add New Eboard Entry</h5>
								<form method="post" action="admin-board.php" id="add-eboard" name="add-newboard" enctype="multipart/form-data">
									Name: <input name="name" type="text" required/> <div class = "break"></div>
									Position: <input name="position" type="text" required/> <div class = "break"></div>
									Major: <input name="major" type="text" required/> <div class = "break"></div>
									Class Year: <input name="classyear" type="text" required/> <div class = "break"></div>
									Bio: <div class = "break"></div>
									<textarea rows = "7" cols = "40" name = "bio"><?php if (isset($bio)) {echo htmlentities($bio, ENT_QUOTES); } ?></textarea>
									<div class = "break"></div>
									<input type="hidden" name="MAX_FILE_SIZE" value="1000000"/>
									Upload File: <input type="file" name="image_file" required><div class = "break"></div><div class = "break"></div>
									<button name="submit" type="submit">Submit</button>
								</form><div class = "break"></div>
							</div>
							<div class="border">
								<h5>Delete Existing Eboard Entry</h5>
								<form method="post" action="admin-board.php" id="delete-oldboard" name="delete-oldboard">
									Name:
									<?php
							      $sql = "SELECT * FROM eboard";
							      $params = array();
							      $eboard = exec_sql_query($db, $sql, $params);
							      if (isset($eboard) && !empty($eboard)) {
											echo "<select name='entrytodelete'required>\n";
											echo "<option value='' selected disabled>Choose Member</option>";
							        foreach($eboard as $member) {
							          echo "<option value='" . htmlspecialchars($member['name']) . "'>" . htmlspecialchars($member['name']) . "</option>";
							        }
											echo "</select>";
											echo '<div class = "break"></div><button name="submit" type="submit">Submit</button>';
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
