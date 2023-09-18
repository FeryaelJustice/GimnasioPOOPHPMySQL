<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gimnaspoo";

$conn = new mysqli($servername, $username, $password);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
} else {
  // Make my_db the current database
  try {
    mysqli_select_db($conn, $dbname);
  } catch (Exception $e) {
    // If we couldn't, then it either doesn't exist, or we can't see it.
    $createdb_sql = 'CREATE DATABASE ' . $dbname;

    if (mysqli_query($conn, $createdb_sql)) {
      // Execute sql file
      $query = file_get_contents(dirname(__DIR__) . '/database/gimnas.sql');

      // execute the SQL
      if (mysqli_multi_query($conn, $query)) {
        echo "Success";
      } else {
        echo "Fail";
      }
    } else {
      echo 'Error creating database: ' . mysqli_error($conn) . "\n";
    }
  }
?>
  <script>
    console.log("Connected successfully");
  </script>
<?php
}

?>