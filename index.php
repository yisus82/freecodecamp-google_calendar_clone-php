<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A courses calendar application">
    <title>Calendar</title>
  </head>

  <body>
    <header>
      <h1>📅 Courses Calendar 📅</h1>

      <!-- ⏰ Clock -->
      <div class="clock-container">
        <div id="clock">
        </div>
      </div>

      <!-- 📅 Calendar -->
      <div class="calendar">
        <div class="nav-button-container">
          <button type="button" class="nav-button">⏮️</button>
          <h2 id="monthYear"></h2>
          <button type="button" class="nav-button">⏭️</button>
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
    </header>
  </body>

</html>