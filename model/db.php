<?php

$db_options = array(
    PDO::ATTR_EMULATE_PREPARES => false                     // important! use actual prepared statements (default: emulate prepared statements)
, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION           // throw exceptions on errors (default: stay silent)
, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC      // fetch associative arrays (default: mixed arrays)
);

$conn = new PDO('mysql:host=127.0.0.1;dbname=todo;charset=utf8', 'root', '', $db_options);    // important! specify the character encoding in the DSN string, don't use SET NAMES

function open($sess_path, $sess_name){
  GLOBAL $db_options;
  // echo '<p>session open fired</p>';
  $conn = new PDO('mysql:host=127.0.0.1;dbname=todo;charset=utf8', 'root', '', $db_options);    // important! specify the character encoding in the DSN string, don't use SET NAMES
$sessionId =  session_id();
  $sql = "INSERT INTO session SET session_id =" . $conn->quote($sessionId) . ", session_data = '' ON DUPLICATE KEY UPDATE session_lastaccesstime = NOW()";
  $conn->query($sql);
}


function read($sessionId){
  GLOBAL $db_options;
  // echo '<p>session read fired</p>';
  $conn = new PDO('mysql:host=127.0.0.1;dbname=todo;charset=utf8', 'root', '', $db_options);    // important! specify the character encoding in the DSN string, don't use SET NAMES

  $sql = "SELECT session_data FROM session where session_id =" . $conn->quote($sessionId);
     $result = $conn->query($sql);
     $data = $result->fetchColumn();
     $result->closeCursor();

     return $data;

}


function write($sessionId, $data){
  GLOBAL $db_options;
  // echo '<p>session write fired</p>';
  $conn = new PDO('mysql:host=127.0.0.1;dbname=todo;charset=utf8', 'root', '', $db_options);    // important! specify the character encoding in the DSN string, don't use SET NAMES

  $sql = "INSERT INTO session SET session_id =" . $conn->quote($sessionId) . ", session_data =" . $conn->quote($data) . " ON DUPLICATE KEY UPDATE session_data =" . $conn->quote($data);
  $conn->query($sql);

}


function close() {
  GLOBAL $db_options;
  // echo '<p>session close fired</p>';
    $sessionId = session_id();
    //perform some action here
}


function destroy($sessionId) {
  GLOBAL $db_options;
  $conn = new PDO('mysql:host=127.0.0.1;dbname=todo;charset=utf8', 'root', '', $db_options);    // important! specify the character encoding in the DSN string, don't use SET NAMES

    $sql = "DELETE FROM session WHERE session_id =" . $conn->quote($sessionId);
    $conn->query($sql);

    setcookie(session_name(), "", time() - 9999);
}


function gc($lifetime) {
  GLOBAL $db_options;
  $conn = new PDO('mysql:host=127.0.0.1;dbname=todo;charset=utf8', 'root', '', $db_options);    // important! specify the character encoding in the DSN string, don't use SET NAMES

  $sql = "DELETE FROM session WHERE session_lastaccesstime < DATE_SUB(NOW(), INTERVAL " . $lifetime . " SECOND)";
  $conn->query($sql);
}






session_set_save_handler("open", "close", "read", "write", "destroy", "gc");


?>
