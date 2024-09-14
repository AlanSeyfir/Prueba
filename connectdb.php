<?php

$servername = "localhost:3307";
$username = "root";
$password = "";
$dbname = "users_biosina";
$conn = "";

$conn = mysqli_connect($servername, $username, $password, $dbname);

try {
  $conn = mysqli_connect($servername, $username, $password, $dbname);
} catch (mysqli_sql_exception) {
  echo "NO se conecto";
}

if ($conn) {
  echo "CONECTADO";
}

?>