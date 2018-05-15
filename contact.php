<?php
include('includes/init.php');
$current_page_id = "contact";

// when the user submits a form
if (isset($_POST["submit"])) {
		// show success message
	$email = $_POST['email'];
	$email = filter_var($email, FILTER_SANITIZE_EMAIL);
	record_message("You have been subscribed to the mailing list.");
  // mail("cudap-l-request@cornell.edu", "join", "", "From: " . $email);
	// Note to TAs: use your own emails to test this form, the client-version website will have the cudap email
	$send = mail("hl566@cornell.edu", "join", "", "From: " . $email);
}

// when the user submits a form
if (isset($_POST["submitmessage"])) {
	// validate form here
	$message = $_POST['message'];
	$message = filter_var($message, FILTER_SANITIZE_STRING);
  record_message("Your message has been received.");
	// mail("cudap-l-request@cornell.edu", "message", $message, "");
	// Note to TAs: use your own emails to test this form, the client-version website will have the cudap email
	mail("hl566@cornell.edu", "message", $message, "");
}

?>

<!DOCTYPE html>
<html>

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
			<?php print_messages();?>
			<div id="contactCentering">

				<div class="contactpage">
					<h2>Questions or Feedback?</h2>
					<!-- TODO: link this to send email? -->
					<p>Contact our officers at <span class="highlight"><a href="mailto:cudap@cornell.edu" target="_blank">cudap@cornell.edu</a></span>, or send us a message on <span class="highlight"><a class="highlight" href="https://www.facebook.com/cudeafawarenessproject/" target="_blank">Facebook</a></span>.<br/>
						You can also send us a message through this website on the bottom of this page! </p>
					</div>

					<div class="flex-div">
						<!-- TODO: create listserv form -->
						<div class="flex-left">
							<h2>Mailing List</h2>
							<p>Leave us your email for information and updates!</p>
							<form method="post" action="contact.php" id="joinForm">

								<div class="largeContainer">
									<div class="labelContainer">
										Email:
									</div>
									<input name="email" type="email" placeholder="netid@cornell.edu" required>
								</div>

								<div id="formButton">
									<button name="submit" type="submit" class="submit">subscribe to listserv</button>
								</div>

							</form>
						</div>

						<!-- TODO: create contact form -->
						<div class="flex-right">
							<h2>Send Us A Message</h2>
							<p>Please leave any inquiries, comments, and/or feedback you might have.</p>
							<form method="post" action="contact.php" id="messageForm" >
								<div class = "inputContainer">
									<textarea rows="7" cols="40" name="message" placeholder="Write your message here" required><?php if (isset($message)) { echo htmlentities($message, ENT_QUOTES); } ?></textarea>
								</div>
								<div class = "break"></div>
								<div id="messageButton">
									<button type="submit" name="submitmessage">submit message</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>

		</section>

		<?php include('includes/footer.php'); ?>

	</body>
</html>
