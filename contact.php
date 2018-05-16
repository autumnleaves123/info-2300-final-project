<?php
include('includes/init.php');
$current_page_id = "contact";

// when the user submits a form
if (isset($_POST["submit"])) {
		// show success message
	$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
	record_message("[You have been subscribed to the mailing list.]");
  mail("cudap-l-request@cornell.edu", "join", "", "From: " . $email);
	// to TAs: you can replace cudap-l-request@cornell.edu with your personal email in the mail() function to test that the form works
}

// when the user submits a form
if (isset($_POST["submitmessage"])) {
	// validate form here
	$message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);
  record_message("[Your message has been sent.]");
	mail("cudap@cornell.edu", "Message From Website", $message, "");
	// to TAs: you can replace cudap@cornell.edu with your personal email in the mail() function to test that the form works
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="stylesheet" type="text/css" href="styles/all.css" media="all" />
	<link rel="stylesheet" type="text/css" href="styles/tablet.css"/>
	<link rel="stylesheet" type="text/css" href="styles/mobile.css"/>

	<title>Contact</title>

</head>

<body>
	<?php include("includes/header.php"); ?>

	<section class="content">
		<h1>Contact Us</h1>

		<div class="white-background no-padding">
			<div id="contactCentering">
				<?php print_messages();?>
				<div class="contactpage">
					<h2>Questions or Feedback?</h2>
					<p>Contact our officers at <span class="highlight"><a href="mailto:cudap@cornell.edu" target="_blank">cudap@cornell.edu</a></span>, or send us a message on <span class="highlight"><a class="highlight" href="https://www.facebook.com/cudeafawarenessproject/" target="_blank">Facebook</a></span>.<br/>
						You can also send us a message through this website on the bottom of this page! </p>
					</div>

					<div class="flex-div">

						<!-- add to listserv form -->
						<div class="flex-left">
							<h2>Mailing List</h2>
							<p>Leave us your email for information and updates!</p>
							<form method="post" action="contact.php" id="joinForm">
								<input name="email" type="email" placeholder="netid@cornell.edu" required>
								<button name="submit" type="submit" class="submit">subscribe to listserv</button>
							</form>
						</div>

						<!-- contact form -->
						<div class="flex-right">
							<h2>Send Us A Message</h2>
							<p>Please leave any inquiries, comments, and/or feedback you might have.</p>
							<form method="post" action="contact.php" id="messageForm" >
								<textarea rows="7" cols="40" name="message" placeholder="Write your message here" required></textarea>
								<button type="submit" name="submitmessage">submit message</button>
							</form>
						</div>

					</div>
				</div>
			</div>
		</section>
		<?php include('includes/footer.php'); ?>

	</body>
</html>
