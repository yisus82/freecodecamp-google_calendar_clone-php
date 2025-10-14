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
      <h1>📅 Courses Calendar 📅</h1>
    </header>

    <!-- ⏰ Clock -->
    <div class="clock-container">
      <div id="clock">
      </div>
    </div>

    <!-- 📅 Calendar -->
    <div class="calendar">
      <div class="nav-btn-container">
        <button type="button" class="nav-btn">⏮️</button>
        <h2 id="monthYear"></h2>
        <button type="button" class="nav-btn">⏭️</button>
      </div>
      <div class="calendar-grid" id="calendar"></div>
    </div>

    <!-- 📌 Modal -->
    <div class="modal" id="eventModal">
      <div class="modal-content">

        <!-- Dropdown Selector -->
        <div id="eventSelectorWrapper">
          <label for="eventSelector"><strong>Select Event:</strong></label>
          <select id="eventSelector">
            <option disabled selected>Choose Event...</option>
          </select>
        </div>

        <!-- 📝 Form -->
        <form method="POST" id="eventForm">
          <input type="hidden" name="action" id="formAction" value="add">
          <input type="hidden" name="event_id" id="eventId">

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

          <button type="submit">💾 Save</button>
        </form>

        <!-- 🗑️ Delete -->
        <form method="POST">
          <input type="hidden" name="action" value="delete">
          <input type="hidden" name="event_id" id="deleteEventId">
          <button type="submit" class="submit-btn">🗑️ Delete</button>
        </form>

        <!-- ❌ Cancel -->
        <button type="button" class="submit-btn">❌ Cancel</button>
      </div>
    </div>
  </body>

</html>