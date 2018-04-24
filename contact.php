<?php include('includes/init.php');
$current_page_id = "contact";

$HIDDEN_ERROR_CLASS = "hiddenError";
// Get information about the form
$submit = $_POST["submit"];

// when the user submits a form
if (isset($submit)) {
	// validate form here
	$firstName = $_POST['firstName'];
	// if the first name field is not empty:
	if ( !empty($firstName) ) {
		// the first name field is valid
		$fnameFilled = true;
		if ((strlen(strval($firstName)) >= 2) && (ctype_alpha(str_replace(' ', '', $firstName)))) {
			$fnameValid = true;
			$fnameLetter = true;
		} else {
			$fnameValid = false;
			$fnameLetter = false;
		}
	} else {
		// the first name field is not valid
		$fnameValid = false;
		$fnameFilled = false;
		//disable letter error msg because filled is already showing
		$fnameLetter = true;
	}

	$lastName = $_POST['lastName'];
	// if the last name field is not empty:
	if ( !empty($lastName) ) {
		// the first name field is valid
		$lnameFilled = true;
		if ((strlen(strval($lastName)) >= 2) && (ctype_alpha(str_replace(' ', '', $lastName)))) {
			$lnameValid = true;
			$lnameLetter = true;
		} else {
			$lnameValid = false;
			$lnameLetter = false;
		}
	} else {
		// the first name field is not valid
		$lnameValid = false;
		$lnameFilled = false;
		//disable letter error msg because filled is already showing
		$lnameLetter = true;
	}

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

	$formValid = $fnameValid && $lnameValid && $emailValid;
	// if valid, allow submission
	if ($formValid) {
		// show success message
    record_message("You have been subscribed to the mailing list.");
	}
} else {
	// no form submitted
	// put default behavior here
	$fnameValid = true;
	$fnameLetter = true;
	$fnameFilled = true;
	$lnameValid = true;
	$lnameLetter = true;
	$lnameFilled = true;
	$emailValid = true;
	$emailFilled = true;
	$emailValEmail = true;
}

$submitmessage = $_POST["submitmessage"];

// when the user submits a form
if (isset($submitmessage)) {
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
}

?>

<!DOCTYPE html>
<html>

<head>
  <?php include('includes/head.php'); ?>
  <title>Contact</title>

</head>

<body>
  <?php include("includes/header.php"); ?>

  <section class = "content">
		<h1>Contact Us</h1>
    <?php print_messages();?>
    <div id="contactCentering">

      <div class="contactpage">
        <h2>Questions or Feedback?</h2>
        <!-- TODO: link this to send email? -->
        <p>Contact our officers at <span class="highlight"><a href="mailto:cudap@cornell.edu" target="_blank">cudap@cornell.edu</a></span>, or send us a message on <span class="highlight"><a class="highlight" href="https://www.facebook.com/cudeafawarenessproject/" target="_blank">Facebook</a></span>.
          You can also send us a message through this website on the bottom of this page! </p>
      </div>

      <!-- TODO: create listserv form -->
      <div class="contactpage">
        <h2>Mailing List</h2>
        <p>Leave us your email for more information and updates!</p>
        <form method="post" action="contact.php" id="joinForm" novalidate>

          <div class="largeContainer">
            <div class="labelContainer">
              <label for="firstName">First Name: </label>
            </div>
            <div class="inputContainer">
              <input id="firstName" name="firstName" value="<?php if (!$fnameValid) { echo($firstName);}?>" placeholder="First name" required>
            </div>
            <span class="errorContainer  <?php if ($fnameFilled) {echo($HIDDEN_ERROR_CLASS);}?>" id="fnameError1">
              First name is required.
            </span>
            <span class="errorContainer  <?php if ($fnameLetter) {echo($HIDDEN_ERROR_CLASS);}?>" id="fnameError2">
              First name must consist of 2 or more letters.
            </span>
          </div>

          <div class="largeContainer">
            <div class="labelContainer">
              <label for="lastName">Last Name: </label>
            </div>
            <div class="inputContainer">
              <input id="lastName" name="lastName" value="<?php if (!$lnameValid) {echo($lastName);}?>" placeholder="Last name" required>
            </div>
            <span class="errorContainer <?php if ($lnameFilled) {echo($HIDDEN_ERROR_CLASS);}?>" id="lnameError1">
              Last name is required.
            </span>
            <span class="errorContainer <?php if ($lnameLetter) {echo($HIDDEN_ERROR_CLASS);}?>" id="lnameError2">
              Last name must consist of 2 or more letters.
            </span>
          </div>

          <div class="largeContainer">
            <div class="labelContainer">
              <label for="email">Email: </label>
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
            <button name="submit" type="submit" class="submit">SUBSCRIBE TO LISTSERV</button>
          </div>
        </form>
      </div>

      <!-- TODO: create contact form -->
      <div class="contactpage">
        <h2>Send Us A Message</h2>
        <p>Any inquiries, comments, and/or feedback you may have, <br/>you can communicate to us using this message form.</p>
        <form method="post" action="contact.php" id="messageForm">
          Message: <div class = "break"></div>
          <textarea rows = "7" cols = "40" name = "message" placeholder="Write your message here" required><?php if (isset($message)) { echo htmlentities($message, ENT_QUOTES); } ?></textarea> <div class = "break"></div>
          <div id="messageButton">
            <button type = "submit" name = "submitmessage">SUBMIT MESSAGE</button>
          </div>
        </form>
      </div>

    </div>


  </section>

  <?php include('includes/footer.php'); ?>

</body>
</html>
