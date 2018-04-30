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
  array_push($messages, $message);
}

// inspired by lecture demo code
// Write out any messages to the user.
function print_messages() {
  global $messages;
  foreach ($messages as $message) {
    echo "<p><em>" . htmlspecialchars($message) . "</em></p>\n";
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

  if (isset($SESSION['current_user'])) {
    return $current_user;
  }
  return NULL;
}

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

/* ===============
   		EXECUTE
   =============== */


// check if logged in
$current_user = check_login();

?>
