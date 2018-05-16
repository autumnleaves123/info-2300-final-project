<?php

include('includes/init.php');

$current_page_id = "gallery";

$sql = "SELECT * FROM categories;";
$params = array();
$categories = exec_sql_query($db, $sql, $params)->fetchAll();

$selected_cat = 'all';

if (empty($_GET['category'])) {
  $sql = "SELECT * FROM images;";
  $params = array();
  $images = exec_sql_query($db, $sql, $params)->fetchAll();
} else {
  foreach ($categories as $category) {
    if ($_GET['category'] == $category['name']) {
      $selected_cat = $category['name'];
      $sql = "SELECT images.*  FROM images INNER JOIN images_cats ON images.id = images_cats.image_id INNER JOIN categories ON images_cats.cat_id = categories.id WHERE categories.name = :cat;";
      $params = array(':cat' => $category['name']);
      $images = exec_sql_query($db, $sql, $params)->fetchAll();
    }
  }
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

  <script src="scripts/gallery.js"></script>
  <title>Gallery</title>
</head>

<body>
  <?php include("includes/header.php"); ?>

  <section class="content">
		<h1>Gallery</h1>

    <!-- Category Buttons -->
    <div id="category-buttons">
      <form action="gallery.php" method="get">
        <button <?php if ($selected_cat == 'all') echo "class=\"selected\""; ?> type="submit">All photos</button>
      </form>
      <?php
        foreach ($categories as $category) { ?>
          <form action="gallery.php" method="get">
            <input hidden name="category" value="<?php echo $category['name']; ?>" />
            <button <?php if ($selected_cat == $category['name']) echo "class=\"selected\""; ?> type="submit"><?php echo $category['name']; ?></button>
          </form>
        <?php }
      ?>
    </div>

    <!-- GALLERY -->
    <!-- referenced from https://www.w3schools.com/howto/howto_js_lightbox.asp and https://www.w3schools.com/howto/howto_css_image_grid_responsive.asp -->
		<!-- Gallery images were provided by CUDAP -->
    <div class="row">
      <?php $colsize = (int) floor(count($images) / 4);
      $rem = count($images) % 4;
      $remainder = $rem;
      $counter = 0;
      for ($i = 0; $i < 4; $i++) {
        $max = $colsize;
        if ($remainder > 0) {
          $max++;
          $remainder--;
        } ?>
        <div class="column-gal">
        <?php for ($j = 0; $j < $max; $j++) { ?>
          <div class="container">
            <img src="<?php echo "uploads/images/" . $images[$counter]['id'] . "." . $images[$counter]['file_ext']; ?>" onclick="openLightbox();currentImage(<?php echo $counter + 1; ?>)" alt="<?php echo $images[$counter]['title']; ?>" />
            <div class="overlay" onclick="openLightbox();currentImage(<?php echo $counter + 1; ?>)">
              <div class="title"><?php echo $images[$counter]['title']; ?></div>
            </div>
          </div>
        <?php $counter++; } ?>
        </div>
      <?php } ?>
    </div>

    <!-- LIGHTBOX -->
    <div id="lightbox-section" class="lightbox">
      <span class="close cursor" onclick="closeLightbox()">&times;</span>
      <div class="lightbox-content">

        <?php $remainder = $rem;
        $counter = 0;
        for ($i = 0; $i < 4; $i++) {
          $max = $colsize;
          if ($remainder > 0) {
            $max++;
            $remainder--;
          } ?>
          <?php for ($j = 0; $j < $max; $j++) { ?>
            <div class="lightbox-image">
              <div class="numbertext"><?php echo $counter + 1 . " / " . count($images); ?></div>
              <img src="<?php echo "uploads/images/" . $images[$counter]['id'] . "." . $images[$counter]['file_ext']; ?>" onclick="openLightbox();currentImage(<?php echo $counter + 1; ?>)" alt="<?php echo $images[$counter]['title']; ?>" />
            </div>
          <?php $counter++; } ?>
        <?php } ?>

        <!-- Next/previous controls -->
        <a class="prev" onclick="plusImages(-1)">&#10094;</a>
        <a class="next" onclick="plusImages(1)">&#10095;</a>
      </div>
    </div>

  </section>
  <?php include('includes/footer.php'); ?>

</body>
</html>
