-- 1) Courses
CREATE TABLE IF NOT EXISTS courses (
  id INT AUTO_INCREMENT PRIMARY KEY,
  course_name VARCHAR(100) NOT NULL UNIQUE
);

-- 2) Users
CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  role ENUM('student','admin') NOT NULL,
  course_id INT NULL,
  year_level INT NULL,
  CONSTRAINT fk_user_course FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE SET NULL
);

-- 3) Attendance
CREATE TABLE IF NOT EXISTS attendance (
  id INT AUTO_INCREMENT PRIMARY KEY,
  student_id INT NOT NULL,
  attended_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  status ENUM('Present','Late') NOT NULL,
  is_late TINYINT(1) NOT NULL DEFAULT 0,
  CONSTRAINT fk_attendance_user FOREIGN KEY (student_id) REFERENCES users(id) ON DELETE CASCADE,
  INDEX (student_id),
  INDEX (attended_at)
);
