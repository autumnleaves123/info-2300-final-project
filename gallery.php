<?php

include('includes/init.php');

$current_page_id = "gallery";

// just select all images for the time being
$sql = "SELECT * FROM images;";
$params = array();
$images = exec_sql_query($db, $sql, $params)->fetchAll();

$sql = "SELECT * FROM categories;";
$params = array();
$categories = exec_sql_query($db, $sql, $params)->fetchAll();

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
      <button>All photos</button>
      <?php
        foreach ($categories as $category) {
          echo "<button>" . $category['name'] . "</button>";
        }
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
