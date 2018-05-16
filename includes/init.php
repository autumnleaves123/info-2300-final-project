<?php

$current_page = null;

/* ===============
   		MESSAGES
   =============== */

$messages = array(); //inspired by lecture demo code

// inspired by lecture demo code
// Record a message to display to the user.
function record_message($message) {
  global $messages;
  $messages[] = $message;
}

// inspired by lecture demo code
// Write out any messages to the user.
function print_messages() {
  global $messages;
  foreach ($messages as $message) {
    echo "<p class=\"message\">" . htmlspecialchars($message) . "</p>\n";
  }
}


/* ===============
   		DATABASE
   =============== */

function exec_sql_query($db, $sql, $params = array()) {
  $query = $db->prepare($sql);
  if ($query and $query->execute($params)) {
    return $query;
  }
  return NULL;
}

// show database errors during development.
function handle_db_error($exception) {
  echo '<p><strong>' . htmlspecialchars('Exception : ' . $exception->getMessage()) . '</strong></p>';
}

// YOU MAY COPY & PASTE THIS FUNCTION WITHOUT ATTRIBUTION.
// open connection to database
function open_or_init_sqlite_db($db_filename, $init_sql_filename) {
  if (!file_exists($db_filename)) {
    $db = new PDO('sqlite:' . $db_filename);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $db_init_sql = file_get_contents($init_sql_filename);
    if ($db_init_sql) {
      try {
        $result = $db->exec($db_init_sql);
        if ($result) {
          return $db;
        }
      } catch (PDOException $exception) {
        // If we had an error, then the DB did not initialize properly, so let's delete it!
        unlink($db_filename);
        throw $exception;
      }
    }
  } else {
    $db = new PDO('sqlite:' . $db_filename);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $db;
  }
  return NULL;
}

// open connection to database
$db = open_or_init_sqlite_db("website.sqlite", "init/init.sql");


/* ===============
   	LOG IN/LOGOUT
   =============== */

function check_login() {
  global $db;

  if (isset($_SESSION['current_user'])) {
    return $_SESSION['current_user'];
  }
  return NULL;
}

// do we still need this function?
function user_id() {
  global $db;
  global $current_user;

  $sql = "SELECT id FROM users WHERE username = '$current_user'";
  $params = array();
  $records = exec_sql_query($db, $sql, $params)->fetchAll();

  if ($records) {
    $account = $records[0];
    return $account['id'];
  }
}

// based off lecture 15 & 19
function log_in($username, $password) {
  global $db;

  if ($username && $password) {
    // check to see if username exists
    $sql = "SELECT * FROM users WHERE username = :username;";
    $params = array(
      ':username' => $username
    );
    $records = exec_sql_query($db, $sql, $params)->fetchAll();

    if ($records) {
      // Username is UNIQUE, so there should only be 1 record.
      $account = $records[0];

      // check to make sure hashed password is right
      if (password_verify($password, $account['password'])) {

        // Generate session
        $_SESSION['current_user'] = $username;

				header("Location: admin.php");
        return $username;

      } else {
        record_message("Invalid username or password.");
      }
    } else {
      record_message("Invalid username or password.");
    }
  } else {
    record_message("No username or password given.");
  }
  return NULL;
}

// based off lecture 15 & 19
function log_out() {
  global $current_user;
  global $db;

  $current_user = NULL;
  unset($_SESSION['current_user']);
  session_destroy();
  record_message("log out successful.");
}

/* ==============================
   		LEARNING SIGNS GALLERY
   ============================== */

function gallery($images){
  $image_count = 1;
  $number_of_images = count($images);
  $number_of_columns = 3;
  $images_in_column = 5;

  $current_word = '';

  echo "<div class='column'>";
  foreach($images as $image) {

    if ($current_word != $image['word']) {
      if ($image['id'] != 1) {
        echo "<div class=\"overlay-sign\">" . $current_word . "</div></div>";
        if ($image['id'] ==  15 || $image['id'] == 25) {
          echo "</div><div class='column'>";
        }
      }
      echo "<div class=\"word\">";
      $current_word = $image['word'];
    }

    echo "<img alt=\"" . $image["image_path"] . "\" src='". $image["image_path"] . "' />";
    if ($image['id'] == 37) {
      echo "<div class=\"overlay-sign\">" . $image['word'] . "</div></div>";
    }
  }
  echo "</div>";
}

function single_view($sign_records){
  echo "<img src='". $sign_records[0]["image_path"] . "' >";
  echo "<p><strong>Word: </strong>" . htmlspecialchars($sign_records[0]["word"]) . "</p>";
  echo "<p><strong>Description: </strong>" . $sign_records[0]["description"] . "</p>";

}

function sign_exists($id) {
  global $db;

  $sql = "SELECT * FROM signs WHERE signs.id = :id;";
  $params = array(":id"=>$id);
  $records = exec_sql_query($db, $sql, $params)->FetchAll();

  return !empty($records); // if $records is not empty, image exists
}

/* ===============
   		ADMIN
   =============== */
const MAX_FILE_SIZE = 2000000;

/* ===============
   		EXECUTE
   =============== */

session_start();

// LOGIN
// Check if we should login the user
if (isset($_POST['login-form-button'])) {
  $username = trim(filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING));
  $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

  $current_user = log_in($username, $password);

} else {

	$current_user = check_login();
}

$current_user = check_login();


// LOGOUT
if (isset($_POST['logout-button'])) {
  log_out();
	// TODO: create a logged out page?
  header("Location: login.php");
}

?>
