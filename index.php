<?php

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
	$sql = "SELECT * FROM feed_to_tags INNER JOIN feed ON feed_to_tags.feed_id = feed.id WHERE tag_id = :current_tag ORDER BY feed.id DESC";
	$params = array(':current_tag' => $current_tag);
	$fetch_feed_content = exec_sql_query($db, $sql, $params)->fetchAll();

} else {
	// no tags, so display all feed content
	$current_tag = NULL;

	// fetch feed content
	$sql = "SELECT * FROM feed ORDER BY id DESC LIMIT 10";
	$params = array();
	$fetch_feed_content = exec_sql_query($db, $sql, $params)->fetchAll();
}

// listserv form
if (isset($_POST["index-listserv-submit"])) {
	$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
  // mail("cudap-l-request@cornell.edu", "join", "", "From: " . $email);
	mail("acw227@cornell.edu", "join", "", "From: " . $email);
	record_message("[Success!]");
	// to TAs: you can replace cudap-l-request@cornell.edu with your personal email in the mail() function to test that the form works

}


?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1"/>
	<link rel="stylesheet" type="text/css" href="styles/all.css" media="all"/>
	<link rel="stylesheet" type="text/css" href="styles/tablet.css"/>
	<link rel="stylesheet" type="text/css" href="styles/mobile.css"/>

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

				<!-- Search criteria that appears if a user chooses to filter posts by tags -->
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

				<!-- for each post -->
				<?php foreach($fetch_feed_content as $post) { ?>
						<div class="post">
							<h6 class="date-ribbon"><?php echo "$post[entry_date]";?></h6>
							<h2><?php echo "$post[title]";?></h2>

							<?php
							$post_id = $post['id'];

							$sql = "SELECT feed_id, tag_id, name FROM feed_to_tags INNER JOIN feed_tags ON feed_to_tags.tag_id = feed_tags.id WHERE feed_id = :post_id";
							$params = array(':post_id' => $post_id);
							$feed_tags = exec_sql_query($db, $sql, $params)->fetchAll();
							?>

							<ul class="tags-in-post">
								<?php foreach ($feed_tags as $tag) { echo "<li>" .$tag['name'] ."</li>"; } ?>
							</ul>

							<p><?php echo "$post[content]";?></p>

							<!-- TODO: echo attachments and links -->
							<!-- TODO: add http -->
							<?php if ($post['url_1'] == NULL && $post['url_2'] == NULL) { echo "";
							} else { echo "<h3>Links:</h3>"; }; ?>
							<?php echo "<a class='url' href=$post[url_1] target='_blank'>Link 1</a><br>";?>
							<?php echo "<a class='url' href=$post[url_2] target='_blank'>Link 2</a>";?>

							<!-- TODO: handle attachment stuff (href)-->
							<?php
								$sql = "SELECT feed_attachment_id, file_ext, file_name FROM feed_to_feed_attachments INNER JOIN feed_attachments ON feed_attachments.id = feed_to_feed_attachments.feed_attachment_id WHERE feed_id = :post_id";
								$params = array(':post_id' => $post_id);
								$fetch_attachments = exec_sql_query($db, $sql, $params)->fetchAll();

								if (sizeof($fetch_attachments)>0) {
									echo "<h3 class='attachment-title'>Attachments:</h3>";
									foreach($fetch_attachments as $attachment) {
										echo "<a class='file-attachment' target='_blank' href='uploads/feed/" . $attachment['feed_attachment_id'] . "." . $attachment['file_ext'] . "'>" . $attachment['file_name'] . "</a>";
									}
								}
							?>

						</div>
				<?php } ?>

				<div id="tenposts"><p>Displaying up to 10 most recent posts.</p></div>
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
						<input type="email" name="email" placeholder="netid@cornell.edu" required>
						<button name="index-listserv-submit" type="submit">subscribe</button>
						<p><?php if (isset($_POST["index-listserv-submit"])) { print_messages(); } ?></p>
					</form>
				</div>

			</div>

		</div>



	</section>

		<?php include('includes/footer.php'); ?>
</body>
</html>
