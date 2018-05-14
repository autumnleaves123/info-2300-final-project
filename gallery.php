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
  <script src="scripts/gallery.js"></script>

  <title>Gallery</title>
</head>

<body>
  <?php include("includes/header.php"); ?>

  <section class = "content2">
		<h1>Gallery</h1>

		<!-- Maybe add tags at the top for filtering? -->

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
    <div class="row">
      <?php $colsize = (int) floor(count($images) / 4);
      for ($i = 0; $i < 4; $i++) { ?>
        <div class="column-gal">
        <?php for ($j = 0; $j < $colsize && !empty($images[$colsize * $i + $j]); $j++) { ?>
          <div class="container">
            <img src="<?php echo "uploads/images/" . $images[$colsize * $i + $j]['id'] . "." . $images[$colsize * $i + $j]['file_ext']; ?>" onclick="openModal();currentSlide(<?php echo $colsize * $i + $j + 1; ?>)" alt="<?php echo $images[$colsize * $i + $j]['title']; ?>" />
            <div class="overlay" onclick="openModal();currentSlide(<?php echo $colsize * $i + $j + 1; ?>)">
              <div class="title"><?php echo $images[$j]['title']; ?></div>
            </div>
          </div>
        <?php } ?>
        </div>
      <?php } ?>
    </div>

    <!-- LIGHTBOX -->
    <div id="lightbox" class="modal">
      <span class="close cursor" onclick="closeModal()">&times;</span>
      <div class="modal-content">

        <?php $colsize = (int) floor(count($images) / 4);
        for ($i = 0; $i < 4; $i++) { ?>
          <?php for ($j = 0; $j < $colsize && !empty($images[$colsize * $i + $j]); $j++) { ?>
            <div class="lightbox-image">
              <div class="numbertext"><?php echo $colsize * $i + $j + 1 . " / " . count($images); ?></div>
              <img src="<?php echo "uploads/images/" . $images[$colsize * $i + $j]['id'] . "." . $images[$colsize * $i + $j]['file_ext']; ?>" onclick="openModal();currentSlide(<?php echo $colsize * $i + $j + 1; ?>)" alt="<?php echo $images[$colsize * $i + $j]['title']; ?>" />
            </div>
          <?php } ?>
        <?php } ?>

        <!-- Next/previous controls -->
        <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
        <a class="next" onclick="plusSlides(1)">&#10095;</a>

        <!-- Caption text -->
        <div class="caption-container">
          <p id="caption"></p>
        </div>
      </div>
    </div>

  </section>

  <?php include('includes/footer.php'); ?>

</body>
</html>
