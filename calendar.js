const calendarElement = document.getElementById('calendar');
const monthYearElement = document.getElementById('monthYear');
const courseModalElement = document.getElementById('courseModal');
const formActionElement = document.getElementById('formAction');
const courseIdElement = document.getElementById('courseId');
const deleteCourseIdElement = document.getElementById('deleteCourseId');
const courseNameElement = document.getElementById('courseName');
const instructorNameElement = document.getElementById('instructorName');
const startDateElement = document.getElementById('startDate');
const endDateElement = document.getElementById('endDate');
const startTimeElement = document.getElementById('startTime');
const endTimeElement = document.getElementById('endTime');
const courseSelectorElement = document.getElementById('courseSelector');
const courseSelectorWrapperElement = document.getElementById('courseSelectorWrapper');
const clockElement = document.getElementById('clock');
const previousMonthButtonElement = document.getElementById('previousMonthButton');
const nextMonthButtonElement = document.getElementById('nextMonthButton');
const cancelButtonElement = document.getElementById('cancelButton');
const deleteButtonElement = document.getElementById('deleteButton');
const deleteModalElement = document.getElementById('deleteModal');
const deleteFormElement = document.getElementById('deleteForm');
const cancelDeleteButtonElement = document.getElementById('cancelDeleteButton');
let calendarDate = new Date();

const renderCalendar = date => {
  calendarElement.innerHTML = '';

  const year = date.getFullYear();
  const month = date.getMonth();
  const today = new Date();

  const totalDays = new Date(year, month + 1, 0).getDate();
  const firstDayOfMonth = new Date(year, month, 1).getDay();

  monthYearElement.textContent = date.toLocaleDateString('en-US', {
    month: 'long',
    year: 'numeric',
  });

  const weekDays = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
  weekDays.forEach(day => {
    const dayElement = document.createElement('div');
    dayElement.className = 'day-name';
    dayElement.textContent = day;
    calendarElement.appendChild(dayElement);
  });

  for (let i = 0; i < firstDayOfMonth; i++) {
    calendarElement.appendChild(document.createElement('div'));
  }

  for (let day = 1; day <= totalDays; day++) {
    const dateString = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;

    const cellElement = document.createElement('div');
    cellElement.className = 'day';

    if (day === today.getDate() && month === today.getMonth() && year === today.getFullYear()) {
      cellElement.classList.add('today');
    }

    const dateElement = document.createElement('div');
    dateElement.className = 'date-number';
    dateElement.textContent = day;
    cellElement.appendChild(dateElement);

    const coursesElement = document.createElement('div');
    coursesElement.className = 'courses';

    const coursesToday = courses.filter(course => course.formatted_date === dateString);
    coursesToday.forEach(course => {
      const courseElement = document.createElement('div');
      courseElement.className = 'course';

      const courseNameElement = document.createElement('div');
      courseNameElement.className = 'course-name';
      courseNameElement.textContent = course.title.split(' - ')[0];

      const instructorElement = document.createElement('div');
      instructorElement.className = 'instructor';
      instructorElement.textContent = `🧑🏻‍🏫 ${course.title.split(' - ')[1]}`;

      const timeElement = document.createElement('div');
      timeElement.className = 'time';
      timeElement.textContent = `⏰ ${course.start_time} - ${course.end_time}`;

      courseElement.appendChild(courseNameElement);
      courseElement.appendChild(instructorElement);
      courseElement.appendChild(timeElement);
      coursesElement.appendChild(courseElement);
    });

    const overlayElement = document.createElement('div');
    overlayElement.className = 'day-overlay';

    const addElement = document.createElement('button');
    addElement.className = 'overlay-btn';
    addElement.textContent = '➕ Add';
    addElement.onclick = e => {
      e.stopPropagation();
      openModalForAdd(dateString);
    };
    overlayElement.appendChild(addElement);

    if (coursesToday.length > 0) {
      const editElement = document.createElement('button');
      editElement.className = 'overlay-btn';
      editElement.textContent = '📝 Edit';
      editElement.onclick = event => {
        event.stopPropagation();
        openModalForEdit(coursesToday);
      };
      overlayElement.appendChild(editElement);
    }

    cellElement.appendChild(overlayElement);
    cellElement.appendChild(coursesElement);
    calendarElement.appendChild(cellElement);
  }
};

const openModalForAdd = dateString => {
  formActionElement.value = 'add';
  courseIdElement.value = '';
  deleteCourseIdElement.value = '';
  courseNameElement.value = '';
  instructorNameElement.value = '';
  startDateElement.value = dateString;
  endDateElement.value = dateString;
  startTimeElement.value = '09:00';
  endTimeElement.value = '10:00';
  deleteButtonElement.style.display = 'none';

  if (courseSelectorElement && courseSelectorWrapperElement) {
    courseSelectorElement.innerHTML = '';
    courseSelectorWrapperElement.style.display = 'none';
  }

  courseModalElement.style.display = 'flex';
};

const openModalForEdit = coursesOnDate => {
  formActionElement.value = 'edit';
  courseModalElement.style.display = 'flex';
  courseSelectorElement.innerHTML = '';

  if (coursesOnDate.length > 1) {
    courseSelectorWrapperElement.style.display = 'block';
    courseSelectorElement.onchange = event => handleCourseSelection(event.target.value);
    coursesOnDate.forEach(course => {
      const optionElement = document.createElement('option');
      optionElement.value = JSON.stringify(course);
      optionElement.textContent = `${course.title} (${course.start_date} ➡️ ${course.end_date})`;
      courseSelectorElement.appendChild(optionElement);
    });
    courseSelectorElement.selectedIndex = 0;
  } else {
    courseSelectorWrapperElement.style.display = 'none';
  }

  handleCourseSelection(JSON.stringify(coursesOnDate[0]));
};

const handleCourseSelection = courseJSON => {
  const course = JSON.parse(courseJSON);

  courseIdElement.value = course.id;
  deleteCourseIdElement.value = course.id;

  const [courseName, instructor] = course.title.split(' - ').map(part => part.trim());

  courseNameElement.value = courseName || '';
  instructorNameElement.value = instructor || '';
  startDateElement.value = course.start_date || '';
  endDateElement.value = course.end_date || '';
  startTimeElement.value = course.start_time || '';
  endTimeElement.value = course.end_time || '';
};

const openDeleteModal = () => (deleteModalElement.style.display = 'flex');
deleteButtonElement.onclick = openDeleteModal;

const closeDeleteModal = () => (deleteModalElement.style.display = 'none');
cancelDeleteButtonElement.onclick = closeDeleteModal;

const closeModal = () => (courseModalElement.style.display = 'none');
cancelButtonElement.onclick = closeModal;

const changeMonth = offset => {
  calendarDate.setMonth(calendarDate.getMonth() + offset);
  renderCalendar(calendarDate);
};
previousMonthButtonElement.onclick = () => changeMonth(-1);
nextMonthButtonElement.onclick = () => changeMonth(1);

const updateClock = () => {
  const now = new Date();

  clockElement.textContent = [
    now.getHours().toString().padStart(2, '0'),
    now.getMinutes().toString().padStart(2, '0'),
    now.getSeconds().toString().padStart(2, '0'),
  ].join(':');
};

renderCalendar(calendarDate);
updateClock();
setInterval(updateClock, 1000);
