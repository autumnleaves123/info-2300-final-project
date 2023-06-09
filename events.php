<?php include('includes/init.php');
$current_page_id = "events"; ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="stylesheet" type="text/css" href="styles/all.css" media="all" />
	<link rel="stylesheet" type="text/css" href="styles/tablet.css"/>
	<link rel="stylesheet" type="text/css" href="styles/mobile.css"/>

  <title>Events</title>
</head>

<body>
  <?php include("includes/header.php"); ?>

  <section class="content">
		<h1>Events</h1>

		<div class="white-background">
			<table>
				<tr>
					<th>Date</th>
					<th>Time</th>
					<th>Location</th>
					<th>Event</th>
				</tr>

				<tr>
					<td>April 17 2018</td>
					<td>4:30PM - 6:00PM</td>
					<td>Ives Hall Room 116</td>
					<td>Undergraduate Disability Studies Journal Panel</td>
				</tr>

				<tr>
					<td>April 18 2018</td>
					<td>5:30PM - 6:30PM</td>
					<td>Goldwin Smith Hall Room 164</td>
					<td>Sign Choir Meeting</td>
				</tr>

				<tr>
					<td>April 24 2018</td>
					<td>9:00PM</td>
					<td>Balch Hall</td>
					<td>CUDAP Arch Sign</td>
				</tr>
			</table>
		</div>
  </section>
  <?php include('includes/footer.php'); ?>

</body>
</html>
