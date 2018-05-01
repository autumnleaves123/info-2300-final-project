cat<?php /*include('includes/init.php');
$current_page_id = "learn";

// check to see if there is an image GET requested

if ((isset($_GET["id"]) or !empty($_GET["id"])) && sign_exists($_GET["id"])) {
  $sign_id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);
} else {
  header("Location: signs.php");
  exit;
}

// QUERY DATABASE
$sql = "SELECT * FROM signs WHERE signs.id = :sign_id";
$params = array(":sign_id"=>$sign_id);
$sign_records = exec_sql_query($db, $sql, $params)->fetchAll();*/
?>

<?php
$page_name = 'image';
include('includes/init.php');

// if somehow this page is accessed with no get request, redirect to homepage
if (empty($_GET['image_id'])) {
  header("Location: index.php");
  exit;
}

// try and get image from database
$image_id = filter_input(INPUT_GET, 'image_id', FILTER_SANITIZE_STRING);
$sql = "SELECT * FROM images WHERE id = :id;";
$params = array(':id' => $image_id);
$records = exec_sql_query($db, $sql, $params)->fetchAll();

// show error if image is not found or if somehow more than 1 image shows up?
$display_image = true;
$display_confirmation = false;
if (empty($records) || count($records) > 1) {
  $display_image = false;
  record_message("An error has occurred.");
} elseif (isset($_POST['confirm_delete'])) { // TODO: delete image if received confirmation
  $display_image = false;
  // remove image from database along with all image category relationships
  $image_ext = $records[0]['file_ext'];

  $sql = "DELETE FROM images WHERE id = :id";
  $params = array(':id' => $image_id);
  $result = exec_sql_query($db, $sql, $params);

  if (empty($result)) {
    record_message("Error deleting image.");
  } else {
    $sql = "DELETE FROM images_cats WHERE image_id = :image_id";
    $params = array(':image_id' => $image_id);
    $result = exec_sql_query($db, $sql, $params);

    if (empty($result)) {
      record_message("Error deleting image.");
    } else {
      // delete any categories which now have no images
      $sql = "SELECT id FROM categories;";
      $params = array();
      $all_cats = exec_sql_query($db, $sql, $params)->fetchAll();

      foreach ($all_cats  as $cat) {
        $sql = "SELECT * FROM images_cats WHERE cat_id = :cat_id;";
        $params = array(':cat_id' => $cat['id']);
        $check = exec_sql_query($db, $sql, $params)->fetchAll();

        if (empty($check)) {
          $sql = "DELETE FROM categories WHERE id = :id;";
          $params = array(':id' => $cat['id']);
          $result = exec_sql_query($db, $sql, $params);
        }
      }

      // delete file
      unlink('uploads/images/' . $image_id . '.' . $image_ext);
      header("Location: index.php?image_deleted=true");
      exit;
    }
  }

  // remove image file
} elseif (isset($_POST['delete_image'])) { // ask for confirmation if delete image form submitted
  $display_image = false;
  $display_confirmation = true;
} else {
  if (isset($_POST['cancel_delete'])) {
    record_message("Image deletion was cancelled.");
  }

  // remove cats if remove cat form submitted
  if (isset($_POST['submit_remove_cat'])) {
    if (isset($_POST['cat_to_remove'])) {
      $cat_to_remove = filter_input(INPUT_POST, 'cat_to_remove', FILTER_SANITIZE_STRING);

      // first check if the cat and cat-image relationship are actually in the database
      $sql = "SELECT categories.name, categories.id FROM categories INNER JOIN images_cats ON images_cats.cat_id = cats.id WHERE categories.name = :name;";
      $params = array(':name' => $cat_to_remove);
      $records_cat = exec_sql_query($db, $sql, $params)->fetchAll();

      // if so, remove cat-image relationship
      if (empty($records_cat)) {
        record_message("Category has already been deleted.");
      } else {
        $sql = "DELETE FROM images_cats WHERE image_id = :image_id AND cat_id = :cat_id;";
        $params = array(':image_id' => $records[0]['id'], ':cat_id' => $records_cat[0]['id']);
        $result = exec_sql_query($db, $sql, $params);

        if (empty($result)) {
          record_message("Error removing category.");
        } else {
          // check if there are any other instances of this cat. if not, remove the cat entirely
          $sql = "SELECT * FROM images_cats WHERE cat_id = :cat_id;";
          $params = array(':cat_id' => $records_cat[0]['id']);
          $check = exec_sql_query($db, $sql, $params)->fetchAll();

          if (empty($check)) {
            $sql = "DELETE FROM categories WHERE id = :id;";
            $params = array(':id' => $records_cat[0]['id']);
            $result = exec_sql_query($db, $sql, $params);

            if (empty($result)) {
              record_message("Error removing category.");
            } else {
              record_message("Category successfully removed.");
            }
          } else {
            record_message("Category successfully removed.");
          }
        }
      }
    } else {
      record_message("Error removing category.");
    }
  }

  // add cats if add cat form submitted
  if (isset($_POST['submit_add_cat'])) {
    if (empty($_POST['cats_to_add'])) {
      record_message("No categories to add.");
    } elseif (empty(trim($_POST['cats_to_add']))) {
      record_message("No categories to add.");
    } else {
      // parse cats
      $cats = explode(",", $_POST['cats_to_add']);
      $add_failed = false;
      foreach ($cats as $cat) { // filter each cat
        $cat = strtolower(trim(filter_var($cat, FILTER_SANITIZE_STRING)));

        if (!empty($cat)) { // make sure the cat is not an empty string
          // check if this cat already exists, if not, add it to cats table
          $sql = "SELECT * FROM categories WHERE name = :name;";
          $params = array(':name' => $cat);
          $records_cat = exec_sql_query($db, $sql, $params)->fetchAll();

          // check if any results returned
          if ($records_cat) {
            $cat_id = $records_cat[0]['id'];
          } else { // no results so add cat to table
            $sql = "INSERT INTO categories (name) VALUES (:name);";
            $params = array(':name' => $cat);
            $result = exec_sql_query($db, $sql, $params);
            if (is_null($result)) {
              $add_failed = true;
            }
            $cat_id = $db->lastInsertId("id");
          }

          // check if image-cat relationship already exists
          $sql = "SELECT * FROM images_cats WHERE image_id = :image_id AND cat_id = :cat_id;";
          $params = array(':image_id' => $image_id, ':cat_id' => $cat_id);
          $records_cat = exec_sql_query($db, $sql, $params)->fetchAll();

          // add image-cat relationship to database
          if (empty($records_cat)) {
            $sql = "INSERT INTO images_cats (image_id, cat_id) VALUES (:image_id, :cat_id);";
            $params = array(':image_id' => $image_id, ':cat_id' => $cat_id);
            $result = exec_sql_query($db, $sql, $params);
            if (is_null($result)) {
              $add_failed = true;
            }
          }
        }
      }
      if ($add_failed) {
        record_message("An error occurred while adding your categorie(s).");
      } else {
        record_message("Categories added successfully.");
      }
    }
  }

  $image = $records[0];
  $id = $image['id'];
  $uploader = $image['uploader'];
  $title = $image['title'];
  $caption = $image['caption'];
  $file_ext = $image['file_ext'];

  // get cats
  $sql = "SELECT categories.name FROM categories INNER JOIN images_cats ON images_cats.cat_id = cats.id WHERE images_cats.image_id = :image_id;";
  $params = array(':image_id' => $id);
  $records = exec_sql_query($db, $sql, $params)->fetchAll();
  $display_cats = true;
  if (empty($records)) {
    $display_cats = false;
  }
}

?>

<!DOCTYPE html>
<html>

  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link rel="stylesheet" type="text/css" href="styles/all.css" media="all" />

    <title>Image View</title>
  </head>

  <body>
    <?php include("includes/header.php"); ?>

    <section class = "content single-view">
      <?php
      if (isset($sign_records) and !empty($sign_records)) {
        single_view($sign_records);?>

        <!--DELETE IMAGE FORM if logged in-->
        <!--NOT IMPLEMENTED YET-->
        <?php if ($current_user) { ?>
        <form action="" method="post">
          <button name="delete_image" value="foo" type="submit">Delete Image</button>
        </form>
        <?php } ?>

      <?php
      }
      else {
        array_push($messages, "Not a valid image view.");
      }
      ?>
    </section>

    <?php include("includes/footer.php"); ?>
  </body>
</html>
