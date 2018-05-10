<?php
include('includes/init.php');
$current_page_id = "contact";

// when the user submits a form
if (isset($_POST["submit"])) {
		// show success message
	$email = $_POST['email'];
	record_message("You have been subscribed to the mailing list.");
  mail("cudap-l-request@cornell.edu", "join", "", "From: " . $email);
}


//
// when the user submits a form
if (isset($_POST["submitmessage"])) {
	// validate form here
	$message = $_POST['message'];
  record_message("Your message has been received.");
	mail("cudap-l-request@cornell.edu", "message", $message, "");
}

?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" type="text/css" href="styles/all.css" media="all" />

  <title>Contact</title>

</head>

<body>
	<?php include("includes/header.php"); ?>

	<section class="content2">
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
							<p>Leave us your email for more information and updates!</p>
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
							<p>Any inquiries, comments, and/or feedback you may have, <br/>you can communicate to us using this message form.</p>
							<form method="post" action="contact.php" id="messageForm" >
								Message:
								<div class = "inputContainer">
									<textarea rows = "7" cols = "40" name = "message" placeholder="Write your message here" required><?php if (isset($message)) { echo htmlentities($message, ENT_QUOTES); } ?></textarea>
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
