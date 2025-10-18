<?php
include 'calendar.php';
?>

<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A courses calendar application">
    <title>📅 Courses Calendar 📅</title>
    <link rel="icon"
      href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>📅</text></svg>">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
  </head>

  <body>
    <header>
      <h1><a href="<?= $_SERVER['PHP_SELF'] ?>">📅 Courses Calendar 📅</a></h1>
    </header>

    <!-- ✅ Success / ❌ Error Messages -->
    <?php if ($successMessage): ?>
      <div class="alert success">
        <?= $successMessage ?>
        <button class="close-btn" onclick="this.parentElement.style.display='none';">✖️</button>
      </div>
    <?php elseif ($errorMessage): ?>
      <div class="alert error">
        <?= $errorMessage ?>
        <button class="close-btn" onclick="this.parentElement.style.display='none';">✖️</button>
      </div>
    <?php endif; ?>

    <!-- ⏰ Clock -->
    <div class="clock-container">
      <div id="clock">
      </div>
    </div>

    <!-- 📅 Calendar -->
    <div class="calendar">
      <div class="nav-btn-container">
        <button type="button" class="nav-btn" id="previousMonthButton">⏮️</button>
        <h2 id="monthYear"></h2>
        <button type="button" class="nav-btn" id="nextMonthButton">⏭️</button>
      </div>
      <div class="calendar-grid" id="calendar"></div>
    </div>

    <!-- 📌 Modal -->
    <div class="modal" id="courseModal">
      <div class="modal-content">

        <!-- Dropdown Selector -->
        <div id="courseSelectorWrapper">
          <label for="courseSelector"><strong>Select Course:</strong></label>
          <select id="courseSelector"></select>
        </div>

        <!-- 📝 Form -->
        <form method="POST" id="courseForm">
          <input type="hidden" name="action" id="formAction" value="add">
          <input type="hidden" name="course_id" id="courseId">

          <label for="courseName">Course Title:</label>
          <input type="text" name="course_name" id="courseName" required>

          <label for="instructorName">Instructor Name:</label>
          <input type="text" name="instructor_name" id="instructorName" required>

          <label for="startDate">Start Date:</label>
          <input type="date" name="start_date" id="startDate" required>

          <label for="endDate">End Date:</label>
          <input type="date" name="end_date" id="endDate" required>

          <label for="startTime">Start Time:</label>
          <input type="time" name="start_time" id="startTime" required>

          <label for="endTime">End Time:</label>
          <input type="time" name="end_time" id="endTime" required>

          <button type="submit" class="submit-btn">💾 Save</button>
        </form>

        <!-- 🗑️ Delete -->
        <button type="button" class="delete-btn" id="deleteButton">🗑️ Delete</button>

        <!-- ❌ Cancel -->
        <button type="button" class="cancel-btn" id="cancelButton">❌ Cancel</button>
      </div>
    </div>

    <!-- Confirm delete course -->
    <div class="modal" id="deleteModal">
      <div class="modal-content">
        <p>Are you sure you want to delete this course?</p>
        <form method="POST" id="deleteForm">
          <input type="hidden" name="action" value="delete">
          <input type="hidden" name="course_id" id="deleteCourseId">
          <div class="button-container">
            <button type="button" class="cancel-btn" id="cancelDeleteButton">Cancel</button>
            <button type="submit" class="delete-btn">Delete</button>
          </div>
        </form>
      </div>
    </div>

    <!-- Pass PHP courses data to JavaScript -->
    <script>
      const courses = <?= json_encode($courses, JSON_UNESCAPED_UNICODE); ?>;
    </script>

    <!-- Calendar JavaScript logic -->
    <script src="calendar.js"></script>
  </body>

</html>