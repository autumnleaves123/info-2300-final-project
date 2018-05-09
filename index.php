<!-- TODO: figure out regex for email -->

<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include('includes/init.php');
$current_page_id = "index";

// fetch all tags
$sql = "SELECT * FROM feed_tags";
$params = array();
$fetch_feed_tags = exec_sql_query($db, $sql, $params)->fetchAll();

// if user clicks on a tag
if ( isset($_GET["tag"])) {
	$current_tag = filter_input(INPUT_GET, 'tag', FILTER_SANITIZE_STRING);

	// fetch images based on TAGS
	$sql = "SELECT * FROM feed_to_tags INNER JOIN feed ON feed_to_tags.feed_id = feed.id WHERE tag_id = :current_tag";
	$params = array(':current_tag' => $current_tag);
	$fetch_feed_content = exec_sql_query($db, $sql, $params)->fetchAll();

} else {
	// no tags, so display all feed content
	$current_tag = NULL;

	// fetch feed content
	$sql = "SELECT * FROM feed";
	$params = array();
	$fetch_feed_content = exec_sql_query($db, $sql, $params)->fetchAll();
}

// listserv form
if (isset($_POST["index-listserv-submit"])) {
	$email = filter_input(INPUT_POST, 'index-listserv-email', FILTER_SANITIZE_EMAIL);
	$email = strtolower($email);
	$email = trim($email);

	// assume form inputs are valid
	$formValid = TRUE;

	if ($formValid) {
		record_message("Success! Thanks for joining.");
		mail("bt293@cornell.edu", "join", "", "From: " . $email);
	}
}

?>

<!DOCTYPE html>
<html lang="">

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

				<a href="about.php">find out more</a>
			</div>

			<div id="welcome-flex-right">
				<img alt="logo" src="images/welcome_image.jpg"/>
			</div>
		</div>

		<div id="feed">

			<div id="feed-flex-left">

				<?php
				if ( isset($_GET["tag"])) {
					$sql = "SELECT * FROM feed_tags WHERE id = :current_tag";
					$params = array(':current_tag' => $current_tag);
					$fetch_tag_name = exec_sql_query($db, $sql, $params)->fetchAll();

					?>
					<div id="search-criteria">
						<?php /*$unicodeChar = '\u2573';
						json_decode('"'.$unicodeChar.'"');*/
						echo "<p>Search results:</p><div id='tag-name'>" . $fetch_tag_name[0]['name'] . "</div><a href='index.php'><img src='../images/xout.png'></a>"; ?>
					</div>
				<?php } ?>

				<?php foreach($fetch_feed_content as $post) { ?>
						<div class="post">

							<!-- implement date ribbon here -->
							<h6 class="date-ribbon">
								<?php echo "$post[entry_date]";?>
							</h6>

							<h2><?php echo "$post[title]";?></h2>


							<?php
							$post_id = $post['id'];

							$sql = "SELECT feed_id, tag_id, name FROM feed_to_tags INNER JOIN feed_tags ON feed_to_tags.tag_id = feed_tags.id WHERE feed_id = :post_id";
							$params = array(':post_id' => $post_id);
							$feed_tags = exec_sql_query($db, $sql, $params)->fetchAll();
							?>

							<ul id="tags-in-post">
								<?php foreach ($feed_tags as $tag) { echo "<li>" .$tag['name'] ."</li>"; } ?>
							</ul>

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
						<input type="email" name="index-listserv-email" placeholder="netid@cornell.edu" pattern="/^[a-zA-Z0-9.!#$%&’*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/" required></input>
						<button name="index-listserv-submit" type="submit">subscribe</button>
					</form>

					<?php if ( isset ($_POST["index-listserv-submit"])) {
						print_messages();
					} ?>
				</div>

			</div>
		</div>

	</section>

		<?php include('includes/footer.php'); ?>
</body>
</html>
