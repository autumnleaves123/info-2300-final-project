<?php

include('includes/init.php');

$current_page_id = "gallery";

// fetch gallery/images array

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" type="text/css" href="styles/all.css" media="all" />

  <title>Gallery</title>
</head>

<body>
  <?php include("includes/header.php"); ?>

  <section class = "content">
		<h1>Gallery</h1>

		<!-- TODO: Print images from gallery/images array -->

    <div class="row">
      <div class="column">
        <img src="/uploads/images/wedding.jpg" style="width:100%">
        <img src="/uploads/images/rocks.jpg" style="width:100%">
        <img src="/uploads/images/falls2.jpg" style="width:100%">
        <img src="/uploads/images/paris.jpg" style="width:100%">
        <img src="/uploads/images/nature.jpg" style="width:100%">
        <img src="/uploads/images/mist.jpg" style="width:100%">
        <img src="/uploads/images/paris.jpg" style="width:100%">
      </div>
      <div class="column">
        <img src="/uploads/images/underwater.jpg" style="width:100%">
        <img src="/uploads/images/ocean.jpg" style="width:100%">
        <img src="/uploads/images/wedding.jpg" style="width:100%">
        <img src="/uploads/images/mountainskies.jpg" style="width:100%">
        <img src="/uploads/images/rocks.jpg" style="width:100%">
        <img src="/uploads/images/underwater.jpg" style="width:100%">
      </div>
      <div class="column">
        <img src="/uploads/images/wedding.jpg" style="width:100%">
        <img src="/uploads/images/rocks.jpg" style="width:100%">
        <img src="/uploads/images/falls2.jpg" style="width:100%">
        <img src="/uploads/images/paris.jpg" style="width:100%">
        <img src="/uploads/images/nature.jpg" style="width:100%">
        <img src="/uploads/images/mist.jpg" style="width:100%">
        <img src="/uploads/images/paris.jpg" style="width:100%">
      </div>
      <div class="column">
        <img src="/uploads/images/underwater.jpg" style="width:100%">
        <img src="/uploads/images/ocean.jpg" style="width:100%">
        <img src="/uploads/images/wedding.jpg" style="width:100%">
        <img src="/uploads/images/mountainskies.jpg" style="width:100%">
        <img src="/uploads/images/rocks.jpg" style="width:100%">
        <img src="/uploads/images/underwater.jpg" style="width:100%">
      </div>
    </div>


  </section>

  <?php include('includes/footer.php'); ?>

</body>
</html>
