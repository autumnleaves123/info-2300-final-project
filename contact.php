<?php
include('includes/init.php');
$current_page_id = "contact";

$HIDDEN_ERROR_CLASS = "hiddenError";

// when the user submits a form
if (isset($_POST["submit"])) {

	$email = $_POST["userEmail"];
	if ( !empty($email) ) {
		// the first name field is valid
		$emailFilled = true;
		if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$emailValid = true;
			$emailValEmail = true;
		} else {
			$emailValid = false;
			$emailValEmail = false;
		}
	} else {
		// the first name field is not valid
		$emailValid = false;
		$emailFilled = false;
		//disable letter error msg because filled is already showing
		$emailValEmail = true;
	}

	$formValid = $emailValid;
	// if valid, allow submission
	if ($formValid) {
		// show success message
    record_message("You have been subscribed to the mailing list.");
	}
} else {
	// no form submitted
	// put default behavior here
	$emailValid = true;
	$emailFilled = true;
	$emailValEmail = true;
}


//
// when the user submits a form
if (isset($_POST["submitmessage"])) {
	// validate form here
	$message = $_POST['message'];
	// if the first name field is not empty:
	if ( !empty($message) ) {
		// the first name field is valid
		$messageFilled = true;
    record_message("Your message has been received.");
	} else {
		// the first name field is not valid
		$messageFilled = false;
	}
} else {
	$messageFilled = true;
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
							<form method="post" action="contact.php" id="joinForm" novalidate>

								<div class="largeContainer">
									<div class="labelContainer">
										<label for="userEmail">Email: </label>
									</div>
									<div class="inputContainer">
										<input type="email" id="userEmail" name="userEmail" value="<?php if (!$emailValid) {echo($email);}?>" placeholder="Your Email" required>
									</div>
									<span class="errorContainer <?php if ($emailFilled) {echo($HIDDEN_ERROR_CLASS);}?>" id="emailErrorNoEmail">
										Email is required.
									</span>
									<span class="errorContainer <?php if ($emailValEmail) {echo($HIDDEN_ERROR_CLASS);}?>" id="emailErrorInvalEmail">
										Not a valid email address.
									</span>
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
							<form method="post" action="contact.php" id="messageForm" novalidate>
								Message:
								<div class = "inputContainer">
									<textarea rows = "7" cols = "40" name = "message" placeholder="Write your message here" required><?php if (isset($message)) { echo htmlentities($message, ENT_QUOTES); } ?></textarea>
								</div>
								<span class="errorContainer <?php if ($messageFilled) {echo($HIDDEN_ERROR_CLASS);}?>" id="msgErrorNoMsg">
									Message is required.
								</span>
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
