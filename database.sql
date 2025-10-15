DROP DATABASE courses_calendar;

CREATE DATABASE courses_calendar;

USE courses_calendar;

CREATE TABLE courses (
  id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  course_name varchar(255) NOT NULL,
  instructor_name varchar(255) NOT NULL,
  start_date date NOT NULL,
  end_date date NOT NULL,
  start_time time NOT NULL,
  end_time time NOT NULL,
  created_at timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO courses (course_name, instructor_name, start_date, end_date, start_time, end_time) VALUES
  ('Artificial Intelligence Bootcamp', 'Alex', '2025-10-19', '2025-10-28', '07:00:00', '10:00:00'),
  ('Data Science Workshop', 'Maria', '2025-11-01', '2025-11-10', '09:00:00', '12:00:00'),
  ('Web Development Course', 'John', '2025-11-15', '2025-11-25', '13:00:00', '16:00:00'),
  ('Cybersecurity Seminar', 'Linda', '2025-12-01', '2025-12-05', '10:00:00', '12:00:00'),
  ('Cloud Computing Training', 'Michael', '2025-12-10', '2025-12-20', '14:00:00', '17:00:00');