<?php include('includes/init.php');
$current_page_id = "login";
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" type="text/css" href="styles/all.css" media="all" />

  <title>Login</title>
</head>

<body>
	<!-- Don't need header -->
	<section>

		<!-- Check that we want to go ahead with this -->
		<?php if ($current_user) { header("Location: admin.php"); } ?>

		<div class="centered">
      <h1>Log-in</h1>
			<form id="login-form" action="login.php" method="POST">
				<input type="text" name="username" placeholder="Username" required/>
				<input type="password" name="password" placeholder="Password" required/>
				<!-- TODO: create button -->
				<button id="login-form-button" type="submit" name="login-form-button">Log In</button>
			</form>

			<p>-- or --</p>
			<a href="index.php" class="link">Return to website</a>
		</div>

  </section>

	<!-- Don't need footer -->
</body>

</html>
