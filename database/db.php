<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gimnaspoo";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
} else {
?>
  <script>
    console.log("Connected successfully");
  </script>
<?php
}

?>