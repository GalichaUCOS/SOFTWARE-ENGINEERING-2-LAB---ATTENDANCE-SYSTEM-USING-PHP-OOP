<?php
require_once __DIR__ . "/classes/User.php";
User::requireLogin();
$user = $_SESSION['user'];
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Dashboard</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container">
    <a class="navbar-brand" href="#">Attendance</a>
    <div class="d-flex">
      <span class="me-3">Hello, <?= htmlspecialchars($user['name']) ?> (<?= htmlspecialchars($user['role']) ?>)</span>
      <a class="btn btn-outline-dark btn-sm" href="logout.php">Logout</a>
    </div>
  </div>
</nav>

<div class="container py-4">
  <?php if ($user['role'] === 'student'): ?>
    <div class="vstack gap-3">
      <a href="mark_attendance.php" class="btn btn-primary">File / Mark Attendance</a>
      <a href="history.php" class="btn btn-outline-secondary">View Attendance History</a>
    </div>
  <?php else: ?>
    <div class="vstack gap-3">
      <a href="add_course.php" class="btn btn-primary">Add / Edit Courses</a>
      <a href="view_attendance.php" class="btn btn-outline-secondary">Check Attendance by Program & Year</a>
    </div>
  <?php endif; ?>
</div>
</body>
</html>
