<?php
include 'connection.php';

$SUCCESS_MESSAGES = [
  1 => 'Course added successfully.',
  2 => 'Course edited successfully.',
  3 => 'Course deleted successfully.',
];

$ERROR_MESSAGES = [
  1 => 'All fields are required.',
  2 => 'End date/time must be after start date/time.',
  3 => 'Database error. Please try again later.',
  4 => 'Invalid course ID.',
];

// Set success message
$successMessage = '';
if (isset($_GET['success']) && array_key_exists(intval($_GET['success']), $SUCCESS_MESSAGES)) {
  $successMessage = $SUCCESS_MESSAGES[intval($_GET['success'])];
}

// Set error message
$errorMessage = '';
if (isset($_GET['error']) && array_key_exists(intval($_GET['error']), $ERROR_MESSAGES)) {
  $errorMessage = $ERROR_MESSAGES[intval($_GET['error'])];
}

// Handle adding a new course
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'add') {
  $courseName = trim($_POST['course_name'] ?? '');
  $instructorName = trim($_POST['instructor_name'] ?? '');
  $startDate = $_POST['start_date'] ?? '';
  $endDate = $_POST['end_date'] ?? '';
  $startTime = $_POST['start_time'] ?? '';
  $endTime = $_POST['end_time'] ?? '';

  // Validate input
  if (empty($courseName) || empty($instructorName) || empty($startDate) || empty($endDate) || empty($startTime) || empty($endTime)) {
    // Redirect with error code
    header("Location: {$_SERVER['PHP_SELF']}?error=1");
    exit();
  } elseif ($startDate > $endDate || ($startDate === $endDate && $startTime >= $endTime)) {
    // Redirect with error code
    header("Location: {$_SERVER['PHP_SELF']}?error=2");
    exit();
  } else {
    // Prepare and bind
    $stmt = $conn->prepare('INSERT INTO courses (course_name, instructor_name, start_date, end_date, start_time, end_time) VALUES (?, ?, ?, ?, ?, ?)');
    $stmt->bind_param('ssssss', $courseName, $instructorName, $startDate, $endDate, $startTime, $endTime);

    // Execute the statement
    if ($stmt->execute()) {
      // Close the statement
      $stmt->close();

      // Refresh the page to show the new course
      header("Location: {$_SERVER['PHP_SELF']}?success=1");
      exit();
    } else {
      // Close the statement
      $stmt->close();

      // Redirect with generic error
      header("Location: {$_SERVER['PHP_SELF']}?error=3");
      exit();
    }
  }
}

// Handle editing an existing course
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'edit') {
  $courseId = intval($_POST['course_id'] ?? 0);
  $courseName = trim($_POST['course_name'] ?? '');
  $instructorName = trim($_POST['instructor_name'] ?? '');
  $startDate = $_POST['start_date'] ?? '';
  $endDate = $_POST['end_date'] ?? '';
  $startTime = $_POST['start_time'] ?? '';
  $endTime = $_POST['end_time'] ?? '';

  // Validate input
  if ($courseId <= 0 || empty($courseName) || empty($instructorName) || empty($startDate) || empty($endDate) || empty($startTime) || empty($endTime)) {
    // Redirect with error code
    header("Location: {$_SERVER['PHP_SELF']}?error=1");
    exit();
  } elseif ($startDate > $endDate || ($startDate === $endDate && $startTime >= $endTime)) {
    // Redirect with error code
    header("Location: {$_SERVER['PHP_SELF']}?error=2");
    exit();
  } else {
    // Prepare and bind
    $stmt = $conn->prepare('UPDATE courses SET course_name=?, instructor_name=?, start_date=?, end_date=?, start_time=?, end_time=? WHERE id=?');
    $stmt->bind_param('ssssssi', $courseName, $instructorName, $startDate, $endDate, $startTime, $endTime, $courseId);

    // Execute the statement
    if ($stmt->execute()) {
      // Close the statement
      $stmt->close();

      // Refresh the page to show the new course
      header("Location: {$_SERVER['PHP_SELF']}?success=1");
      exit();
    } else {
      // Close the statement
      $stmt->close();

      // Redirect with generic error
      header("Location: {$_SERVER['PHP_SELF']}?error=3");
      exit();
    }
  }
}

// Handle deleting a course
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'delete') {
  $courseId = intval($_POST['course_id'] ?? 0);

  if ($courseId <= 0) {
    // Redirect with generic error
    header("Location: {$_SERVER['PHP_SELF']}?error=4");
    exit();
  } else {
    // Prepare and bind
    $stmt = $conn->prepare('DELETE FROM courses WHERE id=?');
    $stmt->bind_param('i', $courseId);

    // Execute the statement
    if ($stmt->execute()) {
      // Close the statement
      $stmt->close();

      // Refresh the page to show the new course
      header("Location: {$_SERVER['PHP_SELF']}?success=1");
      exit();
    } else {
      // Close the statement
      $stmt->close();

      // Redirect with generic error
      header("Location: {$_SERVER['PHP_SELF']}?error=3");
      exit();
    }
  }
}

// Fetch all courses and spread by date
$courses = [];
$result = $conn->query('SELECT * FROM courses');
if ($result && $result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $start = new DateTime($row['start_date']);
    $end = new DateTime($row['end_date']);

    while ($start <= $end) {
      $courses[] = [
        'id' => $row['id'],
        'title' => "{$row['course_name']} - {$row['instructor_name']}",
        'formatted_date' => $start->format('Y-m-d'),
        'start_date' => $row['start_date'],
        'end_date' => $row['end_date'],
        'start_time' => $row['start_time'],
        'end_time' => $row['end_time'],
      ];
      $start->modify('+1 day');
    }
  }
}

// Close the connection
$conn->close();