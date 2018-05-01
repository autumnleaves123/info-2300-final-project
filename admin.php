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
					<ul>
						<li id="grey-out">Update</li>
						<a href="#admin-feed-click"><li>Feed</li></a>
						<a href="#admin-eboard"><li>Eboard</li></a>
						<a href="#"><li>Gallery</li></a>
						<a href="#"><li>Signs</li></a>
						<a href="#"><li>Resources</li></a>
					</ul>

					<form id="logout-form" action="admin.php" method="POST">
			      <button id="logout-form-button" type="submit" name="logout-button">Log Out</button>
			    </form>
				</div>

				<div id="admin-content">

					<!-- Edit feed forms -->
					<div id="admin-feed">
						<h4>Admin Feed</h4>
						<p>Lorem ipsum dolor sit amet, eum id dolorem maiorum forensibus, no nec fabellas expetendis. Doming debitis nam an. Possim timeam reformidans vix ei, has in sale singulis recteque. Mea te assum graecis consequuntur, duo an ignota qualisque instructior. Lorem ipsum dolor sit amet, molestie velit vel risus, quam ut ac nisl sit ante, vel donec orci viverra nibh, quam dui bibendum, nam venenatis nam in pellentesque libero id. Morbi felis habitant luctus wisi commodo, aliquet tortor ipsum, a ac justo at mauris lectus provident. Integer felis ac dolor aliquam. Pulvinar urna at urna magna pellentesque. Vitae vel magnis aenean sed, phasellus sagittis in quis sed, cras morbi pellentesque suspendisse aptent et, velit lectus sed elementum justo magna at. Curae interdum donec platea, venenatis quisque eu rutrum, accumsan ut, tincidunt imperdiet sit amet mi lacus, at habitant. Et ac, augue erat pellentesque, id cursus sem proin neque, eu velit tincidunt veniam dapibus mauris donec. Adipiscing lacinia in fusce scelerisque, lectus amet sollicitudin, proin quisque nascetur nulla. Euismod enim duis sed, a sit ipsum enim, id nec et donec rutrum, pellentesque pulvinar turpis. Proin est, mollis tristique, dis in consequat faucibus. Ut phasellus ultricies nulla sapien risus porttitor. Vel tellus metus nascetur, pellentesque nascetur duis, turpis dictum morbi, varius eget sed ad scelerisque id eu. Quis a cum, at natoque faucibus facilisis at, est consequat sit feugiat, aliquet in amet, tortor sollicitudin quisque erat sit ut. Hendrerit ridiculus cum sed orci non urna, felis sed pede porttitor a sapien libero. Tempor integer dui ultricies etiam vitae, hymenaeos rutrum nonummy, sit varius, nam neque platea eget. Fermentum venenatis ante viverra libero elementum. Convallis dictum tristique orci suspendisse nunc aliquam, sed hendrerit eleifend ac, accumsan sit pellentesque morbi, nibh architecto, donec lectus magnis. Nec euismod bibendum, leo porttitor, aptent eleifend sit, cursus mollis felis quis. A sit vestibulum eleifend. Tempus mauris hymenaeos dignissim nec nunc, sem non fermentum nec in, ante quam, vivamus ac fringilla a, dui hendrerit auctor habitant nunc praesent. Suscipit et, mi arcu convallis dictum lectus, consectetuer ipsum sem. Congue lacus scelerisque diam vulputate, in malesuada euismod ut in lorem, at vitae sit risus, tempor per. Mollis tortor congue nam at volutpat, magnis ligula luctus non eu consequat id, ac blandit. Nec odio ut tortor erat aliquam. Lacinia amet ut magnis cras luctus sollicitudin, dui sollicitudin metus, fusce facilisis netus pede tellus luctus ut, nullam justo, et sociosqu etiam. Mauris neque magna lobortis vulputate. Elementum id semper ligula odio mi malesuada, lorem ut ac vestibulum praesent, lectus integer imperdiet imperdiet nam integer, mattis vivamus aptent in blandit a, sed rutrum nec nulla dignissim nibh lectus. Nam eget nunc etiam, aliquam sed, dui mi eu ac nunc suspendisse, aenean egestas, nunc vitae sapien elit dolor. Curabitur dapibus ligula, leo et nibh justo dictum dapibus. Sed pellentesque sed at. Urna faucibus maecenas donec luctus vitae, ultricies aliquet condimentum, morbi varius urna est massa vestibulum, quisque vehicula tincidunt a condimentum mauris ut, sed sed vestibulum. Eu tempor aliquam inceptos gravida tincidunt, eleifend porttitor, mauris vitae quam neque ligula. Ligula vel sem elit tincidunt, quam a wisi curabitur nunc a, sem iaculis lectus pellentesque maecenas etiam ut, ut arcu dolor enim in sollicitudi
						</p>
					</div>

					<!-- Edit eboard forms -->
					<div id="admin-eboard">
						<h4>Admin Eboard</h4>
						<p>Lorem ipsum dolor sit amet, eum id dolorem maiorum forensibus, no nec fabellas expetendis. Doming debitis nam an. Possim timeam reformidans vix ei, has in sale singulis recteque. Mea te assum graecis consequuntur, duo an ignota qualisque instructior.</p>
					</div>

					<!-- Edit gallery forms -->
					<div id="admin-gallery"></div>

					<!-- Edit signs forms -->
					<div id="admin-signs"></div>

					<!-- Edit resources forms -->
					<div id="admin-resources"></div>

				</div>
			</div>

		</div>


	</section>

	<?php include("includes/footer.php"); ?>
</body>
</html>
