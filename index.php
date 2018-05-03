<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include('includes/init.php');
$current_page_id = "index";

// fetch feed content
$sql = "SELECT * FROM feed";
$params = array();
$fetch_feed_content = exec_sql_query($db, $sql, $params)->fetchAll();

// fetch tags
$sql = "SELECT * FROM feed_tags";
$params = array();
$fetch_feed_tags = exec_sql_query($db, $sql, $params)->fetchAll();

?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="stylesheet" type="text/css" href="styles/all.css" media="all" />

	<title>Home</title>
</head>

<body>
	<?php include('includes/header.php'); ?>

	<section id="index">

		<!-- TODO: use a different image or add some color to current banner -->
		<img id="banner-image" alt="banner" src="images/banner2.jpg"/>

		<div id="welcome">
			<div id="welcome-flex-left">
				<h1>Welcome</h1>

				<p>We are the Cornell University Deaf Awareness Project (CUDAP), a student-run program of the Cornell Public Service Center. Join us to learn more about and participate in raising awareness of the issues facing the Deaf community!</p>

				<a href="about.php">Find out more</a>
			</div>

			<div id="welcome-flex-right">
				<img alt="logo" src="images/welcome_image.jpg"/>
			</div>
		</div>

		<div id="feed">

			<div id="feed-flex-left">
				<?php foreach($fetch_feed_content as $post) { ?>
						<div class="post">
							<h2><?php echo "$post[title]";?></h2>
							<p><?php echo "$post[entry_date]";?></p>
							<p><?php echo "$post[content]";?></p>
						</div>
				<?php } ?>
			</div>

			<div id="feed-flex-right">
				<div id="feed-tags">
					<h2>Tags</h2>
					<ul>
						<?php foreach($fetch_feed_tags as $tag) {
							echo("<li><a href='/index.php?tag=" . $tag['id'] . "'>" . $tag['name'] ."</a></li>"); }
						?>
					</ul>
				</div>

				<div id="feed-listserv">
					<h2>Join our listserv</h2>
					<form method="post" action="index.php" id="add-listserv" name="add-listserv">
						<input type="email" placeholder="netid@cornell.edu" required></input>
						<button name="submit" type="submit">Subscribe</button>
					</form>
				</div>

			</div>
		</div>

	</section>

		<?php include('includes/footer.php'); ?>
</body>
</html>
