<?php include('includes/init.php');
$current_page_id = "login";

// TODO: implement login
// use header function to take user to admin page

// LOGIN
// Check if we should login the user
if (isset($_POST['login-form-button'])) {
  $username = trim(filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING));
  $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

  $current_user = log_in($username, $password);

  if ($current_user) {
    header("Location: admin.php");
  } else {
    array_push($messages, "incorrect username or password");
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php include('includes/head.php'); ?>
  <title>Login</title>
</head>

<body>
	<!-- Don't need header -->

	<section>

		<div class="centered">
			<form id="login-form" action="login.php" method="POST">
				<input type="text" name="username" placeholder="Username" required/>
				<input type="password" name="password" placeholder="Password" required/>
				<!-- TODO: create button -->
				<button id="login-form-button" type="submit" name="login-form-button">Log In</button>
			</form>

			<p>-- Or --</p>
			<a href="index.php">Return to website</a>
		</div>

  </section>

	<!-- Don't need footer -->
</body>

</html>
