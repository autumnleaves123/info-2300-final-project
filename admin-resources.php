<?php include('includes/init.php');
$current_page_id = "admin";
$current_admin_page = "admin-resources";

// redirect user to login.php if not logged in
if ($current_user == NULL) {
	header("Location: login.php");
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
					<form>
						<label>Title <span class="required">(required)</span></label>
						<input type="text" name="feed-title" placeholder="www.aslpro.com" required/>

						<label>URL <span class="required">(required)</span></label>
						<input type="text" name="feed-url-1" placeholder="http://www.aslpro.com/" required/>

						<button name="add-link-button" type="submit">add new link</button>
						<p class="message"><?php if (isset($_POST['add-link-button'])) { print_messages(); }?></p>
					</form>

					<h3>Delete Existing Link</h3>
					<form>
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
								// fetch all feeds titles
								$sql = "SELECT label FROM ppts";
								$params = array();
								$fetch_all_ppts = exec_sql_query($db, $sql, $params)->fetchAll();

								foreach ($fetch_all_ppts as $ppt_label) {
									echo "<option value='" . htmlspecialchars($ppt_label['label']) . "'>" . htmlspecialchars($ppt_label['label']) . "</option>";
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
