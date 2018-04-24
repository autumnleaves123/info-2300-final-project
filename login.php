<?php include('includes/init.php');
$current_page_id = "login"; ?>

<!DOCTYPE html>
<html>

<head>
  <?php include('includes/head.php'); ?>
  <title>Login</title>
</head>

<body>
	<!-- Don't need header -->

	<section class = "content">

		<form id="login-form" action="login.php" method="POST">
			<input type="text" name="username" placeholder="Username" required/>
			<input type="password" name="password" placeholder="Password" required/>
			<!-- TODO: create button -->
			<button id="login-form-button" type="submit"></button>
		</form>

  </section>

	<!-- Don't need footer -->
</body>

</html>
