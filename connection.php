<?php
$username = "root";
$password = "liceo123";
$conn = new mysqli("localhost", $username, $password, "courses_calendar");
$conn->set_charset("utf8mb4");
if ($conn->connect_error) {
  die("Connection failed: {$conn->connect_error}");
}