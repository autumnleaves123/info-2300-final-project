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
								<form method="post" action="admin.php" id="add-eboard" name="add-newboard">
									Name: <input type="text" required/> <div class = "break"></div>
									Position: <input type="text" required/> <div class = "break"></div>
									Major: <input type="text" required/> <div class = "break"></div>
									Class Year: <input type="text" required/> <div class = "break"></div>
									Bio: <div class = "break"></div>
									<textarea rows = "7" cols = "40" name = "bio"><?php if (isset($bio)) {echo htmlentities($bio, ENT_QUOTES); } ?></textarea>
									<div class = "break"></div>
									<button name="submit" type="submit">Submit</button>
								</form><div class = "break"></div>
							</div>
							<div class="border">
								<h5>Delete Existing Eboard Entry</h5>
								<form method="post" action="admin.php" id="delete-eboard" name="add-newboard">
									Name:
									<?php

							      $sql = "SELECT * FROM eboard";
							      $params = array();
							      $eboard = exec_sql_query($db, $sql, $params);
							      if (isset($eboard) && !empty($eboard)) {
											echo "<select name='deleteboard'required>\n";
											echo "<option value='' selected disabled>Choose Member</option>";
							        foreach($eboard as $member) {
							          echo "<option value='" . htmlspecialchars($member['name']) . "'>" . htmlspecialchars($member['name']) . "</option>";
							        }
											echo "</select>";
							      } else {
											echo "<p>No eboard members.</p>";
										}
							    ?>
								 <div class = "break"></div>
								 <button name="submit" type="submit">Submit</button>
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
